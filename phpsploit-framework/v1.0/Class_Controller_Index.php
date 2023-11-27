<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-20
 * Time: 下午11:10
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

class Class_Controller_Index extends Class_Controller
{
    public static function index ( $params = array () )
    {
        $_is_enable_license_agreement = Class_Base_Request::form ( "is_enable_license_agreement" , Class_Base_Request::TYPE_INTEGER , 0 );
        if ( ! empty( $_is_enable_license_agreement ) ) {
            Class_Base_Auth::enable_license_agreement ();
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( ! is_cli () ) {
            $_top    = Class_View_Top::top ();
            $_body   = array (
                "menu"    => array (
                    array (
                        "title"    => "/user" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/user" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/server" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/server" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/session" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/session" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/cookie" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/cookie" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/build" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/build" , array ( "is_build" => 0 ) ) ,
                    ) ,
                    array (
                        "title"    => "/debug" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/debug" , array ( "is_debug" => ( empty( $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] ) ? 0 : 1 ) ) ) ,
                    ) ,
                ) ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "" );
        }
        return null;
    }

    public static function debug ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();

        $_is_debug = Class_Base_Request::form ( "is_debug" , Class_Base_Request::TYPE_INTEGER , ( empty( $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] ) ? 0 : 1 ) );
        if ( empty( $_is_debug ) ) {
            $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] = 0;
        } else {
            $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] = 1;
        }
        if ( ! is_cli () ) {
            $_form     = array (
                "action"  => "/debug" ,
                "selects" => array (
                    array (
                        "title"   => "( Enabled / Disabled )   : " ,
                        "name"    => "is_debug" ,
                        "options" => array (
                            array ( "describe" => "Enabled Debug" , "title" => "Enabled Debug" , "value" => 1 , "selected" => ( ( ! empty( $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] ) ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Disabled Debug" , "title" => "Disabled Debug" , "value" => 0 , "selected" => ( ( empty( $_SESSION[ "PHPSPLOIT_PERMISSION_DEBUG" ] ) ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
            );
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Set Up Debugging Environment</div>';
            $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">Set up a debugging environment, which will determine the level of detail that the Phpsploit Framework software can provide to you when there are runtime errors or abnormal situations in the production environment!</div>';
            $_top      = Class_View_Top::top ();
            $_body     = array (
                "menu"    => array (
                    array (
                        "title"    => "/user" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/user" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/server" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/server" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/session" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/session" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/cookie" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/cookie" , array () ) ,
                    ) ,
                    array (
                        "title"    => "/build" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/build" , array ( "is_build" => 0 ) ) ,
                    ) ,
                    array (
                        "title"    => "/debug" ,
                        "describe" => "" ,
                        "href"     => Class_Base_Response::get_url ( "/debug" , array ( "is_debug" => $_is_debug ) ) ,
                    ) ,
                ) ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom   = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( "" );
        }
        return null;
    }
}