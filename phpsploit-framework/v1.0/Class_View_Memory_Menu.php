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

class Class_View_Memory_Menu
{
    private static $_menu = null;

    public static function menu ()
    {
        if ( empty( self::$_menu ) ) {
            self::$_menu = array (
                array (
                    "title"    => "system" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/memory/system" , array ( "rand" => time () ) ) ,
                ) ,
                array (
                    "title"    => "search" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/memory/search" , array ( "rand" => time () ) ) ,
                ) ,
                array (
                    "title"    => "list" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/memory/list" , array ( "rand" => time () ) ) ,
                ) ,
                array (
                    "title"    => "add" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/memory/add" , array ( "rand" => time () ) ) ,
                ) ,
                array (
                    "title"    => "clear" ,
                    "describe" => "" ,
                    "href"     => 'javascript:if(confirm("Are you sure you want to perform the operation of clearing shared memory? Note that after clearing, all discovered and operable shared memory resources will be cleared and released! Execute clear (select \'OK\'), discard clear (select \'Cancel\').")){document.location.href="' . Class_Base_Response::get_url ( "/memory/clear" , array ( "rand" => time () ) ) . '";}' ,
                ) ,
            );
        }
        return self::$_menu;
    }
}