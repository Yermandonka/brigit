<?php
namespace codigo\brigit\includes\meanings;

class meaningAlreadyExistException extends \Exception
{
    function __construct(string $message = "" , int $code = 0 , \Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }
}

?>