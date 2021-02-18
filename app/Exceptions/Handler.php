<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ModelNotFoundException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        app('sneaker')->captureException($exception);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {
            return $this->renderForRest($request, $exception);
        } else {
            return $this->renderForWeb($request, $exception);
        }

        return parent::render($request, $exception);
    }

    private function renderForRest($request, $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->error($e->getMessage(), 401);
        }

        if ($e instanceof InvalidCredentialException) {
            return response()->error($e->getMessage(), 401);
        }

        if ($e instanceof OtpExpiredException) {
            return response()->error($e->getMessage(), 403);
        }

        if ($e instanceof InvalidOtpException) {
            return response()->error($e->getMessage(), 404);
        }

        if ($e instanceof InvalidEmailException) {
            return response()->error($e->getMessage(), 404);
        }

        if ($e instanceof JobAlreadyAppliedException) {
            return response()->error($e->getMessage(), 403);
        }

        if ($e instanceof JobAlreadyExistsException) {
            return response()->error($e->getMessage(), 422);
        }

        if ($e instanceof ValidationException) {
            return response()->error($e->errors()->toArray(), 422);
        }

        return response()->error($e->getMessage(), 403);
    }

    private function renderForWeb($request, $exception)
    {

    }
}
