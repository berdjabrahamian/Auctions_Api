<?php

namespace App\Exceptions;

use Exception;

class MaxBidException extends Exception
{
    public function render($request)
    {
        return response()->json(['error' => $this->getMessage()], $this->getCode());
    }
}
