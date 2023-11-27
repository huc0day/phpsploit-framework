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

class Class_Base_Elf64_File_Header extends Class_Base_Elf
{
    const ALIAS = 'Elf64_Ehdr';

    const SIZE_E_IDENT     = SIZE_UNSIGNED_CHAR_16;
    const SIZE_E_TYPE      = Class_Base_Elf64::SIZE_ELF64_HALF;
    const SIZE_E_MACHINE   = Class_Base_Elf64::SIZE_ELF64_HALF;
    const SIZE_E_VERSION   = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_E_ENTRY     = Class_Base_Elf64::SIZE_ELF64_ADDR;
    const SIZE_E_PHOFF     = Class_Base_Elf64::SIZE_ELF64_OFF;
    const SIZE_E_SHOFF     = Class_Base_Elf64::SIZE_ELF64_OFF;
    const SIZE_E_FLAGS     = Class_Base_Elf64::SIZE_ELF64_WORD;
    const SIZE_E_EHSIZE    = Class_Base_Elf64::SIZE_ELF64_HALF;
    const SIZE_E_PHENTSIZE = Class_Base_Elf64::SIZE_ELF64_HALF;
    const SIZE_E_PHNUM     = Class_Base_Elf64::SIZE_ELF64_HALF;
    const SIZE_E_SHENTSIZE = Class_Base_Elf64::SIZE_ELF64_HALF;
    const SIZE_E_SHNUM     = Class_Base_Elf64::SIZE_ELF64_HALF;
    const SIZE_E_SHSTRNDX  = Class_Base_Elf64::SIZE_ELF64_HALF;

    const PURPOSE_E_IDENT     = "ELF identification";
    const PURPOSE_E_TYPE      = "Object file type";
    const PURPOSE_E_MACHINE   = "Machine type";
    const PURPOSE_E_VERSION   = "Object file version";
    const PURPOSE_E_ENTRY     = "Entry point address";
    const PURPOSE_E_PHOFF     = "Program header offset";
    const PURPOSE_E_SHOFF     = "Section header offset";
    const PURPOSE_E_FLAGS     = "Processor-specific flags";
    const PURPOSE_E_EHSIZE    = "ELF header size";
    const PURPOSE_E_PHENTSIZE = "Size of program header entry";
    const PURPOSE_E_PHNUM     = "Number of program header entries";
    const PURPOSE_E_SHENTSIZE = "Size of section header entry";
    const PURPOSE_E_SHNUM     = "Number of section header entries";
    const PURPOSE_E_SHSTRNDX  = "Section name string table index";

    private static $_elf64_ehdrs = array ();

    public $e_ident     = null;
    public $e_type      = null;
    public $e_machine   = null;
    public $e_version   = null;
    public $e_entry     = null;
    public $e_phoff     = null;
    public $e_shoff     = null;
    public $e_flags     = null;
    public $e_ehsize    = null;
    public $e_phentsize = null;
    public $e_phnum     = null;
    public $e_shentsize = null;
    public $e_shnum     = null;
    public $e_shstrndx  = null;


    public static function create_elf64_ehdr ( $filepath , $e_ident , $e_type , $e_machine , $e_version , $e_entry , $e_phoff , $e_shoff , $e_flags , $e_ehsize , $e_phentsize , $e_phnum , $e_shentsize , $e_shnum , $e_shstrndx )
    {
        self::$_elf64_ehdrs[ $filepath ] = $_elf64_ehdr = new Class_Base_Elf64_File_Header( $e_ident , $e_type , $e_machine , $e_version , $e_entry , $e_phoff , $e_shoff , $e_flags , $e_ehsize , $e_phentsize , $e_phnum , $e_shentsize , $e_shnum , $e_shstrndx );
        return $_elf64_ehdr;
    }

