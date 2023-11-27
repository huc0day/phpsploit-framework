<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-8
 * Time: 下午3:40
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

class Class_View_File_Menu
{
    private static $_menu = null;

    public static function menu ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( ! is_array ( $params ) ) {
            $params = array ();
        }
        if ( ( ! isset( $params[ "search" ] ) ) || ( ! is_array ( $params[ "search" ] ) ) ) {
            $params[ "search" ] = array ();
        }
        if ( ( ! isset( $params[ "search" ][ "file_name" ] ) ) || ( ! is_string ( $params[ "search" ][ "file_name" ] ) ) ) {
            $params[ "search" ][ "file_name" ] = "";
        }
        if ( ( ! isset( $params[ "search" ][ "current_directory_path" ] ) ) || ( ! is_string ( $params[ "search" ][ "current_directory_path" ] ) ) ) {
            $params[ "search" ][ "current_directory_path" ] = str_replace ( "\\" , "/" , $_SERVER[ "DOCUMENT_ROOT" ] );
        }
        if ( ( ! isset( $params[ "explorer" ] ) ) || ( ! is_array ( $params[ "explorer" ] ) ) ) {
            $params[ "explorer" ] = array ();
        }
        if ( ( ! isset( $params[ "explorer" ][ "current_directory_path" ] ) ) || ( ! is_string ( $params[ "explorer" ][ "current_directory_path" ] ) ) ) {
            $params[ "explorer" ][ "current_directory_path" ] = str_replace ( "\\" , "/" , $_SERVER[ "DOCUMENT_ROOT" ] );
        }
        if ( ( ! isset( $params[ "create" ] ) ) || ( ! is_array ( $params[ "create" ] ) ) ) {
            $params[ "create" ] = array ();
        }
        if ( ( ! isset( $params[ "create" ][ "current_directory_path" ] ) ) || ( ! is_string ( $params[ "create" ][ "current_directory_path" ] ) ) ) {
            $params[ "create" ][ "current_directory_path" ] = "";
        }
        if ( ( ! isset( $params[ "create" ][ "new_file_name" ] ) ) || ( ! is_string ( $params[ "create" ][ "new_file_name" ] ) ) ) {
            $params[ "create" ][ "new_file_name" ] = "";
        }
        if ( ( ! isset( $params[ "create" ][ "data_type" ] ) ) || ( ! Class_Base_Format::is_integer ( ( $params[ "create" ][ "data_type" ] ) ) ) ) {
            $params[ "create" ][ "data_type" ] = Class_Base_Format::TYPE_DATA_TEXT;
        }
        if ( ( ! isset( $params[ "create" ][ "file_content" ] ) ) || ( ! is_string ( $params[ "create" ][ "file_content" ] ) ) ) {
            $params[ "create" ][ "file_content" ] = '';
        }
        if ( ( ! isset( $params[ "upload" ] ) ) || ( ! is_array ( $params[ "upload" ] ) ) ) {
            $params[ "upload" ] = array ();
        }
        if ( ( ! isset( $params[ "upload" ][ "current_directory_path" ] ) ) || ( ! is_string ( $params[ "upload" ][ "current_directory_path" ] ) ) ) {
            $params[ "upload" ][ "current_directory_path" ] = "";
        }
        if ( ( ! isset( $params[ "clear" ] ) ) || ( ! is_array ( $params[ "clear" ] ) ) ) {
            $params[ "clear" ] = array ();
        }
        if ( ( ! isset( $params[ "clear" ][ "file_name" ] ) ) || ( ! is_string ( $params[ "clear" ][ "file_name" ] ) ) ) {
            $params[ "clear" ][ "file_name" ] = "";
        }
        if ( ( ! isset( $params[ "clear" ][ "current_directory_path" ] ) ) || ( ! is_string ( $params[ "clear" ][ "current_directory_path" ] ) ) ) {
            $params[ "clear" ][ "current_directory_path" ] = str_replace ( "\\" , "/" , $_SERVER[ "DOCUMENT_ROOT" ] );
        }

        if ( empty( self::$_menu ) ) {
            self::$_menu = array (
                array (
                    "title"    => "search" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/file/search" , array ( "rand" => time () , "current_directory_path" => $params[ "search" ][ "current_directory_path" ] , "file_name" => $params[ "search" ][ "file_name" ] ) ) ,
                ) ,
                array (
                    "title"    => "explorer" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/file/explorer" , array ( "rand" => time () , "current_directory_path" => $params[ "explorer" ][ "current_directory_path" ] ) ) ,
                ) ,
                array (
                    "title"    => "create" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/file/create" , array ( "rand" => time () , "current_directory_path" => $params[ "create" ][ "current_directory_path" ] , "data_type" => $params[ "create" ][ "data_type" ] ) ) ,
                ) ,
                array (
                    "title"    => "upload" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/file/upload" , array ( "rand" => time () , "current_directory_path" => $params[ "upload" ][ "current_directory_path" ] , ) ) ,
                ) ,
                array (
                    "title"    => "clear" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/file/clear" , array ( "rand" => time () , "current_directory_path" => $params[ "clear" ][ "current_directory_path" ] , "file_name" => $params[ "clear" ][ "file_name" ] ) ) ,
                ) ,
            );
        }
        return self::$_menu;
    }
}