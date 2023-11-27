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

class Class_Controller_Report extends Class_Controller
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
                "menu"    => Class_View_Report_Menu ::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom ::bottom ();
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function create_vulnerability_report ( $params = array () )
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
        $_is_append                 = false;
        $_risk_level_limits         = array ( 1 , 2 , 3 , 4 , 5 , );
        $_discovery_method_limits   = array ( 1 , 2 , );
        $_vulnerability_type_limits = array ( 1 , 2 , 3 , 4 , 5 , );
        for ( $index = 0 ; $index < 10 ; $index ++ ) {
            $_risk_level                                               = Class_Base_Request ::form ( "risk_level_" . $index , Class_Base_Request::TYPE_INTEGER , 0 );
            $_discovery_method                                         = Class_Base_Request ::form ( "discovery_method_" . $index , Class_Base_Request::TYPE_INTEGER , 0 );
            $_vulnerability_type                                       = Class_Base_Request ::form ( "vulnerability_type_" . $index , Class_Base_Request::TYPE_INTEGER , 0 );
            $_vulnerability_name                                       = Class_Base_Request ::form ( "vulnerability_name_" . $index , Class_Base_Request::TYPE_STRING , "" );
            $_vulnerability_discovery_personnel                        = Class_Base_Request ::form ( "vulnerability_discovery_personnel_" . $index , Class_Base_Request::TYPE_STRING , "" );
            $_contact_information_of_vulnerability_discovery_personnel = Class_Base_Request ::form ( "contact_information_of_vulnerability_discovery_personnel_" . $index , Class_Base_Request::TYPE_STRING , "" );
            $_vulnerability_impact                                     = Class_Base_Request ::form ( "vulnerability_impact_" . $index , Class_Base_Request::TYPE_STRING , "" );
            $_vulnerability_discovery_process                          = Class_Base_Request ::form ( "vulnerability_discovery_process_" . $index , Class_Base_Request::TYPE_STRING , "" );
            $_solution_proposal                                        = Class_Base_Request ::form ( "solution_proposal_" . $index , Class_Base_Request::TYPE_STRING , "" );
            if ( ! isset( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
                $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
            }
            if ( ! is_array ( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
                $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
            }
            if ( ( in_array ( $_risk_level , $_risk_level_limits ) ) && ( in_array ( $_discovery_method , $_discovery_method_limits ) ) && ( in_array ( $_vulnerability_type , $_vulnerability_type_limits ) ) ) {
                $_vulnerability_name_length                                       = strlen ( $_vulnerability_name );
                $_vulnerability_discovery_personnel_length                        = strlen ( $_vulnerability_discovery_personnel );
                $_contact_information_of_vulnerability_discovery_personnel_length = strlen ( $_contact_information_of_vulnerability_discovery_personnel );
                if ( ( ( $_vulnerability_name_length > 0 ) && ( $_vulnerability_name_length <= 100 ) ) && ( ( $_vulnerability_discovery_personnel_length > 0 ) && ( $_vulnerability_discovery_personnel_length <= 100 ) ) && ( ( $_contact_information_of_vulnerability_discovery_personnel_length > 0 ) && ( $_contact_information_of_vulnerability_discovery_personnel_length <= 100 ) ) ) {
                    $_vulnerability_impact_length            = strlen ( $_vulnerability_impact );
                    $_vulnerability_discovery_process_length = strlen ( $_vulnerability_discovery_process );
                    $_solution_proposal_length               = strlen ( $_solution_proposal );
                    if ( ( ( $_vulnerability_impact_length > 0 ) && ( $_vulnerability_impact_length <= 10000 ) ) && ( ( $_vulnerability_discovery_process_length > 0 ) && ( $_vulnerability_discovery_process_length <= 10000 ) ) && ( ( $_solution_proposal_length > 0 ) && ( $_solution_proposal_length <= 10000 ) ) ) {
                        $_SESSION[ "VULNERABILITY_REPORT" ][] = array (
                            "risk_level"                                               => $_risk_level ,
                            "discovery_method"                                         => $_discovery_method ,
                            "vulnerability_type"                                       => $_vulnerability_type ,
                            "vulnerability_name"                                       => $_vulnerability_name ,
                            "vulnerability_discovery_personnel"                        => $_vulnerability_discovery_personnel ,
                            "contact_information_of_vulnerability_discovery_personnel" => $_contact_information_of_vulnerability_discovery_personnel ,
                            "vulnerability_impact"                                     => $_vulnerability_impact ,
                            "vulnerability_discovery_process"                          => $_vulnerability_discovery_process ,
                            "solution_proposal"                                        => $_solution_proposal ,
                        );
                        $_is_append                           = true;
                    }
                }
            }
        }
        if ( ( $_is_append ) && ( ! empty( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) ) {
            Class_Base_Response ::redirect ( "/report/show_vulnerability_report" , array () );
            return null;
        }

        $_result                 = "";
        $_connect_domain_List_id = "result_data";
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Create Vulnerability Report</div>';
            $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to create vulnerability reports, which include vulnerability names, vulnerability types, vulnerability risk levels, vulnerability discovery methods, vulnerability discovery processes, vulnerability impact levels, solution suggestions for vulnerabilities, vulnerability discoverers, and their contact information. By using this module function, you can easily create vulnerability reports online.</div>';
            $_form_id     = ( 'report_vulnerability_report_form_id' );
            $_form        = array (
                "action"    => "/report/create_vulnerability_report" ,
                "id"        => $_form_id ,
                "name"      => "report_vulnerability_report_form" ,
                "hiddens"   => array () ,
                "selects"   => array () ,
                "inputs"    => array () ,
                "textareas" => array () ,
                "files"     => array () ,
                "submit"    => array ( "id" => "submit" , "name" => "submit" , "value" => "submit" ) ,
                "reset"     => array ( "id" => "reset" , "name" => "reset" , "value" => "reset" ) ,
                "button"    => array (
                    "id"      => "add_new_form" ,
                    "name"    => "add_new_form" ,
                    "value"   => "Add a new vulnerability information form" ,
                    "display" => false ,
                    "events"  => array (
                        "onclick" => 'click_dyn_add_button(\'' . Class_Base_Format ::htmlentities ( $_form_id ) . '\',\'dyn_form_hidden_index_id\');' ,
                    ) ,
                ) ,
            );
            $_dyn_form    = array (
                "id"        => $_form_id ,
                "style"     => "display:none;" ,
                "hiddens"   => array () ,
                "selects"   => array (
                    array (
                        "id"      => "risk_level" ,
                        "title"   => "Risk Level : " ,
                        "name"    => "risk_level" ,
                        "options" => array (
                            array ( "describe" => "Mild danger" , "title" => "Mild danger" , "value" => 1 , "selected" => ( ( $_risk_level == 1 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Mild to moderate danger" , "title" => "Mild to moderate danger" , "value" => 2 , "selected" => ( ( $_risk_level == 2 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Moderate danger" , "title" => "Moderate danger" , "value" => 3 , "selected" => ( ( $_risk_level == 3 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Moderate to severe danger" , "title" => "Moderate to severe danger" , "value" => 4 , "selected" => ( ( $_risk_level == 4 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Severe danger" , "title" => "Severe danger" , "value" => 5 , "selected" => ( ( $_risk_level == 5 ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                    array (
                        "id"      => "discovery_method" ,
                        "title"   => "Discovery method : " ,
                        "name"    => "discovery_method" ,
                        "options" => array (
                            array ( "describe" => "Black box penetration test" , "title" => "Black box penetration test" , "value" => 1 , "selected" => ( ( $_discovery_method == 1 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "White box penetration test" , "title" => "White box penetration test" , "value" => 2 , "selected" => ( ( $_discovery_method == 2 ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                    array (
                        "id"      => "vulnerability_type" ,
                        "title"   => "Vulnerability type : " ,
                        "name"    => "vulnerability_type" ,
                        "options" => array (
                            array ( "describe" => "Network vulnerabilities" , "title" => "Network vulnerabilities" , "value" => 1 , "selected" => ( ( $_vulnerability_type == 1 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "System vulnerabilities" , "title" => "System vulnerabilities" , "value" => 2 , "selected" => ( ( $_vulnerability_type == 2 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Software vulnerabilities" , "title" => "Software vulnerabilities" , "value" => 3 , "selected" => ( ( $_vulnerability_type == 3 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Web Site vulnerabilities" , "title" => "Web Site vulnerabilities" , "value" => 4 , "selected" => ( ( $_vulnerability_type == 4 ) ? "selected" : "" ) ) ,
                            array ( "describe" => "Other types of vulnerabilities" , "title" => "Other types of vulnerabilities" , "value" => 5 , "selected" => ( ( $_vulnerability_type == 5 ) ? "selected" : "" ) ) ,
                        ) ,
                    ) ,
                ) ,
                "inputs"    => array (
                    array (
                        "id"       => "vulnerability_name" ,
                        "title"    => "Vulnerability Name : " ,
                        "describe" => "Vulnerability Name" ,
                        "name"     => "vulnerability_name" ,
                        "value"    => ( $_vulnerability_name ) ,
                    ) ,
                    array (
                        "id"       => "vulnerability_discovery_personnel" ,
                        "title"    => "Vulnerability Discovery Personnel : " ,
                        "describe" => "Vulnerability Discovery Personnel" ,
                        "name"     => "vulnerability_discovery_personnel" ,
                        "value"    => ( $_vulnerability_discovery_personnel ) ,
                    ) ,
                    array (
                        "id"       => "contact_information_of_vulnerability_discovery_personnel" ,
                        "title"    => "Contact information of vulnerability discovery personnel : " ,
                        "describe" => "Contact information of vulnerability discovery personnel" ,
                        "name"     => "contact_information_of_vulnerability_discovery_personnel" ,
                        "value"    => ( $_contact_information_of_vulnerability_discovery_personnel ) ,
                    ) ,
                ) ,
                "textareas" => array (
                    array (
                        "id"    => 'vulnerability_impact' ,
                        "title" => "Vulnerability Impact : " ,
                        "name"  => "vulnerability_impact" ,
                        "value" => ( $_vulnerability_impact ) ,
                        "style" => 'height:200px;' ,
                    ) ,
                    array (
                        "id"    => 'vulnerability_discovery_process' ,
                        "title" => "Vulnerability Discovery Process : " ,
                        "name"  => "vulnerability_discovery_process" ,
                        "value" => ( $_vulnerability_discovery_process ) ,
                        "style" => 'height:300px;' ,
                    ) ,
                    array (
                        "id"    => 'solution_proposal' ,
                        "title" => "Solution_proposal : " ,
                        "name"  => "solution_proposal" ,
                        "value" => ( $_solution_proposal ) ,
                        "style" => 'height:400px;' ,
                    ) ,
                ) ,
                "files"     => array () ,
                "submit"    => array ( "name" => "submit" ) ,
                "reset"     => array ( "name" => "reset" ) ,
                "button"    => array ( "name" => "add_new_form" ) ,
            );
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Report_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View ::form_body ( $_form ) . Class_View ::dyn_form_body ( $_dyn_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ click_dyn_add_button(\'' . Class_Base_Format ::htmlentities ( $_form_id ) . '\',\'dyn_form_hidden_index_id\'); } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function edit_vulnerability_report ( $params = array () )
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
        if ( ! isset( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
            $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
        }
        if ( ! is_array ( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
            $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
        }
        $_is_updated                = false;
        $_risk_level_limits         = array ( 1 , 2 , 3 , 4 , 5 , );
        $_discovery_method_limits   = array ( 1 , 2 , );
        $_vulnerability_type_limits = array ( 1 , 2 , 3 , 4 , 5 , );
        for ( $report_index = 0 ; $report_index < 50 ; $report_index ++ ) {
            $_risk_level                                               = Class_Base_Request ::form ( "risk_level_" . $report_index , Class_Base_Request::TYPE_INTEGER , 0 );
            $_discovery_method                                         = Class_Base_Request ::form ( "discovery_method_" . $report_index , Class_Base_Request::TYPE_INTEGER , 0 );
            $_vulnerability_type                                       = Class_Base_Request ::form ( "vulnerability_type_" . $report_index , Class_Base_Request::TYPE_INTEGER , 0 );
            $_vulnerability_name                                       = Class_Base_Request ::form ( "vulnerability_name_" . $report_index , Class_Base_Request::TYPE_STRING , "" );
            $_vulnerability_discovery_personnel                        = Class_Base_Request ::form ( "vulnerability_discovery_personnel_" . $report_index , Class_Base_Request::TYPE_STRING , "" );
            $_contact_information_of_vulnerability_discovery_personnel = Class_Base_Request ::form ( "contact_information_of_vulnerability_discovery_personnel_" . $report_index , Class_Base_Request::TYPE_STRING , "" );
            $_vulnerability_impact                                     = Class_Base_Request ::form ( "vulnerability_impact_" . $report_index , Class_Base_Request::TYPE_STRING , "" );
            $_vulnerability_discovery_process                          = Class_Base_Request ::form ( "vulnerability_discovery_process_" . $report_index , Class_Base_Request::TYPE_STRING , "" );
            $_solution_proposal                                        = Class_Base_Request ::form ( "solution_proposal_" . $report_index , Class_Base_Request::TYPE_STRING , "" );
            if ( ! isset( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
                $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
            }
            if ( ! is_array ( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
                $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
            }
            if ( ( in_array ( $_risk_level , $_risk_level_limits ) ) && ( in_array ( $_discovery_method , $_discovery_method_limits ) ) && ( in_array ( $_vulnerability_type , $_vulnerability_type_limits ) ) ) {
                $_vulnerability_name_length                                       = strlen ( $_vulnerability_name );
                $_vulnerability_discovery_personnel_length                        = strlen ( $_vulnerability_discovery_personnel );
                $_contact_information_of_vulnerability_discovery_personnel_length = strlen ( $_contact_information_of_vulnerability_discovery_personnel );
                if ( ( ( $_vulnerability_name_length > 0 ) && ( $_vulnerability_name_length <= 100 ) ) && ( ( $_vulnerability_discovery_personnel_length > 0 ) && ( $_vulnerability_discovery_personnel_length <= 100 ) ) && ( ( $_contact_information_of_vulnerability_discovery_personnel_length > 0 ) && ( $_contact_information_of_vulnerability_discovery_personnel_length <= 100 ) ) ) {
                    $_vulnerability_impact_length            = strlen ( $_vulnerability_impact );
                    $_vulnerability_discovery_process_length = strlen ( $_vulnerability_discovery_process );
                    $_solution_proposal_length               = strlen ( $_solution_proposal );
                    if ( ( ( $_vulnerability_impact_length > 0 ) && ( $_vulnerability_impact_length <= 10000 ) ) && ( ( $_vulnerability_discovery_process_length > 0 ) && ( $_vulnerability_discovery_process_length <= 10000 ) ) && ( ( $_solution_proposal_length > 0 ) && ( $_solution_proposal_length <= 10000 ) ) ) {
                        $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ] = array (
                            "risk_level"                                               => $_risk_level ,
                            "discovery_method"                                         => $_discovery_method ,
                            "vulnerability_type"                                       => $_vulnerability_type ,
                            "vulnerability_name"                                       => $_vulnerability_name ,
                            "vulnerability_discovery_personnel"                        => $_vulnerability_discovery_personnel ,
                            "contact_information_of_vulnerability_discovery_personnel" => $_contact_information_of_vulnerability_discovery_personnel ,
                            "vulnerability_impact"                                     => $_vulnerability_impact ,
                            "vulnerability_discovery_process"                          => $_vulnerability_discovery_process ,
                            "solution_proposal"                                        => $_solution_proposal ,
                        );
                        $_is_updated                                         = true;
                    }
                }
            }
        }
        if ( ( $_is_updated ) && ( ! empty( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) ) {
            Class_Base_Response ::redirect ( "/report/show_vulnerability_report" , array () );
            return null;
        }
        if ( ! is_cli () ) {
            if ( empty( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
                $_form_top = '<div style="margin-top:64px;text-align: left;font-size: 18px;"></div>';
                $_form_top .= '<div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;"></div>';
            } else {
                $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Edit Vulnerability Report</div>';
                $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module function is used to edit vulnerability reports, which include vulnerability names, vulnerability types, vulnerability risk levels, vulnerability discovery methods, vulnerability discovery processes, vulnerability impact levels, solution suggestions for vulnerabilities, vulnerability discoverers, and their contact information. By using this module function, you can easily edit vulnerability reports online.</div>';
            }
            $_form_id   = ( 'report_vulnerability_report_form_id' );
            $_form_html = '';
            $_forms     = array ();
            foreach ( $_SESSION[ "VULNERABILITY_REPORT" ] as $report_index => $item ) {
                $_forms[ $report_index ] = array (
                    "action"    => "/report/edit_vulnerability_report" ,
                    "id"        => ( $_form_id . "_" . $report_index ) ,
                    "name"      => "report_vulnerability_report_form_" . $report_index ,
                    "hiddens"   => array (
                        array (
                            "id"    => "roport_index_" . $report_index ,
                            "name"  => "report_index_" . $report_index ,
                            "value" => $report_index ,
                        ) ,
                    ) ,
                    "selects"   => array (
                        array (
                            "id"      => "risk_level_" . $report_index ,
                            "title"   => "Risk Level : " ,
                            "name"    => "risk_level_" . $report_index ,
                            "options" => array (
                                array ( "describe" => "Mild danger" , "title" => "Mild danger" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Mild to moderate danger" , "title" => "Mild to moderate danger" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 2 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Moderate danger" , "title" => "Moderate danger" , "value" => 3 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 3 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Moderate to severe danger" , "title" => "Moderate to severe danger" , "value" => 4 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 4 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Severe danger" , "title" => "Severe danger" , "value" => 5 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 5 ) ? "selected" : "" ) ) ,
                            ) ,
                        ) ,
                        array (
                            "id"      => "discovery_method_" . $report_index ,
                            "title"   => "Discovery method : " ,
                            "name"    => "discovery_method_" . $report_index ,
                            "options" => array (
                                array ( "describe" => "Black box penetration test" , "title" => "Black box penetration test" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "discovery_method" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "White box penetration test" , "title" => "White box penetration test" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "discovery_method" ] ) == 2 ) ? "selected" : "" ) ) ,
                            ) ,
                        ) ,
                        array (
                            "id"      => "vulnerability_type_" . $report_index ,
                            "title"   => "Vulnerability type : " ,
                            "name"    => "vulnerability_type_" . $report_index ,
                            "options" => array (
                                array ( "describe" => "Network vulnerabilities" , "title" => "Network vulnerabilities" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "System vulnerabilities" , "title" => "System vulnerabilities" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 2 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Software vulnerabilities" , "title" => "Software vulnerabilities" , "value" => 3 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 3 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Web Site vulnerabilities" , "title" => "Web Site vulnerabilities" , "value" => 4 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 4 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Other types of vulnerabilities" , "title" => "Other types of vulnerabilities" , "value" => 5 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 5 ) ? "selected" : "" ) ) ,
                            ) ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "id"       => "vulnerability_name_" . $report_index ,
                            "title"    => "Vulnerability Name : " ,
                            "describe" => "Vulnerability Name" ,
                            "name"     => "vulnerability_name_" . $report_index ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_name" ] ) ) ,
                        ) ,
                        array (
                            "id"       => "vulnerability_discovery_personnel_" . $report_index ,
                            "title"    => "Vulnerability Discovery Personnel : " ,
                            "describe" => "Vulnerability Discovery Personnel" ,
                            "name"     => "vulnerability_discovery_personnel_" . $report_index ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_discovery_personnel" ] ) ) ,
                        ) ,
                        array (
                            "id"       => "contact_information_of_vulnerability_discovery_personnel_" . $report_index ,
                            "title"    => "Contact information of vulnerability discovery personnel : " ,
                            "describe" => "Contact information of vulnerability discovery personnel" ,
                            "name"     => "contact_information_of_vulnerability_discovery_personnel_" . $report_index ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "contact_information_of_vulnerability_discovery_personnel" ] ) ) ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "id"    => 'vulnerability_impact_' . $report_index ,
                            "title" => "Vulnerability Impact : " ,
                            "name"  => "vulnerability_impact_" . $report_index ,
                            "value" => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_impact" ] ) ) ,
                            "style" => 'height:200px;' ,
                        ) ,
                        array (
                            "id"    => 'vulnerability_discovery_process_' . $report_index ,
                            "title" => "Vulnerability Discovery Process : " ,
                            "name"  => "vulnerability_discovery_process_" . $report_index ,
                            "value" => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_discovery_process" ] ) ) ,
                            "style" => 'height:300px;' ,
                        ) ,
                        array (
                            "id"    => 'solution_proposal_' . $report_index ,
                            "title" => "Solution_proposal : " ,
                            "name"  => "solution_proposal_" . $report_index ,
                            "value" => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "solution_proposal" ] ) ) ,
                            "style" => 'height:400px;' ,
                        ) ,
                    ) ,
                    "files"     => array () ,
                    "submit"    => array ( "id" => "submit_" . $report_index , "name" => "submit_" . $report_index , "value" => "submit" , "display" => true ) ,
                    "reset"     => array ( "id" => "reset_" . $report_index , "name" => "reset_" . $report_index , "value" => "reset" , "display" => true ) ,
                    "button"    => array (
                        "id"      => "show_report_" . $report_index ,
                        "name"    => "show_report_" . $report_index ,
                        "value"   => "show report" ,
                        "display" => true ,
                        "events"  => array (
                            "onclick" => ' document.location.href=\'' . Class_Base_Response ::get_url ( "/report/show_vulnerability_report" , array () ) . '\'; ' ,
                        ) ,
                    ) ,
                );
                $_form_html              .= Class_View ::form_body ( $_forms[ $report_index ] );
            }
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Report_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . ( $_form_html ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ console.log("init"); } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response ::outputln ( $_SESSION[ "VULNERABILITY_REPORT" ] );
        }
        return null;
    }

    public static function show_vulnerability_report ( $params = array () )
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
        if ( ! isset( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
            $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
        }
        if ( ! is_array ( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
            $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
        }
        if ( ! is_cli () ) {
            if ( empty( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
                $_form_top = '<div style="margin-top:64px;text-align: left;font-size: 18px;"></div>';
                $_form_top .= '<div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;"></div>';
            } else {
                $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Show Vulnerability Report</div>';
                $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This module is used to display vulnerability reports, which include vulnerability names, types, risk levels, discovery methods, discovery processes, impact levels, suggested solutions for vulnerabilities, and contact information for vulnerability discoverers. By using this module function, you can easily view vulnerability reports online.</div>';
            }
            $_form_id   = ( 'report_vulnerability_report_form_id' );
            $_form_html = '';
            $_forms     = array ();
            foreach ( $_SESSION[ "VULNERABILITY_REPORT" ] as $report_index => $item ) {
                $_forms[ $report_index ] = array (
                    "action"    => "/report/edit_vulnerability_report" ,
                    "id"        => ( $_form_id . "_" . $report_index ) ,
                    "name"      => "report_vulnerability_report_form" ,
                    "hiddens"   => array () ,
                    "selects"   => array (
                        array (
                            "id"       => "risk_level" ,
                            "title"    => "Risk Level : " ,
                            "name"     => "risk_level" ,
                            "options"  => array (
                                array ( "describe" => "Mild danger" , "title" => "Mild danger" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Mild to moderate danger" , "title" => "Mild to moderate danger" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 2 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Moderate danger" , "title" => "Moderate danger" , "value" => 3 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 3 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Moderate to severe danger" , "title" => "Moderate to severe danger" , "value" => 4 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 4 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Severe danger" , "title" => "Severe danger" , "value" => 5 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 5 ) ? "selected" : "" ) ) ,
                            ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "discovery_method" ,
                            "title"    => "Discovery method : " ,
                            "name"     => "discovery_method" ,
                            "options"  => array (
                                array ( "describe" => "Black box penetration test" , "title" => "Black box penetration test" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "discovery_method" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "White box penetration test" , "title" => "White box penetration test" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "discovery_method" ] ) == 2 ) ? "selected" : "" ) ) ,
                            ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "vulnerability_type" ,
                            "title"    => "Vulnerability type : " ,
                            "name"     => "vulnerability_type" ,
                            "options"  => array (
                                array ( "describe" => "Network vulnerabilities" , "title" => "Network vulnerabilities" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "System vulnerabilities" , "title" => "System vulnerabilities" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 2 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Software vulnerabilities" , "title" => "Software vulnerabilities" , "value" => 3 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 3 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Web Site vulnerabilities" , "title" => "Web Site vulnerabilities" , "value" => 4 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 4 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Other types of vulnerabilities" , "title" => "Other types of vulnerabilities" , "value" => 5 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 5 ) ? "selected" : "" ) ) ,
                            ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "id"       => "vulnerability_name" ,
                            "title"    => "Vulnerability Name : " ,
                            "describe" => "Vulnerability Name" ,
                            "name"     => "vulnerability_name" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_name" ] ) ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "vulnerability_discovery_personnel" ,
                            "title"    => "Vulnerability Discovery Personnel : " ,
                            "describe" => "Vulnerability Discovery Personnel" ,
                            "name"     => "vulnerability_discovery_personnel" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_discovery_personnel" ] ) ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "contact_information_of_vulnerability_discovery_personnel" ,
                            "title"    => "Contact information of vulnerability discovery personnel : " ,
                            "describe" => "Contact information of vulnerability discovery personnel" ,
                            "name"     => "contact_information_of_vulnerability_discovery_personnel" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "contact_information_of_vulnerability_discovery_personnel" ] ) ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "id"       => 'vulnerability_impact' ,
                            "title"    => "Vulnerability Impact : " ,
                            "name"     => "vulnerability_impact" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_impact" ] ) ) ,
                            "style"    => 'height:200px;' ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => 'vulnerability_discovery_process' ,
                            "title"    => "Vulnerability Discovery Process : " ,
                            "name"     => "vulnerability_discovery_process" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_discovery_process" ] ) ) ,
                            "style"    => 'height:300px;' ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => 'solution_proposal' ,
                            "title"    => "Solution_proposal : " ,
                            "name"     => "solution_proposal" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "solution_proposal" ] ) ) ,
                            "style"    => 'height:400px;' ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "files"     => array () ,
                    "submit"    => array ( "id" => "submit" , "name" => "submit" , "value" => " edit report " , "display" => true ) ,
                    "reset"     => array ( "id" => "reset" , "name" => "reset" , "value" => "reset" , "display" => false ) ,
                    "button"    => array (
                        "id"      => "delete" ,
                        "name"    => "delete" ,
                        "value"   => " delete report entry " ,
                        "display" => true ,
                        "events"  => array (
                            "onclick" => ' document.location.href=\'' . Class_Base_Response ::get_url ( "/report/delete_vulnerability_report" , array () ) . '\'; ' ,
                        ) ,
                    ) ,
                );
                $_form_html              .= Class_View ::form_body ( $_forms[ $report_index ] );
            }
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Report_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . ( $_form_html ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ console.log("init"); } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response ::outputln ( $_SESSION[ "VULNERABILITY_REPORT" ] );
        }
        return null;
    }

    public static function delete_vulnerability_report ( $params = array () )
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
        if ( ! isset( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
            $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
        }
        if ( ! is_array ( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
            $_SESSION[ "VULNERABILITY_REPORT" ] = array ();
        }
        for ( $report_index = 0 ; $report_index < 100 ; $report_index ++ ) {
            $_report_index = Class_Base_Request ::form ( "report_index_" . $report_index , Class_Base_Request::TYPE_INTEGER , - 1 );
            if ( $_report_index >= 0 ) {
                $_SESSION[ "VULNERABILITY_REPORT" ][ $_report_index ] = null;
                unset( $_SESSION[ "VULNERABILITY_REPORT" ][ $_report_index ] );
            }
        }
        if ( ! is_cli () ) {
            if ( empty( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) {
                $_form_top = '<div style="margin-top:64px;text-align: left;font-size: 18px;"></div>';
                $_form_top .= '<div style="margin-top:32px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;"></div>';
            } else {
                $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Delete Vulnerability Report</div>';
                $_form_top .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">The current interface is the confirmation stage before officially deleting the vulnerability report. Please confirm that the report content to be deleted is what you really want to delete! After clicking the delete button, the report content will be officially cleared and cannot be restored!</div>';
            }
            $_form_id   = ( 'report_vulnerability_report_form_id' );
            $_form_html = '';
            $_forms     = array ();
            foreach ( $_SESSION[ "VULNERABILITY_REPORT" ] as $report_index => $item ) {
                $_forms[ $report_index ] = array (
                    "action"    => "/report/delete_vulnerability_report" ,
                    "id"        => ( $_form_id . "_" . $report_index ) ,
                    "name"      => "report_vulnerability_report_form" ,
                    "hiddens"   => array (
                        array (
                            "id"    => "roport_index_" . $report_index ,
                            "name"  => "report_index_" . $report_index ,
                            "value" => $report_index ,
                        ) ,
                    ) ,
                    "selects"   => array (
                        array (
                            "id"       => "risk_level" ,
                            "title"    => "Risk Level : " ,
                            "name"     => "risk_level" ,
                            "options"  => array (
                                array ( "describe" => "Mild danger" , "title" => "Mild danger" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Mild to moderate danger" , "title" => "Mild to moderate danger" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 2 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Moderate danger" , "title" => "Moderate danger" , "value" => 3 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 3 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Moderate to severe danger" , "title" => "Moderate to severe danger" , "value" => 4 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 4 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Severe danger" , "title" => "Severe danger" , "value" => 5 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "risk_level" ] ) == 5 ) ? "selected" : "" ) ) ,
                            ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "discovery_method" ,
                            "title"    => "Discovery method : " ,
                            "name"     => "discovery_method" ,
                            "options"  => array (
                                array ( "describe" => "Black box penetration test" , "title" => "Black box penetration test" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "discovery_method" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "White box penetration test" , "title" => "White box penetration test" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "discovery_method" ] ) == 2 ) ? "selected" : "" ) ) ,
                            ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "vulnerability_type" ,
                            "title"    => "Vulnerability type : " ,
                            "name"     => "vulnerability_type" ,
                            "options"  => array (
                                array ( "describe" => "Network vulnerabilities" , "title" => "Network vulnerabilities" , "value" => 1 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 1 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "System vulnerabilities" , "title" => "System vulnerabilities" , "value" => 2 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 2 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Software vulnerabilities" , "title" => "Software vulnerabilities" , "value" => 3 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 3 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Web Site vulnerabilities" , "title" => "Web Site vulnerabilities" , "value" => 4 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 4 ) ? "selected" : "" ) ) ,
                                array ( "describe" => "Other types of vulnerabilities" , "title" => "Other types of vulnerabilities" , "value" => 5 , "selected" => ( ( intval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_type" ] ) == 5 ) ? "selected" : "" ) ) ,
                            ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "id"       => "vulnerability_name" ,
                            "title"    => "Vulnerability Name : " ,
                            "describe" => "Vulnerability Name" ,
                            "name"     => "vulnerability_name" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_name" ] ) ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "vulnerability_discovery_personnel" ,
                            "title"    => "Vulnerability Discovery Personnel : " ,
                            "describe" => "Vulnerability Discovery Personnel" ,
                            "name"     => "vulnerability_discovery_personnel" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_discovery_personnel" ] ) ) ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => "contact_information_of_vulnerability_discovery_personnel" ,
                            "title"    => "Contact information of vulnerability discovery personnel : " ,
                            "describe" => "Contact information of vulnerability discovery personnel" ,
                            "name"     => "contact_information_of_vulnerability_discovery_personnel" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "contact_information_of_vulnerability_discovery_personnel" ] ) ) ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "id"       => 'vulnerability_impact' ,
                            "title"    => "Vulnerability Impact : " ,
                            "name"     => "vulnerability_impact" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_impact" ] ) ) ,
                            "style"    => 'height:200px;' ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => 'vulnerability_discovery_process' ,
                            "title"    => "Vulnerability Discovery Process : " ,
                            "name"     => "vulnerability_discovery_process" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "vulnerability_discovery_process" ] ) ) ,
                            "style"    => 'height:300px;' ,
                            "disabled" => "disabled" ,
                        ) ,
                        array (
                            "id"       => 'solution_proposal' ,
                            "title"    => "Solution_proposal : " ,
                            "name"     => "solution_proposal" ,
                            "value"    => ( strval ( $_SESSION[ "VULNERABILITY_REPORT" ][ $report_index ][ "solution_proposal" ] ) ) ,
                            "style"    => 'height:400px;' ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "files"     => array () ,
                    "submit"    => array ( "id" => "submit" , "name" => "submit" , "value" => "delete" , "display" => true ) ,
                    "reset"     => array ( "id" => "reset" , "name" => "reset" , "value" => "reset" , "display" => false ) ,
                    "button"    => array (
                        "id"      => "edit_report" ,
                        "name"    => "edit_report" ,
                        "value"   => "edit report" ,
                        "display" => true ,
                        "events"  => array (
                            "onclick" => ' document.location.href=\'' . Class_Base_Response ::get_url ( "/report/edit_vulnerability_report" , array () ) . '\'; ' ,
                        ) ,
                    ) ,
                );
                $_form_html              .= Class_View ::form_body ( $_forms[ $report_index ] );
            }
            $_top         = Class_View_Top ::top ();
            $_body        = array (
                "menu"    => Class_View_Report_Menu ::menu ( array () ) ,
                "content" => ( ( $_form_top ) . ( $_form_html ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_content     = '<div></div>';
            $_javascript  = '<script type="text/javascript">function init(){ console.log("init"); } function to_submit(form_object){  console.log("form is submit"); return true;}</script>';
            $_bottom      = Class_View_Bottom ::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response ::output ( Class_View ::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            Class_Base_Response ::outputln ( $_SESSION[ "VULNERABILITY_REPORT" ] );
        }
        return null;
    }

    public static function export_vulnerability_report ( $params = array () )
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
        if ( ( ! empty( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) && ( is_array ( $_SESSION[ "VULNERABILITY_REPORT" ] ) ) ) {
            Class_Base_Report ::output_xls_file_content ( "vulnerability_report" , $_SESSION[ "VULNERABILITY_REPORT" ] );
        }
        return null;
    }

    public static function clear_vulnerability_report ( $params = array () )
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
        if ( ( isset( $_SESSION ) ) && ( is_array ( $_SESSION ) ) && ( array_key_exists ( "VULNERABILITY_REPORT" , $_SESSION ) ) ) {
            $_SESSION[ "VULNERABILITY_REPORT" ] = null;
            unset( $_SESSION[ "VULNERABILITY_REPORT" ] );
            Class_Base_Response ::redirect ( "/report/create_vulnerability_report" , array () );
        }
        return null;
    }
}