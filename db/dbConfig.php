<?php
namespace HawksNestGolf\Db;

Class DbConfig
{
    private static $connect_error = "";
    
    public static function getConnection () {
        //$con = @new \mysqli('localhost', 'danielrn_dann', 'HawksNest_123', 'danielrn_hawksnestgolf');
        $con = @new \mysqli('localhost', 'nichomm0_dann', 'HawksNest_123', 'nichomm0_hawksnestgolf');

        if($con->connect_error) {
            self::$connect_error = $con->connect_error;
            return null;
        }

        return $con;
    }
    
    public static function getConnectionError() {
        return(self::$connect_error);
    }

}





