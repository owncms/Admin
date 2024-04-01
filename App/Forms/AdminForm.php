<?php

namespace Modules\Admin\App\Forms;

use Modules\Core\App\src\FormBuilder\Form;
use Modules\Admin\App\Models\Role;

class AdminForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name')
            ->add('last_name')
            ->add('login')
            ->add('email', 'email')
            ->add('role_id', 'select',
                [
                    'choices' => Role::prepareRolesSelect(),
                    'label' => module_lang('form.role')
                ])
            ->add('password', 'repeated', [
                'type' => 'password',
                'second_name' => 'password_confirmation',
            ]);
    }
}
