<?php


namespace App\Http\Controllers\Api;

trait ApiResponse
{
    public function apiResponse(array $data, int $status)
    {
        return response()->json(['data' => $data],$status);
    }
}
