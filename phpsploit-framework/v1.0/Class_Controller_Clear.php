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

class Class_Controller_Clear extends Class_Controller
{
    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_start              = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_privilege_user     = Class_Base_Request::form ( "privilege_user" , Class_Base_Request::TYPE_STRING , "" );
        $_privilege_password = Class_Base_Request::form ( "privilege_password" , Class_Base_Request::TYPE_STRING , "" );
        if ( ! empty( $_start ) ) {
            $_privilege_user_length     = strlen ( $_privilege_user );
            $_privilege_password_length = strlen ( $_privilege_password );
            if ( $_privilege_user_length <= 0 ) {
                Class_Base_Response::outputln ( "Please enter the account name of the privileged account!" );
            }
            if ( $_privilege_password_length <= 0 ) {
                Class_Base_Response::outputln ( "Please enter the account password of the privileged account!" );
            }
            if ( Class_Operate_User::check_privilege_user_and_password_for_clear ( $_privilege_user , $_privilege_password ) ) {
                Class_Base_Auth::clear ();
                if ( ! is_cli () ) {
                    Class_Base_Response::redirect ( "/login" );
                } else {
                    Class_Base_Response::outputln ( "If there are no unexpected circumstances, you have logged out and cleared the account information in the Phpsploit Framework software. However, due to other reasons such as access permissions, the cleaning of shared memory may also fail! After successfully clearing the shared memory information, if you need to use the Phpsploit Framework software again, you will need to access the initialization interface (/init) again to reinitialize your Phpsploit Framework software account information. After successful initialization, you will receive a new initial password and command line access token! When you fail to clear the shared memory information (mainly manifested as: you have already performed the/clear operation to clear the shared memory, but the next time you use the Phpsploit Framework software, you do not perform the initialization work again, but instead skip to the login interface), You may need to manually clear relevant shared memory information using IPC series commands (you can view the list of shared memory through ipcs -m, or use ipcrm -m <shm id> or ipcrm -M <shm key> to clear specified shared memory messages).You may need to perform ipcrm - M 0x5d8a0000 and ipcrm - M 0x5d8a0001 operations to repair the failure of/clear behavior in a command line environment! Note that 0x5d8a0000 and 0x5d8a0001 are not necessarily shared memory data of the Phpsploit Framework software, and may also be occupied by other software programs! You need to compare the feature information of the relevant shared memory data before making appropriate actions (note that for deletion operations, you should maintain a cautious attitude! Improper deletion behavior may lead to system or software crashes, or lead to adverse consequences such as damage or loss of system or software data!)! Under normal circumstances, the Phpsploit Framework software will use two key values, 0x5d8a0000 and 0x5d8a0001, in shared memory. The access permission value corresponding to the shared memory KEY key (0x5d8a0000) is an octal number (660), and the memory space usage size corresponding to the shared memory KEY key (0x5d8a0000) is a decimal number (32); The access permission value corresponding to the shared memory KEY key (0x5d8a0001) is an octal number (660), and the memory space occupation size corresponding to the shared memory KEY key (0x5d8a0001) is a decimal number (1048712);" );
                }
            } else {
                if ( ! is_cli () ) {
                    Class_Base_Response::outputln ( '<div style="width:100%;position: absolute;top:25%;font-size:26px;color:red;text-align: center;">Privileged user or password error! After 3 seconds, automatically return to the previous interface!</div><script type="text/javascript">setTimeout("history.back()",3000);</script>' );
                } else {
                    Class_Base_Response::outputln ( "Failed to verify the name and password information of the privileged account! Unable to call the \"/clear\" interface to reset the account information of the Phpsploit Framework software! You can try again after carefully verifying the name and password information of the privileged account. If the execution still fails, please contact the target host administrator who is conducting penetration testing or security audit behavior. The target host administrator will clean up the shared memory as appropriate (Note that under the condition of no unexpected or special circumstances, the shared memory resources used by the Phpsploit Framework software related to the software account are: 1. key=0x5d8a0000, perms=660, size=64; 2. key=0x5d8a0001, perms=660, size=1048712)!" );
                }
            }
            return null;
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response::get_cli_url ( "/clear" , array ( "start" => 1 , "privilege_user" => $_privilege_user , "privilege_password" => $_privilege_password ) );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Clean Up Authentication And Shared Memory Information</div>';
            $_form_top       .= '<div style="width:100%;word-break:break-all;margin-top:32px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is mainly used to reset the account authentication and shared memory information of the Phpsploit Framework software, This module function requires the transmission of correct privileged account and password information! Incorrect account and password information will result in a failed cleanup action! After successfully clearing the shared memory information, if you need to use the Phpsploit Framework software again, you will need to access the initialization interface (/init) again to reinitialize your Phpsploit Framework software account information. After successful initialization, you will receive a new initial password and command line access token! When you fail to clear the shared memory information (mainly manifested as: you have already performed the/clear operation to clear the shared memory, but the next time you use the Phpsploit Framework software, you do not perform the initialization work again, but instead skip to the login interface), You may need to manually clear relevant shared memory information using IPC series commands (you can view the list of shared memory through ipcs -m, or use ipcrm -m <shm id> or ipcrm -M <shm key> to clear specified shared memory messages).You may need to perform ipcrm - M 0x5d8a0000 and ipcrm - M 0x5d8a0001 operations to repair the failure of/clear behavior in a command line environment! Note that 0x5d8a0000 and 0x5d8a0001 are not necessarily shared memory data of the Phpsploit Framework software, and may also be occupied by other software programs! You need to compare the feature information of the relevant shared memory data before making appropriate actions (note that for deletion operations, you should maintain a cautious attitude! Improper deletion behavior may lead to system or software crashes, or lead to adverse consequences such as damage or loss of system or software data!)! Under normal circumstances, the Phpsploit Framework software will use two key values, 0x5d8a0000 and 0x5d8a0001, in shared memory. The access permission value corresponding to the shared memory KEY key (0x5d8a0000) is an octal number (660), and the memory space usage size corresponding to the shared memory KEY key (0x5d8a0000) is a decimal number (32); The access permission value corresponding to the shared memory KEY key (0x5d8a0001) is an octal number (660), and the memory space occupation size corresponding to the shared memory KEY key (0x5d8a0001) is a decimal number (1048712).</div>';
            $_form_name      = "form_0";
            $_form           = array (
                "action"    => "/clear" ,
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
                        "id"       => "privilege_user" ,
                        "title"    => "( Privilege User ) : " ,
                        "describe" => "Privilege User" ,
                        "name"     => "privilege_user" ,
                        "value"    => $_privilege_user ,
                    ) ,
                    array (
                        "id"       => "privilege_password" ,
                        "title"    => "( Privilege Password ) : " ,
                        "describe" => "Privilege Password" ,
                        "name"     => "privilege_password" ,
                        "value"    => $_privilege_password ,
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
                    "title" => "( Clear )" ,
                    "name"  => "submit_form" ,
                    "value" => "clean up authentication and shared memory information" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset" ,
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
            $_top            = Class_View_Top::top ();
            $_body           = array (
                "menu"    => Class_View_Shell_Menu::menu ( array () ) ,
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
            $_javascript     = '<script type="text/javascript">function init(){ } function to_submit(form_object){  if(form_object.privilege_user.value==""){ alert("Privileged User cannot be empty!"); return false; } if(form_object.privilege_password.value==""){ alert("Privileged Password cannot be empty!"); return false; } console.log("form is submit"); return true;}function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom         = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }
}