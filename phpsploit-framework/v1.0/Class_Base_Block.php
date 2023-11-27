<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-13
 * Time: 下午12:29
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

class Class_Base_Block extends Class_Base implements Interface_Base_Block
{
    private $_head     = null;
    private $_content  = null;
    private $_end_flag = null;

    public static function exist_block ( $key , $size )
    {
        $_block_size = ( self::SIZE_BLOCK_HEAD + $size + self::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( ! empty( $_block_id ) ) {
            $_head = Class_Base_Memory::read_share_memory ( $_block_id , self::OFFSET_START , self::SIZE_BLOCK_HEAD , Class_Base_Format::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            if ( ! Class_Base_Format::is_empty ( $_head ) ) {
                $_head_block_key = substr ( $_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY );
                if ( ! Class_Base_Format::is_empty ( $_head_block_key ) ) {
                    $_head_content_size = substr ( $_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE );
                    if ( ! Class_Base_Format::is_empty ( $_head_content_size ) ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function open_block ( $key , $size )
    {
        if ( ! is_integer ( $size ) ) {
            throw new \Exception( "size is not a integer" , 0 );
        }
        $_block_size = ( self::SIZE_BLOCK_HEAD + $size + self::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( empty( $_block_id ) ) {
            throw new \Exception( "share memory id is empty" , 0 );
        }
        $_head     = Class_Base_Memory::read_share_memory ( $_block_id , self::OFFSET_START , self::SIZE_BLOCK_HEAD , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        $_content  = Class_Base_Memory::read_share_memory ( $_block_id , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD ) , $size , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        $_end_flag = Class_Base_Memory::read_share_memory ( $_block_id , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD + $size ) , self::SIZE_BLOCK_END_FLAG , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        $_block    = new Class_Base_Block( $_head , $_content , $_end_flag );
        return $_block;
    }

    public static function create_block ( $head_block_name , $head_block_key , $head_content_size , $head_block_status , $head_block_mode , $head_block_type , $head_content_type , $head_reserved , $head_end_flag , $content , $end_flag )
    {
        if ( $head_content_type == Interface_Base_FormatType::TYPE_FORMAT_INTEGER ) {
            $head_content_size = self::SIZE_BLOCK_HEAD_CONTENT_SIZE;
        }
        $_head_block_name   = Class_Base_Format::format_name_write ( $head_block_name , self::SIZE_BLOCK_HEAD_BLOCK_NAME );
        $_head_block_key    = Class_Base_Format::format_key_write ( $head_block_key );
        $_head_content_size = Class_Base_Format::format_size_write ( $head_content_size );
        $_head_block_status = Class_Base_Format::format_status_write ( $head_block_status );
        $_head_block_mode   = Class_Base_Format::format_mode_write ( $head_block_mode );
        $_head_block_type   = Class_Base_Format::format_type_write ( $head_block_type );
        $_head_content_type = Class_Base_Format::format_type_write ( $head_content_type );
        $_head_reserved     = Class_Base_Format::format_reserved_write ( $head_reserved , self::SIZE_BLOCK_HEAD_RESERVED );
        $_head_end_flag     = Class_Base_Format::format_end_flag_write ( $head_end_flag , self::SIZE_BLOCK_HEAD_END_FLAG );
        $_head              = ( $_head_block_name . $_head_block_key . $_head_content_size . $_head_block_status . $_head_block_mode . $_head_block_type . $_head_content_type . $_head_reserved . $_head_end_flag );
        $_content           = Class_Base_Format::format_content_write ( $content , $head_content_size , $head_content_type );
        $_end_flag          = Class_Base_Format::format_end_flag_write ( $end_flag , self::SIZE_BLOCK_END_FLAG );
        $_data              = ( $_head . $_content . $_end_flag );
        $_block_size        = ( self::SIZE_BLOCK_HEAD_CONTENT_SIZE + $head_content_size + self::SIZE_BLOCK_END_FLAG );
        $_data_length       = strlen ( $_data );
        if ( $_block_size != $_data_length ) {
            throw new \Exception( "block size is error , block size ( " . $_block_size . " ) , data length ( " . $_data_length . " ) " , 0 );
        }
        self::check_block ( $_head , $_content , $head_content_type , $_end_flag );
        $_block_id = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( ! empty( $_block_id ) ) {
            $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_data , self::OFFSET_START , Interface_Base_FormatType::TYPE_FORMAT_STRING );
            if ( ( ! empty( $_write_length ) ) && ( $_write_length == $_data_length ) ) {
                $_block = new Class_Base_Block( $_head , $_content , $_end_flag );
                return $_block;
            }
        }
        return null;
    }

    public static function clear_block_by_content_size ( $key , $content_size )
    {
        $_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $content_size + Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( ! empty( $_block_id ) ) {
            $_block_type = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_BlockHead::get_head_block_type_offset () , Class_Base_BlockHead::get_head_block_type_size () );
            if ( ( $_block_type == Interface_Base_BlockType::TYPE_BLOCK_DATA ) || ( $_block_type == Interface_Base_BlockType::TYPE_BLOCK_INDEXES ) || ( $_block_type == Interface_Base_BlockType::TYPE_BLOCK_UNIQUE_INDEX ) || ( $_block_type == Interface_Base_BlockType::TYPE_BLOCK_SOCKETS ) ) {
                $_bool = Class_Base_Memory::clear_share_memory_by_key ( $key , $_block_size );
                return $_bool;
            }
        }
        return false;
    }

    public static function clear_block_by_block_size ( $key , $block_size )
    {
        $_block_id = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $block_size );
        if ( ! empty( $_block_id ) ) {
            $_block_type = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_BlockHead::get_head_block_type_offset () , Class_Base_BlockHead::get_head_block_type_size () );
            $_block_type = Class_Base_Format::format_type_read ( $_block_type );
            if ( $_block_type == Interface_Base_BlockKey::INDEXES ) {
                $_indexes_item_count = Class_Base_Block_Indexes::get_map_count_for_clear ( $key );
                if ( ! empty( $_indexes_item_count ) ) {
                    return false;
                }
            }
            $_bool = Class_Base_Memory::clear_share_memory_by_key ( $key , $block_size );
            return $_bool;

        }
        return false;
    }

    public static function check_block ( $head , $content , $head_content_type , $end_flag )
    {
        if ( ( ! is_string ( $head ) ) || ( strlen ( $head ) != self::SIZE_BLOCK_HEAD ) ) {
            throw new \Exception( ( "head is not a string or head length is not " . self::SIZE_BLOCK_HEAD ) , 0 );
        }
        if ( strlen ( strval ( $content ) ) <= 0 ) {
            throw new \Exception( "content length is less than or equal to 0" , 0 );
        }
        if ( ! Class_Base_Format::is_minlen_to_maxlen_hex ( substr ( $head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) , Class_Base_Format::HEX_MAX_LENGTH , Class_Base_Format::HEX_MAX_LENGTH ) ) {
            throw new \Exception( "content size is not a vaild hex number" , 0 );
        }
        if ( ! Class_Base_Format::is_minlen_to_maxlen_integer ( Class_Base_Format::hex_to_dec ( substr ( $head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) ) , Class_Base_Format::INTEGER_MIN_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) {
            throw new \Exception( "content size is not a vaild integer number" , 0 );
        }
        if ( $head_content_type == Interface_Base_FormatType::TYPE_FORMAT_INTEGER ) {
            if ( Class_Base_Format::hex_to_dec ( substr ( $head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) ) != self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) {
                throw new \Exception( "content size is error" , 0 );
            }
            if ( ! Class_Base_Format::is_minlen_to_maxlen_hex ( $content , Class_Base_Format::HEX_MAX_LENGTH , Class_Base_Format::HEX_MAX_LENGTH ) ) {
                throw new \Exception( "content is not a valid hex number" , 0 );
            }
            if ( ! Class_Base_Format::is_minlen_to_maxlen_integer ( Class_Base_Format::hex_to_dec ( $content ) , Class_Base_Format::INTEGER_MIN_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) {
                throw new \Exception( "content is not a valid integer number" , 0 );
            }
        } else {
            if ( Class_Base_Format::hex_to_dec ( substr ( $head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) != strlen ( $content ) ) ) {
                throw new \Exception( "content size is error" , 0 );
            }
        }
        if ( ( ! is_string ( $end_flag ) ) || ( strlen ( $end_flag ) != self::SIZE_BLOCK_END_FLAG ) ) {
            throw new \Exception( "end_flag is error" , 0 );
        }
        if ( strlen ( $head . $content . $end_flag ) != ( self::SIZE_BLOCK_HEAD + ( Class_Base_Format::hex_to_dec ( substr ( $head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) ) ) + self::SIZE_BLOCK_END_FLAG ) ) {
            throw new \Exception( "share memory data length is error" , 0 );
        }
    }

    public function __construct ( $head , $content , $end_flag )
    {
        $this->_head     = $head;
        $this->_content  = $content;
        $this->_end_flag = $end_flag;
    }

    public function __destruct ()
    {
        $this->_head     = null;
        $this->_content  = null;
        $this->_end_flag = null;
    }

    public function get_head_block_name ()
    {
        $_block_name = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_block_name = substr ( $this->_head , ( self::OFFSET_START ) , self::SIZE_BLOCK_HEAD_BLOCK_NAME );
            $_block_name = Class_Base_Format::format_name_read ( $_block_name );
        }
        return $_block_name;
    }

    public function get_head_block_key ()
    {
        $_block_key = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_block_key = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY );
            $_block_key = Class_Base_Format::format_key_read ( $_block_key );
        }
        return $_block_key;
    }

    public function get_head_content_size ()
    {
        $_content_size = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_content_size = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY ) , self::SIZE_BLOCK_HEAD_CONTENT_SIZE );
            $_content_size = Class_Base_Format::format_size_read ( $_content_size );
        }
        return $_content_size;
    }

    public function get_head_block_status ()
    {
        $_block_status = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_block_status = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE ) , self::SIZE_BLOCK_HEAD_BLOCK_STATUS );
            $_block_status = Class_Base_Format::format_status_read ( $_block_status );
        }
        return $_block_status;
    }

    public function get_head_block_mode ()
    {
        $_block_mode = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_block_mode = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS ) , self::SIZE_BLOCK_HEAD_BLOCK_MODE );
            $_block_mode = Class_Base_Format::format_mode_read ( $_block_mode );
        }
        return $_block_mode;
    }

    public function get_head_block_type ()
    {
        $_block_type = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_block_type = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE ) , self::SIZE_BLOCK_HEAD_BLOCK_TYPE );
            $_block_type = Class_Base_Format::format_type_read ( $_block_type );
        }
        return $_block_type;
    }

    public function get_head_content_type ()
    {
        $_content_type = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_content_type = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE + self::SIZE_BLOCK_HEAD_BLOCK_TYPE ) , self::SIZE_BLOCK_HEAD_CONTENT_TYPE );
            $_content_type = Class_Base_Format::format_type_read ( $_content_type );
        }
        return $_content_type;
    }

    public function get_head_reserved ()
    {
        $_reserved = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_reserved = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE + self::SIZE_BLOCK_HEAD_BLOCK_TYPE + self::SIZE_BLOCK_HEAD_CONTENT_TYPE ) , self::SIZE_BLOCK_HEAD_RESERVED );
            $_reserved = Class_Base_Format::format_reserved_read ( $_reserved );
        }
        return $_reserved;
    }

    public function get_head_end_flag ()
    {
        $_end_flag = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_head ) ) && ( is_string ( $this->_head ) ) && ( strlen ( $this->_head ) == self::SIZE_BLOCK_HEAD ) ) {
            $_end_flag = substr ( $this->_head , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME + self::SIZE_BLOCK_HEAD_BLOCK_KEY + self::SIZE_BLOCK_HEAD_CONTENT_SIZE + self::SIZE_BLOCK_HEAD_BLOCK_STATUS + self::SIZE_BLOCK_HEAD_BLOCK_MODE + self::SIZE_BLOCK_HEAD_BLOCK_TYPE + self::SIZE_BLOCK_HEAD_CONTENT_TYPE + self::SIZE_BLOCK_HEAD_RESERVED ) , self::SIZE_BLOCK_HEAD_END_FLAG );
            $_end_flag = Class_Base_Format::format_end_flag_read ( $_end_flag );
        }
        return $_end_flag;
    }

    public function get_block_end_flag ()
    {
        $_end_flag = null;
        if ( ( ! Class_Base_Format::is_empty ( $this->_end_flag ) ) && ( is_string ( $this->_end_flag ) ) && ( strlen ( $this->_end_flag ) == self::SIZE_BLOCK_END_FLAG ) ) {
            $_end_flag = substr ( $this->_end_flag , ( self::OFFSET_START ) , self::SIZE_BLOCK_END_FLAG );
            $_end_flag = Class_Base_Format::format_end_flag_read ( $_end_flag );
        }
        return $_end_flag;
    }

    public function get_head ()
    {
        return $this->_head;
    }

    public function get_content ()
    {
        return $this->_content;
    }

    public function get_end_flag ()
    {
        return $this->_end_flag;
    }

    public function get_block_string ()
    {
        return ( $this->_head . $this->_content . $this->_end_flag );
    }
}