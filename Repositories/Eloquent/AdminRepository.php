<?php

namespace Modules\Admin\Repositories\Eloquent;

use Modules\Admin\Repositories\Interfaces\AdminRepositoryInterface;
use Modules\Admin\Entities\Admin;

class AdminRepository implements AdminRepositoryInterface
{

    public function getModel()
    {
        return new Admin;
    }

    public function find($id)
    {
        return $this->getModel()->where('id', $id)->first();
    }

    public function getAll()
    {
        return $this->getModel()->all();
    }

    public function findById($id)
    {
        return $this->getModel()->whereId($id)->first();
    }

    public function create(array $data)
    {
        return $this->getModel()->create($data);
    }

    public function update($id, array $data)
    {
        return $this->find($id)->update($data);
    }
}
