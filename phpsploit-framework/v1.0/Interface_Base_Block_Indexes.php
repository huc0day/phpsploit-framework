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

interface Interface_Base_Block_Indexes extends Interface_Base , Interface_Base_Block_IndexesItem
{
    const KEY                 = 200000000000000001;
    const MODE_READ           = 0440;
    const MODE_WRITE          = 0220;
    const MODE_READ_AND_WRITE = 0660;
    const MODE_COMMON         = 0644;

    const SIZE_BLOCK_DATA            = 1048576;
    const SIZE_BLOCK_DATA_ITEM       = 128;
    const SIZE_BLOCK_DATA_ITEM_COUNT = 8192;
    const SIZE_BLOCK                 = 1048712;

    const SIZE_INTEGER_KEY_MAX  = 999999999999999999;
    const SIZE_INTEGER_KEY_MIN  = 100000000000000001;
    const SIZE_STRING_KEY       = 18;
    const SIZE_INTEGER_MODE_MIN = 0600;
    const SIZE_INTEGER_MODE_MAX = 0777;
    const SIZE_INTEGER_TYPE_MIN = 1001;
    const SIZE_INTEGER_TYPE_MAX = 9999;

    const OFFSET_BLOCK_DATA_ITEM_MAX = 1048448;

    const SIZE_MAP             = 1048576;
    const SIZE_MAP_ITEM        = 128;
    const LIMIT_MAP_ITEM_COUNT = 8192;
}