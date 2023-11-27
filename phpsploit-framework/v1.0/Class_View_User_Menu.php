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

class Class_View_User_Menu
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
                    "title"    => "user_info" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/user/user_info" , array () ) ,
                ) ,
                array (
                    "title"    => "create_production_account" ,
                    "describe" => "" ,
                    "href"     => Class_Base_Response::get_url ( "/user/create_production_privilege_user_password" , array () ) ,
                ) ,
                array (
                    "title"    => "unsubscribe" ,
                    "describe" => "clear" ,
                    "href"     => 'javascript:if(confirm("Are you sure you want to reset the software data of Phpsploit Framework? After resetting, shared memory and session data will be destroyed! If you want to continue using the Phpsploit Framework software, you need to perform the initialization operation of the Phpsploit Framework software again! Note: The files you downloaded, uploaded, and created will not be deleted together. If you want to clean these files, you need to manually perform the cleaning work of these files! Reminder: Files downloaded, uploaded, or created using the Phpsploit Framework software usually contain the word \'phpsploit\' in the file name, which usually appears with a prefix name separated by a period before the file extension! If the downloaded, uploaded, or created file does not have an extension, the word \'phpsploit\' will directly appear as a file extension! This type of naming design is mainly designed to facilitate your management of files downloaded, uploaded, and created using the Phpsploit Framework software. Execute clear (select \'OK\'), discard clear (select \'Cancel\').")){document.location.href="' . Class_Base_Response ::get_url ( "/clear" , array ( "rand" => time () ) ) . '";}' ,
                ) ,
                array (
                    "title"    => "logout" ,
                    "describe" => "logout" ,
                    "href"     => 'javascript:if(confirm("Are you sure you want to log out? After logging out, if you want to use the Phpsploit Framework software again, you need to use the currently created account, password, and command board to log in again! Before officially logging out, it is recommended that you take note of your current account, password, command board, and other information! This can avoid the dilemma of not being able to log in again after logging out! If you forget your password after logging out, you can also contact the authorized party who authorizes you to conduct penetration testing or security audit behavior, and cooperate with them to uninstall the Phpsploit Framework software (this usually requires you to execute the \"php -f <Phpsploit Framework software project file path> /clear\" operation in the command line environment of the target machine to uninstall the Phpsploit Framework software)! Execute clear (select \'OK\'), discard clear (select \'Cancel\').")){document.location.href="' . Class_Base_Response ::get_url ( "/logout" , array () ) . '";}' ,                        //
                ) ,
            );
        }
        return self::$_menu;
    }
}