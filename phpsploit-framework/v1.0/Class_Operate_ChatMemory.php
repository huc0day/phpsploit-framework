<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-17
 * Time: 上午9:58
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

class Class_Operate_ChatMemory extends Class_Operate
{
    const SHARE_MEMORY_KEY = 111111111188888888;

    public static function get_client_sockets ( $share_memory_key = self::SHARE_MEMORY_KEY )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! isset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ] ) ) || ( ! is_array ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ] ) ) ) {
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ] = array ();
        }
        $_client_sockets = $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ];
        self::init_client_sockets ( $share_memory_key );
        $_share_memory_id = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
        for ( $index = 0 ; $index < Class_Base_Memory::BLOCK_SIZE_1048576 ; $index += 8 ) {
            $_client_socket[ $index ] = $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $index ] = Class_Base_Memory::read_share_memory ( $_share_memory_id , $index , 8 , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
        }
        return $_client_sockets;
    }

    public static function init_client_sockets ( $share_memory_key = self::SHARE_MEMORY_KEY )
    {
        $_share_memory_id = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_CREATE );
        if ( ! empty( $_share_memory_id ) ) {
            for ( $index = 0 ; $index < Class_Base_Memory::BLOCK_SIZE_1048576 ; $index += 8 ) {
                Class_Base_Memory::write_share_memory ( $_share_memory_id , 0 , $index , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
                $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $index ] = null;
            }
            @shmop_close ( $_share_memory_id );
        }
    }

    public static function get_client_socket ( $share_memory_key , $share_memory_index )
    {
        if ( ( $share_memory_index >= 0 ) && ( $share_memory_index <= ( Class_Base_Memory::BLOCK_SIZE_1048576 - 8 ) ) ) {
            $_share_memory_id               = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
            $_share_memory_block_read_value = $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $share_memory_index ] = Class_Base_Memory::read_share_memory ( $_share_memory_id , $share_memory_index , 8 , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
            return $_share_memory_block_read_value;
        }
        return false;
    }

    public static function set_client_socket ( $share_memory_key , $share_memory_index , $share_memory_value )
    {
        if ( ( $share_memory_index >= 0 ) && ( $share_memory_index <= ( Class_Base_Memory::BLOCK_SIZE_1048576 - 8 ) ) ) {
            $_share_memory_id                                                               = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
            $_share_memory_block_write_length                                               = Class_Base_Memory::write_share_memory ( $_share_memory_id , $share_memory_value , $share_memory_index , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $share_memory_index ] = $share_memory_value;
            return $_share_memory_block_write_length;
        }
        return false;
    }

    public static function exist_client_socket ( $share_memory_key , $share_memory_value )
    {
        $_share_memory_id = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( ! empty( $_share_memory_id ) ) {
            for ( $index = 0 ; $index < Class_Base_Memory::BLOCK_SIZE_1048576 ; $index += 8 ) {
                $_client_socket = Class_Base_Memory::read_share_memory ( $_share_memory_id , $index , 8 , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
                if ( $_client_socket == $share_memory_value ) {
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $index ] = $share_memory_value;
                    return true;
                }
            }
        }
        return false;
    }

    public static function write_client_socket ( $share_memory_key , $share_memory_value )
    {
        $_share_memory_id = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
        if ( ! empty( $_share_memory_id ) ) {
            for ( $index = 0 ; $index < Class_Base_Memory::BLOCK_SIZE_1048576 ; $index += 8 ) {
                $_client_socket = Class_Base_Memory::read_share_memory ( $_share_memory_id , $index , 8 , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
                if ( $_client_socket == 0 ) {
                    $_share_memory_block_write_length = Class_Base_Memory::write_share_memory ( $_share_memory_id , $share_memory_value , $index , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
                    if ( ! empty( $_share_memory_block_write_length ) ) {
                        $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $index ] = $share_memory_value;
                        return $index;
                    }
                }
            }
        }
        return false;
    }

    public static function delete_client_socket ( $share_memory_key , $share_memory_index )
    {
        if ( ( $share_memory_index >= 0 ) && ( $share_memory_index <= ( Class_Base_Memory::BLOCK_SIZE_1048576 - 8 ) ) ) {
            $_share_memory_id                                                               = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
            $_share_memory_block_write_length                                               = Class_Base_Memory::write_share_memory ( $_share_memory_id , 0 , $share_memory_index , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $share_memory_index ] = null;
            unset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $share_memory_index ] );
            return $_share_memory_block_write_length;
        }
        return false;
    }

    public static function clear_client_sockets ( $share_memory_key )
    {
        $_share_memory_id = Class_Base_Memory::open_share_memory ( $share_memory_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_1048576 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
        for ( $index = 0 ; $index < Class_Base_Memory::BLOCK_SIZE_1048576 ; $index += 8 ) {
            Class_Base_Memory::write_share_memory ( $_share_memory_id , 0 , $index , Class_Base_Memory::DATA_FORMAT_TYPE_64_INTEGER_PACK );
            $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $index ] = null;
            unset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ][ $index ] );
        }
        Class_Base_Memory::clear_share_memory ( $_share_memory_id );
        $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ] = null;
        unset( $_SESSION[ "PHPSPLOIT_FRAMEWORK_CLIENT_SOCKETS_MEMORY" ] );
    }
}