<?php

namespace App\Http\Controllers\Admin;

use Validator; 
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponseTrait;

    /* login */
    public function login(AuthRequest $request)
    {
        /* check exist email */
        $existCredintial = User::where('email', $request->email)->first();
        if (!$existCredintial) {
            $errorArray = ['Invalid login credentials.'];
            return $this->HttpErrorResponse(array($errorArray), 404);
        }

        /* check exist password */
        if (!Hash::check($request->password, $existCredintial->password)) {
            $errorArray =['Invalid login credentials.'];
            return $this->HttpErrorResponse(array($errorArray), 404);
        }

        /* check role */
        $checkRole = User::where('role', $existCredintial->role)->first();
        if (!$checkRole) {
            $errorArray = ['Invalid login credentials.'];
            return $this->HttpErrorResponse(array($errorArray), 404);
        }

        $credentials = $request->only('email', 'password');

        $token = auth()->claims([
            'id' => $checkRole->id,
            'name' => $checkRole->name,
            'permissions' => json_decode($checkRole),
        ])->attempt($credentials);

        return $this->createNewToken($token);
    }

    /* create token generate exp date */
    protected function createNewToken($token)
    {
        $response_data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
 
        return response()->json([
            'status' => 'false',
            'data' => $response_data,
        ], 200);
    }
}
