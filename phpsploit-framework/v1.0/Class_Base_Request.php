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

class Class_Base_Request extends Class_Base implements Interface_Base_Request
{
    const TYPE_DATA_TEXT = 10000001;
    const TYPE_DATA_BIN  = 10000002;
    const TYPE_UNKNOWN   = 0;
    const TYPE_STRING    = 1001;
    const TYPE_INTEGER   = 1002;
    const VALUE_UNKNOWN  = null;
    const VALUE_STRING   = "";
    const VALUE_INTEGER  = 0;

    private static $_params = null;

    public static function init ( $timeout = 60 )
    {
        set_time_limit ( $timeout );
    }

    public static function init_form ()
    {
        if ( is_null ( self ::$_params ) || ( ! is_array ( self ::$_params ) ) ) {
            self ::$_params = $_REQUEST;
        }
    }

    public static function create_password ()
    {
        $_password = "";
        for ( $i = 0 ; $i < 18 ; $i ++ ) {
            $_password .= chr ( rand ( 33 , 126 ) );
        }
        return $_password;
    }

    public static function create_security_code ()
    {
        $_password = "";
        for ( $i = 0 ; $i < 18 ; $i ++ ) {
            $_password .= chr ( rand ( 33 , 126 ) );
        }
        return $_password;
    }

    public static function form ( $name , $type = self::TYPE_UNKNOWN , $value = self::VALUE_UNKNOWN )
    {
        self ::init_form ();
        if ( ! isset( self ::$_params[ $name ] ) ) {
            $_value = null;
            if ( $type == self::TYPE_INTEGER ) {
                $_value = intval ( $value );
            }
            if ( $type == self::TYPE_STRING ) {
                $_value = strval ( $value );
            }
            return $_value;
        }
        $_value = self ::$_params[ $name ];
        if ( $type == self::TYPE_INTEGER ) {
            $_value = intval ( self ::$_params[ $name ] );
        }
        if ( $type == self::TYPE_STRING ) {
            $_value = strval ( self ::$_params[ $name ] );
        }
        return $_value;
    }

