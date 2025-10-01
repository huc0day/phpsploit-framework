<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-15
 * Time: 下午6:52
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

class Class_Controller_Security
{
    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( ! is_cli () ) {
            $_top    = Class_View_Top::top ();
            $_body   = array (
                "menu"    => Class_View_Security_Menu::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function url ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_string = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        $_type   = Class_Base_Request::form ( "type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Security::TYPE_URL_ENCODE );
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Url Data Encode / Decode</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for URL encoding or decoding behavior of corresponding data.</div>';
            $_form        = array (
                "action"    => "/security/url" ,
                "selects"   => array (
                    array (
                        "title"   => "( Encode / Decode )   : " ,
                        "name"    => "type" ,
                        "options" => array (
                            array ( "describe" => "encode data" , "title" => "Encode Data" , "value" => Class_Base_Security::TYPE_URL_ENCODE , "selected" => ( ( $_type == Class_Base_Security::TYPE_URL_ENCODE ) ? "selected" : "" ) ) ,
                            array ( "describe" => "decode data" , "title" => "Decode Data" , "value" => Class_Base_Security::TYPE_URL_DECODE , "selected" => ( ( $_type == Class_Base_Security::TYPE_URL_DECODE ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "string" ,
                        "value" => $_string ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_URL_DECODE ) ? urldecode ( $_string ) : urlencode ( $_string ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function base64 ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_string = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        $_type   = Class_Base_Request::form ( "type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Security::TYPE_BASE64_ENCODE );
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Base64 Data Encode / Decode</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for BASE64 mode encoding or decoding behavior of corresponding data.</div>';
            $_form        = array (
                "action"    => "/security/base64" ,
                "selects"   => array (
                    array (
                        "title"   => "( Encode / Decode )   : " ,
                        "name"    => "type" ,
                        "options" => array (
                            array ( "describe" => "encode data" , "title" => "Encode Data" , "value" => Class_Base_Security::TYPE_BASE64_ENCODE , "selected" => ( ( $_type == Class_Base_Security::TYPE_BASE64_ENCODE ) ? "selected" : "" ) ) ,
                            array ( "describe" => "decode data" , "title" => "Decode Data" , "value" => Class_Base_Security::TYPE_BASE64_DECODE , "selected" => ( ( $_type == Class_Base_Security::TYPE_BASE64_DECODE ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "string" ,
                        "value" => $_string ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_BASE64_DECODE ) ? base64_decode ( $_string ) : base64_encode ( $_string ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function sha1 ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_string = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:16px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Sha1 Data Encode</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for SHA1 mode encoding or decoding behavior of corresponding data.</div>';
            $_form        = array (
                "action"    => "/security/sha1" ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "string" ,
                        "value" => $_string ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( sha1 ( $_string ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function md5 ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_string = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Md5 Data Encode</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for MD5 mode encoding or decoding behavior of corresponding data.</div>';
            $_form        = array (
                "action"    => "/security/md5" ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "string" ,
                        "value" => $_string ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( md5 ( $_string ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function crc32 ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_string = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Crc32 Data Encode</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for CRC32 mode encoding or decoding behavior of corresponding data.</div>';
            $_form        = array (
                "action"    => "/security/crc32" ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "string" ,
                        "value" => $_string ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( sprintf ( "%un" , crc32 ( $_string ) ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function crypt ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_string = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        $_salt   = Class_Base_Request::form ( "salt" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Crypt Data Encode</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for CRYPT mode encoding or decoding behavior of corresponding data.</div>';
            $_form        = array (
                "action"    => "/security/crypt" ,
                "inputs"    => array (
                    array (
                        "title"    => "( Encode Salt ) : " ,
                        "describe" => "salt" ,
                        "name"     => "salt" ,
                        "value"    => $_salt ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "string" ,
                        "value" => $_string ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( crypt ( $_string , $_salt ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function openssl ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_type        = Class_Base_Request::form ( "type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Security::TYPE_OPENSSL_ENCODE );
        $_data        = Class_Base_Request::form ( "data" , Class_Base_Request::TYPE_STRING , "" );
        $_cipher_algo = Class_Base_Request::form ( "cipher_algo" , Class_Base_Request::TYPE_STRING , "" );
        $_passphrase  = Class_Base_Request::form ( "passphrase" , Class_Base_Request::TYPE_STRING , "" );
        $_options     = Class_Base_Request::form ( "options" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_iv          = Class_Base_Request::form ( "iv" , Class_Base_Request::TYPE_STRING , "" );
        $_tag         = Class_Base_Request::form ( "tag" , Class_Base_Request::TYPE_STRING , "" );
        $_aad         = Class_Base_Request::form ( "aad" , Class_Base_Request::TYPE_STRING , "" );
        $_tag_length  = Class_Base_Request::form ( "tag_length" , Class_Base_Request::TYPE_INTEGER , 16 );
        $_result      = "";
        if ( ( is_integer ( $_type ) ) && ( Class_Base_Security::is_openssl_type ( $_type ) ) && ( is_string ( $_data ) ) && ( strlen ( $_data ) > 0 ) && ( is_string ( $_cipher_algo ) ) && ( strlen ( $_cipher_algo ) > 0 ) && ( is_string ( $_passphrase ) ) && ( strlen ( $_passphrase ) > 0 ) && ( is_integer ( $_options ) ) && ( Class_Base_Security::is_openssl_options ( $_options ) ) && ( is_string ( $_iv ) ) && ( is_string ( $_tag ) ) && ( is_string ( $_aad ) ) && is_integer ( $_tag_length ) ) {
            if ( empty( $_iv ) ) {
                $_iv = Class_Base_Security::get_openssl_iv ( $_cipher_algo );
                if ( $_iv === false ) {
                    throw new \Exception( "Failed to obtain initialization vector! Current encryption and decryption algorithm : " . print_r ( $_cipher_algo , true ) , 0 );
                }
            } else {
                $_iv = ( ( empty( @base64_decode ( $_iv ) ) ) ? ( $_iv ) : ( base64_decode ( $_iv ) ) );
            }
            if ( $_type == Class_Base_Security::TYPE_OPENSSL_DECODE ) {
                $_tag = base64_decode ( $_tag );
                $_tag = Class_Base_Security::get_openssl_tag ( $_tag , $_cipher_algo );
                if ( $_tag !== false ) {
                    $_result = Class_Base_Security::get_openssl_decode ( $_data , $_cipher_algo , $_passphrase , $_options , $_iv , $_tag , $_aad , $_tag_length );
                }
            } else {
                if ( Class_Base_Security::is_openssl_tag_length ( $_tag_length , $_cipher_algo ) ) {
                    $_result = Class_Base_Security::get_openssl_encode ( $_data , $_cipher_algo , $_passphrase , $_options , $_iv , $_tag , $_aad , $_tag_length );
                }
            }
            $_iv = ( ( $_iv == "" ) ? ( $_iv ) : ( base64_encode ( $_iv ) ) );
        }
        if ( ! is_cli () ) {
            $_form_top     = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Openssl Data Encode / Decode</div>';
            $_form_top     .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for OPENSSL mode encoding or decoding behavior of corresponding data.</div>';
            $_form         = array (
                "action"    => "/security/openssl" ,
                "inputs"    => array (
                    array (
                        "title"    => "( Encode Passphrase ) : " ,
                        "describe" => "passphrase" ,
                        "name"     => "passphrase" ,
                        "value"    => $_passphrase ,
                    ) ,
                    array (
                        "title"            => "( Encode IV ) : " ,
                        "describe"         => "iv" ,
                        "name"             => "iv" ,
                        "value"            => $_iv ,
                        "explanatory_note" => "Do not modify" ,
                    ) ,
                    array (
                        "title"            => "( Encode Tag ) : " ,
                        "describe"         => "tag" ,
                        "name"             => "tag" ,
                        "value"            => base64_encode ( $_tag ) ,
                        "explanatory_note" => "Do not modify" ,
                    ) ,
                    array (
                        "title"    => "( Encode Aad ) : " ,
                        "describe" => "aad" ,
                        "name"     => "aad" ,
                        "value"    => $_aad ,
                    ) ,
                ) ,
                "selects"   => array (
                    array (
                        "title"   => "( Cipher Algo ) : " ,
                        "name"    => "cipher_algo" ,
                        "options" => array () ,
                    ) ,
                    array (
                        "title"   => "( Tag Length )   : " ,
                        "name"    => "tag_length" ,
                        "options" => array () ,
                    ) ,
                    array (
                        "title"   => "( Encode / Decode )   : " ,
                        "name"    => "type" ,
                        "options" => array (
                            array ( "describe" => "encode data" , "title" => "Encode Data" , "value" => Class_Base_Security::TYPE_OPENSSL_ENCODE , "selected" => ( ( $_type == Class_Base_Security::TYPE_OPENSSL_ENCODE ) ? "selected" : "" ) ) ,
                            array ( "describe" => "decode data" , "title" => "Decode Data" , "value" => Class_Base_Security::TYPE_OPENSSL_DECODE , "selected" => ( ( $_type == Class_Base_Security::TYPE_OPENSSL_DECODE ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                    array (
                        "title"   => "( Encode Options )   : " ,
                        "name"    => "options" ,
                        "options" => array (
                            array ( "describe" => "OPENSSL_DEFAULT" , "title" => "OPENSSL_DEFAULT" , "value" => 0 , "selected" => ( ( $_options == 0 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "OPENSSL_RAW_DATA" , "title" => "OPENSSL_RAW_DATA" , "value" => OPENSSL_RAW_DATA , "selected" => ( ( $_options == OPENSSL_RAW_DATA ) ? "selected" : "" ) ) ,
                            array ( "describe" => "OPENSSL_ZERO_PADDING" , "title" => "OPENSSL_ZERO_PADDING" , "value" => OPENSSL_ZERO_PADDING , "selected" => ( ( $_options == OPENSSL_ZERO_PADDING ) ? "selected" : "" ) ) ,
                            array ( "describe" => "OPENSSL_RAW_DATA OR OPENSSL_ZERO_PADDING" , "title" => "OPENSSL_RAW_DATA OR OPENSSL_ZERO_PADDING" , "value" => ( OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING ) , "selected" => ( ( $_options == ( OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING ) ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "data" ,
                        "value" => $_data ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => $_result ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_cipher_algos = Class_Base_Security::get_openssl_cipher_algos ();
            foreach ( $_cipher_algos as $k => $v ) {
                $_form[ "selects" ][ 0 ][ "options" ][] = array ( "describe" => ( $v ) , "title" => ( $v ) , "value" => $v , "selected" => ( ( $_cipher_algo == $v ) ? "selected" : "" ) );
            }
            $_tag_lengths = Class_Base_Security::get_openssl_tag_lengths ();
            foreach ( $_tag_lengths as $k => $v ) {
                $_form[ "selects" ][ 1 ][ "options" ][] = array ( "describe" => ( $v ) , "title" => ( $v ) , "value" => $v , "selected" => ( ( $_tag_length == $v ) ? "selected" : "" ) );
            }
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function hash ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_data    = Class_Base_Request::form ( "data" , Class_Base_Request::TYPE_STRING , "" );
        $_algo    = Class_Base_Request::form ( "algo" , Class_Base_Request::TYPE_STRING , "" );
        $_options = Class_Base_Request::form ( "options" , Class_Base_Request::TYPE_STRING , "" );
        $_result  = "";
        $_options = @json_decode ( $_options );
        if ( ! is_array ( $_options ) ) {
            $_options = array ();
        }
        if ( empty( $_algo ) ) {
            $_data = "";
        } else {
            if ( ! Class_Base_Security::is_hash_algo ( $_algo ) ) {
                $_data = "";
            } else {
                $_options = ( empty( $_options ) ? ( array () ) : ( ( empty( @json_decode ( $_options ) ) ) ? ( array () ) : ( json_decode ( $_options ) ) ) );
                $_result  = Class_Base_Security::get_hash ( $_algo , $_data , false , $_options );
            }
        }
        if ( ! is_cli () ) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Hash Data Encode</div>';
            $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for HASH mode encoding or decoding behavior of corresponding data.</div>';
            $_form     = array (
                "action"    => "/security/hash" ,
                "selects"   => array (
                    array (
                        "title"   => "( Encode Algo ) : " ,
                        "name"    => "algo" ,
                        "options" => array () ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "title" => "( Json Options )   : " ,
                        "name"  => "string" ,
                        "value" => json_encode ( $_options ) ,
                    ) ,
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "data" ,
                        "value" => $_data ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( $_result ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_algos    = Class_Base_Security::get_hash_algos ();
            foreach ( $_algos as $k => $v ) {
                $_form[ "selects" ][ 0 ][ "options" ][] = array ( "describe" => ( $v ) , "title" => ( $v ) , "value" => $v , "selected" => ( ( $_algo == $v ) ? "selected" : "" ) );
            }
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

    public static function password_hash ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( defined ( "PASSWORD_BCRYPT" ) ) {
            $_data    = Class_Base_Request::form ( "password" , Class_Base_Request::TYPE_STRING , "" );
            $_algo    = Class_Base_Request::form ( "algo" , Class_Base_Request::TYPE_STRING , PASSWORD_BCRYPT );
            $_options = Class_Base_Request::form ( "options" , Class_Base_Request::TYPE_STRING , "" );
            $_result  = "";
            $_options = @json_decode ( $_options );
            if ( ! is_array ( $_options ) ) {
                $_options = array ();
            }
            if ( empty( $_algo ) ) {
                $_data = "";
            } else {
                if ( ! Class_Base_Security::is_password_hash_algo ( $_algo ) ) {
                    $_data = "";
                } else {
                    if ( ( is_string ( $_data ) ) && ( strlen ( $_data ) > 0 ) && ( is_string ( $_algo ) ) && ( Class_Base_Security::is_password_hash_algo ( $_algo ) ) && ( is_array ( $_options ) ) ) {
                        $_result = Class_Base_Security::get_password_hash ( $_data , $_algo , $_options );
                    }
                }
            }
            if ( ! is_cli () ) {
                $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Password Hash Data Encode</div>';
                $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for PASSWORD HASH mode encoding or decoding behavior of corresponding data.</div>';
                $_form     = array (
                    "action"    => "/security/password_hash" ,
                    "selects"   => array (
                        array (
                            "title"   => "( Encode Algo ) : " ,
                            "name"    => "algo" ,
                            "options" => array (
                                array (
                                    "describe" => ( "PASSWORD_BCRYPT" ) ,
                                    "title"    => ( "PASSWORD_BCRYPT" ) ,
                                    "value"    => ( PASSWORD_BCRYPT ) ,
                                    "selected" => ( ( $_algo == PASSWORD_BCRYPT ) ? "selected" : "" ) ,
                                ) ,
                            ) ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "title"    => "( Encode Password ) : " ,
                            "describe" => "password" ,
                            "name"     => "password" ,
                            "value"    => $_data ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "title" => "( Json Options )   : " ,
                            "name"  => "string" ,
                            "value" => json_encode ( $_options ) ,
                        ) ,
                        array (
                            "title"    => "( Result Data )   : " ,
                            "name"     => "result" ,
                            "value"    => ( $_result ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                );
                if ( defined ( "PASSWORD_ARGON2I" ) ) {
                    $_form[ "selects" ][ 0 ][ "options" ][] = array (
                        "describe" => ( "PASSWORD_ARGON2I" ) ,
                        "title"    => ( "PASSWORD_ARGON2I" ) ,
                        "value"    => ( PASSWORD_ARGON2I ) ,
                        "selected" => ( ( $_algo == PASSWORD_ARGON2I ) ? "selected" : "" ) ,
                    );
                }
                if ( defined ( "PASSWORD_ARGON2ID" ) ) {
                    $_form[ "selects" ][ 0 ][ "options" ][] = array (
                        "describe" => ( "PASSWORD_ARGON2ID" ) ,
                        "title"    => ( "PASSWORD_ARGON2ID" ) ,
                        "value"    => ( PASSWORD_ARGON2ID ) ,
                        "selected" => ( ( $_algo == PASSWORD_ARGON2ID ) ? "selected" : "" ) ,
                    );
                }
                $_top         = Class_View_Top::top ();
                $_body        = array (
                    "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                    "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
                );
                $_bottom_menu = array (
                    array (
                        "title"    => "" ,
                        "describe" => "" ,
                        "href"     => "#" ,
                    ) ,
                );
                $_content     = '<div></div>';
                $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
                Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
            } else {
                Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
            }
        }
        return null;
    }

    public static function sodium ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();

        if ( defined ( "SODIUM_BASE64_VARIANT_ORIGINAL" ) && defined ( "SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING" ) && defined ( "SODIUM_BASE64_VARIANT_URLSAFE" ) && defined ( "SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING" ) ) {
            $_type   = Class_Base_Request::form ( "type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Security::TYPE_SODIUM_BASE64_TO_BIN2 );
            $_data   = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
            $_id     = Class_Base_Request::form ( "id" , Class_Base_Request::TYPE_INTEGER , SODIUM_BASE64_VARIANT_ORIGINAL );
            $_ignore = Class_Base_Request::form ( "ignore" , Class_Base_Request::TYPE_STRING , "" );
            $_result = "";
            $_ignore = Class_Base_Security::format_bin2_string_to_bin2_string ( $_ignore );
            if ( $_ignore === false ) {
                throw new \Exception( "format bin2 string to bin2 string is parse error" , 0 );
            }
            if ( ( is_integer ( $_type ) ) && ( Class_Base_Security::is_sodium_type ( $_type ) ) && ( is_string ( $_data ) ) && ( strlen ( $_data ) > 0 ) && ( is_integer ( $_id ) ) && ( Class_Base_Security::is_sodium_id ( $_id ) ) && ( is_string ( $_ignore ) ) ) {
                if ( $_type == Class_Base_Security::TYPE_SODIUM_BIN2_TO_BASE64 ) {
                    $_result = Class_Base_Security::sodium_bin2_format_string_to_base64 ( $_data , $_id );
                } else {
                    $_result = Class_Base_Security::sodium_base64_to_bin2_format_string ( $_data , $_id , $_ignore );
                }
            }
            if ( ! is_cli () ) {
                $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Sodium Data Encode</div>';
                $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for SODIUM mode encoding or decoding behavior of corresponding data.</div>';
                $_form        = array (
                    "action"    => "/security/sodium" ,
                    "selects"   => array (
                        array (
                            "title"   => "( Base64 / Bin2 ) : " ,
                            "name"    => "type" ,
                            "options" => array (
                                array (
                                    "describe" => ( "Base64 To Bin2" ) ,
                                    "title"    => ( "Base64 To Bin2" ) ,
                                    "value"    => ( Class_Base_Security::TYPE_SODIUM_BASE64_TO_BIN2 ) ,
                                    "selected" => ( ( $_type == Class_Base_Security::TYPE_SODIUM_BASE64_TO_BIN2 ) ? "selected" : "" ) ,
                                ) ,
                                array (
                                    "describe" => ( "Bin2 To Base64" ) ,
                                    "title"    => ( "Bin2 To Base64" ) ,
                                    "value"    => ( Class_Base_Security::TYPE_SODIUM_BIN2_TO_BASE64 ) ,
                                    "selected" => ( ( $_type == Class_Base_Security::TYPE_SODIUM_BIN2_TO_BASE64 ) ? "selected" : "" ) ,
                                ) ,
                            ) ,
                        ) ,
                        array (
                            "title"   => "( Encode ID ) : " ,
                            "name"    => "id" ,
                            "options" => array (
                                array (
                                    "describe" => ( "SODIUM_BASE64_VARIANT_ORIGINAL" ) ,
                                    "title"    => ( "SODIUM_BASE64_VARIANT_ORIGINAL" ) ,
                                    "value"    => ( SODIUM_BASE64_VARIANT_ORIGINAL ) ,
                                    "selected" => ( ( $_id == SODIUM_BASE64_VARIANT_ORIGINAL ) ? "selected" : "" ) ,
                                ) ,
                                array (
                                    "describe" => ( "SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING" ) ,
                                    "title"    => ( "SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING" ) ,
                                    "value"    => ( SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING ) ,
                                    "selected" => ( ( $_id == SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING ) ? "selected" : "" ) ,
                                ) ,
                                array (
                                    "describe" => ( "SODIUM_BASE64_VARIANT_URLSAFE" ) ,
                                    "title"    => ( "SODIUM_BASE64_VARIANT_URLSAFE" ) ,
                                    "value"    => ( SODIUM_BASE64_VARIANT_URLSAFE ) ,
                                    "selected" => ( ( $_id == SODIUM_BASE64_VARIANT_URLSAFE ) ? "selected" : "" ) ,
                                ) ,
                                array (
                                    "describe" => ( "SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING" ) ,
                                    "title"    => ( "SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING" ) ,
                                    "value"    => ( SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING ) ,
                                    "selected" => ( ( $_id == SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING ) ? "selected" : "" ) ,
                                ) ,
                            ) ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "title"    => "( Ignore Char ) : " ,
                            "describe" => "ignore" ,
                            "name"     => "ignore" ,
                            "value"    => Class_Base_Security::bin2_string_to_format_bin2_string ( $_ignore ) ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "title" => "( Raw Data )   : " ,
                            "name"  => "string" ,
                            "value" => ( $_data ) ,
                        ) ,
                        array (
                            "title"    => "( Result Data )   : " ,
                            "name"     => "result" ,
                            "value"    => ( $_result ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                );
                $_top         = Class_View_Top::top ();
                $_body        = array (
                    "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                    "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
                );
                $_bottom_menu = array (
                    array (
                        "title"    => "" ,
                        "describe" => "" ,
                        "href"     => "#" ,
                    ) ,
                );
                $_content     = '<div></div>';
                $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
                Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
            } else {
                Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
            }
        } else {
            throw new \Exception( "The current environment does not support SODIUM_BASE64 series functions and constant definitions!" );
        }
        return null;
    }

    public static function hash_hmac ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_string = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        $_algo   = Class_Base_Request::form ( "algo" , Class_Base_Request::TYPE_STRING , "" );
        $_key    = Class_Base_Request::form ( "key" , Class_Base_Request::TYPE_STRING , "" );
        $_data   = "";
        if ( ( strlen ( $_algo ) > 0 ) && ( strlen ( $_key ) > 0 ) ) {
            $_data = Class_Base_Security::get_hash_hmac ( $_algo , $_string , $_key );
        }
        if ( ! is_cli () ) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Hash Hmac Data Encode</div>';
            $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This functional module is mainly used for HASH HMAC mode encoding or decoding behavior of corresponding data.</div>';
            $_form     = array (
                "action"    => "/security/hash_hmac" ,
                "inputs"    => array (
                    array (
                        "title"    => "( Encode Key ) : " ,
                        "describe" => "key" ,
                        "name"     => "key" ,
                        "value"    => $_key ,
                    ) ,
                ) ,
                "selects"   => array (
                    array (
                        "title"   => "( Encode Algo ) : " ,
                        "name"    => "algo" ,
                        "options" => array () ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "title" => "( Raw Data )   : " ,
                        "name"  => "string" ,
                        "value" => $_string ,
                    ) ,
                    array (
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => $_data ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_algos    = Class_Base_Security::get_hash_hmac_algos ();
            foreach ( $_algos as $k => $v ) {
                $_form[ "selects" ][ 0 ][ "options" ][] = array ( "describe" => ( $v ) , "title" => ( $v ) , "value" => $v , "selected" => ( ( $_algo == $v ) ? "selected" : "" ) );
            }
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Security_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "\n" . 'This functional module is currently not suitable for command line environments, and this issue may be improved in future versions!' );
        }
        return null;
    }

}