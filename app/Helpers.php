<?php 
namespace App;

class Helpers {
    static function crc32b_hash( String $str, String $preffix = null ) : string {

        if($preffix){
            $preffix .= "__"; 
        }

        return sprintf('%1$s%2$s',$preffix,hash( 'crc32b', $str ));
	
    }
}