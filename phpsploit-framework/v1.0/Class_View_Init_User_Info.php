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

class Class_View_Init_User_Info extends Class_View
{
    public static function init ( $params = array () )
    {
        if ( ! is_cli () ) {
            if ( ! is_array ( $params ) ) {
                $params = array ();
            }
            if ( ( ! isset( $params[ "privilege_user" ] ) ) || ( ! is_string ( $params[ "privilege_user" ] ) ) || ( strlen ( $params[ "privilege_user" ] ) <= 0 ) ) {
                $params[ "privilege_user" ] = "";
            }
            if ( ( ! isset( $params[ "privilege_password" ] ) ) || ( ! is_string ( $params[ "privilege_password" ] ) ) || ( strlen ( $params[ "privilege_password" ] ) <= 0 ) ) {
                $params[ "privilege_password" ] = "";
            }
            $_cli_url        = Class_Base_Response::get_cli_url ( "init_user_info" , array ( "privilege_user" => $params[ "privilege_user" ] , "privilege_password" => $params[ "privilege_password" ] ) );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_content        = '<div style="height:16px;margin-top:32px;"></div><div style="line-height:32px;font-size:32px;text-align: center;">Initialize in phpsploit-framework</div><div style="height:32px;"></div>';
            $_content        .= '<div style="width:80%;word-break:break-all;margin-top:32px;padding-left:10%;padding-right:0;text-align: left;font-size: 18px;">Important Note : <span style="font-size: 18px;color:red;">You need to remember the username, user password, cli token, and other information generated after each initialization of the phpsploit framework software! After you exit the phpsploit framework software and before re initializing the phpsploit framework software, you need to use the generated username, user password, and cli token to log in and use the phpsploit framework software! If you do not remember the username, user password, cli token, and other information generated after the initialization of the phpsploit framework software, it may cause you to be unable to continue using the phpsploit framework software after it exits, until you perform the initialization operation on the phpsploit framework software again!</div>';
            return ( Class_View::form_page (
                array (
                    "title"   => "login to phpsploit-framework" ,
                    "content" => $_content ,
                ) ,
                array (
                    "action"    => "/login" ,
                    "hiddens"   => array (
                        array (
                            "name"   => "user" ,
                            "value"  => $params[ "user" ] ,
                            "events" => array () ,
                        ) ,
                        array (
                            "name"   => "password" ,
                            "value"  => $params[ "password" ] ,
                            "events" => array () ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "title"    => "User : " ,
                            "describe" => "user" ,
                            "name"     => "show_user" ,
                            "value"    => $params[ "user" ] ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "Password : " ,
                            "describe" => "password" ,
                            "name"     => "show_password" ,
                            "value"    => $params[ "password" ] ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "Cli Token : " ,
                            "describe" => "Cli Token" ,
                            "name"     => "cli_token" ,
                            "value"    => $params[ "security_token" ] ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "Privileged User : " ,
                            "describe" => "Privileged User" ,
                            "name"     => "privilege_user" ,
                            "value"    => $params[ "privilege_user" ] ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "title"    => "Privileged Password : " ,
                            "describe" => "Privileged Password" ,
                            "name"     => "privilege_password" ,
                            "value"    => $params[ "privilege_password" ] ,
                            "disabled" => "disabled" ,
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
                        "title" => "( Start To Login Phpsploit-Framework Software )" ,
                        "name"  => "submit_form" ,
                        "value" => "submit" ,
                    ) ,
                    "gets"      => array () ,
                ) ,
                array (
                    "menu"       => array () ,
                    "content"    => "<div></div>" ,
                    "javascript" => '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return confirm_submit();} function confirm_submit(){if(confirm(\'Are you sure you want to click the `submit` button now ? Before officially clicking the `submit` button, you should keep in mind the dynamically generated `User, Password, Cli Token` and other information, as they will be used to log in to the web or command - line environment of the Phpsploit Framework software!If you do not remember the above information, it will cause you to be unable to use the Phpsploit Framework software properly!If you forget information such as` User, Password, Cli Token `, you need to contact the server administrator of the environment where the Phpsploit Framework software is located and have them take corresponding actions on the shared memory . In general, the Phpsploit Framework software uses shared memory with KEY `0x5d8a0000` and KEY `0x5d8a0001` to store login information for the Phpsploit Framework software . However, it is not ruled out that other software will use these two shared memory resources, and you need to identify them according to the specific situation!If the shared memory with KEY of `0x5d8a0000` and KEY of `0x5d8a0001` is occupied by the Phpsploit Framework software, in a scenario where no special unexpected circumstances occur, the access permission to the shared memory with KEY of `0x5d8a0000` is `660`, and the space size of the shared memory with KEY of `0x5d8a0000` is `32 bytes`; The access permission for shared memory with KEY `0x5d8a0001` is` 660 `, and the space size for shared memory with KEY` 0x5d8a0001 `is` 1048712 bytes` . You can view shared memory information through the ipcs -m command ( which may require sufficient access and operation permissions), and you can use the ipcrm -M ' . Class_Base_Format::htmlentities ( '<shmem key>' ) . ' command to clean up specified shared memory resources.Appropriate shared memory cleaning operations can reset the login authentication information of Phpsploit Framework software! However, you must take it seriously and maintain a cautious attitude towards the cleaning of shared memory. Improper memory data cleaning operations may lead to system or software and hardware resources crashing, damaging, and related storage data loss and damage!\')){this.type="submit";return true;}else{this.type="button";return false;}}</script>' ,
                )
            ) );
        }
        return null;
    }
}