<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-7
 * Time: 下午1:19
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

class Class_Controller_Memory extends Class_Controller
{
    private static $_sizes = array (
        Class_Base_Memory::BLOCK_SIZE_8 ,
        Class_Base_Memory::BLOCK_SIZE_16 ,
        Class_Base_Memory::BLOCK_SIZE_32 ,
        Class_Base_Memory::BLOCK_SIZE_64 ,
        Class_Base_Memory::BLOCK_SIZE_128 ,
        Class_Base_Memory::BLOCK_SIZE_256 ,
        Class_Base_Memory::BLOCK_SIZE_512 ,
        Class_Base_Memory::BLOCK_SIZE_1024 ,
        Class_Base_Memory::BLOCK_SIZE_2048 ,
        Class_Base_Memory::BLOCK_SIZE_4096 ,
        Class_Base_Memory::BLOCK_SIZE_8192 ,
        Class_Base_Memory::BLOCK_SIZE_65536 ,
        Class_Base_Memory::BLOCK_SIZE_131072 ,
        Class_Base_Memory::BLOCK_SIZE_262144 ,
        Class_Base_Memory::BLOCK_SIZE_524288 ,
        Class_Base_Memory::BLOCK_SIZE_1048576 ,
    );

    private static $_block_web_keys = array (
        Interface_Base_BlockKey::WEB_AUTH ,
        Interface_Base_BlockKey::WEB_KEYS ,
        Interface_Base_BlockKey::WEB_INDEXES ,
        Interface_Base_BlockKey::WEB_UNIQUE_INDEX ,
        Interface_Base_BlockKey::WEB_RESERVED ,
        Interface_Base_BlockKey::WEB_SOCKETS ,
    );

