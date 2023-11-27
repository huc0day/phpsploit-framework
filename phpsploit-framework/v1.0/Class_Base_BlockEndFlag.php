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

class Class_Base_BlockEndFlag extends Class_Base implements Interface_Base_BlockEndFlag
{
    private $_end_flag = self::FLAG_BLOCK_END;

    public static function is_block_end_flag ( $block )
    {
        if ( ( empty( $block ) ) || ( ! is_object ( $block ) ) || ( ! ( $block instanceof Class_Base_BlockEndFlag ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_end_flag ( $block )
    {
        if ( ! property_exists ( $block , "end_flag" ) ) {
            return false;
        }
        if ( ( is_null ( $block->end_flag ) ) || ( ! is_string ( $block->end_flag ) ) ) {
            return false;
        }
        return true;
    }

    public static function create_block_end_flag ( $end_flag )
    {
        $_block_end_flag = new Class_Base_BlockEndFlag( $end_flag );
        return $_block_end_flag;
    }

    public static function get_end_flag_size ()
    {
        $_size = self::SIZE_BLOCK_END_FLAG;
        return $_size;
    }

    public function __construct ( $end_flag = self::FLAG_BLOCK_END )
    {
        if ( ! is_string ( $end_flag ) ) {
            throw new \Exception( "end_flag is not a string" , 0 );
        }
        if ( strlen ( $end_flag ) != 8 ) {
            throw new \Exception( "end_flag length is not 8" , 0 );
        }
        $this->_end_flag = $end_flag;
    }

    public function __destruct ()
    {
        $this->_end_flag = null;
    }

    public function get_end_flag ()
    {
        $_end_flag = $this->_end_flag;
        return $_end_flag;
    }

    public function get_block_string ()
    {
        $_block_string = ( $this->_end_flag );
        return $_block_string;
    }

    public function get_block_string_size ()
    {
        $_block_string        = self::get_block_string ();
        $_block_string_length = strlen ( $_block_string );
        return $_block_string_length;
    }
}