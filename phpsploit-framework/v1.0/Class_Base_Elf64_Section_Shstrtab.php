<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-6
 * Time: 下午1:57
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

class Class_Base_Elf64_Section_Shstrtab extends Class_Base
{
    private static $_section_shstrtabs      = array ();
    private static $_section_shstrtab_names = array ();
    private        $_content                = null;
    private        $_names                  = null;

    public static function create_elf64_section_shstrtab ( $file_path , $section_shstrtab_header )
    {
        if ( ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 0 ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) && ( is_object ( $section_shstrtab_header ) && ( $section_shstrtab_header instanceof Class_Base_Elf64_Section_Header ) ) ) {
            $_tmp_file_point = fopen ( $file_path , "rb" );
            if ( ! empty( $_tmp_file_point ) ) {
                fseek ( $_tmp_file_point , $section_shstrtab_header->get_sh_offset () , SEEK_SET );
                $_shstrtab_section_content = @fread ( $_tmp_file_point , $section_shstrtab_header->get_sh_size () );
                fclose ( $_tmp_file_point );
                if ( ( ! is_null ( $_shstrtab_section_content ) ) ) {
                    if ( strpos ( $_shstrtab_section_content , chr ( 46 ) ) !== false ) {
                        $_section_shstrtab_object = self::$_section_shstrtabs[ $file_path ] = new Class_Base_Elf64_Section_Shstrtab( $_shstrtab_section_content );
                        $_section_shstrtab_names  = explode ( chr ( 46 ) , $_shstrtab_section_content );
                        array_shift ( $_section_shstrtab_names );
                        self::$_section_shstrtab_names[ $file_path ] = $_section_shstrtab_object->_names = $_section_shstrtab_names;
                        $_section_shstrtab_names                     = null;
                        unset( $_section_shstrtab_names );
                        return $_section_shstrtab_object;
                    }
                }
            }
        }
        return false;
    }

    public static function get_section_name ( $file_path , $sh_name )
    {
        if ( ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 0 ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) ) {
            if ( ( ! empty( self::$_section_shstrtabs[ $file_path ] ) ) && ( is_object ( self::$_section_shstrtabs[ $file_path ] ) ) && ( self::$_section_shstrtabs[ $file_path ] instanceof Class_Base_Elf64_Section_Shstrtab ) ) {
                $_shstrtab_section_content        = self::$_section_shstrtabs[ $file_path ]->get_content ();
                $_shstrtab_section_content_length = strlen ( $_shstrtab_section_content );
                if ( ( is_integer ( $sh_name ) ) && ( $sh_name < $_shstrtab_section_content_length ) && ( ( $sh_name != ( -1 ) ) && ( $sh_name != ( $_shstrtab_section_content_length - 1 ) ) ) ) {
                    $_end_dot_position = strpos ( $_shstrtab_section_content , chr ( 46 ) , ( $sh_name + 1 ) );
                    $_size             = ( $_end_dot_position - $sh_name );
                    if ( ( ( $sh_name + $_size ) < $_shstrtab_section_content_length ) ) {
                        $_sh_name = substr ( $_shstrtab_section_content , $sh_name , $_size );
                        $_sh_name = str_replace ( chr ( 0 ) , "" , $_sh_name );
                        return $_sh_name;
                    }
                }
            }
        }
        return false;
    }

    public function __construct ( $shstrtab_section_content )
    {
        if ( is_string ( $shstrtab_section_content ) ) {
            $this->_content = $shstrtab_section_content;
        }
    }

    public function __destruct ()
    {
        // TODO: Implement __destruct() method.
    }

    public function get_content ()
    {
        return $this->_content;
    }

    public function get_content_length ()
    {
        $_content_length = strlen ( $this->_content );
        return $_content_length;
    }

    public function get_names ()
    {
        return $this->_names;
    }

    public function get_sh_name ( $offset )
    {
        $_content_length = $this->get_content_length ();
        if ( ( is_integer ( $offset ) ) && ( $offset < $_content_length ) && ( ( $offset != ( -1 ) ) && ( $offset != ( $_content_length - 1 ) ) ) ) {
            $_end_dot_position = strpos ( $this->_content , chr ( 46 ) , ( $offset + 1 ) );
            $_size             = ( $_end_dot_position - $offset );
            if ( ( ( $offset + $_size ) < $_content_length ) ) {
                $_sh_name = substr ( $this->_content , $offset , $_size );
                $_sh_name = str_replace ( chr ( 0 ) , "" , $_sh_name );
                return $_sh_name;
            }
        }
        return false;
    }
}