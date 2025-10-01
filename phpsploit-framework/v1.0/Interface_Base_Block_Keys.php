<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-23
 * Time: 下午1:24
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

interface Interface_Base_Block_Keys extends Interface_Base
{
    const WEB_KEY         = Interface_Base_BlockKey::WEB_KEYS;
    const CLI_KEY         = Interface_Base_BlockKey::CLI_KEYS;
    const MAP_SIZE        = 1048576;
    const MAP_ITEM_SIZE   = 32;
    const MAP_ITEM_LIMIT  = 32768;
    const SIZE_BLOCK      = 1048712;
    const SIZE_BLOCK_KEY  = 16;
    const SIZE_BLOCK_SIZE = 16;
}