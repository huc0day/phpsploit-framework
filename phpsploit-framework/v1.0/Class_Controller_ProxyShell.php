<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-6-14
 * Time: 下午1:43
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

class Class_Controller_ProxyShell
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
                "menu"    => Class_View_ProxyShell_Menu ::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom ::bottom ();
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function create_session_id ( $params = array () )
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
        $_local_ipv6_address = Class_Base_RawSocket ::get_local_ipv6_address ();
        $_src_ipv6_address   = Class_Base_Request ::form ( "src_ipv6" , Class_Base_Request::TYPE_STRING , "" );
        $_dst_ipv6_address   = Class_Base_Request ::form ( "dst_ipv6" , Class_Base_Request::TYPE_STRING , "" );
        if ( empty( $_src_ipv6_address ) ) {
            if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ] ) ) {
                $_src_ipv6_address = $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ];
            } else {
                $_src_ipv6_address = $_local_ipv6_address;
            }
        }
        if ( empty( $_proxy_ipv6_address ) ) {
            if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ] ) ) {
                $_proxy_ipv6_address = $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ];
            } else {
                $_proxy_ipv6_address = $_local_ipv6_address;
            }
        }
        if ( empty( $_dst_ipv6_address ) ) {
            if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ] ) ) {
                $_dst_ipv6_address = $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ];
            } else {
                $_dst_ipv6_address = $_local_ipv6_address;
            }
        }

        Class_Operate_ProxyShell ::init_session_ipv6_address_info ( $_src_ipv6_address , $_proxy_ipv6_address , $_dst_ipv6_address );

        if ( ( ( is_string ( $_src_ipv6_address ) ) && ( strlen ( $_src_ipv6_address ) > 0 ) ) && ( ( is_string ( $_dst_ipv6_address ) ) && ( strlen ( $_dst_ipv6_address ) > 0 ) ) ) {
            $_session_id = Class_Operate_ProxyShell ::create_authentication_code ( $_src_ipv6_address , $_dst_ipv6_address );
        }
        if ( is_cli () ) {
            if ( ( ! empty( $_src_ipv6_address ) ) && ( ! empty( $_session_id ) ) ) {
                Class_Base_Response ::outputln ( "source ipv6 address ( " . $_src_ipv6_address . " ) , Source Authentication Code : Session ID ( " . $_session_id . " ) " );
            }
            return null;
        }
        $_cli_url        = Class_Base_Response ::get_cli_url ( "/shell/proxy_shell/create_session_id" , array ( "src_ipv6" => $_src_ipv6_address , "dst_ipv6" => $_dst_ipv6_address ) );
        $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
        $_show_result    = ( 'cli url : ' . $_cli_url . "\n\n" . 'cli encode url : ' . $_cli_encode_url . "\n\n" );
        $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Create Source To Destination Session ID</div>';
        $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to create specified authentication information on the server, This authentication information is mainly used for effective authentication of secure communication between clients and servers The authentication information is calculated and synthesized using the client IPV6 address and the server IPV6 address. Incorrect authentication information will result in authentication failure during the communication process between the client and the server. The authentication code will be automatically created every time the server officially starts the listening instance. When the client sends communication data to the server, it must carry the correct authentication code! To improve communication security, the data sent by the client to the server will After encryption processing, the key information required for the encryption operation is also automatically issued every time the server officially starts the listening instance. Note that the lifecycle of the authentication code and encryption key is the same as the lifecycle of the server listening instance that is started each time! To avoid communication security risks, you should avoid using this PROXY SHELL function in an insecure local area network environment.</span></div>';
        $_form           = array (
            "action"    => "/shell/proxy_shell/create_session_id" ,
            "inputs"    => array (
                array (
                    "id"       => "src_ipv6" ,
                    "title"    => "( Source IPV6 ) : " ,
                    "describe" => "Source IP Address" ,
                    "name"     => "src_ipv6" ,
                    "value"    => ( ( ! empty( $_src_ipv6_address ) ) ? ( $_src_ipv6_address ) : ( $_local_ipv6_address ) ) ,
                ) ,
                array (
                    "id"       => "dst_ipv6" ,
                    "title"    => "( Destination IPV6 ) : " ,
                    "describe" => "Destination IP Address" ,
                    "name"     => "dst_ipv6" ,
                    "value"    => ( ( ! empty( $_dst_ipv6_address ) ) ? ( $_dst_ipv6_address ) : ( $_local_ipv6_address ) ) ,
                ) ,
                array (
                    "id"       => "src_authentication_code" ,
                    "title"    => "( Source Auth Code ) : " ,
                    "describe" => "Source Authentication Code" ,
                    "name"     => "src_authentication_code" ,
                    "value"    => ( ( ! empty( $_session_id ) ) ? ( $_session_id ) : ( '' ) ) ,
                    "disabled" => "disabled" ,
                ) ,
            ) ,
            "textareas" => array (
                array (
                    "id"       => "show_result" ,
                    "title"    => "( Show Result ) : " ,
                    "describe" => "Show Result" ,
                    "name"     => "show_result" ,
                    "value"    => ( ( ! empty( $_show_result ) ) ? ( $_show_result ) : ( '' ) ) ,
                    "disabled" => "disabled" ,
                    "style"    => 'height:300px;' ,
                ) ,
            ) ,
        );
        $_top            = Class_View_Top ::top ();
        $_body           = array (
            "menu"    => Class_View_ProxyShell_Menu ::menu ( array () ) ,
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
    }

    public static function clear_session_id ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth ::is_login () ) ) {
            Class_Base_Response ::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth ::check_permission ();
        $_local_ipv6_address = Class_Base_RawSocket ::get_local_ipv6_address ();
        $_src_ipv6_address   = Class_Base_Request ::form ( "src_ipv6" , Class_Base_Request::TYPE_STRING , "" );
        $_dst_ipv6_address   = Class_Base_Request ::form ( "dst_ipv6" , Class_Base_Request::TYPE_STRING , "" );
        if ( ( ( is_string ( $_src_ipv6_address ) ) && ( strlen ( $_src_ipv6_address ) > 0 ) ) && ( Class_Base_Format ::is_ipv6_address ( $_src_ipv6_address ) ) && ( ( is_string ( $_dst_ipv6_address ) ) && ( strlen ( $_dst_ipv6_address ) > 0 ) && ( Class_Base_Format ::is_ipv6_address ( $_dst_ipv6_address ) ) ) ) {
            $_session_id = Class_Operate_ProxyShell ::create_src_to_dst_session_id_string ( $_src_ipv6_address , $_dst_ipv6_address );
        }
        $_cli_url        = Class_Base_Response ::get_cli_url ( "/shell/proxy_shell/clear_session_id" , array ( "src_ipv6" => $_src_ipv6_address , "dst_ipv6" => $_dst_ipv6_address ) );
        $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
        $_show_result    = ( 'cli url : ' . $_cli_url . "\n\n" . 'cli encode url : ' . $_cli_encode_url . "\n\n" );
        if ( ( ! empty( $_src_ipv6_address ) ) && ( ! empty( $_dst_ipv6_address ) ) && ( ! empty( $_session_id ) ) ) {
            $_deleted = Class_Operate_ProxyShell ::clear_authentication_code ( $_src_ipv6_address );
            if ( $_deleted === false ) {
                $_show_result .= ( "Failed to clear proxy session authorization ID , session_id : " . print_r ( $_session_id , true ) );
            } else {
                $_show_result .= ( "Successfully cleared proxy session authorization ID , session_id : " . print_r ( $_session_id , true ) );
            }
        }
        if ( is_cli () ) {
            if ( ( ! empty( $_src_ipv6_address ) ) && ( ! empty( $_session_id ) ) ) {
                Class_Base_Response ::outputln ( "source ipv6 address ( " . $_src_ipv6_address . " ) , Source Authentication Code : Session ID ( " . $_session_id . " ) " );
            }
            if ( ! empty( $_show_result ) ) {
                Class_Base_Response ::outputln ( "\n" . ( $_show_result ) . "\n" );
            }
            return null;
        }
        $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Clear Source To Destination Session ID</div>';
        $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is mainly used to clear the specified authentication information you previously created on the server. After the authentication information is cleared, clients using this authentication information will not be able to communicate normally with the PROXY SHELL module function on the server (due to the clearing of the authentication information, communication requests sent by the client will be rejected by the server).</span></div>';
        $_form        = array (
            "action"    => "/shell/proxy_shell/clear_session_id" ,
            "inputs"    => array (
                array (
                    "id"       => "src_ipv6" ,
                    "title"    => "( Source IPV6 ) : " ,
                    "describe" => "Source IP Address" ,
                    "name"     => "src_ipv6" ,
                    "value"    => ( ( ! empty( $_src_ipv6_address ) ) ? ( $_src_ipv6_address ) : ( $_local_ipv6_address ) ) ,
                ) ,
                array (
                    "id"       => "dst_ipv6" ,
                    "title"    => "( Destination IPV6 ) : " ,
                    "describe" => "Destination IP Address" ,
                    "name"     => "dst_ipv6" ,
                    "value"    => ( ( ! empty( $_dst_ipv6_address ) ) ? ( $_dst_ipv6_address ) : ( $_local_ipv6_address ) ) ,
                ) ,
                array (
                    "id"       => "src_authentication_code" ,
                    "title"    => "( Source Auth Code ) : " ,
                    "describe" => "Source Authentication Code" ,
                    "name"     => "src_authentication_code" ,
                    "value"    => ( ( ! empty( $_session_id ) ) ? ( $_session_id ) : ( '' ) ) ,
                    "disabled" => "disabled" ,
                ) ,
            ) ,
            "textareas" => array (
                array (
                    "id"       => "show_result" ,
                    "title"    => "( Show Result ) : " ,
                    "describe" => "Show Result" ,
                    "name"     => "show_result" ,
                    "value"    => ( ( ! empty( $_show_result ) ) ? ( $_show_result ) : ( '' ) ) ,
                    "disabled" => "disabled" ,
                    "style"    => "height:300px;" ,
                ) ,
            ) ,
        );
        $_top         = Class_View_Top ::top ();
        $_body        = array (
            "menu"    => Class_View_ProxyShell_Menu ::menu ( array () ) ,
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
        $_javascript  = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
        $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
        Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
    }

    public static function send ( $params = array () )
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

        $_debug              = Class_Base_Request ::form ( "debug" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_local_ipv6_address = Class_Base_RawSocket ::get_local_ipv6_address ();
        $_src_ipv6_address   = Class_Base_Request ::form ( "src_ipv6" , Class_Base_Request::TYPE_STRING , "" );
        $_proxy_ipv6_address = Class_Base_Request ::form ( "proxy_ipv6" , Class_Base_Request::TYPE_STRING , "" );
        $_dst_ipv6_address   = Class_Base_Request ::form ( "dst_ipv6" , Class_Base_Request::TYPE_STRING , "" );
        $_md5_token          = Class_Base_Request ::form ( "md5_token" , Class_Base_Request::TYPE_STRING , ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) );
        $_command            = Class_Base_Request ::form ( "command" , Class_Base_Request::TYPE_STRING , "" );
        $_encode_key         = Class_Base_Request ::form ( "encode_key" , Class_Base_Request::TYPE_STRING , "" );
        $_encode_iv_base64   = Class_Base_Request ::form ( "encode_iv_base64" , Class_Base_Request::TYPE_STRING , "" );
        if ( empty( $_src_ipv6_address ) ) {
            if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ] ) ) {
                $_src_ipv6_address = $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_SRC_IPV6" ];
            } else {
                $_src_ipv6_address = $_local_ipv6_address;
            }
        }
        if ( empty( $_proxy_ipv6_address ) ) {
            if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ] ) ) {
                $_proxy_ipv6_address = $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_PROXY_IPV6" ];
            } else {
                $_proxy_ipv6_address = $_local_ipv6_address;
            }
        }
        if ( empty( $_dst_ipv6_address ) ) {
            if ( ! empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ] ) ) {
                $_dst_ipv6_address = $_SESSION[ "PHPSPLOIT_FRAMEWORK_PROXY_SHELL_DST_IPV6" ];
            } else {
                $_dst_ipv6_address = $_local_ipv6_address;
            }
        }
        Class_Operate_ProxyShell ::init_session_ipv6_address_info ( $_src_ipv6_address , $_proxy_ipv6_address , $_dst_ipv6_address );
        if ( ( ( is_string ( $_src_ipv6_address ) ) && ( strlen ( $_src_ipv6_address ) > 0 ) ) && ( ( is_string ( $_dst_ipv6_address ) ) && ( strlen ( $_dst_ipv6_address ) > 0 ) ) ) {
            $_session_id = Class_Operate_ProxyShell ::create_authentication_code ( $_src_ipv6_address , $_dst_ipv6_address );
        }
        if ( ! is_cli () ) {
            $_send_request_result_id = "send_request_result_id";
            $_cli_url                = Class_Base_Response ::get_cli_url ( "/shell/proxy_shell/send" , array ( "src_ipv6" => $_src_ipv6_address , "proxy_ipv6" => $_proxy_ipv6_address , "dst_ipv6" => $_dst_ipv6_address , "session_id" => $_session_id , "command" => $_command , "encode_key" => $_encode_key , "encode_iv_base64" => $_encode_iv_base64 , "debug" => $_debug ) );
            $_cli_encode_url         = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_form_top               = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Send Command To Proxy Shell Server</div>';
            $_form_top               .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module uses raw socket technology to send shell command information from the client side of the PROXY SHELL environment to the server side. Currently, the SEND module cannot receive corresponding return information from the server side (because in the IPV6 protocol of the network layer, there are no transport level related functions, such as transmission level features based on serial numbers, flags, retransmissions, timeouts, etc.). In the module components of this PROXY SHELL series kit, there is a dedicated RECIVE module function to receive return information sent from the server of the PROXY SHELL environment to the client.</span></div>';
            $_form                   = array (
                "action"    => "/shell/proxy_shell/send" ,
                "inputs"    => array (
                    array (
                        "id"       => "src_ipv6" ,
                        "title"    => "( Source IPV6 ) : " ,
                        "describe" => "Source IP Address" ,
                        "name"     => "src_ipv6" ,
                        "value"    => ( ( ! empty( $_src_ipv6_address ) ) ? ( $_src_ipv6_address ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "proxy_ipv6" ,
                        "title"    => "( Proxy IPV6 ) : " ,
                        "describe" => "Proxy IP Address" ,
                        "name"     => "proxy_ipv6" ,
                        "value"    => ( ( ! empty( $_proxy_ipv6_address ) ) ? ( $_proxy_ipv6_address ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "dst_ipv6" ,
                        "title"    => "( Destination IPV6 ) : " ,
                        "describe" => "Destination IP Address" ,
                        "name"     => "dst_ipv6" ,
                        "value"    => ( ( ! empty( $_dst_ipv6_address ) ) ? ( $_dst_ipv6_address ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "session_id" ,
                        "title"    => "( Auth Session ID ) : " ,
                        "describe" => "Auth Session ID" ,
                        "name"     => "session_id" ,
                        "value"    => ( ( ! empty( $_session_id ) ) ? ( $_session_id ) : ( '' ) ) ,
                        "disabled" => "disabled" ,
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
                        "value"    => ( ( ! empty( $_encode_iv_base64 ) ) ? ( str_replace ( " " , "+" , $_encode_iv_base64 ) ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "md5_token" ,
                        "title"    => "( Cli Md5 Token ) : " ,
                        "describe" => "Cli Md5 Token" ,
                        "name"     => "md5_token" ,
                        "value"    => ( ( ! empty( $_md5_token ) ) ? ( $_md5_token ) : ( '' ) ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => "command_id" ,
                        "title" => "( Shell Command )   : " ,
                        "name"  => "command" ,
                        "value" => ( $_command ) ,
                        "style" => 'height:200px;' ,
                    ) ,
                    array (
                        "id"       => $_send_request_result_id ,
                        "title"    => "( Send Request )   : " ,
                        "name"     => "result" ,
                        "value"    => "" ,
                        "disabled" => "disabled" ,
                        "style"    => 'height:200px;' ,
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
            $_top                    = Class_View_Top ::top ();
            $_body                   = array (
                "menu"    => Class_View_ProxyShell_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) ) ,
            );
            $_bottom_menu            = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content                = '<div></div>';
            $_javascript             = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom                 = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        if ( is_root_permissions () && ( ! empty( $_command ) ) ) {
            try {

                $_send_request_result = Class_Operate_ProxyShell ::send ( $_src_ipv6_address , $_dst_ipv6_address , $_proxy_ipv6_address , $_command , $_encode_key , $_encode_iv_base64 , $_debug );
                if ( ! is_cli () ) {
                    Class_Base_Response ::output_textarea_inner_html ( $_send_request_result_id , ( "\n" . ( print_r ( $_send_request_result , true ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response ::outputln ( "\n" . ( print_r ( $_send_request_result , true ) ) . "\n" );
                }
            } catch ( \Exception $e ) {
                if ( ! is_cli () ) {
                    Class_Base_Response ::output_textarea_inner_html ( $_send_request_result_id , ( "\n" . ( print_r ( $e , true ) ) ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                } else {
                    Class_Base_Response ::outputln ( "\n" . ( print_r ( $e , true ) ) . "\n" );
                }
            }
        }

        return null;
    }

    public static function receive ( $params = array () )
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
        $_debug            = Class_Base_Request ::form ( "debug" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_md5_token        = Class_Base_Request ::form ( "md5_token" , Class_Base_Request::TYPE_STRING , ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) );
        $_local_ipv6       = Class_Base_Request ::form ( "local_ipv6" , Class_Base_Request::TYPE_STRING , ( Class_Base_RawSocket ::get_local_ipv6_address () ) );
        $_encode_key       = Class_Base_Request ::form ( "encode_key" , Class_Base_Request::TYPE_STRING , "" );
        $_encode_iv_base64 = Class_Base_Request ::form ( "encode_iv_base64" , Class_Base_Request::TYPE_STRING , "" );
        if ( is_cli () ) {
            if ( is_root_permissions () ) {
                if ( ( ! empty( $_encode_key ) ) && ( ! empty( $_encode_iv_base64 ) ) && ( is_string ( $_encode_key ) ) && ( is_string ( $_encode_iv_base64 ) ) ) {
                    Class_Operate_ProxyShell ::receive ( $_encode_key , $_encode_iv_base64 , $_local_ipv6 , "result_show_id" , $_debug );
                }
            }
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response ::get_cli_url ( "/shell/proxy_shell/receive" , array ( "encode_key" => $_encode_key , "encode_iv_base64" => $_encode_iv_base64 , "local_ipv6" => $_local_ipv6 , "debug" => $_debug ) );
            $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Receive Command Execute Result From Proxy Shell Server</div>';
            $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is mainly used to receive command execution results from the server side of the PROXY SHELL environment.</span></div>';
            $_form           = array (
                "action"    => "/shell/proxy_shell/receive" ,
                "inputs"    => array (
                    array (
                        "id"       => "md5_token" ,
                        "title"    => "( Cli Md5 Token ) : " ,
                        "describe" => "Cli Md5 Token" ,
                        "name"     => "md5_token" ,
                        "value"    => ( ( ! empty( $_md5_token ) ) ? ( $_md5_token ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "local_ipv6" ,
                        "title"    => "( Local Ipv6 Address ) : " ,
                        "describe" => "Local Ipv6 Address" ,
                        "name"     => "local_ipv6" ,
                        "value"    => ( ( ! empty( $_local_ipv6 ) ) ? ( $_local_ipv6 ) : ( '' ) ) ,
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
                        "value"    => ( ( ! empty( $_encode_iv_base64 ) ) ? ( str_replace ( " " , "+" , $_encode_iv_base64 ) ) : ( '' ) ) ,
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
            );
            $_top            = Class_View_Top ::top ();
            $_body           = array (
                "menu"    => Class_View_ProxyShell_Menu ::menu ( array () ) ,
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
        }
        return null;
    }

    public static function listen ( $params = array () )
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
        $_debug              = Class_Base_Request::form ("debug",Class_Base_Request::TYPE_INTEGER,0);
        $_local_ipv6 = Class_Base_Request ::form ( "local_ipv6" , Class_Base_Request::TYPE_STRING , ( Class_Base_RawSocket ::get_local_ipv6_address () ) );
        $_md5_token  = Class_Base_Request ::form ( "md5_token" , Class_Base_Request::TYPE_STRING , ( ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) ? ( "" ) : ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] ) ) );
        if ( is_cli () ) {
            if ( is_root_permissions () ) {
                Class_Operate_ProxyShell ::listen ( $_local_ipv6 , "result_show_id",$_debug );
            }
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response ::get_cli_url ( "/shell/proxy_shell/listen" , array ( "local_ipv6" => $_local_ipv6,"debug"=>$_debug ) );
            $_cli_encode_url = Class_Base_Response ::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Listen in Proxy Shell Server</div>';
            $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to listen, receive, and execute command information from the PROXY SHELL environment client. Both communication parties have implemented secure encryption before officially sending data. The encryption key is automatically assigned when the server monitoring module in the PROXY SHELL environment is activated. Both the client and server of the PROXY SHELL environment must use matching security keys to encrypt and decrypt communication data. Therefore, when calling the relevant module functions of the PROXY SHELL environment, you may need to pass necessary information (including encode_key, encode_ivbase64, session_id, md5_token, etc.) to the relevant modules. Note that this module is currently only available in command line environments! When you officially start the listening module function of the PROXY SHELL environment server in the command line environment, you need to pay attention to the security key information generated by this listening module and displayed on the command line interface (including encode_key and encode_iv_base64). The command sending module and command execution result receiving module of the PROXY SHELL environment client will use them to encrypt and decrypt the sent and received data!</span></div>';
            $_form           = array (
                "action"    => "/shell/proxy_shell/listen" ,
                "inputs"    => array (
                    array (
                        "id"       => "local_ipv6" ,
                        "title"    => "( Local IPV6 Address ) : " ,
                        "describe" => "Local IPV6 Address" ,
                        "name"     => "local_ipv6" ,
                        "value"    => ( ( ! empty( $_local_ipv6 ) ) ? ( $_local_ipv6 ) : ( '' ) ) ,
                    ) ,
                    array (
                        "id"       => "md5_token" ,
                        "title"    => "( Cli Md5 Token ) : " ,
                        "describe" => "Cli Md5 Token" ,
                        "name"     => "md5_token" ,
                        "value"    => ( ( ! empty( $_md5_token ) ) ? ( $_md5_token ) : ( '' ) ) ,
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
            );
            $_top            = Class_View_Top ::top ();
            $_body           = array (
                "menu"    => Class_View_ProxyShell_Menu ::menu ( array () ) ,
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
        }
        return null;
    }
}