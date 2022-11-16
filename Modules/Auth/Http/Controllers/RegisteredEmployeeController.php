<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Modules\Employee\Entities\Employee;

class RegisteredEmployeeController extends Controller
{


    protected $EmployeeModel = Employee::class;
    protected $UserModel = User::class;
    

    protected function get_model(){

        $type  = request('type','user');

        if($type == 'employee'){
            return $this->EmployeeModel;
        }

        return $this->UserModel;

    }
    
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $model = $this->get_model();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.$model],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $model::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return response()->json([
            'token' => $user->createToken($request->userAgent() ?? 'auth')->plainTextToken,
            'message' => __("authenticated successfully")
        ]);
    }
}
