<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-4
 * Time: 下午8:30
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

class Class_Base_Elf64_Section_Header
{
    const ALIAS = 'Elf64_Shdr';

    const SIZE_SH_NAME      = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_SH_TYPE      = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_SH_FLAGS     = Class_Base_Elf64::SIZE_ELF64_XWORD;
    const SIZE_SH_ADDR      = Class_Base_Elf64::SIZE_ELF64_ADDR;
    const SIZE_SH_OFFSET    = Class_Base_Elf64::SIZE_ELF64_OFF;
    const SIZE_SH_SIZE      = Class_Base_Elf64::SIZE_ELF64_XWORD;
    const SIZE_SH_LINK      = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_SH_INFO      = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_SH_ADDRALIGN = Class_Base_Elf64::SIZE_ELF64_XWORD;
    const SIZE_SH_ENTSIZE   = Class_Base_Elf64::SIZE_ELF64_XWORD;


    const PURPOSE_SH_NAME      = "";
    const PURPOSE_SH_TYPE      = "";
    const PURPOSE_SH_FLAGS     = "";
    const PURPOSE_SH_ADDR      = "";
    const PURPOSE_SH_OFFSET    = "";
    const PURPOSE_SH_SIZE      = "";
    const PURPOSE_SH_LINK      = "";
    const PURPOSE_SH_INFO      = "";
    const PURPOSE_SH_ADDRALIGN = "";
    const PURPOSE_SH_ENTSIZE   = "";

    private static $_elf64_shdrs = array ();

    public $sh_name      = null;
    public $sh_type      = null;
    public $sh_flags     = null;
    public $sh_addr      = null;
    public $sh_offset    = null;
    public $sh_size      = null;
    public $sh_link      = null;
    public $sh_info      = null;
    public $sh_addralign = null;
    public $sh_entsize   = null;

    public static function get_section_header_size ()
    {
        $_section_header_size = ( self::SIZE_SH_NAME + self::SIZE_SH_TYPE + self::SIZE_SH_FLAGS + self::SIZE_SH_ADDR + self::SIZE_SH_OFFSET + self::SIZE_SH_SIZE + self::SIZE_SH_LINK + self::SIZE_SH_INFO + self::SIZE_SH_ADDRALIGN + self::SIZE_SH_ENTSIZE );
        return $_section_header_size;
    }

    public static function get_sh_name_offset ()
    {
        $_offset = ( Class_Base_Elf::OFFSET_START );
        return $_offset;
    }

    public static function get_sh_type_offset ()
    {
        $_offset = ( self::get_sh_name_offset () + self::SIZE_SH_NAME );
        return $_offset;
    }

    public static function get_sh_flags_offset ()
    {
        $_offset = ( self::get_sh_type_offset () + self::SIZE_SH_TYPE );
        return $_offset;
    }

    public static function get_sh_addr_offset ()
    {
        $_offset = ( self::get_sh_flags_offset () + self::SIZE_SH_FLAGS );
        return $_offset;
    }

    public static function get_sh_offset_offset ()
    {
        $_offset = ( self::get_sh_addr_offset () + self::SIZE_SH_ADDR );
        return $_offset;
    }

    public static function get_sh_size_offset ()
    {
        $_offset = ( self::get_sh_offset_offset () + self::SIZE_SH_OFFSET );
        return $_offset;
    }

    public static function get_sh_link_offset ()
    {
        $_offset = ( self::get_sh_size_offset () + self::SIZE_SH_SIZE );
        return $_offset;
    }

    public static function get_sh_info_offset ()
    {
        $_offset = ( self::get_sh_link_offset () + self::SIZE_SH_LINK );
        return $_offset;
    }

    public static function get_sh_addralign_offset ()
    {
        $_offset = ( self::get_sh_info_offset () + self::SIZE_SH_INFO );
        return $_offset;
    }

    public static function get_sh_entsize_offset ()
    {
        $_offset = ( self::get_sh_addralign_offset () + self::SIZE_SH_ADDRALIGN );
        return $_offset;
    }

    public static function create_elf64_shdr ( $filepath , $sh_name , $sh_type , $sh_flags , $sh_addr , $sh_offset , $sh_size , $sh_link , $sh_info , $sh_addralign , $sh_entsize )
    {
        self::$_elf64_shdrs[ $filepath ] = $_elf64_ehdr = new Class_Base_Elf64_Section_Header( $sh_name , $sh_type , $sh_flags , $sh_addr , $sh_offset , $sh_size , $sh_link , $sh_info , $sh_addralign , $sh_entsize );
        return $_elf64_ehdr;
    }

    public function __construct ( $sh_name , $sh_type , $sh_flags , $sh_addr , $sh_offset , $sh_size , $sh_link , $sh_info , $sh_addralign , $sh_entsize )
    {
        $this->sh_name      = $sh_name;
        $this->sh_type      = $sh_type;
        $this->sh_flags     = $sh_flags;
        $this->sh_addr      = $sh_addr;
        $this->sh_offset    = $sh_offset;
        $this->sh_size      = $sh_size;
        $this->sh_link      = $sh_link;
        $this->sh_info      = $sh_info;
        $this->sh_addralign = $sh_addralign;
        $this->sh_entsize   = $sh_entsize;
    }

