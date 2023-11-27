<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-8
 * Time: 下午2:53
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

class Class_Controller_Build extends Class_Controller
{
    const BUILD_TYPE_LITE = 1;
    const BUILD_TYPE_FULL = 2;

    public static function index ( $params = array () )
    {
        $_build_type = Class_Base_Request::form ( "build_type" , Class_Base_Request::TYPE_INTEGER , self::BUILD_TYPE_LITE );
        if ( $_build_type == self::BUILD_TYPE_FULL ) {
            return self::_full ( $params );
        } else {
            return self::_lite ( $params );
        }
    }

    private static function _full ( $params = array () )
    {
        if ( ! is_cli () ) {
            if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
                Class_Base_Response::redirect ( "/login" );
                return null;
            }
            Class_Base_Auth::check_permission ();
            $_show_result_id = "show_result_id";
            $_show_error_id  = "show_error_id";
            $_cli_url        = Class_Base_Response::get_cli_url ( "/build" , array ( "is_build" => 1 , "type" => self::BUILD_TYPE_FULL ) );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Build Project File</div>';
            $_form_top       .= '<div style="width:100%;word-break:break-all;margin-top:16px;padding-left:0;padding-right:0;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is mainly used to create integration project software for the penetration testing target environment (the generated integration project software will include most of the software functions provided by the development testing environment, please note that this functional module can only run normally in the development testing environment). You have two construction modes to choose from, They are "lite" (lean mode) and "full" (full mode), respectively! When conducting penetration testing activities, we prioritize building "lite" (lean mode) project files! "Lite" (lean mode) is relatively small in file size and has the majority of practical penetration testing functions! "Full" (full mode) project files have a larger volume and contain "guide" library modules, which you can find in " Find relevant systems and third-party software commands commonly used in penetration testing and security operation and maintenance processes in the \'guide\' module! Note: that before formally building the project file, you should first modify the initialization content of the "PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD" constants in the "index. php" file in the Phpsploit Framework software project directory, otherwise the project file will not be able to be built properly! Legal constant content information can be obtained by accessing the "/user/create_production_privilege_user_password" interface!</div>';
            $_form           = array (
                "action"    => "/build" ,
                "selects"   => array (
                    array (
                        "id"      => "is_build" ,
                        "title"   => "Build Project : " ,
                        "name"    => "is_build" ,
                        "options" => array (
                            array ( "describe" => "Start Build" , "title" => "Build" , "value" => 1 , "selected" => ( "selected" ) ) ,
                            array ( "describe" => "No Start Build" , "title" => "No Build" , "value" => 0 , ) ,
                        ) ,
                    ) ,
                    array (
                        "id"      => "build_type" ,
                        "title"   => "Build Type : " ,
                        "name"    => "build_type" ,
                        "options" => array (
                            array ( "describe" => "Build Lite" , "title" => "Lite" , "value" => self::BUILD_TYPE_LITE ) ,
                            array ( "describe" => "Build full" , "title" => "Full" , "value" => self::BUILD_TYPE_FULL , "selected" => ( "selected" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"       => $_show_result_id ,
                        "title"    => "( Build Progress )   : " ,
                        "name"     => $_show_result_id ,
                        "value"    => "" ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                    array (
                        "id"       => $_show_error_id ,
                        "title"    => "( Error Message )   : " ,
                        "name"     => $_show_error_id ,
                        "value"    => "" ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
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
                "menu"    => Class_View_Build_Menu::menu ( array () ) ,
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
            Class_Base_Auth::check_permission ();
        }
        $_is_build = Class_Base_Request::form ( "is_build" , Class_Base_Request::TYPE_INTEGER , 0 );
        if ( ! empty( $_is_build ) ) {
            $_new_file_path = Class_Operate_Build::create_new_full_file ();
            if ( $_new_file_path !== false ) {
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $_show_result_id , ( "\n" . 'new file : ' . $_new_file_path . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( ( "\n" . "new file : " . $_new_file_path . "\n" ) );
                }
            }
        }
        return null;
    }

    private static function _lite ( $params = array () )
    {
        if ( ! is_cli () ) {
            if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
                Class_Base_Response::redirect ( "/login" );
                return null;
            }
            Class_Base_Auth::check_permission ();
            $_show_result_id = "show_result_id";
            $_show_error_id  = "show_error_id";
            $_cli_url        = Class_Base_Response::get_cli_url ( "/build" , array ( "is_build" => 1 , "type" => self::BUILD_TYPE_LITE ) );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Build Project File</div>';
            $_form_top       .= '<div style="width:100%;word-break:break-all;margin-top:16px;padding-left:0;padding-right:0;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is mainly used to create integration project software for the penetration testing target environment (the generated integration project software will include most of the software functions provided by the development testing environment, please note that this functional module can only run normally in the development testing environment). You have two construction modes to choose from, They are "lite" (lean mode) and "full" (full mode), respectively! When conducting penetration testing activities, we prioritize building "lite" (lean mode) project files! "Lite" (lean mode) is relatively small in file size and has the majority of practical penetration testing functions! "Full" (full mode) project files have a larger volume and contain "guide" library modules, which you can find in " Find relevant systems and third-party software commands commonly used in penetration testing and security operation and maintenance processes in the \'guide\' module!  Note: that before formally building the project file, you should first modify the initialization content of the "PRIVILEGE_USER_MODULE_USER and PRIVILEGE_USER_MODULE_PASSWORD" constants in the "index. php" file in the Phpsploit Framework software project directory, otherwise the project file will not be able to be built properly! Legal constant content information can be obtained by accessing the "/user/create_production_privilege_user_password" interface!</div>';
            $_form           = array (
                "action"    => "/build" ,
                "selects"   => array (
                    array (
                        "id"      => "is_build" ,
                        "title"   => "Build Project : " ,
                        "name"    => "is_build" ,
                        "options" => array (
                            array ( "describe" => "Start Build" , "title" => "Build" , "value" => 1 , "selected" => ( "selected" ) ) ,
                            array ( "describe" => "No Start Build" , "title" => "No Build" , "value" => 0 , ) ,
                        ) ,
                    ) ,
                    array (
                        "id"      => "build_type" ,
                        "title"   => "Build Type : " ,
                        "name"    => "build_type" ,
                        "options" => array (
                            array ( "describe" => "Build Lite" , "title" => "Lite" , "value" => self::BUILD_TYPE_LITE , "selected" => ( "selected" ) ) ,
                            array ( "describe" => "Build full" , "title" => "Full" , "value" => self::BUILD_TYPE_FULL , ) ,
                        ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"       => $_show_result_id ,
                        "title"    => "( Build Progress )   : " ,
                        "name"     => $_show_result_id ,
                        "value"    => "" ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                    array (
                        "id"       => $_show_error_id ,
                        "title"    => "( Error Message )   : " ,
                        "name"     => $_show_error_id ,
                        "value"    => "" ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
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
                "menu"    => Class_View_Build_Menu::menu ( array () ) ,
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
            Class_Base_Auth::check_permission ();
        }
        $_is_build = Class_Base_Request::form ( "is_build" , Class_Base_Request::TYPE_INTEGER , 0 );
        if ( ! empty( $_is_build ) ) {
            $_new_file_path = Class_Operate_Build::create_new_lite_file ();
            if ( $_new_file_path !== false ) {
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $_show_result_id , ( "\n" . 'new file : ' . $_new_file_path . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( ( "\n" . "new file : " . $_new_file_path . "\n" ) );
                }
            }
        }
        return null;
    }

    public static function encode_build ( $params = array () )
    {
        if ( ! is_cli () ) {
            if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
                Class_Base_Response::redirect ( "/login" );
                return null;
            }
            Class_Base_Auth::check_permission ();
            $_start               = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
            $_input_file_path     = Class_Base_Request::form ( "input_file_path" , Class_Base_Request::TYPE_STRING , "" );
            $_save_directory_path = Class_Base_Request::form ( "save_directory_path" , Class_Base_Request::TYPE_STRING , "" );
            $_output_file_path    = null;
            $_encode_key          = null;
            $_encode_iv           = null;
            $_show_result_id      = "show_result_id";
            $_show_error_id       = "show_error_id";
            $_cli_url             = Class_Base_Response::get_cli_url ( "/encode_build" , array ( "start" => 1 , "is_build" => 1 , "input_file_path" => $_input_file_path , "save_directory_path" => $_save_directory_path ) );
            $_cli_encode_url      = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top            = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Build Encode Project File</div>';
            $_form_top            .= '<div style="width:100%;word-break:break-all;margin-top:16px;padding-left:0;padding-right:0;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This function module is used to read the content of the specified file and encrypt it, while writing the encryption results to the newly created ciphertext file. Tip: If you are creating a ciphertext copy of a PHP type file, you can use the corresponding decryption module function (/decode_build) to restore the ciphertext copy of the PHP type file to a plaintext copy.</div>';
            $_form_name           = "form_0";
            $_form                = array (
                "id"        => $_form_name ,
                "name"      => $_form_name ,
                "action"    => "/encode_build" ,
                "hiddens"   => array (
                    array (
                        "id"    => "start" ,
                        "name"  => "start" ,
                        "value" => 1 ,
                    ) ,
                ) ,
                "selects"   => array (
                    array (
                        "id"      => "is_build" ,
                        "title"   => "Build Project : " ,
                        "name"    => "is_build" ,
                        "options" => array (
                            array ( "describe" => "Start Build" , "title" => "Encode Build" , "value" => 1 , "selected" => ( "selected" ) ) ,
                            array ( "describe" => "No Start Build" , "title" => "No Build" , "value" => 0 , ) ,
                        ) ,
                    ) ,
                ) ,
                "inputs"    => array (
                    array (
                        "id"    => "input_file_path" ,
                        "title" => "Input File Path : " ,
                        "name"  => "input_file_path" ,
                        "value" => $_input_file_path ,
                    ) ,
                    array (
                        "id"    => "save_directory_path" ,
                        "title" => "Save Directory Path : " ,
                        "name"  => "save_directory_path" ,
                        "value" => $_save_directory_path ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => $_show_result_id ,
                        "title" => "( Build Result )   : " ,
                        "name"  => $_show_result_id ,
                        "value" => "" ,
                        "style" => 'height:800px;' ,
                    ) ,
                    array (
                        "id"       => $_show_error_id ,
                        "title"    => "( Error Message )   : " ,
                        "name"     => $_show_error_id ,
                        "value"    => "" ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
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
                "submit"    => array (
                    "id"    => "submit_form" ,
                    "type"  => "submit" ,
                    "title" => "( Create Encode Of File )" ,
                    "name"  => "submit_form" ,
                    "value" => "create encode file" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Encode File Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Encode File Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top                 = Class_View_Top::top ();
            $_body                = array (
                "menu"    => Class_View_Build_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu         = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content             = '<div></div>';
            $_javascript          = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom              = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Auth::check_permission ();
        }
        $_is_build = Class_Base_Request::form ( "is_build" , Class_Base_Request::TYPE_INTEGER , 0 );
        if ( ( ! empty( $_start ) ) && ( ! empty( $_is_build ) ) ) {
            $_create_new_file = Class_Operate_Build::create_new_encode_file ( $_input_file_path , $_save_directory_path , $_output_file_path , $_encode_key , $_encode_iv );
            if ( $_create_new_file !== false ) {
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $_show_result_id , ( "\n" . 'new file : ' . $_output_file_path . ' , encode key : ' . $_encode_key . ' , encode base64 iv : ' . $_encode_iv . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( ( "\n" . 'new file : ' . $_output_file_path . ' , encode key : ' . $_encode_key . ' , encode base64 iv : ' . $_encode_iv . "\n" ) );
                }
            }
        }
        return null;
    }

    public static function decode_build ( $params = array () )
    {
        if ( ! is_cli () ) {
            if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
                Class_Base_Response::redirect ( "/login" );
                return null;
            }
            Class_Base_Auth::check_permission ();
            $_start               = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
            $_input_file_path     = Class_Base_Request::form ( "input_file_path" , Class_Base_Request::TYPE_STRING , "" );
            $_save_directory_path = Class_Base_Request::form ( "save_directory_path" , Class_Base_Request::TYPE_STRING , "" );
            $_encode_key          = Class_Base_Request::form ( "encode_key" , Class_Base_Request::TYPE_STRING , "" );
            $_encode_iv_base64    = Class_Base_Request::form ( "encode_iv_base64" , Class_Base_Request::TYPE_STRING , "" );
            $_output_file_path    = null;
            $_show_result_id      = "show_result_id";
            $_show_error_id       = "show_error_id";
            $_cli_url             = Class_Base_Response::get_cli_url ( "/decode_build" , array ( "start" => 1 , "is_build" => 1 , "input_file_path" => $_input_file_path , "save_directory_path" => $_save_directory_path , "encode_key" => $_encode_key , "encode_iv_base64" => $_encode_iv_base64 ) );
            $_cli_encode_url      = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top            = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Build Decode Php Project File</div>';
            $_form_top            .= '<div style="width:100%;word-break:break-all;margin-top:16px;padding-left:0;padding-right:0;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This function module is used to read the content of a specified file (with a file name suffix of .phpsploit.encode ) and decrypt it, while writing the decryption results to a newly created plaintext file (with a file name suffix of .phpsploit.php ). Note: The current version only supports decryption of encrypted PHP type files! In future versions, support for other types of files will gradually be added!</div>';
            $_form_name           = "form_0";
            $_form                = array (
                "id"        => $_form_name ,
                "name"      => $_form_name ,
                "action"    => "/decode_build" ,
                "hiddens"   => array (
                    array (
                        "id"    => "start" ,
                        "name"  => "start" ,
                        "value" => 1 ,
                    ) ,
                ) ,
                "selects"   => array (
                    array (
                        "id"      => "is_build" ,
                        "title"   => "Build Project : " ,
                        "name"    => "is_build" ,
                        "options" => array (
                            array ( "describe" => "Start Build" , "title" => "Decode Build" , "value" => 1 , "selected" => ( "selected" ) ) ,
                            array ( "describe" => "No Start Build" , "title" => "No Build" , "value" => 0 , ) ,
                        ) ,
                    ) ,
                ) ,
                "inputs"    => array (
                    array (
                        "id"    => "input_file_path" ,
                        "title" => "Input File Path : " ,
                        "name"  => "input_file_path" ,
                        "value" => $_input_file_path ,
                    ) ,
                    array (
                        "id"    => "save_directory_path" ,
                        "title" => "Save Directory Path : " ,
                        "name"  => "save_directory_path" ,
                        "value" => $_save_directory_path ,
                    ) ,
                    array (
                        "id"    => "encode_key" ,
                        "title" => "Encode Key : " ,
                        "name"  => "encode_key" ,
                        "value" => $_encode_key ,
                    ) ,
                    array (
                        "id"    => "encode_iv_base64" ,
                        "title" => "Encode Iv Base64 : " ,
                        "name"  => "encode_iv_base64" ,
                        "value" => $_encode_iv_base64 ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => $_show_result_id ,
                        "title" => "( Build Result )   : " ,
                        "name"  => $_show_result_id ,
                        "value" => "" ,
                        "style" => 'height:800px;' ,
                    ) ,
                    array (
                        "id"       => $_show_error_id ,
                        "title"    => "( Error Message )   : " ,
                        "name"     => $_show_error_id ,
                        "value"    => "" ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
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
                "submit"    => array (
                    "id"    => "submit_form" ,
                    "type"  => "submit" ,
                    "title" => "( Create Decode Of File )" ,
                    "name"  => "submit_form" ,
                    "value" => "create decode file" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Decode File Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Decode File Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top                 = Class_View_Top::top ();
            $_body                = array (
                "menu"    => Class_View_Build_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu         = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content             = '<div></div>';
            $_javascript          = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom              = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Auth::check_permission ();
        }
        $_is_build = Class_Base_Request::form ( "is_build" , Class_Base_Request::TYPE_INTEGER , 0 );
        if ( ( ! empty( $_start ) ) && ( ! empty( $_is_build ) ) ) {
            $_create_new_file = Class_Operate_Build::create_new_decode_php_file ( $_input_file_path , $_save_directory_path , $_output_file_path , $_encode_key , $_encode_iv_base64 );
            if ( $_create_new_file !== false ) {
                if ( ! is_cli () ) {
                    Class_Base_Response::output_textarea_inner_html ( $_show_result_id , ( "\n" . 'new file : ' . $_output_file_path . ' , encode key : ' . $_encode_key . ' , encode base64 iv : ' . $_encode_iv_base64 . "\n" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response::outputln ( ( "\n" . 'new file : ' . $_output_file_path . ' , encode key : ' . $_encode_key . ' , encode base64 iv : ' . $_encode_iv_base64 . "\n" ) );
                }
            }
        }
        return null;
    }

}