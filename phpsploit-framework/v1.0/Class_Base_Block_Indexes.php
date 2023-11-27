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

class Class_Base_Block_Indexes extends Class_Base_Block implements Interface_Base_Block_Indexes
{
    private static $_indexes_keys = array ();
    private        $_head         = null;
    private        $_content      = null;
    private        $_end_flag     = null;

    public static function get_key ()
    {
        return Interface_Base_BlockKey::INDEXES;
    }

    public static function exist_indexes_key ( $key )
    {
        if ( ( in_array ( $key , self::$_indexes_keys ) ) ) {
            return true;
        }
        return false;
    }

    public static function add_indexes_key ( $key )
    {
        if ( ! self::exist_indexes_key ( $key ) ) {
            self::$_indexes_keys[] = $key;
        }
    }

    public static function clear_indexes_key ( $key )
    {
        if ( self::exist_indexes_key ( $key ) ) {
            foreach ( self::$_indexes_keys as $index => $indexes_key ) {
                if ( $indexes_key == $key ) {
                    self::$_indexes_keys[ $index ] = null;
                    unset( self::$_indexes_keys[ $index ] );
                }
            }
        }
    }

    public static function get_indexes_keys ()
    {
        return self::$_indexes_keys;
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
        return self::SIZE_MAP;
    }