    public static function form_md5 ( $name , $security_code = null )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            if ( is_null ( $security_code ) ) {
                $_md5 = md5 ( self ::$_params[ $name ] );
            } else {
                $_md5 = md5 ( self ::$_params[ $name ] . $security_code );
            }
            return $_md5;
        }
        return null;
    }

    public static function form_boolean ( $name )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            return boolval ( self ::$_params[ $name ] );
        }
        return null;
    }

    public static function form_int ( $name )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            return intval ( self ::$_params[ $name ] );
        }
        return null;
    }

    public static function form_float ( $name )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            return floatval ( self ::$_params[ $name ] );
        }
        return null;
    }

    public static function form_double ( $name )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            return doubleval ( self ::$_params[ $name ] );
        }
        return null;
    }

    public static function form_string ( $name )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            return strval ( self ::$_params[ $name ] );
        }
        return null;
    }

    public static function form_array ( $name )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            return json_decode ( self ::$_params[ $name ] , true );
        }
        return null;
    }

    public static function form_object ( $name )
    {
        self ::init_form ();
        if ( isset( self ::$_params[ $name ] ) ) {
            return json_decode ( self ::$_params[ $name ] );
        }
        return null;
    }

    public static function get_save_directory_path ( $save_directory_path )
    {
        if ( is_null ( $save_directory_path ) ) {
            $save_directory_path = "./";
        }
        if ( ! is_string ( $save_directory_path ) ) {
            $save_directory_path = "./";
        }
        if ( strlen ( $save_directory_path ) <= 0 ) {
            $save_directory_path = "./";
        }
        if ( ( ! file_exists ( $save_directory_path ) ) || ( ! is_dir ( $save_directory_path ) ) ) {
            $save_directory_path = "./";
        }
        $save_directory_path = realpath ( $save_directory_path );
        return $save_directory_path;
    }

    public static function send ( $url , $data = array () , $files = array () , $is_download = false , $save_directory_path = null , $display_progress = 1 , $search_progress_id = "search_progress_id" , $search_errors_id = "search_errors_id" , $search_result_id = "search_result_id" )
    {
        if ( ( ! is_string ( $url ) ) || ( strlen ( $url ) <= 0 ) || ( ! is_array ( $data ) ) || ( ! is_array ( $files ) ) || ( ! is_bool ( $is_download ) ) ) {
            return false;
        }
        $save_directory_path = self ::get_save_directory_path ( $save_directory_path );
        if ( $save_directory_path === false ) {
            return false;
        }

        $ch = curl_init ();

        curl_setopt ( $ch , CURLOPT_SSL_VERIFYHOST , FALSE );
        curl_setopt ( $ch , CURLOPT_SSL_VERIFYPEER , FALSE );

        curl_setopt ( $ch , CURLOPT_URL , $url );

        if ( ! empty( $data ) ) {
            curl_setopt ( $ch , CURLOPT_POST , true );
            curl_setopt ( $ch , CURLOPT_POSTFIELDS , $data );
        }
        if ( ! empty( $files ) ) {
            foreach ( $files as $index => $file ) {
                $files[ $index ] = new CURLFile( $file );
            }
        }

        curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , true );

        if ( ! empty( $is_download ) ) {

            $start_time = time ();
            $size       = 0;
            $rate       = 0;
            $flag       = 0;
            $_filename  = self ::filename ( $url );
            $_extname   = self ::extname ( $_filename );
            $_filename  = ( ( is_null ( $_filename ) ) || ( $_filename == "" ) ) ? ( "_." . time () . ".phpsploit" ) : ( $_filename . "." . time () . ".phpsploit" . ( ( is_string ( $_extname ) && ( strlen ( $_extname ) > 0 ) ) ? ( chr ( 46 ) . $_extname ) : ( "" ) ) );

            curl_setopt ( $ch , CURLOPT_WRITEFUNCTION , function ( $ch , $str ) use ( &$flag , &$size , &$rate , &$url , &$_filename , &$save_directory_path , &$display_progress , &$start_time , &$search_progress_id , &$search_errors_id , &$search_result_id ) {

                try {
                    Class_Base_Response ::check_browser_service_stop ();
                } catch ( \Throwable $e ) {
                    Class_Base_Response ::outputln ( $e );
                    exit( 1 );
                }

                $len = strlen ( $str );

                if ( $rate == 0 ) {

                    $size = curl_getinfo ( $ch , CURLINFO_CONTENT_LENGTH_DOWNLOAD );

                    $type = curl_getinfo ( $ch , CURLINFO_CONTENT_TYPE );

                    $httpcode = curl_getinfo ( $ch , CURLINFO_HTTP_CODE );
                }

                $rate += $len;

                if ( ( file_exists ( $save_directory_path ) ) && ( is_dir ( $save_directory_path ) ) ) {
                    $_filepath = $save_directory_path . "/" . $_filename;
                    file_put_contents ( $_filepath , $str , FILE_APPEND | LOCK_EX );
                    if ( ! empty( $display_progress ) ) {
                        if ( ! is_cli () ) {
                            Class_Base_Response ::output_div_inner_html ( $search_progress_id , ( "file path : " . $_filepath . " , file size : " . $size . " , rate : " . $rate . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                        } else {
                            Class_Base_Response ::outputln ( "Download progress in file path : " . $_filepath . " , file size : " . $size . " , rate : " . $rate . "\n" );
                        }
                    }
                    if ( $rate >= $size ) {
                        $_end_time  = time ();
                        $_exec_time = ( $_end_time - $start_time );
                        if ( file_exists ( $_filepath ) && ( is_file ( $_filepath ) ) ) {
                            $_file_size = Class_Base_File ::get_file_size ( $_filepath );
                            $_file_type = Class_Base_File ::get_mime_content_type ( $_filepath );
                            if ( ! is_cli () ) {
                                Class_Base_Response ::output_div_inner_html ( $search_result_id , ( "\n" . 'File download completed, taking ' . $_exec_time . ' seconds, file size ( ' . $_file_size . ' bytes ), file type ( ' . $_file_type . ' ), file save path ( <a href="' . Class_Base_Format ::htmlentities ( Class_Base_Response ::get_url ( "/file/detail" , array ( "file_path" => $_filepath ) ) ) . '">' . $_filepath . '</a> ) . ' . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                            } else {
                                Class_Base_Response ::outputln ( "\n" . 'File download completed, taking ' . $_exec_time . ' seconds, file size ( ' . $_file_size . ' bytes ), file type ( ' . $_file_type . ' ), file save path ( ' . $_filepath . ' ) . ' . "\n" );
                            }
                        } else {
                            if ( ! is_cli () ) {
                                Class_Base_Response ::output_div_inner_html ( $search_errors_id , ( "\n" . '<span style="color:red;">File download failed, took ( ' . $_exec_time . ' seconds), download data size ( ' . $size . ' bytes) , downloaded data size ( ' . $rate . ' bytes)</span>' . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                            } else {
                                Class_Base_Response ::outputln ( "\n" . 'File download failed, took ( ' . $_exec_time . ' seconds), download data size ( ' . $size . ' bytes) , downloaded data size ( ' . $rate . ' bytes)' . "\n" );
                            }
                        }
                        return $len;
                    }
                }
                return $len;
            } );
        }
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }

    public static function filename ( $url )
    {
        $url      = str_replace ( "\\" , "/" , $url );
        $position = strripos ( $url , '/' );
        if ( $position === false ) {
            $position = 0;
        }
        if ( $position == ( strlen ( $url ) - 1 ) ) {
            return null;
        }
        $filename = substr ( $url , ( $position + 1 ) , ( strlen ( $url ) - ( $position + 1 ) ) );
        return $filename;
    }

    public static function extname ( $filename )
    {
        $position = strripos ( $filename , '.' );
        if ( $position === false ) {
            return null;
        }
        if ( $position == ( strlen ( $filename ) - 1 ) ) {
            return null;
        }
        $extname = substr ( $filename , ( $position + 1 ) , ( strlen ( $filename ) - ( $position + 1 ) ) );

        return $extname;
    }

    public static function create_folder ( $name = "tmp" )
    {
        $name = str_replace ( "\\" , "/" , $name );
        while ( strpos ( $name , "../" ) !== false ) {
            $name = str_replace ( "../" , "" , $name );
        }
        if ( $name == "" ) {
            $name = time ();
        }
        if ( substr ( $name , 0 , 1 ) == "/" ) {
            if ( strlen ( $name ) == 1 ) {
                $name = time ();
            } else {
                $name = substr ( $name , 1 );
            }
        }
        $name = "./" . $name;
        if ( file_exists ( $name ) && is_dir ( $name ) ) {
            return $name;
        }
        $bool = mkdir ( $name , 0700 , true );
        if ( ! $bool ) {
            return null;
        }
        return $name;
    }

}