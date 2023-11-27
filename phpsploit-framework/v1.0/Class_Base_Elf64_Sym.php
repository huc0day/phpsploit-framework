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

class Class_Base_Elf64_Sym extends Class_Base
{
    const SIZE_ST_NAME  = ( Class_Base_Elf64::SIZE_ELF64_WORD );
    const SIZE_ST_INFO  = ( Class_Base_Elf64::SIZE_UNSIGNED_CHAR );
    const SIZE_ST_OTHER = ( Class_Base_Elf64::SIZE_UNSIGNED_CHAR );
    const SIZE_ST_SHNDX = ( Class_Base_Elf64::SIZE_ELF64_HALF );
    const SIZE_ST_VALUE = ( Class_Base_Elf64::SIZE_ELF64_ADDR );
    const SIZE_ST_SIZE  = ( Class_Base_Elf64::SIZE_ELF64_XWORD );

    const PURPOSE_ST_NAME  = "";
    const PURPOSE_ST_INFO  = "";
    const PURPOSE_ST_OTHER = "";
    const PURPOSE_ST_SHNDX = "";
    const PURPOSE_ST_VALUE = "";
    const PURPOSE_ST_SIZE  = "";

    private static $_elf64_syms = array ();

    public $st_name  = null;
    public $st_info  = null;
    public $st_other = null;
    public $st_shndx = null;
    public $st_value = null;
    public $st_size  = null;

    public static function get_sym_size ()
    {
        $_sym_size = ( self::SIZE_ST_NAME + self::SIZE_ST_INFO + self::SIZE_ST_OTHER + self::SIZE_ST_SHNDX + self::SIZE_ST_VALUE + self::SIZE_ST_SIZE );
        return $_sym_size;
    }

    public static function get_st_name_offset ()
    {
        $_offset = ( Class_Base_Elf::OFFSET_START );
        return $_offset;
    }

    public static function get_st_info_offset ()
    {
        $_offset = ( self::get_st_name_offset () + self::SIZE_ST_NAME );
        return $_offset;
    }

    public static function get_st_other_offset ()
    {
        $_offset = ( self::get_st_info_offset () + self::SIZE_ST_INFO );
        return $_offset;
    }

    public static function get_st_shndx_offset ()
    {
        $_offset = ( self::get_st_other_offset () + self::SIZE_ST_OTHER );
        return $_offset;
    }

    public static function get_st_value_offset ()
    {
        $_offset = ( self::get_st_shndx_offset () + self::SIZE_ST_SHNDX );
        return $_offset;
    }

    public static function get_st_size_offset ()
    {
        $_offset = ( self::get_st_value_offset () + self::SIZE_ST_VALUE );
        return $_offset;
    }


    public static function create_elf64_sym ( $filepath , $st_name , $st_info , $st_other , $st_shndx , $st_value , $st_size )
    {
        self::$_elf64_syms[ $filepath ] = new Class_Base_Elf64_Sym( $st_name , $st_info , $st_other , $st_shndx , $st_value , $st_size );
    }

    public function __construct ( $st_name , $st_info , $st_other , $st_shndx , $st_value , $st_size )
    {
        $this->st_name  = $st_name;
        $this->st_info  = $st_info;
        $this->st_other = $st_other;
        $this->st_shndx = $st_shndx;
        $this->st_value = $st_value;
        $this->st_size  = $st_size;
    }

    public function __destruct ()
    {
        $this->st_name  = null;
        $this->st_info  = null;
        $this->st_other = null;
        $this->st_shndx = null;
        $this->st_value = null;
        $this->st_size  = null;
    }

}