<?php

namespace App\Http\Requests\Role;

use App\Enums\Ability;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $role = $this->route('role');
        $response = Gate::inspect(Ability::UPDATE, $role);

        if ($response->allowed()) {
            return true;
        }

        throw new ModelNotFoundException;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $role = $this->route('role');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role)],
            'permissions' => ['required', 'array'],
        ];
    }
}
