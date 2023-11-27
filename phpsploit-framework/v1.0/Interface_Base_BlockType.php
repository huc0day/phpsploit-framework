<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-20
 * Time: 下午4:14
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

interface Interface_Base_BlockType extends Interface_Base
{
    const TYPE_BLOCK_KEYS         = 1001;
    const TYPE_BLOCK_INDEXES      = 2001;
    const TYPE_BLOCK_UNIQUE_INDEX = 3001;
    const TYPE_BLOCK_DATA         = 4001;
    const TYPE_BLOCK_SOCKETS      = 5001;

}