<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-7
 * Time: 下午1:19
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

class Class_Controller_Login extends Class_Controller
{
    public static function index ( $params = array () )
    {
        $_is_enable_license_agreement = Class_Base_Request::form ( "is_enable_license_agreement" , Class_Base_Request::TYPE_INTEGER , 0 );
        if ( ! empty( $_is_enable_license_agreement ) ) {
            Class_Base_Auth::enable_license_agreement ();
        }
        if ( ! ( Class_Base_Auth::is_enable_license_agreement () ) ) {
            Class_Base_Response::redirect ( "/" );
            return null;
        }
        if ( ! Class_Operate_User::exist_token () ) {
            Class_Base_Auth::clear ();
            Class_Base_Response::redirect ( "/init" );
            return null;
        }
        if ( ( Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/index" );
            return null;
        }
        $_user           = Class_Base_Request::form ( "user" , Class_Base_Request::TYPE_STRING , "" );
        $_password       = Class_Base_Request::form ( "password" , Class_Base_Request::TYPE_STRING , "" );
        $_security_token = "";
        if ( ( ! empty( $_user ) ) && ( ! empty( $_password ) ) ) {
            if ( Class_Operate_User::check_user_and_password ( $_user , $_password , $_security_token ) ) {
                Class_Base_Auth::enable_login ();
                if ( ! is_cli () ) {
                    Class_Base_Response::redirect ( "/index" );
                } else {
                    Class_Base_Response::output ( array ( 'user' => $_user , 'password' => $_password , 'security_token' => $_security_token ) );
                }
                return null;
            }
        }
        if ( ! is_cli () ) {
            $_view_data = array ( 'user' => $_user , 'password' => $_password , );
            Class_Base_Response::output ( Class_View_Login::login ( $_view_data ) , "text" );
        }

        return null;
    }
}