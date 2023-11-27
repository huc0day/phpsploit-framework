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

class Class_View_Bottom
{
    private static $_bottom = null;

    private static function _init ()
    {
        if ( empty( self::$_bottom ) ) {
            self::$_bottom = array (
                "menu"    => array (
                    array (
                        "title"    => "" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/index" , array ( "rand" => time () ) ) ,
                    ) ,
                ) ,
                "content" => "" ,
            );
        }
    }

    public static function bottom ( $menu = array ( array ( "title" => "" , "describe" => "" , "href" => "#" , ) , ) , $content = "" , $javascript = '<script type="text/javascript">function init(){ console.log("Page loading completed ! "); }function submit(form_object){ return true;}</script>' )
    {
        self::_init ();
        if ( is_array ( $menu ) ) {
            if ( ! empty( $menu ) ) {
                foreach ( $menu as $index => $item ) {
                    if ( ! is_array ( $menu[ $index ] ) ) {
                        $menu[ $index ] = array ( "title" => "" , "describe" => "" , "href" => "#" );
                    }
                    if ( ! isset( $menu[ $index ][ "title" ] ) ) {
                        $menu[ $index ][ "title" ] = "";
                    }
                    if ( ! isset( $menu[ $index ][ "describe" ] ) ) {
                        $menu[ $index ][ "describe" ] = "";
                    }
                    if ( ! isset( $menu[ $index ][ "href" ] ) ) {
                        $menu[ $index ][ "href" ] = "#";
                    }
                }
                self::$_bottom[ "menu" ] = $menu;
            }
        }
        if ( is_string ( $content ) ) {
            self::$_bottom[ "content" ] = $content;
        }
        if ( is_string ( $content ) ) {
            self::$_bottom[ "javascript" ] = $javascript;
        }
        return self::$_bottom;
    }
}