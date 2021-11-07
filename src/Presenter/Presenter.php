<?php

namespace Modules\Admin\src\Presenter;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Presenter
{
    private array $filterList;

    public function __construct(
        private object $model,
        private array $searchableColumns
    )
    {
    }

    public function withFilters(): object
    {
        $filterList = $this->model->filter_list;
        if (!is_array($filterList)) {
            return $this;
        }
        $baseUrl = request()->url();
        $urls = [];
        foreach ($filterList as $filter => $data) {
            if (!isset($data['param'])) {
                $data['param'] = 1;
                $filterList[$filter] = $data;
            }
            if (isset($data['base'])) {
                $urls[$filter] = $baseUrl;
            } else {
                $urls[$filter] = $baseUrl . "?status=$filter," . $data['param'];
            }
        }
        $this->filterList = [
            'data' => $filterList,
            'urls' => $urls,
        ];
        return $this;
    }

    public function getFilterList(): array
    {
        return $this->filterList ?? [];
    }

    public function getData(): array
    {
        $search = '';
        $status = 1;
        $columns = $this->getSearchableColumns();
        if (request()->has('search') && request()->get('search')) {
            $search = strtolower(trim(request()->get('search')));
        }
        if (request()->has('status')) {
            $status = request()->get('status');
            if (str_contains($status, ',')) {
                $status = explode(',', $status);
                $status = $status[1];
            }
        }
        $model = $this->model;
        if (in_array('deleted_at', $columns)) {
            $model->withTrashed();
        }
        $items = $model->where(function ($q) use ($search, $columns) {
            if ($search && count($columns)) {
                if (count($columns) == 1) {
                    $q->whereRaw("lower({$columns[0]}) like (?)", ["%{$search}%"]);
                } else {
                    foreach ($columns as $key => $column) {
                        if ($key == 0) {
                            $q->whereRaw("lower({$column}) like (?)", ["%{$search}%"]);
                        } else {
                            $q->orWhereRaw("lower({$column}) like (?)", ["%{$search}%"]);
                        }
                    }
                }
            }
        })->where(function ($q) use ($status, $model, $columns) {
            if (in_array('active', $columns) && ($status == 0 || $status == 1)) {
                $q->where('active', $status);
            } elseif ($status == 2 && in_array('deleted_at', $columns)) {
                $q->onlyTrashed();
            }
        })->paginate();

        return [
            'items' => $items,
            'filter_list' => $this->getFilterList(),
            'request' => request()->all()
        ];
    }

    public function getSearchableColumns(): array
    {
        $searchableColumns = $this->model->searchableColumns;
        if (empty($searchableColumns)) {
            if (in_array('name', $this->model->getFillable())) {
                $searchableColumns[] = 'name';
            }
        }
        return $searchableColumns;
    }

    public function paginate($items, $perPage = 15, $page = null, $options = []): object
    {
        $perPage = $perPage ?: request('limit', config('presenter.limit', '15'));

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
