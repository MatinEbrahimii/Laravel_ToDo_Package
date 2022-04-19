<?php

namespace MatinEbrahimii\ToDo\Http\Responses;

use Illuminate\Http\Response;

class JsonResponses
{
    public function success()
    {
        return response()->json(['message' => ' success'], Response::HTTP_OK);
    }

    public function send($key, $value)
    {
        return response()->json([$key => $value], Response::HTTP_OK);
    }

    public function notFound()
    {
        return response()->json(['message' => ' Not Found'], Response::HTTP_NOT_FOUND);
    }

    public function unauthorized()
    {
        return response()->json(['message' => ' Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    public function modelDidntCreate()
    {
        return response()->json(
            ['error' => 'Model Didnt Create'],
            Response::HTTP_BAD_REQUEST
        );
    }

    public function loggedIn()
    {
        return response()->json(['message' => 'You are logged in']);
    }

    public function emailNotValid()
    {
        return response()->json([
            'error' => 'your email is not valid', Response::HTTP_BAD_REQUEST,
        ]);
    }

    public function userNotFound()
    {
        return response()->json(
            ['error' => 'Email Does not Exist'],
            Response::HTTP_BAD_REQUEST
        );
    }
}
