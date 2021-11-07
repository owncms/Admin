<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    protected ?int $modelId = null;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'last_name' => 'max:255',
            'login' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $this->modelId,
            'role_id' => 'required',
            'password' => 'confirmed|min:6',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function setModelId($id)
    {
        $this->modelId = $id;
    }
}
