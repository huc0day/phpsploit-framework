<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-8
 * Time: 上午9:22
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

class Class_Base_Auth extends Class_Base
{
    const SHM_WEB_KEY = Interface_Base_BlockKey::WEB_AUTH;
    const SHM_CLI_KEY = Interface_Base_BlockKey::CLI_AUTH;

    const SECURITY_CODE = '^1A69DvAk88$!;Radfs^#q0123456789';

    public static function create_password ()
    {
        $_password = "";
        for ( $i = 0 ; $i < 18 ; $i ++ ) {
            $_password .= chr ( rand ( 33 , 126 ) );
        }
        return $_password;
    }

    public static function create_security_code ()
    {
        $_password = "";
        for ( $i = 0 ; $i < 18 ; $i ++ ) {
            $_password .= chr ( rand ( 33 , 126 ) );
        }
        return $_password;
    }

    public static function is_enable_license_agreement ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! empty( $_SESSION ) ) && ( is_array ( $_SESSION ) ) && ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_ENABLE_LICENSE_AGREEMENT" ] ) ) && ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_ENABLE_LICENSE_AGREEMENT" ] == 1 ) ) {
            return true;
        }
        return false;
    }

    public static function enable_license_agreement ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! isset( $_SESSION ) ) || ( ! is_array ( $_SESSION ) ) ) {
            $_SESSION = array ();
        }
        $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_ENABLE_LICENSE_AGREEMENT" ] = 1;
    }

    public static function disable_license_agreement ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! isset( $_SESSION ) ) || ( ! is_array ( $_SESSION ) ) ) {
            $_SESSION = array ();
        }
        $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_ENABLE_LICENSE_AGREEMENT" ] = 0;
    }

    public static function is_login ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! empty( $_SESSION ) ) && ( is_array ( $_SESSION ) ) && ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_LOGIN" ] ) ) && ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_LOGIN" ] == 1 ) ) {
            if ( ! ( Class_Operate_User::exist_token () ) ) {
                $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_LOGIN" ] = null;
                unset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_LOGIN" ] );
                return false;
            }
            return true;
        }
        return false;
    }

    public static function enable_login ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! isset( $_SESSION ) ) || ( ! is_array ( $_SESSION ) ) ) {
            $_SESSION = array ();
        }
        $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_LOGIN" ] = 1;
    }

    public static function disable_login ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! isset( $_SESSION ) ) || ( ! is_array ( $_SESSION ) ) ) {
            $_SESSION = array ();
        }
        $_SESSION[ "PHPSPLOIT_FRAMEWORK_IS_LOGIN" ] = 0;
    }

    public static function clear_session ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( isset( $_SESSION ) ) {
            if ( is_array ( $_SESSION ) ) {
                foreach ( $_SESSION as $k => $v ) {
                    $_SESSION[ $k ] = null;
                    unset( $_SESSION[ $k ] );
                }
                if ( isset( $_COOKIE[ session_name () ] ) ) {
                    setcookie ( session_name () , '' , time () - 42000 , '/' );
                }
            }
            session_destroy ();
            $_SESSION = null;
            unset( $_SESSION );
        }
    }

    public static function clear ()
    {
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            Class_Base_Memory::clear ();
        }
        self::clear_session ();
    }

    public static function is_permission_csrf ()
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! empty( $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] ) ) && ( ! empty( $_REQUEST[ "csrf" ] ) ) && ( $_REQUEST[ "csrf" ] == $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] ) ) {
            return true;
        }
        return false;
    }

    public static function is_permission ()
    {
        if ( ( self::is_login () ) && ( self::is_permission_csrf () ) ) {
            return true;
        }
        return false;
    }

    public static function check_permission ()
    {
        if ( ( ! is_cli () ) && ( ! self::is_permission () ) ) {
            throw new \Exception( "Insufficient access permissions to perform this operation!" , 0 );
        }
    }

    public static function cli_show_license_agreement ()
    {
        if ( is_cli () ) {
            $_is_enable_license_agreement = Class_Base_Request::form ( "is_enable_license_agreement" , Class_Base_Request::TYPE_INTEGER , 0 );
            if ( empty( $_is_enable_license_agreement ) ) {
                Class_Base_Response::output ( "\n\n" . Class_View_Default::get_document_title () . "\n\n" . Class_View_Default::get_document_body () . "\n\n" . Class_View_Default::get_document_confirm () . "\n\n" . Class_View_Default::get_command_line_form_parameter_description () . "\n\n" );
            }
        }
    }
}