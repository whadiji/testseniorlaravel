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
}
