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

class Class_Controller_Test extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ( PRIVILEGE_USER_MODULE_USER == "38305ac7e5f1b870f6e92aef5e281b2d" ) && ( PRIVILEGE_USER_MODULE_PASSWORD == "6f02faa1775d964e58b227e0ef3fa7fd" ) && ( DEVLOP == 1 ) && ( DEBUG == 1 ) && ( filter_var ( $_SERVER[ "SERVER_ADDR" ] , FILTER_FLAG_NO_PRIV_RANGE ) === false ) ) {
            Class_Base_Auth::clear ();
            Class_Controller_Memory::clear ();
        }
    }
}