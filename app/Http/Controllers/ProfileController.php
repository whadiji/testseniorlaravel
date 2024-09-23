<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
       /**
     * @OA\Get(
     *     path="/api/profiles",
     *     summary="Get all active profiles",
     *     description="Retrieve all profiles with 'active' status. This endpoint is public and does not require authentication.",
     *     operationId="getActiveProfiles",
     *     tags={"Profiles"},
     *     @OA\Response(
     *         response=200,
     *         description="List of active profiles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="image", type="string", example="/storage/images/profiles/profile1.jpg")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(['data' => ProfileResource::collection(Profile::active()->get())]);
    }

        /**
     * @OA\Get(
     *     path="/api/all-profiles",
     *     summary="Get all profiles",
     *     description="Retrieve all profiles including the 'status' field. This endpoint requires authentication.",
     *     operationId="getAllProfiles",
     *     tags={"Profiles"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="List of all profiles with status",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="image", type="string", example="/storage/images/profiles/profile1.jpg"),
     *                 @OA\Property(property="status", type="string", example="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token is required",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function indexAll(): JsonResponse
    {
        // Retrieve all profiles with the "status" field
        return $this->successResponse(['data' => ProfileResource::collection(Profile::all())]);
    }

       /**
     * @OA\Post(
     *     path="/api/profiles",
     *     summary="Create a new profile",
     *     description="Creates a new profile with an image, last name, first name, and status. Only accessible to authenticated administrators.",
     *     operationId="storeProfile",
     *     tags={"Profiles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"last_name", "first_name", "status", "image"},
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="The last name of the profile",
     *                     example="Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     description="The first name of the profile",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     enum={"inactive", "pending", "active"},
     *                     description="The status of the profile (Inactive, Pending, Active)",
     *                     example="active"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="The profile image file"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profile created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="status", type="string", example="active"),
     *             @OA\Property(property="image", type="string", example="path/to/image.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Missing or invalid parameters",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="message", type="string", example="Bad request."),
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Authentication required",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized."),
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Internal server error."),
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     )
     * )
     */

     public function store(ProfileRequest $request): JsonResponse
     {
         return $request->store();
     } 

}
