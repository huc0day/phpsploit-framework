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

class Class_Controller_User extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        if ( ! is_cli () ) {
            $_top    = Class_View_Top ::top ();
            $_body   = array (
                "menu"    => Class_View_User_Menu ::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom ::bottom ();
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function create_production_privilege_user_password ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        $_init_user            = str_replace ( "?" , "!" , str_replace ( "&" , "!" , str_replace ( "=" , "!" , Class_Base_Request ::form ( "init_user" , Class_Base_Request::TYPE_STRING , "0day" ) ) ) );
        $_init_password        = str_replace ( "?" , "!" , str_replace ( "&" , "!" , str_replace ( "=" , "!" , Class_Base_Auth ::create_password () ) ) );
        $_encode_init_user     = "";
        $_encode_init_password = "";
        if ( ( strlen ( $_init_user ) > 0 ) && ( strlen ( $_init_password ) > 0 ) ) {
            $_encode_init_user     = Class_Operate_User ::create_privilege_encode_user ( $_init_user );
            $_encode_init_password = Class_Operate_User ::create_privilege_encode_password ( $_init_password );
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response ::get_cli_url ( "/user/create_production_privilege_user_password" , array ( "init_user" => $_init_user , "init_password" => $_init_password , ) );
            $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:128px;height: 32px;text-align: center;font-size: 18px;">Create an Initialization Privileged Account and Password for the Production Environment</br><p style="color:red;text-align: left;">This operation will only dynamically generate and output encrypted information for the new privileged account and corresponding password, and will not really change the configuration content of the framework file! You need to manually update the content values of the framework global constants (PRIVILEGE_USER-MODULE_USER) and (PRIVILEGE_USER-MODULE_PASSWORD)!</p></div>';
            $_form           = array (
                "action" => "/user/create_production_privilege_user_password" ,
                "inputs" => array (
                    array (
                        "id"       => "user" ,
                        "title"    => "( Privileged User ) : " ,
                        "describe" => "Privileged Account for the Production Environment" ,
                        "name"     => "init_user" ,
                        "value"    => $_init_user ,
                    ) ,
                    array (
                        "id"       => "password" ,
                        "title"    => "( Privileged User Password ) : " ,
                        "describe" => "Privileged Password for the Production Environment" ,
                        "name"     => "init_password" ,
                        "value"    => $_init_password ,
                        "disabled" => "disabled" ,
                    ) ,
                    array (
                        "id"       => "user" ,
                        "title"    => "( Encode Privileged User ) : " ,
                        "describe" => "Encode Privileged Account for the Production Environment" ,
                        "name"     => "init_user" ,
                        "value"    => $_encode_init_user ,
                        "disabled" => "disabled" ,
                    ) ,
                    array (
                        "id"       => "password" ,
                        "title"    => "( Encode Privileged User Password ) : " ,
                        "describe" => "Encode Privileged Password for the Production Environment" ,
                        "name"     => "init_password" ,
                        "value"    => $_encode_init_password ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
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
                "submit" => array (
                    "display" => true ,
                ) ,
                "reset"  => array (
                    "display" => true ,
                ) ,
            );
            $_top            = Class_View_Top ::top ();
            $_body           = array (
                "menu"    => Class_View_User_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
            );
            $_bottom_menu    = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content        = '<div></div>';
            $_javascript     = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom         = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response ::outputln ( "\n" . 'This operation will only dynamically generate and output encrypted information for the new privileged account and corresponding password, and will not really change the configuration content of the framework file! You need to manually update the content values of the framework global constants (PRIVILEGE_USER-MODULE_USER) and (PRIVILEGE_USER-MODULE_PASSWORD)!' );
            Class_Base_Response ::outputln ( "Privileged User : " . $_init_user );
            Class_Base_Response ::outputln ( "Privileged User Password : " . $_init_password );
            Class_Base_Response ::outputln ( "Encode Privileged User : " . $_encode_init_user );
            Class_Base_Response ::outputln ( "Encode Privileged User Password : " . $_encode_init_password );
        }
        return null;
    }

    public static function user_info ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        if ( is_cli () ) {
            Class_Base_Response ::outputln ( "\n" . 'Note that this command is not valid on the command line!' );
            Class_Base_Response ::outputln (
                array (
                    "PHPSPLOIT_FRAMEWORK_USER"      => ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ] ) ,
                    "PHPSPLOIT_FRAMEWORK_PASSWORD"  => ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ] ) ,
                    "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" => ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ,
                )
            );
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response ::get_cli_url ( "/user/user_info" , array () );
            $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Display account name, account password, MD5 token information</div>';
            $_form_top       .= '<div style="width:100%;word-break:break-all;margin-top:16px;padding-left:0;padding-right:0;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">Warning: You must remember the following three pieces of information, which will be used for the login behavior of this framework software before you perform the initialization operation again.Note: The temporary account cache information of the Phpsploit Framework software is stored in the Session environment. If you try to access this interface in a command-line environment, you may not be able to obtain valid information. Because in general, processes in the command line environment cannot obtain session environment information in the web environment (although we can achieve session environment information exchange between the web environment and the command line environment through special technical means. However, in order to reduce the software\'s inherent environmental dependencies and improve the software\'s compatibility and availability, the author of this software did not choose to do so).</div>';
            $_form           = array (
                "action"    => "/user/user_info" ,
                "inputs"    => array (
                    array (
                        "id"       => "user" ,
                        "title"    => "( User Name ) : " ,
                        "describe" => "User Name" ,
                        "name"     => "user" ,
                        "value"    => ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ] ) ,
                        "disabled" => "disabled" ,
                    ) ,
                    array (
                        "id"       => "password" ,
                        "title"    => "( User Password ) : " ,
                        "describe" => "User Password" ,
                        "name"     => "password" ,
                        "value"    => ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ] ) ,
                        "disabled" => "disabled" ,
                    ) ,
                    array (
                        "id"       => "md5_token" ,
                        "title"    => "( MD5 Token ) : " ,
                        "describe" => "MD5 Token" ,
                        "name"     => "md5_token" ,
                        "value"    => ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
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
            $_top            = Class_View_Top ::top ();
            $_body           = array (
                "menu"    => Class_View_User_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
            );
            $_bottom_menu    = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content        = '<div></div>';
            $_javascript     = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom         = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }
}