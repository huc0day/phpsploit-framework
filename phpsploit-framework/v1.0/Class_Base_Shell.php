<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-13
 * Time: 下午12:06
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

class Class_Base_Shell extends Class_Base implements Interface_Base_Shell
{
    private static $_command = null;
    private static $_output  = null;
    private static $_retval  = null;

    private static function _init ( $command )
    {
        self::$_command = $command;
        self::$_output  = null;
        self::$_retval  = null;
    }

    private static function _clear ()
    {
        self::$_command = null;
        self::$_output  = null;
        self::$_retval  = null;
    }


    public static function command ( $command )
    {
        self::_init ( $command );
        exec ( self::$_command , self::$_output , self::$_retval );
        return self::$_output;
    }
}