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

class Class_Base_Elf64 extends Class_Base_Elf
{
    const TYPE_ELF64_ADDR    = "ELF64_Addr";
    const TYPE_ELF64_OFF     = "ELF64_Off";
    const TYPE_ELF64_HALF    = "ELF64_Half";
    const TYPE_ELF64_WORD    = "ELF64_Word";
    const TYPE_ELF64_SWORD   = "ELF64_Sword";
    const TYPE_ELF64_XWORD   = "ELF64_Xword";
    const TYPE_ELF64_SXWORD  = "ELF64_Sxword";
    const TYPE_UNSIGNED_CHAR = "unsigned char";

    const SIZE_ELF64_ADDR    = 8;
    const SIZE_ELF64_OFF     = 8;
    const SIZE_ELF64_HALF    = 2;
    const SIZE_ELF64_WORD    = 4;
    const SIZE_ELF64_SWORD   = 4;
    const SIZE_ELF64_XWORD   = 8;
    const SIZE_ELF64_SXWORD  = 8;
    const SIZE_UNSIGNED_CHAR = 1;

    const ALIGNMENT_ELF64_ADDR    = 8;
    const ALIGNMENT_ELF64_OFF     = 8;
    const ALIGNMENT_ELF64_HALF    = 2;
    const ALIGNMENT_ELF64_WORD    = 4;
    const ALIGNMENT_ELF64_SWORD   = 4;
    const ALIGNMENT_ELF64_XWORD   = 8;
    const ALIGNMENT_ELF64_SXWORD  = 8;
    const ALIGNMENT_UNSIGNED_CHAR = 1;

    const PURPOSE_ELF64_ADDR    = "Unsigned program address";
    const PURPOSE_ELF64_OFF     = "Unsigned file offset";
    const PURPOSE_ELF64_HALF    = "Unsigned medium integer";
    const PURPOSE_ELF64_WORD    = "Unsigned integer";
    const PURPOSE_ELF64_SWORD   = "Signed integer";
    const PURPOSE_ELF64_XWORD   = "Unsigned long integer";
    const PURPOSE_ELF64_SXWORD  = "Signed long integer";
    const PURPOSE_UNSIGNED_CHAR = "Unsigned small integer";

    public static function get_file_header_offset ()
    {
        $_offset = ( Class_Base_Elf64_File_Header::get_file_header_offset () );
        return $_offset;
    }

    public static function get_file_header_size ()
    {
        $_file_header_size = ( Class_Base_Elf64_File_Header::get_file_header_size () );
        return $_file_header_size;
    }

    public static function get_program_header_table_offset ()
    {
        $_offset = ( self::get_file_header_offset () + Class_Base_Elf64_File_Header::get_file_header_size () );
        return $_offset;
    }

