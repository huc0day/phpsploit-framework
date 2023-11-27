<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-4
 * Time: 下午10:21
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

class Class_Base_Elf64_Dyn extends Class_Base
{
    const SIZE_D_TAG      = ( Class_Base_Elf64::SIZE_ELF64_SXWORD );
    const SIZE_D_UN_D_VAL = ( Class_Base_Elf64::SIZE_ELF64_WORD );
    const SIZE_D_UN_D_PTR = ( Class_Base_Elf64::SIZE_ELF64_ADDR );


    const PURPOSE_D_TAG      = "";
    const PURPOSE_D_UN_D_VAL = "";
    const PURPOSE_D_UN_D_PTR = "";

    private static $_dynamic    = array ();
    private static $_elf64_dyns = array ();

    public $d_tag = null;
    public $d_un  = null;


    public static function get_dyn_size ()
    {
        $_dyn_size = ( self::SIZE_D_TAG + self::SIZE_D_UN_D_PTR );
        return $_dyn_size;
    }

    public static function get_d_tag_offset ()
    {
        $_offset = ( Class_Base_Elf::OFFSET_START );
        return $_offset;
    }

    public static function get_d_un_offset ()
    {
        $_offset = ( self::get_d_tag_offset () + self::SIZE_D_TAG );
        return $_offset;
    }

    public static function create_elf64_dyn ( $filepath , $d_tag , $d_un )
    {
        self::$_elf64_dyns[ $filepath ] = new Class_Base_Elf64_Dyn( $d_tag , $d_un );
        self::$_dynamic[ $filepath ]    = self::$_elf64_dyns[ $filepath ];
    }

    public function __construct ( $d_tag , $d_un )
    {
        $this->d_tag = $d_tag;
        $this->d_un  = $d_un;

    }

    public function __destruct ()
    {
        $this->d_tag = null;
        $this->d_un  = null;
    }
}