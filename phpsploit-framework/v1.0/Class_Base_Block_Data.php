<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-24
 * Time: 上午11:36
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

class Class_Base_Block_Data extends Class_Base_Block implements Interface_Base_Block_Data
{
    private $_key      = null;
    private $_size     = null;
    private $_head     = null;
    private $_content  = null;
    private $_end_flag = null;

    public static function create_key ()
    {
        $_key = Base_BlockUniqueIndex::get_index ( Base_BlockUniqueIndex::KEY );
        return $_key;
    }

    public static function create_block_object ( $key , $size , $head , $content , $end_flag )
    {
        $_block_data = new Base_BlockData( $key , $size , $head , $content , $end_flag );
        return $_block_data;
    }

    public static function get_block_data ( $key , $size )
    {
        $_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $size + Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        $_block_data = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , $_block_size , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        return $_block_data;
    }

    public static function get_block_object ( $key , $size )
    {
        $_block_size     = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $size + Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
        $_block_data     = self::get_block_data ( $key , $size );
        $_block_head     = substr ( $_block_data , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_BlockHead::get_head_size () );
        $_block_content  = substr ( $_block_data , Class_Base_BlockHead::SIZE_BLOCK_HEAD , $size );
        $_block_end_flag = substr ( $_block_data , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $size ) , Class_Base_BlockEndFlag::get_end_flag_size () );
        $_block_object   = new Base_BlockData( $key , $_block_size , $_block_head , $_block_content , $_block_end_flag );
        return $_block_object;
    }

    public static function read ( $key , $size )
    {
        $_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $size + Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( empty( $_block_id ) ) {
            throw new \Exception( "share memeory id is error" , 0 );
        }
        $_data = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD ) , $size );
        return $_data;
    }

    public static function write ( $key , $value , $size )
    {
        $_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $size + Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( empty( $_block_id ) ) {
            throw new \Exception( "share memory id is error" , 0 );
        }
        $_length = Class_Base_Memory::write_share_memory ( $_block_id , $value , ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD ) );
        return $_length;
    }

    public static function clear_block ( $key , $size )
    {
        $_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $size + Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( ! empty( $_block_id ) ) {
            $_type = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_BlockHead::get_head_block_type_offset () , Class_Base_BlockHead::get_head_block_type_size () );
            if ( $_type == Interface_Base_BlockType::TYPE_BLOCK_DATA ) {
                $_bool = Class_Base_Memory::clear_share_memory_by_key ( $key , $_block_size );
                return $_bool;
            }
        }
        return false;
    }

    public static function check_object_params ( $head , $content , $end_flag )
    {
        if ( ( ( ! is_object ( $head ) ) && ( ! is_string ( $head ) ) ) || ( ( ! is_object ( $content ) ) && ( ! is_string ( $content ) ) ) || ( ( ! is_object ( $end_flag ) ) && ( ! is_string ( $end_flag ) ) ) ) {
            throw new \Exception( "head or data or end_flag is not a string or object" , 0 );
        }
        if ( is_object ( $head ) && is_object ( $content ) && is_object ( $end_flag ) ) {
            if ( ( ! ( $head instanceof Class_Base_BlockHead ) ) || ( ! ( $content instanceof Class_Base_BlockContent ) ) || ( ! ( $end_flag instanceof Class_Base_BlockEndFlag ) ) ) {
                throw new \Exception( "head or data or end_flag is error , head( " . print_r ( $head , true ) . " ) , data : ( " . $content . " ) , end_flag : ( " . $end_flag . " ) " , 0 );
            }
            if ( ( strlen ( $head->get_block_string () ) != Class_Base_BlockHead::SIZE_BLOCK_HEAD ) || ( $content->get_content_size () != $head->get_size () ) || ( strlen ( $end_flag->get_block_string () ) != Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG ) ) {
                throw new \Exception( "head size or data size or end_flag size is error" , 0 );
            }
        } else if ( is_string ( $head ) && is_string ( $content ) && is_string ( $end_flag ) ) {
            if ( strlen ( $head ) != Class_Base_BlockHead::get_head_size () ) {
                throw new \Exception( "unique index block head size is error , head param size( " . strlen ( $head ) . " ) , head size ( " . Class_Base_BlockHead::get_head_size () . " ) " , 0 );
            }
            $_block_key = substr ( $head , Class_Base_BlockHead::get_head_block_key_offset () , Class_Base_BlockHead::get_head_block_key_size () );
            if ( Class_Base_Format::is_empty ( $_block_key ) || ( ! Class_Base_Format::is_min_to_max_hex ( $_block_key , Class_Base_Format::HEX_KEY_MIN_VALUE , Class_Base_Format::HEX_KEY_MAX_VALUE ) ) ) {
                throw new \Exception( "unique index block head key is error , key ( " . $_block_key . " ) " , 0 );
            }
            $_data_size = substr ( $head , Class_Base_BlockHead::get_head_content_size_offset () , Class_Base_BlockHead::get_head_content_size_size () );
            $_data_size = Class_Base_Format::hex_to_dec ( $_data_size );
            if ( strlen ( $content ) != $_data_size ) {
                throw new \Exception( "unique index block data size is error , data param size ( " . strlen ( $content ) . " ) , data size ( " . $_data_size . " ) " , 0 );
            }
            if ( strlen ( $end_flag ) != Class_Base_BlockEndFlag::get_end_flag_size () ) {
                throw new \Exception( "unique index block end_flag size is error , end_flag param size ( " . strlen ( $end_flag ) . " ) , end_flag size ( " . Class_Base_BlockEndFlag::get_end_flag_size () . " ) " , 0 );
            }
        } else {
            throw new \Exception( "unique index block params is error ,  head ( " . print_r ( $head , true ) . " ) , data ( " . print_r ( $content , true ) . " ) , end_flag ( " . print_r ( $end_flag , true ) . " ) " , 0 );
        }
    }

    public function __construct ( $key , $size , $head , $content , $end_flag )
    {
        self::check_object_params ( $head , $content , $end_flag );
        $this->_key  = Class_Base_Format::format_key_write ( $key );
        $this->_size = Class_Base_Format::format_size_write ( $size );
        if ( is_object ( $head ) && is_object ( $content ) && is_object ( $end_flag ) ) {
            $this->_head     = $head->get_block_string ();
            $this->_content  = $content->get_block_string ();
            $this->_end_flag = $end_flag->get_block_string ();
        } else if ( is_string ( $head ) && is_string ( $content ) && is_string ( $end_flag ) ) {
            $this->_head     = $head;
            $this->_content  = $content;
            $this->_end_flag = $end_flag;
        }
    }

    public function __destruct ()
    {
        $this->_key      = null;
        $this->_size     = null;
        $this->_head     = null;
        $this->_content  = null;
        $this->_end_flag = null;
    }

    public function get_key ()
    {
        $_key = Class_Base_Format::hex_to_dec ( $this->_key );
        return $_key;
    }

    public function get_size ()
    {
        $_size = Class_Base_Format::hex_to_dec ( $this->_size );
        return $_size;
    }

    public function get_encode_key ()
    {
        return $this->_key;
    }

    public function get_encode_size ()
    {
        return $this->_size;
    }

    public function get_head ()
    {
        $_block_name    = Class_Base_Format::format_name_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_block_name_offset () , Class_Base_BlockHead::get_head_block_name_size () ) );
        $_block_key     = Class_Base_Format::format_key_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_block_key_offset () , Class_Base_BlockHead::get_head_block_key_size () ) );
        $_content_size  = Class_Base_Format::format_size_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_content_size_offset () , Class_Base_BlockHead::get_head_content_size_size () ) );
        $_block_status  = Class_Base_Format::format_status_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_block_status_offset () , Class_Base_BlockHead::get_head_block_status_size () ) );
        $_block_mode    = Class_Base_Format::format_mode_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_block_mode_offset () , Class_Base_BlockHead::get_head_block_mode_size () ) );
        $_block_type    = Class_Base_Format::format_type_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_block_type_offset () , Class_Base_BlockHead::get_head_block_type_size () ) );
        $_content_type  = Class_Base_Format::format_type_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_content_type_offset () , Class_Base_BlockHead::get_head_content_type_size () ) );
        $_reserved      = Class_Base_Format::format_reserved_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_reserved_offset () , Class_Base_BlockHead::get_head_reserved_size () ) );
        $_head_end_flag = Class_Base_Format::format_end_flag_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_end_flag_offset () , Class_Base_BlockHead::get_head_end_flag_size () ) );
        $_head          = new Class_Base_BlockHead( $_block_name , $_block_key , $_content_size , $_block_status , $_block_mode , $_block_type , $_content_type , $_reserved , $_head_end_flag );
        return $_head;
    }

    public function get_encode_head ()
    {
        return $this->_head;
    }

    public function get_content ()
    {
        $_content = Class_Base_Format::content_to_string ( $this->_content );
        $_size    = Class_Base_Format::format_size_read ( substr ( $this->_head , Class_Base_BlockHead::get_head_content_size_offset () , Class_Base_BlockHead::get_head_content_size_size () ) );
        $_content = new Class_Base_BlockContent( $_content , $_size );
        return $_content;
    }

    public function get_encode_content ()
    {
        return $this->_content;
    }

    public function get_end_flag ()
    {
        $_end_flag = Class_Base_Format::end_flag_to_string ( $this->_content , Class_Base_BlockEndFlag::get_end_flag_size () );
        $_end_flag = new Class_Base_BlockEndFlag( $_end_flag );
        return $_end_flag;
    }

    public function get_encode_end_flag ()
    {
        return $this->_end_flag;
    }

    public function get_block_string ()
    {
        $_block_string = ( $this->_head . $this->_content . $this->_end_flag );
        return $_block_string;
    }

    public function get_block_string_size ()
    {
        $_block_string        = self::get_block_string ();
        $_block_string_length = strlen ( $_block_string );
        return $_block_string_length;
    }
}