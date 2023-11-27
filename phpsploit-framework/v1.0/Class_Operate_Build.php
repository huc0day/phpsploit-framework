<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-6-3
 * Time: 下午8:16
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

class Class_Operate_Build
{
    private static $_current_file             = null;
    private static $_current_directory        = null;
    private static $_current_directory_object = null;
    private static $_current_new_file         = null;
    private static $_base_interfaces          = array (
        'Interface_Root' ,
        'Interface_Base' ,
        'Interface_Operate' ,
        'Interface_Controller' ,
        'Interface_View' ,
        'Interface_Main' ,
        'Interface_Base_Error' ,
        'Interface_Base_Exception' ,
        'Interface_Base_Request' ,
        'Interface_Base_Response' ,
        'Interface_Base_Memory' ,
        'Interface_Base_BlockName' ,
        'Interface_Base_BlockKey' ,
        'Interface_Base_BlockSize' ,
        'Interface_Base_BlockStatus' ,
        'Interface_Base_BlockMode' ,
        'Interface_Base_BlockType' ,
        'Interface_Base_BlockContentType' ,
        'Interface_Base_BlockReserved' ,
        'Interface_Base_BlockHeadEndFlag' ,
        'Interface_Base_BlockHead' ,
        'Interface_Base_BlockContent' ,
        'Interface_Base_BlockEndFlag' ,
        'Interface_Base_Block' ,
        'Interface_Base_Block_IndexesItem' ,
        'Interface_Base_Block_UniqueIndex' ,
        'Interface_Base_Block_Indexes' ,
        'Interface_Base_FormatType' ,
        'Interface_Base_Format' ,
        'Interface_Base_Document' ,
        'Interface_Base_Socket' ,
        'Interface_Base_RawSocket' ,
        'Interface_Base_Security' ,
        'Interface_Operate_User' ,
        'Interface_Base_Lock' ,
        'Interface_Base_File' ,
    );

    private static $_base_classes = array (
        'Class_Root' ,
        'Class_Base' ,
        'Class_Operate' ,
        'Class_Controller' ,
        'Class_View' ,
        'Class_Main' ,
        'Class_Base_Error' ,
        'Class_Base_Exception' ,
        'Class_Base_Extension' ,
        'Class_Base_Request' ,
        'Class_Base_Response' ,
        'Class_Base_Format' ,
        'Class_Base_Memory' ,
        'Class_Base_Block' ,
        'Class_Base_Document' ,
    );

    public static function get_current_file ()
    {
        return self::$_current_file = __FILE__;
    }

    public static function get_current_directory ()
    {
        return self::$_current_directory = dirname ( __FILE__ );
    }

    public static function get_current_directory_object ()
    {
        if ( ( empty( self::$_current_directory_object ) ) || ( ! is_object ( self::$_current_directory_object ) ) ) {
            $_current_directory              = self::get_current_directory ();
            self::$_current_directory_object = dir ( $_current_directory );
        }
        return self::$_current_directory_object;
    }

    public static function create_current_directory_object ()
    {
        if ( ( ! empty( self::$_current_directory_object ) ) || ( is_object ( self::$_current_directory_object ) ) ) {
            self::$_current_directory_object = null;
        }
        $_current_directory              = self::get_current_directory ();
        self::$_current_directory_object = dir ( $_current_directory );
        return self::$_current_directory_object;
    }

    public static function clear_current_directory_object ()
    {
        self::$_current_directory_object = null;
        return self::$_current_directory_object;
    }

    public static function get_new_file_name ( $type_string = "lite" )
    {
        if ( ( $type_string != "lite" ) && ( $type_string != "full" ) ) {
            $type_string = "lite";
        }
        $_new_file_name = ( ( "build_" ) . ( $type_string ) . ( "_" ) . ( ( time () . rand ( 10000000 , 99999999 ) ) . chr ( 46 ) . ( "phpsploit" ) . chr ( 46 ) . ( "php" ) ) );
        return $_new_file_name;
    }

    public static function get_new_file_path ( $type_string = "lite" )
    {
        $_new_file_name = ( ( self::get_current_directory () ) . chr ( 47 ) . ( self::get_new_file_name ( $type_string ) ) );
        return $_new_file_name;
    }

    public static function exist_new_file ()
    {
        if ( ( is_string ( self::$_current_new_file ) ) && ( strlen ( self::$_current_new_file ) > 0 ) ) {
            if ( file_exists ( self::$_current_new_file ) && is_file ( self::$_current_new_file ) ) {
                return true;
            }
        }
        return false;
    }

