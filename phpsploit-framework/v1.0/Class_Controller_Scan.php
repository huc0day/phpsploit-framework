<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-2
 * Time: 下午1:02
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

class Class_Controller_Scan
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
                "menu"    => Class_View_Scan_Menu::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function webs ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_start                   = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_webs                    = Class_Base_Request::form ( "webs" , Class_Base_Request::TYPE_STRING , "" );
        $_webs                    = str_replace ( chr ( 13 ) , "" , str_replace ( chr ( 10 ) , "" , str_replace ( chr ( 32 ) , "" , $_webs ) ) );
        $_webs_length             = strlen ( $_webs );
        $_webs_fast_char_position = ( $_webs_length - 1 );
        $_webs                    = ( ( $_webs_length > 0 ) ? ( ( substr ( $_webs , $_webs_fast_char_position , 1 ) == chr ( 44 ) ) ? ( ( $_webs_length > 1 ) ? ( substr ( $_webs , 0 , $_webs_fast_char_position ) ) : ( "" ) ) : ( $_webs ) ) : ( "" ) );
        $_web_array               = explode ( chr ( 44 ) , $_webs );
        $_web_array               = array_unique ( $_web_array );
        $_webs_count              = count ( $_web_array );
        if ( $_webs_count > 8 ) {
            throw new \Exception( "The number of web sites for survival testing cannot exceed 8" , 0 );
        }
        $_result           = array ();
        $_web_domain_names = array ();
        if ( ( ! empty( $_start ) ) && ( $_webs_count > 0 ) ) {
            $_result = Class_Operate_Scan::request_webs ( $_web_array );
            if ( ( ! empty( $_result ) ) && ( is_array ( $_result ) ) ) {
                $_web_domain_names = array_keys ( $_result );
            }
        } else {
            $_web_domain_names = $_web_array;
        }

        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response::get_cli_url ( "/scan/webs" , array ( 'start' => 1 , 'webs' => $_webs , ) );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Web Activity Status Detection</div>';
            $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to scan the survival status of WEB sites in the specified list (list elements include IP addresses, host names, or domain names, etc., separated by commas between elements in the list, for example: http://localhost , http://127.0.0.1 , https://localhost , https://127.0.0.1 , http://localhost:8080 , http://127.0.0.1:8080 , https://localhost:4443 , https://127.0.0.1:4443 ）</div>';
            $_form_name      = "form_0";
            $_form           = array (
                "action"    => "/scan/webs" ,
                "id"        => $_form_name ,
                "name"      => $_form_name ,
                "hiddens"   => array (
                    array (
                        "id"    => "start" ,
                        "name"  => "start" ,
                        "value" => 1 ,
                    ) ,
                ) ,
                "selects"   => array () ,
                "inputs"    => array () ,
                "textareas" => array (
                    array (
                        "id"    => "request_webs" ,
                        "title" => "( Request Domain )   : " ,
                        "name"  => "webs" ,
                        "value" => ( implode ( chr ( 44 ) , $_web_domain_names ) ) ,
                    ) ,
                    array (
                        "id"       => "response_http_code" ,
                        "title"    => "( Http Code Result )   : " ,
                        "name"     => "result" ,
                        "value"    => ( print_r ( $_result , true ) ) ,
                        "disabled" => "disabled" ,
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
                    "title" => "( Start Scan Webs )" ,
                    "name"  => "submit_form" ,
                    "value" => "start scan webs" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Scan Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Scan Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top            = Class_View_Top::top ();
            $_body           = array (
                "menu"    => Class_View_Scan_Menu::menu ( array () ) ,
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
            $_javascript     = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom         = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( $_result );
        }
        return null;
    }

    public static function domain ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_start                    = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_ip                       = Class_Base_Request::form ( "ip" , Class_Base_Request::TYPE_STRING , "" );
        $_ports                    = Class_Base_Request::form ( "ports" , Class_Base_Request::TYPE_STRING , "" );
        $_ip                       = str_replace ( chr ( 13 ) , "" , str_replace ( chr ( 10 ) , "" , str_replace ( chr ( 32 ) , "" , $_ip ) ) );
        $_ports                    = str_replace ( chr ( 13 ) , "" , str_replace ( chr ( 10 ) , "" , str_replace ( chr ( 32 ) , "" , $_ports ) ) );
        $_ports_length             = strlen ( $_ports );
        $_ports_fast_char_position = ( $_ports_length - 1 );
        $_ports                    = ( ( $_ports_length > 0 ) ? ( ( substr ( $_ports , $_ports_fast_char_position , 1 ) == chr ( 44 ) ) ? ( ( $_ports_length > 1 ) ? ( substr ( $_ports , 0 , $_ports_fast_char_position ) ) : ( "" ) ) : ( $_ports ) ) : ( "" ) );
        $_port_array               = explode ( chr ( 44 ) , $_ports );
        $_port_array               = array_unique ( $_port_array );
        $_ports_count              = count ( $_port_array );
        if ( $_ports_count > 8 ) {
            throw new \Exception( "The number of domain ports for survival testing cannot exceed 8" , 0 );
        }
        $_result = array ();
        if ( ( ! empty( $_start ) ) && ( ! empty( $_ip ) ) && ( $_ports_count > 0 ) ) {
            $_result = Class_Operate_Scan::request_domain_ports ( $_ip , $_port_array );
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response::get_cli_url ( "/scan/domain" , array ( 'start' => 1 , 'ip' => $_ip , 'ports' => $_ports , ) );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Domain Port Activity Status Detection</div>';
            $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to scan the response status of TCP protocol ports in a specified host (the list element is the port number, separated by commas between the elements in the list, examples: 22, 80, 443, 3306).</div>';
            $_form_name      = "form_0";
            $_form           = array (
                "action"    => "/scan/domain" ,
                "id"        => $_form_name ,
                "name"      => $_form_name ,
                "hiddens"   => array (
                    array (
                        "id"    => "start" ,
                        "name"  => "start" ,
                        "value" => 1 ,
                    ) ,
                ) ,
                "selects"   => array () ,
                "inputs"    => array (
                    array (
                        "id"       => "request_ip" ,
                        "title"    => "Domain IP Address : " ,
                        "describe" => "domain ip address" ,
                        "name"     => "ip" ,
                        "value"    => $_ip ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => "request_ports" ,
                        "title" => "( Request Ports )   : " ,
                        "name"  => "ports" ,
                        "value" => ( implode ( chr ( 44 ) , $_port_array ) ) ,
                    ) ,
                    array (
                        "id"       => "response_port_status" ,
                        "title"    => "( Port Status )   : " ,
                        "name"     => "result" ,
                        "value"    => ( print_r ( $_result , true ) ) ,
                        "disabled" => "disabled" ,
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
                    "title" => "( Start Scan Domain )" ,
                    "name"  => "submit_form" ,
                    "value" => "start scan ports" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Scan Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Scan Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top            = Class_View_Top::top ();
            $_body           = array (
                "menu"    => Class_View_Scan_Menu::menu ( array () ) ,
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
            $_javascript     = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom         = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response::outputln ( $_result );
        }
        return null;
    }

    public static function tamperproof ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_start                    = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_sampling_directory_path  = Class_Base_Request::form ( "sampling_directory_path" , Class_Base_Request::TYPE_STRING , "" );
        $_detection_directory_path = Class_Base_Request::form ( "detection_directory_path" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! is_cli () ) {
            $_cli_url                      = Class_Base_Response::get_cli_url ( "/scan/tamperproof" , array ( 'start' => 1 , 'sampling_directory_path' => $_sampling_directory_path , 'detection_directory_path' => $_detection_directory_path , ) );
            $_cli_encode_url               = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top                     = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Abnormal Directory And File Detection</div>';
            $_form_top                     .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module uses file detection technology to perform security scans on specified directories (such as web directories), and provides relevant prompts and warnings for discovered risks. This feature helps operations engineers or blue team members in CTF competitions to conduct web file security checks.</div>';
            $_form_name                    = "form_0";
            $_form                         = array (
                "action"    => "/scan/tamperproof" ,
                "id"        => $_form_name ,
                "name"      => $_form_name ,
                "hiddens"   => array (
                    array (
                        "id"    => "start" ,
                        "name"  => "start" ,
                        "value" => 1 ,
                    ) ,
                ) ,
                "selects"   => array () ,
                "inputs"    => array (
                    array (
                        "id"       => "sampling_directory_path" ,
                        "title"    => "Sampling Directory : " ,
                        "describe" => "Sampling Directory" ,
                        "name"     => "sampling_directory_path" ,
                        "value"    => $_sampling_directory_path ,
                    ) ,
                    array (
                        "id"       => "detection_directory_path" ,
                        "title"    => "Detection Directory : " ,
                        "describe" => "Detection Directory" ,
                        "name"     => "detection_directory_path" ,
                        "value"    => $_detection_directory_path ,
                    ) ,
                ) ,
                "textareas" => array (
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
                    "title" => "( Start Scan Tamperproof )" ,
                    "name"  => "submit_form" ,
                    "value" => "start scan tamperproof" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Scan Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Scan Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top                          = Class_View_Top::top ();
            $_body                         = array (
                "menu"    => Class_View_Scan_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu                  = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_search_sampling_progress_id  = "search_sampling_progress";
            $_search_detection_progress_id = "search_detection_progress";
            $_search_errors_id             = "search_errors";
            $_search_result_id             = "search_result";
            $_content                      = '<div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Sampling Progress</div><div id="' . $_search_sampling_progress_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Detection Progress</div><div id="' . $_search_detection_progress_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Errors</div><div id="' . $_search_errors_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Search Result</div><div id="' . $_search_result_id . '" style="padding-top:16px;padding-bottom:16px;text-align: left;font-size:18px;"></div>';
            $_javascript                   = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom                       = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );

            if ( ( ! empty( $_start ) ) && ( is_string ( $_sampling_directory_path ) ) && ( strlen ( $_sampling_directory_path ) > 0 ) && ( is_string ( $_detection_directory_path ) ) && ( strlen ( $_detection_directory_path ) > 0 ) ) {
                Class_Operate_Scan::scan_directory_exception ( $_sampling_directory_path , $_detection_directory_path , $_search_sampling_progress_id , $_search_detection_progress_id , $_search_errors_id , $_search_result_id , 100 , 0 );
            }
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $_search_sampling_progress_id , "" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
            }
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $_search_detection_progress_id , "" , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
            }

        } else {
            if ( ( ! empty( $_start ) ) && ( is_string ( $_sampling_directory_path ) ) && ( strlen ( $_sampling_directory_path ) > 0 ) && ( is_string ( $_detection_directory_path ) ) && ( strlen ( $_detection_directory_path ) > 0 ) ) {
                Class_Operate_Scan::scan_directory_exception ( $_sampling_directory_path , $_detection_directory_path , $_search_sampling_progress_id , $_search_detection_progress_id , $_search_errors_id , $_search_result_id , 100 , 0 );
            }
        }
        return null;
    }
}