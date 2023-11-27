<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-29
 * Time: 上午9:19
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

class Class_Base_Error extends Class_Base implements Interface_Base_Error
{
    const ERROR                                 = 10000000;
    const SYSTEM_ERROR                          = 10001000;
    const SYSTEM_EXCEPTION                      = 10002000;
    const EXCEPTION                             = 20000000;
    const FILE_EXCEPTION                        = 20001000;
    const FILE_EXCEPTION_DELETE                 = 20001001;
    const MEMORY_EXCEPTION                      = 20002000;
    const NETWORK_EXCEPTION                     = 20003000;
    const NETWORK_EXCEPTION_CLIENT_DISCONNECTED = 20003001;

}