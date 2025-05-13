<?php
namespace codigo\brigit\includes\votes;

class tooManyVotesException extends \Exception
{
    function __construct(string $message = "" , int $code = 0 , \Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }
}

?>