    public function __construct ( $e_ident , $e_type , $e_machine , $e_version , $e_entry , $e_phoff , $e_shoff , $e_flags , $e_ehsize , $e_phentsize , $e_phnum , $e_shentsize , $e_shnum , $e_shstrndx )
    {
        $this->e_ident     = $e_ident;
        $this->e_type      = $e_type;
        $this->e_machine   = $e_machine;
        $this->e_version   = $e_version;
        $this->e_entry     = $e_entry;
        $this->e_phoff     = $e_phoff;
        $this->e_shoff     = $e_shoff;
        $this->e_flags     = $e_flags;
        $this->e_ehsize    = $e_ehsize;
        $this->e_phentsize = $e_phentsize;
        $this->e_phnum     = $e_phnum;
        $this->e_shentsize = $e_shentsize;
        $this->e_shnum     = $e_shnum;
        $this->e_shstrndx  = $e_shstrndx;
    }

    public function __destruct ()
    {
        $this->e_ident     = null;
        $this->e_type      = null;
        $this->e_machine   = null;
        $this->e_version   = null;
        $this->e_entry     = null;
        $this->e_phoff     = null;
        $this->e_shoff     = null;
        $this->e_flags     = null;
        $this->e_ehsize    = null;
        $this->e_phentsize = null;
        $this->e_phnum     = null;
        $this->e_shentsize = null;
        $this->e_shnum     = null;
        $this->e_shstrndx  = null;
    }

    public static function get_alias ()
    {
        return self::ALIAS;
    }

    public static function get_file_header_offset ()
    {
        $_offset = ( self::get_e_ident_offset () );
        return $_offset;
    }

    public static function get_file_header_size ()
    {
        $_file_header_size = ( self::SIZE_E_IDENT + self::SIZE_E_TYPE + self::SIZE_E_MACHINE + self::SIZE_E_VERSION + self::SIZE_E_ENTRY + self::SIZE_E_PHOFF + self::SIZE_E_SHOFF + self::SIZE_E_FLAGS + self::SIZE_E_EHSIZE + self::SIZE_E_PHENTSIZE + self::SIZE_E_PHNUM + self::SIZE_E_SHENTSIZE + self::SIZE_E_SHNUM + self::SIZE_E_SHSTRNDX );
        return $_file_header_size;
    }

    public static function get_e_ident_offset ()
    {
        $_offset = ( Class_Base_Elf::OFFSET_START );
        return $_offset;
    }

    public static function get_e_type_offset ()
    {
        $_offset = ( self::get_e_ident_offset () + self::SIZE_E_IDENT );
        return $_offset;
    }

    public static function get_e_machine_offset ()
    {
        $_offset = ( self::get_e_type_offset () + self::SIZE_E_TYPE );
        return $_offset;
    }

    public static function get_e_version_offset ()
    {
        $_offset = ( self::get_e_machine_offset () + self::SIZE_E_MACHINE );
        return $_offset;
    }

    public static function get_e_entry_offset ()
    {
        $_offset = ( self::get_e_version_offset () + self::SIZE_E_VERSION );
        return $_offset;
    }

    public static function get_e_phoff_offset ()
    {
        $_offset = ( self::get_e_entry_offset () + self::SIZE_E_ENTRY );
        return $_offset;
    }

    public static function get_e_shoff_offset ()
    {
        $_offset = ( self::get_e_phoff_offset () + self::SIZE_E_PHOFF );
        return $_offset;
    }

    public static function get_e_flags_offset ()
    {
        $_offset = ( self::get_e_shoff_offset () + self::SIZE_E_SHOFF );
        return $_offset;
    }

    public static function get_e_ehsize_offset ()
    {
        $_offset = ( self::get_e_flags_offset () + self::SIZE_E_FLAGS );
        return $_offset;
    }

    public static function get_e_phentsize_offset ()
    {
        $_offset = ( self::get_e_ehsize_offset () + self::SIZE_E_EHSIZE );
        return $_offset;
    }

    public static function get_e_phnum_offset ()
    {
        $_offset = ( self::get_e_phentsize_offset () + self::SIZE_E_PHENTSIZE );
        return $_offset;
    }

    public static function get_e_shentsize_offset ()
    {
        $_offset = ( self::get_e_phnum_offset () + self::SIZE_E_PHNUM );
        return $_offset;
    }

    public static function get_e_shnum_offset ()
    {
        $_offset = ( self::get_e_shentsize_offset () + self::SIZE_E_SHENTSIZE );
        return $_offset;
    }

