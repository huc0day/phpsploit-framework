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

interface Interface_Base_BlockHead extends Interface_Base , Interface_Base_BlockName , Interface_Base_BlockKey , Interface_Base_BlockSize , Interface_Base_BlockStatus , Interface_Base_BlockMode , Interface_Base_BlockType , Interface_Base_BlockContentType , Interface_Base_BlockReserved , Interface_Base_BlockHeadEndFlag
{
    const SIZE_BLOCK_HEAD              = 128;
    const SIZE_BLOCK_HEAD_BLOCK_NAME   = 64;
    const SIZE_BLOCK_HEAD_BLOCK_KEY    = 16;
    const SIZE_BLOCK_HEAD_CONTENT_SIZE = 16;
    const SIZE_BLOCK_HEAD_BLOCK_STATUS = 1;
    const SIZE_BLOCK_HEAD_BLOCK_MODE   = 3;
    const SIZE_BLOCK_HEAD_BLOCK_TYPE   = 4;
    const SIZE_BLOCK_HEAD_CONTENT_TYPE = 4;
    const SIZE_BLOCK_HEAD_RESERVED     = 12;
    const SIZE_BLOCK_HEAD_END_FLAG     = 8;
    const FLAG_BLOCK_HEAD_END          = "55AA55AA";
}