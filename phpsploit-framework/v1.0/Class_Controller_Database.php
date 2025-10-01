<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-30
 * Time: 下午7:08
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

class Class_Controller_Database extends Class_Controller
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
                "menu"    => Class_View_Database_Menu::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function query ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_drive_type = Class_Base_Request::form ( "drive_type" , Class_Base_Request::TYPE_STRING , Class_Base_Database::TYPE_DRIVE_MYSQL );
        $_domain     = Class_Base_Request::form ( "domain" , Class_Base_Request::TYPE_STRING , Class_Base_Database::DOMAIN_LOCALHOST );
        $_port       = Class_Base_Request::form ( "port" , Class_Base_Request::TYPE_INTEGER , Class_Base_Database::PORT_LOCALHOST );
        $_user       = Class_Base_Request::form ( "user_name" , Class_Base_Request::TYPE_STRING , "" );
        $_password   = Class_Base_Request::form ( "user_password" , Class_Base_Request::TYPE_STRING , "" );
        $_string     = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        $_type       = Class_Base_Request::form ( "type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Security::TYPE_ENCODE_CRYPTO_JS );
        $_key        = ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] );
        $_iv         = ( empty( $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ] ) ? "" : $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ] );
        $_result     = "";
        if ( ( is_string ( $_user ) ) && ( strlen ( $_user ) > 0 ) && ( is_string ( $_password ) ) && ( is_string ( $_string ) ) && ( strlen ( $_string ) > 0 ) && ( is_integer ( $_type ) ) && ( Class_Base_Security::is_phpsploit_encode_type ( $_type ) ) && ( is_string ( $_key ) ) && ( strlen ( $_key ) > 0 ) && ( is_string ( $_iv ) ) && ( strlen ( $_iv ) > 0 ) ) {
            if ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) {
                $_user     = Class_Base_Security::phpsploit_decode_128 ( $_user , $_key , $_iv );
                $_password = Class_Base_Security::phpsploit_decode_128 ( $_password , $_key , $_iv );
                $_string   = Class_Base_Security::phpsploit_decode_128 ( $_string , $_key , $_iv );
                if ( ( is_string ( $_user ) ) && ( strlen ( $_user ) > 0 ) && ( is_string ( $_password ) ) && ( is_string ( $_string ) ) && ( strlen ( $_string ) > 0 ) ) {
                    Class_Base_Database::connect ( $_drive_type , $_domain , $_port , $_user , $_password , array ( \PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING ) );
                    $_result = Class_Base_Database::query_sqls_string ( $_string );
                    if ( $_result === false ) {
                        $_result = array ();
                        $_error  = Class_Base_Database::get_error_infos ();
                    }
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] = "";
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ]  = "";
                }
            }
        }
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Database Query</div>';
            $_form_top    .= '<div style="margin-top:32px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This function module is mainly used for SQL statement queries, please use this function with caution! Incorrect SQL query statements may increase the performance burden of the database server and even pose data security risks! Before performing this operation, you should fully obtain legal authorization from the authorized party! Any unauthorized SQL query behavior is illegal, and you may bear the relevant legal consequences as a result! This module function can only be used for activities such as penetration testing, security auditing, and security technology research with legal authorization. </div>';
            $_form        = array (
                "action"    => "/database/query" ,
                "hiddens"   => array (
                    array (
                        "id"    => "encode_sql" ,
                        "name"  => "string" ,
                        "value" => "" ,
                    ) ,
                    array (
                        "id"    => "encode_user" ,
                        "name"  => "user_name" ,
                        "value" => "" ,
                    ) ,
                    array (
                        "id"    => "encode_password" ,
                        "name"  => "user_password" ,
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
                    array (
                        "id"       => "algo_domain" ,
                        "title"    => "( Database domain ) : " ,
                        "describe" => "domain" ,
                        "name"     => "domain" ,
                        "value"    => $_domain ,
                    ) ,
                    array (
                        "id"       => "algo_port" ,
                        "title"    => "( Database Port ) : " ,
                        "describe" => "port" ,
                        "name"     => "port" ,
                        "value"    => $_port ,
                    ) ,
                    array (
                        "id"       => "algo_user" ,
                        "title"    => "( Database User ) : " ,
                        "describe" => "user" ,
                        "name"     => "show_user" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_user ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( $_user , $_key , $_iv ) ) : ( $_user ) ) ,
                    ) ,
                    array (
                        "id"       => "algo_password" ,
                        "title"    => "( Database Password ) : " ,
                        "describe" => "password" ,
                        "name"     => "show_password" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_password ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( $_password , $_key , $_iv ) ) : ( $_password ) ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => "sql_statement" ,
                        "title" => "( SQL Statement   )   : " ,
                        "name"  => "show_string" ,
                        "value" => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_string ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( $_string , $_key , $_iv ) ) : ( $_string ) ) ,
                    ) ,
                    array (
                        "id"       => "result_data" ,
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_result ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( print_r ( $_result , true ) , $_key , $_iv ) ) : ( $_result ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                    array (
                        "id"       => "error_data" ,
                        "title"    => "( Error Data )   : " ,
                        "name"     => "error" ,
                        "value"    => ( print_r ( $_error , true ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Database_Menu::menu ( array () ) ,
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
            $_javascript  = '<script type="text/javascript">
function init(){ 
    document.getElementById("algo_key").value=aes_key;
    document.getElementById("algo_iv").value=aes_iv; 
    if(document.getElementById("sql_statement").value!==""){
       document.getElementById("sql_statement").value=phpsploit_decode(document.getElementById("sql_statement").value,"' . $_key . '","' . $_iv . '"); 
    }
    if(document.getElementById("algo_user").value!==""){
       document.getElementById("algo_user").value=phpsploit_decode(document.getElementById("algo_user").value,"' . $_key . '","' . $_iv . '");
    }
    if(document.getElementById("algo_password").value!==""){
       document.getElementById("algo_password").value=phpsploit_decode(document.getElementById("algo_password").value,"' . $_key . '","' . $_iv . '");
    }
    if(document.getElementById("result_data").value!==""){
       document.getElementById("result_data").value=phpsploit_decode(document.getElementById("result_data").value,"' . $_key . '","' . $_iv . '");
    }
}
function to_submit(form_object){ 
    form_object.string.value=phpsploit_encode(document.getElementById("sql_statement").value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value);
    document.getElementById("sql_statement").value=""; 
    form_object.user_name.value=phpsploit_encode(document.getElementById("algo_user").value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value);
    document.getElementById("algo_user").value=""; 
    form_object.user_password.value=phpsploit_encode(document.getElementById("algo_password").value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value);
    document.getElementById("algo_password").value=""; 
    console.log(phpsploit_decode(form_object.string.value,form_object.user_name.value,form_object.user_password.value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value)); 
    document.getElementById("algo_key").value="";
    document.getElementById("algo_iv").value="";
    console.log("form is submit");
    return true;
}
</script>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function exec ( $params = array () )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_drive_type = Class_Base_Request::form ( "drive_type" , Class_Base_Request::TYPE_STRING , Class_Base_Database::TYPE_DRIVE_MYSQL );
        $_domain     = Class_Base_Request::form ( "domain" , Class_Base_Request::TYPE_STRING , Class_Base_Database::DOMAIN_LOCALHOST );
        $_port       = Class_Base_Request::form ( "port" , Class_Base_Request::TYPE_INTEGER , Class_Base_Database::PORT_LOCALHOST );
        $_user       = Class_Base_Request::form ( "user_name" , Class_Base_Request::TYPE_STRING , "" );
        $_password   = Class_Base_Request::form ( "user_password" , Class_Base_Request::TYPE_STRING , "" );
        $_string     = Class_Base_Request::form ( "string" , Class_Base_Request::TYPE_STRING , "" );
        $_type       = Class_Base_Request::form ( "type" , Class_Base_Request::TYPE_INTEGER , Class_Base_Security::TYPE_ENCODE_CRYPTO_JS );
        $_key        = ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] );
        $_iv         = ( $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ] );
        $_result     = "";
        if ( ( is_string ( $_user ) ) && ( strlen ( $_user ) > 0 ) && ( is_string ( $_password ) ) && ( is_string ( $_string ) ) && ( strlen ( $_string ) > 0 ) && ( is_integer ( $_type ) ) && ( Class_Base_Security::is_phpsploit_encode_type ( $_type ) ) && ( is_string ( $_key ) ) && ( strlen ( $_key ) > 0 ) && ( is_string ( $_iv ) ) && ( strlen ( $_iv ) > 0 ) ) {
            if ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) {
                $_user     = Class_Base_Security::phpsploit_decode_128 ( $_user , $_key , $_iv );
                $_password = Class_Base_Security::phpsploit_decode_128 ( $_password , $_key , $_iv );
                $_string   = Class_Base_Security::phpsploit_decode_128 ( $_string , $_key , $_iv );
                if ( ( is_string ( $_user ) ) && ( strlen ( $_user ) > 0 ) && ( is_string ( $_password ) ) && ( is_string ( $_string ) ) && ( strlen ( $_string ) > 0 ) ) {
                    Class_Base_Database::connect ( $_drive_type , $_domain , $_port , $_user , $_password , array ( \PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING ) );
                    $_result = Class_Base_Database::exec_sqls_string ( $_string );
                    if ( $_result === false ) {
                        $_result = array ();
                        $_error  = Class_Base_Database::get_error_infos ();
                    }
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_KEY" ] = "";
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_JS_ENCODE_SOURCE_CODE_RAND_IV" ]  = "";
                }
            }
        }
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Database Exec</div>';
            $_form_top    .= '<div style="margin-top:32px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This function module is mainly used for SQL statement execution, please use this function with caution! Incorrect SQL execution statements may increase the performance burden of the database server and even pose data security risks! Before performing this operation, you should fully obtain legal authorization from the authorized party! Any unauthorized SQL query behavior is illegal, and you may bear the relevant legal consequences as a result! This module function can only be used for activities such as penetration testing, security auditing, and security technology research with legal authorization. Please treat it with caution!</div>';
            $_form        = array (
                "action"    => "/database/exec" ,
                "hiddens"   => array (
                    array (
                        "id"    => "encode_sql" ,
                        "name"  => "string" ,
                        "value" => "" ,
                    ) ,
                    array (
                        "id"    => "encode_user" ,
                        "name"  => "user_name" ,
                        "value" => "" ,
                    ) ,
                    array (
                        "id"    => "encode_password" ,
                        "name"  => "user_password" ,
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
                    array (
                        "id"       => "algo_domain" ,
                        "title"    => "( Database domain ) : " ,
                        "describe" => "domain" ,
                        "name"     => "domain" ,
                        "value"    => $_domain ,
                    ) ,
                    array (
                        "id"       => "algo_port" ,
                        "title"    => "( Database Port ) : " ,
                        "describe" => "port" ,
                        "name"     => "port" ,
                        "value"    => $_port ,
                    ) ,
                    array (
                        "id"       => "algo_user" ,
                        "title"    => "( Database User ) : " ,
                        "describe" => "user" ,
                        "name"     => "show_user" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_user ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( $_user , $_key , $_iv ) ) : ( $_user ) ) ,
                    ) ,
                    array (
                        "id"       => "algo_password" ,
                        "title"    => "( Database Password ) : " ,
                        "describe" => "password" ,
                        "name"     => "show_password" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_password ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( $_password , $_key , $_iv ) ) : ( $_password ) ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => "sql_statement" ,
                        "title" => "( SQL Statement   )   : " ,
                        "name"  => "show_string" ,
                        "value" => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_string ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( $_string , $_key , $_iv ) ) : ( $_string ) ) ,
                    ) ,
                    array (
                        "id"       => "result_data" ,
                        "title"    => "( Result Data )   : " ,
                        "name"     => "result" ,
                        "value"    => ( ( $_type == Class_Base_Security::TYPE_ENCODE_CRYPTO_JS ) ? ( empty( $_result ) ? ( "" ) : Class_Base_Security::phpsploit_encode_128 ( print_r ( $_result , true ) , $_key , $_iv ) ) : ( $_result ) ) ,
                        "disabled" => "disabled" ,
                    ) ,
                    array (
                        "id"       => "error_data" ,
                        "title"    => "( Error Data )   : " ,
                        "name"     => "error" ,
                        "value"    => print_r ( $_error , true ) ,
                        "disabled" => "disabled" ,
                    ) ,
                ) ,
            );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Database_Menu::menu ( array () ) ,
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
            $_javascript  = '<script type="text/javascript">