    public static function get_e_shstrndx_offset ()
    {
        $_offset = ( self::get_e_shnum_offset () + self::SIZE_E_SHNUM );
        return $_offset;
    }

    public function get_ei_magic_number ()
    {
        if ( ( is_string ( $this->e_ident ) ) && ( strlen ( $this->e_ident ) == 16 ) ) {
            $_magic_number = Class_Base_Format::get_format_hex_content ( substr ( $this->e_ident , 0 , 4 ) );
            return $_magic_number;
        }
        return false;
    }

    public function get_ei_class ()
    {
        if ( ( is_string ( $this->e_ident ) ) && ( strlen ( $this->e_ident ) == 16 ) ) {
            $_ei_class = Class_Base_Elf::unpack ( substr ( $this->e_ident , 4 , 1 ) , "C" );
            return $_ei_class;
        }
        return false;
    }

    public function get_ei_data ()
    {
        if ( ( is_string ( $this->e_ident ) ) && ( strlen ( $this->e_ident ) == 16 ) ) {
            $_ei_class = Class_Base_Elf::unpack ( substr ( $this->e_ident , 5 , 1 ) , "C" );
            return $_ei_class;
        }
        return false;
    }

    public function get_ei_version ()
    {
        if ( ( is_string ( $this->e_ident ) ) && ( strlen ( $this->e_ident ) == 16 ) ) {
            $_ei_class = Class_Base_Elf::unpack ( substr ( $this->e_ident , 6 , 1 ) , "C" );
            return $_ei_class;
        }
        return false;
    }

    public function get_ei_osabi ()
    {
        if ( ( is_string ( $this->e_ident ) ) && ( strlen ( $this->e_ident ) == 16 ) ) {
            $_ei_class = Class_Base_Elf::unpack ( substr ( $this->e_ident , 7 , 1 ) , "C" );
            return $_ei_class;
        }
        return false;
    }

    public function get_ei_abiversion ()
    {
        if ( ( is_string ( $this->e_ident ) ) && ( strlen ( $this->e_ident ) == 16 ) ) {
            $_ei_class = Class_Base_Elf::unpack ( substr ( $this->e_ident , 8 , 1 ) , "C" );
            return $_ei_class;
        }
        return false;
    }

    public function get_ei_pad ()
    {
        if ( ( is_string ( $this->e_ident ) ) && ( strlen ( $this->e_ident ) == 16 ) ) {
            $_ei_class = Class_Base_Format::get_format_hex_content ( substr ( $this->e_ident , 9 , 7 ) );
            return $_ei_class;
        }
        return false;
    }

    public function get_e_ident ()
    {
        $_hexs = Class_Base_Format::get_format_hex_content ( $this->e_ident );
        return $_hexs;
    }

    public function get_e_type ()
    {
        if ( ( is_string ( $this->e_type ) ) && ( strlen ( $this->e_type ) == 2 ) ) {
            $_elf_type = Class_Base_Elf::unpack ( substr ( $this->e_type , 0 , 2 ) , "v*" );
            return $_elf_type;
        }
        return false;
    }

    public function get_e_machine ()
    {
        if ( ( is_string ( $this->e_machine ) ) && ( strlen ( $this->e_machine ) == 2 ) ) {
            $_elf_machine = Class_Base_Elf::unpack ( substr ( $this->e_machine , 0 , 2 ) , "v*" );
            return $_elf_machine;
        }
        return false;
    }

    public function get_e_version ()
    {
        if ( ( is_string ( $this->e_version ) ) && ( strlen ( $this->e_version ) == 4 ) ) {
            $_elf_version = Class_Base_Elf::unpack ( substr ( $this->e_version , 0 , 4 ) , "V*" );
            return $_elf_version;
        }
        return false;
    }

    public function get_e_entry ()
    {
        if ( ( is_string ( $this->e_entry ) ) && ( strlen ( $this->e_entry ) == 8 ) ) {
            $_elf_entry = ( ( Class_Base_Elf::unpack ( substr ( $this->e_entry , 0 , 8 ) , "Q*" ) ) );
            return $_elf_entry;
        }
        return false;
    }

