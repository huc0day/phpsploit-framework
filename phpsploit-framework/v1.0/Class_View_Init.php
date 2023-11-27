<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-7
 * Time: 下午3:11
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

class Class_View_Init extends Class_View
{
    public static function init ( $params = array () )
    {
        if ( ! is_cli () ) {
            if ( ( ! isset( $params[ "privilege_user" ] ) ) || ( ! is_string ( $params[ "privilege_user" ] ) ) || ( strlen ( $params[ "privilege_user" ] ) <= 0 ) ) {
                $params[ "privilege_user" ] = "";
            }
            if ( ( ! isset( $params[ "privilege_password" ] ) ) || ( ! is_string ( $params[ "privilege_password" ] ) ) || ( strlen ( $params[ "privilege_password" ] ) <= 0 ) ) {
                $params[ "privilege_password" ] = "";
            }
            $_cli_url        = Class_Base_Response ::get_cli_url ( "init_user_info" , array ( "privilege_user" => $params[ "privilege_user" ] , "privilege_password" => $params[ "privilege_password" ] ) );
            $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_form_name      = "form_0";
            return ( Class_View ::form_page (
                array (
                    "title"   => "phpsploit-framework" ,
                    "content" => '<div style="height:16px;"></div><div style="line-height:32px;font-size:32px;text-align: center;">Initialize installation to PhpSploit - Framework</div><div style="height:32px;"></div>' ,
                ) ,
                array (
                    "action"    => "/init_user_info" ,
                    "id"        => $_form_name ,
                    "name"      => $_form_name ,
                    "inputs"    => array (
                        array (
                            "title"    => "Init User Name: " ,
                            "describe" => "Init User" ,
                            "name"     => "privilege_user" ,
                            "value"    => $params[ "privilege_user" ] ,
                        ) ,
                        array (
                            "title"    => "Init User Password : " ,
                            "describe" => "Init Password" ,
                            "name"     => "privilege_password" ,
                            "value"    => $params[ "privilege_password" ] ,
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
                        array (
                            "title"    => "Additional Service Terms ： " ,
                            "describe" => 'PhpSploit框架是专为善而非恶而设计的。如果您计划将此工具用于未经您执行评估的公司授权的恶意目的，则表示您违反了此工具集的服务条款和许可证。点击提交（一次，或者一次以上），即表示您同意服务条款，并且您只能将此工具用于合法目的。' ,
                            "name"     => "additional_service_terms" ,
                            "value"    => 'The PhpSploit-Framework is designed purely for good and not evil. If you are planning on using this tool for malicious purposes that are not authorized by the company you are performing assessments for, you are violating the terms of service and license of this toolset. By hitting submit (once or more), you agree to the terms of service and that you will only use this tool for lawful purposes only.' ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "button"    => array (
                        "id"      => "button_form" ,
                        "type"    => "button" ,
                        "title"   => "( Create Connection Client Environment CLI Encode URL )" ,
                        "name"    => "button_form" ,
                        "value"   => "create cli encode url" ,
                        "display" => true ,
                        "events"  => array (
                            "onclick" => 'create_encode_url();' ,
                        ) ,
                    ) ,
                    "gets"      => array () ,
                ) ,
                array (
                    "menu"       => array (
                        array (
                            "title"    => "" ,
                            "describe" => "" ,
                            "href"     => "#" ,
                        ) ,
                    ) ,
                    "content"    => '<div></div>' ,
                    "javascript" => '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}function create_encode_url(){ document.getElementById("' . htmlentities ( $_form_name ) . '").action="' . Class_Base_Response ::get_url ( "/init" , array () ) . '";if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>' ,
                ) )
            );

        }
        return null;
    }
}