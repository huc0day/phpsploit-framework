<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-27
 * Time: 下午6:55
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

class Class_Controller_Session extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( ! is_cli () ) {
            $_top    = Class_View_Top::top ();
            $_body   = array (
                "menu"    => Class_View_Session_Menu::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function session_info ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( is_cli () ) {
            Class_Base_Response::outputln (
                $_SESSION
            );
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response::get_cli_url ( "/session/session_info" , array () );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Display relevant information about PHP session environment variables</div>';
            $_form_top       .= '<div style="width:100%;word-break:break-all;margin-top:16px;padding-left:0;padding-right:0;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface mainly displays the internal session variable content of the PHP language located on the server side.If you try to access this interface in a command-line environment, you may not be able to obtain valid information. Because in general, processes in the command line environment cannot obtain session environment information in the web environment (although we can achieve session environment information exchange between the web environment and the command line environment through special technical means. However, in order to reduce the software\'s inherent environmental dependencies and improve the software\'s compatibility and availability, the author of this software did not choose to do so).</div>';
            $_form           = array (
                "action"    => "/session/session_info" ,
                "inputs"    => array () ,
                "textareas" => array (
                    array (
                        "id"       => "cli_encode_url" ,
                        "title"    => "( Cli Encode URL )   : " ,
                        "name"     => "cli_encode_url" ,
                        "value"    => ( 'cli url : ' . $_cli_url . "\n\n" . 'cli encode url : ' . $_cli_encode_url . "\n\n" ) ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                ) ,
                "submit"    => array (
                    "display" => false ,
                ) ,
                "reset"     => array (
                    "display" => false ,
                ) ,
            );
            foreach ( $_SESSION as $key => $value ) {
                $_form[ "inputs" ][] = array (
                    "id"       => $key ,
                    "title"    => ( ( strlen ( $key ) > 12 ) ? ( substr ( $key , 0 , 12 ) . chr ( 46 ) . chr ( 46 ) . chr ( 46 ) ) : ( $key ) ) ,
                    "describe" => $key ,
                    "name"     => $key ,
                    "value"    => ( $value ) ,
                    "disabled" => "disabled" ,
                );
            }
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Session_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }
}