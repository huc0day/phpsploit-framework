<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-4
 * Time: 上午9:54
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

class Class_Base_Elf extends Class_Base
{
    const PT_NULL    = 0;
    const PT_LOAD    = 1;
    const PT_DYNAMIC = 2;
    const PT_INTERP  = 3;
    const PT_NOTE    = 4;
    const PT_SHLIB   = 5;
    const PT_PHDR    = 6;
    const PT_LOPROC  = 0x70000000;
    const PT_HIPROC  = 0x7fffffff;

    const SH_TYPE_SHT_NULL           = 0;
    const SH_TYPE_SHT_PROGBITS       = 1;
    const SH_TYPE_SHT_SYMTAB         = 2;
    const SH_TYPE_SHT_STRTAB         = 3;
    const SH_TYPE_SHT_RELA           = 4;
    const SH_TYPE_SHT_HASH           = 5;
    const SH_TYPE_SHT_DYNAMIC        = 6;
    const SH_TYPE_SHT_NOTE           = 7;
    const SH_TYPE_SHT_NOBITS         = 8;
    const SH_TYPE_SHT_REL            = 9;
    const SH_TYPE_SHT_SHLIB          = 10;
    const SH_TYPE_SHT_DYNSYM         = 11;
    const SH_TYPE_SHT_INIT_ARRAY     = 14;
    const SH_TYPE_SHT_FINI_ARRAY     = 15;
    const SH_TYPE_SHT_PREINIT_ARRAY  = 16;
    const SH_TYPE_SHT_GROUP          = 17;
    const SH_TYPE_SHT_SYMTAB_SHNDX   = 18;
    const SH_TYPE_SHT_NUM            = 19;
    const SH_TYPE_SHT_LOOS           = 0x60000000;
    const SH_TYPE_SHT_GNU_ATTRIBUTES = 0x6ffffff5;
    const SH_TYPE_SHT_GNU_HASH       = 0x6ffffff6;
    const SH_TYPE_SHT_GNU_LIBLIST    = 0x6ffffff7;
    const SH_TYPE_SHT_CHECKSUM       = 0x6ffffff8;
    const SH_TYPE_SHT_LOSUNW         = 0x6ffffffa;
    const SH_TYPE_SHT_SUNW_MOVE      = 0x6ffffffa;
    const SH_TYPE_SHT_SUNW_COMDAT    = 0x6ffffffb;
    const SH_TYPE_SHT_SUNW_SYMINFO   = 0x6ffffffc;
    const SH_TYPE_SHT_GNU_VERDEF     = 0x6ffffffd;
    const SH_TYPE_SHT_GNU_VERNEED    = 0x6ffffffe;
    const SH_TYPE_SHT_GNU_VERSYM     = 0x6fffffff;
    const SH_TYPE_SHT_HISUNW         = 0x6fffffff;
    const SH_TYPE_SHT_HIOS           = 0x6fffffff;
    const SH_TYPE_SHT_LOPROC         = 0x70000000;
    const SH_TYPE_SHT_HIPROC         = 0x7fffffff;
    const SH_TYPE_SHT_LOUSER         = 0x80000000;
    const SH_TYPE_SHT_HIUSER         = 0x8fffffff;

    private static $_pt_type_names = array (
        self::PT_NULL    => 'null' ,
        self::PT_LOAD    => 'load' ,
        self::PT_DYNAMIC => 'dynamic' ,
        self::PT_INTERP  => 'intep' ,
        self::PT_NOTE    => 'note' ,
        self::PT_SHLIB   => 'shlib' ,
        self::PT_PHDR    => 'phor' ,
        self::PT_LOPROC  => 'loproc' ,
        self::PT_HIPROC  => 'hiproc' ,
    );

