<?php

namespace Modules\Admin\Forms;

use Modules\Core\src\FormBuilder\Form;
use Modules\Admin\Entities\Role;

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
