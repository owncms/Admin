<?php

namespace Modules\Admin\App\Http\Controllers\Backend;

use Modules\Admin\App\Http\Controllers\Controller as CoreController;
use Modules\Admin\App\Models\Admin;
use Modules\Admin\App\Http\Requests\AdminRequest;
use Modules\Admin\App\Forms\AdminForm;

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
