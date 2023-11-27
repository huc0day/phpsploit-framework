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

class Class_Base_Elf64_Program_Header extends Class_Base
{
    const ALIAS = "Elf64_Phdr";

    const SIZE_P_TYPE   = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_P_FLAGS  = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_P_OFFSET = Class_Base_Elf64::SIZE_ELF64_OFF;
    const SIZE_P_VADDR  = Class_Base_Elf64::SIZE_ELF64_ADDR;
    const SIZE_P_PADDR  = Class_Base_Elf64::SIZE_ELF64_ADDR;
    const SIZE_P_FILESZ = Class_Base_Elf64::SIZE_ELF64_XWORD;
    const SIZE_P_MEMSZ  = Class_Base_Elf64::SIZE_ELF64_XWORD;
    const SIZE_P_ALIGN  = Class_Base_Elf64::SIZE_ELF64_XWORD;


    const PURPOSE_P_TYPE   = "";
    const PURPOSE_P_FLAGS  = "";
    const PURPOSE_P_OFFSET = "";
    const PURPOSE_P_VADDR  = "";
    const PURPOSE_P_PADDR  = "";
    const PURPOSE_P_FILESZ = "";
    const PURPOSE_P_MEMSZ  = "";
    const PURPOSE_P_ALIGN  = "";

    private static $_elf64_phdrs = array ();

    public $p_type   = null;
    public $p_flags  = null;
    public $p_offset = null;
    public $p_vaddr  = null;
    public $p_paddr  = null;
    public $p_filesz = null;
    public $p_memsz  = null;
    public $p_align  = null;

    public static function get_program_header_size ()
    {
        $_program_header_size = ( self::SIZE_P_TYPE + self::SIZE_P_FLAGS + self::SIZE_P_OFFSET + self::SIZE_P_VADDR + self::SIZE_P_PADDR + self::SIZE_P_FILESZ + self::SIZE_P_MEMSZ + self::SIZE_P_ALIGN );
        return $_program_header_size;
    }

    public static function get_p_type_offset ()
    {
        $_offset = ( Class_Base_Elf::OFFSET_START );
        return $_offset;
    }

    public static function get_p_flags_offset ()
    {
        $_offset = ( self::get_p_type_offset () + self::SIZE_P_TYPE );
        return $_offset;
    }

    public static function get_p_offset_offset ()
    {
        $_offset = ( self::get_p_flags_offset () + self::SIZE_P_FLAGS );
        return $_offset;
    }

    public static function get_p_vaddr_offset ()
    {
        $_offset = ( self::get_p_offset_offset () + self::SIZE_P_OFFSET );
        return $_offset;
    }

    public static function get_p_paddr_offset ()
    {
        $_offset = ( self::get_p_vaddr_offset () + self::SIZE_P_VADDR );
        return $_offset;
    }

    public static function get_p_filesz_offset ()
    {
        $_offset = ( self::get_p_paddr_offset () + self::SIZE_P_PADDR );
        return $_offset;
    }

    public static function get_p_memsz_offset ()
    {
        $_offset = ( self::get_p_filesz_offset () + self::SIZE_P_FILESZ );
        return $_offset;
    }

    public static function get_p_align_offset ()
    {
        $_offset = ( self::get_p_memsz_offset () + self::SIZE_P_MEMSZ );
        return $_offset;
    }

    public static function create_elf64_phdr ( $filepath , $p_type , $p_flags , $p_offset , $p_vaddr , $p_paddr , $p_filesz , $p_memsz , $p_align )
    {
        self::$_elf64_phdrs[ $filepath ] = $_elf64_phdr = new Class_Base_Elf64_Program_Header( $p_type , $p_flags , $p_offset , $p_vaddr , $p_paddr , $p_filesz , $p_memsz , $p_align );
        return $_elf64_phdr;
    }

    public function __construct ( $p_type , $p_flags , $p_offset , $p_vaddr , $p_paddr , $p_filesz , $p_memsz , $p_align )
    {
        $this->p_type   = $p_type;
        $this->p_flags  = $p_flags;
        $this->p_offset = $p_offset;
        $this->p_vaddr  = $p_vaddr;
        $this->p_paddr  = $p_paddr;
        $this->p_filesz = $p_filesz;
        $this->p_memsz  = $p_memsz;
        $this->p_align  = $p_align;
    }

    public function __destruct ()
    {
        $this->p_type   = null;
        $this->p_flags  = null;
        $this->p_offset = null;
        $this->p_vaddr  = null;
        $this->p_paddr  = null;
        $this->p_filesz = null;
        $this->p_memsz  = null;
        $this->p_align  = null;
    }

