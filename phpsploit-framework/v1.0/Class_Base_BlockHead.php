<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-10
 * Time: 下午3:35
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

class Class_Base_BlockHead extends Class_Base implements Interface_Base_BlockHead
{
    private $_block_name;
    private $_block_key;
    private $_content_size;
    private $_block_status;
    private $_block_mode;
    private $_block_type;
    private $_content_type;
    private $_reserved;
    private $_head_end_flag;

    public static function is_block_head ( $block )
    {
        if ( ( empty( $block ) ) || ( ! is_object ( $block ) ) || ( ! ( $block instanceof Class_Base_BlockHead ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_block_name ( $block )
    {
        if ( ! property_exists ( $block , "_block_name" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_block_name ) ) || ( ! is_string ( $block->_block_name ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_block_key ( $block )
    {
        if ( ! property_exists ( $block , "_block_key" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_block_key ) ) || ( ! is_integer ( $block->_block_key ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_size ( $block )
    {
        if ( ! property_exists ( $block , "_content_size" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_content_size ) ) || ( ! is_integer ( $block->_content_size ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_status ( $block )
    {
        if ( ! property_exists ( $block , "_block_status" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_block_status ) ) || ( ! is_integer ( $block->_block_status ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_mode ( $block )
    {
        if ( ! property_exists ( $block , "_block_mode" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_block_mode ) ) || ( ! is_integer ( $block->_block_mode ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_block_type ( $block )
    {
        if ( ! property_exists ( $block , "_block_type" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_block_type ) ) || ( ! is_integer ( $block->_block_type ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_content_type ( $block )
    {
        if ( ! property_exists ( $block , "_content_type" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_content_type ) ) || ( ! is_integer ( $block->_content_type ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_reserved ( $block )
    {
        if ( ! property_exists ( $block , "_reserved" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_reserved ) ) || ( ! is_string ( $block->_reserved ) ) ) {
            return false;
        }
        if ( strlen ( $block->_reserved ) != self::SIZE_BLOCK_HEAD_RESERVED ) {
            return false;
        }
        return true;
    }

    public static function check_block_head_end_flag ( $block )
    {
        if ( ! property_exists ( $block , "_head_end_flag" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_head_end_flag ) ) || ( ! is_string ( $block->_head_end_flag ) ) ) {
            return false;
        }
        return true;
    }

    public static function create_block_head ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag )
    {
        $_block_data = new Class_Base_BlockHead( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag );
        return $_block_data;
    }

    public static function get_head_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START );
        return $_offset;
    }

    public static function get_head_block_name_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START );
        return $_offset;
    }

    public static function get_head_block_key_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME );
        return $_offset;
    }

    public static function get_head_content_size_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY );
        return $_offset;
    }

    public static function get_head_block_status_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE );
        return $_offset;
    }

    public static function get_head_block_mode_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS );
        return $_offset;
    }

    public static function get_head_block_type_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE );
        return $_offset;
    }

    public static function get_head_content_type_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE + self::SIZE_BLOCK_HEAD_BLOCK_TYPE );
        return $_offset;
    }

    public static function get_head_reserved_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE + self::SIZE_BLOCK_HEAD_BLOCK_TYPE + self::SIZE_BLOCK_HEAD_CONTENT_TYPE );
        return $_offset;
    }

    public static function get_head_end_flag_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE + self::SIZE_BLOCK_HEAD_BLOCK_TYPE + self::SIZE_BLOCK_HEAD_CONTENT_TYPE + self::SIZE_BLOCK_HEAD_RESERVED );
        return $_offset;
    }

    public static function get_head_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD );
        return $_size;
    }

