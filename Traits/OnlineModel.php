<?php

namespace Modules\Admin\Traits;

trait OnlineModel
{
    /**
     * @return array[]
     */
    public function getFilterListAttribute(): array
    {
        $columns = \Schema::getColumnListing($this->getTable());
        $data = [];
        if (in_array('deleted_at', $columns)) {
            $all = $this->withTrashed()->count();
        } else {
            $all = $this->count();
        }
        $data['all'] = [
            'count' => $all,
            'badge' => 'secondary',
            'param' => '*',
            'base' => true
        ];
        if (in_array('active', $columns)) {
            $active = $this->where('active', 1)->count();
            $inactive = $all - $active;
            $data['active'] = [
                'count' => $active,
                'badge' => 'success',
                'param' => 1,
            ];
            $data['inactive'] = [
                'count' => $inactive,
                'badge' => 'danger',
                'param' => 0,
            ];
        }
        if (in_array('deleted_at', $columns)) {
            $trashed = $this->onlyTrashed()->count();
            $data['trashed'] = [
                'count' => $trashed,
                'badge' => 'dark',
                'param' => 2,
            ];
        }
        return $data;
    }

    public function getSearchableColumnsAttribute(): array
    {
        return (property_exists($this, 'searchableColumns')) ? $this->searchableColumns : [];
    }
}
