<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProjectInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows("update", $this->route("project"));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => ["required", "email", Rule::exists("users", "email")]
        ];
    }

    /**
     * Get custom messages for valiator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "email.exists" =>  "The user you are inviting must have a Birdboard account."
        ];
    }
}
