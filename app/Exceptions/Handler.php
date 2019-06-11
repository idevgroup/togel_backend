<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
            //
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
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        if ($exception instanceof AuthorizationException) {
            return $this->unauthorized($request, $exception);
        }
        return parent::render($request, $exception);
    }

    private function unauthorized($request, Exception $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }
        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
            case 'member':
                $login = 'member.login';
                break;
            default:
                $login = 'login';
                break;
        }
        return redirect()->guest(route($login));
        /*if ($request->expectsJson()) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }

        // flash()->warning($exception->getMessage());
        \Alert::warning($exception->getMessage(), 'Notification')->persistent("OK");
        return redirect()->route(_ADMIN_PREFIX_URL . 'dashboards.index');*/
    }
}