    public function get_p_type ()
    {
        if ( ( is_string ( $this->p_type ) ) && ( strlen ( $this->p_type ) == 4 ) ) {
            $_p_type = ( ( Class_Base_Elf::unpack ( substr ( $this->p_type , 0 , 4 ) , "V*" ) ) );
            return $_p_type;
        }
        return false;
    }

    public function get_p_flags ()
    {
        if ( ( is_string ( $this->p_flags ) ) && ( strlen ( $this->p_flags ) == 4 ) ) {
            $_p_flags = ( ( Class_Base_Elf::unpack ( substr ( $this->p_flags , 0 , 4 ) , "V*" ) ) );
            return $_p_flags;
        }
        return false;
    }

    public function get_p_offset ()
    {
        if ( ( is_string ( $this->p_offset ) ) && ( strlen ( $this->p_offset ) == 8 ) ) {
            $_p_offset = ( ( Class_Base_Elf::unpack ( substr ( $this->p_offset , 0 , 8 ) , "Q*" ) ) );
            return $_p_offset;
        }
        return false;
    }

    public function get_p_vaddr ()
    {
        if ( ( is_string ( $this->p_vaddr ) ) && ( strlen ( $this->p_vaddr ) == 8 ) ) {
            $_p_vaddr = ( ( Class_Base_Elf::unpack ( substr ( $this->p_vaddr , 0 , 8 ) , "Q*" ) ) );
            return $_p_vaddr;
        }
        return false;
    }

    public function get_p_paddr ()
    {
        if ( ( is_string ( $this->p_paddr ) ) && ( strlen ( $this->p_paddr ) == 8 ) ) {
            $_p_paddr = ( ( Class_Base_Elf::unpack ( substr ( $this->p_paddr , 0 , 8 ) , "Q*" ) ) );
            return $_p_paddr;
        }
        return false;
    }

    public function get_p_filesz ()
    {
        if ( ( is_string ( $this->p_filesz ) ) && ( strlen ( $this->p_filesz ) == 8 ) ) {
            $_p_filesz = ( ( Class_Base_Elf::unpack ( substr ( $this->p_filesz , 0 , 8 ) , "Q*" ) ) );
            return $_p_filesz;
        }
        return false;
    }

    public function get_p_memsz ()
    {
        if ( ( is_string ( $this->p_memsz ) ) && ( strlen ( $this->p_memsz ) == 8 ) ) {
            $_p_memsz = ( ( Class_Base_Elf::unpack ( substr ( $this->p_memsz , 0 , 8 ) , "Q*" ) ) );
            return $_p_memsz;
        }
        return false;
    }

    public function get_p_align ()
    {
        if ( ( is_string ( $this->p_align ) ) && ( strlen ( $this->p_align ) == 8 ) ) {
            $_p_align = ( ( Class_Base_Elf::unpack ( substr ( $this->p_align , 0 , 8 ) , "Q*" ) ) );
            return $_p_align;
        }
        return false;
    }

    public function get_format_program_header ()
    {
        $_format_program_header = array ();

        $_format_program_header[ "p_type" ]       = $this->get_p_type ();
        $_format_program_header[ "p_type_name" ]  = Class_Base_Elf::get_pt_type_name ( $this->get_p_type () );
        $_format_program_header[ "hex_p_type" ]   = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_type () ) );
        $_format_program_header[ "p_flags" ]      = $this->get_p_flags ();
        $_format_program_header[ "hex_p_flags" ]  = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_flags () ) );
        $_format_program_header[ "p_offset" ]     = $this->get_p_offset ();
        $_format_program_header[ "hex_p_offset" ] = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_offset () ) );
        $_format_program_header[ "p_vaddr" ]      = $this->get_p_vaddr ();
        $_format_program_header[ "hex_p_vaddr" ]  = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_vaddr () ) );
        $_format_program_header[ "p_paddr" ]      = $this->get_p_paddr ();
        $_format_program_header[ "hex_p_paddr" ]  = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_paddr () ) );
        $_format_program_header[ "p_filesz" ]     = $this->get_p_filesz ();
        $_format_program_header[ "hex_p_filesz" ] = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_filesz () ) );
        $_format_program_header[ "p_memsz" ]      = $this->get_p_memsz ();
        $_format_program_header[ "hex_p_memsz" ]  = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_memsz () ) );
        $_format_program_header[ "p_align" ]      = $this->get_p_align ();
        $_format_program_header[ "hex_p_align" ]  = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_p_align () ) );

        return $_format_program_header;
    }

}