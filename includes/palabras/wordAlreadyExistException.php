<?php
namespace codigo\brigit\includes\palabras;

class wordAlreadyExistException extends \Exception
{
    function __construct(string $message = "" , int $code = 0 , \Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }
}

?>