    public static function get_file_list ()
    {
        $_file_list                = array ();
        $_current_directory        = self::get_current_directory ();
        $_current_directory_object = self::get_current_directory_object ();
        if ( $_current_directory_object !== false ) {
            while ( $_current_directory_file_name = $_current_directory_object->read () ) {
                $_current_directory_file = ( $_current_directory . chr ( 47 ) . $_current_directory_file_name );
                if ( file_exists ( $_current_directory_file ) && is_file ( $_current_directory_file ) ) {
                    $_file_list[] = $_current_directory_file;
                }
            }
        }
        return $_file_list;
    }

    public static function get_class_or_interface_name_in_file_path ( $file_path )
    {
        if ( ( ! is_string ( $file_path ) ) || ( strlen ( $file_path ) <= 0 ) ) {
            throw new \Exception( ( "The file_path is not a string, or the length of the file_path is less than or equal to 0 , file_path : " . print_r ( $file_path , true ) ) , 0 );
        }
        $file_path                     = str_replace ( "\\" , "/" , $file_path );
        $_file_path_length             = strlen ( $file_path );
        $_file_path_separator_position = false;
        $_file_name_separator_position = false;
        for ( $index = ( $_file_path_length - 1 ) ; $index >= 0 ; $index -- ) {
            $_char = substr ( $file_path , $index , 1 );
            if ( $_char == "/" ) {
                $_file_path_separator_position = $index;
                break;
            }
        }
        for ( $index = ( $_file_path_length - 1 ) ; $index >= 0 ; $index -- ) {
            $_char = substr ( $file_path , $index , 1 );
            if ( $_char == "." ) {
                $_file_name_separator_position = $index;
                break;
            }
        }
        $_class_or_interface_name_start_position = 0;
        $_class_or_interface_name_end_position   = ( $_file_path_length - 1 );
        if ( ( $_file_path_separator_position !== false ) && ( ( $_file_path_separator_position + 1 ) < $_file_path_length ) ) {
            $_class_or_interface_name_start_position = ( $_file_path_separator_position + 1 );
        }
        if ( ( $_file_name_separator_position !== false ) && ( $_file_name_separator_position < $_file_path_length ) ) {
            $_class_or_interface_name_end_position = $_file_name_separator_position;
        }
        $_file_name = substr ( $file_path , $_class_or_interface_name_start_position , ( $_class_or_interface_name_end_position - $_class_or_interface_name_start_position ) );
        return $_file_name;
    }

    public static function init_new_file ( $current_new_file )
    {
        if ( ( ! is_string ( $current_new_file ) ) || ( strlen ( $current_new_file ) <= 0 ) ) {
            throw new \Exception( ( "The current_new_file is not a string, or the length of the current_new_file is less than or equal to 0 , current_new_file : " . print_r ( $current_new_file , true ) ) , 0 );
        }
        if ( ! file_exists ( $current_new_file ) ) {
            $_tmp_file_point = @fopen ( $current_new_file , "w+" );
            if ( ! empty( $_tmp_file_point ) ) {
                fwrite ( $_tmp_file_point , "<?php\n" );
                @fclose ( $_tmp_file_point );
            } else {
                throw new \Exception( "file " . $current_new_file . " is init error" , 0 );
            }
        }
    }

    public static function is_default_pivilege_user_password ()
    {
        if ( ( ! defined ( "PRIVILEGE_USER_MODULE_USER" ) ) || ( empty( PRIVILEGE_USER_MODULE_USER ) ) ) {
            return true;
        }
        if ( ( ! defined ( "PRIVILEGE_USER_MODULE_PASSWORD" ) ) || ( empty( PRIVILEGE_USER_MODULE_PASSWORD ) ) ) {
            return true;
        }
        if ( ( PRIVILEGE_USER_MODULE_USER != "38305ac7e5f1b870f6e92aef5e281b2d" ) && ( PRIVILEGE_USER_MODULE_PASSWORD != "6f02faa1775d964e58b227e0ef3fa7fd" ) ) {
            return false;
        }
        return true;
    }

    public static function is_build_envement ()
    {
        $_current_directory   = self::get_current_directory ();
        $_interface_root      = "Interface_Root";
        $_class_root          = "Class_Root";
        $_interface_root_file = ( $_current_directory . '/' . $_interface_root . '.php' );
        $_class_root_file     = ( $_current_directory . '/' . $_class_root . '.php' );
        if ( ( file_exists ( $_interface_root_file ) && ( is_file ( $_interface_root_file ) ) ) && ( file_exists ( $_class_root_file ) && ( is_file ( $_class_root_file ) ) ) ) {
            return true;
        }
        return false;
    }

