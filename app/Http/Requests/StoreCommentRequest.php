<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreCommentRequest extends FormRequest
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
            'content' => 'required|string|max:1000',
            'profile_id' => 'required|integer',
        ];
    }

    public function failedValidation(ValidationValidator $validator)
    {
        $response = app(Controller::class)->errorResponse(["errors" => $validator->errors()->all(), 'message' => 'Bad request'], 400);
        throw new ValidationException($validator, $response);
    }

    public function store(): JsonResponse
    {
        try {
            if (Comment::ofProfile($this->user()->id, $this->profile_id)->exists()) {
                return app(Controller::class)->errorResponse(['message' => 'Unauthorized', "errors" => ['You have already commented on this profile']], 401);
            }
            // Proceed to create the comment
            $comment = Comment::create($this->validated() + ['administrator_id' => $this->user()->id]);
            return app(Controller::class)->successResponse(['comment' => new CommentResource($comment), 'message' => 'created successfully !'], 201);
        } catch (\Exception $e) {
            return app(Controller::class)->errorResponse(["errors" => $e->getMessage(),'message' => 'Internal server error'], 500);
        }
    }
}
