<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-22
 * Time: 下午10:27
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

interface Interface_Base_Format extends Interface_Base_FormatType
{
    const STRING_MIN_LENGTH          = 0;
    const STRING_MAX_LENGTH          = 999999999999999999;
    const INTEGER_MIN_VALUE          = 0;
    const INTEGER_MAX_VALUE          = 999999999999999999;
    const HEX_MIN_VALUE              = 0x0000000000000000;
    const HEX_MAX_VALUE              = 0x0de0b6b3a763ffff;
    const HEX_KEY_MIN_VALUE          = 0x001634585D8A0001;
    const HEX_KEY_MAX_VALUE          = 0x0DE0B6B3A763FFFF;
    const INTEGER_MIN_LENGTH         = 1;
    const INTEGER_MAX_LENGTH         = 18;
    const OCT_MAX_VALUE              = 067405553164730777777;
    const OCT_MIN_LENGTH             = 1;
    const OCT_MAX_LENGTH             = 20;
    const HEX_MIN_LENGTH             = 1;
    const HEX_MAX_LENGTH             = 16;
    const PORT_MIN_VALUE             = 0;
    const PORT_MAX_VALUE             = 65535;
    const SIZE_INTEGER_SPACE         = 16;
    const CHAR_ZERO                  = '0';
    const ASCII_CODE_ZERO            = "\0";
    const INTEGER_BOOLEAN_TRUE       = 1;
    const INTEGER_BOOLEAN_FALSE      = 0;
    const OFFSET_BLOCK_MIN           = 0;
    const OFFSET_BLOCK_MAX           = 1048448;
    const OFFSET_BLOCK_AUTOINCREMENT = 128;
    const OFFSET_BLOCK_COUNT         = 8192;

    const DATA_FORMAT_STRING_NULL_FILL_PACK      = "a*";
    const DATA_FORMAT_64_INTEGER_PACK            = "a*";
    const DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK = 1001;
    const DATA_FORMAT_TYPE_64_INTEGER_PACK       = 2001;
}