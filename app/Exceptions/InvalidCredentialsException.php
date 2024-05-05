<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InvalidCredentialsException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): bool
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response(__('auth.failed'), ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
