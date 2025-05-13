<?php
namespace codigo\brigit\includes\votes;

class voteAlreadyExistException extends \Exception
{
    function __construct(string $message = "" , int $code = 0 , \Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }
}

?>