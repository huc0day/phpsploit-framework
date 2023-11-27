<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-10
 * Time: 下午3:53
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

class Class_Main extends Class_Root implements Interface_Main
{

    public static function route_execute ()
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( ( ! isset( $_SERVER ) ) || ( ! is_array ( $_SERVER ) ) ) {
            $_SERVER = array ();
        }
        if ( empty( $_SERVER[ "REQUEST_URI" ] ) ) {
            $_SERVER[ "REQUEST_URI" ] = "/";
        }
        if ( ( ! isset( $_REQUEST ) ) || ( ! is_array ( $_REQUEST ) ) ) {
            $_REQUEST = array ();
        }
        if ( ( $_SERVER[ "REQUEST_URI" ] == "/test" ) && ( empty( DEVLOP ) ) ) {
            throw new \Exception( "In a production environment, the test controller (/test) cannot be used, and/test should only be used for development and testing environments as appropriate." , 0 );
        }
        if ( ( $_SERVER[ "REQUEST_URI" ] != "/" ) && ( $_SERVER[ "REQUEST_URI" ] != "/test" ) && ( $_SERVER[ "REQUEST_URI" ] != "/clear" ) && ( $_SERVER[ "REQUEST_URI" ] != "/login" ) && ( $_SERVER[ "REQUEST_URI" ] != "/init_user_info" ) && ( is_cli () ) ) {
            self::cli_authorization_check ();
        }
        foreach ( $GLOBALS[ "ROUTE_MAPS" ] as $key => $value ) {
            if ( strtolower ( $key ) == strtolower ( str_replace ( "\\" , "/" , $_SERVER[ "REQUEST_URI" ] ) ) ) {
                $GLOBALS[ "ROUTE_ACTION" ] = $value;
                break;
            }
        }
        if ( empty( $GLOBALS[ "ROUTE_ACTION" ] ) ) {
            if ( defined ( "DEVELOP" ) ) {
                throw new \Exception ( "route " . $_SERVER[ "REQUEST_URI" ] . " is not exist" , 0 );
            } else {
                throw new \Exception ( "route " . $_SERVER[ "REQUEST_URI" ] . " is not exist" , 0 );
            }
        }
        if ( strpos ( $GLOBALS[ "ROUTE_ACTION" ] , "::" ) === false ) {
            throw new \Exception( "Route resolution failed" , 0 );
        }
        $_class_info       = explode ( "::" , $GLOBALS[ "ROUTE_ACTION" ] );
        $_class_info_count = count ( $_class_info );
        if ( ( $_class_info_count <= 1 ) || ( $_class_info_count > 2 ) ) {
            throw new \Exception( "Class information acquisition failed" , 0 );
        }
        $_class_name        = $_class_info[ 0 ];
        $_class_method_name = $_class_info[ 1 ];
        if ( ! class_exists ( $_class_name ) ) {
            throw new \Exception( "class ( '.$_class_name.' ) is not exist" , 0 );
        }
        if ( ! method_exists ( $_class_name , $_class_method_name ) ) {
            throw new \Exception( "class ( " . $_class_name . " ) :: function ( " . $_class_method_name . " ) is not exist." , 0 );
        }
        $_execute_result = call_user_func ( $GLOBALS[ "ROUTE_ACTION" ] , $_REQUEST );
        return $_execute_result;
    }

    public static function config_read ( $filename )
    {
        if ( ! file_exists ( $filename ) ) {
            throw new Exception( "config file " . $filename . " is not found" , 0 );
        }
        $_array = @json_decode ( @file_get_contents ( $filename ) , true );
        if ( ! is_array ( $_array ) ) {
            throw new Exception( "config file " . $filename . " is format error" , 0 );
        }
        return $_array;
    }

    public static function cli_authorization_check ()
    {
        if ( is_cli () ) {
            global $_SERVER;
            global $_REQUEST;
            if ( ! Class_Operate_User::exist_token () ) {
                Class_Base_Response::outputln ( "The command line authentication token has not been initialized, and the program has been disabled from running! Please log in to the management backend through web and access /cli/create_token The  module completes the initialization operation of the command line authentication token." );
                exit( 0 );
            }
            if ( ( ! is_array ( $_REQUEST ) ) || ( empty( $_REQUEST[ "md5_token" ] ) ) ) {
                Class_Base_Response::outputln ( "please enter the correct cli authentication token value!" );
                exit( 0 );
            }
            if ( ! Class_Operate_User::check_md5_token ( $_REQUEST[ "md5_token" ] ) ) {
                Class_Base_Response::outputln ( "cli authentication token input error!" );
                exit( 0 );
            }
            if ( ( ( empty( $_SERVER[ "REQUEST_URI" ] ) ) || ( $_SERVER[ "REQUEST_URI" ] != "/" ) ) && ( empty( $_REQUEST[ "is_enable_license_agreement" ] ) ) ) {
                Class_Base_Response::outputln ( "Sorry, due to your refusal to accept the relevant terms and conditions in the user agreement and disclaimer of this software, you are no longer able to use this software! If you forcibly continue to use this software, it will be considered as an infringement on the author of this software. The author of this software reserves the right to pursue legal responsibility from you!" );
                exit( 0 );
            }
            Class_Base_Auth::enable_login ();
        }
    }
}

