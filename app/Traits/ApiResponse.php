<?php

namespace App\Http\Traits;

trait ApiResponse
{

    /**
     * Generic success response containing data as part of output.
     * @param $data
     * @param $statusCode
     * @param $message
     * @return \Illuminate\Http\Response
     */
    function success($data, $statusCode, $message)
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
     * @return \Illuminate\Http\Response
     */

    function successWithoutData($statusCode, $message)
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
     * @return \Illuminate\Http\Response
     */
    function error($statusCode, $message)
    {
        return response()->json([
            "status" => false,
            "message" => $message
        ], $statusCode);
    }
}
