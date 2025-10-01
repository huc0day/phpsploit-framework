<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-20
 * Time: 下午11:10
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

class Class_Controller_File extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( ! is_cli () ) {
            $_top    = Class_View_Top::top ();
            $_body   = array (
                "menu"    => Class_View_File_Menu::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function show_search ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_file_name              = Class_Base_Request::form ( "file_name" , Class_Base_Request::TYPE_STRING , "" );
        $_current_directory_path = Class_Base_Request::form ( "current_directory_path" , Class_Base_Request::TYPE_STRING , ( empty( $_SERVER[ "DOCUMENT_ROOT" ] ) ? "" : $_SERVER[ "DOCUMENT_ROOT" ] ) );
        if ( ! is_cli () ) {
            $_menu_params        = array (
                "search"   => array (
                    "file_name"              => $_file_name ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "explorer" => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "create"   => array (
                    "current_directory_path" => $_current_directory_path ,
                    "data_type"              => Class_Base_Format::TYPE_DATA_TEXT ,
                ) ,
                "upload"   => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "clear"    => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
            );
            $_form               = array (
                "action" => "/file/search" ,
                "inputs" => array (
                    array (
                        "title"    => "search path : " ,
                        "describe" => "search path" ,
                        "name"     => "current_directory_path" ,
                        "value"    => $_current_directory_path ,
                    ) ,
                    array (
                        "title"    => "file name : " ,
                        "describe" => "file name" ,
                        "name"     => "file_name" ,
                        "value"    => $_file_name ,
                    ) ,
                ) ,
            );
            $_form_top           = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Search File By File Name</div>';
            $_form_top           .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is used to search for a specified directory or file under a specified path based on a specified keyword.</div>';
            $_top                = Class_View_Top::top ();
            $_body               = array (
                "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu        = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_search_progress_id = "search_progress";
            $_search_errors_id   = "search_errors";
            $_search_result_id   = "search_result";
            $_content            = '<div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Progress</div><div id="' . $_search_progress_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Errors</div><div id="' . $_search_errors_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Result</div><div id="' . $_search_result_id . '" style="padding-top:16px;padding-bottom:16px;text-align: left;font-size:18px;"></div>';
            $_bottom             = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        if ( ( $_current_directory_path != "" ) && ( $_file_name != "" ) ) {
            Class_Operate_File::search_file ( $_current_directory_path , $_file_name , $_search_progress_id , $_search_errors_id , $_search_result_id , 500 );
        }
        if ( ! is_cli () ) {
            Class_Base_Response::output_div_inner_html ( $_search_progress_id , "" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
        }
        return null;
    }

    public static function show_explorer ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_current_directory_path = Class_Base_Request::form ( "current_directory_path" , Class_Base_Request::TYPE_STRING , ( empty( $_SERVER[ "DOCUMENT_ROOT" ] ) ? "" : $_SERVER[ "DOCUMENT_ROOT" ] ) );
        $_search_progress_id     = "search_progress";
        $_search_errors_id       = "search_errors";
        $_search_result_id       = "search_result";
        if ( ! is_cli () ) {
            $_menu_params        = array (
                "search"   => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "explorer" => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "create"   => array (
                    "current_directory_path" => $_current_directory_path ,
                    "data_type"              => Class_Base_Format::TYPE_DATA_TEXT ,
                ) ,
                "upload"   => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "clear"    => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
            );
            $_form               = array (
                "action" => "/file/explorer" ,
                "inputs" => array (
                    array (
                        "title"    => "current directory : " ,
                        "describe" => "current directory path" ,
                        "name"     => "current_directory_path" ,
                        "value"    => $_current_directory_path ,
                    ) ,
                ) ,
            );
            $_form_top           = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Show Directory And File Path</div>';
            $_form_top           .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is used to display directories or files under a specified path.</div>';
            $_top                = Class_View_Top::top ();
            $_body               = array (
                "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu        = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_search_progress_id = "search_progress";
            $_search_errors_id   = "search_errors";
            $_search_result_id   = "search_result";
            $_content            = '<div id="' . $_search_progress_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div id="' . $_search_errors_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div id="' . $_search_result_id . '" style="padding-top:16px;padding-bottom:16px;text-align: left;font-size:18px;"></div>';
            $_bottom             = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        Class_Operate_File::explorer ( $_current_directory_path , $_search_progress_id , $_search_errors_id , $_search_result_id , "/file/explorer" , "/file/detail" , array ( "directory_field_name" => "current_directory_path" , "file_field_name" => "file_path" ) );
        return null;
    }

    public static function show_detail ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_data_type                = Class_Base_Request::form ( "data_type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Request::TYPE_DATA_BIN );
        $_file_path                = Class_Base_Request::form ( "file_path" , Class_Base_Request::TYPE_STRING , "" );
        $_file_content_read_offset = Class_Base_Request::form ( "file_content_read_offset" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_file_info                = Class_Operate_File::get_file_info ( $_file_path , $_file_content_read_offset , $_data_type );
        $_current_directory_path   = Class_Base_File::parent_directory ( $_file_path );
        $_file_name                = Class_Base_File::get_file_name ( $_file_path );
        if ( ( ! file_exists ( $_file_path ) ) || ( ! is_file ( $_file_path ) ) ) {
            Class_Base_Response::redirect ( "/file/explorer" , array ( "current_directory_path" => dirname ( $_file_path ) ) );
            return null;
        }
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Show File Content</div>';
            $_form_result = '<div style="width:100%;padding-top: 16px;"><div style="text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">';
            $_form_result .= 'The following displays relevant information about the current file, including file path, file type, file size, file access permissions, user group to which the file belongs, user to whom the file belongs, last access time, last modification time of the file, inode information of the file, and last modification time of the file inode.';
            $_form_result .= '</div><div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">File information</div><div style="height: 32px;text-align: left;font-size: 18px;">';
            $_form_result .= empty( $_file_path ) ? '' : 'file path : ' . $_file_path;
            $_form_result .= '</div><div style="height: 32px;text-align: left;font-size:18px;">file type : ' . $_file_info[ "type" ] . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file size : ' . $_file_info[ "size" ] . ' byte</div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file perms : ' . $_file_info[ "perms" ] . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file group : ' . ( ( ! empty( $_file_info[ "group" ] ) ) ? ( "name : " . $_file_info[ "group" ][ "name" ] . " , gid : " . $_file_info[ "group" ][ "gid" ] ) : "" ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file owner : ' . ( ( ! empty( $_file_info[ "owner" ] ) ) ? ( "name : " . $_file_info[ "owner" ][ "name" ] . " , uid : " . $_file_info[ "owner" ][ "gid" ] ) : "" ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file atime : ' . date ( 'Y-m-d H:i:s' , $_file_info[ "atime" ] ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file mtime : ' . date ( 'Y-m-d H:i:s' , $_file_info[ "mtime" ] ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file inode : ' . $_file_info[ "inode" ] . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file ctime : ' . date ( 'Y-m-d H:i:s' , $_file_info[ "ctime" ] ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">read limit : ' . $_file_info[ "content_read_limit" ] . ' byte </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">read offset : ' . $_file_info[ "content_read_offset" ] . '  </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">next offset : ' . $_file_info[ "content_read_next_offset" ] . '  </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">read remain : ' . ( ( $_file_info[ "content_read_remain" ] < 0 ) ? 0 : $_file_info[ "content_read_remain" ] ) . ' byte </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">data type : ' . ( ( $_file_info[ "data_type" ] == Class_Base_File::TYPE_DATA_TEXT ) ? "Text Data Format" : "Binary Data Format" ) . ' &nbsp;&nbsp;<a href="' . ( Class_Base_Response::get_url ( "/file/detail" , array ( 'file_path' => $_file_path , "file_content_read_offset" => $_file_info[ "content_read_offset" ] , "data_type" => ( ( $_file_info[ "data_type" ] == Class_Base_File::TYPE_DATA_TEXT ) ? Class_Base_File::TYPE_DATA_BIN : Class_Base_File::TYPE_DATA_TEXT ) ) ) ) . '">Switch the data display format to ' . ( ( $_file_info[ "data_type" ] == Class_Base_File::TYPE_DATA_TEXT ) ? "Binary Data Format" : "Text Data Format" ) . '</a>  </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">data size : ' . $_file_info[ "content_size" ] . ' byte </div>';
            $_form_result .= '<div style="padding-top:12px;text-align: left;font-size:18px;">file data : ';
            if ( $_data_type == Class_Base_Format::TYPE_DATA_TEXT ) {
                $_form_result .= '<pre>';
            }
            $_form_result .= ( ( isset( $_file_path ) ) && ( file_exists ( $_file_path ) ) && ( is_file ( $_file_path ) ) ) ? ( Class_Base_Format::htmlentities ( $_file_info[ "content" ] ) ) : "";
            if ( $_data_type == Class_Base_Format::TYPE_DATA_TEXT ) {
                $_form_result .= '</pre>';
            }
            $_form_result .= '</div></div>';
            $_form_result .= '<div style="width:100%;padding-top: 64px;">';
            $_form_result .= '<table style="width:100%;">';
            $_form_result .= '<tr>';
            $_form_result .= '<td colspan="4" style="text-align: left;padding-top:32px;padding-bottom: 32px;"><a style="font-size:18px;" href="' . ( ( empty( $_file_info[ "content_read_remain" ] ) ) ? Class_Base_Response::get_url ( "/file/detail" , array ( 'file_path' => $_file_path , "file_content_read_offset" => 0 , "data_type" => $_data_type ) ) : Class_Base_Response::get_url ( "/file/detail" , array ( 'file_path' => $_file_path , "file_content_read_offset" => $_file_info[ "content_read_next_offset" ] , "data_type" => $_data_type ) ) ) . '">Read File Reamin Content</a></td>';
            $_form_result .= '</tr>';
            $_form_result .= '<tr>';
            $_form_result .= '<td colspan="4" style="text-align: left;padding-bottom: 32px;"><a style="font-size:18px;" href="' . ( ( is_null ( $_current_directory_path ) ) ? "" : Class_Base_Response::get_url ( "/file/explorer" , array ( 'current_directory_path' => $_current_directory_path ) ) ) . '">Return To Current Directory : ' . ( ( ! is_null ( $_current_directory_path ) ) ? $_current_directory_path : "" ) . '</a></td>';
            $_form_result .= '</tr>';
            $_form_result .= '<tr>';
            $_form_result .= '<td style="25%;text-align: left;"><a style="font-size:18px;" href="' . ( ( is_null ( $_current_directory_path ) ) ? "" : Class_Base_Response::get_url ( "/file/upload" , array ( 'current_directory_path' => $_current_directory_path ) ) ) . '">Upload files to the current directory</a></td>';
            $_form_result .= '<td style="25%;text-align: left;"><a style="font-size:18px;" href="' . ( ( is_null ( $_current_directory_path ) ) ? "" : Class_Base_Response::get_url ( "/file/create" , array ( 'current_directory_path' => $_current_directory_path ) ) ) . '">Create a file in the current directory</a></td>';
            $_form_result .= '<td style="25%;text-align: left;">' . ( ( ! Class_Base_File::is_permission ( $_file_path ) ) ? "" : '<a style="font-size:18px;" href="' . Class_Base_Response::get_url ( "/file/edit" , array ( 'file_path' => $_file_path , ) ) . '">Edit current file</a>' ) . '</td>';
            $_form_result .= '<td style="25%;text-align: left;">' . ( ( ! Class_Base_File::is_permission ( $_file_path ) ) ? "" : '<a style="font-size:18px;" href="' . Class_Base_Response::get_url ( "/file/delete" , array ( 'file_path' => $_file_path , ) ) . '">Delete current file</a>' ) . '</td>';
            $_form_result .= '</tr>';
            $_form_result .= '</table>';
            $_form_result .= '</div>';
            $_menu_params = array (
                "search"   => array (
                    "file_name"              => $_file_name ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "explorer" => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "create"   => array (
                    "current_directory_path" => $_current_directory_path ,
                    "data_type"              => Class_Base_Format::TYPE_DATA_TEXT ,
                ) ,
                "upload"   => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "clear"    => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
                "content" => ( $_form_top . $_form_result ) ,
            );
            $_bottom      = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( $_file_info , "file_info : " );
        }

        return null;
    }

    public static function show_create ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_current_directory_path = Class_Base_Request::form ( "current_directory_path" , Class_Base_Request::TYPE_STRING , "" );
        $_file_name              = Class_Base_Request::form ( "file_name" , Class_Base_Request::TYPE_STRING , "" );
        $_data_type              = Class_Base_Request::form ( "data_type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Request::TYPE_DATA_BIN );
        $_file_content           = Class_Base_Request::form ( "file_content" , Class_Base_Request::TYPE_STRING , "" );
        $_file_content_size      = Class_Base_Format::get_bin_content_size ( $_file_content , $_data_type );
        if ( ( is_string ( $_current_directory_path ) ) && ( strlen ( $_current_directory_path ) > 0 ) && ( is_string ( $_file_name ) ) && ( strlen ( $_file_name ) > 0 ) && ( is_integer ( $_data_type ) ) && ( in_array ( $_data_type , array ( Class_Base_Request::TYPE_DATA_TEXT , Class_Base_Request::TYPE_DATA_BIN ) ) ) && ( is_string ( $_file_content ) ) && ( $_file_content_size > 0 ) && ( $_file_content_size <= Class_Base_File::SIZE_FILE_CONTENT_LIMIT ) ) {
            $_file_info = Class_Operate_File::create_file ( $_current_directory_path , $_file_name , $_data_type , $_file_content );
            if ( ! empty( $_file_info ) ) {
                Class_Base_Response::redirect ( "/file/detail" , array ( "file_path" => $_file_info[ "file_path" ] ) );
            }
        }
        if ( ! is_cli () ) {
            $_menu_params = array (
                "search"   => array (
                    "file_name"              => $_file_name ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "explorer" => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "create"   => array (
                    "current_directory_path" => $_current_directory_path ,
                    "data_type"              => $_data_type ,
                ) ,
                "upload"   => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "clear"    => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
            );
            $_form        = array (
                "action"    => "/file/create" ,
                "inputs"    => array (
                    array (
                        "title"    => "current directory : " ,
                        "describe" => "current directory path" ,
                        "name"     => "current_directory_path" ,
                        "value"    => $_current_directory_path ,
                    ) ,
                    array (
                        "title"    => "file name : " ,
                        "describe" => "file name" ,
                        "name"     => "file_name" ,
                        "value"    => $_file_name ,
                    ) ,
                ) ,
                "selects"   => array (
                    array (
                        "title"   => "data type : " ,
                        "name"    => "data_type" ,
                        "options" => array (
                            array ( "describe" => "text data" , "title" => "Text Data Format" , "value" => Class_Base_Format::TYPE_DATA_TEXT , "selected" => ( ( $_data_type == Class_Base_Format::TYPE_DATA_TEXT ) ? "selected" : "" ) ) ,
                            array ( "describe" => "bin data" , "title" => "Binary Data Format" , "value" => Class_Base_Format::TYPE_DATA_BIN , "selected" => ( ( $_data_type == Class_Base_Format::TYPE_DATA_BIN ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "title" => "file content : " ,
                        "name"  => "file_content" ,
                        "value" => $_file_content ,
                    ) ,
                ) ,
            );
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Create File</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is used to create files of the specified type using the specified content format. Currently, the supported content formats are divided into text format and binary format (binary format is encoded using the "\x<0~f><0- f>" format, with a value range of 0x00~ 0xff).</div>';
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , ( $_content ) );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function show_upload ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( is_cli () ) {
            throw new \Exception( "The current method of the controller cannot be run in a command line environment!" , 0 );
        }
        $_current_directory_path  = Class_Base_Request::form ( "current_directory_path" , Class_Base_Request::TYPE_STRING , "" );
        $_file_upload_count_index = 0;
        $_file_upload_count_limit = 10;
        $_file_objects            = array ();
        foreach ( $_FILES as $key => $item ) {
            $_file_object = Class_Base_File::upload ( $key , $_current_directory_path , Class_Base_File::SIZE_FILE_CONTENT_LIMIT , Class_Base_File::get_file_type_all () );
            if ( ! empty( $_file_object ) ) {
                $_file_objects[ $key ] = $_file_object;
                $_file_upload_count_index ++;
                if ( $_file_upload_count_index >= $_file_upload_count_limit ) {
                    break;
                }
            }
        }
        if ( ( ! empty( $_file_objects ) ) ) {
            $_file_objects_size = count ( $_file_objects );
            if ( $_file_objects_size == 1 ) {
                foreach ( $_file_objects as $key => $file_object ) {
                    if ( ( is_object ( $file_object ) ) && ( $file_object instanceof Class_Base_File ) && ( property_exists ( $file_object , "exist" ) ) && ( ! empty( $file_object->exist ) ) ) {
                        Class_Base_Response::redirect ( "/file/detail" , array ( "file_path" => $file_object->path ) );
                        return null;
                    }
                }
            }
            foreach ( $_file_objects as $key => $file_object ) {
                if ( ( is_object ( $file_object ) ) && ( $file_object instanceof Class_Base_File ) && ( property_exists ( $file_object , "exist" ) ) && ( ! empty( $file_object->exist ) ) ) {
                    Class_Base_Response::outputln ( '<div style="padding: 32px;width:100%;text-align: center;"><a href="' . Class_Base_Response::get_url ( "/file?detail" , array ( "file_path" => $file_object->path ) ) . '">' . $file_object->path . '</a></div>' );
                }
            }
            return null;
        }
        $_menu_params = array (
            "search"   => array (
                "file_name"              => "" ,
                "current_directory_path" => $_current_directory_path ,
            ) ,
            "explorer" => array (
                "current_directory_path" => $_current_directory_path ,
            ) ,
            "create"   => array (
                "current_directory_path" => $_current_directory_path ,
                "data_type"              => Class_Base_Format::TYPE_DATA_TEXT ,
            ) ,
            "upload"   => array (
                "current_directory_path" => $_current_directory_path ,
            ) ,
            "clear"    => array (
                "file_name"              => "" ,
                "current_directory_path" => $_current_directory_path ,
            ) ,
        );
        $_form        = array (
            "action"  => "/file/upload" ,
            "enctype" => "multipart/form-data" ,
            "inputs"  => array (
                array (
                    "title"    => "current directory : " ,
                    "describe" => "current directory path" ,
                    "name"     => "current_directory_path" ,
                    "value"    => $_current_directory_path ,
                ) ,
            ) ,
            "files"   => array (
                array (
                    "title"    => "upload file : " ,
                    "describe" => "upload file" ,
                    "name"     => "file_1" ,
                    "value"    => "" ,
                ) ,
            ) ,
        );
        $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Upload File</div>';
        $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is used to upload specified files to the specified directory. Warning: Uploading inappropriate files to the server may pose a security risk. Inappropriate files include executable files in binary format, script command files in text format, etc.You should be fully aware that uploading inappropriate files to the server space can cause various terrifying risk consequences!This includes but is not limited to server space, operating system, functional abnormalities in applications, software crashes, data corruption, loss or leakage, and other situations!Before uploading files, you should be fully aware that your improper behavior may bring legal risks and consequences to yourself! This module function must be used with caution.It can only be used for legally authorized penetration testing and security audit activities.The written contract you sign with the authorized party should clearly indicate that the authorized party allows you to upload files and other related operations, and specify the types of files that can be uploaded.You must strictly abide by the contract content signed between you and the authorized party, and conduct safe, reasonable, and moderate file upload behavior according to the contract content.</div>';
        $_top         = Class_View_Top::top ();
        $_body        = array (
            "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
            "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
        );
        $_bottom_menu = array (
            array (
                "title"    => "" ,
                "describe" => "" ,
                "href"     => "#" ,
            ) ,
        );
        $_content     = '<div></div>';
        $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
        Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        return null;
    }

    public static function show_edit ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_debug        = Class_Base_Request::form ( "debug" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_data_type    = Class_Base_Request::form ( "data_type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Request::TYPE_DATA_BIN );
        $_file_content = Class_Base_Request::form ( "file_content" , Class_Base_Request::TYPE_STRING , "" );
        $_file_path    = Class_Base_Request::form ( "file_path" , Class_Base_Request::TYPE_STRING , "" );
        if ( file_exists ( $_file_path ) && is_file ( $_file_path ) && ( Class_Base_File::is_permission ( $_file_path ) ) ) {
            if ( strlen ( $_file_content ) > 0 ) {
                $_file_content_update_size_limit = Class_Base_File::SIZE_FILE_CONTENT_LIMIT;
                $_file_info                      = Class_Operate_File::update_file ( $_file_path , $_file_content , $_data_type , $_file_content_update_size_limit , $_debug );
                if ( ! empty( $_file_info ) ) {
                    Class_Base_Response::redirect ( "/file/detail" , array ( "file_path" => $_file_info[ "file_path" ] ) );
                }
                return null;
            }
            $_limit_read_size               = Class_Base_File::SIZE_FILE_CONTENT_LIMIT;
            $_current_directory_path        = dirname ( $_file_path );
            $_file_name                     = basename ( $_file_path );
            $_file_size                     = Class_Base_File::get_file_size ( $_file_path );
            $_file_content_remain_read_size = 0;
            $_file_content                  = Class_Base_File::get_file_content ( $_file_path , $_data_type , $_file_content_remain_read_size , $_limit_read_size );
            $_file_content_read_size        = Class_Base_File::get_file_content_size ( $_file_content , $_data_type );
            if ( ! is_cli () ) {
                $_menu_params = array (
                    "search"   => array (
                        "file_name"              => "" ,
                        "current_directory_path" => $_current_directory_path ,
                    ) ,
                    "explorer" => array (
                        "current_directory_path" => $_current_directory_path ,
                    ) ,
                    "create"   => array (
                        "current_directory_path" => $_current_directory_path ,
                        "data_type"              => $_data_type ,
                    ) ,
                    "upload"   => array (
                        "current_directory_path" => $_current_directory_path ,
                    ) ,
                    "clear"    => array (
                        "file_name"              => "" ,
                        "current_directory_path" => $_current_directory_path ,
                    ) ,
                );
                $_form        = array (
                    "action"    => "/file/edit" ,
                    "hiddens"   => array (
                        array (
                            "name"  => "data_type" ,
                            "value" => $_data_type ,
                        ) ,
                        array (
                            "name"  => "file_path" ,
                            "value" => $_file_path ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "title"    => "current directory : " ,
                            "describe" => "current directory path" ,
                            "name"     => "current_directory_path" ,
                            "value"    => $_current_directory_path ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "edit file name : " ,
                            "describe" => "edit file name" ,
                            "name"     => "edit_file_name" ,
                            "value"    => $_file_name ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "file content size : " ,
                            "describe" => "file content size" ,
                            "name"     => "file_content_size" ,
                            "value"    => ( $_file_size . " byte" ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "file content read size : " ,
                            "describe" => "file content read size" ,
                            "name"     => "file_content_read_size" ,
                            "value"    => ( $_file_content_read_size . " byte" ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "file content remain read size : " ,
                            "describe" => "file content remain read size" ,
                            "name"     => "file_content_remain_read_size" ,
                            "value"    => ( $_file_content_remain_read_size . " byte" ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "file editing permissions : " ,
                            "describe" => "file editing permissions" ,
                            "name"     => "file_editing_permissions" ,
                            "value"    => ( ( $_file_size > $_limit_read_size ) ? "prohibit" : "allow" ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "selects"   => array (
                        array (
                            "title"    => "data type : " ,
                            "name"     => "edit_data_type" ,
                            "options"  => array (
                                array ( "describe" => "text data" , "title" => "text data" , "value" => Class_Base_Format::TYPE_DATA_TEXT , "selected" => ( ( $_data_type == Class_Base_Format::TYPE_DATA_TEXT ) ? "selected" : "" ) ) ,
                                array ( "describe" => "bin data" , "title" => "bin data" , "value" => Class_Base_Format::TYPE_DATA_BIN , "selected" => ( ( $_data_type == Class_Base_Format::TYPE_DATA_BIN ) ? "selected" : "" ) ) ,
                            ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "title"    => "file data : " ,
                            "name"     => "file_content" ,
                            "value"    => $_file_content ,
                            "disabled" => ( ( $_file_size > $_limit_read_size ) ? "disabled" : "" ) ,
                        ) ,
                    ) ,
                );
                $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Edit File</div>';
                $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">Attention!When editing files, pay attention to the differences in display content formats!There is a clear difference between pure text format and binary content format in terms of saving and processing after editing!Inappropriate content format changes may result in the loss or damage of the target content!When you choose to save the file content in plain text format, the Phpsploit Framework software will save it in text content format.When you choose to save the file content in binary content format, the Phpsploit Framework software will save it in binary format.Warning: When editing the content of a binary file, you should choose to save it in binary mode instead of in plain text mode.</div>';
                $_top         = Class_View_Top::top ();
                $_body        = array (
                    "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
                    "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
                );
                $_bottom_menu = array (
                    array (
                        "title"    => 'Switch data editing format to ' . ( ( $_data_type == Class_Base_File::TYPE_DATA_TEXT ) ? "Binary Data Format" : "Text Data Format" ) ,
                        "describe" => 'Switch data editing format to ' . ( ( $_data_type == Class_Base_File::TYPE_DATA_TEXT ) ? "Binary Data Format" : "Text Data Format" ) ,
                        "href"     => ( Class_Base_Response::get_url ( "/file/edit" , array ( 'file_path' => $_file_path , "data_type" => ( $_data_type == Class_Base_File::TYPE_DATA_TEXT ) ? Class_Base_File::TYPE_DATA_BIN : Class_Base_File::TYPE_DATA_TEXT ) ) ) ,
                    ) ,
                );
                $_content     = '<div style="margin-top:64px;"></div>';
                $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
                Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
            }
        }

        return null;
    }

    public static function show_delete ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_debug                    = Class_Base_Request::form ( "debug" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_file_path                = Class_Base_Request::form ( "file_path" , Class_Base_Request::TYPE_STRING , "" );
        $_file_content_read_offset = Class_Base_Request::form ( "file_content_read_offset" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_file_info                = Class_Operate_File::get_file_info ( $_file_path , $_file_content_read_offset );
        $_deleted                  = Class_Base_Request::form ( "deleted" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_current_directory_path   = Class_Base_File::parent_directory ( $_file_path );
        $_file_name                = Class_Base_File::get_file_name ( $_file_path );
        if ( ( strlen ( $_file_path ) > 0 ) && ( ! empty( $_deleted ) ) && Class_Base_File::is_permission ( $_file_path ) ) {
            $_file_info = Class_Operate_File::delete_file ( $_file_path , ( Class_Base_File::SIZE_FILE_CONTENT_LIMIT * 10 ) , $_debug );
            if ( ! empty( $_file_info ) ) {
                if ( ! is_cli () ) {
                    Class_Base_Response::outputln ( '<div style="height:64px;"></div>' );
                    Class_Base_Response::output_link_label ( Class_Base_Response::get_url ( "/file/explorer" , array ( "current_directory_path" => $_current_directory_path ) ) , "jmp_to_explorer_parent_directory" , ( 'Successfully deleted file ( ' . $_file_path . ' ) ! Return To Current Directory : ' . $_current_directory_path ) , ( 'Return To Current Directory : ' . $_current_directory_path ) );
                } else {
                    Class_Base_Response::outputln ( $_file_info );
                }
                return null;
            }
        }
        if ( ( ! file_exists ( $_file_path ) ) || ( ! is_file ( $_file_path ) ) ) {
            Class_Base_Response::redirect ( "/file/explorer" , array ( "current_directory_path" => dirname ( $_file_path ) ) );
            return null;
        }
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Delete File</div>';
            $_form_result = '<div style="width:100%;padding-top: 16px;padding-bottom: 32px;"><div style="text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">';
            $_form_result .= 'The following shows the relevant information of the current file, including file path, file type, file size, file access permissions, user group to which the file belongs, user to whom the file belongs, last access time, last modification time of the file, inode information of the file, and last modification time of the inode of the file.';
            $_form_result .= '</div></div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size: 18px;">';
            $_form_result .= empty( $_file_path ) ? '' : 'file path : ' . $_file_path;
            $_form_result .= '</div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file type : ' . $_file_info[ "type" ] . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file size : ' . $_file_info[ "size" ] . ' byte</div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file perms : ' . $_file_info[ "perms" ] . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file group : ' . ( ( ! empty( $_file_info[ "group" ] ) ) ? ( "name : " . $_file_info[ "group" ][ "name" ] . " , gid : " . $_file_info[ "group" ][ "gid" ] ) : "" ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file owner : ' . ( ( ! empty( $_file_info[ "owner" ] ) ) ? ( "name : " . $_file_info[ "owner" ][ "name" ] . " , uid : " . $_file_info[ "owner" ][ "gid" ] ) : "" ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file atime : ' . date ( 'Y-m-d H:i:s' , $_file_info[ "atime" ] ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file mtime : ' . date ( 'Y-m-d H:i:s' , $_file_info[ "mtime" ] ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file inode : ' . $_file_info[ "inode" ] . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">file ctime : ' . date ( 'Y-m-d H:i:s' , $_file_info[ "ctime" ] ) . ' </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">read limit : ' . $_file_info[ "content_read_limit" ] . ' byte </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">read offset : ' . $_file_info[ "content_read_offset" ] . '  </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">next offset : ' . $_file_info[ "content_read_next_offset" ] . '  </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">read remain : ' . ( ( $_file_info[ "content_read_remain" ] < 0 ) ? 0 : $_file_info[ "content_read_remain" ] ) . ' byte </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">data size : ' . $_file_info[ "content_size" ] . ' byte </div>';
            $_form_result .= '<div style="height: 32px;text-align: left;font-size:18px;">data type : ' . ( ( $_file_info[ "data_type" ] == Class_Base_File::TYPE_DATA_TEXT ) ? "Text Data Format" : "Binary Data Format" ) . ' &nbsp;&nbsp;<a href="' . ( Class_Base_Response::get_url ( "/file/delete" , array ( 'file_path' => $_file_path , "file_content_read_offset" => $_file_info[ "content_read_next_offset" ] , "data_type" => ( ( $_file_info[ "data_type" ] == Class_Base_File::TYPE_DATA_TEXT ) ? Class_Base_File::TYPE_DATA_BIN : Class_Base_File::TYPE_DATA_TEXT ) ) ) ) . '">Switch the data display format to ' . ( ( $_file_info[ "data_type" ] == Class_Base_File::TYPE_DATA_TEXT ) ? "Binary Data Format" : "Text Data Format" ) . '</a>  </div>';
            $_form_result .= '<div style="padding-top:12px;text-align: left;font-size:18px;">file data : ';
            $_form_result .= ( ( isset( $_file_path ) ) && ( file_exists ( $_file_path ) ) && ( is_file ( $_file_path ) ) ) ? ( Class_Base_Format::htmlentities ( $_file_info[ "content" ] ) ) : "";
            $_form_result .= '</div></div>';
            $_form_result .= '<div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Are you sure you want to delete the current file?</div>';
            $_form_result .= '<div style="margin-top:32px;margin-bottom:16px;text-align: left;font-size: 18px;color:red;">After deleting the file, it will be difficult to recover, please operate with caution! If you are unsure whether to delete the current file, please abandon the deletion of the current file!</div>';
            $_form_result .= '<div style="width:100%;padding-top: 64px;">';
            $_form_result .= '<table style="width:100%;">';
            $_form_result .= '<tr>';
            $_form_result .= '<td colspan="4" style="text-align: left;padding-top:32px;padding-bottom: 32px;"><a style="font-size:18px;" href="' . ( ( empty( $_file_info[ "content_read_remain" ] ) ) ? "" : Class_Base_Response::get_url ( "/file/delete" , array ( 'file_path' => $_file_path , "file_content_read_offset" => $_file_info[ "content_read_next_offset" ] ) ) ) . '">Read File Reamin Content</a></td>';
            $_form_result .= '</tr>';
            $_form_result .= '<tr>';
            $_form_result .= '<td colspan="4" style="text-align: left;padding-bottom: 32px;"><a style="font-size:18px;" href="' . ( ( is_null ( $_current_directory_path ) ) ? "" : Class_Base_Response::get_url ( "/file/explorer" , array ( 'current_directory_path' => $_current_directory_path ) ) ) . '">Return To Current Directory : ' . ( ( ! is_null ( $_current_directory_path ) ) ? $_current_directory_path : "" ) . '</a></td>';
            $_form_result .= '</tr>';
            $_form_result .= '<tr>';
            $_form_result .= '<td style="50%;text-align: left;">' . ( ( ! Class_Base_File::is_permission ( $_file_path ) ) ? "" : '<a style="font-size:18px;" href="' . ( Class_Base_Response::get_url ( "/file/delete" , array ( 'file_path' => $_file_path , 'deleted' => 1 ) ) ) . '">Delete current file</a>' ) . '</td>';
            $_form_result .= '<td style="50%;text-align: left;"><a style="font-size:18px;" href="' . ( Class_Base_Response::get_url ( "/file/detail" , array ( 'file_path' => $_file_path , ) ) ) . '">Return to View Current File</a></td>';
            $_form_result .= '</tr>';
            $_form_result .= '</table>';
            $_form_result .= '</div>';
            $_menu_params = array (
                "search"   => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "explorer" => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "create"   => array (
                    "current_directory_path" => $_current_directory_path ,
                    "data_type"              => Class_Base_Format::TYPE_DATA_TEXT ,
                ) ,
                "upload"   => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "clear"    => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
                "content" => ( $_form_top . $_form_result ) ,
            );
            $_bottom      = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( $_file_path , "file : " );
        }
        return null;
    }

    public static function show_clear ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_file_name              = Class_Base_Request::form ( "file_name" , Class_Base_Request::TYPE_STRING , "" );
        $_current_directory_path = Class_Base_Request::form ( "current_directory_path" , Class_Base_Request::TYPE_STRING , ( empty( $_SERVER[ "DOCUMENT_ROOT" ] ) ? "" : $_SERVER[ "DOCUMENT_ROOT" ] ) );
        if ( ! is_cli () ) {
            $_menu_params        = array (
                "search"   => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "explorer" => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "create"   => array (
                    "current_directory_path" => $_current_directory_path ,
                    "data_type"              => Class_Base_Format::TYPE_DATA_TEXT ,
                ) ,
                "upload"   => array (
                    "current_directory_path" => $_current_directory_path ,
                ) ,
                "clear"    => array (
                    "file_name"              => "" ,
                    "current_directory_path" => $_current_directory_path ,
                ) ,
            );
            $_form               = array (
                "action" => "/file/clear" ,
                "inputs" => array (
                    array (
                        "title"    => "search clear path : " ,
                        "describe" => "search clear path" ,
                        "name"     => "current_directory_path" ,
                        "value"    => $_current_directory_path ,
                    ) ,
                    array (
                        "title"    => "clear file name : " ,
                        "describe" => "clear file name" ,
                        "name"     => "file_name" ,
                        "value"    => ( ( strlen ( $_file_name ) <= 0 ) ? "phpsploit" : $_file_name ) ,
                    ) ,
                ) ,
            );
            $_form_top           = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Clear File By File Name</div>';
            $_form_top           .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">Note: For security reasons (the purpose of this software design and release is to enable ethical hackers to better conduct penetration testing and security audit activities, rather than being used by malicious saboteurs for various illegal activities), this module function can only clear relevant files directly created, uploaded, and downloaded using the Phpsploit framework software.</div>';
            $_top                = Class_View_Top::top ();
            $_body               = array (
                "menu"    => Class_View_File_Menu::menu ( $_menu_params ) ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu        = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_search_progress_id = "search_progress";
            $_search_errors_id   = "search_errors";
            $_search_result_id   = "search_result";
            $_content            = '<div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Progress</div><div id="' . $_search_progress_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Errors</div><div id="' . $_search_errors_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Result</div><div id="' . $_search_result_id . '" style="padding-top:16px;padding-bottom:16px;text-align: left;font-size:18px;"></div><div style="height:64px;"></div>';
            $_bottom             = Class_View_Bottom::bottom ( $_bottom_menu , $_content );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        if ( ( $_current_directory_path != "" ) && ( $_file_name != "" ) ) {
            Class_Operate_File::clear_file ( $_current_directory_path , $_file_name , $_search_progress_id , $_search_errors_id , $_search_result_id , 500 );
        }
        if ( ! is_cli () ) {
            Class_Base_Response::output_div_inner_html ( $_search_progress_id , "" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
        }
        return null;
    }
}