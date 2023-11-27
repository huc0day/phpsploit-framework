<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-27
 * Time: 上午11:03
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

class Class_Base_Memory extends Class_Base implements Interface_Base_Memory
{
    private static $_lock_keys = array (
        'default' => 0000000000 ,
    );

    public static function get_lock_keys ()
    {
        return self::$_lock_keys;
    }

    public static function get_lock_key ( $key )
    {
        if ( empty( self::$_lock_keys[ $key ] ) ) {
            return null;
        }
        return self::$_lock_keys[ $key ];
    }

    public static function exist_lock_key ( $key , $value )
    {
        if ( ( array_key_exists ( $key , self::$_lock_keys ) ) && ( in_array ( $value , self::$_lock_keys ) ) && ( self::$_lock_keys[ $key ] == $value ) ) {
            return 1;
        }
        return 0;
    }

    public static function add_lock_key ( $key , $value )
    {
        if ( ( array_key_exists ( $key , self::$_lock_keys ) ) || ( in_array ( $value , self::$_lock_keys ) ) ) {
            return 0;
        }
        self::$_lock_keys[ $key ] = $value;
        return 1;
    }

    //
    public static function path ( $path )
    {
        $_path = str_replace ( "\\" , "/" , $path );
        return $_path;
    }

    public static function check_pack_integer ( $integer )
    {
        if ( ! Class_Base_Format::is_minlen_to_maxlen_integer ( $integer , Class_Base_Format::INTEGER_MIN_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) {
            throw new \Exception( "pack integer data is error , data : " . print_r ( $integer , true ) , 0 );
        }
    }

    public static function pack ( $data , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_format = self::DATA_FORMAT_STRING_NULL_FILL_PACK;
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            self::check_pack_integer ( $data );
            $_format = self::DATA_FORMAT_64_INTEGER_PACK;
            $data    = dechex ( $data );
        }
        $_pack_data = pack ( $_format , $data );
        return $_pack_data;
    }

