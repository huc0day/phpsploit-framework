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

class Class_Controller_Cli extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ! is_cli () ) {
            return array ();
        }
        return array ();
    }

    public static function create_token ( $params = array () )
    {
        if ( ! is_cli () ) {
            return array ();
        }

        if ( Class_Operate_User::exist_token () ) {
            Class_Base_Response::outputln ( "\nThe command line authentication token has been initialized and cannot be initialized again! If you need to perform the initialization operation again, please first access the  ' /cli/clean_token ' route and perform the clearing operation on the current command-line authentication token ! \n\nURI routing call format : /cli/clean_token?privilege_user=%26privilege_password=" );
            return array ();
        }

        $_privilege_user     = Class_Base_Request::form ( "privilege_user" , Class_Base_Request::TYPE_STRING , "" );
        $_privilege_password = Class_Base_Request::form ( "privilege_password" , Class_Base_Request::TYPE_STRING , "" );

        $_privilege_user_length     = strlen ( $_privilege_user );
        $_privilege_password_length = strlen ( $_privilege_password );

        if ( $_privilege_user_length <= 0 ) {
            Class_Base_Response::outputln ( "Please enter the account name of the privileged account! uri route call format : /cli/create_token?privilege_user=%26privilege_password=" );
            return array ();
        }
        if ( $_privilege_password_length <= 0 ) {
            Class_Base_Response::outputln ( "Please enter the account password of the privileged account!" );
            return array ();
        }

        $_certified = Class_Operate_User::check_privilege_user_and_password_for_cli_create_token ( $_privilege_user , $_privilege_password );
        if ( ! $_certified ) {
            Class_Base_Response::outputln ( "privileged account or account password is input error !" );
            return array ();
        }

        $_password       = null;
        $_security_token = Class_Operate_User::create_token ( $_password );

        Class_Base_Response::outputln ( "\nSecurity Token creation successful, new Security Token: " . $_security_token . " , password : " . $_password );


        return array ();
    }

    public static function clear_token ( $params = array () )
    {
        if ( ! is_cli () ) {
            return array ();
        }

        $_privilege_user     = Class_Base_Request::form ( "privilege_user" , Class_Base_Request::TYPE_STRING , "" );
        $_privilege_password = Class_Base_Request::form ( "privilege_password" , Class_Base_Request::TYPE_STRING , "" );

        $_privilege_user_length     = strlen ( $_privilege_user );
        $_privilege_password_length = strlen ( $_privilege_password );

        if ( $_privilege_user_length <= 0 ) {
            Class_Base_Response::outputln ( "Please enter the account name of the privileged account! uri route call format : /cli/clear_token?privilege_user=%26privilege_password=" );
            return array ();
        }
        if ( $_privilege_password_length <= 0 ) {
            Class_Base_Response::outputln ( "Please enter the account password of the privileged account!" );
            return array ();
        }

        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            if ( Class_Operate_User::exist_token () ) {
                Class_Controller_Memory::clear ();
            }
        }

        Class_Base_Response::outputln ( "\nThe Security Token has been successfully cleared! " );

        return array ();
    }
}