function init(){ 
    document.getElementById("algo_key").value=aes_key;
    document.getElementById("algo_iv").value=aes_iv; 
    if(document.getElementById("sql_statement").value!==""){
       document.getElementById("sql_statement").value=phpsploit_decode(document.getElementById("sql_statement").value,"' . $_key . '","' . $_iv . '"); 
    }
    if(document.getElementById("algo_user").value!==""){
       document.getElementById("algo_user").value=phpsploit_decode(document.getElementById("algo_user").value,"' . $_key . '","' . $_iv . '");
    }
    if(document.getElementById("algo_password").value!==""){
       document.getElementById("algo_password").value=phpsploit_decode(document.getElementById("algo_password").value,"' . $_key . '","' . $_iv . '");
    }
    if(document.getElementById("result_data").value!==""){
       document.getElementById("result_data").value=phpsploit_decode(document.getElementById("result_data").value,"' . $_key . '","' . $_iv . '");
    }
}
function to_submit(form_object){ 
    form_object.string.value=phpsploit_encode(document.getElementById("sql_statement").value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value);
    document.getElementById("sql_statement").value=""; 
    form_object.user_name.value=phpsploit_encode(document.getElementById("algo_user").value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value);
    document.getElementById("algo_user").value=""; 
    form_object.user_password.value=phpsploit_encode(document.getElementById("algo_password").value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value);
    document.getElementById("algo_password").value=""; 
    console.log(phpsploit_decode(form_object.string.value,form_object.user_name.value,form_object.user_password.value,document.getElementById("algo_key").value,document.getElementById("algo_iv").value)); 
    document.getElementById("algo_key").value="";
    document.getElementById("algo_iv").value="";
    console.log("form is submit");
    return true;
}
</script>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

}