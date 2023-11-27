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

class Class_View_Guide_PenetrationTestCommands_Menu extends Class_View
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
                    "title"    => "information_gathering " ,
                    "describe" => "Information Gathering " ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/information_gathering" , array () ) ,
                ) ,
                array (
                    "title"    => "vulnerability_analysis" ,
                    "describe" => "vulnerability analysis" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/vulnerability_analysis" , array () ) ,
                ) ,
                array (
                    "title"    => "web_program" ,
                    "describe" => "web program" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/web_program" , array () ) ,
                ) ,
                array (
                    "title"    => "database_evaluation" ,
                    "describe" => "database evaluation" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/database_evaluation" , array () ) ,
                ) ,
                array (
                    "title"    => "password_attack" ,
                    "describe" => "password attack" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/password_attack" , array () ) ,
                ) ,
                array (
                    "title"    => "wireless_attacks" ,
                    "describe" => "wireless attacks" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/wireless_attacks" , array () ) ,
                ) ,
                array (
                    "title"    => "reverse_engineering" ,
                    "describe" => "reverse engineering" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/reverse_engineering" , array () ) ,
                ) ,
                array (
                    "title"    => "vulnerability_exploitation" ,
                    "describe" => "vulnerability exploitation" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/vulnerability_exploitation" , array () ) ,
                ) ,
                array (
                    "title"    => "sniff_deception" ,
                    "describe" => "sniff deception" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/sniff_deception" , array () ) ,
                ) ,
                array (
                    "title"    => "permission_maintenance" ,
                    "describe" => "permission maintenance" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/permission_maintenance" , array () ) ,
                ) ,
                array (
                    "title"    => "data_forensics" ,
                    "describe" => "data forensics" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/data_forensics" , array () ) ,
                ) ,
                array (
                    "title"    => "reporting" ,
                    "describe" => "reporting" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/reporting" , array () ) ,
                ) ,
                array (
                    "title"    => "social_engineering" ,
                    "describe" => "social engineering" ,
                    "href"     => Class_Base_Response::get_url ( "/guide/penetration_test_commands/social_engineering" , array () ) ,
                ) ,
            );
        }
        return self::$_menu;
    }
}