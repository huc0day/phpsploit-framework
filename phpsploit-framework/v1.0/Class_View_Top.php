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

class Class_View_Top
{
    private static $_top = null;

    public static function top ()
    {
        if ( empty( self::$_top ) ) {
            self::$_top = array (
                "lang"       => "en" ,
                "charset"    => "utf-8" ,
                "title"      => "phpsploit-framework" ,
                "javascript" => ( Class_Base_Security::get_js_encode_source_code () . Class_Base_Security::get_js_base64_source_code () . Class_Base_Security::get_js_urldecode () ) ,
                "menu"       => array (
                    array (
                        "title"    => "home" ,
                        "describe" => "home" ,
                        "href"     => Class_Base_Response::get_url ( "/index" , array () ) ,
                    ) ,
                    array (
                        "title"    => "guide" ,
                        "describe" => "guide" ,
                        "href"     => Class_Base_Response::get_url ( "/guide" , array () ) ,
                    ) ,
                    array (
                        "title"    => "security" ,
                        "describe" => "security" ,
                        "href"     => Class_Base_Response::get_url ( "/security" , array () ) ,
                    ) ,
                    array (
                        "title"    => "memory" ,
                        "describe" => "memory" ,
                        "href"     => Class_Base_Response::get_url ( "/memory" , array () ) ,
                    ) ,
                    array (
                        "title"    => "database" ,
                        "describe" => "database" ,
                        "href"     => Class_Base_Response::get_url ( "/database" , array () ) ,
                    ) ,
                    array (
                        "title"    => "file" ,
                        "describe" => "file" ,
                        "href"     => Class_Base_Response::get_url ( "/file" , array () ) ,
                    ) ,
                    array (
                        "title"    => "scan" ,
                        "describe" => "scan" ,
                        "href"     => Class_Base_Response::get_url ( "/scan" , array () ) ,
                    ) ,
                    array (
                        "title"    => "wget" ,
                        "describe" => "wget" ,
                        "href"     => Class_Base_Response::get_url ( "/wget" , array () ) ,
                    ) ,
                    array (
                        "title"    => "elf" ,
                        "describe" => "elf" ,
                        "href"     => Class_Base_Response::get_url ( "/elf" , array () ) ,
                    ) ,
                    array (
                        "title"    => "shell" ,
                        "describe" => "shell" ,
                        "href"     => Class_Base_Response::get_url ( "/shell" , array () ) ,
                    ) ,
                    array (
                        "title"    => "chat" ,
                        "describe" => "chat" ,
                        "href"     => Class_Base_Response::get_url ( "/chat" , array () ) ,
                    ) ,
                    array (
                        "title"    => "report" ,
                        "describe" => "report" ,
                        "href"     => Class_Base_Response::get_url ( "/report" , array () ) ,
                    ) ,
                    array (
                        "title"    => "clear" ,
                        "describe" => "clear" ,
                        "href"     => 'javascript:if(confirm("Are you sure you want to reset the software data of Phpsploit Framework? After resetting, shared memory and session data will be destroyed! If you want to continue using the Phpsploit Framework software, you need to perform the initialization operation of the Phpsploit Framework software again! Note: The files you downloaded, uploaded, and created will not be deleted together. If you want to clean these files, you need to manually perform the cleaning work of these files! Reminder: Files downloaded, uploaded, or created using the Phpsploit Framework software usually contain the word \'phpsploit\' in the file name, which usually appears with a prefix name separated by a period before the file extension! If the downloaded, uploaded, or created file does not have an extension, the word \'phpsploit\' will directly appear as a file extension! This type of naming design is mainly designed to facilitate your management of files downloaded, uploaded, and created using the Phpsploit Framework software. Execute clear (select \'OK\'), discard clear (select \'Cancel\').")){document.location.href="' . Class_Base_Response::get_url ( "/clear" , array ( "rand" => time () ) ) . '";}' ,
                    ) ,
                    array (
                        "title"    => "logout" ,
                        "describe" => "logout" ,
                        "href"     => 'javascript:if(confirm("Are you sure you want to log out? After logging out, if you want to use the Phpsploit Framework software again, you need to use the currently created account, password, and command board to log in again! Before officially logging out, it is recommended that you take note of your current account, password, command board, and other information! This can avoid the dilemma of not being able to log in again after logging out! If you forget your password after logging out, you can also contact the authorized party who authorizes you to conduct penetration testing or security audit behavior, and cooperate with them to uninstall the Phpsploit Framework software (this usually requires you to execute the \"php -f <Phpsploit Framework software project file path> /clear\" operation in the command line environment of the target machine to uninstall the Phpsploit Framework software)! Execute clear (select \'OK\'), discard clear (select \'Cancel\').")){document.location.href="' . Class_Base_Response::get_url ( "/logout" , array () ) . '";}' ,                        //
                    ) ,
                ) ,
                "content"    => '<div style="line-height:32px;font-size:32px;text-align: center;">phpsploit-framework</div><div style="height:32px;"></div>' ,
            );
        }

        foreach ( self::$_top[ "menu" ] as $index => $menu ) {
            if ( PHP_VERSION_ID < 80000 ) {
                if ( $menu[ "title" ] == "elf" ) {
                    self::$_top[ "menu" ][ $index ] = null;
                    unset( self::$_top[ "menu" ][ $index ] );
                }
                if ( $menu[ "title" ] == "chat" ) {
                    self::$_top[ "menu" ][ $index ] = null;
                    unset( self::$_top[ "menu" ][ $index ] );
                }
            }
            if ( ! Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
                if ( $menu[ "title" ] == "memory" ) {
                    self::$_top[ "menu" ][ $index ] = null;
                    unset( self::$_top[ "menu" ][ $index ] );
                }
            }
            try {
                if ( $menu[ "title" ] == "guide" ) {
                    if ( ( ! class_exists ( "Class_Controller_PenetrationTestCommands" ) ) || ( ! class_exists ( "Class_Controller_PenetrationTestCommands" ) ) ) {
                        self::$_top[ "menu" ][ $index ] = null;
                        unset( self::$_top[ "menu" ][ $index ] );
                    }
                }
            } catch ( \Exception $e ) {
                if ( $menu[ "title" ] == "guide" ) {
                    self::$_top[ "menu" ][ $index ] = null;
                    unset( self::$_top[ "menu" ][ $index ] );
                }
            }
        }

        return self::$_top;
    }
}