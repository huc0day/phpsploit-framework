<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-24
 * Time: 上午11:36
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

class Class_Base extends Class_Root implements Interface_Base
{
    public static function class_exists ( $class_name )
    {
        if ( is_string ( $class_name ) && ( strlen ( $class_name ) > 0 ) ) {
            try {
                return class_exists ( $class_name );
            } catch ( \Exception $e ) {
                return false;
            }
        }
        return false;
    }

    public static function interface_exists ( $interface_name )
    {
        if ( is_string ( $interface_name ) && ( strlen ( $interface_name ) > 0 ) ) {
            try {
                return interface_exists ( $interface_name );
            } catch ( \Exception $e ) {
                return false;
            }
        }
        return false;
    }
}