    public static function get_file_info ( $file_path )
    {
        if ( ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 0 ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) && ( Class_Base_File::get_file_size ( $file_path ) > ( Class_Base_Elf64_File_Header::get_file_header_size () ) ) ) {
            $_file_point = @fopen ( $file_path , "rb" );
            if ( ! empty( $_file_point ) ) {
                $_file_info           = array ();
                $_file_head_size      = Class_Base_Elf64_File_Header::get_file_header_size ();
                $_file_header_content = @fread ( $_file_point , $_file_head_size );
                if ( ! empty( $_file_header_content ) ) {
                    $_file_header_content_size = strlen ( $_file_header_content );
                    if ( $_file_header_content_size == $_file_header_content_size ) {
                        $_file_info[ "file_header" ]     = $_file_header_object = Class_Base_Elf64_File_Header::create_elf64_ehdr (
                            $file_path ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_ident_offset () , Class_Base_Elf64_File_Header::SIZE_E_IDENT ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_type_offset () , Class_Base_Elf64_File_Header::SIZE_E_TYPE ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_machine_offset () , Class_Base_Elf64_File_Header::SIZE_E_MACHINE ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_version_offset () , Class_Base_Elf64_File_Header::SIZE_E_VERSION ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_entry_offset () , Class_Base_Elf64_File_Header::SIZE_E_ENTRY ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_phoff_offset () , Class_Base_Elf64_File_Header::SIZE_E_PHOFF ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_shoff_offset () , Class_Base_Elf64_File_Header::SIZE_E_SHOFF ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_flags_offset () , Class_Base_Elf64_File_Header::SIZE_E_FLAGS ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_ehsize_offset () , Class_Base_Elf64_File_Header::SIZE_E_EHSIZE ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_phentsize_offset () , Class_Base_Elf64_File_Header::SIZE_E_PHENTSIZE ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_phnum_offset () , Class_Base_Elf64_File_Header::SIZE_E_PHNUM ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_shentsize_offset () , Class_Base_Elf64_File_Header::SIZE_E_SHENTSIZE ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_shnum_offset () , Class_Base_Elf64_File_Header::SIZE_E_SHNUM ) ,
                            substr ( $_file_header_content , Class_Base_Elf64_File_Header::get_e_shstrndx_offset () , Class_Base_Elf64_File_Header::SIZE_E_SHSTRNDX )
                        );
                        $_file_info[ "program_headers" ] = array ();
                        $_file_info[ "programs" ]        = array ();
                        $_program_head_count             = $_file_info[ "file_header" ]->get_program_header_count ();
                        $_program_head_size              = Class_Base_Elf64_Program_Header::get_Program_header_size ();
                        $_program_head_offset            = intval ( $_file_info[ "file_header" ]->get_program_header_offset () );
                        for ( $programs_index = 0 ; $programs_index < $_program_head_count ; $programs_index++ ) {
                            fseek ( $_file_point , $_program_head_offset , SEEK_SET );
                            $_program_head_content = @fread ( $_file_point , $_program_head_size );
                            if ( ! empty( $_program_head_content ) ) {
                                $_program_head_content_size = strlen ( $_program_head_content );
                                if ( $_program_head_size == $_program_head_content_size ) {
                                    $_file_info[ "program_headers" ][ $_program_head_offset ] = Class_Base_Elf64_Program_Header::create_elf64_phdr (
                                        $file_path ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_type_offset () , Class_Base_Elf64_Program_Header::SIZE_P_TYPE ) ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_flags_offset () , Class_Base_Elf64_Program_Header::SIZE_P_FLAGS ) ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_offset_offset () , Class_Base_Elf64_Program_Header::SIZE_P_OFFSET ) ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_vaddr_offset () , Class_Base_Elf64_Program_Header::SIZE_P_VADDR ) ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_paddr_offset () , Class_Base_Elf64_Program_Header::SIZE_P_PADDR ) ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_filesz_offset () , Class_Base_Elf64_Program_Header::SIZE_P_FILESZ ) ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_memsz_offset () , Class_Base_Elf64_Program_Header::SIZE_P_MEMSZ ) ,
                                        substr ( $_program_head_content , Class_Base_Elf64_Program_Header::get_p_align_offset () , Class_Base_Elf64_Program_Header::SIZE_P_ALIGN )
                                    );
                                    if ( intval ( $_file_info[ "program_headers" ][ $_program_head_offset ]->get_p_type () ) > 0 ) {
                                        $_program_info = Class_Base_Elf64_Program::get_program_content ( $file_path , $_file_info[ "program_headers" ][ $_program_head_offset ]->get_p_type () , $_file_info[ "program_headers" ][ $_program_head_offset ]->get_p_offset () , $_file_info[ "program_headers" ][ $_program_head_offset ]->get_p_filesz () );
                                        if ( $_program_info !== false ) {
                                            $_file_info[ "programs" ][ $_file_info[ "program_headers" ][ $_program_head_offset ]->get_p_offset () ] = $_program_info;
                                        }
                                    }
                                    //Class_Base_Response::outputln ( array ($_file_info[ "program_headers" ][ $_program_head_offset ]->get_format_program_header() , $_file_info[ "programs" ][ $_file_info[ "program_headers" ][ $_program_head_offset ]->get_p_offset () ] ) );
                                }
                            }
                            $_program_head_offset += $_program_head_size;
                        }

                        $_file_info[ "section_shstrtab" ] = $_section_shstrtab = self::create_section_shstrtab ( $file_path , $_file_header_object );
                        $_file_info[ "section_syms" ]     = $_section_syms = self::create_section_syms ( $file_path , $_file_header_object );
                        $_file_info[ "section_headers" ]  = array ();
                        $_file_info[ "sections" ]         = array ();
                        $_section_header_count            = $_file_info[ "file_header" ]->get_section_header_count ();
                        $_section_header_size             = Class_Base_Elf64_Section_Header::get_section_header_size ();
                        $_section_header_offset           = intval ( $_file_info[ "file_header" ]->get_section_header_offset () );
                        for ( $section_index = 0 ; $section_index < $_section_header_count ; $section_index++ ) {
                            fseek ( $_file_point , $_section_header_offset , SEEK_SET );
                            $_section_header_content = @fread ( $_file_point , $_section_header_size );
                            if ( ! empty( $_section_header_content ) ) {
                                $_section_header_content_size = strlen ( $_section_header_content );
                                if ( $_section_header_size == $_section_header_content_size ) {
                                    $_file_info[ "section_headers" ][ $_section_header_offset ] = $_section_header_object = Class_Base_Elf64_Section_Header::create_elf64_shdr (
                                        $file_path ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_name_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_NAME ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_type_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_TYPE ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_flags_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_FLAGS ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_addr_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ADDR ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_offset_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_OFFSET ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_size_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_SIZE ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_link_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_LINK ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_info_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_INFO ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_addralign_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ADDRALIGN ) ,
                                        substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_entsize_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ENTSIZE )
                                    );
                                    if ( intval ( $_section_header_object->get_sh_type () ) > 0 ) {
                                        $_section_info = Class_Base_Elf64_Section::get_section_content ( $file_path , $_section_header_object->get_sh_type () , $_section_header_object->get_sh_offset () , $_section_header_object->get_sh_size () , $_section_header_object->get_sh_name () );
                                        if ( $_section_info !== false ) {
                                            $_file_info[ "sections" ][ $_section_header_object->get_sh_offset () ] = $_section_info;
                                        }
                                    }
                                }
                            }
                            $_section_header_offset += $_section_header_size;
                        }
                    }
                }
                @fclose ( $_file_point );
                return $_file_info;
            }
        }
        return false;
    }

    public static function create_section_shstrtab ( $file_path , $file_header_object )
    {
        $_section_shstrtab_object = false;
        if ( ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 0 ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) && ( Class_Base_File::get_file_size ( $file_path ) > ( Class_Base_Elf64_File_Header::get_file_header_size () ) ) && ( is_object ( $file_header_object ) ) && ( ( $file_header_object instanceof Class_Base_Elf64_File_Header ) ) ) {
            $_file_point = @fopen ( $file_path , "rb" );
            if ( ! empty( $_file_point ) ) {
                $_section_header_count  = $file_header_object->get_section_header_count ();
                $_section_header_size   = Class_Base_Elf64_Section_Header::get_section_header_size ();
                $_section_header_offset = intval ( $file_header_object->get_section_header_offset () );
                for ( $section_header_index = 0 ; $section_header_index < $_section_header_count ; $section_header_index++ ) {
                    fseek ( $_file_point , $_section_header_offset , SEEK_SET );
                    $_section_header_content = @fread ( $_file_point , $_section_header_size );
                    if ( ! empty( $_section_header_content ) ) {
                        $_section_header_content_size = strlen ( $_section_header_content );
                        if ( $_section_header_size == $_section_header_content_size ) {
                            $_sh_type = ( ( Class_Base_Elf::unpack ( ( substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_type_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_TYPE ) ) , "V*" ) ) );
                            if ( ( $section_header_index == $file_header_object->get_e_shstrndx () ) && ( $_sh_type == 3 ) ) {
                                $_section_header_object   = Class_Base_Elf64_Section_Header::create_elf64_shdr (
                                    $file_path ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_name_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_NAME ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_type_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_TYPE ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_flags_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_FLAGS ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_addr_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ADDR ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_offset_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_OFFSET ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_size_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_SIZE ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_link_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_LINK ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_info_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_INFO ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_addralign_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ADDRALIGN ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_entsize_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ENTSIZE )
                                );
                                $_section_shstrtab_object = Class_Base_Elf64_Section_Shstrtab::create_elf64_section_shstrtab ( $file_path , $_section_header_object );
                                $_section_header_object   = null;
                                break;
                            }
                        }
                    }
                    $_section_header_offset += $_section_header_size;
                }
                @fclose ( $_file_point );
            }
        }
        return $_section_shstrtab_object;
    }

    public static function create_section_syms ( $file_path , $file_header_object )
    {
        $_section_syms_object = false;
        if ( ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 0 ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) && ( Class_Base_File::get_file_size ( $file_path ) > ( Class_Base_Elf64_File_Header::get_file_header_size () ) ) && ( is_object ( $file_header_object ) ) && ( ( $file_header_object instanceof Class_Base_Elf64_File_Header ) ) ) {
            $_file_point = @fopen ( $file_path , "rb" );
            if ( ! empty( $_file_point ) ) {
                $_section_header_count  = $file_header_object->get_section_header_count ();
                $_section_header_size   = Class_Base_Elf64_Section_Header::get_section_header_size ();
                $_section_header_offset = intval ( $file_header_object->get_section_header_offset () );
                for ( $section_header_index = 0 ; $section_header_index < $_section_header_count ; $section_header_index++ ) {
                    fseek ( $_file_point , $_section_header_offset , SEEK_SET );
                    $_section_header_content = @fread ( $_file_point , $_section_header_size );
                    if ( ! empty( $_section_header_content ) ) {
                        $_section_header_content_size = strlen ( $_section_header_content );
                        if ( $_section_header_size == $_section_header_content_size ) {
                            $_sh_type = ( ( Class_Base_Elf::unpack ( ( substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_type_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_TYPE ) ) , "V*" ) ) );
                            if ( ( $section_header_index == $file_header_object->get_e_shstrndx () ) && ( $_sh_type == 3 ) ) {
                                $_section_header_object = Class_Base_Elf64_Section_Header::create_elf64_shdr (
                                    $file_path ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_name_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_NAME ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_type_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_TYPE ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_flags_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_FLAGS ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_addr_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ADDR ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_offset_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_OFFSET ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_size_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_SIZE ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_link_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_LINK ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_info_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_INFO ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_addralign_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ADDRALIGN ) ,
                                    substr ( $_section_header_content , Class_Base_Elf64_Section_Header::get_sh_entsize_offset () , Class_Base_Elf64_Section_Header::SIZE_SH_ENTSIZE )
                                );
                                $_section_syms_object   = Class_Base_Elf64_Section_Shstrtab::create_elf64_section_shstrtab ( $file_path , $_section_header_object );
                                $_section_header_object = null;
                                break;
                            }
                        }
                    }
                    $_section_header_offset += $_section_header_size;
                }
                @fclose ( $_file_point );
            }
        }
        return $_section_syms_object;
    }

    public static function elf64_hash ( $name )
    {
        $_h           = 0;
        $_name_length = strlen ( $name );
        for ( $index = 0 ; $index < $_name_length ; $index++ ) {
            $_h = ( ( $_h << 4 ) + ( ord ( substr ( $name , $index , 1 ) ) ) );
            if ( $_g = ( $_h & 0xf0000000 ) ) {
                $_h ^= ( $_g >> 24 );
            }
            $_h &= 0x0fffffff;
        }
        return $_h;
    }


}