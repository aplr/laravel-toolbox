<?php

namespace Aplr\Toolbox\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * {@inheritDoc}
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => $exception->getMessage(),
        ], 401);
    }

    /**
     * {@inheritDoc}
     */
    protected function convertValidationExceptionToResponse(ValidationException $exception, $request)
    {
        return response()->json([
            'message'=> $exception->getMessage(),
            'errors' => $exception->errors(),
        ], $exception->status);
    }

    /**
     * {@inheritDoc}
     */
    protected function prepareResponse($request, Exception $e)
    {
        return $this->prepareJsonResponse($request, $e);
    }

    /**
     * {@inheritDoc}
     */
    protected function convertExceptionToArray(Exception $e)
    {
        if ($e instanceof ApiException) {
            return [ 'message' => $e->getMessage() ];
        }
        
        return parent::convertExceptionToArray($e);
    }
}