    public function __destruct ()
    {
        $this->sh_name      = null;
        $this->sh_type      = null;
        $this->sh_flags     = null;
        $this->sh_addr      = null;
        $this->sh_offset    = null;
        $this->sh_size      = null;
        $this->sh_link      = null;
        $this->sh_info      = null;
        $this->sh_addralign = null;
        $this->sh_entsize   = null;
    }

    public function get_sh_name ()
    {
        if ( ( is_string ( $this->sh_name ) ) && ( strlen ( $this->sh_name ) == 4 ) ) {
            $_sh_name = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_name , 0 , 4 ) , "V*" ) ) );
            return $_sh_name;
        }
        return false;
    }

    public function get_sh_type ()
    {
        if ( ( is_string ( $this->sh_type ) ) && ( strlen ( $this->sh_type ) == 4 ) ) {
            $_sh_type = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_type , 0 , 4 ) , "V*" ) ) );
            return $_sh_type;
        }
        return false;
    }

    public function get_sh_flags ()
    {
        if ( ( is_string ( $this->sh_flags ) ) && ( strlen ( $this->sh_flags ) == 8 ) ) {
            $_sh_flags = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_flags , 0 , 8 ) , "Q*" ) ) );
            return $_sh_flags;
        }
        return false;
    }

    public function get_sh_addr ()
    {
        if ( ( is_string ( $this->sh_addr ) ) && ( strlen ( $this->sh_addr ) == 8 ) ) {
            $_sh_addr = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_addr , 0 , 8 ) , "Q*" ) ) );
            return $_sh_addr;
        }
        return false;
    }

    public function get_sh_offset ()
    {
        if ( ( is_string ( $this->sh_offset ) ) && ( strlen ( $this->sh_offset ) == 8 ) ) {
            $_sh_offset = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_offset , 0 , 8 ) , "Q*" ) ) );
            return $_sh_offset;
        }
        return false;
    }

    public function get_sh_size ()
    {
        if ( ( is_string ( $this->sh_size ) ) && ( strlen ( $this->sh_size ) == 8 ) ) {
            $_sh_size = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_size , 0 , 8 ) , "Q*" ) ) );
            return $_sh_size;
        }
        return false;
    }

    public function get_sh_link ()
    {
        if ( ( is_string ( $this->sh_link ) ) && ( strlen ( $this->sh_link ) == 4 ) ) {
            $_sh_link = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_link , 0 , 4 ) , "V*" ) ) );
            return $_sh_link;
        }
        return false;
    }

    public function get_sh_info ()
    {
        if ( ( is_string ( $this->sh_info ) ) && ( strlen ( $this->sh_info ) == 4 ) ) {
            $_sh_info = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_info , 0 , 4 ) , "V*" ) ) );
            return $_sh_info;
        }
        return false;
    }

    public function get_sh_addralign ()
    {
        if ( ( is_string ( $this->sh_addralign ) ) && ( strlen ( $this->sh_addralign ) == 8 ) ) {
            $_sh_addralign = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_addralign , 0 , 8 ) , "Q*" ) ) );
            return $_sh_addralign;
        }
        return false;
    }

    public function get_sh_entsize ()
    {
        if ( ( is_string ( $this->sh_entsize ) ) && ( strlen ( $this->sh_entsize ) == 8 ) ) {
            $_sh_entsize = ( ( Class_Base_Elf::unpack ( substr ( $this->sh_entsize , 0 , 8 ) , "Q*" ) ) );
            return $_sh_entsize;
        }
        return false;
    }

    public function get_format_section_header ()
    {
        $_format_section_header = array ();

        $_format_section_header[ "sh_name" ]          = $this->get_sh_name ();
        $_format_section_header[ "sh_type" ]          = $this->get_sh_type ();
        $_format_section_header[ "hex_sh_type" ]      = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $_format_section_header[ "sh_type" ] ) );
        $_format_section_header[ "sh_type_name" ]     = ( empty( Class_Base_Elf::get_sh_type_name ( $_format_section_header[ "sh_type" ] ) ) ? ( "" ) : ( Class_Base_Elf::get_sh_type_name ( $_format_section_header[ "sh_type" ] ) ) );
        $_format_section_header[ "sh_flags" ]         = $this->get_sh_flags ();
        $_format_section_header[ "sh_addr" ]          = $this->get_sh_addr ();
        $_format_section_header[ "hex_sh_addr" ]      = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $_format_section_header[ "sh_addr" ] ) );
        $_format_section_header[ "sh_offset" ]        = $this->get_sh_offset ();
        $_format_section_header[ "hex_sh_offset" ]    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $_format_section_header[ "sh_offset" ] ) );
        $_format_section_header[ "sh_size" ]          = $this->get_sh_size ();
        $_format_section_header[ "hex_sh_size" ]      = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $_format_section_header[ "sh_size" ] ) );
        $_format_section_header[ "sh_link" ]          = $this->get_sh_link ();
        $_format_section_header[ "sh_info" ]          = $this->get_sh_info ();
        $_format_section_header[ "sh_addralign" ]     = $this->get_sh_addralign ();
        $_format_section_header[ "hex_sh_addralign" ] = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $_format_section_header[ "sh_addralign" ] ) );
        $_format_section_header[ "sh_entsize" ]       = $this->get_sh_entsize ();
        $_format_section_header[ "hex_sh_entsize" ]   = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $_format_section_header[ "sh_entsize" ] ) );

        return $_format_section_header;
    }

}