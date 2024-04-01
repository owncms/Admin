<?php

namespace Modules\Admin\App\Forms;

use Modules\Core\App\src\FormBuilder\Form;
use Modules\Admin\App\Models\Role;

class RoleForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name')
            ->add('title');
    }
}
