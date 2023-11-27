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

class Class_Base_Elf64_Program extends Class_Base
{
    private static $_program_types = array ( 0 , 1 , 2 , 3 , 4 , 5 , 6 , 0x60000000 , 0x6fffffff , 0x70000000 , 0x7fffffff );
    private static $_programs      = array ();

    public static function get_program_content ( $file_path , $program_type , $program_offset , $program_size )
    {
        if ( ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 0 ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) && ( is_integer ( $program_type ) ) && ( in_array ( $program_type , self::$_program_types ) ) && ( is_integer ( $program_offset ) ) && ( is_integer ( $program_size ) ) ) {
            $_file_tmp_point = fopen ( $file_path , "rb" );
            if ( ! empty( $_file_tmp_point ) ) {
                fseek ( $_file_tmp_point , $program_offset , SEEK_SET );
                $_program_content = @fread ( $_file_tmp_point , $program_size );
                fclose ( $_file_tmp_point );
                if ( ! is_null ( $_program_content ) ) {
                    if ( ( ! array_key_exists ( $file_path , self::$_programs ) ) || ( ! is_array ( self::$_programs[ $file_path ] ) ) ) {
                        self::$_programs[ $file_path ] = array ();
                    }
                    if ( ( ! array_key_exists ( $program_offset , self::$_programs[ $file_path ] ) ) || ( ! is_array ( self::$_programs[ $file_path ][ $program_offset ] ) ) ) {
                        self::$_programs[ $file_path ][ $program_offset ] = array ();
                    }
                    self::$_programs[ $file_path ][ $program_offset ][ "type" ]         = $program_type;
                    self::$_programs[ $file_path ][ $program_offset ][ "hex_type" ]     = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $program_type ) );
                    self::$_programs[ $file_path ][ $program_offset ][ "type_name" ]    = Class_Base_Elf::get_pt_type_name ( $program_type );
                    self::$_programs[ $file_path ][ $program_offset ][ "offset" ]       = $program_offset;
                    self::$_programs[ $file_path ][ $program_offset ][ "hex_offset" ]   = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $program_offset ) );
                    self::$_programs[ $file_path ][ $program_offset ][ "size" ]         = $program_size;
                    self::$_programs[ $file_path ][ $program_offset ][ "hex_size" ]     = ( ( '0x' ) . Class_Base_Elf::dec_to_hex ( $program_size ) );
                    self::$_programs[ $file_path ][ $program_offset ][ "content_type" ] = "ascii_char";
                    self::$_programs[ $file_path ][ $program_offset ][ "content" ]      = $_program_content;
                    return self::$_programs[ $file_path ][ $program_offset ];
                }
            }
        }
        return false;
    }

    public static function show_program_content ( $program_type , $program_content , &$program_content_type = null )
    {
        if ( $program_type == 3 ) {
            $_show_program_content = str_replace ( chr ( 0 ) , ( chr ( 32 ) ) , $program_content );
            $program_content_type  = "ascii_char";
        } else {
            $_show_program_content = Class_Base_Format::get_format_hex_content ( $program_content );
            $program_content_type  = "hex_char";
        }
        return $_show_program_content;
    }
}