    public function get_e_phoff ()
    {
        if ( ( is_string ( $this->e_phoff ) ) && ( strlen ( $this->e_phoff ) == 8 ) ) {
            $_elf_phoff = ( ( Class_Base_Elf::unpack ( substr ( $this->e_phoff , 0 , 8 ) , "Q*" ) ) );
            return $_elf_phoff;
        }
        return false;
    }

    public function get_e_shoff ()
    {
        if ( ( is_string ( $this->e_shoff ) ) && ( strlen ( $this->e_shoff ) == 8 ) ) {
            $_elf_shoff = ( ( Class_Base_Elf::unpack ( substr ( $this->e_shoff , 0 , 8 ) , "Q*" ) ) );
            return $_elf_shoff;
        }
        return false;
    }

    public function get_e_flags ()
    {
        if ( ( is_string ( $this->e_flags ) ) && ( strlen ( $this->e_flags ) == 4 ) ) {
            $_elf_flags = ( ( Class_Base_Elf::unpack ( substr ( $this->e_flags , 0 , 4 ) , "V*" ) ) );
            return $_elf_flags;
        }
        return false;
    }

    public function get_e_ehsize ()
    {
        if ( ( is_string ( $this->e_ehsize ) ) && ( strlen ( $this->e_ehsize ) == 2 ) ) {
            $_elf_ehsize = ( ( Class_Base_Elf::unpack ( substr ( $this->e_ehsize , 0 , 2 ) , "v*" ) ) );
            return $_elf_ehsize;
        }
        return false;
    }

    public function get_e_phentsize ()
    {
        if ( ( is_string ( $this->e_phentsize ) ) && ( strlen ( $this->e_phentsize ) == 2 ) ) {
            $_elf_phentsize = ( ( Class_Base_Elf::unpack ( substr ( $this->e_phentsize , 0 , 2 ) , "v*" ) ) );
            return $_elf_phentsize;
        }
        return false;
    }

    public function get_e_phnum ()
    {
        if ( ( is_string ( $this->e_phnum ) ) && ( strlen ( $this->e_phnum ) == 2 ) ) {
            $_elf_phnum = ( ( Class_Base_Elf::unpack ( substr ( $this->e_phnum , 0 , 2 ) , "v*" ) ) );
            return $_elf_phnum;
        }
        return false;
    }

    public function get_e_shentsize ()
    {
        if ( ( is_string ( $this->e_shentsize ) ) && ( strlen ( $this->e_shentsize ) == 2 ) ) {
            $_elf_shentsize = ( ( Class_Base_Elf::unpack ( substr ( $this->e_shentsize , 0 , 2 ) , "v*" ) ) );
            return $_elf_shentsize;
        }
        return false;
    }

    public function get_e_shnum ()
    {
        if ( ( is_string ( $this->e_shnum ) ) && ( strlen ( $this->e_shnum ) == 2 ) ) {
            $_elf_shnum = ( ( Class_Base_Elf::unpack ( substr ( $this->e_shnum , 0 , 2 ) , "v*" ) ) );
            return $_elf_shnum;
        }
        return false;
    }

    public function get_e_shstrndx ()
    {
        if ( ( is_string ( $this->e_shstrndx ) ) && ( strlen ( $this->e_shstrndx ) == 2 ) ) {
            $_elf_shstrndx = ( ( Class_Base_Elf::unpack ( substr ( $this->e_shstrndx , 0 , 2 ) , "v*" ) ) );
            return $_elf_shstrndx;
        }
        return false;
    }

