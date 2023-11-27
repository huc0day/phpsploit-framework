<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-24
 * Time: 上午11:34
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

class Class_Operate_File extends Class_Root implements Interface_Operate
{
    public static function search_file ( $search_path , $search_filename , $search_progress_id , $search_errors_id , $search_result_id , $usleep = 100 , $debug = 0 )
    {
        if ( ! is_integer ( $usleep ) ) {
            $usleep = 100;
        }
        if ( is_string ( $search_path ) && ( is_string ( $search_filename ) ) ) {
            $_search_path            = str_replace ( "\\" , "/" , $search_path );
            $_search_filename_length = strlen ( $search_filename );
            if ( file_exists ( $_search_path ) && is_dir ( $search_path ) ) {
                if ( $_search_path == "/" ) {
                    throw new \Exception( "Unable to directly search for the corresponding file in the root directory! Please enter a specific path to start searching in the corresponding directory!" , 0 );
                }
                $_current_directory        = $search_path;
                $_current_directory_object = dir ( $_current_directory );
                if ( $_current_directory_object === false ) {
                    Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'Directory <span style="color:red;">' . $_current_directory . '</span> is not authorized to access, search has skipped this directory' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    return;
                }
                while ( $file = $_current_directory_object->read () ) {
                    Class_Base_Response::check_browser_service_stop ();
                    if ( $file !== false ) {
                        $_current_child_item = ( $_current_directory . "/" . $file );
                        if ( strlen ( $file ) >= $_search_filename_length ) {
                            if ( strpos ( $file , $search_filename ) !== false ) {
                                if ( is_cli () ) {
                                    Class_Base_Response::outputln ( $_current_child_item , ( ( is_dir ( $_current_child_item ) ? "dir" : "file" ) . " : " ) );
                                } else {
                                    Class_Base_Response::output_div_inner_html ( $search_result_id , ( ( is_dir ( $_current_child_item ) ) ? ( '<a href="' . Class_Base_Response::get_url ( "/file/explorer" , array ( "current_directory_path" => $_current_child_item ) ) . '">' ) : ( '<a href="' . Class_Base_Response::get_url ( "/file/detail" , array ( "file_path" => $_current_child_item ) ) . '">' ) ) . ( ( ( is_dir ( $_current_child_item ) ? "dir" : "file" ) . " : " ) . $_current_child_item ) . ( '</a>' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                }
                            }
                        }
                        if ( is_dir ( $_current_child_item ) && ( $_current_child_item != ( $_current_directory . "/." ) ) && ( $_current_child_item != ( $_current_directory . "/.." ) ) ) {
                            $_current_child_directory = ( $_current_directory . "/" . $file );
                            if ( is_cli () ) {
                            } else {
                                Class_Base_Response::output_div_inner_html ( $search_progress_id , ( '<a href="' . Class_Base_Response::get_url ( "/file/explorer" , array ( "current_directory_path" => $_current_child_directory ) ) . '">' . "dir : " . $_current_child_directory . '</a>' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                            }
                            self::search_file ( $_current_child_directory , $search_filename , $search_progress_id , $search_errors_id , $search_result_id , $usleep );
                        } else if ( is_file ( $_current_child_item ) ) {
                            $_current_child_file = ( $_current_directory . "/" . $file );
                            if ( is_cli () ) {
                            } else {
                                Class_Base_Response::output_div_inner_html ( $search_progress_id , ( '<a href="' . Class_Base_Response::get_url ( "/file/detail" , array ( "file_path" => $_current_child_file ) ) . '">' . "file : " . $_current_child_file . '</a>' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                            }
                        }
                        usleep ( $usleep );
                    }
                }
            }
        }

    }

    public static function explorer ( $current_directory_path , $search_progress_id , $search_errors_id , $search_result_id , $directory_uri , $file_uri , $uri_params = array ( "directory_field_name" => "current_directory_path" , "file_field_name" => "current_file_path" ) , $debug = 0 )
    {
        if ( is_string ( $current_directory_path ) && ( strlen ( $current_directory_path ) > 0 ) && ( ( is_string ( $directory_uri ) ) && ( is_string ( $file_uri ) ) ) && ( is_array ( $uri_params ) ) && ( isset( $uri_params[ "directory_field_name" ] ) ) && ( is_string ( $uri_params[ "directory_field_name" ] ) ) && ( isset( $uri_params[ "file_field_name" ] ) ) && ( is_string ( $uri_params[ "file_field_name" ] ) ) ) {
            $current_directory_path = str_replace ( "\\" , "/" , $current_directory_path );
            $directory_uri          = str_replace ( "\\" , "/" , $directory_uri );
            $file_uri               = str_replace ( "\\" , "/" , $file_uri );
            if ( ! Class_Base_Format::is_field_name ( $uri_params[ "directory_field_name" ] ) ) {
                throw new \Exception( ( "directory_field_name is error , directory_field_name : " . print_r ( $uri_params[ "directory_field_name" ] , true ) ) , 0 );
            }
            if ( ! Class_Base_Format::is_field_name ( $uri_params[ "file_field_name" ] ) ) {
                throw new \Exception( ( "file_field_name is error , file_field_name : " . print_r ( $uri_params[ "file_field_name" ] , true ) ) , 0 );
            }
            if ( file_exists ( $current_directory_path ) && is_dir ( $current_directory_path ) ) {
                Class_Base_Response::output_div_inner_html ( $search_progress_id , "current directory : " . $current_directory_path , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                $_current_directory_object = dir ( $current_directory_path );
                if ( $_current_directory_object === false ) {
                    Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'Errors : Directory <span style="color:red;">' . $current_directory_path . '</span> is not authorized to access, search has skipped this directory' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    return;
                }
                while ( $file = $_current_directory_object->read () ) {
                    if ( $file === false ) {
                        continue;
                    }
                    $_current_child_item = ( $current_directory_path . "/" . $file );
                    if ( is_dir ( $_current_child_item ) && ( $_current_child_item != ( $current_directory_path . "/." ) ) && ( $_current_child_item != ( $current_directory_path . "/.." ) ) ) {
                        if ( substr ( $current_directory_path , ( strlen ( $current_directory_path ) - 1 ) , 1 ) != "/" ) {
                            $_current_child_directory = ( $current_directory_path . "/" . $file );
                        } else {
                            $_current_child_directory = ( $current_directory_path . $file );
                        }
                        if ( is_cli () ) {
                        } else {
                            Class_Base_Response::output_div_inner_html ( $search_result_id , 'current directory child directory : <a href="' . Class_Base_Response::get_url ( $directory_uri , array ( $uri_params[ "directory_field_name" ] => $_current_child_directory ) ) . '">' . $_current_child_directory . '</a>' , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        }
                    } else if ( is_file ( $_current_child_item ) ) {
                        if ( substr ( $current_directory_path , ( strlen ( $current_directory_path ) - 1 ) , 1 ) != "/" ) {
                            $_current_child_file = ( $current_directory_path . "/" . $file );
                        } else {
                            $_current_child_file = ( $current_directory_path . $file );
                        }
                        if ( is_cli () ) {
                        } else {
                            Class_Base_Response::output_div_inner_html ( $search_result_id , 'current directory child file : <a href="' . Class_Base_Response::get_url ( $file_uri , array ( $uri_params[ "file_field_name" ] => $_current_child_file ) ) . '">' . $_current_child_file . '</a>' , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                        }
                    }
                }
            }
        }
    }

    public static function get_file_info ( $file_path , $file_content_read_offset = 0 , $data_type = Class_Base_File::TYPE_DATA_BIN )
    {
        $_file_info = Class_Base_File::get_file_info ( $file_path , $file_content_read_offset , $data_type );
        return $_file_info;
    }

    public static function create_file ( $current_directory_path , $file_name , $data_type , $file_content , $file_size_limit = Class_Base_File::SIZE_FILE_CONTENT_LIMIT , $debug = 0 )
    {
        $_create_info = Class_Base_File::create_file ( $current_directory_path , $file_name , $data_type , $file_content , $file_size_limit , $debug );
        return $_create_info;
    }

    public static function update_file ( $file_path , $file_content , $data_type , $file_size_limit = Class_Base_File::SIZE_FILE_CONTENT_LIMIT , $debug = 0 )
    {
        $_update_info = Class_Base_File::update_file ( $file_path , $file_content , $data_type , $file_size_limit , $debug );
        return $_update_info;
    }

    public static function delete_file ( $file_path , $file_size_limit = Class_Base_File::SIZE_FILE_CONTENT_LIMIT , $debug = 0 )
    {
        $_delete_info = Class_Base_File::delete_file ( $file_path , $file_size_limit , $debug );
        return $_delete_info;
    }

    public static function clear_file ( $search_path , $search_filename , $search_progress_id , $search_errors_id , $search_result_id , $usleep = 100 , $debug = 0 )
    {
        if ( ! is_integer ( $usleep ) ) {
            $usleep = 100;
        }
        if ( is_string ( $search_path ) && ( is_string ( $search_filename ) ) ) {
            $_search_path            = str_replace ( "\\" , "/" , $search_path );
            $_search_filename_length = strlen ( $search_filename );
            if ( file_exists ( $_search_path ) && is_dir ( $search_path ) ) {
                if ( $_search_path == "/" ) {
                    throw new \Exception( "Unable to directly search for the corresponding file in the root directory! Please enter a specific path to start searching in the corresponding directory!" , 0 );
                }
                $_current_directory        = $search_path;
                $_current_directory_object = dir ( $_current_directory );
                if ( $_current_directory_object === false ) {
                    Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'Directory <span style="color:red;">' . $_current_directory . '</span> is not authorized to access, search has skipped this directory' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                    return;
                }
                while ( $file = $_current_directory_object->read () ) {
                    Class_Base_Response::check_browser_service_stop ();
                    if ( $file !== false ) {
                        $_current_child_item = ( $_current_directory . "/" . $file );
                        if ( strlen ( $file ) >= $_search_filename_length ) {
                            if ( strpos ( $file , $search_filename ) !== false ) {
                                if ( Class_Base_File::is_permission ( $_current_child_item ) ) {
                                    try {
                                        $_file_info = Class_Base_File::delete_file ( $_current_child_item , ( Class_Base_File::SIZE_FILE_CONTENT_LIMIT * 10 ) , $debug );
                                        if ( $_file_info !== false ) {
                                            if ( is_cli () ) {
                                                Class_Base_Response::outputln ( $_current_child_item , ( ( is_dir ( $_current_child_item ) ? "dir" : "file" ) . " : " ) );
                                            } else {
                                                Class_Base_Response::output_div_inner_html ( $search_result_id , ( ( "The file has been successfully deleted ! File path : " ) . $_current_child_item ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                            }
                                        } else {
                                            Class_Base_Response::output_div_inner_html ( $search_errors_id , ( '<span style="color:red;">' . ( "The deletion of the target file failed. You may not have permission to clear it ! Please contact the server administrator promptly for communication and resolution ! Destination file path : " ) . $_current_child_item . '</span>' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                        }
                                    } catch ( \Exception $e ) {
                                        if ( $e->getCode () == Class_Base_Error::FILE_EXCEPTION_DELETE ) {
                                            Class_Base_Response::output_div_inner_html ( $search_errors_id , ( '<span style="color:red;">' . ( "The deletion of the target file failed. You may not have permission to clear it ! This may be caused by reasons such as the size of the target file exceeding the security limit ! Please contact the server administrator promptly for communication and resolution ! Destination file path : " ) . $_current_child_item . '</span>' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                        } else {
                                            throw $e;
                                        }
                                    }
                                } else {
                                    Class_Base_Response::output_div_inner_html ( $search_errors_id , ( '<span style="color:red;">' . ( "The target file may be a directory or cannot be deleted due to security restrictions or other reasons ! Please contact the server administrator promptly for communication and resolution ! Target path : " ) . $_current_child_item . '</span>' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                }
                            }
                        }
                        if ( is_dir ( $_current_child_item ) && ( $_current_child_item != ( $_current_directory . "/." ) ) && ( $_current_child_item != ( $_current_directory . "/.." ) ) ) {
                            $_current_child_directory = ( $_current_directory . "/" . $file );
                            if ( is_cli () ) {
                            } else {
                                Class_Base_Response::output_div_inner_html ( $search_progress_id , ( "dir : " . $_current_child_directory ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                            }
                            self::clear_file ( $_current_child_directory , $search_filename , $search_progress_id , $search_errors_id , $search_result_id , $usleep );
                        } else if ( is_file ( $_current_child_item ) ) {
                            $_current_child_file = ( $_current_directory . "/" . $file );
                            if ( is_cli () ) {
                            } else {
                                Class_Base_Response::output_div_inner_html ( $search_progress_id , ( "file : " . $_current_child_file ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                            }
                        }
                        usleep ( $usleep );
                    }
                }
            }
        }

    }
}