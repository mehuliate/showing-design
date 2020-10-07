<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class MeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            return new UserResource($user);
            // return response()->json([
            //     "user" => auth()->user()
            // ], 200);
        }
        return response()->json(null, 401);
    }
}
