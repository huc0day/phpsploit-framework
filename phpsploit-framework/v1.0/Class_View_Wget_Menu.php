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

class Class_View_Wget_Menu
{
    private static $_menu = null;

    public static function menu ( $params = array () )
    {
        if ( ! is_array ( $params ) ) {
            $params = array ();
        }
        if ( ( ! isset( $params[ "wget" ] ) ) || ( ! is_array ( $params[ "wget" ] ) ) ) {
            $params[ "wget" ] = array ();
        }
        if ( ( ! isset( $params[ "wget" ][ "timeout" ] ) ) || ( ! is_integer ( $params[ "wget" ][ "timeout" ] ) ) ) {
            $params[ "wget" ][ "timeout" ] = 60;
        }
        if ( ( ! isset( $params[ "wget" ][ "display_progress" ] ) ) || ( ! is_integer ( $params[ "wget" ][ "display_progress" ] ) ) ) {
            $params[ "wget" ][ "display_progress" ] = 1;
        }
        if ( ( ! isset( $params[ "wget" ][ "file_url" ] ) ) || ( ! is_string ( $params[ "wget" ][ "file_url" ] ) ) ) {
            $params[ "wget" ][ "file_url" ] = "";
        }
        if ( ( ! isset( $params[ "wget" ][ "save_directory_path" ] ) ) || ( ! is_string ( $params[ "wget" ][ "save_directory_path" ] ) ) ) {
            $params[ "wget" ][ "save_directory_path" ] = "";
        }

        if ( empty( self::$_menu ) ) {
            self::$_menu = array (
                array (
                    "title"    => "wget" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/wget" , array ( "timeout" => $params[ "wget" ][ "timeout" ] , "display_progress" => $params[ "wget" ][ "display_progress" ] , "file_url" => urlencode ( $params[ "wget" ][ "file_url" ] ) , "save_directory_path" => $params[ "wget" ][ "save_directory_path" ] , ) ) ,
                ) ,
            );
        }
        return self::$_menu;
    }
}