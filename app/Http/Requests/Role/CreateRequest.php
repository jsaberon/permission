<?php

namespace App\Http\Requests\Role;

use App\Enums\Ability;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $response = Gate::inspect(Ability::CREATE, Role::class);

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
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['required', 'array'],
        ];
    }
}
