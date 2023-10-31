<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use App\Traits\HttpResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AdminPermission
{
    use HttpResponseTrait;

    /* admin permission */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->header('Authorization');

            if (!$token) {
                $errorArray = ['token' => ['Token not found.']];
                return $this->HttpErrorResponse($errorArray, 404);
            }

            $user = JWTAuth::parseToken()->authenticate($token);
            /* check role */
            if ($user->role == "admin") {
                return $next($request);
            } else {
                $errorArray = ['token' => ['Invalid Role Permission.']];
                return $this->HttpErrorResponse($errorArray, 404);
            }
            
        } catch (Exception $e) {
            $errorArray = ['token' => [$e->getMessage()]];
            return $this->HttpErrorResponse($errorArray, 404);
        }
    }
}
