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

class Class_Controller_Logout extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ( Class_Base_Auth::is_login () ) ) {
            Class_Base_Auth::disable_login ();
            Class_Base_Auth::disable_license_agreement ();
            if ( ! is_cli () ) {
                Class_Base_Response::redirect ( "/login" );
            } else {
                Class_Base_Response::outputln ( "\n" . 'This command may not be very suitable for command line environments in general!' );
            }
            return null;
        }
        return null;
    }
}