<?php

namespace App\Http\Requests\Permission;

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
        $permission = $this->route('permission');
        $response = Gate::inspect(Ability::UPDATE, $permission);

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
        $permission = $this->route('permission');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission)],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
