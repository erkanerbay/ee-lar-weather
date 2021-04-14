<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * @param  $message
     *
     * @return JsonResponse
     */
    protected static function error($message): JsonResponse
    {
        $message = is_array($message) ? $message : [$message];
        return response()->json($message, 400);
    }

    /**
     * @param $validation
     * @return JsonResponse
     */
    protected static function validationError($validation): JsonResponse
    {
        return self::error($validation->messages()->all());
    }
}
