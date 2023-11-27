<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-23
 * Time: 上午11:53
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

class Class_Controller_Init
{
    public static function index ( $params = array () )
    {
        $_is_enable_license_agreement = Class_Base_Request ::form ( "is_enable_license_agreement" , Class_Base_Request::TYPE_INTEGER , 0 );
        if ( ! empty( $_is_enable_license_agreement ) ) {
            Class_Base_Auth ::enable_license_agreement ();
        }
        if ( ! ( Class_Base_Auth ::is_enable_license_agreement () ) ) {
            Class_Base_Response ::redirect ( "/" );
            return null;
        }
        if ( ( Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/index" );
            return null;
        }
        if ( Class_Operate_User ::exist_token () ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        if ( ! Class_Base_Extension ::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        $_privilege_user     = Class_Base_Request ::form ( "privilege_user" , Class_Base_Request::TYPE_STRING , "" );
        $_privilege_password = Class_Base_Request ::form ( "privilege_password" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! is_cli () ) {
            $_view_data = array ( 'privilege_user' => $_privilege_user , 'privilege_password' => $_privilege_password );
            Class_Base_Response ::output ( Class_View_Init ::init ( $_view_data ) , "text" , 0 );
        } else {
            Class_Base_Response ::output ( "\n" . Class_Base_Response ::get_encode_cli_url ( "/init_user_info" , array ( "privilege_user" => $_privilege_user , "privilege_password" => $_privilege_password ) ) . "\n" , "text" , 0 );
        }
        return null;
    }

    public static function init_user_info ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ! ( Class_Base_Auth ::is_enable_license_agreement () ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response ::redirect ( "/" );
                return null;
            } else {
                Class_Base_Auth ::cli_show_license_agreement ();
            }
        }
        if ( ( Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/index" );
            return null;
        }
        $_privilege_user     = Class_Base_Request ::form ( "privilege_user" , Class_Base_Request::TYPE_STRING , "" );
        $_privilege_password = Class_Base_Request ::form ( "privilege_password" , Class_Base_Request::TYPE_STRING , "" );
        $_user                      = "";
        $_password                  = "";
        $_md5_token                 = "";
        if ( Class_Operate_User ::check_privilege_user_and_password ( $_privilege_user , $_privilege_password , $_user , $_password , $_md5_token ) ) {
            if ( ! is_cli () ) {
                if ( empty( $_user ) ) {
                    $_user      = ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ] ) );
                    $_password  = ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ] ) );
                    $_md5_token = ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) );
                }
                $_view_data = array ( 'privilege_user' => $_privilege_user , 'privilege_password' => $_privilege_password , 'user' => $_user , 'password' => $_password , 'md5_token' => $_md5_token );
                Class_Base_Response ::output ( Class_View_Init_User_Info ::init ( $_view_data ) , "text" , 0 );
            } else {
                Class_Base_Response ::output ( array ( 'privilege_user' => $_privilege_user , 'privilege_password' => $_privilege_password , 'user' => $_user , 'password' => $_password , 'md5_token' => $_md5_token ) , "json" );
            }
        } else {
            if ( ! is_cli () ) {
                Class_Base_Response ::redirect ( "/init" , array ( "privilege_user" => $_privilege_user , "privilege_password" => $_privilege_password ) );
            } else {
                Class_Base_Response ::outputln ( "\nAccount initialization or password input error , please double check and try again ! " );
            }
        }
        return null;
    }
}