<?php

namespace Aplr\Toolbox\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Lukasoppermann\Httpstatus\Httpstatus as HttpStatus;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ApiHandler extends ExceptionHandler
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
        
        $data = parent::convertExceptionToArray($e);

        if ($e instanceof HttpException && empty($data['message'])) {
            $data['message'] = $this->convertStatusCodeToMessage($e->getStatusCode());
        }

        return $data;
    }

    /**
     * Returns the reason phrase for a given HTTP status code
     *
     * @param integer $statusCode
     * @return string
     */
    protected function convertStatusCodeToMessage(int $statusCode): string
    {
        $status = new HttpStatus();

        if ($status->hasStatusCode($statusCode)) {
            return $status->getReasonPhrase($statusCode);
        }

        return 'Server Error';
    }
}
