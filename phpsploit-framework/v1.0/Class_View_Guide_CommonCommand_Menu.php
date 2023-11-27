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

class Class_View_Guide_CommonCommand_Menu
{
    private static $_menu = null;

    public static function menu ( $params = array () )
    {
        if ( ! is_array ( $params ) ) {
            $params = array ();
        }

        if ( empty( self::$_menu ) ) {
            self::$_menu = array (
                array (
                    "title"    => "user_commands" ,
                    "describe" => "user_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/user_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "elf_commands" ,
                    "describe" => "elf_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/elf_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "system_commands" ,
                    "describe" => "system_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/system_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "file_commands" ,
                    "describe" => "file_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/file_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "hardware_commands" ,
                    "describe" => "hardware_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/hardware_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "software_commands" ,
                    "describe" => "software_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/software_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "network_commands" ,
                    "describe" => "network_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/network_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "firewall_commands" ,
                    "describe" => "firewall_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/firewall_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "webserver_commands" ,
                    "describe" => "webserver_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/webserver_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "docker_commands" ,
                    "describe" => "docker_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/docker_commands" , array () ) ,
                ) ,
                array (
                    "title"    => "penetration_test_commands" ,
                    "describe" => "penetration_test_commands" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands" , array () ) ,
                ) ,
            );
        }
        return self::$_menu;
    }
}