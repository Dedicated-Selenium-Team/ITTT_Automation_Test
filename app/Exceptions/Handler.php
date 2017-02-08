<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
    HttpException::class,
    ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
       $message = 'Bad Request';
       $status_code= '400';
       if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        $message='Resource not found';
        $status_code='404';
        
    } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
     $message='Page not found';
     $status_code='404';
     

 }

 //return response()->view('404',compact('e','request','message','status_code'));
    /*
    $exceptiontype=get_class($e);
    $link_array = explode('\\',$exceptiontype);
    $exceptiontype = end($link_array);
$status_code=(new \Illuminate\Http\Response)->getStatusCode();
    return response()->view('404',compact('e','request','exceptiontype','status_code'));
*/
    return parent::render($request, $e);
}
}

