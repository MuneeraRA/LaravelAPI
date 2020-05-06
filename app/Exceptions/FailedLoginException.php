<?php
 
namespace App\Exceptions;

use Exception;
use Config;
 
class FailedLoginException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }
 
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(['error' => 'Invalid Password'], Config::get('constants.status_codes.forbidden'));

    }
}