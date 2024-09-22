<?php

namespace App\Http\Requests\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use \Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response=app(Controller::class)->errorResponse(["errors"=>$validator->errors()->all(),'message'=>'Bad request'],400);
        throw new ValidationException($validator, $response);
    }

    public function authenticate(): JsonResponse
    {
        if (auth()->attempt($this->validated())) {
            $user = auth()->user();
            if ($user) {
            
                $token = $user->createToken('AdminToken')->plainTextToken;
                return app(Controller::class)->successResponse(['message' => 'Login successful', 'token' => $token], 200);
            }
        }
        return app(Controller::class)->errorResponse('Invalid credentials', 401);
    }
}
