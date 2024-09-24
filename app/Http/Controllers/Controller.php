<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

   /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel API Documentation",
     *      description="Laravel API Documentation",
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     *
     * @OA\SecurityScheme(
    *      securityScheme="bearerAuth",
    *      in="header",
    *      name="Authorization",
    *      type="http",
    *      scheme="Bearer",
    *      bearerFormat="sanctum",
    * ),
    */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

     /**
     * Create a successful response.
     *
     * @param array<string, mixed> $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse(array $data, int $code = 200)
    {
        $data = array_merge([
            'success' => true,
            'message' => '',
        ], $data);
        return $this->sendResponse($data, $code);
    }
    /**
     * Create an error response.
     *
     * @param string|array<string, mixed> $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, int $code = 400): \Illuminate\Http\JsonResponse
    {
        $data = [
            'success' => false,
            'message' => ''
        ];
        if (is_array($message)) {
            $data = array_merge($data, $message);
        } else {
            $data['message'] = $message;
        }
        return $this->sendResponse($data, $code);
    }
    /**
     * Send a JSON response.
     *
     * @param array<string, mixed> $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(array $data, int $code = 200)
    {
        $header = array(
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );
        return response()->json($data, $code, $header, JSON_UNESCAPED_UNICODE);
    }
}
