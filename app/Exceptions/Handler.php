<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        switch ($exception){
            case $exception instanceof NotFoundHttpException:
                return response()->json([
                        'code' => 404,
                        'status' => 'error',
                        'message' => 'Nie znaleziono strony']
                    , 404);
                break;

            case $exception instanceof ValidationException:
                            return response()->json([
                    'code' => 422,
                    'status' => 'error',
                    'errors' => $exception->errors()]
                , 422);
                break;

            case $exception instanceof ModelNotFoundException:
            return response()->json([
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Nie znaleziono']
                , 404);
                break;

            case $exception instanceof AuthorizationException:
            return response()->json([
                    'code' => 403,
                    'status' => 'error',
                    'message' => 'Brak autoryzacji lub uprawnień by wykonać tę akcję']
                , 403);
            break;

            case $exception instanceof MethodNotAllowedHttpException:
            return response()->json([
                    'code' => 405,
                    'status' => 'error',
                    'message' => 'Method not allowed']
                , 405);
                break;

            case $exception instanceof UnauthorizedHttpException:
            return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Unauthorized']
                , 401);
                break;

            case $exception instanceof QueryException:
            return response()->json([
                    'code' => 500,
                    'status' => 'error',
                    'errors' => $exception->errorInfo,
                    'message' => 'Internal Server Error']
                , 500);
                break;

//            case $exception instanceof Google_Service_Exception:
//            return response()->json([
//                    'code' => $exception->getCode(),
//                    'status' => 'error',
//                    'message' => $exception->getMessage()]
//                , $exception->getCode());
//                break;

            case $exception instanceof Exception:
            return response()->json([
                    'code' => 500,
                    'status' => 'error',
                    'errors' => $exception->getMessage(),
                    'message' => 'Internal Server Error']
                , 500);
                break;

        }
        return parent::render($request, $exception);
    }
}