    public static function get_head_block_name_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_BLOCK_NAME );
        return $_size;
    }

    public static function get_head_block_key_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_BLOCK_KEY );
        return $_size;
    }

    public static function get_head_content_size_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_CONTENT_SIZE );
        return $_size;
    }

    public static function get_head_block_status_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_BLOCK_STATUS );
        return $_size;
    }

    public static function get_head_block_mode_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_BLOCK_MODE );
        return $_size;
    }

    public static function get_head_block_type_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_BLOCK_TYPE );
        return $_size;
    }

    public static function get_head_content_type_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_CONTENT_TYPE );
        return $_size;
    }

    public static function get_head_reserved_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_RESERVED );
        return $_size;
    }

    public static function get_head_end_flag_size ()
    {
        $_size = ( self::SIZE_BLOCK_HEAD_END_FLAG );
        return $_size;
    }

    public static function check_block_head_data ( $head )
    {
        if ( empty( $head ) ) {
            return false;
        }
        if ( ! is_string ( $head ) ) {
            return false;
        }
        if ( strlen ( $head ) != self::SIZE_BLOCK_HEAD ) {
            return false;
        }
        if ( Class_Base_Format::is_empty ( $head ) ) {
            return false;
        }
        if ( Class_Base_Format::is_empty ( substr ( $head , ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) ) ) {
            return false;
        }
        if ( Class_Base_Format::is_empty ( substr ( $head , ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) ) ) {
            return false;
        }
        return true;
    }

    public function __construct ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag )
    {
        $this->_block_name    = Class_Base_Format::format_name_write ( $block_name , self::SIZE_BLOCK_HEAD_BLOCK_NAME );
        $this->_block_key     = Class_Base_Format::format_key_write ( $block_key );
        $this->_content_size  = Class_Base_Format::format_size_write ( $content_size );
        $this->_block_status  = Class_Base_Format::format_status_write ( $block_status );
        $this->_block_mode    = Class_Base_Format::format_mode_write ( $block_mode );
        $this->_block_type    = Class_Base_Format::format_type_write ( $block_type );
        $this->_content_type  = Class_Base_Format::format_type_write ( $content_type );
        $this->_reserved      = Class_Base_Format::format_reserved_write ( $reserved , self::get_head_reserved_size () );
        $this->_head_end_flag = Class_Base_Format::format_end_flag_write ( $head_end_flag , self::SIZE_BLOCK_HEAD_END_FLAG );
    }

    public function __destruct ()
    {
        $this->_block_name    = null;
        $this->_block_key     = null;
        $this->_content_size  = null;
        $this->_block_status  = null;
        $this->_block_mode    = null;
        $this->_block_type    = null;
        $this->_content_type  = null;
        $this->_reserved      = null;
        $this->_head_end_flag = null;
    }

    public function set_block_name ( $block_name )
    {
        $this->_block_name = Class_Base_Format::format_name_write ( $block_name , self::SIZE_BLOCK_HEAD_BLOCK_NAME );
    }

    public function set_block_key ( $block_key )
    {
        $this->_block_key = Class_Base_Format::format_key_write ( $block_key );
    }

    public function set_content_size ( $content_size )
    {
        $this->_content_size = Class_Base_Format::format_size_write ( $content_size );
    }

    public function set_block_status ( $block_status )
    {
        $this->_block_status = Class_Base_Format::format_status_write ( $block_status );
    }

    public function set_block_mode ( $block_mode )
    {
        $this->_block_mode = Class_Base_Format::format_mode_write ( $block_mode );
    }

    public function set_block_type ( $block_type )
    {
        $this->_block_type = Class_Base_Format::format_type_write ( $block_type );
    }

    public function set_content_type ( $content_type )
    {
        $this->_content_type = Class_Base_Format::format_type_write ( $content_type );
    }

    public function set_reserved ( $reserved )
    {
        $this->_reserved = Class_Base_Format::format_reserved_write ( $reserved , self::SIZE_BLOCK_HEAD_RESERVED );
    }

    public function set_head_end_flag ( $_head_end_flag )
    {
        $this->_head_end_flag = Class_Base_Format::format_end_flag_write ( $_head_end_flag , self::SIZE_BLOCK_HEAD_END_FLAG );
    }

    public function get_block_name ()
    {
        $_block_name = Class_Base_Format::format_name_read ( $this->_block_name );
        return $_block_name;
    }

    public function get_block_key ()
    {
        $_block_key = Class_Base_Format::format_key_read ( $this->_block_key );
        return $_block_key;
    }

    public function get_content_size ()
    {
        $_content_size = Class_Base_Format::format_size_read ( $this->_content_size );
        return $_content_size;
    }

    public function get_block_status ()
    {
        $_block_status = Class_Base_Format::format_status_read ( $this->_block_status );
        return $_block_status;
    }

    public function get_block_mode ()
    {
        $_block_mode = Class_Base_Format::format_mode_read ( $this->_block_mode );
        return $_block_mode;
    }

    public function get_block_type ()
    {
        $_block_type = Class_Base_Format::format_type_read ( $this->_block_type );
        return $_block_type;
    }

    public function get_content_type ()
    {
        $_content_type = Class_Base_Format::format_type_read ( $this->_content_type );
        return $_content_type;
    }

    public function get_reserved ()
    {
        $_reserved = Class_Base_Format::format_reserved_read ( $this->_reserved );
        return $_reserved;
    }

    public function get_head_end_flag ()
    {
        $_head_end_flag = Class_Base_Format::format_end_flag_read ( $this->_head_end_flag );
        return $_head_end_flag;
    }

    public function get_encode_block_name ()
    {
        return $this->_block_name;
    }

    public function get_encode_block_key ()
    {
        return $this->_block_key;
    }

    public function get_encode_content_size ()
    {
        return $this->_content_size;
    }

    public function get_encode_block_status ()
    {
        return $this->_block_status;
    }

    public function get_encode_block_mode ()
    {
        return $this->_block_mode;
    }

    public function get_encode_block_type ()
    {
        return $this->_block_type;
    }

    public function get_encode_content_type ()
    {
        return $this->_content_type;
    }

    public function get_encode_reserved ()
    {
        return $this->_reserved;
    }

    public function get_encode_head_end_flag ()
    {
        return $this->_head_end_flag;
    }

    public function get_block_string ()
    {
        $_block_string = ( $this->_block_name . $this->_block_key . $this->_content_size . $this->_block_status . $this->_block_mode . $this->_block_type . $this->_content_type . $this->_reserved . $this->_head_end_flag );
        return $_block_string;
    }

    public function get_block_string_size ()
    {
        $_block_string        = self::get_block_string ();
        $_block_string_length = strlen ( $_block_string );
        return $_block_string_length;
    }
}