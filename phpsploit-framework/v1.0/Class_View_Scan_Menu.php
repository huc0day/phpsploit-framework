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

class Class_View_Scan_Menu
{
    private static $_menu = null;

    public static function menu ( $params = array () )
    {
        if ( ! is_array ( $params ) ) {
            $params = array ();
        }
        if ( ( ! isset( $params[ "webs" ] ) ) || ( ! is_array ( $params[ "webs" ] ) ) ) {
            $params[ "webs" ] = array ();
        }
        if ( ( ! isset( $params[ "webs" ][ "urls" ] ) ) || ( ! is_string ( $params[ "webs" ][ "urls" ] ) ) ) {
            $params[ "webs" ][ "urls" ] = "";
        }
        if ( ( ! isset( $params[ "domain" ] ) ) || ( ! is_array ( $params[ "domain" ] ) ) ) {
            $params[ "domain" ] = array ();
        }
        if ( ( ! isset( $params[ "domain" ][ "ip" ] ) ) || ( ! is_string ( $params[ "domain" ][ "ip" ] ) ) ) {
            $params[ "domain" ][ "ip" ] = "";
        }
        if ( ( ! isset( $params[ "domain" ][ "ports" ] ) ) || ( ! is_string ( $params[ "domain" ][ "ports" ] ) ) ) {
            $params[ "domain" ][ "ports" ] = "";
        }
        if ( ( ! isset( $params[ "tamperproof" ] ) ) || ( ! is_array ( $params[ "tamperproof" ] ) ) ) {
            $params[ "tamperproof" ] = array ();
        }
        if ( ( ! isset( $params[ "tamperproof" ][ "sampling_directory_path" ] ) ) || ( ! is_string ( $params[ "tamperproof" ][ "sampling_directory_path" ] ) ) ) {
            $params[ "tamperproof" ][ "sampling_directory_path" ] = "";
        }
        if ( ( ! isset( $params[ "tamperproof" ][ "detection_directory_path" ] ) ) || ( ! is_string ( $params[ "tamperproof" ][ "detection_directory_path" ] ) ) ) {
            $params[ "tamperproof" ][ "detection_directory_path" ] = "";
        }
        if ( empty( self::$_menu ) ) {
            self::$_menu = array (
                array (
                    "title"    => "webs" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/scan/webs" , array ( "urls" => $params[ "webs" ][ "urls" ] , ) ) ,
                ) ,
                array (
                    "title"    => "domain" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/scan/domain" , array ( "ip" => $params[ "domain" ][ "ip" ] , "ports" => $params[ "domain" ][ "ports" ] ) ) ,
                ) ,
                array (
                    "title"    => "tamperproof" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/scan/tamperproof" , array ( "sampling_directory_path" => $params[ "tamperproof" ][ "sampling_directory_path" ] , "detection_directory_path" => $params[ "tamperproof" ][ "detection_directory_path" ] ) ) ,
                ) ,
            );
        }
        return self::$_menu;
    }
}