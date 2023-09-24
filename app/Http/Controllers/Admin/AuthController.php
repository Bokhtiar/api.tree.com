<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponseTrait;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        /* check validator */
        if ($validator->fails()) {
            return $this->HttpErrorResponse($validator->errors(), 422);
        }

        /* check exist email */
        $existCredintial = User::where('email', $request->email)->first();
        if (!$existCredintial) {
            $errorArray = ['credentials' => ['Invalid login credentials.']];
            return $this->HttpErrorResponse($errorArray, 404);
        }

        /* check exist password */
        if (!Hash::check($request->password, $existCredintial->password)) {
            $errorArray = ['credentials' => ['Invalid login credentials.']];
            return $this->HttpErrorResponse($errorArray, 404);
        }

        /* check role */
        $checkRole = User::where('role', $existCredintial->role)->first();
        if (!$checkRole) {
            $errorArray = ['credentials' => ['Invalid login credentials.']];
            return $this->HttpErrorResponse($errorArray, 404);
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
        ], 401);
    }
}
