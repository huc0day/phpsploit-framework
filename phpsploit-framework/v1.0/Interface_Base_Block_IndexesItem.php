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

interface Interface_Base_Block_IndexesItem extends Interface_Base
{
    const SIZE_BLOCK_INDEXES_ITEM              = 128;
    const SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME   = 64;
    const SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY    = 16;
    const SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE = 16;
    const SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS = 1;
    const SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE   = 3;
    const SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE   = 4;
    const SIZE_BLOCK_INDEXES_ITEM_CONTENT_TYPE = 4;
    const SIZE_BLOCK_INDEXES_ITEM_RESERVED     = 12;
    const SIZE_BLOCK_INDEXES_ITEM_END_FLAG     = 8;
    const FLAG_BLOCK_INDEXES_ITEM_END          = "0X900X90";
    const OFFSET_BLOCK_INDEXES_ITEM_START      = 0;
}