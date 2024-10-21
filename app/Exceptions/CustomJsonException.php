<?php

namespace App\Exceptions;

use Exception;

class CustomJsonException extends Exception
{
    protected $code;
    protected $status;
    protected $message;

    public function __construct($data)
    {
        $this->code = $data['code'] ?? 500;
        $this->status = $data['status'] ?? 'error';
        $this->message = $data['message'] ??  'Internal Server Error';
    }

    public function render()
    {
        return response()->json([
            $this->status => $this->message,
        ], $this->code);
    }
}
