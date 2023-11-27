<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-23
 * Time: 下午6:27
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

class Class_Operate_ChatServer extends Class_Operate implements Interface_Operate_ChatServer
{
    const EXCEPTION_MESSAGE_TOKEN_ERROR  = "token is error";
    const EXCEPTION_MESSAGE_CONNECT_QUIT = "connect is exit";
    const EXCEPTION_MESSAGE_CONNECT_EXIT = "connect service is exit";
    const EXCEPTION_BREAK                = 1;

    private static $_client_sockets         = array ();
    private static $_server_socket          = null;
    private static $_max_connect_number     = 0;
    private static $_invitation_codes       = array ( "admin" => null , "users" => array () );
    private static $_invitation_codes_limit = Interface_Operate_ChatServer::LIMIT_INVITATION_CODES;

    public static function create_invitation_codes ( $connect_domain_List_id = "connect_domain_list_id" )
    {
        self::$_invitation_codes[ "admin" ] = array ( time () . rand ( 10000001 , 99999999 ) , "admin" );
        if ( ! is_array ( self::$_invitation_codes[ "users" ] ) ) {
            self::$_invitation_codes[ "users" ] = array ();
        }
        if ( ! is_cli () ) {
            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nSuccessfully created a temporary administrator account for the combat conference room, account nickname: " . self::$_invitation_codes[ "admin" ][ 1 ] . ", account password: " . self::$_invitation_codes[ "admin" ][ 0 ] ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
        } else {
            Class_Base_Response::outputln ( "\n" . ( "Successfully created a temporary administrator account for the combat conference room, account nickname: " . self::$_invitation_codes[ "admin" ][ 1 ] . ", account password: " . self::$_invitation_codes[ "admin" ][ 0 ] ) . "\n" );
        }
        for ( $user_invitation_codes_index = 0 ; $user_invitation_codes_index < ( self::$_invitation_codes_limit - 1 ) ; $user_invitation_codes_index++ ) {
            self::$_invitation_codes[ "users" ][ $user_invitation_codes_index ] = array ( ( time () . rand ( 10000001 , 99999999 ) ) , ( "user_" . $user_invitation_codes_index ) );
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nSuccessfully created " . ( $user_invitation_codes_index + 1 ) . " combat conference room temporary account, account nickname: " . ( self::$_invitation_codes[ "users" ][ $user_invitation_codes_index ][ 1 ] ) . ", account password: " . ( self::$_invitation_codes[ "users" ][ $user_invitation_codes_index ][ 0 ] ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "\n" . ( "Successfully created " . ( $user_invitation_codes_index + 1 ) . " combat conference room temporary account, account nickname: " . ( self::$_invitation_codes[ "users" ][ $user_invitation_codes_index ][ 1 ] ) . ", account password: " . ( self::$_invitation_codes[ "users" ][ $user_invitation_codes_index ][ 0 ] ) ) . "\n" );
            }
        }
    }

    public static function in_invitation_codes ( $invitation_code )
    {
        if ( $invitation_code == self::$_invitation_codes[ "admin" ][ 0 ] ) {
            return true;
        }
        foreach ( self::$_invitation_codes[ "users" ] as $index => $user ) {
            if ( $invitation_code == $user[ 0 ] ) {
                return true;
            }
        }
        return false;
    }

    public static function get_invitation_code_index ( $invitation_code )
    {
        foreach ( self::$_invitation_codes[ "users" ] as $index => $user ) {
            if ( $invitation_code == $user[ 0 ] ) {
                return $index;
            }
        }
        return false;
    }

    public static function get_invitation_code_name ( $invitation_code )
    {
        if ( $invitation_code == self::$_invitation_codes[ "admin" ][ 0 ] ) {
            return self::$_invitation_codes[ "admin" ][ 1 ];
        }
        foreach ( self::$_invitation_codes[ "users" ] as $index => $user ) {
            if ( $invitation_code == $user[ 0 ] ) {
                return $user[ 1 ];
            }
        }
        return null;
    }

    public static function clear_invitation_code ( $invitation_code )
    {
        foreach ( self::$_invitation_codes[ "users" ] as $index => $user ) {
            if ( $invitation_code == $user[ 0 ] ) {
                self::$_invitation_codes[ "users" ][ $index ] = null;
                unset( self::$_invitation_codes[ "users" ][ $index ] );
            }
        }
        return null;
    }

    public static function get_client_key ( $ip , $port )
    {
        $_client_key = $ip . ":" . $port;
        return $_client_key;
    }

    public static function create_server ( $ip , $port , $max_connect_number = 20 , $max_execute_time = 3600 , $connect_domain_List_id = "connect_domain_list_id" )
    {
        Class_Base_Socket::init ( $max_execute_time );
        if ( ! is_cli () ) {
            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\n" . 'The maximum effective listening time of the socket server has been set to ' . ( ( intval ( $max_execute_time ) === 0 ) ? 'unlimited duration. Please note that such behavior may be dangerous!' : ( $max_execute_time . ' seconds' ) ) ) . "\n" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
        } else {
            Class_Base_Response::outputln ( 'The maximum effective listening time of the socket server has been set to ' . ( ( intval ( $max_execute_time ) === 0 ) ? 'unlimited duration. Please note that such behavior may be dangerous!' : ( $max_execute_time . ' seconds' ) ) );
        }
        self::$_max_connect_number = $max_connect_number;
        self::$_server_socket      = Class_Base_Socket::create ();
        Class_Base_Socket::socket_set_nonblock ( self::$_server_socket );
        Class_Base_Socket::bind ( self::$_server_socket , $ip , $port );
        Class_Base_Socket::listen ( self::$_server_socket , $max_connect_number );
    }

    public static function add_client_to_map ( $ip , $port , $socket , $invitation_code )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_key = self::get_client_key ( $ip , $port );
        if ( empty( self::$_client_sockets[ $_key ] ) ) {
            self::$_client_sockets[ $_key ] = array ( $socket , $invitation_code );
        }
        if ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] = array ( $socket , $invitation_code );
        }
    }

    public static function set_client_map_invitation_code ( $ip , $port , $invitation_code )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_key = self::get_client_key ( $ip , $port );
        if ( array_key_exists ( $_key , self::$_client_sockets ) && is_array ( self::$_client_sockets[ $_key ] ) && ( count ( self::$_client_sockets[ $_key ] ) >= 2 ) && empty( self::$_client_sockets[ $_key ][ 1 ] ) ) {
            self::$_client_sockets[ $_key ][ 1 ] = $invitation_code;
        }
        if ( array_key_exists ( $_key , $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] ) && is_array ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] ) && ( count ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] ) >= 2 ) && empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ][ 1 ] ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ][ 1 ] = $invitation_code;
        }
    }

    public static function get_client_map_invitation_code ( $ip , $port )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_key = self::get_client_key ( $ip , $port );
        if ( ! empty( self::$_client_sockets[ $_key ] ) ) {
            if ( count ( self::$_client_sockets[ $_key ] ) >= 2 ) {
                return self::$_client_sockets[ $_key ][ 1 ];
            }
        }
        if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] ) ) {
            if ( count ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] ) >= 2 ) {
                return $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ][ 1 ];
            }
        }
        return null;
    }

    public static function get_client_map_socket ( $ip , $port )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_key = self::get_client_key ( $ip , $port );
        if ( ! empty( self::$_client_sockets[ $_key ] ) ) {
            if ( count ( self::$_client_sockets[ $_key ] ) >= 2 ) {
                return self::$_client_sockets[ $_key ][ 0 ];
            }
        } else if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] ) ) {
            if ( count ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ] ) >= 2 ) {
                return $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $_key ][ 0 ];
            }
        }
        return null;
    }

    public static function get_client_map_ip_and_port ( $client_key )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ! empty( self::$_client_sockets[ $client_key ] ) ) {
            $_item = explode ( ":" , $client_key );
            if ( count ( $_item ) < 2 ) {
                return null;
            }
            return $_item;
        } else if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $client_key ] ) ) {
            $_item = explode ( ":" , $client_key );
            if ( count ( $_item ) < 2 ) {
                return null;
            }
            return $_item;
        }
        return null;
    }

    public static function clear_client_to_map ( $key )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ! empty( self::$_client_sockets[ $key ] ) ) {
            self::$_client_sockets[ $key ] = null;
            unset( self::$_client_sockets[ $key ] );
        }
        if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $key ] ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $key ] = null;
            unset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][ $key ] );
        }
    }

    public static function count_client_socket_map ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_count = count ( self::$_client_sockets );
        if ( empty( $_count ) ) {
            $_count = count ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] );
        }
        return $_count;
    }

    public static function list_client_socket ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_list = array_keys ( self::$_client_sockets );
        if ( empty( $_list ) ) {
            $_list = array_keys ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] );
        }
        return $_list;
    }

    public static function list_client_sokcet_string ()
    {
        $_string = implode ( " , " , self::list_client_socket () );
        return $_string;
    }

    public static function send_message ( $socket , $message , $private_key_resource , $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_client_sockets = array ();
        if ( ! empty( self::$_client_sockets ) ) {
            $_client_sockets = self::$_client_sockets;
        } else if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] ) ) {
            $_client_sockets = $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ];
        }
        foreach ( $_client_sockets as $key => $item ) {
            if ( ( ! empty( $item[ 0 ] ) ) && ( ! empty( $item[ 1 ] ) ) ) {
                if ( $socket != $item[ 0 ] ) {
                    try {
                        $_message_length = strlen ( $message );
                        if ( $_message_length == 1 ) {
                            if ( substr ( $message , ( $_message_length - 1 ) , 1 ) != "\n" ) {
                                if ( substr ( $message , ( $_message_length - 1 ) , 1 ) == "\r" ) {
                                    $message = ( $message . "\n" );
                                } else {
                                    $message = ( $message . "\r\n" );
                                }
                            }
                        } else if ( $_message_length >= 2 ) {
                            if ( substr ( $message , ( $_message_length - 2 ) , 2 ) != "\r\n" ) {
                                if ( substr ( $message , ( $_message_length - 1 ) , 1 ) == "\r" ) {
                                    $message = ( $message . "\n" );
                                } else {
                                    $message = ( $message . "\r\n" );
                                }
                            }
                        }
                        $_encode_message = Class_Base_Security_Rsa::private_encode ( $message , $private_key_resource );
                        $_length         = Class_Base_Socket::write ( $item[ 0 ] , $_encode_message );
                    } catch ( \Exception $e ) {
                        if ( ! is_cli () ) {
                            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client connection write is error , client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) , messsage ( " . $message . " ) , error code ( " . $e->getCode () . " ) , error_message ( " . $e->getMessage () . " ) " ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        } else {
                            Class_Base_Response::outputln ( "\n" . ( "client connection write is error , client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) , messsage ( " . $message . " ) , error code ( " . $e->getCode () . " ) , error_message ( " . $e->getMessage () . " ) " ) . "\n" );
                        }
                        $_length = false;
                    }
                    if ( $_length === false ) {
                        try {
                            Class_Base_Socket::close ( $item[ 0 ] );
                        } catch ( \Exception $e ) {
                            if ( ! is_cli () ) {
                                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client connection close is error , client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) , error code ( " . $e->getCode () . " ) , error_message ( " . $e->getMessage () . " ) " ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                            } else {
                                Class_Base_Response::outputln ( "\n" . ( "client connection close is error , client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) , error code ( " . $e->getCode () . " ) , error_message ( " . $e->getMessage () . " ) " ) . "\n" );
                            }
                        }
                        self::clear_client_to_map ( $key );
                        if ( ! is_cli () ) {
                            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client connection is close , client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) " ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        } else {
                            Class_Base_Response::outputln ( "\n" . ( "client connection is close , client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) " ) . "\n" );
                        }
                    }
                    if ( ! is_null ( $socket ) ) {
                        if ( ! is_cli () ) {
                            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nsend message to client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) , message : " . print_r ( $message , true ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        } else {
                            Class_Base_Response::outputln ( "\n" . ( "send message to client ( " . $key . " ) , invitation_code ( " . $item[ 1 ] . " ) , message : " . print_r ( $message , true ) ) . "\n" );
                        }
                    }
                }
            }
        }
    }

    public static function start ( $ip , $port , $max_connect_number , $max_execute_time , $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        try {
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nChat Server is Start , time : " . date ( "Y-m-d H:i:s" , time () ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nclient manager connect : " . $_SERVER[ "REMOTE_ADDR" ] . ":" . $_SERVER[ "REMOTE_PORT" ] . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "Chat Server is Start" );
            }
            self::create_invitation_codes ( $connect_domain_List_id );
            self::create_server ( $ip , $port , $max_connect_number , $max_execute_time , $connect_domain_List_id );
            $_public_key_resource  = Class_Base_Security_Rsa::create_public_key_resource ( Class_Base_Security_Rsa::CLIENT_PUBLIC_KEY );
            $_private_key_resource = Class_Base_Security_Rsa::create_private_key_resource ( Class_Base_Security_Rsa::SERVER_PRIVATE_KEY );
            if ( ( empty( $_public_key_resource ) ) || ( empty( $_private_key_resource ) ) ) {
                throw new \Exception( "RSA public or private key resource request failed ! " , 0 );
            }
            do {
                $client_socket = Class_Base_Socket::accept ( self::$_server_socket );
                if ( ! empty( $client_socket ) ) {
                    if ( ! Class_Base_Socket::is_socket ( $client_socket ) ) {
                        throw new \Exception( "new socket is not a resource , socket ( " . print_r ( $client_socket , true ) . " ) , socket type ( " . gettype ( $client_socket ) . " ) " , 0 );
                    }
                    $_client_info = Class_Base_Socket::getpeername ( $client_socket );
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "Received connection from client " . $_client_info[ "ip" ] . ":" . $_client_info[ "port" ] ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "\n" . ( "Received connection from client " . $_client_info[ "ip" ] . ":" . $_client_info[ "port" ] ) . "\n" );
                    }
                    self::add_client_to_map ( $_client_info[ "ip" ] , $_client_info[ "port" ] , $_client_info[ "socket" ] , $_client_info[ "invitation_code" ] );
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client sockets : " . self::list_client_sokcet_string () ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "\n" . ( "client sockets : " . self::list_client_sokcet_string () ) . "\n" );
                    }
                }
                try {
                    $_client_sockets = array ();
                    if ( ! empty( self::$_client_sockets ) ) {
                        $_client_sockets = self::$_client_sockets;
                    } else if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] ) ) {
                        $_client_sockets = $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ];
                    }
                    foreach ( $_client_sockets as $key => $item ) {
                        if ( empty( $item ) ) {
                            continue;
                        }
                        if ( empty( $item[ 0 ] ) ) {
                            continue;
                        }
                        $_client_exit = 0;
                        $_client_info = Class_Base_Socket::getpeername ( $item[ 0 ] );
                        if ( empty( $_client_info[ "socket" ] ) ) {
                            continue;
                        }
                        $_message = Class_Base_Socket::receive ( $item[ 0 ] , 1048576 , MSG_DONTWAIT );
                        if ( ! Class_Base_Format::is_empty ( $_message ) ) {
                            $_message             = Class_Base_Security_Rsa::public_decode ( $_message , $_public_key_resource );
                            $_client_message      = Class_Base_Format::format_message_read ( $_message );
                            $_client_message_item = explode ( chr ( 32 ) , $_client_message );
                            $_message_item        = $_client_message_item;
                            array_shift ( $_message_item );
                            if ( count ( $_client_message_item ) < 2 ) {
                                Class_Base_Socket::close ( $item[ 0 ] );
                                self::clear_client_to_map ( $key );
                                $_client_exit = 1;
                                if ( ! is_cli () ) {
                                    Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client ( " . $key . " ) socket is close , client_invitation_code is not is exist , time : " . date ( "Y-m-d H:i:s" , time () ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                } else {
                                    Class_Base_Response::outputln ( "\n" . ( "client ( " . $key . " ) socket is close , client_invitation_code is not is exist , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                                }
                            }
                            $_invitation_code = $item[ 1 ] = $_client_info[ "invitation_code" ] = $_client_message_item[ 0 ];
                            $_client_message  = implode ( " " , $_message_item );
                            if ( ( ! self::in_invitation_codes ( $_invitation_code ) ) & ( empty( $_client_exit ) ) ) {
                                Class_Base_Socket::close ( $item[ 0 ] );
                                self::clear_client_to_map ( $key );
                                $_client_exit = 1;
                                if ( ! is_cli () ) {
                                    Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client ( " . $key . " ) socket is close , client_invitation_code is error , client_invitation_code ( " . $_invitation_code . " ) , time : " . date ( "Y-m-d H:i:s" , time () ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                } else {
                                    Class_Base_Response::outputln ( "\n" . ( "client ( " . $key . " ) socket is close , client_invitation_code is error , client_invitation_code ( " . $_invitation_code . " ) , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                                }
                            }
                            if ( empty( $_client_exit ) ) {
                                self::set_client_map_invitation_code ( $_client_info[ "ip" ] , $_client_info[ "port" ] , $_invitation_code );
                                if ( $_client_message == "exit" ) {
                                    Class_Base_Socket::close ( $item[ 0 ] );
                                    self::clear_client_to_map ( $key );
                                    if ( ! is_cli () ) {
                                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client ( " . $key . " ) socket is close , client_send_exit to server , time : " . date ( "Y-m-d H:i:s" , time () ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                    } else {
                                        Class_Base_Response::outputln ( "\n" . ( "client ( " . $key . " ) socket is close , client_send_exit to server , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                                    }
                                }
                                if ( $_invitation_code == self::$_invitation_codes[ "admin" ][ 0 ] ) {
                                    if ( $_client_message == "server_exit" ) {
                                        throw new \Exception( "exit" , 0 );
                                    }
                                    $_client_message_length = strlen ( $_client_message );
                                    if ( ( $_client_message_length > 16 ) && ( $_client_message_length < 29 ) ) {
                                        if ( substr ( $_client_message , 0 , 6 ) == "kill_9" ) {
                                            $_kill_client_key = substr ( $_client_message , 7 , ( $_client_message_length - 7 ) );
                                            if ( key_exists ( $_kill_client_key , self::$_client_sockets ) || key_exists ( $_kill_client_key , $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] ) ) {
                                                $_kill_client_item = self::get_client_map_ip_and_port ( $_kill_client_key );
                                                if ( ! empty( $_kill_client_item ) ) {
                                                    $_client_socket = self::get_client_map_socket ( $_kill_client_item[ 0 ] , $_kill_client_item[ 1 ] );
                                                    if ( ! empty( $_client_socket ) ) {
                                                        Class_Base_Socket::close ( $_client_socket );
                                                    }
                                                    $_kill_client_invitation_code = self::get_client_map_invitation_code ( $_kill_client_item[ 0 ] , $_kill_client_item[ 1 ] );
                                                    if ( ! empty( $_kill_client_invitation_code ) ) {
                                                        self::clear_invitation_code ( $_kill_client_invitation_code );
                                                    }
                                                    self::clear_client_to_map ( $_kill_client_key );
                                                    if ( ! is_cli () ) {
                                                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "client ( " . $key . " ) socket is close , admin send kill_9 to server , time : " . date ( "Y-m-d H:i:s" , time () ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                                    } else {
                                                        Class_Base_Response::outputln ( "\n" . ( "client ( " . $key . " ) socket is close , admin send kill_9 to server , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if ( empty( $_client_exit ) && ( ! empty( $item[ 0 ] ) ) && ( $_client_message != "" ) ) {
                                    if ( ! is_cli () ) {
                                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "\nreceive message from client ( " . $_client_info[ "ip" ] . ":" . $_client_info[ "port" ] . " ) , invitation_code ( " . $_client_info[ "invitation_code" ] . " ) , message : " . print_r ( $_client_message , true ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                    } else {
                                        Class_Base_Response::outputln ( "\n" . ( "receive message from client ( " . $_client_info[ "ip" ] . ":" . $_client_info[ "port" ] . " ) , invitation_code ( " . $_client_info[ "invitation_code" ] . " ) , message : " . print_r ( $_client_message , true ) ) . "\n" );
                                    }
                                    $_client_message = ( self::get_invitation_code_name ( $item[ 1 ] ) . " : " . $_client_message );
                                    self::send_message ( $item[ 0 ] , $_client_message , $_private_key_resource , $connect_domain_List_id );
                                }
                            }
                            if ( self::count_client_socket_map () <= 0 ) {
                                throw new \Exception( "exit" , 0 );
                            }
                        }
                    }
                } catch ( \Exception $e ) {
                    if ( $e->getMessage () == "exit" ) {
                        Class_Base_Socket::close ( self::$_server_socket );
                        if ( ! is_cli () ) {
                            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "server socket is close , time : " . date ( "Y-m-d H:i:s" , time () ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        } else {
                            Class_Base_Response::outputln ( "\n" . ( "server socket is close , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                        }
                        break;
                    } else {
                        if ( ! is_cli () ) {
                            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( print_r ( $e , true ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        } else {
                            Class_Base_Response::outputln ( "\n" . ( print_r ( $e , true ) ) . "\n" );
                        }
                    }
                }
                sleep ( 1 );
            } while ( true );

        } catch ( \Exception $e ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( print_r ( $e , true ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "\n" . ( print_r ( $e , true ) ) . "\n" );
            }
        }
    }

    public static function forwarding_message ( $message , $max_execute_time = 60 , $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        foreach ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] as $index => $client_socket ) {
            $_write_length = Class_Base_Socket::write ( $client_socket , strlen ( $message ) );
            if ( $_write_length === false ) {
                $_client_info = Class_Base_Socket::getpeername ( $client_socket );
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "Data forwarding failed, receiving end (" . $_client_info[ "ip" ] . ": " . $_client_info[ "port" ] . "), data content: " . $message ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( "\n" . ( "Data forwarding failed, receiving end (" . $_client_info[ "ip" ] . ": " . $_client_info[ "port" ] . "), data content: " . $message ) . "\n" );
                }
            }
        }
    }

    public static function fork_process_append_sockets ( $socket , $max_execute_time = 3600 , $connect_domain_List_id = "connect_domain_list_id" )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! empty( $socket ) ) && ( is_resource ( $socket ) || ( is_object ( $socket ) ) ) ) {
            $_pid = pcntl_fork ();
            if ( $_pid == -1 ) {
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "Failed to create child process" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( "\n" . ( "Failed to create child process" ) . "\n" );
                }
                exit( 1 );
            } else if ( $_pid == 0 ) {
                if ( ! in_array ( $socket , $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ] ) ) {
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS" ][] = $socket;
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "The current socket has been added to the socket assembly subkey of the session array" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "\n" . ( "The current socket has been added to the socket assembly subkey of the session array" ) . "\n" );
                    }
                } else {
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "The current socket already exists in the socket assembly sub key of the session array" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "\n" . ( "The current socket already exists in the socket assembly sub key of the session array" ) . "\n" );
                    }
                }
            } else {
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "Successfully created socket subprocess, subprocess ID: " . $_pid ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( "\n" . ( "Successfully created socket subprocess, subprocess ID: " . $_pid ) . "\n" );
                }
            }
        }
    }

}