    private static $_block_cli_keys = array (
        Interface_Base_BlockKey::CLI_AUTH ,
        Interface_Base_BlockKey::CLI_KEYS ,
        Interface_Base_BlockKey::CLI_INDEXES ,
        Interface_Base_BlockKey::CLI_UNIQUE_INDEX ,
        Interface_Base_BlockKey::CLI_RESERVED ,
        Interface_Base_BlockKey::CLI_SOCKETS ,
    );

    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_top    = Class_View_Top::top ();
        $_body   = array (
            "menu"    => Class_View_Memory_Menu::menu () ,
            "content" => "" ,
        );
        $_bottom = Class_View_Bottom::bottom ();
        Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        return null;
    }

    public static function system ()
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_result = Class_Base_Shell::command ( "ipcs -m" );

        if ( ! is_cli () ) {
            $_show_result = "";
            foreach ( $_result as $index => $item ) {
                $_show_result .= ( "\n" . $item . "\n" );
            }
            $_cli_url        = Class_Base_Response::get_cli_url ( "/memory/system" , array () );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_result_data_id = "result_data";
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Display a list of shared memory in the system</div>';
            $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to display the list of shared memory resources in the current system (note that due to access permissions, only the list of shared memory resources that can be accessed by the account to which the current process belongs is currently displayed).</span></div>';
            $_form           = array (
                "action"    => "/memory/system" ,
                "inputs"    => array (
                    array (
                        "id"       => "command" ,
                        "title"    => "( Command ) : " ,
                        "describe" => "IPC Command" ,
                        "name"     => "command" ,
                        "value"    => ( 'ipcs -m' ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"       => $_result_data_id ,
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( $_show_result ) ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;white-space: pre;padding:16px;' ,
                    ) ,
                    array (
                        "id"       => "cli_encode_url" ,
                        "title"    => "( Cli Encode URL )   : " ,
                        "name"     => "cli_encode_url" ,
                        "value"    => ( 'cli url : ' . $_cli_url . "\n\n" . 'cli encode url : ' . $_cli_encode_url . "\n\n" ) ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                ) ,
            );
            $_top            = Class_View_Top::top ();
            $_body           = array (
                "menu"    => Class_View_Memory_Menu::menu () ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu    = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content        = '<div></div>';
            $_javascript     = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom         = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( $_result );
        }
        return null;
    }

    public static function show_search ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_form     = array (
                "action" => "/memory/detail" ,
                "inputs" => array (
                    array (
                        "title"    => "key : " ,
                        "describe" => "key" ,
                        "name"     => "key" ,
                        "value"    => "" ,
                    ) ,
                ) ,
            );
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Search Share Memory Information</div>';
            $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is used to search for all available shared memory data, which can be controlled by the Phpsploit Framework software framework.</div>';
            $_top      = Class_View_Top::top ();
            $_body     = array (
                "menu"    => Class_View_Memory_Menu::menu () ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom   = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            throw new \Exception( "The current environment does not support SHMOP series functions and constant definitions!" );
        }
        return null;
    }

    public static function show_list ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_page      = Class_Base_Request::form ( "page" , Class_Base_Request::TYPE_INTEGER , 1 );
            $_page_size = Class_Base_Request::form ( "page_size" , Class_Base_Request::TYPE_INTEGER , 4 );
            $_key       = Class_Base_Request::form ( "key" , Class_Base_Request::TYPE_STRING , "" );
            $_search    = array ( "action" => "/memory/list" , "name" => "key" , "value" => $_key );
            if ( ! is_cli () ) {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::WEB_KEY );
            } else {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::CLI_KEY );
            }
            if ( ! is_cli () ) {
                $_max_page           = 1;
                $_list               = Class_Base_Format::map_to_list ( $_map , 3 , $_key );
                $_row_total          = count ( $_list );
                $_page_row_list      = Class_Base_Format::list_to_page_list ( $_list , $_page , $_page_size , $_max_page );
                $_page_row_link_list = Class_Base_Format::memory_page_list_to_memory_page_link_list ( $_page_row_list , "/memory/detail" );
                $_top                = Class_View_Top::top ();
                $_body               = array (
                    "menu"    => Class_View_Memory_Menu::menu () ,
                    "content" => ( Class_View_Memory::list_table ( $_page , $_page_size , $_max_page , $_row_total , $_page_row_link_list , $_search ) ) ,
                );
                $_bottom             = Class_View_Bottom::bottom ();
                Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
            } else {
                Class_Base_Response::outputln ( $_map , "block map : " );
            }
        } else {
            throw new \Exception( "The current environment does not support SHMOP series functions and constant definitions!" );
        }
        return null;
    }

    public static function show_detail ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            if ( ! is_cli () ) {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::WEB_KEY );
            } else {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::CLI_KEY );
            }
            $_key   = Class_Base_Request::form ( "key" );
            $_size  = 0;
            $_value = "";
            if ( ( ! empty( $_key ) ) ) {
                foreach ( $_map as $k => $v ) {
                    if ( $k == $_key ) {
                        $_size = $v;
                        break;
                    }
                }
                $_key   = intval ( $_key );
                $_shmid = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_size , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
                if ( ! empty( $_shmid ) ) {
                    $_value = Class_Base_Memory::read_share_memory ( $_shmid , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , $_size , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                }
            }
            if ( ! is_cli () ) {
                $_form_result = '<div style="width:100%;padding-top: 64px;"><div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Show shared memory information</div><div style="margin-bottom:32px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface displays data in shared memory in hexadecimal format.</div><div style="height: 32px;text-align: left;font-size: 18px;">';
                $_form_result .= empty( $_key ) ? '' : 'Shared memory key : ' . $_key;
                $_form_result .= '</div><div style="height: 32px;text-align: left;font-size:18px;">Shared memory size : ' . $_size . ' byte</div><div style="padding-top:12px;text-align: left;font-size:18px;">Shared memory data : ';
                $_form_result .= empty( $_value ) ? '' : Class_Base_Format::htmlentities ( Class_Base_Format::string_to_hexs_string ( $_value ) );
                $_form_result .= '</div></div>';
                $_form_result .= '<div style="width:100%;padding-top: 64px;text-align: center;"><a style="font-size:18px;" href="' . Class_Base_Response::get_url ( "/memory/edit" , array ( 'key' => $_key ) ) . '">edit</a>';
                $_form_result .= '<span style="font-size:18px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><a style="font-size:18px;" href="' . Class_Base_Response::get_url ( "/memory/delete" , array ( 'key' => $_key ) ) . '">delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>';
                $_top         = Class_View_Top::top ();
                $_body        = array (
                    "menu"    => Class_View_Memory_Menu::menu () ,
                    "content" => ( $_form_result ) ,
                );
                $_bottom      = Class_View_Bottom::bottom ();
                Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
            } else {
                Class_Base_Response::outputln ( $_key , "key : " );
                Class_Base_Response::outputln ( $_size , "size : " );
                Class_Base_Response::outputln ( $_value , "value : " );
            }
        } else {
            throw new \Exception( "The current environment does not support SHMOP series functions and constant definitions!" );
        }
        return null;
    }

    public static function add ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key   = Class_Base_Request::form ( "key" );
            $_value = Class_Base_Request::form ( "value" );
            $_size  = Class_Base_Request::form ( "size" );
            if ( ( ! empty( $_key ) ) && ( ( is_string ( $_value ) ) && ( $_value != '' ) ) && ( ! empty( $_size ) ) ) {
                if ( Class_Base_Format::is_minlen_to_maxlen_integer ( $_key , Class_Base_Format::INTEGER_MAX_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) {
                    if ( ( in_array ( $_size , self::$_sizes ) ) && ( ! in_array ( $_key , self::$_block_web_keys ) ) ) {
                        $_key   = intval ( $_key );
                        $_value = substr ( Class_Base_Format::hexs_string_to_string ( $_value ) , 0 , $_size );
                        $_value = substr ( $_value , 0 , $_size );
                        $_shmid = Class_Base_Memory::create_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_size );
                        if ( ! empty( $_shmid ) ) {
                            $_write_length = Class_Base_Memory::write_share_memory ( $_shmid , $_value , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                            if ( ! ( empty( $_write_length ) ) ) {
                                if ( ! is_cli () ) {
                                    Class_Base_Response::redirect ( "/memory/detail" , array ( "key" => $_key ) );
                                } else {
                                    Class_Base_Response::outputln ( "key : " . $_key . " , size : " . $_size . " , value : " . $_value );
                                }
                                return null;
                            }
                        }
                    }
                }
            }
            $_form = array (
                "action"  => "/memory/add" ,
                "name"    => "form1" ,
                "inputs"  => array (
                    array (
                        "title"    => "key : " ,
                        "describe" => "key" ,
                        "name"     => "key" ,
                        "value"    => ( time () . rand ( 10000000 , 99999999 ) ) ,
                    ) ,
                    array (
                        "title"    => "value : " ,
                        "describe" => "value" ,
                        "name"     => "value" ,
                        "value"    => '\x00\x00\x00\x00\x00\x00\x00\x00' ,
                    ) ,
                ) ,
                "selects" => array (
                    array (
                        "title"   => "size : " ,
                        "name"    => "size" ,
                        "options" => array () ,
                    ) ,
                ) ,
            );
            foreach ( self::$_sizes as $k => $v ) {
                $_form[ "selects" ][ 0 ][ "options" ][] = array ( "describe" => ( $v . ( ' byte' ) ) , "title" => ( $v . ( ' byte' ) ) , "value" => $v , "selected" => ( ( 8 == $v ) ? "selected" : "" ) );
            }
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Create Share Memory Data</div>';
            $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">You can create shared memory data through this function. When using this function, you need to set three options (shared memory key value, shared memory size, and shared memory data). The key value of shared memory is 18 bit integer type data, and the value range is (10000000000000000 ～ 999999999999999999); The size of shared memory is in bytes, and the optional value is an integer multiple of 2 (minimum 8 bytes, maximum 1048576 bytes); Shared memory data is in hexadecimal format (single character value range: x00~ xFF), and the total number of characters in shared memory data cannot exceed the size limit of shared memory, otherwise the overflow characters will be discarded!</div>';
            $_top      = Class_View_Top::top ();
            $_body     = array (
                "menu"    => Class_View_Memory_Menu::menu () ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom   = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            throw new \Exception( "The current environment does not support SHMOP series functions and constant definitions!" );
        }
        return null;
    }

    public static function edit ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key   = Class_Base_Request::form ( "key" );
            $_value = Class_Base_Request::form ( "value" );
            if ( empty( $_key ) ) {
                throw new \Exception( "Missing key request parameter: key , block key : " . $_key , 0 );
            }
            if ( ( in_array ( intval ( $_key ) , self::$_block_web_keys ) ) ) {
                if ( is_cli () ) {
                    throw new \Exception( "The framework retains key values and cannot be deleted , key : " . $_key , 0 );
                } else {
                    Class_Base_Response::redirect ( "/memory/detail" , array ( "key" => $_key ) );
                    return null;
                }
            }
            if ( ! is_cli () ) {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::WEB_KEY );
            } else {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::CLI_KEY );
            }
            if ( empty( $_map[ $_key ] ) ) {
                throw new \Exception( "block is not exist , block key : " . $_key , 0 );
            }
            $_size = $_map[ $_key ];
            if ( ( ! empty( $_key ) ) && ( ( is_string ( $_value ) ) && ( $_value != '' ) ) && ( ! empty( $_size ) ) && ( $_key != Interface_Base_Block_Keys::WEB_KEY ) && ( $_key != Interface_Base_Block_Keys::CLI_KEY ) ) {
                if ( Class_Base_Format::is_minlen_to_maxlen_integer ( $_key , Class_Base_Format::INTEGER_MAX_LENGTH , Class_Base_Format::INTEGER_MAX_LENGTH ) ) {
                    if ( ( in_array ( $_size , self::$_sizes ) ) && ( ! in_array ( $_key , self::$_block_web_keys ) ) ) {
                        $_key   = intval ( $_key );
                        $_value = substr ( Class_Base_Format::hexs_string_to_string ( $_value ) , 0 , $_size );
                        $_shmid = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_size , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
                        if ( ! empty( $_shmid ) ) {
                            $_write_length = Class_Base_Memory::write_share_memory ( $_shmid , Class_Base_Format::string_to_data ( $_value , $_size ) , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                            if ( ! ( empty( $_write_length ) ) ) {
                                if ( ! is_cli () ) {
                                    Class_Base_Response::redirect ( "/memory/detail" , array ( "key" => $_key ) );
                                } else {
                                    Class_Base_Response::outputln ( "key : " . $_key . " , size : " . $_size . " , value : " . $_value );
                                }
                                return null;
                            }
                        }
                    }
                }
            }
            $_key   = intval ( $_key );
            $_shmid = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_size , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( empty( $_shmid ) ) {
                throw new \Exception( "Shared memory does not exist , key ( " . $_key . " ) , size ( " . $_size . " ) " , 0 );
            }
            $_value = Class_Base_Memory::read_share_memory ( $_shmid , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , $_size , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            if ( $_value === false ) {
                throw new \Exception( "Shared memory content read failed , key ( " . $_key . " ) , size ( " . $_size . " ) " , 0 );
            }
            $_form = array (
                "action"  => "/memory/edit" ,
                "name"    => "form1" ,
                "hiddens" => array (
                    array (
                        "name"  => "key" ,
                        "value" => $_key ,
                    ) ,
                ) ,
                "inputs"  => array (
                    array (
                        "title"    => "key : " ,
                        "describe" => "key" ,
                        "name"     => "" ,
                        "value"    => $_key ,
                        "disabled" => "disabled" ,
                    ) ,
                    array (
                        "title"    => "value : " ,
                        "describe" => "value" ,
                        "name"     => "value" ,
                        "value"    => Class_Base_Format::string_to_hexs_string ( $_value ) ,
                        "disabled" => "" ,
                    ) ,
                ) ,
                "selects" => array (
                    array (
                        "title"    => "size : " ,
                        "name"     => "" ,
                        "options"  => array () ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            foreach ( self::$_sizes as $k => $v ) {
                $_form[ "selects" ][ 0 ][ "options" ][] = array ( "describe" => ( $v . ( ' byte' ) ) , "title" => ( $v . ( ' byte' ) ) , "value" => $v , "selected" => ( ( $_size == $v ) ? "selected" : "" ) );
            }
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Edit Share Memory Data</div>';
            $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">Are you sure you want to edit this shared memory? After editing, the data in the shared memory may have unknown exceptions (for example, the memory data may have errors due to changing the original value to the wrong value), which may lead to errors in the software program that references the shared memory, or even system crash!  </div>';
            $_top      = Class_View_Top::top ();
            $_body     = array (
                "menu"    => Class_View_Memory_Menu::menu () ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom   = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            throw new \Exception( "The current environment does not support SHMOP series functions and constant definitions!" );
        }
        return null;
    }

    public static function delete ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_time_key = "/memory/delete/csrf";
            $_key      = Class_Base_Request::form ( "key" );
            $_delete   = Class_Base_Request::form ( "delete" );
            $_csrf     = Class_Base_Request::form ( "memory_delete_csrf" );
            if ( ! is_cli () ) {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::WEB_KEY );
            } else {
                $_map = Class_Base_Block_Keys::read_map ( Interface_Base_Block_Keys::CLI_KEY );
            }
            if ( empty( $_map[ $_key ] ) ) {
                throw new \Exception( "Shared memory does not exist , key : " . $_key , 0 );
            }
            $_key  = intval ( $_key );
            $_size = $_map[ $_key ];
            if ( ( ! empty( $_key ) ) && ( ! empty( $_delete ) ) && ( ! empty( $_csrf ) ) ) {
                if ( ( in_array ( $_key , self::$_block_web_keys ) ) ) {
                    if ( is_cli () ) {
                        throw new \Exception( "The framework retains key values and cannot be deleted , key : " . $_key , 0 );
                    } else {
                        Class_Base_Response::redirect ( "/memory/delete" , array ( "key" => $_key ) );
                        return null;
                    }
                }
                if ( ( ! is_cli () ) && ( ( empty( $_SESSION[ $_time_key ] ) ) || ( $_csrf != $_SESSION[ $_time_key ] ) ) ) {
                    throw new \Exception( "Csrf token error , csrf : " . $_csrf , 0 );
                }
                $_deleted = Class_Base_Memory::delete_share_memory_by_key ( $_key , $_size );
                if ( ! $_deleted ) {
                    throw new \Exception( "Shared memory deletion failed , key : " . $_key , 0 );
                }
                $_SESSION[ $_time_key ] = null;
                if ( ! is_cli () ) {
                    Class_Base_Response::redirect ( "/memory/list" );
                } else {
                    Class_Base_Response::outputln ( "Shared memory deleted successfully , key ( " . $_key . " ) , size ( " . $_size . " ) " , 0 );
                }
                return null;
            }
            $_shmid = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , $_size , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( ! empty( $_shmid ) ) {
                $_value = Class_Base_Memory::read_share_memory ( $_shmid , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , $_size , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
            }
            if ( ! is_cli () ) {
                $_form_result = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Delete Share Memory Data</div>';
                $_form_result .= '<div style="width:100%;padding-top: 16px;padding-bottom: 16px;"><div style="height: 64px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">Are you sure you want to delete this shared memory? After deletion, the data in this shared memory cannot be recovered! </span>Confirm the deletion operation (select "<span style="font-size: 18px;color:red;">delete</span>"), otherwise select (select "<span style="font-size: 18px;color:blue;">back</span>").</div><div style="margin-top:32px;height: 32px;text-align: center;font-size: 18px;">Shared memory information</div><div style="width:100%;padding-top: 16px;padding-bottom:32px;text-align: left;"><span style="font-size: 18px;color:red;">prompt: Because there may be invisible characters (special characters, control character, etc.) in the content stored in shared memory, the current shared memory content will be displayed in hexadecimal form!</span></div><div style="height: 32px;text-align: left;font-size: 18px;">';
                $_form_result .= empty( $_key ) ? '' : 'Shared memory key : ' . $_key;
                $_form_result .= '</div><div style="height: 32px;text-align: left;font-size:18px;">Shared memory size : ' . $_size . ' byte</div><div style="text-align: left;font-size:18px;">Shared memory data : ';
                $_form_result .= empty( $_value ) ? '' : Class_Base_Format::htmlentities ( Class_Base_Format::string_to_hexs_string ( $_value ) );
                $_form_result .= '</div></div>';
                $_form_result .= '<div style="width:100%;padding-top: 64px;text-align: center;"><a style="font-size:18px;" href="' . Class_Base_Response::get_url ( "/memory/delete" , array ( 'key' => $_key , 'delete' => 1 , 'memory_delete_csrf' => $_SESSION[ $_time_key ] = ( time () . rand ( 10000000 , 99999999 ) ) ) ) . '">delete</a>';
                $_form_result .= '<span style="font-size:18px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><a style="font-size:18px;" href="' . Class_Base_Response::get_url ( "/memory/detail" , array ( 'key' => $_key , 'csrf' => $_SESSION[ "/memory/detail/time" ] = ( time () . rand ( 10000000 , 99999999 ) ) ) ) . '">back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>';
                $_top         = Class_View_Top::top ();
                $_body        = array (
                    "menu"    => Class_View_Memory_Menu::menu () ,
                    "content" => ( $_form_result ) ,
                );
                $_bottom      = Class_View_Bottom::bottom ();
                Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
            } else {
                Class_Base_Response::outputln ( $_key , "key : " );
                Class_Base_Response::outputln ( $_size , "size : " );
                Class_Base_Response::outputln ( $_value , "value : " );
            }
        } else {
            throw new \Exception( "The current environment does not support SHMOP series functions and constant definitions!" );
        }
        return null;
    }

    public static function clear ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        try {
            Class_Base_Auth::clear ();
        } catch ( \Exception $e ) {
            throw $e;
        }
        if ( ! is_cli () ) {
            Class_Base_Response::redirect ( "/login" );
        }
    }
}