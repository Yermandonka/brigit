<?php
namespace codigo\brigit\includes\votes;

class voteFactory
{
    public static function CreateVote()
    {
        return new voteDAO();
    }
}
?>
