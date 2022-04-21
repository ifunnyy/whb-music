<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request -> ajax() || $request -> wantsJson()) {
            // 404 not found
            if ($exception instanceof NotFoundHttpException) {
                $result = [
                    "result" => false,
                    "code"=> -1,
                    "msg"=> '找不到该接口',
                    "data"=> json_decode("{}")
                ];
                return response()->json($result, '404');
            }
            // 402 表单检验错误
            if ($exception instanceof ValidationException) {
                $result = [
                    "result" => false,
                    "code"=> -1,
                    "msg"=> array_values($exception->errors())[0][0],
                    "data"=> json_decode("{}")
                ];
                return response()->json($result, $exception->status);
            }
            // 401 身份验证错误
            if ($exception instanceof AuthenticationException) {
                $result = [
                    "result" => false,
                    "code"=> -1,
                    "msg"=> '请先登录',
                    "data"=> json_decode("{}")
                ];
                return response()->json($result, '401');
            }
            // 抛出 http 异常
            if ($exception instanceof HttpException) {
                $result = [
                    "result" => false,
                    "code"=> -1,
                    "msg"=> $exception->getMessage(),
                    "data"=> json_decode("{}")
                ];
                return response()->json($result, $exception->getStatusCode());
            }
        }

        return parent::render($request, $exception);
    }
}
