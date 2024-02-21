<?php

namespace App\Exceptions;

use App\Http\Controllers\ControllerBase;
use App\Http\Response\Response;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $e)
    {
        //
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            return ControllerBase::sendError($e->getMessage(), $e->getCode() ?: 500);
        });
    }
    public function render($request, Throwable $e)
    {
        return Response::json($e->getMessage(), $e->getCode());
    }
}
