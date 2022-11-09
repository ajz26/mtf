<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\Response
     */

    protected function get_guard(){
        return (request('type','user') == 'employee') ? 'employees' : 'users';
    }
    public function store(LoginRequest $request)
    {
        $request->authenticate();


        $user = Auth::guard($this->get_guard())->user();
        
        return response()->json([
            'token' => $user->createToken($request->userAgent() ?? 'auth')->plainTextToken,
            'message' => __("Employee authenticated successfully")
        ]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        Auth::guard('web')->logout();

        $success = $request->user()->currentAccessToken()->delete();



        return response()->noContent();
    }
}