    public function get_format_file_header ()
    {
        $_format_file_header = array ();

        $_format_file_header[ "e_ident" ]                        = array ();
        $_format_file_header[ "e_ident" ][ "ei_magic_number" ]   = $this->get_ei_magic_number ();
        $_format_file_header[ "e_ident" ][ "ei_class" ]          = $this->get_ei_class ();
        $_format_file_header[ "e_ident" ][ "hex_ei_class" ]      = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_ei_class () ) );
        $_format_file_header[ "e_ident" ][ "ei_data" ]           = $this->get_ei_data ();
        $_format_file_header[ "e_ident" ][ "hex_ei_data" ]       = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_ei_data () ) );
        $_format_file_header[ "e_ident" ][ "ei_version" ]        = $this->get_ei_version ();
        $_format_file_header[ "e_ident" ][ "hex_ei_version" ]    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_ei_version () ) );
        $_format_file_header[ "e_ident" ][ "ei_osabi" ]          = $this->get_ei_osabi ();
        $_format_file_header[ "e_ident" ][ "hex_ei_osabi" ]      = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_ei_osabi () ) );
        $_format_file_header[ "e_ident" ][ "ei_abiversion" ]     = $this->get_ei_abiversion ();
        $_format_file_header[ "e_ident" ][ "hex_ei_abiversion" ] = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_ei_abiversion () ) );
        $_format_file_header[ "e_ident" ][ "ei_pad" ]            = $this->get_ei_pad ();
        $_format_file_header[ "e_type" ]                         = $this->get_e_type ();
        $_format_file_header[ "hex_e_type" ]                     = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_type () ) );
        $_format_file_header[ "e_machine" ]                      = $this->get_e_machine ();
        $_format_file_header[ "hex_e_machine" ]                  = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_machine () ) );
        $_format_file_header[ "e_version" ]                      = $this->get_e_version ();
        $_format_file_header[ "hex_e_version" ]                  = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_version () ) );
        $_format_file_header[ "e_entry" ]                        = $this->get_e_entry ();
        $_format_file_header[ "hex_e_entry" ]                    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_entry () ) );
        $_format_file_header[ "e_phoff" ]                        = $this->get_e_phoff ();
        $_format_file_header[ "hex_e_phoff" ]                    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_phoff () ) );
        $_format_file_header[ "e_shoff" ]                        = $this->get_e_shoff ();
        $_format_file_header[ "hex_e_shoff" ]                    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_shoff () ) );
        $_format_file_header[ "e_flags" ]                        = $this->get_e_flags ();
        $_format_file_header[ "hex_e_flags" ]                    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_flags () ) );
        $_format_file_header[ "e_ehsize" ]                       = $this->get_e_ehsize ();
        $_format_file_header[ "hex_e_ehsize" ]                   = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_ehsize () ) );
        $_format_file_header[ "e_phentsize" ]                    = $this->get_e_phentsize ();
        $_format_file_header[ "hex_e_phentsize" ]                = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_phentsize () ) );
        $_format_file_header[ "e_phnum" ]                        = $this->get_e_phnum ();
        $_format_file_header[ "hex_e_phnum" ]                    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_phnum () ) );
        $_format_file_header[ "e_shentsize" ]                    = $this->get_e_shentsize ();
        $_format_file_header[ "hex_e_shentsize" ]                = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_shentsize () ) );
        $_format_file_header[ "e_shnum" ]                        = $this->get_e_shnum ();
        $_format_file_header[ "hex_e_shnum" ]                    = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_shnum () ) );
        $_format_file_header[ "e_shstrndx" ]                     = $this->get_e_shstrndx ();
        $_format_file_header[ "hex_e_shstrndx" ]                 = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $this->get_e_shstrndx () ) );

        return $_format_file_header;
    }

    public function get_program_header_offset ()
    {
        $_program_header_offset = $this->get_e_phoff ();
        return $_program_header_offset;
    }

    public function get_program_header_size ()
    {
        $_program_header_size = $this->get_e_phentsize ();
        return $_program_header_size;
    }

    public function get_program_header_count ()
    {
        $_program_header_count = $this->get_e_phnum ();
        return $_program_header_count;
    }

    public function get_section_header_offset ()
    {
        $_section_header_offset = $this->get_e_shoff ();
        return $_section_header_offset;
    }

    public function get_section_header_size ()
    {
        $_section_header_offset = $this->get_e_shentsize ();
        return $_section_header_offset;
    }

    public function get_section_header_count ()
    {
        $_section_header_count = $this->get_e_shnum ();
        return $_section_header_count;
    }

    public function get_section_header_sym_table_index ()
    {
        $_section_header_sym_table_index = $this->get_e_shstrndx ();
        return $_section_header_sym_table_index;
    }

}