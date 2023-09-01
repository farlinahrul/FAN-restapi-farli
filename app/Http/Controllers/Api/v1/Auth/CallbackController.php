<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Traits\ApiWrapper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    use ApiWrapper;
    /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    */
    public function __invoke(Request $request)
    {
        $data = [
            'state' => $request->state,
            'code'  => $request->code
        ];

        return $this->successResponse($data);
    }
}