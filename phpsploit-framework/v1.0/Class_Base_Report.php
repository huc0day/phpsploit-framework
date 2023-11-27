<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-11
 * Time: 下午6:37
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

class Class_Base_Report extends Class_Base
{
    public static function output_mime_xls_header ( $file_name = null )
    {
        if ( is_null ( $file_name ) ) {
            $file_name = time ();
        }
        if ( ! is_string ( $file_name ) ) {
            $file_name = strval ( $file_name );
        }
        header ( 'Pragma:public' );
        header ( 'Expires:0' );
        header ( 'Cache-Control:must-revalidate,post-check=0,pre-check=0' );
        header ( 'Content-Type:application/force-download' );
        header ( 'Content-Type:application/octet-stream' );
        header ( 'Content-Type:application/download' );
        header ( 'Content-Disposition:attachment,filename=' . ( $file_name ) . '.xls' );
        header ( 'Content-Transfer-Encoding:binary' );
    }

    public static function output_xls_file_content ( $file_name = null , $map = array () )
    {
        self::output_mime_xls_header ( $file_name );
        echo ( self::get_xls_content ( $map ) );
    }

    public static function get_xls_content ( $map )
    {
        $_xls_bof     = self::get_xls_bof_flag_content ();
        $_xls_eof     = self::get_xls_eof_flag_content ();
        $_xls_content = $_xls_bof;
        $_field_names = null;
        if ( ( ! empty( $map ) ) && ( is_array ( $map ) ) ) {
            foreach ( $map as $map_index => $fields ) {
                if ( ( ! empty( $fields ) ) && ( is_array ( $fields ) ) ) {
                    if ( is_null ( $_field_names ) ) {
                        $_field_names = array_keys ( $fields );
                        foreach ( $_field_names as $name_index => $name ) {
                            $_xls_content .= self::get_xls_string_field_content ( 0 , $name_index , $name );
                        }
                    }
                    $_values = array_values ( $fields );
                    foreach ( $_values as $value_index => $field_value ) {
                        if ( is_bool ( $field_value ) || is_numeric ( $field_value ) || is_integer ( $field_value ) || is_float ( $field_value ) || is_double ( $field_value ) ) {
                            if ( is_bool ( $field_value ) ) {
                                $field_value = ( ( $field_value === false ) ? 0 : 1 );
                            }
                            $_xls_content .= self::get_xls_number_field_content ( ( $map_index + 1 ) , ( $value_index ) , $field_value );
                        } else {
                            if ( is_array ( $field_value ) ) {
                                $field_value = json_encode ( $field_value );
                            } else if ( is_object ( $field_value ) ) {
                                $field_value = json_encode ( $field_value );
                            } else {
                                $field_value = strval ( $field_value );
                            }
                            $_xls_content .= self::get_xls_string_field_content ( ( $map_index + 1 ) , ( $value_index ) , $field_value );
                        }
                    }
                }
            }
        }
        $_xls_content .= $_xls_eof;
        return $_xls_content;
    }

    public static function get_xls_bof_flag_content ()
    {
        $_xls_bof = pack ( "ssssss" , 0x809 , 0x8 , 0x0 , 0x10 , 0x0 , 0x0 );
        return $_xls_bof;
    }

    public static function get_xls_eof_flag_content ()
    {
        $_xls_bof = pack ( "ss" , 0x0a , 0x00 );
        return $_xls_bof;
    }

    public static function get_xls_number_field_content ( $rows_index , $cols_index , $value )
    {
        $_xls_number_field_content = ( pack ( "sssss" , 0x203 , 14 , $rows_index , $cols_index , 0x0 ) . pack ( "d" , $value ) );
        return $_xls_number_field_content;
    }

    public static function get_xls_string_field_content ( $rows_index , $cols_index , $value )
    {
        $_byte_size  = 8;
        $_value_size = strlen ( $value );

        $_xls_string_field_content = ( pack ( "ssssss" , 0x204 , ( $_byte_size + $_value_size ) , $rows_index , $cols_index , 0x0 , ( $_value_size ) ) . ( $value ) );
        return $_xls_string_field_content;
    }

    public static function output_vulnerability_report_content ( $array = array () )
    {
        self::output_mime_xls_header ();
        echo self::get_vulnerability_report_content ( $array );
    }

    public static function get_vulnerability_report_content ( $array = array () )
    {
        if ( ! is_array ( $array ) ) {
            $array = array ();
        }
        foreach ( $array as $index => $item ) {

        }
    }

    public static function get_word_content_header ()
    {
        $_word_content_header = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns= "http://www.w3.org/TR/REC-html40">';
        return $_word_content_header;
    }

    public static function get_word_content_body ( $content )
    {
        return $content;
    }

    public static function get_word_content_footer ()
    {
        $_word_content_footer = '"</html>';
        return $_word_content_footer;
    }

    public static function get_word_content ( $content )
    {
        $_word_content_header = self::get_word_content_header ();
        $_word_content_body   = self::get_word_content_body ( $content );
        $_word_content_footer = self::get_word_content_footer ();
        $_word_content        = ( $_word_content_header . $_word_content_body . $_word_content_footer );
        return $_word_content;
    }
}