    private static $_sh_type_names = array (
        self::SH_TYPE_SHT_NULL           => 'null' ,
        self::SH_TYPE_SHT_PROGBITS       => 'progbits' ,
        self::SH_TYPE_SHT_SYMTAB         => 'symtab' ,
        self::SH_TYPE_SHT_STRTAB         => 'strtab' ,
        self::SH_TYPE_SHT_RELA           => 'rela' ,
        self::SH_TYPE_SHT_HASH           => 'hash' ,
        self::SH_TYPE_SHT_DYNAMIC        => 'dynamic' ,
        self::SH_TYPE_SHT_NOTE           => 'note' ,
        self::SH_TYPE_SHT_NOBITS         => 'nobits' ,
        self::SH_TYPE_SHT_REL            => 'rel' ,
        self::SH_TYPE_SHT_SHLIB          => 'shlib' ,
        self::SH_TYPE_SHT_DYNSYM         => 'dynsym' ,
        self::SH_TYPE_SHT_INIT_ARRAY     => 'init_array' ,
        self::SH_TYPE_SHT_FINI_ARRAY     => 'fini_array' ,
        self::SH_TYPE_SHT_PREINIT_ARRAY  => 'preinit_array' ,
        self::SH_TYPE_SHT_GROUP          => 'group' ,
        self::SH_TYPE_SHT_SYMTAB_SHNDX   => 'symtab_shndx' ,
        self::SH_TYPE_SHT_NUM            => 'num' ,
        self::SH_TYPE_SHT_LOOS           => 'loos' ,
        self::SH_TYPE_SHT_GNU_ATTRIBUTES => 'gnu_attributes' ,
        self::SH_TYPE_SHT_GNU_HASH       => 'gnu_hash' ,
        self::SH_TYPE_SHT_GNU_LIBLIST    => 'gnu_liblist' ,
        self::SH_TYPE_SHT_CHECKSUM       => 'checksum' ,
        self::SH_TYPE_SHT_LOSUNW         => 'losunw' ,
        self::SH_TYPE_SHT_SUNW_MOVE      => 'sunw_move' ,
        self::SH_TYPE_SHT_SUNW_COMDAT    => 'sunw_comdat' ,
        self::SH_TYPE_SHT_SUNW_SYMINFO   => 'sunw_syminfo' ,
        self::SH_TYPE_SHT_GNU_VERDEF     => 'gnu_verdef' ,
        self::SH_TYPE_SHT_GNU_VERNEED    => 'gnu_verneed' ,
        self::SH_TYPE_SHT_GNU_VERSYM     => 'gnu_versym' ,
        self::SH_TYPE_SHT_HISUNW         => 'hisunw' ,
        self::SH_TYPE_SHT_HIOS           => 'hios' ,
        self::SH_TYPE_SHT_LOPROC         => 'loproc' ,
        self::SH_TYPE_SHT_HIPROC         => 'hiproc' ,
        self::SH_TYPE_SHT_LOUSER         => 'louser' ,
        self::SH_TYPE_SHT_HIUSER         => 'hiuser' ,
    );


    const FLAG_FORMAT_ELF  = '\x7f\x45\x4c\x46';
    const VALUE_ELFCLASS32 = 1;
    const VALUE_ELFCLASS64 = 2;

    const OFFSET_START = 0;

    private static $_values_elf_class = array ( self::VALUE_ELFCLASS32 , self::VALUE_ELFCLASS64 );

    public static function get_pt_type_name ( $pt_type )
    {
        $_pt_type_name = "unknown";
        if ( ! empty( self::$_pt_type_names[ $pt_type ] ) ) {
            return self::$_pt_type_names[ $pt_type ];
        }
        $pt_type = intval ( $pt_type );
        if ( ( $pt_type > 0x70000000 ) && ( $pt_type < 0x7fffffff ) ) {
            return "processor_specific_semantics";
        }
        return $_pt_type_name;
    }

    public static function get_sh_type_name ( $sh_type )
    {
        $_sh_type_name = "unknown";
        if ( ! empty( self::$_sh_type_names[ $sh_type ] ) ) {
            return self::$_sh_type_names[ $sh_type ];
        }
        return $_sh_type_name;
    }


    public static function is_elf_format ( $data )
    {
        if ( ( is_string ( $data ) ) && ( strlen ( $data ) >= 4 ) ) {
            $_magic_number      = substr ( $data , 0 , 4 );
            $_magic_number_hexs = Class_Base_Format::get_format_hex_content ( $_magic_number );
            if ( $_magic_number_hexs == self::FLAG_FORMAT_ELF ) {
                return true;
            }
        }
        return false;
    }

    public static function is_elf_machine ( $e_machine )
    {
        if ( is_integer ( $e_machine ) && ( $e_machine > 0 ) && ( $e_machine < 111 ) ) {
            return true;
        }
        return false;
    }

    public static function is_ei_class ( $ei_class )
    {
        $_exist = in_array ( $ei_class , self::$_values_elf_class );
        return $_exist;
    }

    public static function pack ( $data , $format = "a*" )
    {
        $_data = pack ( $format , $data );
        return $_data;
    }

    public static function unpack ( $data , $format = "a*" )
    {
        $_data = unpack ( $format , $data );
        if ( is_array ( $_data ) ) {
            $_data = $_data[ 1 ];
        }
        return $_data;
    }

    public static function dec_to_hex ( $dec , $hex_string_length = 16 )
    {
        if ( ! is_integer ( $dec ) ) {
            $dec = intval ( $dec );
        }
        $_hex     = dechex ( $dec );
        $_hex_len = strlen ( $_hex );
        if ( $_hex_len < $hex_string_length ) {
            $_hex = str_pad ( $_hex , $hex_string_length , chr ( 48 ) , STR_PAD_LEFT );
        }
        return $_hex;
    }
}