    public static function exist_indexes_item_block_key ( $key , $indexes_item_block_key )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item_block_key = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY , self::TYPE_CONTENT_STRING );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                    $_indexes_item_block_key = Class_Base_Format::format_key_read ( $_indexes_item_block_key );
                    if ( $_indexes_item_block_key == $indexes_item_block_key ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function exist_indexes_item_block_name ( $key , $indexes_item_block_name )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item_block_name = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME , self::TYPE_CONTENT_STRING );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( $_indexes_item_block_name );
                    if ( $_indexes_item_block_name == $indexes_item_block_name ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function exist_indexes_item_by_block_key_and_block_name ( $key , $block_key , $block_name )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item            = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) );
                $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) );
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( $_indexes_item_block_key == $block_key ) ) {
                    return true;
                }
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( $_indexes_item_block_name == $block_name ) ) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function exist_indexes_item ( $key , $indexes_item )
    {
        if ( ( empty( $indexes_item ) ) || ( ! is_object ( $indexes_item ) ) || ( ! ( $indexes_item instanceof Class_Base_Block_IndexesItem ) ) ) {
            throw new \Exception( "indexes_item is not a IndexesItem object , indexes_item ( " . $indexes_item . " ) " , 0 );
        }
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item            = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) );
                $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) );
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( $_indexes_item_block_key == $indexes_item->get_block_key () ) ) {
                    return true;
                }
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( $_indexes_item_block_name == $indexes_item->get_block_name () ) ) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function write_indexes_item ( $key , $indexes_item )
    {
        if ( ( empty( $indexes_item ) ) || ( ! is_object ( $indexes_item ) ) || ( ! ( $indexes_item instanceof Class_Base_Block_IndexesItem ) ) ) {
            throw new \Exception( "indexes_item is not a IndexesItem object , indexes_item ( " . $indexes_item . " ) " , 0 );
        }
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            $_exist = self::exist_indexes_item ( $key , $indexes_item );
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( empty( $_exist ) ) {
                    if ( Class_Base_Format::is_empty ( $_indexes_item ) ) {
                        $_indexes_item = $indexes_item->get_block_string ();
                        $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_indexes_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                        return $_write_length;
                    }
                } else {
                    if ( ! Class_Base_Format::is_empty ( $_indexes_item ) ) {
                        $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_HEAD_BLOCK_NAME ) );
                        $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) );
                        if ( ( ( $indexes_item->get_block_key () == $_indexes_item_block_key ) && ( $indexes_item->get_block_name () != $_indexes_item_block_name ) ) || ( ( $indexes_item->get_block_key () != $_indexes_item_block_key ) && ( $indexes_item->get_block_name () == $_indexes_item_block_name ) ) ) {
                            throw new \Exception( "indexes item block_key or block_name is error , memory block_key ( " . $_indexes_item_block_key . " ) , memory block_name ( " . $_indexes_item_block_name . " ) , object block_key ( " . $indexes_item->get_block_key () . " ) , object block_name ( " . $indexes_item->get_block_name () . " ) " , 0 );
                        }
                        if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( ! Class_Base_Format::is_empty ( $indexes_item->get_block_key () ) ) && ( ! Class_Base_Format::is_empty ( $indexes_item->get_block_name () ) ) && ( $indexes_item->get_block_key () == $_indexes_item_block_key ) && ( $indexes_item->get_block_name () == $_indexes_item_block_name ) ) {
                            $_indexes_item = $indexes_item->get_block_string ();
                            $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_indexes_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                            return $_write_length;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function read_indexes_item ( $key , $indexes_item_block_key , $indexes_item_block_name )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            $_exist = self::exist_indexes_item_by_block_key_and_block_name ( $key , $indexes_item_block_key , $indexes_item_block_name );
            if ( ! $_exist ) {
                return null;
            }
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_HEAD_BLOCK_NAME ) );
                    $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) );
                    if ( ( $indexes_item_block_key == $_indexes_item_block_key ) && ( $indexes_item_block_name != $_indexes_item_block_name ) || ( $indexes_item_block_key != $_indexes_item_block_key ) && ( $indexes_item_block_name == $_indexes_item_block_name ) ) {
                        throw new \Exception( "indexes item block_key or block_name is error , memory block_key ( " . $_indexes_item_block_key . " ) , memory block_name ( " . $_indexes_item_block_name . " ) , object block_key ( " . $indexes_item_block_key . " ) , object block_name ( " . $indexes_item_block_name . " ) " , 0 );
                    }
                    if ( ( ! Class_Base_Format::is_empty ( $indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( ! Class_Base_Format::is_empty ( $indexes_item_block_name ) ) && ( $indexes_item_block_key == $_indexes_item_block_key ) && ( $indexes_item_block_name == $_indexes_item_block_name ) ) {
                        $_indexes_item    = Class_Base_Block_IndexesItem::indexes_item_string_to_indexes_item_object ( $_indexes_item );
                        $_item_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $_indexes_item->get_content_size () + Interface_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
                        $_item_block_id   = Class_Base_Memory::open_share_memory ( $_indexes_item->get_block_key () , $_indexes_item->get_block_mode () , $_item_block_size );
                        $_item_block_data = Class_Base_Memory::read_share_memory ( $_item_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD ) , self::get_content_size () , self::TYPE_CONTENT_STRING );
                        if ( $_indexes_item->get_content_type () == self::TYPE_CONTENT_INTEGER ) {
                            $_item_block_data = Class_Base_Format::hex_to_dec ( $_item_block_data );
                        } else {
                            $_item_block_data = Class_Base_Format::content_to_string ( $_item_block_data );
                        }
                        return $_item_block_data;
                    }
                }

            }
        }
        return null;
    }

    public static function write_indexes_item_content ( $key , $indexes_item , $indexes_item_content )
    {
        if ( ( empty( $indexes_item ) ) || ( ! is_object ( $indexes_item ) ) || ( ! ( $indexes_item instanceof Class_Base_Block_IndexesItem ) ) ) {
            throw new \Exception( "indexes_item is not a IndexesItem object , indexes_item ( " . $indexes_item . " ) " , 0 );
        }
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            $_exist = self::exist_indexes_item ( $key , $indexes_item );
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( empty( $_exist ) ) {
                    if ( Class_Base_Format::is_empty ( $_indexes_item ) ) {
                        $_indexes_item = $indexes_item->get_block_string ();
                        $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_indexes_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                        return $_write_length;
                    }
                } else {
                    if ( ! Class_Base_Format::is_empty ( $_indexes_item ) ) {
                        $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_HEAD_BLOCK_NAME ) );
                        $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) );
                        if ( ( ( $indexes_item->get_block_key () == $_indexes_item_block_key ) && ( $indexes_item->get_block_name () != $_indexes_item_block_name ) ) || ( ( $indexes_item->get_block_key () != $_indexes_item_block_key ) && ( $indexes_item->get_block_name () == $_indexes_item_block_name ) ) ) {
                            throw new \Exception( "indexes item block_key or block_name is error , memory block_key ( " . $_indexes_item_block_key . " ) , memory block_name ( " . $_indexes_item_block_name . " ) , object block_key ( " . $indexes_item->get_block_key () . " ) , object block_name ( " . $indexes_item->get_block_name () . " ) " , 0 );
                        }
                        if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( ! Class_Base_Format::is_empty ( $indexes_item->get_block_key () ) ) && ( ! Class_Base_Format::is_empty ( $indexes_item->get_block_name () ) ) && ( $indexes_item->get_block_key () == $_indexes_item_block_key ) && ( $indexes_item->get_block_name () == $_indexes_item_block_name ) ) {
                            if ( $indexes_item->get_content_type () == Interface_Base_BlockContentType::TYPE_CONTENT_INTEGER ) {
                                $indexes_item_content = Class_Base_Format::dec_to_hex ( $indexes_item_content );
                            } else {
                                $indexes_item_content = Class_Base_Format::string_to_content ( $indexes_item_content , $indexes_item->get_content_size () );
                            }
                            $_item_block_size = ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $indexes_item->get_content_size () + Interface_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG );
                            $_item_block_id   = Class_Base_Memory::open_share_memory ( $indexes_item->get_block_key () , $indexes_item->get_block_mode () , $_item_block_size );
                            if ( ! empty( $_item_block_id ) ) {
                                $_write_length = Class_Base_Memory::write_share_memory ( $_item_block_id , $indexes_item_content , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD ) , self::TYPE_CONTENT_STRING );
                                return $_write_length;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function read_indexes_item_content ( $key , $indexes_item_block_key , $indexes_item_block_name , $indexes_item_content )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            $_exist = self::exist_indexes_item_by_block_key_and_block_name ( $key , $indexes_item_block_key , $indexes_item_block_name );
            if ( ! $_exist ) {
                return null;
            }
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_HEAD_BLOCK_NAME ) );
                    $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) );
                    if ( ( $indexes_item_block_key == $_indexes_item_block_key ) && ( $indexes_item_block_name != $_indexes_item_block_name ) || ( $indexes_item_block_key != $_indexes_item_block_key ) && ( $indexes_item_block_name == $_indexes_item_block_name ) ) {
                        throw new \Exception( "indexes item block_key or block_name is error , memory block_key ( " . $_indexes_item_block_key . " ) , memory block_name ( " . $_indexes_item_block_name . " ) , object block_key ( " . $indexes_item_block_key . " ) , object block_name ( " . $indexes_item_block_name . " ) " , 0 );
                    }
                    if ( ( ! Class_Base_Format::is_empty ( $indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( ! Class_Base_Format::is_empty ( $indexes_item_block_name ) ) && ( $indexes_item_block_key == $_indexes_item_block_key ) && ( $indexes_item_block_name == $_indexes_item_block_name ) ) {
                        $_indexes_item = Class_Base_Block_IndexesItem::indexes_item_string_to_indexes_item_object ( $_indexes_item );
                        return $_indexes_item;
                    }
                }

            }
        }
        return null;
    }

    public static function clear_indexes_item ( $key , $indexes_item_block_key , $indexes_item_block_name , $exit = 0 )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item              = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name   = substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
                $_indexes_item_block_key    = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
                $_indexes_item_content_size = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE );
                $_indexes_item_block_type   = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE );
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) ) {
                    $_indexes_item_block_key  = Class_Base_Format::format_key_read ( $_indexes_item_block_key );
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( $_indexes_item_block_name );
                    if ( ( $_indexes_item_block_key == $indexes_item_block_key ) && ( $_indexes_item_block_name == $indexes_item_block_name ) ) {
                        $_indexes_item_block_type = Class_Base_Format::format_type_read ( $_indexes_item_block_type );
                        if ( $_indexes_item_block_type != self::TYPE_BLOCK_DATA ) {
                            throw new \Exception( "Cannot delete indexes_item , block_type is not equal to block_data , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        $_indexes_item_content_size = Class_Base_Format::format_size_read ( $_indexes_item_content_size );
                        $_bool                      = Class_Base_Memory::clear_share_memory_by_key ( $_indexes_item_block_key , $_indexes_item_content_size );
                        if ( empty( $_bool ) ) {
                            throw new \Exception( "delete indexes_item is error , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        $_indexes_item = Class_Base_Format::string_to_data ( null , self::SIZE_MAP_ITEM );
                        $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_indexes_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                        if ( empty( $_write_length ) ) {
                            throw new \Exception( "delete indexes_item is error , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        if ( ! empty( $exit ) ) {
                            return;
                        }
                    }
                }
            }
        }
    }

    public static function clear_indexes_item_by_block_key ( $key , $indexes_item_block_key , $exit = 0 )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item              = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name   = substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
                $_indexes_item_block_key    = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
                $_indexes_item_content_size = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE );
                $_indexes_item_block_type   = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                    $_indexes_item_block_key = Class_Base_Format::format_key_read ( $_indexes_item_block_key );
                    if ( $_indexes_item_block_key == $indexes_item_block_key ) {
                        $_indexes_item_block_type = Class_Base_Format::format_type_read ( $_indexes_item_block_type );
                        if ( $_indexes_item_block_type != self::TYPE_BLOCK_DATA ) {
                            throw new \Exception( "Cannot delete indexes_item , block_type is not equal to block_data , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        $_indexes_item_content_size = Class_Base_Format::format_size_read ( $_indexes_item_content_size );
                        $_bool                      = Class_Base_Memory::clear_share_memory_by_key ( $_indexes_item_block_key , $_indexes_item_content_size );
                        if ( empty( $_bool ) ) {
                            throw new \Exception( "delete indexes_item is error , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        $_indexes_item = Class_Base_Format::string_to_data ( null , self::SIZE_MAP_ITEM );
                        $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_indexes_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                        if ( empty( $_write_length ) ) {
                            throw new \Exception( "delete indexes_item is error , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        if ( ! empty( $exit ) ) {
                            return;
                        }
                    }
                }
            }
        }
    }

    public static function clear_indexes_item_by_block_name ( $key , $indexes_item_block_name , $exit = 0 )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item              = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name   = substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
                $_indexes_item_block_key    = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
                $_indexes_item_content_size = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE );
                $_indexes_item_block_type   = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE );
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( $_indexes_item_block_name );
                    if ( $_indexes_item_block_name == $indexes_item_block_name ) {
                        $_indexes_item_block_type = Class_Base_Format::format_type_read ( $_indexes_item_block_type );
                        if ( $_indexes_item_block_type != self::TYPE_BLOCK_DATA ) {
                            throw new \Exception( "Cannot delete indexes_item , block_type is not equal to block_data , block_key ( " . $_indexes_item_block_name . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        $_indexes_item_content_size = Class_Base_Format::format_size_read ( $_indexes_item_content_size );
                        $_bool                      = Class_Base_Memory::clear_share_memory_by_key ( $_indexes_item_block_key , $_indexes_item_content_size );
                        if ( empty( $_bool ) ) {
                            throw new \Exception( "delete indexes_item is error , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        $_indexes_item = Class_Base_Format::string_to_data ( null , self::SIZE_MAP_ITEM );
                        $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_indexes_item , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                        if ( empty( $_write_length ) ) {
                            throw new \Exception( "delete indexes_item is error , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) , content_size ( " . $_indexes_item_content_size . " ) , block_type ( " . $_indexes_item_block_type . " ) " , 0 );
                        }
                        if ( ! empty( $exit ) ) {
                            return;
                        }
                    }
                }
            }
        }
    }

    public static function check_indexes_item_block_key_and_block_name ( $memory_block_key , $object_block_key , $memory_block_name , $object_block_name )
    {
        if ( ( ( $object_block_key == $memory_block_key ) && ( $object_block_name != $memory_block_name ) ) || ( ( $object_block_key != $memory_block_key ) && ( $object_block_name == $memory_block_name ) ) ) {
            throw new \Exception( "indexes item block_key or block_name is error , memory block_key ( " . $memory_block_key . " ) , memory block_name ( " . $memory_block_name . " ) , object block_key ( " . $object_block_key . " ) , object block_name ( " . $object_block_name . " ) " , 0 );
        }
    }

    public static function get_indexes_item_block_key_count ( $key , $indexes_item_block_key )
    {
        $_count    = 0;
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item_block_key = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY , self::TYPE_CONTENT_STRING );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                    $_indexes_item_block_key = Class_Base_Format::format_key_read ( $_indexes_item_block_key );
                    if ( $_indexes_item_block_key == $indexes_item_block_key ) {
                        $_count++;
                    }
                }
            }
        }
        return $_count;
    }

    public static function get_indexes_item_block_name_count ( $key , $indexes_item_block_name )
    {
        $_count    = 0;
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item_block_name = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME , self::TYPE_CONTENT_STRING );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( $_indexes_item_block_name );
                    if ( $_indexes_item_block_name == $indexes_item_block_name ) {
                        $_count++;
                    }
                }
            }
        }
        return $_count;
    }


    public static function check_indexes_item_block_name_is_empty_by_block_key ( $key , $indexes_item_block_key )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item            = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name = substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
                $_indexes_item_block_key  = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                    $_indexes_item_block_key = Class_Base_Format::format_key_read ( $_indexes_item_block_key );
                    if ( $_indexes_item_block_key == $indexes_item_block_key ) {
                        if ( Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function check_indexes_item_block_key_is_empty_by_block_name ( $key , $indexes_item_block_name )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item            = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name = substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
                $_indexes_item_block_key  = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
                if ( ! Class_Base_Format::is_empty ( $indexes_item_block_name ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( $_indexes_item_block_name );
                    if ( $_indexes_item_block_name == $indexes_item_block_name ) {
                        if ( Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function check_indexes ( $key )
    {
        $_block_key_list  = array ();
        $_block_name_list = array ();
        $_block_id        = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item            = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name = substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
                $_indexes_item_block_key  = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) ) {
                    throw new \Exception( "indexes item block_name is empty , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) " , 0 );
                }
                if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) ) {
                    throw new \Exception( "indexes item block_key is empty , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) " , 0 );
                }
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                    $_indexes_item_block_key = Class_Base_Format::format_key_read ( $_indexes_item_block_key );
                    if ( ! in_array ( $_indexes_item_block_key , $_block_key_list ) ) {
                        $_block_key_list[] = $_indexes_item_block_key;
                    } else {
                        throw new \Exception( "The same number of indexes_item_block_key is greater than one , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) " , 0 );
                    }
                }
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( $_indexes_item_block_name );
                    if ( ! in_array ( $_indexes_item_block_name , $_block_name_list ) ) {
                        $_block_name_list[] = $_indexes_item_block_name;
                    } else {
                        throw new \Exception( "The same number of indexes_item_block_name is greater than one , block_key ( " . $_indexes_item_block_key . " ) , block_name ( " . $_indexes_item_block_name . " ) " , 0 );
                    }
                }
            }
        }
    }

    public static function check_indexes_for_clear ( $key )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item ) ) {
                    $_indexes_item_block_name   = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) );
                    $_indexes_item_block_key    = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) );
                    $_indexes_item_content_size = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE ) );
                    $_indexes_item_block_mode   = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE ) );
                    $_indexes_item_block_type   = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE ) );
                    $_indexes_item_content_type = Class_Base_Format::format_name_read ( substr ( $_indexes_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE ) , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_TYPE ) );
                    throw new \Exception( "There is sub-data under indexes, so the current indexes cannot be cleared, indexes key( " . $key . " ) , indexes_item_block_key ( " . $_indexes_item_block_key . " ) , indexes_item_block_name ( " . $_indexes_item_block_name . " ) , indexes_item_content_size ( " . $_indexes_item_content_size . " ) , indexes_item_block_mode ( " . $_indexes_item_block_mode . " ) , indexes_item_block_type ( " . $_indexes_item_block_type . " ) , indexes_item_content_type ( " . $_indexes_item_content_type . " ) " , 0 );
                }
            }
        }
        return true;
    }

    public static function check_indexes_by_block_key_and_block_name ( $key , $indexes_item_block_key , $indexes_item_block_name )
    {
        $_block_key_count  = 0;
        $_block_name_count = 0;
        $_block_id         = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item            = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                $_indexes_item_block_name = substr ( $_indexes_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
                $_indexes_item_block_key  = substr ( $_indexes_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                    $_indexes_item_block_key = Class_Base_Format::format_key_read ( $_indexes_item_block_key );
                    if ( $_indexes_item_block_key == $indexes_item_block_key ) {
                        $_block_key_count++;
                        if ( Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) {
                            return false;
                        }
                    }
                }
                if ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( $_indexes_item_block_name );
                    if ( $_indexes_item_block_name == $indexes_item_block_name ) {
                        $_block_name_count++;
                        if ( Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) {
                            return false;
                        }
                    }
                }
            }
        }
        if ( $_block_key_count > 1 ) {
            return false;
        }
        if ( $_block_name_count > 1 ) {
            return false;
        }
        return true;
    }

    public static function get_end_flag_size ()
    {
        return Class_Base_BlockEndFlag::get_end_flag_size ();
    }

    public static function is_empty ( $data )
    {
        $_ret = Class_Base_Format::is_empty ( $data );
        return $_ret;
    }

    public static function get_block ( $key )
    {
        $_block_id = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::SIZE_BLOCK );
        if ( ! empty( $_block_id ) ) {
            self::add_indexes_key ( $key );
        }
        return $_block_id;
    }

    public static function read_block_string ( $key )
    {

        $_block_id = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_block_string = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , self::SIZE_BLOCK , self::TYPE_CONTENT_STRING );
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

    public static function create_block_object ( $head , $content , $end_flag )
    {
        $_block_keys = new Class_Base_Block_Indexes( $head , $content , $end_flag );
        return $_block_keys;
    }

    public static function init_block_data ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag , $content , $end_flag )
    {
        $_head          = self::create_head ( $block_name , $block_key , $content_size , $block_status , $block_mode , $block_type , $content_type , $reserved , $head_end_flag );
        $_content       = self::create_content ( $content );
        $_end_flag      = self::create_end_flag ( $end_flag );
        $_block_indexes = self::create_block_object ( $_head , $_content , $_end_flag );
        $_block_string  = $_block_indexes->create_block_string ();
        $_block_id      = Class_Base_Memory::open_share_memory ( $key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , self::get_block_size () );
        $_length        = Class_Base_Memory::write_share_memory ( $_block_id , $_block_string , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , self::TYPE_CONTENT_STRING );
        return $_length;
    }

    public static function read_head ( $key )
    {

        $_block_id = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_head = Class_Base_Memory::read_share_memory ( $_block_id , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_BlockHead::SIZE_BLOCK_HEAD , self::TYPE_CONTENT_STRING );
        return $_head;
    }

    public static function read_content ( $key )
    {

        $_block_id = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_data = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD ) , self::SIZE_MAP , self::TYPE_CONTENT_STRING );
        return $_data;
    }

    public static function read_end_flag ( $key )
    {

        $_block_id = self::get_block ( $key );
        if ( self::is_empty ( $_block_id ) ) {
            return null;
        }
        $_end_flag = Class_Base_Memory::read_share_memory ( $_block_id , ( self::SIZE_BLOCK - Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG ) , Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG , self::TYPE_CONTENT_STRING );
        return $_end_flag;
    }

    public static function check_indexes_item_object ( $indexes_item )
    {
        if ( ( empty( $indexes_item ) ) || ( ! is_object ( $indexes_item ) ) || ( ! ( $indexes_item instanceof Class_Base_Block_IndexesItem ) ) ) {
            throw new \Exception( "indexes item is error" , 0 );
        }
    }

    public static function check_indexes_item_string ( $indexes_item )
    {
        if ( ( ! is_string ( $indexes_item ) ) || ( strlen ( $indexes_item ) != self::SIZE_BLOCK_INDEXES_ITEM ) ) {
            throw new \Exception( "indexes item is error" , 0 );
        }
    }

    public static function indexes_item_object_to_indexes_item_string ( $indexes_item )
    {
        if ( ( empty( $indexes_item ) ) || ( ! is_object ( $indexes_item ) ) || ( ! ( $indexes_item instanceof Class_Base_Block_IndexesItem ) ) ) {
            throw new \Exception( "indexes item is error" , 0 );
        }
        self::check_indexes_item_object ( $indexes_item );
        $_item_block_name   = Class_Base_Format::format_name_write ( $indexes_item->get_block_name () , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME );
        $_item_block_key    = Class_Base_Format::format_name_write ( $indexes_item->get_block_key () , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY );
        $_item_content_size = Class_Base_Format::format_name_write ( $indexes_item->get_content_size () , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE );
        $_item_block_status = Class_Base_Format::format_name_write ( $indexes_item->get_block_status () , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS );
        $_item_block_mode   = Class_Base_Format::format_name_write ( $indexes_item->get_block_mode () , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE );
        $_item_block_type   = Class_Base_Format::format_name_write ( $indexes_item->get_block_type () , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE );
        $_item_content_type = Class_Base_Format::format_name_write ( $indexes_item->get_content_type () , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_TYPE );
        $_item_reserved     = Class_Base_Format::format_name_write ( $indexes_item->get_reserved () , self::SIZE_BLOCK_INDEXES_ITEM_RESERVED );
        $_item_end_flag     = Class_Base_Format::format_name_write ( $indexes_item->get_item_end_flag () , self::SIZE_BLOCK_INDEXES_ITEM_END_FLAG );
        $_item              = ( $_item_block_name . $_item_block_key . $_item_content_size . $_item_block_status . $_item_block_mode . $_item_block_type . $_item_content_type . $_item_reserved . $_item_end_flag );
        self::check_indexes_item_string ( $_item );
        return $_item;
    }

    public static function indexes_item_string_to_indexes_item_object ( $indexes_item )
    {
        if ( ( ! is_string ( $indexes_item ) ) || ( strlen ( $indexes_item ) != self::SIZE_BLOCK_INDEXES_ITEM ) ) {
            throw new \Exception( "indexes item is error" , 0 );
        }
        self::check_indexes_item_string ( $indexes_item );
        $_item_block_name   = Class_Base_Format::format_name_read ( substr ( $_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) );
        $_item_block_key    = Class_Base_Format::format_key_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) );
        $_item_content_size = Class_Base_Format::format_size_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE ) );
        $_item_block_status = Class_Base_Format::format_status_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS ) );
        $_item_block_mode   = Class_Base_Format::format_mode_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE ) );
        $_item_block_type   = Class_Base_Format::format_type_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE ) );
        $_item_content_type = Class_Base_Format::format_type_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE ) , self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_TYPE ) );
        $_item_reserved     = Class_Base_Format::format_reserved_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_TYPE ) , self::SIZE_BLOCK_INDEXES_ITEM_RESERVED ) );
        $_item_end_flag     = Class_Base_Format::format_end_flag_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_SIZE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_STATUS + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_MODE + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_TYPE + self::SIZE_BLOCK_INDEXES_ITEM_CONTENT_TYPE + self::SIZE_BLOCK_INDEXES_ITEM_RESERVED ) , self::SIZE_BLOCK_INDEXES_ITEM_END_FLAG ) );
        $_indexes_item      = new Class_Base_Block_IndexesItem( $_item_block_name , $_item_block_key , $_item_content_size , $_item_block_status , $_item_block_mode , $_item_block_type , $_item_content_type , $_item_reserved , $_item_end_flag );
        self::check_indexes_item_object ( $indexes_item );
        return $_indexes_item;
    }


    public static function get_indexes_item ( $key , $item_key )
    {
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item_key = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! self::is_empty ( $_indexes_item_key ) ) {
                    $_item_key = Class_Base_Format::hex_to_dec ( substr ( $_indexes_item_key , ( self::OFFSET_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) );
                    if ( $_item_key == $item_key ) {
                        $_indexes_item = self::indexes_item_string_to_indexes_item_object ( $_indexes_item_key );
                        return $_indexes_item;
                    }
                }
            }
        }
        return null;
    }

    public static function set_indexes_item ( $key , $indexes_item )
    {
        if ( ( empty( $indexes_item ) ) || ( ! is_object ( $indexes_item ) ) || ( ! ( $indexes_item instanceof Class_Base_Block_IndexesItem ) ) ) {
            throw new \Exception( "indexes item is error" , 0 );
        }
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_indexes_item_key = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! self::is_empty ( $_indexes_item_key ) ) {
                    $_indexes_item_key = Class_Base_Format::hex_to_dec ( $_indexes_item_key );
                    if ( $_indexes_item_key == $indexes_item->get_block_key () ) {
                        $_indexes_item = self::indexes_item_object_to_indexes_item_string ( $indexes_item );
                        $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $_indexes_item , ( self::OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                        return $_write_length;
                    }
                }
            }
        }
        return false;
    }

    public static function add_indexes_item ( $key , $indexes_item )
    {
        if ( ! self::exist_indexes_item ( $key , $indexes_item ) ) {
            $indexes_item = self::indexes_item_object_to_indexes_item_string ( $indexes_item );
            $_block_id    = self::get_block ( $key );
            if ( ! self::is_empty ( $_block_id ) ) {
                for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                    $_indexes_item = Class_Base_Memory::read_share_memory ( $_block_id , ( self::OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                    if ( Class_Base_Format::is_empty ( $_indexes_item ) ) {
                        $_write_length = Class_Base_Memory::write_share_memory ( $_block_id , $indexes_item , ( self::OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::TYPE_CONTENT_STRING );
                        return $_write_length;
                    }
                }
            }
        }
        return false;
    }

    public static function exist_map_item ( $key , $item_key )
    {
        $_item_key = explode ( ":" , $item_key );
        if ( count ( $_item_key ) < 2 ) {
            throw new \Exception( "item key is error" , 0 );
        }
        $_block_key  = $_item_key[ 0 ];
        $_block_name = $_item_key[ 1 ];
        $_block_id   = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! self::is_empty ( $_item ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_HEAD_BLOCK_NAME ) );
                    $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) );
                    if ( ( ! Class_Base_Format::is_empty ( $_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_block_name ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) && ( $_indexes_item_block_key == $_block_key ) && ( $_indexes_item_block_name == $_block_name ) ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function get_map_count ( $key )
    {
        $_count    = 0;
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! self::is_empty ( $_item ) ) {
                    $_indexes_item_block_name = Class_Base_Format::format_name_read ( substr ( $_item , ( self::OFFSET_START ) , self::SIZE_BLOCK_HEAD_BLOCK_NAME ) );
                    $_indexes_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) );
                    if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) && ( ! Class_Base_Format::is_empty ( $_indexes_item_block_name ) ) ) {
                        $_count++;
                    }
                }
            }
        }
        return $_count;
    }

    public static function get_map_count_for_clear ( $key )
    {
        $_count    = 0;
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! self::is_empty ( $_item ) ) {
                    $_indexes_item_block_key = Class_Base_Format::format_key_read ( substr ( $_item , ( self::OFFSET_START + self::SIZE_BLOCK_HEAD_BLOCK_NAME ) , self::SIZE_BLOCK_HEAD_BLOCK_KEY ) );
                    if ( ( ! Class_Base_Format::is_empty ( $_indexes_item_block_key ) ) ) {
                        $_count++;
                    }
                }
            }
        }
        return $_count;
    }

    public static function read_map_item ( $key , $item_key )
    {
        $_map_item_key = explode ( ":" , $item_key );
        if ( count ( $_map_item_key ) < 2 ) {
            throw new \Exception( "map item key is error" , 0 );
        }
        $_block_key  = $_map_item_key[ 0 ];
        $_block_name = $_map_item_key[ 1 ];
        $_item       = self::read_indexes_item ( $key , $_block_key , $_block_name );
        return $_item;
    }

    public static function write_map_item ( $key , $item )
    {
        $_write_length = self::write_indexes_item ( $key , $item );
        return $_write_length;
    }

    public static function get_map_item ( $key , $item_key )
    {
        $_length = self::read_map_item ( $key , $item_key );
        return $_length;
    }

    public static function set_map_item ( $key , $item )
    {
        $_length = self::write_map_item ( $key , $item );
        return $_length;
    }

    public static function set_map ( $key , $map )
    {
        $_write_result = array ();
        if ( is_array ( $map ) ) {
            foreach ( $map as $k => $item ) {
                if ( ( empty( $item ) ) || ( ! is_object ( $item ) ) || ( ! ( $item instanceof Interface_Base_Block_IndexesItem ) ) ) {
                    throw new \Exception( "map item is not a indexes item object , map item ( " . print_r ( $item , true ) . " ) " , 0 );
                }
                $_length = self::write_map_item ( $key , $item );
                if ( self::is_empty ( $_length ) ) {
                    $_write_result[ $k ] = 0;
                } else {
                    $_write_result[ $k ] = 1;
                }

            }
        }
        return $_write_result;
    }

    public static function get_map ( $key )
    {
        $_map      = array ();
        $_block_id = self::get_block ( $key );
        if ( ! self::is_empty ( $_block_id ) ) {
            for ( $index = 0 ; $index < self::SIZE_MAP ; $index += self::SIZE_MAP_ITEM ) {
                $_item = Class_Base_Memory::read_share_memory ( $_block_id , ( Class_Base_BlockHead::SIZE_BLOCK_HEAD + $index ) , self::SIZE_MAP_ITEM , self::TYPE_CONTENT_STRING );
                if ( ! self::is_empty ( $_item ) ) {
                    $_item_block_name = Class_Base_Format::format_key_read ( substr ( $_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) );
                    $_item_block_key  = Class_Base_Format::format_key_read ( substr ( $_item , ( self::OFFSET_BLOCK_INDEXES_ITEM_START + self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_NAME ) , self::SIZE_BLOCK_INDEXES_ITEM_BLOCK_KEY ) );
                    if ( ( ! self::is_empty ( $_item_block_key ) ) && ( ! self::is_empty ( $_item_block_name ) ) ) {
                        $_item_key          = ( $_item_block_key . $_item_block_name );
                        $_map[ $_item_key ] = self::indexes_item_string_to_indexes_item_object ( $_item );
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
            if ( $_block_type == Interface_Base_BlockType::TYPE_BLOCK_INDEXES ) {
                if ( self::get_map_count_for_clear ( $key ) < 1 ) {
                    $_bool = Class_Base_Memory::clear_share_memory_by_key ( $key , self::SIZE_BLOCK );
                    if ( ! empty( $_bool ) ) {
                        self::clear_indexes_key ( $key );
                    }
                    return $_bool;
                }
            }
        }
        return false;
    }

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
            if ( ( strlen ( $head->get_block_string () ) != Class_Base_BlockHead::SIZE_BLOCK_HEAD ) || ( $content->get_content_size () != $head->get_content_size () ) || ( strlen ( $end_flag->get_block_string () ) != Class_Base_BlockEndFlag::SIZE_BLOCK_END_FLAG ) ) {
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