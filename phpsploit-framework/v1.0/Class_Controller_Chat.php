<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-11
 * Time: 上午10:04
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

class Class_Controller_Chat extends Class_Controller
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
                "menu"    => Class_View_Chat_Menu::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function server_chat ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_start              = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_listen_ip          = Class_Base_Request::form ( "ip" , Class_Base_Request::TYPE_STRING , "" );
        $_listen_port        = Class_Base_Request::form ( "port" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_max_connect_number = Class_Base_Request::form ( "max_connect_number" , Class_Base_Request::TYPE_INTEGER , 20 );
        $_max_execute_time   = Class_Base_Request::form ( "max_execute_time" , Class_Base_Request::TYPE_INTEGER , 3600 );
        $_cli_url            = Class_Base_Response::get_cli_url ( "/chat/server_chat" , array ( "start" => 1 , "ip" => $_listen_ip , "port" => $_listen_port , "max_connect_number" => $_max_connect_number , "max_execute_time" => $_max_connect_number ) );
        $_cli_encode_url     = Class_Base_Response::get_urlencode ( $_cli_url );
        $_result             = "";
        if ( empty( $_start ) ) {
            $_result .= ( 'cli url : ' . $_cli_url ) . "\n\n" . ( 'cli encode url : ' . ( $_cli_encode_url ) ) . "\n\n";
        }
        $_connect_domain_List_id = "result_data";
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Combat Meeting Room</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module is based on the C/S architecture pattern and provides a typical chat environment between the client and server (both communication ends use RSA protocol to encrypt chat content, ensuring maximum communication security of chat content). The client is written in JAVA language, and the server is implemented in PHP language (due to the limitations of PHP language itself, the technical implementation of the server is still in further optimization). In CTF competitions, if you feel that public chat software may be breached and utilized by red teams, then in special scenarios, this module function can also become another option worth considering (although the server implementation, even the author himself, thinks it is not perfect ^ _ ^).Warning! When you start a server chat environment instance in the web interface, other functions in the current web environment will become unusable! If the target host for your current penetration testing or security audit behavior is still running other businesses, you should never use this feature in the web environment, as it will make other businesses in the web environment unusable! The functionality of this module is currently only applicable to web environments without other business operations, as well as relatively independent command-line environments!</div>';
            $_form_name   = "form_0";
            $_form        = array (
                "action"    => "/chat/server_chat" ,
                "id"        => $_form_name ,
                "name"      => $_form_name ,
                "hiddens"   => array (
                    array (
                        "id"    => "start" ,
                        "name"  => "start" ,
                        "value" => 1 ,
                    ) ,
                ) ,
                "inputs"    => array (
                    array (
                        "id"       => "listen_ip" ,
                        "title"    => "( Listen IP Address ) : " ,
                        "describe" => "listen IP Address" ,
                        "name"     => "ip" ,
                        "value"    => ( ( ! empty( $_listen_ip ) ) ? ( $_listen_ip ) : ( '127.0.0.1' ) ) ,
                    ) ,
                    array (
                        "id"       => "listen_port" ,
                        "title"    => "( Listen IP Port ) : " ,
                        "describe" => "listen IP Port" ,
                        "name"     => "port" ,
                        "value"    => ( ( ! empty( $_listen_port ) ) ? ( $_listen_port ) : ( rand ( 40000 , 49999 ) ) ) ,
                    ) ,
                    array (
                        "id"       => "max_connect_number" ,
                        "title"    => "( Max Connect Number ) : " ,
                        "describe" => "Max Connect Number" ,
                        "name"     => "max_connect_number" ,
                        "value"    => $_max_connect_number ,
                    ) ,
                    array (
                        "id"       => "max_execute_time" ,
                        "title"    => "( Max Execute Time ) : " ,
                        "describe" => "Max Execute Time" ,
                        "name"     => "max_execute_time" ,
                        "value"    => $_max_execute_time ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"       => $_connect_domain_List_id ,
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( $_result ) ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                ) ,
                "submit"    => array (
                    "id"    => "submit_form" ,
                    "type"  => "submit" ,
                    "title" => "( Start Chat Server Environment )" ,
                    "name"  => "submit_form" ,
                    "value" => "start chat server" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Chat Server Environment Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Chat Server Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Chat_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        if ( ( ! empty( $_start ) ) && ( is_string ( $_listen_ip ) ) && ( strlen ( $_listen_ip ) > 0 ) && ( ( Class_Base_Format::is_ipv4_address ( $_listen_ip ) ) || ( Class_Base_Format::is_ipv6_address ( $_listen_ip ) ) ) && ( is_integer ( $_listen_port ) ) && ( ( ( $_listen_port ) > 0 ) && ( $_listen_port < 65536 ) ) && ( is_integer ( $_max_connect_number ) ) && ( ( $_max_connect_number <= 100 ) ) && ( is_integer ( $_max_execute_time ) ) && ( $_max_execute_time >= 0 ) && ( is_string ( $_connect_domain_List_id ) ) ) {
            Class_Operate_ChatServer::start ( $_listen_ip , $_listen_port , $_max_connect_number , $_max_execute_time , $_connect_domain_List_id );
        }
        return null;
    }

    public static function reverse_chat ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( ! is_cli () ) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Combat Meeting Room (New Version)</div>';
            $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module still provides a typical chat environment between client and server based on the C/S architecture mode, with the main difference being that it will use rebound connections for connection communication management. This method is beneficial for the red team to engage in better activities in CTF matches, while using a traditional chat and communication environment for connection is more convenient for the blue team to communicate and communicate in CTF matches.</div>';
            $_form_top .= '<div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: left;font-size: 18px;color:red;">This module functionality will be implemented in a future version.</div>';
            $_form     = array (
                "submit" => array ( "display" => false ) ,
                "reset"  => array ( "display" => false ) ,
            );
            $_top      = Class_View_Top::top ();
            $_body     = array (
                "menu"    => Class_View_Chat_Menu::menu () ,
                "content" => ( $_form_top . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom   = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }
}