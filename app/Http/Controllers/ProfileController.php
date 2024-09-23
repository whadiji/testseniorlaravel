<?php

namespace App\Http\Controllers;

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

}
