namespace App\Exceptions;
<?php
public function render($request, Exception $exception)
{
    if ($request->expectsJson()) {
        return response()->json([
            'error' => $exception->getMessage()
        ], $exception->getCode() ?: 400);
    }
    return parent::render($request, $exception);
}
