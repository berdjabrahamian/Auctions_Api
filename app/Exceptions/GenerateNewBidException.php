<?php

namespace App\Exceptions;

use Exception;

class GenerateNewBidException extends Exception
{

    /**
     * @return mixed
     */
    public function getMessage()
    {
        $this->message[] = 'Hello';
        return $this->message;
    }
    public function render($request)
    {
        return response()->json(['error' => $this->getMessage()], $this->getCode());
    }
}
