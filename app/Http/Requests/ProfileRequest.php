<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class ProfileRequest extends FormRequest
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
    public function rules()
    {
        return [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:inactive,pending,active',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response=app(Controller::class)->errorResponse(["errors"=>$validator->errors()->all(),'message'=>'Bad request'],400);
        throw new ValidationException($validator, $response);
    }

    public function store()
    {
        try {
            $validatedData = $this->except(['image']);
            $path = null;
            if ($this->hasFile('image')) {
                $path = $this->file('image')->store('images/profiles', 'public');
            }
            $profile = Profile::create($validatedData + ['image' => $path, 'administrator_id' => $this->user()->id]);
            return app(Controller::class)->successResponse(['profile' => new ProfileResource($profile), 'message' => 'created successfully !'], 201);
        } catch (\Exception $e) {
            return app(Controller::class)->errorResponse(['message' => 'Internal server error'], 500);
        }
    }
}
