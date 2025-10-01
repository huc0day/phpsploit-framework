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

class Class_View_Security_Menu
{
    private static $_menus = null;

    public static function menu ( $params = array () )
    {
        if ( ! is_array ( $params ) ) {
            $params = array ();
        }
        if ( ( ! isset( $params[ "encode" ] ) ) || ( ! is_array ( $params[ "encode" ] ) ) ) {
            $params[ "encode" ] = array ();
        }
        if ( ( ! isset( $params[ "encode" ][ "string" ] ) ) || ( ! is_string ( $params[ "encode" ][ "string" ] ) ) ) {
            $params[ "encode" ][ "string" ] = "";
        }
        if ( ( ! isset( $params[ "decode" ] ) ) || ( ! is_array ( $params[ "decode" ] ) ) ) {
            $params[ "decode" ] = array ();
        }
        if ( ( ! isset( $params[ "decode" ][ "string" ] ) ) || ( ! is_string ( $params[ "decode" ][ "string" ] ) ) ) {
            $params[ "decode" ][ "string" ] = "";
        }
        if ( empty( self::$_menus ) ) {
            self::$_menus = array (
                array (
                    "title"    => "url" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/url" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "base64" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/base64" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "sha1" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/sha1" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "md5" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/md5" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "crc32" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/crc32" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "crypt" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/crypt" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "openssl" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/openssl" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "hash" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/hash" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "password_hash" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/password_hash" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
                array (
                    "title"    => "sodium" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/security/sodium" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
                ) ,
            );
        }
        foreach ( self::$_menus as $index => $menu ) {
            if ( strtoupper ( substr ( PHP_OS , 0 , 3 ) ) === 'WIN' ) {
                if ( $menu[ "title" ] == "sodium" ) {
                    self::$_menus[ $index ] = null;
                    unset( self::$_menus[ $index ] );
                }
            }
        }
        if ( PHP_VERSION_ID >= 70200 ) {
            self::$_menus[] = array (
                "title"    => "hash_hmac" ,
                "describe" => "" ,
                "href"     => Class_Base_Response::get_url ( "/security/hash_hmac" , array ( "string" => $params[ "encode" ][ "string" ] , ) ) ,
            );
        }
        return self::$_menus;
    }
}