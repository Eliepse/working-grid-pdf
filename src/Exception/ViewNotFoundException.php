<?php


namespace Eliepse\WorkingGrid\Exception;


use Exception;
use Throwable;

class ViewNotFoundException extends Exception
{
    public function __construct(string $viewName, string $viewPath, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("View \"$viewName\" not found at \"$viewPath\"", $code, $previous);
    }
}