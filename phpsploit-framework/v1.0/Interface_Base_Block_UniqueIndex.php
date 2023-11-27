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

interface Interface_Base_Block_UniqueIndex extends Interface_Base
{
    const NAME                  = "UNIQUE_INDEX";
    const KEY                   = 300000000000000001;
    const INDEX_START           = 100000000000000001;
    const INDEX_LIMIT           = 999999999999999999;
    const INDEX_NAME            = "BLOCK_UNIQUE_INDEX";
    const SIZE_DEC_INTEGER      = 18;
    const SIZE_HEX_INTEGER      = 16;
    const SIZE_BLOCK            = 152;
    const VALUE_STATUS_DISABLED = 0;
    const VALUE_STATUS_ENABLED  = 1;

}