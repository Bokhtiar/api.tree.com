<?php

namespace App\Http\Requests;

use App\Traits\HttpResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegistrationRequest extends FormRequest
{
    use HttpResponseTrait;
    
    /** Determine if the user is authorized to make this request */
    public function authorize(): bool
    {
        return true;
    }

    /** Get the validation rules that apply to the request. */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'role' => 'required',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|unique:users,email',
        ];
    }

    /** response */
    protected function failedValidation(Validator $validator)
    {
        /* validation error message */
        if ($validator->errors()) {
            $errors = $validator->errors()->getMessages();
            $errors_formated = array();
            foreach ($errors as $value) {
                array_push($errors_formated, $value);
            }
        }

        throw new ValidationException(
            $validator,
            $this->HttpErrorResponse($errors_formated, 422)
        );
    }

}
