<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-23
 * Time: 下午4:59
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

class Class_Base_Block_Keys extends Class_Base_Block implements Interface_Base_Block_Keys
{
    private static $_key      = Interface_Base_BlockKey::KEYS;
    private        $_head     = null;
    private        $_content  = null;
    private        $_end_flag = null;

    public static function get_key ()
    {
        return Interface_Base_BlockKey::KEYS;
    }

    public static function set_block_key ( $key )
    {
        self::$_key = $key;
    }

    public static function get_block_key ()
    {
        return self::$_key;
    }

    public static function get_block_size ()
    {
        return self::SIZE_BLOCK;
    }

    public static function get_head_size ()
    {
        return Class_Base_BlockHead::get_head_size ();
    }

    public static function get_content_size ()
    {
        return self::MAP_SIZE;
    }

    public static function get_map_count ( $key )
    {
        $_count     = 0;
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::MAP_SIZE ; $index += self::MAP_ITEM_SIZE ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::MAP_ITEM_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! self::is_empty ( $_item ) ) {
                    $_count++;
                }
            }
        }
        return $_count;
    }

    public static function get_end_flag_size ()
    {
        return Class_Base_BlockEndFlag::get_end_flag_size ();
    }

    public static function is_empty ( $data )
    {
        if ( is_string ( $data ) ) {
            $data = str_replace ( "\0" , "" , $data );
        }
        $_bool = empty( $data );
        return $_bool;
    }

    public static function get_block ( $key )
    {
        self::$_key = $key;
        $_block_id  = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::SIZE_BLOCK );
        return $_block_id;
    }

    public static function read_block_string ( $key )
    {
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_block_string = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , self::SIZE_BLOCK , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        return $_block_string;
    }

    public static function create_head ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag )
    {
        $_head = Class_Base_BlockHead::create_block_head ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag );
        return $_head;
    }

    public static function create_content ( $content )
    {
        $_content = Class_Base_BlockContent::create_block_content ( $content , self::get_content_size () );
        return $_content;
    }

    public static function create_end_flag ( $end_flag )
    {
        $_end_flag = Class_Base_BlockEndFlag::create_block_end_flag ( $end_flag );
        return $_end_flag;
    }

    public static function create_block_data ( $head , $content , $end_flag )
    {
        $_block_keys = new Class_Base_Block_Keys( $head , $content , $end_flag );
        return $_block_keys;
    }

    public static function init_block_data ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag , $content , $end_flag )
    {
        $_head         = self::create_head ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag );
        $_content      = self::create_content ( $content );
        $_end_flag     = self::create_end_flag ( $end_flag );
        $_block_keys   = self::create_block_data ( $_head , $_content , $_end_flag );
        $_block_string = $_block_keys->create_block_string ();
        $_block_id     = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::get_block_size () );
        $_length       = Class_Base_Memory::write_share_memory ( $_block_id , $_block_string , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        return $_length;
    }

    public static function read_head ( $key )
    {
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_head = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_BlockHead::SIZE_BLOCK_HEAD , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        return $_head;
    }

    public static function read_content ( $key )
    {
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_data = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD ) , self::MAP_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        return $_data;
    }

    public static function read_end_flag ( $key )
    {
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_end_flag = Class_Base_Memory::read_share_memory ( $_block_id , ( self::SIZE_BLOCK - Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG ) , Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        return $_end_flag;
    }

    public static function exist_map_item_key ( $key , $item_key )
    {
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::MAP_SIZE ; $index += self::MAP_ITEM_SIZE ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::MAP_ITEM_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! self::is_empty ( $_item ) ) {
                    $_item_key = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , self::SIZE_BLOCK_KEY ) );
                    if ( $_item_key == $item_key ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function get_map_item ( $key , $item_key )
    {
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::MAP_SIZE ; $index += self::MAP_ITEM_SIZE ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::MAP_ITEM_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! self::is_empty ( $_item ) ) {
                    $_item_key = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , self::SIZE_BLOCK_KEY ) );
                    if ( $_item_key == $item_key ) {
                        return $_item;
                    }
                }
            }
        }
        return null;
    }

    public static function set_map_item ( $key , $item_key , $item_size )
    {
        self::$_key = $key;
        $_length    = self::write_map_item ( $key , $item_key , $item_size );
        return $_length;
    }

    public static function get_map_item_size ( $key , $item_key )
    {
        self::$_key = $key;
        $_block_id  = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::MAP_SIZE ; $index += self::MAP_ITEM_SIZE ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::MAP_ITEM_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! self::is_empty ( $_item ) ) {
                    $_item_key = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , self::SIZE_BLOCK_KEY ) );
                    if ( $_item_key == $item_key ) {
                        $_item_size = Class_Base_Format::hex_to_dec ( substr ( $_item , self::SIZE_BLOCK_KEY , self::SIZE_BLOCK_SIZE ) );
                        return $_item_size;
                    }
                }
            }
        }
        return null;
    }

    public static function write_map_item ( $key , $item_key , $item_size )
    {
        self::$_key = $key;
        $_exist     = self::exist_map_item_key ( $key , $item_key );
        if ( ! $_exist ) {
            $_block_id = self::get_block ( $key );
            if ( ! self::is_empty ( $_block_id ) ) {
                $_head = self::get_head ( $key );
                if ( Class_Base_Format::is_empty ( $_head ) ) {
                    self::init_block_data ( Interface_Base_BlockName::NAME_BLOCK_KEYS , $key , self::MAP_SIZE , Interface_Base_BlockStatus::STATUS_BLOCK_ENABLED , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Interface_Base_BlockType::TYPE_BLOCK_KEYS , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_BlockHead::FLAG_BLOCK_HEAD_END , null , Class_Base_BlockEndFlag::FLAG_BLOCK_END );
                }
                for ( $index = 0 ; $index < self::MAP_SIZE ; $index += self::MAP_ITEM_SIZE ) {
                    $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::MAP_ITEM_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( self::is_empty ( $_item ) ) {
                        $_item_key  = Class_Base_Format::dec_to_hex ( $item_key );
                        $_item_size = Class_Base_Format::dec_to_hex ( $item_size );
                        $_item      = ( $_item_key . $_item_size );
                        $_length    = Class_Base_Memory::write_share_memory ( $_block_id , $_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                        return $_length;
                    }
                }
            }
        } else {
            $_block_id = self::get_block ( $key );
            if ( ! self::is_empty ( $_block_id ) ) {
                $_head = self::get_head ( $key );
                if ( Class_Base_Format::is_empty ( $_head ) ) {
                    self::init_block_data ( Interface_Base_BlockName::NAME_BLOCK_KEYS , $key , self::MAP_SIZE , Interface_Base_BlockStatus::STATUS_BLOCK_ENABLED , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Interface_Base_BlockType::TYPE_BLOCK_KEYS , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_BlockHead::FLAG_BLOCK_HEAD_END , null , Class_Base_BlockEndFlag::FLAG_BLOCK_END );
                }
                for ( $index = 0 ; $index < self::MAP_SIZE ; $index += self::MAP_ITEM_SIZE ) {
                    $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::MAP_ITEM_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( ! self::is_empty ( $_item ) ) {
                        $_item_key = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , self::SIZE_BLOCK_KEY ) );
                        if ( $item_key == $_item_key ) {
                            $_item_size = Class_Base_Format::dec_to_hex ( $item_size );
                            $_length    = Class_Base_Memory::write_share_memory ( $_block_id , $_item_size , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index + self::SIZE_BLOCK_KEY ) , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                            return $_length;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function set_map ( $key , $map )
    {
        $_write_result = array ();
        self::$_key    = $key;
        if ( is_array ( $map ) ) {
            foreach ( $map as $k => $v ) {
                $_length = self::write_map_item ( $key , $k , $v );
                if ( self::is_empty ( $_length ) ) {
                    $_write_result[ $k ] = 0;
                } else {
                    $_write_result[ $k ] = 1;
                }

            }
        }
        return $_write_result;
    }

    public static function read_map ( $key )
    {
        self::$_key = $key;
        $_map       = array ();
        $_block_id  = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::MAP_SIZE ; $index += self::MAP_ITEM_SIZE ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::MAP_ITEM_SIZE , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! self::is_empty ( $_item ) ) {
                    $_item_key  = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , self::SIZE_BLOCK_KEY ) );
                    $_item_size = Class_Base_Format::hex_to_dec ( substr ( $_item , self::SIZE_BLOCK_KEY , self::SIZE_BLOCK_SIZE ) );
                    if ( ! self::is_empty ( $_item_key ) ) {
                        $_map[ $_item_key ] = $_item_size;
                    }
                }
            }
        }
        return $_map;
    }

    public static function clear ( $key )
    {
        $_block_id = self::get_block ( $key );
        if ( ! empty( $_block_id ) ) {
            $_block_type = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_BlockHead::get_head_block_type_offset () , Class_Base_BlockHead::get_head_block_type_size () );
            if ( $_block_type == Interface_Base_BlockType::TYPE_BLOCK_KEYS ) {
                $_bool = Class_Base_Memory::clear_share_memory_by_key ( $key , self::SIZE_BLOCK );
                return $_bool;
            }
        }
        return false;
    }

    private static $_check_keys_status = array ();

    public static function get_check_keys_status ( $key )
    {
        if ( array_key_exists ( $key , self::$_check_keys_status ) ) {
            return self::$_check_keys_status[ $key ];
        }
        return null;
    }

    public static function is_check_keys_status ( $key )
    {
        if ( array_key_exists ( $key , self::$_check_keys_status ) ) {
            if ( ! empty( self::$_check_keys_status[ $key ] ) ) {
                return true;
            }
        }
        return false;
    }

    public static function enable_check_keys_status ( $key )
    {
        self::$_check_keys_status[ $key ] = 1;
    }

    public static function start_check_status ( $key )
    {
        if ( self::is_check_keys_status ( $key ) ) {
            return false;
        }
        self::enable_check_keys_status ( $key );
        return true;
    }

    public static function clear_check_status ( $key )
    {
        if ( array_key_exists ( $key , self::$_check_keys_status ) ) {
            self::$_check_keys_status[ $key ] = null;
            unset( self::$_check_keys_status[ $key ] );
        }
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
            if ( ( strlen ( $head->get_block_string () ) != Class_Base_BlockHead::SIZE_BLOCK_HEAD ) || ( $content->get_encode_content_size () != $head->get_content_size () ) || ( strlen ( $end_flag->get_block_string () ) != Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG ) ) {
                throw new \Exception( "head size or data size or end_flag size is error , head object size (" . ( strlen ( $head->get_block_string () ) ) . ") , head content_size ( " . $head->get_content_size () . " ) , content size ( " . $content->get_content_size () . " ) , end_flag size ( " . ( strlen ( $end_flag->get_block_string () ) ) . " ) " , 0 );
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

    public function create_block_string ()
    {
        $_block_string = ( $this->_head . $this->_content . $this->_end_flag );
        return $_block_string;
    }

    public function get_create_block_string_size ()
    {
        $_block_string        = self::create_block_string ();
        $_block_string_length = strlen ( $_block_string );
        return $_block_string_length;
    }
}