<?php

namespace Aen233\IUSDK\Exceptions;

use ErrorException;
use Exception;
use InvalidArgumentException;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
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
     * @param  \Exception $exception
     *
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception                $exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof BaseException
            || $exception instanceof HttpException
            || $exception instanceof ValidationException
            || $exception instanceof InvalidArgumentException
            || $exception instanceof QueryException
            || $exception instanceof ModelNotFoundException
            || $exception instanceof ErrorException
            || $exception instanceof ReflectionException
        ) {
            return $this->error($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * 自定义错误输出
     *
     * @param $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function error($exception)
    {
        $statusCode = 500;
        if ($exception instanceof ValidationException) {
            $code    = $exception->status;
            $message = current(current(array_values($exception->errors())));
        } else {
            $code    = $exception->getCode() ?: ($exception->statusCode ?? 404);
            $message = $exception->getMessage();
        }

        $response = [
            'id'      => md5(uniqid()),
            'code'    => $code,
            'status'  => $statusCode,
            'message' => $message,
            'error'   => 'ERROR',
        ];

        if ($exception instanceof BaseException && $exception->getData()) {
            $response['data'] = $exception->getData();
        }

        iuLog('error', 'Response Error: ', $response);
        iuLog(PHP_EOL);

        return response()->json($response, $statusCode, [], 320);
    }
}
