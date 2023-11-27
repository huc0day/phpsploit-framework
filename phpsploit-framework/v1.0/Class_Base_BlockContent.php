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

class Class_Base_BlockContent extends Class_Base implements Interface_Base_BlockContent
{
    private $_content = null;

    public static function get_content_offset ()
    {
        $_offset = ( Class_Base_Memory::SHARE_MEMORY_OFFSET_START + Class_Base_BlockHead::SIZE_BLOCK_HEAD_BLOCK_NAME + Class_Base_BlockHead::SIZE_BLOCK_HEAD_BLOCK_KEY + Class_Base_BlockHead::SIZE_BLOCK_HEAD_CONTENT_SIZE + Class_Base_BlockHead::SIZE_BLOCK_HEAD_BLOCK_STATUS + Class_Base_BlockHead::SIZE_BLOCK_HEAD_BLOCK_MODE + Class_Base_BlockHead::SIZE_BLOCK_HEAD_BLOCK_TYPE + Class_Base_BlockHead::SIZE_BLOCK_HEAD_CONTENT_TYPE + Class_Base_BlockHead::SIZE_BLOCK_HEAD_RESERVED + Class_Base_BlockHead::SIZE_BLOCK_HEAD_END_FLAG );
        return $_offset;
    }

    public static function is_block_content ( $block )
    {
        if ( ( empty( $block ) ) || ( ! is_object ( $block ) ) || ( ! ( $block instanceof Class_Base_BlockContent ) ) ) {
            return false;
        }
        return true;
    }

    public static function check_block_content ( $block )
    {
        if ( ! property_exists ( $block , "content" ) ) {
            return false;
        }
        if ( ( is_null ( $block->_content ) ) || ( ! is_string ( $block->_content ) ) ) {
            return false;
        }
        return true;
    }

    public static function create_block_content ( $content , $size )
    {
        $_block_content = new Class_Base_BlockContent( $content , $size );
        return $_block_content;
    }

    public function __construct ( $content , $size )
    {
        if ( is_integer ( $content ) ) {
            $content = strval ( $content );
        }
        if ( ( ! is_null ( $content ) ) && ( ! is_string ( $content ) ) ) {
            throw new \Exception( "content is not null and is not a string" , 0 );
        }
        if ( is_null ( $content ) || ( strlen ( $content ) <= 0 ) ) {
            $content = str_repeat ( "\0" , $size );
        }
        if ( strlen ( $content ) > $size ) {
            $content = substr ( $content , 0 , $size );
        }
        if ( strlen ( $content ) < $size ) {
            $content = str_pad ( $content , $size , "\0" , STR_PAD_RIGHT );
        }
        $this->_content = $content;
    }

    public function __destruct ()
    {
        $this->_content = null;
    }

    public function get_content ()
    {
        $_content = Class_Base_Format::data_to_string ( $this->_content );
        return $_content;
    }

    public function get_content_size ()
    {
        $_content        = self::get_content ();
        $_content_length = strlen ( $_content );
        return $_content_length;
    }

    public function get_encode_content ()
    {
        $_content = $this->_content;
        return $_content;
    }

    public function get_encode_content_size ()
    {
        $_block_content_length = strlen ( $this->_content );
        return $_block_content_length;
    }

    public function get_block_string ()
    {
        $_block_string = ( $this->_content );
        return $_block_string;
    }

    public function get_block_string_size ()
    {
        $_block_string        = self::get_block_string ();
        $_block_string_length = strlen ( $_block_string );
        return $_block_string_length;
    }
}