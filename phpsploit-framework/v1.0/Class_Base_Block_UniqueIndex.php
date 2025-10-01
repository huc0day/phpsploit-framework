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

class Class_Base_Block_UniqueIndex extends Class_Base_Block implements Interface_Base_Block_UniqueIndex
{
    private $_head     = null;
    private $_content  = null;
    private $_end_flag = null;

    public static function get_key ()
    {
        return Interface_Base_BlockKey::WEB_UNIQUE_INDEX;
    }

    public static function get_block ( $key )
    {
        $_block_id = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::SIZE_BLOCK );
        if ( empty( $_block_id ) ) {
            throw new \Exception( "unique index block open is error" , 0 );
        }
        $_head = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_BlockHead::SIZE_BLOCK_HEAD , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( ! Class_Base_BlockHead::check_block_head_data ( $_head ) ) {
            $_head_object     = Class_Base_BlockHead::create_block_head ( self::NAME , self::KEY , self::SIZE_BLOCK_HEAD_CONTENT_SIZE , self::STATUS_BLOCK_ENABLED , self::MODE_BLOCK_READ_AND_WRITE , self::TYPE_BLOCK_UNIQUE_INDEX , self::TYPE_CONTENT_INTEGER , Class_Base_Format::string_to_reserved ( null , self::SIZE_BLOCK_HEAD_RESERVED ) , Class_Base_BlockHead::FLAG_BLOCK_HEAD_END );
            $_head            = $_head_object->get_block_string ();
            $_hex_index_start = Class_Base_Format::dec_to_hex ( self::INDEX_START );
            $_data_object     = Class_Base_BlockContent::create_block_content ( $_hex_index_start , self::SIZE_HEX_INTEGER );
            $_data            = $_data_object->get_block_string ();
            $_end_flag_object = Class_Base_BlockEndFlag::create_block_end_flag ( Class_Base_BlockHead::FLAG_BLOCK_HEAD_END );
            $_end_flag        = $_end_flag_object->get_block_string ();
            $_block_string    = ( $_head . $_data . $_end_flag );
            $_length          = Class_Base_Memory::write_share_memory ( $_block_id , $_block_string , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            if ( empty( $_length ) ) {
                throw new \Exception( "unique index block init is error" , 0 );
            }
        }
        return $_block_id;
    }

    public static function clear_block ( $key )
    {
        $_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + self::SIZE_HEX_INTEGER + self::SIZE_BLOCK_END_FLAG );
        $_block_id   = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_block_size );
        if ( ! empty( $_block_id ) ) {
            $_type = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_BlockHead::get_head_block_type_offset () , Class_Base_BlockHead::get_head_block_type_size () );
            if ( $_type == Interface_Base_BlockType::TYPE_BLOCK_UNIQUE_INDEX ) {
                $_bool = Class_Base_Memory::clear_share_memory_by_key ( $key , self::SIZE_BLOCK );
                return $_bool;
            }
        }
        return false;
    }

    public static function get_index ( $key )
    {
        $_block_id       = self::get_block ( $key );
        $_hex_index      = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD ) , self::SIZE_HEX_INTEGER , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        $_dec_index      = Class_Base_Format::hex_to_dec ( $_hex_index );
        $_dec_next_index = ( $_dec_index + 1 );
        if ( $_dec_next_index > self::INDEX_LIMIT ) {
            throw new \Exception( "unique index greater than limit , index ( " . $_dec_next_index . " ) " , 0 );
        }
        $_hex_next_index = Class_Base_Format::dec_to_hex ( $_dec_next_index );
        $_length         = Class_Base_Memory::write_share_memory ( $_block_id , $_hex_next_index , ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD ) , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( empty( $_length ) ) {
            throw new \Exception( "unique index block autoincrement index is error" , 0 );
        }
        return $_dec_index;
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
            if ( ( strlen ( $head->get_block_string () ) != Class_Base_BlockHead::get_head_size () ) || ( $content->get_content_size () != $head->get_content_size () ) || ( strlen ( $end_flag->get_block_string () ) != Class_Base_BlockEndFlag::get_end_flag_size () ) ) {
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

    public function __construct ( $head , $content , $end_flag )
    {
        self::check_object_params ( $head , $content , $end_flag );
        if ( is_object ( $head ) && is_object ( $content ) && is_object ( $end_flag ) ) {
            $this->_head     = $head->get_block_string ();
            $this->_content  = $content->get_block_string ();
            $this->_end_flag = $end_flag->get_block_string ();
        } else if ( is_string ( $head ) && is_string ( $content ) && is_string ( $end_flag ) ) {
            $this->_head     = $head;
            $this->_content  = $content;
            $this->_end_flag = $end_flag;
        }
        parent::__construct ( $this->_head , $this->_content , $this->_end_flag );
    }

    public function __destruct ()
    {
        $this->_head     = null;
        $this->_content  = null;
        $this->_end_flag = null;
    }

    public function get_block_string ()
    {
        $_block_string = ( $this->_head . $this->_content . $this->_end_flag );
        return $_block_string;
    }

    public function get_head_string ()
    {
        $_block_head_string = ( $this->_head );
        return $_block_head_string;
    }

    public function get_data_string ()
    {
        $_block_data_string = ( $this->_content );
        return $_block_data_string;
    }

    public function get_end_flag_string ()
    {
        $_block_end_flag_string = ( $this->_end_flag );
        return $_block_end_flag_string;
    }

}