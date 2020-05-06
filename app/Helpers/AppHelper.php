<?php
namespace App\Helpers;

class AppHelper
{
    public static function buildResponse($data, bool $requestFlag, $satausCode)
    {
        return response()->json([
            'success' => $requestFlag,
            'response' => $data
        ], $satausCode );
    }
}