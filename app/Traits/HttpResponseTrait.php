<?php

namespace App\Traits;

trait HttpResponseTrait
{

    /* Http success response handle */
    public function HttpSuccessResponse($message, $data, $status_code)
    {
        return response()->json(
            [
                'status' => true,
                'message' => $message,
                'data' => $data,
            ],
            $status_code
        );
    }

    /* Http error response handle */
    public function HttpErrorResponse($errors, $status_code)
    {
        return response()->json(
            [
                'status' => false,
                'errors' => $errors,
            ],
            $status_code
        );
    }
}