    public static function create_new_full_file ( $show_result_id = "show_result_id" , $show_error_id = "show_error_id" )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( self::is_default_pivilege_user_password () ) {
            if ( is_cli () ) {
                Class_Base_Response::outputln ( "\n" . ( 'Your current Phpsploit Framework software privilege account and its password content are still in an initialized state. Using an initial account and password to build a project poses significant security risks! For security reasons, the authors of the Phpsploit framework software prohibit the use of initial privileged accounts and passwords to build project files in the design of the Phpsploit framework software! Before building the project file, you need to modify the contents of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You can dynamically create and output new privileged account and password information using the "/user/create_production_privilege_user_password" interface! Note that the \'/user/create_production_privilege_user_password\' interface only outputs new privileged account and password information and does not truly change the values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You need to manually override the initial values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'at the code level, which are typically located in Phpsploit Framework software project directory  of \' index.php \'file .' ) . "\n" );
            } else {
                Class_Base_Response::output_textarea_inner_html ( $show_error_id , ( "\n" . ( 'Your current Phpsploit Framework software privilege account and its password content are still in an initialized state. Using an initial account and password to build a project poses significant security risks! For security reasons, the authors of the Phpsploit framework software prohibit the use of initial privileged accounts and passwords to build project files in the design of the Phpsploit framework software! Before building the project file, you need to modify the contents of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You can dynamically create and output new privileged account and password information using the "/user/create_production_privilege_user_password" interface! Note that the \'/user/create_production_privilege_user_password\' interface only outputs new privileged account and password information and does not truly change the values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You need to manually override the initial values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'at the code level, which are typically located in Phpsploit Framework software project directory  of \' index.php \'file .' ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            }
            return false;
        }
        if ( ! self::is_build_envement () ) {
            if ( is_cli () ) {
                Class_Base_Response::outputln ( "\n" . ( 'The phpsploit-framework software is in a non development environment and cannot build project files!' ) . "\n" );
            } else {
                Class_Base_Response::output_textarea_inner_html ( $show_error_id , ( "\n" . ( 'The phpsploit-framework software is in a non development environment and cannot build project files!' ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            }
            return false;
        }
        $_write_length = 0;
        if ( ! self::exist_new_file () ) {
            $_current_new_file = self::get_new_file_path ( "full" );
            if ( ! file_exists ( $_current_new_file ) ) {
                self::init_new_file ( $_current_new_file );
                self::create_new_file_in_extend_bases ( $_current_new_file , $_write_length , $show_result_id , $show_error_id );
                $_file_list = self::get_file_list ();
                if ( ( ! empty( $_file_list ) ) && ( is_array ( $_file_list ) ) ) {
                    foreach ( $_file_list as $index => $file_path ) {
                        $file_path                = str_replace ( "\\" , "/" , $file_path );
                        $_file_path_length        = strlen ( $file_path );
                        $_class_or_interface_name = self::get_class_or_interface_name_in_file_path ( $file_path );
                        if ( strcmp ( $_SERVER[ "SCRIPT_FILENAME" ] , $file_path ) != 0 ) {
                            $_file_path_separator_position = strripos ( $file_path , "/" );
                            if ( ( $_file_path_separator_position !== false ) && ( ( $_file_path_separator_position + 1 ) != $_file_path_length ) && ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 10 ) && ( ( substr ( $file_path , ( $_file_path_separator_position + 1 ) , 6 ) == "Class_" ) || ( substr ( $file_path , ( $_file_path_separator_position + 1 ) , 10 ) == "Interface_" ) ) && ( substr ( $file_path , - 4 , 4 ) == ".php" ) && ( ! in_array ( $_class_or_interface_name , self::$_base_interfaces ) ) && ( ! in_array ( $_class_or_interface_name , self::$_base_classes ) ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) ) {
                                $_file_size = filesize ( $file_path );
                                if ( ( $_file_size > 0 ) && ( $_file_size <= ( 1024 * 1024 * 10 ) ) ) {
                                    $_file_content        = @file_get_contents ( $file_path );
                                    $_file_content        = str_replace ( "<?php\n" , "" , $_file_content );
                                    $_file_content_length = strlen ( $_file_content );
                                    if ( ( $_file_content !== false ) && ( ! is_null ( $_file_content ) ) && ( is_string ( $_file_content ) ) && ( $_file_content_length > 0 ) ) {
                                        $_file_write_length = file_put_contents ( $_current_new_file , ( "\n" . $_file_content . "\n" ) , FILE_APPEND | LOCK_EX );
                                        if ( $_file_write_length !== false ) {
                                            $_write_length += $_file_write_length;
                                            if ( is_cli () ) {
                                                Class_Base_Response::outputln ( "\n" . ( 'Read ' . $_file_content_length . ' bytes from file ' . $file_path . ' and append them to file ' . $_current_new_file ) . "\n" );
                                            } else {
                                                Class_Base_Response::output_textarea_inner_html ( $show_result_id , ( "\n" . 'Read ' . $_file_content_length . ' bytes from file ' . $file_path . ' and append them to file ' . $_current_new_file . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                            }
                                        }
                                    }
                                }

                            } else {
                                if ( ( strcmp ( $_SERVER[ "SCRIPT_FILENAME" ] , $file_path ) != 0 ) && ( $file_path != $_current_new_file ) && ( ! in_array ( $_class_or_interface_name , self::$_base_interfaces ) ) && ( ! in_array ( $_class_or_interface_name , self::$_base_classes ) ) ) {
                                    if ( is_cli () ) {
                                        Class_Base_Response::outputln ( "\n" . ( $file_path . ' is not exist , or ' . $file_path . ' is not a php class and php interface file' ) . "\n" );
                                    } else {
                                        Class_Base_Response::output_textarea_inner_html ( $show_error_id , ( "\n" . $file_path . ' is not exist , or ' . $file_path . ' is not a php class and php interface file' . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                    }
                                }
                            }
                        }
                    }
                    self::read_index_file_to_append_project_file ( $_current_new_file , $_write_length , $show_result_id , $show_error_id );
                    if ( file_exists ( $_current_new_file ) && is_file ( $_current_new_file ) ) {
                        if ( empty( self::$_current_new_file ) ) {
                            self::$_current_new_file = $_current_new_file;
                        }
                    }
                }
            }
        }
        if ( ( ! empty( $_write_length ) ) && ( ! empty( self::$_current_new_file ) ) ) {
            return self::$_current_new_file;
        }
        return false;
    }

    public static function create_new_lite_file ( $show_result_id = "show_result_id" , $show_error_id = "show_error_id" )
    {
        if ( is_cli () ) {
            global $_SERVER;
            if ( ! is_array ( $_SERVER ) ) {
                $_SERVER = array ();
            }
        }
        if ( self::is_default_pivilege_user_password () ) {
            if ( is_cli () ) {
                Class_Base_Response::outputln ( "\n" . ( 'Your current Phpsploit Framework software privilege account and its password content are still in an initialized state. Using an initial account and password to build a project poses significant security risks! For security reasons, the authors of the Phpsploit framework software prohibit the use of initial privileged accounts and passwords to build project files in the design of the Phpsploit framework software! Before building the project file, you need to modify the contents of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You can dynamically create and output new privileged account and password information using the "/user/create_production_privilege_user_password" interface! Note that the \'/user/create_production_privilege_user_password\' interface only outputs new privileged account and password information and does not truly change the values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You need to manually override the initial values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'at the code level, which are typically located in Phpsploit Framework software project directory  of \' index.php \'file .' ) . "\n" );
            } else {
                Class_Base_Response::output_textarea_inner_html ( $show_error_id , ( "\n" . ( 'Your current Phpsploit Framework software privilege account and its password content are still in an initialized state. Using an initial account and password to build a project poses significant security risks! For security reasons, the authors of the Phpsploit framework software prohibit the use of initial privileged accounts and passwords to build project files in the design of the Phpsploit framework software! Before building the project file, you need to modify the contents of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You can dynamically create and output new privileged account and password information using the "/user/create_production_privilege_user_password" interface! Note that the \'/user/create_production_privilege_user_password\' interface only outputs new privileged account and password information and does not truly change the values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'! You need to manually override the initial values of the constants\' PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD \'at the code level, which are typically located in Phpsploit Framework software project directory  of \' index.php \'file .' ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            }
            return false;
        }
        if ( ! self::is_build_envement () ) {
            if ( is_cli () ) {
                Class_Base_Response::outputln ( "\n" . ( 'The phpsploit-framework software is in a non development environment and cannot build project files!' ) . "\n" );
            } else {
                Class_Base_Response::output_textarea_inner_html ( $show_error_id , ( "\n" . ( 'The phpsploit-framework software is in a non development environment and cannot build project files!' ) . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            }
            return false;
        }
        $_write_length = 0;
        if ( ! self::exist_new_file () ) {
            $_current_new_file = self::get_new_file_path ( "lite" );
            if ( ! file_exists ( $_current_new_file ) ) {
                self::init_new_file ( $_current_new_file );
                self::create_new_file_in_extend_bases ( $_current_new_file , $_write_length , $show_result_id , $show_error_id );
                $_file_list = self::get_file_list ();
                if ( ( ! empty( $_file_list ) ) && ( is_array ( $_file_list ) ) ) {
                    foreach ( $_file_list as $index => $file_path ) {
                        $file_path                = str_replace ( "\\" , "/" , $file_path );
                        $_file_path_length        = strlen ( $file_path );
                        $_class_or_interface_name = self::get_class_or_interface_name_in_file_path ( $file_path );
                        if ( strcmp ( $_SERVER[ "SCRIPT_FILENAME" ] , $file_path ) != 0 ) {
                            $_file_path_separator_position = strripos ( $file_path , "/" );
                            if ( ( $_file_path_separator_position !== false ) && ( ( $_file_path_separator_position + 1 ) != $_file_path_length ) && ( is_string ( $file_path ) ) && ( strlen ( $file_path ) > 10 ) && ( ( substr ( $file_path , ( $_file_path_separator_position + 1 ) , 6 ) == "Class_" ) || ( substr ( $file_path , ( $_file_path_separator_position + 1 ) , 10 ) == "Interface_" ) ) && ( substr ( $file_path , - 4 , 4 ) == ".php" ) && ( ! in_array ( $_class_or_interface_name , self::$_base_interfaces ) ) && ( ! in_array ( $_class_or_interface_name , self::$_base_classes ) ) && ( file_exists ( $file_path ) ) && ( is_file ( $file_path ) ) ) {
                                $_file_name = basename ( $file_path );
                                if ( ( strpos ( $_file_name , "Class_Controller_Guide" ) === false ) && ( strpos ( $_file_name , "Class_Controller_PenetrationTestCommands" ) === false ) ) {
                                    $_file_size = filesize ( $file_path );
                                    if ( ( $_file_size > 0 ) && ( $_file_size <= ( 1024 * 1024 * 10 ) ) ) {
                                        $_file_content        = @file_get_contents ( $file_path );
                                        $_file_content        = str_replace ( "<?php\n" , "" , $_file_content );
                                        $_file_content_length = strlen ( $_file_content );
                                        if ( ( $_file_content !== false ) && ( ! is_null ( $_file_content ) ) && ( is_string ( $_file_content ) ) && ( $_file_content_length > 0 ) ) {
                                            $_file_write_length = file_put_contents ( $_current_new_file , ( "\n" . $_file_content . "\n" ) , FILE_APPEND | LOCK_EX );
                                            if ( $_file_write_length !== false ) {
                                                $_write_length += $_file_write_length;
                                                if ( is_cli () ) {
                                                    Class_Base_Response::outputln ( "\n" . ( 'Read ' . $_file_content_length . ' bytes from file ' . $file_path . ' and append them to file ' . $_current_new_file ) . "\n" );
                                                } else {
                                                    Class_Base_Response::output_textarea_inner_html ( $show_result_id , ( "\n" . 'Read ' . $_file_content_length . ' bytes from file ' . $file_path . ' and append them to file ' . $_current_new_file . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                                }
                                            }
                                        }
                                    }
                                }

                            } else {
                                if ( ( strcmp ( $_SERVER[ "SCRIPT_FILENAME" ] , $file_path ) != 0 ) && ( $file_path != $_current_new_file ) && ( ! in_array ( $_class_or_interface_name , self::$_base_interfaces ) ) && ( ! in_array ( $_class_or_interface_name , self::$_base_classes ) ) ) {
                                    if ( is_cli () ) {
                                        Class_Base_Response::outputln ( "\n" . ( $file_path . ' is not exist , or ' . $file_path . ' is not a php class and php interface file' ) . "\n" );
                                    } else {
                                        Class_Base_Response::output_textarea_inner_html ( $show_error_id , ( "\n" . $file_path . ' is not exist , or ' . $file_path . ' is not a php class and php interface file' . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                                    }
                                }
                            }
                        }
                    }
                    self::read_index_file_to_append_project_file ( $_current_new_file , $_write_length , $show_result_id , $show_error_id );
                    if ( file_exists ( $_current_new_file ) && is_file ( $_current_new_file ) ) {
                        if ( empty( self::$_current_new_file ) ) {
                            self::$_current_new_file = $_current_new_file;
                        }
                    }
                }
            }
        }
        if ( ( ! empty( $_write_length ) ) && ( ! empty( self::$_current_new_file ) ) ) {
            return self::$_current_new_file;
        }
        return false;
    }

    public static function create_new_file_in_extend_bases ( $current_new_file , &$write_length , $show_result_id = "show_result_id" , $show_error_id = "show_error_id" )
    {
        self::read_interface_files_to_append_project_file ( $current_new_file , $write_length , $show_result_id , $show_error_id );

        self::read_class_files_to_append_project_file ( $current_new_file , $write_length , $show_result_id , $show_error_id );

        if ( ! empty( $write_length ) ) {
            return $current_new_file;
        }

        return false;
    }

    public static function read_interface_files_to_append_project_file ( $current_new_file , &$write_length , $show_result_id , $show_error_id )
    {
        foreach ( self::$_base_interfaces as $index => $interface_name ) {
            self::read_interface_file_to_append_project_file_by_interface_name ( $interface_name , $current_new_file , $write_length , $show_result_id , $show_error_id );
        }
    }

    public static function read_class_files_to_append_project_file ( $current_new_file , &$write_length , $show_result_id , $show_error_id )
    {
        foreach ( self::$_base_classes as $index => $class_name ) {
            self::read_class_file_to_append_project_file_by_class_name ( $class_name , $current_new_file , $write_length , $show_result_id , $show_error_id );
        }
    }

    public static function read_index_file_to_append_project_file ( $current_new_file , &$write_length , $show_result_id , $show_error_id )
    {
        $_index_name = 'index';
        self::read_index_file_to_append_project_file_by_index_name ( $_index_name , $current_new_file , $write_length , $show_result_id , $show_error_id );
    }

    public static function read_interface_file_to_append_project_file_by_interface_name ( $interface_name , $current_new_file , &$write_length , $show_result_id = "show_result_id" , $show_error_id = "show_error_id" )
    {
        if ( ! is_integer ( $write_length ) ) {
            $write_length = 0;
        }
        $_current_directory = self::get_current_directory ();
        $_interface_file    = ( $_current_directory . chr ( 47 ) . $interface_name . ( ".php" ) );
        if ( ( ! file_exists ( $_interface_file ) ) || ( ! is_file ( $_interface_file ) ) ) {
            throw new \Exception( "Interface file " . $_interface_file . " is not exist , or " . $_interface_file . " is not a file ! " , 0 );
        } else {
            $_file_content        = @file_get_contents ( $_interface_file );
            $_file_content        = str_replace ( "<?php\n" , "" , $_file_content );
            $_file_content_length = strlen ( $_file_content );
            $_file_write_length   = file_put_contents ( $current_new_file , ( "\n" . $_file_content . "\n" ) , FILE_APPEND | LOCK_EX );
            if ( $_file_write_length !== false ) {
                $write_length += $_file_write_length;
                if ( is_cli () ) {
                    Class_Base_Response::outputln ( "\n" . ( 'Read ' . $_file_content_length . ' bytes from file ' . $_interface_file . ' and append them to file ' . $current_new_file ) . "\n" );
                } else {
                    Class_Base_Response::output_textarea_inner_html ( $show_result_id , ( "\n" . 'Read ' . $_file_content_length . ' bytes from file ' . $_interface_file . ' and append them to file ' . $current_new_file . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                }
            }
        }
    }

    public static function read_class_file_to_append_project_file_by_class_name ( $class_name , $current_new_file , &$write_length , $show_result_id = "show_result_id" , $show_error_id = "show_error_id" )
    {
        if ( ! is_integer ( $write_length ) ) {
            $write_length = 0;
        }
        $_current_directory = self::get_current_directory ();
        $_class_file        = ( $_current_directory . chr ( 47 ) . $class_name . ( ".php" ) );
        if ( ( ! file_exists ( $_class_file ) ) || ( ! is_file ( $_class_file ) ) ) {
            throw new \Exception( "Class file " . $_class_file . " is not exist , or " . $_class_file . " is not a file ! " , 0 );
        } else {
            $_file_content        = @file_get_contents ( $_class_file );
            $_file_content        = str_replace ( "<?php\n" , "" , $_file_content );
            $_file_content_length = strlen ( $_file_content );
            $_file_write_length   = file_put_contents ( $current_new_file , ( "\n" . $_file_content . "\n" ) , FILE_APPEND | LOCK_EX );
            if ( $_file_write_length !== false ) {
                $write_length += $_file_write_length;
                if ( is_cli () ) {
                    Class_Base_Response::outputln ( "\n" . ( 'Read ' . $_file_content_length . ' bytes from file ' . $_class_file . ' and append them to file ' . $current_new_file ) . "\n" );
                } else {
                    Class_Base_Response::output_textarea_inner_html ( $show_result_id , ( "\n" . 'Read ' . $_file_content_length . ' bytes from file ' . $_class_file . ' and append them to file ' . $current_new_file . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                }
            }
        }
    }

    public static function read_index_file_to_append_project_file_by_index_name ( $index_name , $current_new_file , &$write_length , $show_result_id = "show_result_id" , $show_error_id = "show_error_id" )
    {
        if ( ! is_integer ( $write_length ) ) {
            $write_length = 0;
        }
        $_current_directory = self::get_current_directory ();
        $_index_file        = ( $_current_directory . chr ( 47 ) . $index_name . ( ".php" ) );
        if ( ( ! file_exists ( $_index_file ) ) || ( ! is_file ( $_index_file ) ) ) {
            throw new \Exception( "Index file " . $_index_file . " is not exist , or " . $_index_file . " is not a file ! " , 0 );
        } else {
            $_file_content        = @file_get_contents ( $_index_file );
            $_file_content        = str_replace ( "<?php\n" , "" , $_file_content );
            $_file_content_length = strlen ( $_file_content );
            $_file_write_length   = file_put_contents ( $current_new_file , ( "\n" . $_file_content . "\n" ) , FILE_APPEND | LOCK_EX );
            if ( $_file_write_length !== false ) {
                $write_length += $_file_write_length;
                if ( is_cli () ) {
                    Class_Base_Response::outputln ( "\n" . ( 'Read ' . $_file_content_length . ' bytes from file ' . $_index_file . ' and append them to file ' . $current_new_file ) . "\n" );
                } else {
                    Class_Base_Response::output_textarea_inner_html ( $show_result_id , ( "\n" . 'Read ' . $_file_content_length . ' bytes from file ' . $_index_file . ' and append them to file ' . $current_new_file . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                }
            }
        }
    }

    public static function create_new_encode_file ( $input_file_path , $save_directory_path , &$output_file_path , &$encode_key , &$encode_iv_base64 )
    {
        if ( is_string ( $input_file_path ) ) {
            $input_file_path = trim ( $input_file_path );
        }
        if ( is_string ( $save_directory_path ) ) {
            $save_directory_path = trim ( $save_directory_path );
        }
        if ( ( is_string ( $input_file_path ) ) && ( strlen ( $input_file_path ) < 256 ) && ( file_exists ( $input_file_path ) ) && ( is_file ( $input_file_path ) ) ) {
            if ( ( is_string ( $save_directory_path ) ) && ( strlen ( $save_directory_path ) < 256 ) && ( file_exists ( $save_directory_path ) ) && ( is_dir ( $save_directory_path ) ) ) {
                $_new_encode_file_name = ( ( md5 ( time () . rand ( 10000000 , 99999999 ) ) ) . '.phpsploit.encode' );
                $_new_encode_file      = ( $save_directory_path . '/' . $_new_encode_file_name );
                $_input_file_size      = ( filesize ( $input_file_path ) );
                if ( ( $_input_file_size < ( 1024 * 1024 * 100 ) ) ) {
                    $_read_file_pointer = fopen ( $input_file_path , "r" );
                    if ( ! empty( $_read_file_pointer ) ) {
                        $_read_file_content_size   = ( 1024 );
                        $_read_file_content_offset = 0;
                        $_read_file_content        = "";
                        for ( $read_file_content_index = 0 ; $read_file_content_index < $_input_file_size ; $read_file_content_index += $_read_file_content_size ) {
                            $_read_file_content           .= fread ( $_read_file_pointer , 1024 );
                            $_read_file_content_offset    += 1024;
                            $_reand_file_move_offset_flag = fseek ( $_read_file_pointer , $_read_file_content_offset );
                            if ( $_reand_file_move_offset_flag == - 1 ) {
                                fclose ( $_read_file_pointer );
                                break;
                            }
                        }
                        $encode_key           = ( time () . rand ( 100000 , 999999 ) );
                        $encode_iv            = openssl_random_pseudo_bytes ( openssl_cipher_iv_length ( "AES-256-CBC" ) );
                        $encode_iv_base64     = base64_encode ( $encode_iv );
                        $_encode_content      = Class_Base_Security::phpsploit_encode ( $_read_file_content , $encode_key , $encode_iv );
                        $_encode_content_size = strlen ( $_encode_content );
                        if ( ( ! file_exists ( $_new_encode_file ) ) ) {
                            $_write_file_pointer = fopen ( $_new_encode_file , "w" );
                            if ( ( empty( $_write_file_pointer ) ) ) {
                                return false;
                            }
                            $_write_file_content_block_size = ( 1024 );
                            for ( $encode_content_index = 0 ; $encode_content_index < $_encode_content_size ; $encode_content_index += $_write_file_content_block_size ) {
                                $_encode_content_block = substr ( $_encode_content , $encode_content_index , $_write_file_content_block_size );
                                $_bytes                = fwrite ( $_write_file_pointer , $_encode_content_block );
                                if ( $_bytes === false ) {
                                    fclose ( $_write_file_pointer );
                                    return false;
                                }
                            }
                            fclose ( $_write_file_pointer );
                            $output_file_path = $_new_encode_file;
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function create_new_decode_php_file ( $input_file_path , $save_directory_path , &$output_file_path , $encode_key , $encode_iv_base64 )
    {
        if ( is_string ( $input_file_path ) ) {
            $input_file_path = trim ( $input_file_path );
        }
        if ( is_string ( $save_directory_path ) ) {
            $save_directory_path = trim ( $save_directory_path );
        }
        if ( ( ! is_string ( $input_file_path ) ) || ( strlen ( $input_file_path ) < 49 ) || ( substr ( $input_file_path , - 17 , 17 ) != ".phpsploit.encode" ) || ( ! file_exists ( $input_file_path ) ) || ( ! is_file ( $input_file_path ) ) ) {
            return false;
        }
        if ( ( is_string ( $input_file_path ) ) && ( strlen ( $input_file_path ) < 256 ) && ( file_exists ( $input_file_path ) ) && ( is_file ( $input_file_path ) ) ) {
            if ( ( is_string ( $save_directory_path ) ) && ( strlen ( $save_directory_path ) < 256 ) && ( file_exists ( $save_directory_path ) ) && ( is_dir ( $save_directory_path ) ) ) {
                $_new_decode_file_name = ( ( md5 ( time () . rand ( 10000000 , 99999999 ) ) ) . '.phpsploit.php' );
                $_new_decode_file      = ( $save_directory_path . '/' . $_new_decode_file_name );
                $_input_file_size      = ( filesize ( $input_file_path ) );
                if ( ( $_input_file_size < ( 1024 * 1024 * 100 ) ) ) {
                    $_read_file_pointer = fopen ( $input_file_path , "r" );
                    if ( ! empty( $_read_file_pointer ) ) {
                        $_read_file_content_size   = ( 1024 );
                        $_read_file_content_offset = 0;
                        $_read_file_content        = "";
                        for ( $read_file_content_index = 0 ; $read_file_content_index < $_input_file_size ; $read_file_content_index += $_read_file_content_size ) {
                            $_read_file_content           .= fread ( $_read_file_pointer , 1024 );
                            $_read_file_content_offset    += 1024;
                            $_reand_file_move_offset_flag = fseek ( $_read_file_pointer , $_read_file_content_offset );
                            if ( $_reand_file_move_offset_flag == - 1 ) {
                                fclose ( $_read_file_pointer );
                                break;
                            }
                        }
                        $encode_iv            = base64_decode ( $encode_iv_base64 );
                        $_decode_content      = Class_Base_Security::phpsploit_decode ( $_read_file_content , $encode_key , $encode_iv );
                        $_decode_content_size = strlen ( $_decode_content );
                        if ( ( ! file_exists ( $_new_decode_file ) ) ) {
                            $_write_file_pointer = fopen ( $_new_decode_file , "w" );
                            if ( ( empty( $_write_file_pointer ) ) ) {
                                return false;
                            }
                            $_write_file_content_block_size = ( 1024 );
                            for ( $decode_content_index = 0 ; $decode_content_index < $_decode_content_size ; $decode_content_index += $_write_file_content_block_size ) {
                                $_encode_content_block = substr ( $_decode_content , $decode_content_index , $_write_file_content_block_size );
                                $_bytes                = fwrite ( $_write_file_pointer , $_encode_content_block );
                                if ( $_bytes === false ) {
                                    fclose ( $_write_file_pointer );
                                    return false;
                                }
                            }
                            fclose ( $_write_file_pointer );
                            $output_file_path = $_new_decode_file;
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
