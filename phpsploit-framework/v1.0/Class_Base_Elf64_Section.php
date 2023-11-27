<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-6
 * Time: 上午9:00
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

class Class_Base_Elf64_Section extends Class_Base
{
    private static $_section_types = array ( 0 , 1 , 2 , 3 , 4 , 5 , 6 , 7 , 8 , 9 , 10 , 11 , 0x60000000 , 0x6fffffff , 0x70000000 , 0x7fffffff );
    private static $_sections      = array ();

    public static function get_section_content ( $file_path , $section_type , $section_offset , $section_size , $section_name )
    {
        if ( ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 0 ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) && ( is_integer ( $section_type ) ) && ( in_array ( $section_type , self::$_section_types ) ) && ( is_integer ( $section_offset ) ) && ( is_integer ( $section_size ) ) && ( $section_size > 0 ) ) {
            $_file_tmp_point = fopen ( $file_path , "rb" );
            if ( ! empty( $_file_tmp_point ) ) {
                fseek ( $_file_tmp_point , $section_offset , SEEK_SET );
                $_section_content = @fread ( $_file_tmp_point , $section_size );
                fclose ( $_file_tmp_point );
                if ( ( ! array_key_exists ( $file_path , self::$_sections ) ) || ( ! is_array ( self::$_sections[ $file_path ] ) ) ) {
                    self::$_sections[ $file_path ] = array ();
                }
                if ( ( ! array_key_exists ( $section_offset , self::$_sections[ $file_path ] ) ) || ( ! is_array ( self::$_sections[ $file_path ][ $section_offset ] ) ) ) {
                    self::$_sections[ $file_path ][ $section_offset ] = array ();
                }
                self::$_sections[ $file_path ][ $section_offset ][ "sh_name" ]      = $section_name;
                self::$_sections[ $file_path ][ $section_offset ][ "name" ]         = Class_Base_Elf64_Section_Shstrtab::get_section_name ( $file_path , $section_name );
                self::$_sections[ $file_path ][ $section_offset ][ "type" ]         = $section_type;
                self::$_sections[ $file_path ][ $section_offset ][ "hex_type" ]     = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $section_type ) );
                self::$_sections[ $file_path ][ $section_offset ][ "type_name" ]    = Class_Base_Elf::get_sh_type_name ( $section_type );
                self::$_sections[ $file_path ][ $section_offset ][ "offset" ]       = $section_offset;
                self::$_sections[ $file_path ][ $section_offset ][ "hex_offset" ]   = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $section_offset ) );
                self::$_sections[ $file_path ][ $section_offset ][ "size" ]         = $section_size;
                self::$_sections[ $file_path ][ $section_offset ][ "hex_size" ]     = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $section_size ) );
                self::$_sections[ $file_path ][ $section_offset ][ "content_type" ] = "ascii_char";
                self::$_sections[ $file_path ][ $section_offset ][ "content" ]      = $_section_content;
                if ( ! is_null ( $_section_content ) ) {
                    return self::$_sections[ $file_path ][ $section_offset ];
                }
            }
        }
        return false;
    }

    public static function show_section_content ( $section_type , $section_content , &$section_content_type = null )
    {
        if ( $section_type == 3 ) {
            $_show_section_content = str_replace ( chr ( 0 ) , ( chr ( 32 ) ) , $section_content );
            $section_content_type  = "ascii_char";
        } else {
            $_show_section_content = Class_Base_Format::get_format_hex_content ( $section_content );
            $section_content_type  = "hex_char";
        }
        return $_show_section_content;
    }
}