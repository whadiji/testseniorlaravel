<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Authenticate an admin and return a token",
     *     description="Logs in an admin user and returns an authentication token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="administrator@demo.com"),
     *             @OA\Property(property="password", type="string", example="secret123"),
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(
     *                   property="success",
     *                   type="boolean",
     *                   example="true"
     *               ),
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *                   example="Login successful"
     *               ),
     *               @OA\Property(
     *                   property="token",
     *                   type="string",
     *                   example="1|zciir31phWmxt06zflfClSRipwQ6yKbwUQw0sMan36f0a163"
     *               ),
     *           )
     *       )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(
     *                   property="success",
     *                   type="boolean"
     *               ),
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *                   example="invalid credentials"
     *               ),
     *           )
     *       )
     *     )
     * )
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        return $request->authenticate();
    }
}
