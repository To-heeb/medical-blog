<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponse
{

    /**
     * Generic success response containing data as part of output.
     * @param $data
     * @param $statusCode
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    function success($data, $statusCode = Response::HTTP_OK, $message)
    {
        return response()->json([
            "data" => $data,
            "status" => true,
            "message" => $message
        ], $statusCode);
    }


    /**
     * Generic success response without data as part of output.
     * @param $statusCode
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */

    function successWithoutData($statusCode = Response::HTTP_NO_CONTENT, $message)
    {
        return response()->json([
            "status" => true,
            "message" => $message
        ], $statusCode);
    }


    /**
     * Generic response when a request fails.
     * @param $statusCode
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    function error($statusCode, $message)
    {
        return response()->json([
            "status" => false,
            "message" => $message
        ], $statusCode);
    }
}