    public static function unpack ( $pack_data , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_format = self::DATA_FORMAT_STRING_NULL_FILL_PACK;
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            $_format = self::DATA_FORMAT_64_INTEGER_PACK;
        }
        $_data = unpack ( $_format , $pack_data );
        if ( is_array ( $_data ) ) {
            $_data = $_data[ 1 ];
        }
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            $_data = hexdec ( $_data );
            if ( ! Class_Base_Format::is_minlen_to_maxlen_integer ( $_data , Class_Base_Format::INTEGER_MIN_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) {
                throw new \Exception( "unpack integer data is error , data : " . print_r ( $_data , true ) , 0 );
            }
        }
        return $_data;
    }

    //

    public static function read_share_memory_integer ( $key )
    {
        $_block_id = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::BLOCK_SIZE_16 );
        $_integer  = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , self::BLOCK_SIZE_16 , self::DATA_FORMAT_TYPE_64_INTEGER_PACK );
        return $_integer;
    }

    public static function write_share_memory_integer ( $key , $value )
    {
        $_block_id = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::BLOCK_SIZE_16 );
        $_length   = Class_Base_Memory::write_share_memory ( $_block_id , $value , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , self::DATA_FORMAT_TYPE_64_INTEGER_PACK );
        return $_length;
    }

    //
    public static function create_share_memory_key ()
    {
        $_key = time () . rand ( 10000000 , 99999999 );
        return $_key;
    }

    public static function create_share_memory ( &$key = null , $mode = self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size = self::BLOCK_SIZE_65536 , $is_check_key_format = true )
    {
        if ( ( ! empty( $is_check_key_format ) ) ) {
            if ( empty( $key ) || ( ! Class_Base_Format::is_minlen_to_maxlen_integer ( $key , Class_Base_Format::INTEGER_MAX_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) ) {
                $key = self::create_share_memory_key ();
            }
        } else {
            if ( empty( $key ) ) {
                $key = self::create_share_memory_key ();
            }
        }
        $_shmid = shmop_open ( $key , self::FLAGS_SHARE_MEMORY_CREATE , $mode , $size );
        if ( ( ! empty( $_shmid ) ) ) {
            self::_add_keys_item ( Class_Base_Block_Keys::get_block_key () , $key , $size );
        }
        return $_shmid;
    }

    public static function open_share_memory ( &$key = null , $mode = self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size = self::BLOCK_SIZE_65536 , $flags = self::FLAGS_SHARE_MEMORY_OPEN , $is_check_key_format = true )
    {
        if ( ( ! empty( $is_check_key_format ) ) ) {
            if ( empty( $key ) || ( ! Class_Base_Format::is_minlen_to_maxlen_integer ( $key , Class_Base_Format::INTEGER_MAX_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) ) {
                $key = self::create_share_memory_key ();
            }
        } else {
            if ( empty( $key ) ) {
                $key = self::create_share_memory_key ();
            }
        }
        $_shmid = shmop_open ( $key , $flags , $mode , $size );
        if ( ( ! empty( $_shmid ) ) ) {
            $_check = Class_Base_Block_Keys::start_check_status ( $key );
            if ( ! empty( $_check ) ) {
                self::_add_keys_item ( Class_Base_Block_Keys::get_block_key () , $key , $size );
            }
        }
        return $_shmid;
    }

    public static function size_share_memory ( $shmid )
    {
        $_size = shmop_size ( $shmid );
        return $_size;
    }

    public static function read_share_memory ( $shmid , $offset = self::SHARE_MEMORY_OFFSET_START , $length = self::BLOCK_SIZE_65536 , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_pack_data = shmop_read ( $shmid , $offset , $length );
        $_data      = self::unpack ( $_pack_data , $format_type );
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            $_data = intval ( $_data );
        }
        return $_data;
    }

    public static function write_share_memory ( $shmid , $data , $offset = self::SHARE_MEMORY_OFFSET_START , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_pack_data = self::pack ( $data , $format_type );
        $_length    = shmop_write ( $shmid , $_pack_data , $offset );
        if ( ! empty( $_length ) ) {
            $_length = shmop_size ( $shmid );
        }
        return $_length;
    }

    public static function reset_string_share_memory ( $shmid , $size )
    {
        $_success = 1;
        for ( $index = 0 ; $index < $size ; $index++ ) {
            $_length = self::write_share_memory ( $shmid , self::BLCOK_DATA_VALUE_ASCII_CODE_ZERO , $index , self::DATA_FORMAT_STRING_NULL_FILL_PACK );
            if ( empty( $_length ) ) {
                $_success = 0;
            }
        }
        return $_success;
    }

    public static function reset_integer_share_memory ( $shmid )
    {
        $_success = 1;
        $_length  = self::write_share_memory ( $shmid , self::BLOCK_DATA_VALUE_INTEGER_ZERO , self::SHARE_MEMORY_OFFSET_START , self::DATA_FORMAT_64_INTEGER_PACK );
        if ( empty( $_length ) ) {
            $_success = 0;
        }
        return $_success;
    }

    public static function clear_share_memory ( $shmid )
    {
        $_bool = shmop_delete ( $shmid );
        if ( ! empty( $_bool ) ) {
            @shmop_close ( $shmid );
        }
        return $_bool;
    }

    //
    public static function size_share_memory_by_key ( $key , $size )
    {
        $_shmid = self::open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size );
        $_size  = shmop_size ( $_shmid );
        return $_size;
    }

    public static function read_share_memory_by_key ( $key , $size , $offset = self::SHARE_MEMORY_OFFSET_START , $length = self::BLOCK_SIZE_65536 , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_shmid     = self::open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size );
        $_pack_data = shmop_read ( $_shmid , $offset , $length );
        $_data      = self::unpack ( $_pack_data , $format_type );
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            $_data = intval ( $_data );
        }
        return $_data;
    }

    public static function write_share_memory_by_key ( $key , $size , $data , $offset = self::SHARE_MEMORY_OFFSET_START , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_shmid     = self::open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size );
        $_pack_data = self::pack ( $data , $format_type );
        $_length    = shmop_write ( $_shmid , $_pack_data , $offset );
        if ( ! empty( $_length ) ) {
            $_length = shmop_size ( $_shmid );
        }
        return $_length;
    }

    public static function reset_string_share_memory_by_key ( $key , $size )
    {
        $_shmid   = self::open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size );
        $_success = 1;
        for ( $index = 0 ; $index < $size ; $index++ ) {
            $_length = self::write_share_memory ( $_shmid , self::BLCOK_DATA_VALUE_ASCII_CODE_ZERO , $index , self::DATA_FORMAT_STRING_NULL_FILL_PACK );
            if ( empty( $_length ) ) {
                $_success = 0;
            }
        }
        return $_success;
    }

    public static function reset_integer_share_memory_by_key ( $key , $size )
    {
        $_shmid   = self::open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size );
        $_success = 1;
        $_length  = self::write_share_memory ( $_shmid , self::BLOCK_DATA_VALUE_INTEGER_ZERO , self::SHARE_MEMORY_OFFSET_START , self::DATA_FORMAT_64_INTEGER_PACK );
        if ( empty( $_length ) ) {
            $_success = 0;
        }
        return $_success;
    }

    public static function delete_share_memory_by_key ( $key , $size )
    {
        $key  = intval ( $key );
        $size = intval ( $size );
        if ( $key == Interface_Base_Block_Keys::KEY ) {
            return false;
        }
        $_keys_key = Interface_Base_Block_Keys::KEY;
        $_shmid    = self::open_share_memory ( $_keys_key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , Interface_Base_Block_Keys::SIZE_BLOCK , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( empty( $_shmid ) ) {
            return false;
        }
        for ( $index = Class_Base_BlockHead::SIZE_BLOCK_HEAD ; $index < ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + Interface_Base_Block_Keys::MAP_SIZE ) ; $index += Interface_Base_Block_Keys::MAP_ITEM_SIZE ) {
            $_item = Class_Base_Memory::read_share_memory ( $_shmid , $index , Interface_Base_Block_Keys::MAP_ITEM_SIZE , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            if ( ! Class_Base_Format::is_empty ( $_item ) ) {
                $_item_hex_key  = substr ( $_item , 0 , Interface_Base_Block_Keys::SIZE_BLOCK_KEY );
                $_item_hex_size = substr ( $_item , Interface_Base_Block_Keys::SIZE_BLOCK_KEY , Interface_Base_Block_Keys::SIZE_BLOCK_SIZE );
                $_item_dec_key  = Class_Base_Format::hex_to_dec ( $_item_hex_key );
                $_item_dec_size = Class_Base_Format::hex_to_dec ( $_item_hex_size );
                if ( ( ! empty( $_item_dec_key ) ) && ( ! empty( $_item_dec_size ) ) ) {
                    if ( ( $key == $_item_dec_key ) && ( $size == $_item_dec_size ) ) {
                        $_item_shmid = self::open_share_memory ( $_item_dec_key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $_item_dec_size , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
                        if ( ! empty( $_item_shmid ) ) {
                            $_item_deleted = self::clear_share_memory ( $_item_shmid );
                            if ( empty( $_item_deleted ) ) {
                                return false;
                            }
                        }
                        $_write_length = self::write_share_memory ( $_shmid , Class_Base_Format::string_to_data ( null , Interface_Base_Block_Keys::MAP_ITEM_SIZE ) , $index , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                        if ( empty( $_write_length ) ) {
                            return false;
                        }
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function clear_share_memory_by_key ( $key , $size )
    {
        $_shmid = self::_open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( $key == Class_Base_Block_Keys::get_block_key () ) {
            $_count = Class_Base_Block_Keys::get_map_count ( $key );
            if ( empty( $_count ) ) {
                $_bool = self::clear_share_memory ( $_shmid );
                return $_bool;
            } else if ( ( $_count == 1 ) ) {
                $_item_key = self::read_share_memory ( $_shmid , Class_Base_BlockHead::SIZE_BLOCK_HEAD , Class_Base_Block_Keys::SIZE_BLOCK_KEY );
                if ( Class_Base_Format::is_empty ( $_item_key ) ) {
                    $_bool = self::clear_share_memory ( $_shmid );
                    return $_bool;
                } else {
                    $_item_key = Class_Base_Format::hex_to_dec ( $_item_key );
                    if ( $_item_key == Interface_Base_BlockKey::KEYS ) {
                        $_bool = self::clear_share_memory ( $_shmid );
                        return $_bool;
                    }
                }
            }
        } else {
            $_length = self::_clear_keys_item ( Class_Base_Block_Keys::get_block_key () , $key );
            if ( ! empty( $_length ) ) {
                Class_Base_Block_Keys::clear_check_status ( $key );
                $_bool = self::clear_share_memory ( $_shmid );
                return $_bool;
            }
        }
        return false;
    }
    //

    //
    public static function create_lock_key ( $key )
    {
        $_key = self::LOCK_KEY . $key;
        return $_key;
    }

    public static function get_lock_id ( $key = null )
    {
        if ( empty( $key ) || ( ! is_numeric ( $key ) ) ) {
            return null;
        }
        $_sem_id = sem_get ( $key );
        return $_sem_id;
    }

    public static function lock ( $key = null )
    {
        $_sem_id = self::get_lock_id ( $key );
        if ( empty( $_sem_id ) ) {
            throw new \Exception( "share memory lock id is error" , 0 );
        }
        $_success = sem_acquire ( $_sem_id );
        if ( empty( $_success ) ) {
            throw new \Exception( "get share memory lock is error" , 0 );
        }
        return $_sem_id;
    }

    public static function unlock ( $key )
    {
        $_sem_id = sem_get ( $key );
        if ( $_sem_id === false ) {
            throw new \Exception( "sem id : false" , 0 );
        }
        $_success = sem_release ( $_sem_id );
        if ( $_success === false ) {
            //throw new \Exception("sem release : false", 0);
        }
        if ( $_success ) {
            $_success = sem_remove ( $_sem_id );
            if ( $_success === false ) {
                throw new \Exception( "sem remove : false" , 0 );
            }
        }
        return $_sem_id;
    }

    private static function _open_share_memory ( &$key = null , $mode = self::MODE_SHARE_MEMORY_READ_AND_WRITE , $size = self::BLOCK_SIZE_65536 , $flags = self::FLAGS_SHARE_MEMORY_OPEN )
    {
        if ( empty( $key ) || ( ! is_integer ( $key ) ) ) {
            $key = self::create_share_memory_key ();
        }
        $_shmid = shmop_open ( $key , $flags , $mode , $size );
        return $_shmid;
    }

    //
    private static function _exist_keys_item_key ( $key , $item_key )
    {
        $_block_id = self::_open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Block_Keys::SIZE_BLOCK , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( ! Class_Base_Format::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < Class_Base_Block_Keys::MAP_SIZE ; $index += Class_Base_Block_Keys::MAP_ITEM_SIZE ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Block_Keys::MAP_ITEM_SIZE , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! Class_Base_Format::is_empty ( $_item ) ) {
                    $_item_key = hexdec ( substr ( $_item , 0 , Class_Base_Block_Keys::SIZE_BLOCK_KEY ) );
                    if ( $_item_key == $item_key ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private static function _add_keys_item ( $key , $item_key , $item_size )
    {
        $_exist = self::_exist_keys_item_key ( $key , $item_key );
        if ( ! $_exist ) {
            $_block_id = self::_open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Block_Keys::SIZE_BLOCK );
            if ( ! Class_Base_Format::is_empty ( $_block_id ) ) {
                $_block_head = self::read_share_memory ( $_block_id , self::SHARE_MEMORY_OFFSET_START , Class_Base_BlockHead::SIZE_BLOCK_HEAD , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( Class_Base_Format::is_empty ( $_block_head ) ) {
                    $_block_head_object = Class_Base_BlockHead::create_block_head ( Interface_Base_BlockName::NAME_BLOCK_KEYS , $key , Interface_Base_Block_Keys::MAP_SIZE , Interface_Base_BlockStatus::STATUS_BLOCK_ENABLED , Interface_Base_BlockMode::MODE_BLOCK_READ_AND_WRITE , Interface_Base_BlockType::TYPE_BLOCK_KEYS , Interface_Base_BlockContentType::TYPE_CONTENT_STRING , null , Class_Base_BlockHead::FLAG_BLOCK_HEAD_END );
                    $_block_head        = $_block_head_object->get_block_string ();
                    $_write_length      = self::write_share_memory ( $_block_id , $_block_head , self::SHARE_MEMORY_OFFSET_START , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( empty( $_write_length ) ) {
                        throw new \Exception( "keys block init is fail" , 0 );
                    }
                }
                $_block_end_flag = self::read_share_memory ( $_block_id , ( self::SHARE_MEMORY_OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD + Interface_Base_Block_Keys::MAP_SIZE ) , Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( Class_Base_Format::is_empty ( $_block_end_flag ) ) {
                    $_block_end_flag_object = Class_Base_BlockEndFlag::create_block_end_flag ( Interface_Base_BlockEndFlag::FLAG_BLOCK_END );
                    $_block_end_flag        = $_block_end_flag_object->get_block_string ();
                    $_write_length          = self::write_share_memory ( $_block_id , $_block_end_flag , self::SHARE_MEMORY_OFFSET_START , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( empty( $_write_length ) ) {
                        throw new \Exception( "keys block init is fail" , 0 );
                    }
                }
                for ( $index = 0 ; $index < Class_Base_Block_Keys::MAP_SIZE ; $index += Class_Base_Block_Keys::MAP_ITEM_SIZE ) {
                    $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Block_Keys::MAP_ITEM_SIZE , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( Class_Base_Format::is_empty ( $_item ) ) {
                        $_item_key  = Class_Base_Format::dec_to_hex ( $item_key );
                        $_item_size = Class_Base_Format::dec_to_hex ( $item_size );
                        $_item      = ( $_item_key . $_item_size );
                        $_length    = Class_Base_Memory::write_share_memory ( $_block_id , $_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                        if ( empty( $_length ) ) {
                            throw new \Exception( "write block key to block keys is error" , 0 );
                        }
                        return $_length;
                    }
                }
            }
        }
        return false;
    }

    private static function _write_keys_item ( $key , $item_key , $item_size )
    {
        $_exist = self::_exist_keys_item_key ( $key , $item_key );
        if ( ! $_exist ) {
            $_block_id = self::_open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Block_Keys::SIZE_BLOCK , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( ! Class_Base_Format::is_empty ( $_block_id ) ) {
                for ( $index = 0 ; $index < Class_Base_Block_Keys::MAP_SIZE ; $index += Class_Base_Block_Keys::MAP_ITEM_SIZE ) {
                    $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Block_Keys::MAP_ITEM_SIZE , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( Class_Base_Format::is_empty ( $_item ) ) {
                        $_item_key  = Class_Base_Format::dec_to_hex ( $item_key );
                        $_item_size = Class_Base_Format::dec_to_hex ( $item_size );
                        $_item      = ( $_item_key . $_item_size );
                        $_length    = Class_Base_Memory::write_share_memory ( $_block_id , $_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                        return $_length;
                    }
                }
            }
        } else {
            $_block_id = self::_open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Block_Keys::SIZE_BLOCK , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( ! Class_Base_Format::is_empty ( $_block_id ) ) {
                for ( $index = 0 ; $index < Class_Base_Block_Keys::MAP_SIZE ; $index += Class_Base_Block_Keys::MAP_ITEM_SIZE ) {
                    $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Block_Keys::MAP_ITEM_SIZE , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( ! Class_Base_Format::is_empty ( $_item ) ) {
                        $_item_key = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , Class_Base_Block_Keys::SIZE_BLOCK_KEY ) );
                        if ( $item_key == $_item_key ) {
                            $_item_size = Class_Base_Format::dec_to_hex ( $item_size );
                            $_length    = Class_Base_Memory::write_share_memory ( $_block_id , $_item_size , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index + Class_Base_Block_Keys::SIZE_BLOCK_KEY ) , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                            return $_length;
                        }
                    }
                }
            }
        }
        return false;
    }

    private static function _clear_keys_item ( $key , $item_key )
    {
        $_exist = self::_exist_keys_item_key ( $key , $item_key );
        if ( $_exist ) {
            $_block_id = self::_open_share_memory ( $key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Block_Keys::SIZE_BLOCK , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( ! Class_Base_Format::is_empty ( $_block_id ) ) {
                for ( $index = 0 ; $index < Class_Base_Block_Keys::MAP_SIZE ; $index += Class_Base_Block_Keys::MAP_ITEM_SIZE ) {
                    $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Class_Base_Block_Keys::MAP_ITEM_SIZE , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( ! Class_Base_Format::is_empty ( $_item ) ) {
                        $_item_key = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , Class_Base_Block_Keys::SIZE_BLOCK_KEY ) );
                        if ( $item_key == $_item_key ) {
                            $_item   = Class_Base_Format::string_to_content ( null , Class_Base_Block_Keys::MAP_ITEM_SIZE );
                            $_length = Class_Base_Memory::write_share_memory ( $_block_id , $_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                            return $_length;
                        }
                    }
                }
            }
        }
        return true;
    }

    public static function clear ( $key = Interface_Base_Block_Keys::KEY )
    {
        $_key   = intval ( $key );
        $_size  = Interface_Base_Block_Keys::SIZE_BLOCK;
        $_shmid = self::open_share_memory ( $_key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $_size , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( ! empty( $_shmid ) ) {
            $_block_type = self::read_share_memory ( $_shmid , Class_Base_BlockHead::get_head_block_type_offset () , Class_Base_BlockHead::get_head_block_type_size () );
            if ( $_block_type == Interface_Base_BlockType::TYPE_BLOCK_KEYS ) {
                for ( $index = 0 ; $index < Interface_Base_Block_Keys::MAP_SIZE ; $index += Interface_Base_Block_Keys::MAP_ITEM_SIZE ) {
                    $_item = Class_Base_Memory::read_share_memory ( $_shmid , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , Interface_Base_Block_Keys::MAP_ITEM_SIZE , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( ! Class_Base_Format::is_empty ( $_item ) ) {
                        try {
                            $_item_key  = Class_Base_Format::hex_to_dec ( substr ( $_item , 0 , Interface_Base_Block_Keys::SIZE_BLOCK_KEY ) );
                            $_item_size = Class_Base_Format::hex_to_dec ( substr ( $_item , Interface_Base_Block_Keys::SIZE_BLOCK_KEY , Interface_Base_Block_Keys::SIZE_BLOCK_SIZE ) );
                            if ( ( ! Class_Base_Format::is_empty ( $_item_key ) ) && ( ! Class_Base_Format::is_empty ( $_item_size ) ) && ( $_item_key != $_key ) ) {
                                $_item_shmid = self::open_share_memory ( $_item_key , self::MODE_SHARE_MEMORY_READ_AND_WRITE , $_item_size , self::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
                                if ( ! empty( $_item_shmid ) ) {
                                    self::clear_share_memory ( $_item_shmid );
                                }
                            }
                        } catch ( \Exception $e ) {
                            Class_Base_Response::outputln ( $e );
                        }
                    }
                }
                self::clear_share_memory ( $_shmid );
            }
        }
    }
}