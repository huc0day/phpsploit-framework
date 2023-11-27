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

interface Interface_Base_Memory extends Interface_Base
{
    const BLOCK_SIZE_8        = 8;
    const BLOCK_SIZE_16       = 16;
    const BLOCK_SIZE_32       = 32;
    const BLOCK_SIZE_64       = 64;
    const BLOCK_SIZE_128      = 128;
    const BLOCK_SIZE_256      = 256;
    const BLOCK_SIZE_512      = 512;
    const BLOCK_SIZE_1024     = 1024;
    const BLOCK_SIZE_2048     = 2048;
    const BLOCK_SIZE_4096     = 4096;
    const BLOCK_SIZE_8192     = 8192;
    const BLOCK_SIZE_65536    = 65536;
    const BLOCK_SIZE_131072   = 131072;
    const BLOCK_SIZE_262144   = 262144;
    const BLOCK_SIZE_524288   = 524288;
    const BLOCK_SIZE_1048576  = 1048576;
    const BLOCK_SIZE_2097152  = 2097152;
    const BLOCK_SIZE_4194304  = 4194304;
    const BLOCK_SIZE_8388608  = 8388608;
    const BLOCK_SIZE_16777216 = 16777216;
    const BLOCK_SIZE_33554432 = 33554432;
    const BLOCK_SIZE_67108864 = 67108864;
    //
    const DATA_FORMAT_STRING_NULL_FILL_PACK      = "a*";
    const DATA_FORMAT_64_INTEGER_PACK            = "a*";
    const DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK = 1001;
    const DATA_FORMAT_TYPE_64_INTEGER_PACK       = 2001;
    //
    const FLAGS_SHARE_MEMORY_READ           = 'a';
    const FLAGS_SHARE_MEMORY_READ_AND_WRITE = 'w';
    const FLAGS_SHARE_MEMORY_CREATE         = 'n';
    const FLAGS_SHARE_MEMORY_OPEN           = 'c';
    //
    const MODE_SHARE_MEMORY_READ                     = 0440;
    const MODE_SHARE_MEMORY_WRITE                    = 0220;
    const MODE_SHARE_MEMORY_READ_AND_WRITE           = 0660;
    const MODE_SHARE_MEMORY_READ_AND_WRITE_READ_READ = 0644;
    //
    const BLOCK_DATA_VALUE_INTEGER_MIN_VALUE = 1;
    const BLOCK_DATA_VALUE_INTEGER_MAX_VALUE = 999999999999999999;
    //
    const BLOCK_DATA_VALUE_INTEGER_MIN_LENGTH = 1;
    const BLOCK_DATA_VALUE_INTEGER_MAX_LENGTH = 18;
    //
    const BLOCK_DATA_VALUE_INTEGER_ZERO    = 0;
    const BLOCK_DATA_VALUE_INTEGER_ONE     = 1;
    const BLCOK_DATA_VALUE_ASCII_CODE_ZERO = "\0";
    //
    const SHARE_MEMORY_OFFSET_START = 0;
    //
    const SHARE_MEMORY_OFFSET_AUTOINCREMENT_8  = 8;
    const SHARE_MEMORY_OFFSET_AUTOINCREMENT_16 = 16;
    const SHARE_MEMORY_OFFSET_AUTOINCREMENT_32 = 32;
    const SHARE_MEMORY_OFFSET_AUTOINCREMENT_64 = 64;
    //
    const LOCK_KEY = 99999999;
}