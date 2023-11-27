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

class Class_Base_Elf64_Rel extends Class_Base
{
    const SIZE_R_OFFSET = ( Class_Base_Elf64::SIZE_ELF64_ADDR );
    const SIZE_R_INFO   = ( Class_Base_Elf64::SIZE_ELF64_XWORD );


    const PURPOSE_R_OFFSET = "";
    const PURPOSE_R_INFO   = "";


    private static $_elf64_rels = array ();

    public $r_offset = null;
    public $r_info   = null;


    public static function get_rel_size ()
    {
        $_rel_size = ( self::SIZE_R_OFFSET + self::SIZE_R_INFO );
        return $_rel_size;
    }

    public static function get_r_offset_offset ()
    {
        $_offset = ( Class_Base_Elf::OFFSET_START );
        return $_offset;
    }

    public static function get_r_info_offset ()
    {
        $_offset = ( self::get_r_offset_offset () + self::SIZE_R_OFFSET );
        return $_offset;
    }

    public static function create_elf64_rel ( $filepath , $r_offset , $r_info )
    {
        self::$_elf64_rels[ $filepath ] = new Class_Base_Elf64_Rel( $r_offset , $r_info );
    }

    public function __construct ( $r_offset , $r_info )
    {
        $this->r_offset = $r_offset;
        $this->r_info   = $r_info;

    }

    public function __destruct ()
    {
        $this->r_offset = null;
        $this->r_info   = null;
    }
}