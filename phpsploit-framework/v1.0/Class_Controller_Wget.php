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

class Class_Controller_Wget extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        $_start               = Class_Base_Request ::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_timeout             = Class_Base_Request ::form ( "timeout" , Class_Base_Request::TYPE_INTEGER , 60 );
        $_display_progress    = Class_Base_Request ::form ( "display_progress" , Class_Base_Request::TYPE_INTEGER , 1 );
        $_file_url            = Class_Base_Request ::form ( "file_url" , Class_Base_Request::TYPE_STRING , "" );
        $_save_directory_path = Class_Base_Request ::form ( "save_directory_path" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! is_cli () ) {
            $_cli_url            = Class_Base_Response ::get_cli_url ( "/wget" , array ( 'start' => 1 , 'timeout' => $_timeout , 'display_progress' => $_display_progress , 'file_url' => $_file_url , 'save_directory_path' => $_save_directory_path , ) );
            $_cli_encode_url     = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_form_top           = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Resource Requests And File Downloads</div>';
            $_form_top           .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is used to download the specified online resources to the specified directory on the server. Warning: Downloading inappropriate files to the server may pose a security risk. Unsuitable files include executable files in binary format, script command files in text format, etc. You should be fully aware that downloading inappropriate documents to server space can lead to various terrifying risk consequences! This includes but is not limited to functional abnormalities in server space, operating system, application programs, software crashes, data corruption, loss or leakage, and other situations! Before downloading the file, you should be fully aware that your improper behavior may bring legal risks and consequences to yourself! This module function must be used with caution. It can only be used for legally authorized penetration testing and security audit activities. The written contract you sign with the authorized party should clearly indicate that the authorized party allows you to download files and other related operations, and specify the types of files that can be downloaded. You must strictly abide by the contract content signed between you and the authorized party, and conduct safe, reasonable, and moderate file download behavior according to the contract content.</div>';
            $_form_name          = "form_0";
            $_form               = array (
                "action"    => "/wget" ,
                "id"        => $_form_name ,
                "name"      => $_form_name ,
                "hiddens"   => array (
                    array (
                        "id"    => "start" ,
                        "name"  => "start" ,
                        "value" => 1 ,
                    ) ,
                ) ,
                "selects"   => array (
                    array (
                        "id"      => "timeout" ,
                        "title"   => "Request Timeout : " ,
                        "name"    => "timeout" ,
                        "options" => array (
                            array ( "describe" => "60 seconds" , "title" => "60 seconds" , "value" => 60 , "selected" => ( ( $_timeout == 60 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "120 seconds" , "title" => "120 seconds" , "value" => 120 , "selected" => ( ( $_timeout == 120 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "180 seconds" , "title" => "180 seconds" , "value" => 180 , "selected" => ( ( $_timeout == 180 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "300 seconds" , "title" => "300 seconds" , "value" => 300 , "selected" => ( ( $_timeout == 300 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "600 seconds" , "title" => "600 seconds" , "value" => 600 , "selected" => ( ( $_timeout == 600 ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                    array (
                        "id"      => "display_progress" ,
                        "title"   => "Display progress : " ,
                        "name"    => "display_progress" ,
                        "options" => array (
                            array ( "describe" => "Yes" , "title" => "Yes" , "value" => 1 , "selected" => ( ( $_display_progress == 1 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "No" , "title" => "No" , "value" => 0 , "selected" => ( ( $_display_progress == 0 ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "inputs"    => array (
                    array (
                        "id"       => "file_url" ,
                        "title"    => "Request File Url : " ,
                        "describe" => "Request File Url" ,
                        "name"     => "file_url" ,
                        "value"    => $_file_url ,
                    ) ,
                    array (
                        "id"       => "save_directory_path" ,
                        "title"    => "File Save Directory : " ,
                        "describe" => "File Save Directory" ,
                        "name"     => "save_directory_path" ,
                        "value"    => $_save_directory_path ,
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
                    "title" => "( Start Download To Server )" ,
                    "name"  => "submit_form" ,
                    "value" => "start download server" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Download Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Wget Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top                = Class_View_Top ::top ();
            $_body               = array (
                "menu"    => Class_View_Wget_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
            );
            $_bottom_menu        = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_search_progress_id = "search_rogress_id";
            $_search_errors_id   = "search_errors_id";
            $_search_result_id   = "search_result_id";
            $_content            = '<div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Request Progress</div><div id="' . $_search_progress_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;">Request Errors</div><div id="' . $_search_errors_id . '" style="padding-top:16px;padding-bottom:16px;text-align: center;font-size:18px;"></div><div style="padding-top:16px;text-align: center;font-size:18px;">Request Result</div><div id="' . $_search_result_id . '" style="padding-top:16px;padding-bottom:16px;text-align: left;font-size:18px;"></div>';
            $_javascript         = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom             = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        if ( ( ! empty( $_start ) ) && ( ! empty( $_timeout ) ) && ( is_integer ( $_timeout ) ) && ( in_array ( $_timeout , array ( 60 , 120 , 180 , 300 , 600 ) ) ) && ( ! empty( $_file_url ) ) && ( is_string ( $_file_url ) ) && ( is_string ( $_save_directory_path ) ) && ( strlen ( $_save_directory_path ) > 0 ) && ( file_exists ( $_save_directory_path ) ) && is_dir ( $_save_directory_path ) ) {
            Class_Base_Request ::init ( $_timeout );
            Class_Base_Request ::send ( $_file_url , array () , array () , true , $_save_directory_path , $_display_progress , $_search_progress_id , $_search_errors_id , $_search_result_id );
        }
    }
}