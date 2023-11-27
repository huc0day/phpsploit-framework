<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-6-8
 * Time: 上午8:15
 */

/*
=======================================================================================================
Phpsploit-Framework is an open source CTF framework and vulnerability exploitation development library.
Copyright (C) 2022-2023, huc0day (Chinese name: GaoJian).
All rights reserved.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY;   without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.    If not, see <https://www.gnu.org/licenses/>.
=======================================================================================================
 */

class Class_Base_Extension extends Class_Base
{
    const EXTENSION_NAME_SHMOP = "shmop";
    const EXTENSION_NAME_CURL  = "curl";

    private static $_enabled_extensions = false;

    public static function exist_enabled_extensions ( $extension_name )
    {
        if ( ( ! is_string ( $extension_name ) ) || ( strlen ( $extension_name ) <= 0 ) ) {
            throw new \Exception( ( "extension_name is error , extension_name : " . print_r ( $extension_name , true ) ) , 0 );
        }
        $_exist = @extension_loaded ( $extension_name );
        if ( is_null ( $_exist ) ) {
            $_exist = false;
        }
        return $_exist;
    }

    public static function get_enabled_extensions ()
    {
        if ( ( ! isset( self::$_enabled_extensions ) ) || ( ! is_array ( self::$_enabled_extensions ) ) ) {
            self::$_enabled_extensions = @get_loaded_extensions ();
            if ( is_null ( self::$_enabled_extensions ) ) {
                self::$_enabled_extensions = false;
            }
        }
        if ( ( is_null ( self::$_enabled_extensions ) ) || ( self::$_enabled_extensions === false ) || ( ! is_array ( self::$_enabled_extensions ) ) ) {
            throw new \Exception( "get enabled extensions is error" , 0 );
        }
        return self::$_enabled_extensions;
    }

    public static function get_extension_functions ( $extension_name )
    {
        if ( ! self::exist_enabled_extensions ( $extension_name ) ) {
            return false;
        }
        $_functions = @get_extension_funcs ( $extension_name );
        if ( ( ! is_null ( $_functions ) ) && ( is_array ( $_functions ) ) ) {
            return $_functions;
        }
        return false;
    }


}