<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProfileRequestUpdate extends FormRequest
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
            'first_name' => 'required_if:action,update|string|max:255',
            'last_name' => 'required_if:action,update|string|max:255',
            'status' => 'required_if:action,update|in:active,inactive,pending',
            'image' => 'nullable|image|max:2048',
            'action' => 'required|in:update,delete',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = app(Controller::class)->errorResponse(["errors" => $validator->errors()->all(),'message' => 'Bad request'], 400);
        throw new ValidationException($validator, $response);
    }

    public function updateOrDelete(Profile $profile): JsonResponse
    {
        $action = $this->input('action');

        if ($action === 'delete') {
            return $this->deleteProfile($profile);
        }

        return $this->updateProfile($profile);
    }
    private function updateProfile(Profile $profile): JsonResponse
    {
        try {
            if ($this->hasFile('image')) {
                Storage::disk('public')->delete($profile->image);
                $profile->image = $this->file('image')->store('profiles', 'public');
            }

            $profile->update($this->except('image'));

            return app(Controller::class)->successResponse(['message' => 'Profile updated successfully', 'profile' => new ProfileResource($profile)], 200);
        } catch (\Exception $e) {
            return app(Controller::class)->errorResponse(["errors" => $e->getMessage(),'message' => 'Internal server error'], 500);
        }
    }

    private function deleteProfile(Profile $profile): JsonResponse
    {
        try {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }
            $profile->delete();

            return app(Controller::class)->successResponse(['message' => 'Profile deleted successfully'], 200);
        } catch (\Exception $e) {
            return app(Controller::class)->errorResponse(["errors" => $e->getMessage(),'message' => 'Internal server error'], 500);
        }
    }
}
