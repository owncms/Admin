<?php

namespace Modules\Admin\Http\Controllers\Backend;

use Modules\Admin\Http\Controllers\Controller as CoreController;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Http\Requests\AdminRequest;
use Modules\Admin\Forms\AdminForm;

class AdminController extends CoreController
{
    public function __construct()
    {
        $this->model = Admin::class;
        $this->form = AdminForm::class;
        $this->baseView = 'panel.admins';
        $this->baseRoute = 'admins';
        $this->request = AdminRequest::class;
        parent::__construct();
    }

}
