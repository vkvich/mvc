<?php
namespace app\classes;
class Connection
{
    function connect($server,$userName,$password,$databaseName,$charSet)
    {
        $link = mysqli_connect($server, $userName, $password, $databaseName);

        if ($link != false){
            mysqli_set_charset($link, $charSet);
            return  $link;
        }

    }

}
