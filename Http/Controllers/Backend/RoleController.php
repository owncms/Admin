<?php

namespace Modules\Admin\Http\Controllers\Backend;

use Modules\Admin\Http\Controllers\Controller as CoreController;
use Modules\Admin\Entities\Role;
use Modules\Admin\Forms\RoleForm;
use Bouncer;
use Modules\Admin\src\Bouncer\AbilityManager;
use Modules\Admin\Http\Requests\RoleRequest;

class RoleController extends CoreController
{
    public function __construct()
    {
        $this->model = Role::class;
        $this->form = RoleForm::class;
        $this->baseView = 'panel.roles';
        $this->baseRoute = 'roles';
        $this->request = RoleRequest::class;
        parent::__construct();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(): object
    {
        if (!Bouncer::can('create', $this->model)) {
            return abort(403);
        }
        $form = $this->form($this->form, [
            'method' => 'POST',
            'route' => [implode('.', [$this->routeWithModulePrefix, 'store'])]
        ]);

        $entity = new $this->model;
        $modules = (new AbilityManager)->init($entity)->getModulesAbilities();
        return $this->view($this->baseView . '.create', compact(['form', 'entity', 'modules']));
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id): object
    {
        if (!Bouncer::can('show', $this->model)) {
            return abort(403);
        }
        $item = $this->model::findOrFail($id);
        $modules = (new AbilityManager)->init($item)->getModulesAbilities();;
        if (method_exists($item, 'attributesToUnset')) {
            $item->attributesToUnset();
        }
        $form = $this->form($this->form, [
            'method' => 'POST',
            'model' => $item
        ]);
        $form->disableFields();

        $entity = new $this->model;
        return $this->view($this->baseView . '.show', compact(['form', 'item', 'entity', 'modules']));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id): object
    {
        if (!Bouncer::can('edit', $this->model)) {
            return abort(403);
        }
        $item = $this->model::findOrFail($id);
        $modules = (new AbilityManager)->init($item)->getModulesAbilities();
        if (method_exists($item, 'attributesToUnset')) {
            $item->attributesToUnset();
        }
        $form = $this->form($this->form, [
            'method' => 'PUT',
            'route' => [$this->routeWithModulePrefix . '.update', $item->id],
            'model' => $item
        ]);

        $entity = new $this->model;
        return $this->view($this->baseView . '.edit', compact(['item', 'form', 'entity', 'modules']));
    }
}
