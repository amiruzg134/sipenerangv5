<?php

namespace App\Traits;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

trait ApiResponser
{
    /**
     * Success Response
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message="OK", $data=null,  $code = Response::HTTP_OK)
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public function errorResponse($message, $status_code=10, $code = Response::HTTP_PRECONDITION_FAILED)
    {
        return response()->json([
            'message' => $message,
            'status_code' => $status_code
        ], $code);
    }
}
