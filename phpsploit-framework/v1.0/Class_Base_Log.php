<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-17
 * Time: 下午2:02
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

class Class_Base_Log extends Class_Base
{
    const TYPE_ERROR     = 123456789010000001;
    const TYPE_EXCEPTION = 123456789020000001;
    const TYPE_SECURITY  = 123456789030000001;
    const TYPE_USER      = 123456789040000001;
    private static $_types = array (
        123456789010000001 => 'ERROR' ,
        123456789020000001 => 'EXCEPTION' ,
        123456789030000001 => 'SECURITY' ,
        123456789040000001 => 'USER' ,
    );

    public static function exist_type ( $type )
    {
        if ( Class_Base_Format::is_minlen_to_maxlen_integer ( $type , 18 , 18 ) ) {
            if ( ! is_integer ( $type ) ) {
                $type = intval ( $type );
            }
            if ( isset( self::$_types[ $type ] ) ) {
                return true;
            }
        }
        return false;
    }

    public static function add_content ( $type , $content , $title )
    {
        if ( ! self::exist_type ( $type ) ) {
            throw new \Exception( ( "type is error , type : " . print_r ( $type , true ) ) , 0 );
        }
        $_time        = time ();
        $_time_format = date ( 'Y-m-d H:i:s' , $_time );
        $_user        = ( posix_getuid () . ':' . posix_getgid () );
        $_array       = array ( 'type' => ( $type . ':' . self::$_types[ $type ] ) , 'time' => $_time , 'Y-m-d_H:i:s' => $_time_format , 'user' => $_user , 'title' => $title , 'content' => $content );
        $_json        = json_encode ( $_array );
        $_line        = "\n" . $_json . "\n";
        $_line_length = strlen ( $_line );
        $_shmid       = Class_Base_Memory::open_share_memory ( $type , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 );
        if ( empty( $_shmid ) ) {
            throw new \Exception( "share memory id is error" , 0 );
        }
        $_occupancy_size = Class_Base_Memory::size_share_memory ( $_shmid );
        $_remain_size    = ( Class_Base_Memory::BLOCK_SIZE_1048576 - $_occupancy_size );
        if ( $_remain_size < $_line_length ) {
            throw new \Exception( ( "reamin_size is error , reamin_size : " . print_r ( $_remain_size , true ) ) , 0 );
        }
        $_write_length = Class_Base_Memory::write_share_memory ( $_shmid , $_line , $_occupancy_size , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        if ( empty( $_write_length ) ) {
            throw new \Exception( "share memory write length is error" , 0 );
        }
        $_remain_size = ( $_remain_size - $_line_length );
        return $_remain_size;
    }

    public static function get_content ( $type )
    {
        if ( ! self::exist_type ( $type ) ) {
            throw new \Exception( ( "type is error , type : " . print_r ( $type , true ) ) , 0 );
        }
        $_shmid = Class_Base_Memory::open_share_memory ( $type , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( empty( $_shmid ) ) {
            throw new \Exception( "share memory id is error" , 0 );
        }
        $_read_data   = Class_Base_Memory::read_share_memory ( $_shmid , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        $_show_string = Class_Base_Format::data_to_string ( $_read_data );
        return $_show_string;
    }

    public static function get_json_array ( $type )
    {
        $_content = trim ( self::get_content ( $type ) , "\n" );
        $_array   = explode ( "\n\n" , $_content );
        return $_array;
    }

    public static function get_array ( $type )
    {
        $_json_array = get_json_array ( $type );
        $_array      = array ();
        foreach ( $_json_array as $index => $json ) {
            $_array[ $index ] = json_decode ( $json , true );
        }
        return $_array;
    }
}