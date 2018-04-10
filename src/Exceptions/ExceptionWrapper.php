<?php

namespace Aplr\Toolbox\Exceptions;

use Exception;
use ReflectionClass;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\ValidationException;

class ExceptionWrapper implements Arrayable, Jsonable, JsonSerializable {

    private $exception;
    private $message;
    private $code;

    public function __construct(Exception $e, $code = 0, $message = null)
    {
        $this->exception = $e;
        $this->code = $code;
        $this->message = $message;
    }

    public static function wrap(Exception $e, $code = 0, $message = null)
    {
        return new self($e, $code, $message);
    }

    public function getMessage()
    {
        if (!is_null($this->message)) {
            return $this->message;
        }

        return $this->exception->getMessage();
    }

    public function getCode()
    {
        if ($this->exception instanceof HttpException && $this->code == 0) {
            return $this->exception->getStatusCode();
        }

        return $this->code;
    }

    public function getClass()
    {
        return (new ReflectionClass($this->exception))->getShortName();
    }

    public function toArray()
    {
        $data = [
            'message' => $this->getMessage(),
            'code' => $this->getCode()
        ];

        if (config('app.debug')) {
            $data['exception'] = $this->getClass();
        }

        if ($this->exception instanceof ValidationException) {
            $data['errors'] = $this->exception->errors();
        }

        return $data;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

}