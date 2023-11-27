<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-16
 * Time: 下午5:26
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

class Class_Base_Socket extends Class_Base implements Interface_Base_Socket
{
    const ERROR_CREATE    = 10001001;
    const ERROR_SET_BLOCK = 10001002;
    const ERROR_BIND      = 10001003;
    const ERROR_LISTEN    = 10001004;
    const ERROR_ACCEPT    = 10001005;
    const ERROR_CLOSE     = 10001006;
    const ERROR_READ      = 10001007;
    const ERROR_WRITE     = 10001008;
    const ERROR_CONNECT   = 10001009;
    const ERROR_SELECT    = 10001010;
    const ERROR_SEND      = 10001011;
    const ERROR_RECV      = 10001012;

    const EXCEPTION_MESSAGE_CONNECT_QUIT = "connect is exit";
    const EXCEPTION_MESSAGE_CONNECT_EXIT = "connect service is exit";
    const EXCEPTION_BREAK                = 1;

    private static $_is_nonblock = 0;

    public static function init ( $timeout = 0 )
    {
        set_time_limit ( intval ( $timeout ) );
    }

    public static function create ( $domain = AF_INET , $type = SOCK_STREAM , $protocol = SOL_TCP )
    {
        $sock = socket_create ( $domain , $type , $protocol );
        if ( ! $sock ) {
            throw new \Exception( "socket create : " . socket_strerror ( socket_last_error () ) , self::ERROR_CREATE );
        }
        return $sock;
    }

    public static function set_block ( $sock )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket set block : socket is null" , self::ERROR_SET_BLOCK );
        }
        $bool = socket_set_block ( $sock );
        if ( ! $bool ) {
            throw new \Exception( "socket set block : " . socket_strerror ( socket_last_error () ) , self::ERROR_SET_BLOCK );
        }
        return $bool;
    }

    public static function bind ( $sock , $address = "0.0.0.0" , $port = 40668 )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket bind : " . $address . ":" . $port . " socket is null" , self::ERROR_BIND );
        }
        $bool = socket_bind ( $sock , $address , $port );
        if ( ! $bool ) {
            throw new \Exception( "socket bind : " . socket_strerror ( socket_last_error () ) , self::ERROR_BIND );
        }
        return $bool;
    }

    public static function listen ( $sock , $backlog = 0 )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket listen : socket is null" , self::ERROR_LISTEN );

        }
        $bool = socket_listen ( $sock , $backlog );
        if ( ! $bool ) {
            throw new \Exception( "socket listen : " . socket_strerror ( socket_last_error () ) , self::ERROR_LISTEN );
        }
        return $bool;
    }

    public static function accept ( $sock )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket accept : socket is null" , self::ERROR_ACCEPT );
        }
        $connect = socket_accept ( $sock );
        if ( ! self::is_nonblock () ) {
            if ( empty( $connect ) ) {
                throw new \Exception( "socket accept : " . socket_strerror ( socket_last_error () ) , self::ERROR_ACCEPT );
            }
        }
        return $connect;
    }

    public static function connect ( $sock , $ip = "127.0.0.1" , $port = 40668 )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket connect : socket is null" , self::ERROR_SET_BLOCK );
        }
        $bool = socket_connect ( $sock , $ip , $port );
        if ( ! $bool ) {
            throw new \Exception( "socket connect : " . socket_strerror ( socket_last_error () ) , self::ERROR_CONNECT );
        }
        return $bool;
    }

    public static function select ( $sock , $tv_sec , $tv_usec = 0 )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket select : socket is null" , self::ERROR_SET_BLOCK );
        }
        $socks = array ( $sock );
        $count = socket_select ( $socks , $sockets , $sockets , $tv_sec , $tv_usec );
        if ( $count === false ) {
            throw new \Exception( "socket select : " . socket_strerror ( socket_last_error () ) , self::ERROR_SELECT );
        }
        return $count;
    }

    public static function getpeername ( $socket )
    {
        if ( is_resource ( $socket ) || is_object ( $socket ) ) {
            $_client           = array ();
            $_client[ "ip" ]   = "0.0.0.0";
            $_client[ "port" ] = 0;
            $_bool             = socket_getpeername ( $socket , $_client[ "ip" ] , $_client[ "port" ] );
            if ( empty( $_bool ) ) {
                return array ( "ip" => "0.0.0.0" , "port" => "0" , "socket" => null , "invitation_code" => 0 );
            }
            $_client[ "socket" ]          = $socket;
            $_client[ "invitation_code" ] = 0;
            return $_client;
        }
        return array ( "ip" => "0.0.0.0" , "port" => "0" , "socket" => null , "invitation_code" => 0 );
    }

    public static function close ( $sock )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket close : socket is null" , self::ERROR_CLOSE );
        }
        @socket_close ( $sock );
    }

    public static function read ( $sock , $length = 1024 , $type = PHP_BINARY_READ )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket read : socket is null" , self::ERROR_READ );
        }
        $data = socket_read ( $sock , $length , $type );
        if ( $data === false ) {
            throw new \Exception( "socket read : " . socket_strerror ( socket_last_error () ) , self::ERROR_READ );
        }
        return $data;
    }

    public static function receive ( $sock , $length = 1048576 , $flag = MSG_DONTWAIT )
    {
        $_buf    = null;
        $_length = socket_recv ( $sock , $_buf , $length , $flag );
        if ( $_length !== false ) {
            return $_buf;
        }
        return null;
    }

    public static function send ( $sock , $data , $length , $flags )
    {
        $_length = socket_send ( $sock , $data , $length , $flags );
        return $_length;
    }

    public static function write ( $sock , $data , $length = null )
    {
        if ( empty( $sock ) ) {
            throw new \Exception( "socket write : socket is null" , self::ERROR_WRITE );
        }
        if ( $length == null ) {
            $count = socket_write ( $sock , $data );
        } else {
            $count = socket_write ( $sock , $data , $length );
        }
        if ( $count === false ) {
            throw new \Exception( "socket write : " . socket_strerror ( socket_last_error () ) , self::ERROR_WRITE );
        }
        return $count;
    }

    public static function socket_set_nonblock ( $socket )
    {
        self::$_is_nonblock = 1;
        if ( is_resource ( $socket ) ) {
            stream_set_blocking ( $socket , false );
        }
        return socket_set_nonblock ( $socket );
    }

    public static function is_nonblock ()
    {
        if ( ! empty( self::$_is_nonblock ) ) {
            return true;
        }
        return false;
    }

    public static function is_socket ( $socket )
    {
        $_bool = Class_Base_Format::is_socket ( $socket );
        return $_bool;
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
}