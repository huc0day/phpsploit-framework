<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-13
 * Time: 下午12:24
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

class Class_Base_Response extends Class_Base implements Interface_Base_Response
{
    const FLAG_JS_CONTENT_INNER_HTML_COVER  = "cover";
    const FLAG_JS_CONTENT_INNER_HTML_APPEND = "append";

    private static $_output_json_flag                           = 0;
    private static $_output_flag                                = 0;
    private static $_cli_check_enable_license_agreement_filters = array ();

    public static function json ( $data )
    {
        return json_encode ( $data , JSON_PRETTY_PRINT );
    }

    public static function text ( $data )
    {
        if ( is_object ( $data ) || is_array ( $data ) ) {
            $data = json_encode ( $data , JSON_PRETTY_PRINT );
        }
        if ( is_null ( $data ) ) {
            $data = "";
        }
        return strval ( $data );
    }

    public static function output ( $data , $format = "text" , $is_convert_line_breaks = 1 )
    {
        if ( is_null ( $data ) ) {
            $data = "";
        }
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
            ob_implicit_flush ( 1 );
        }
        $_format = strtolower ( strval ( $format ) );
        if ( ( ! is_cli () ) ) {
            echo ( str_pad ( "" , 8192 , "\0" ) );
            if ( ( $_format == "text" ) && ( ! empty( $is_convert_line_breaks ) ) ) {
                $data = str_replace ( "\n" , "</br>" , $data );
            }
        }
        if ( $_format == "text" ) {
            print_r ( self::text ( $data ) );
        } else if ( $_format == "json" ) {
            print_r ( self::json ( $data ) );
        } else if ( ( $format == "array" ) || ( $format == "object" ) ) {
            print_r ( ( $data ) );
        }
        if ( is_cli () ) {
            echo ( "\n" );
        }
        if ( ( ! is_cli () ) ) {
            flush ();
        }
    }

    public static function outputln ( $data , $title = null , $format = "text" , $is_convert_line_breaks = 1 )
    {
        if ( is_null ( $title ) ) {
            $data = print_r ( $data , true ) . "\n";
        } else {
            $data = strval ( $title ) . chr ( 32 ) . print_r ( $data , true ) . "\n";
        }
        self::output ( $data , $format , $is_convert_line_breaks );
    }

    public static function header ( $type = "text" )
    {
        if ( ! is_cli () && ( ! self::$_output_json_flag ) && ( ! self::$_output_flag ) ) {
            if ( $type == "json" ) {
                @header ( "Content-type: application/json; charset=utf-8" );
                @header ( "HTTP/1.1 200" );
                @header ( "Cache-Control: no-store, no-cache" );
                @header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" , time () ) . " GMT" );
                self::$_output_json_flag = 1;
                self::$_output_flag      = 1;
            }
        }
    }

    public static function get_http_referer ( $is_encode = 0 )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( empty( $_SERVER[ "HTTP_REFERER" ] ) ) {
            $_SERVER[ "HTTP_REFERER" ] = ( self::_get_url ( "/index" , array ( "http_referer" => "" ) ) );
        }
        if ( ! empty( $is_encode ) ) {
            $_http_referer = ( urlencode ( $_SERVER[ "HTTP_REFERER" ] ) );
        } else {
            $_http_referer = ( $_SERVER[ "HTTP_REFERER" ] );
        }
        return $_http_referer;
    }

    private static function _get_url ( $action , $params = null )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ! empty( $action ) ) {
            if ( substr ( $action , 0 , 1 ) != "/" ) {
                $action = "/" . $action;
            }
            $_index_file_name = INDEX_FILE_URI;
            $_url             = $_index_file_name . '?url=' . $action;
            if ( ( ! empty( $params ) ) && ( is_array ( $params ) ) ) {
                foreach ( $params as $k => $v ) {
                    if ( is_string ( $k ) && ( ! Class_Base_Format::is_integer ( $k ) ) ) {
                        $_url .= '&' . $k . '=' . urlencode ( $v );
                    }
                }
            }
            $_url .= '&rand=' . rand ( 100000000000000000 , 999999999999999999 );
            $_url .= '&csrf=' . ( empty( $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] ) ? ( $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] = ( time () . rand ( 10000000 , 99999999 ) ) ) : $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] );
            $_url .= '&debug=' . ( empty( $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] ) ? ( 0 ) : ( $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] ) );
            return $_url;
        }
        return null;
    }

    public static function get_url ( $action , $params = null )
    {
        if ( ! empty( $action ) ) {
            $_url = self::_get_url ( $action , $params );
            if ( ! empty( $_url ) ) {
                return $_url;
            }
        }
        return null;
    }

    public static function get_cli_url ( $action , $params = null )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ! empty( $action ) ) {
            if ( substr ( $action , 0 , 1 ) != "/" ) {
                $action = "/" . $action;
            }
            $_index = 0;
            $_url   = ( $action . '?' );
            if ( ( ! empty( $params ) ) && ( is_array ( $params ) ) ) {
                foreach ( $params as $k => $v ) {
                    if ( is_string ( $k ) && ( ! Class_Base_Format::is_integer ( $k ) ) ) {
                        if ( $_index == 0 ) {
                            $_url .= ( $k . '=' . urlencode ( $v ) );
                        } else {
                            $_url .= ( '&' . $k . '=' . urlencode ( $v ) );
                        }
                        $_index ++;
                    }
                }
            }
            if ( empty( $params ) ) {
                $_url .= 'security_token=' . ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_SECURITY_TOKEN" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_SECURITY_TOKEN" ] ) );
            } else {
                $_url .= '&security_token=' . ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_SECURITY_TOKEN" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_SECURITY_TOKEN" ] ) );
            }
            if ( ! in_array ( $action , self::$_cli_check_enable_license_agreement_filters ) ) {
                $_url .= '&is_enable_license_agreement=' . ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_ENABLE_LICENSE_AGREEMENT" ] ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_ENABLE_LICENSE_AGREEMENT" ] ) );
            }
            $_url .= '&debug=1';
            return $_url;
        }
        return null;
    }

    public static function get_urlencode ( $_cli_url )
    {
        $_cli_encode_url = urlencode ( $_cli_url );
        return $_cli_encode_url;
    }

    public static function get_encode_cli_url ( $action , $params = null )
    {
        $_cli_url        = self::get_cli_url ( $action , $params );
        $_cli_encode_url = self::get_urlencode ( $_cli_url );
        return $_cli_encode_url;
    }

    public static function redirect ( $action , $params = null )
    {
        if ( ! is_cli () ) {
            if ( ! empty( $action ) ) {
                $_url = self::get_url ( $action , $params );
                if ( ! empty( $_url ) ) {
                    @header ( "Location: $_url" );
                }
            }
        }
    }

    public static function output_console_log ( $content )
    {
        $content         = urlencode ( $content );
        $_js_console_log = '<script type="text/javascript">console.log(urldecode("' . str_replace ( "\t" , '\t' , str_replace ( "\"" , "\\\"" , $content ) ) . '")+"\n");</script>';
        self::output ( $_js_console_log , "text" , 0 );
    }

    public static function output_textarea_inner_html ( $id , $content , $flag = self::FLAG_JS_CONTENT_INNER_HTML_COVER )
    {
        $content = urlencode ( $content );
        if ( $flag == self::FLAG_JS_CONTENT_INNER_HTML_APPEND ) {
            $_js_div_inner_html = '<script type="text/javascript">window.document.getElementById("' . str_replace ( "\"" , "\\\"" , $id ) . '").innerHTML+=(urldecode("' . $content . '"))+"\n";</script>';
        } else {
            $_js_div_inner_html = '<script type="text/javascript">window.document.getElementById("' . str_replace ( "\"" , "\\\"" , $id ) . '").innerHTML=(urldecode("' . $content . '"))+"\n";</script>';
        }
        self::output ( $_js_div_inner_html , "text" , 0 );
    }

    public static function output_div_inner_html ( $id , $content , $flag = self::FLAG_JS_CONTENT_INNER_HTML_COVER )
    {
        $content = urlencode ( $content );
        if ( $flag == self::FLAG_JS_CONTENT_INNER_HTML_APPEND ) {
            $_js_div_inner_html = '<script type="text/javascript">window.document.getElementById("' . str_replace ( "\"" , "\\\"" , $id ) . '").innerHTML+="<div>"+urldecode("' . str_replace ( "\t" , '\t' , str_replace ( "\"" , "\\\"" , $content ) ) . '")+"</div></br>";</script>';
        } else {
            $_js_div_inner_html = '<script type="text/javascript">window.document.getElementById("' . str_replace ( "\"" , "\\\"" , $id ) . '").innerHTML=urldecode("' . str_replace ( "\t" , '\t' , str_replace ( "\"" , "\\\"" , $content ) ) . '");</script>';
        }
        self::output ( $_js_div_inner_html , "text" , 1 );
    }

    public static function output_link_label ( $href , $id , $title , $description = "" , $style = "" )
    {
        Class_Base_Response::outputln ( '<a id="' . Class_Base_Format::htmlentities ( $id ) . '" style="font-size:18px;' . Class_Base_Format::htmlentities ( $style ) . '" href="' . Class_Base_Format::htmlentities ( $href ) . '" title="' . Class_Base_Format::htmlentities ( $description ) . '">' . Class_Base_Format::htmlentities ( $title ) . '</a>' );
    }

    public static function check_browser_service_stop ()
    {
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
            echo ( "" );
            flush ();
            if ( connection_aborted () ) {
                throw new \Exception( "Client browser disconnected ! " , Class_Base_Error::NETWORK_EXCEPTION_CLIENT_DISCONNECTED );
            }
        }
    }
}