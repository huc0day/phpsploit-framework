<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-23
 * Time: 下午1:26
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

interface Interface_Base_RawSocket extends Interface_Base
{
    const TYPE_RESOURCE_SOCKET               = "RawSocket";
    const HOST_IVP4                          = "172.17.0.1";
    const HOST_IPV6                          = "2001:db8:1::242:ac11:1";
    const DOCKER_IPV4_172_17_0_2             = "172.17.0.2";
    const DOCKER_IPV4_172_17_0_3             = "172.17.0.3";
    const DOCKER_IPV4_172_17_0_4             = "172.17.0.4";
    const DOCKER_IPV6_2001_DB8_1__242_AC11_2 = "2001:db8:1::242:ac11:2";
    const DOCKER_IPV6_2001_DB8_1__242_AC11_3 = "2001:db8:1::242:ac11:3";
    const DOCKER_IPV6_2001_DB8_1__242_AC11_4 = "2001:db8:1::242:ac11:4";
}