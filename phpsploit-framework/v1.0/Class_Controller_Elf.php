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

class Class_Controller_Elf
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
                "menu"    => Class_View_Elf_Menu::menu () ,
                "content" => "" ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function elf64 ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        $_start      = Class_Base_Request::form ( "start" , Class_Base_Request::TYPE_INTEGER , 0 );
        $_file_path  = Class_Base_Request::form ( "file_path" , Class_Base_Request::TYPE_STRING , "" );
        $_elf64_info = array ();
        if ( ( ! empty( $_start ) ) && ( strlen ( $_file_path ) > 0 ) && ( file_exists ( $_file_path ) ) && ( is_file ( $_file_path ) ) ) {
            $_elf64_info = Class_Base_Elf64::get_file_info ( $_file_path );
        }
        if ( ! is_cli () ) {
            $_cli_url        = Class_Base_Response::get_cli_url ( "/elf/elf64" , array ( 'start' => 1 , 'file_path' => $_file_path , ) );
            $_cli_encode_url = Class_Base_Response::get_urlencode ( $_cli_url );
            $_form_top       = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">ELF 64 Format File Data Info</div>';
            $_form_top       .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface is used to obtain and parse the specified binary executable file content. For the binary security part of CTF competitions, as well as penetration testing and software security audit activities, this interface function can provide very powerful assistance capabilities.</div>';
            $_form_top       .= '<div style="margin-top: 16px;text-align:left;font-size:18px;"><span style="font-size: 18px;color:red;">cli url : ' . ( Class_Base_Format::htmlentities ( $_cli_url ) ) . '</span></div>';
            $_form_top       .= '<div style="margin-top: 16px;text-align:left;font-size:18px;"><span style="font-size: 18px;color:red;">cli encode url : ' . ( Class_Base_Format::htmlentities ( $_cli_encode_url ) ) . '</span></div>';
            $_form_name      = "form_0";
            $_form           = array (
                "action"    => "/elf/elf64" ,
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
                        "id"       => "file_path" ,
                        "title"    => "Read File Path : " ,
                        "describe" => "Read File Path" ,
                        "name"     => "file_path" ,
                        "value"    => $_file_path ,
                    ) ,
                ) ,
                "textareas" => array () ,
                "files"     => array () ,
                "submit"    => array (
                    "id"    => "submit_form" ,
                    "type"  => "submit" ,
                    "title" => "( Start Analyzing File Content )" ,
                    "name"  => "submit_form" ,
                    "value" => "start analyzing file content" ,
                ) ,
                "reset"     => array (
                    "id"    => "reset_form" ,
                    "type"  => "reset" ,
                    "title" => "( Reset File Configuration Information )" ,
                    "name"  => "reset_form" ,
                    "value" => "reset configuration" ,
                ) ,
                "button"    => array (
                    "id"      => "button_form" ,
                    "type"    => "button" ,
                    "title"   => "( Create Wget Environment CLI Encode URL )" ,
                    "name"    => "button_form" ,
                    "value"   => "create cli encode url" ,
                    "display" => false ,
                    "events"  => array (
                        "onclick" => 'create_encode_url();' ,
                    ) ,
                ) ,
            );
            $_bottom_menu    = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_bottom_form    = array (
                "action"    => "/elf/elf64" ,
                "submit"    => array ( "display" => false , ) ,
                "reset"     => array ( "display" => false , ) ,
                "hiddens"   => array () ,
                "selects"   => array () ,
                "textareas" => array () ,
            );
            if ( ( ! empty( $_elf64_info[ "file_header" ] ) ) && ( is_object ( $_elf64_info[ "file_header" ] ) ) && ( $_elf64_info[ "file_header" ] instanceof Class_Base_Elf64_File_Header ) ) {
                $_bottom_form[ "textareas" ][] = array (
                    "id"       => "file_header" ,
                    "title"    => "File Header : " ,
                    "name"     => "file_header" ,
                    "value"    => ( ( empty( $_elf64_info[ "file_header" ] ) ) ? print_r ( array () , true ) : print_r ( $_elf64_info[ "file_header" ]->get_format_file_header () , true ) ) ,
                    "disabled" => "disabled" ,
                    "style"    => ( 'height:1020px;' ) ,
                );
            }
            if ( ( ! empty( $_elf64_info[ "program_headers" ] ) ) && ( is_array ( $_elf64_info[ "program_headers" ] ) ) ) {
                foreach ( $_elf64_info[ "program_headers" ] as $program_header_offset => $program_header ) {
                    $_bottom_form[ "textareas" ][] = array (
                        "id"       => ( "program_header_" . $program_header_offset ) ,
                        "title"    => "Program Header_" . $program_header_offset . " : " ,
                        "name"     => ( "program_header_" . $program_header_offset ) ,
                        "value"    => ( print_r ( $program_header->get_format_program_header () , true ) ) ,
                        "disabled" => "disabled" ,
                        "style"    => ( 'height:480px;' ) ,
                    );
                }
            }
            if ( ( ! empty( $_elf64_info[ "section_headers" ] ) ) && ( is_array ( $_elf64_info[ "section_headers" ] ) ) ) {
                foreach ( $_elf64_info[ "section_headers" ] as $section_header_offset => $section_header ) {
                    if ( ( is_object ( $section_header ) ) && ( $section_header instanceof Class_Base_Elf64_Section_Header ) ) {
                        $_format_section_header = $section_header->get_format_section_header ();
                        $_format_sh_name        = $section_header->get_sh_name ();
                        if ( $_format_sh_name === false ) {
                            $_format_section_header[ "format_sh_name" ] = "";
                        } else {
                            if ( $_elf64_info[ "section_shstrtab" ] !== false ) {
                                $_format_section_header[ "format_sh_name" ] = $_elf64_info[ "section_shstrtab" ]->get_sh_name ( $section_header->get_sh_name () );
                            } else {
                                $_format_section_header[ "format_sh_name" ] = "";
                            }
                        }
                        $_bottom_form[ "textareas" ][] = array (
                            "id"       => ( "section_header_" . $section_header_offset ) ,
                            "title"    => ( "Section Header_" . $section_header_offset . ( ( empty( $section_header->get_sh_name () ) ) ? "" : " ( " . ( $_format_section_header[ "format_sh_name" ] ) . " ) : " ) ) ,
                            "name"     => ( "section_header_" . $section_header_offset ) ,
                            "value"    => ( print_r ( $_format_section_header , true ) ) ,
                            "disabled" => "disabled" ,
                            "style"    => ( 'height:500px;' ) ,
                        );
                    }
                }
            }
            if ( ( ! empty( $_elf64_info[ "programs" ] ) ) && ( is_array ( $_elf64_info[ "programs" ] ) ) ) {
                foreach ( $_elf64_info[ "programs" ] as $program_offset => $program ) {
                    $program[ "content" ]          = Class_Base_Elf64_Program::show_program_content ( $program[ "type" ] , $program[ "content" ] , $_program_content_type );
                    $program[ "content_type" ]     = $_program_content_type;
                    $_bottom_form[ "textareas" ][] = array (
                        "id"       => ( "program_" . $program_offset ) ,
                        "title"    => "Program_" . $program_offset . " : " ,
                        "name"     => ( "program_" . $program_offset ) ,
                        "value"    => ( print_r ( $program , true ) ) ,
                        "disabled" => "disabled" ,
                        "style"    => ( 'height:265px;' ) ,
                    );
                }
            }
            if ( ( ! empty( $_elf64_info[ "sections" ] ) ) && ( is_array ( $_elf64_info[ "sections" ] ) ) ) {
                foreach ( $_elf64_info[ "sections" ] as $section_offset => $section ) {
                    $section[ "content" ]          = Class_Base_Elf64_Section::show_section_content ( $section[ "type" ] , $section[ "content" ] , $_section_content_type );
                    $section[ "content_type" ]     = $_section_content_type;
                    $_bottom_form[ "textareas" ][] = array (
                        "id"       => ( "section_" . $section_offset ) ,
                        "title"    => "Section_" . $section_offset . " ( " . ( $section[ "name" ] ) . " ) : " ,
                        "name"     => ( "section_" . $section_offset ) ,
                        "value"    => ( print_r ( $section , true ) ) ,
                        "disabled" => "disabled" ,
                        "style"    => ( 'height:265px;' ) ,
                    );
                }
            }
            $_top        = Class_View_Top::top ();
            $_body       = array (
                "menu"    => Class_View_Elf_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_content    = ( ( '<table style="width:100%;"><tr><td style="width:20%;"></td><td style="width:80%;">' ) . Class_View::form_body ( $_bottom_form ) . ( '</td></tr></table>' ) );
            $_javascript = '<script type="text/javascript">function init(){ } function to_submit(form_object){  console.log("form is submit"); return true;} function create_encode_url(){ document.getElementById("start").value=0;if(document.forms["' . htmlentities ( $_form_name ) . '"].onsubmit()!=false){document.forms["' . htmlentities ( $_form_name ) . '"].submit();} }</script>';
            $_bottom     = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        } else {
            $_output_info = array ( "file_header" => array () , "program_headers" => array () , "section_headers" => array () , "programs" => array () , "sections" => array () , );
            if ( ( ! empty( $_elf64_info[ "file_header" ] ) ) && ( is_object ( $_elf64_info[ "file_header" ] ) ) && ( $_elf64_info[ "file_header" ] instanceof Class_Base_Elf64_File_Header ) ) {
                $_output_info[ "file_header" ] = ( $_elf64_info[ "file_header" ]->get_format_file_header () );
            }
            if ( ( ! empty( $_elf64_info[ "program_headers" ] ) ) && ( is_array ( $_elf64_info[ "program_headers" ] ) ) ) {
                foreach ( $_elf64_info[ "program_headers" ] as $program_header_offset => $program_header ) {
                    $_output_info[ "program_headers" ][ $program_header_offset ] = ( $program_header->get_format_program_header () );
                }
            }
            if ( ( ! empty( $_elf64_info[ "section_headers" ] ) ) && ( is_array ( $_elf64_info[ "section_headers" ] ) ) ) {
                foreach ( $_elf64_info[ "section_headers" ] as $section_header_offset => $section_header ) {
                    if ( ( is_object ( $section_header ) ) && ( $section_header instanceof Class_Base_Elf64_Section_Header ) ) {
                        $_format_section_header = $section_header->get_format_section_header ();
                        $_format_sh_name        = $section_header->get_sh_name ();
                        if ( $_format_sh_name === false ) {
                            $_format_section_header[ "format_sh_name" ] = "";
                        } else {
                            if ( $_elf64_info[ "section_shstrtab" ] !== false ) {
                                $_format_section_header[ "format_sh_name" ] = $_elf64_info[ "section_shstrtab" ]->get_sh_name ( $section_header->get_sh_name () );
                            } else {
                                $_format_section_header[ "format_sh_name" ] = "";
                            }
                        }
                        $_output_info[ "section_headers" ][ $section_header_offset ] = ( $_format_section_header );
                    }
                }
            }
            if ( ( ! empty( $_elf64_info[ "programs" ] ) ) && ( is_array ( $_elf64_info[ "programs" ] ) ) ) {
                foreach ( $_elf64_info[ "programs" ] as $program_offset => $program ) {
                    $program[ "content" ]                          = Class_Base_Elf64_Program::show_program_content ( $program[ "type" ] , $program[ "content" ] , $_program_content_type );
                    $program[ "content_type" ]                     = $_program_content_type;
                    $_output_info[ "programs" ][ $program_offset ] = ( $program );
                }
            }
            if ( ( ! empty( $_elf64_info[ "sections" ] ) ) && ( is_array ( $_elf64_info[ "sections" ] ) ) ) {
                foreach ( $_elf64_info[ "sections" ] as $section_offset => $section ) {
                    $section[ "content" ]                          = Class_Base_Elf64_Section::show_section_content ( $section[ "type" ] , $section[ "content" ] , $_section_content_type );
                    $section[ "content_type" ]                     = $_section_content_type;
                    $_output_info[ "sections" ][ $section_offset ] = ( $section );
                }
            }
            Class_Base_Response::outputln ( $_output_info );
        }
        return null;
    }

    public static function elf_h ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( ! is_cli () ) {
            $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">ELF 64 Format File Data Info</div>';
            $_form_top    .= '<div style="margin-top:16px;margin-bottom:64px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">You can analyze the format and content details of ELF files based on the content of elf. h. Your mastery of the ELF format structure affects your overall ability in the field of binary security.</div>';
            $_form        = array ();
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Elf_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . Class_View::form_body ( $_form ) ) ,
            );
            $_bottom_menu = array (
                array (
                    "title"    => "" ,
                    "describe" => "" ,
                    "href"     => "#" ,
                ) ,
            );
            $_bottom_form = array ( "submit" => array ( "display" => false , ) , "reset" => array ( "display" => false , ) );
            $_top         = Class_View_Top::top ();
            $_body        = array (
                "menu"    => Class_View_Elf_Menu::menu ( array () ) ,
                "content" => ( ( $_form_top ) . ( '<pre style="text-align: left;">' . Class_Base_Format::htmlentities ( Class_Base_Document_Elf64::get_content_elf_h () ) . '</pre>' ) ) ,
            );
            $_content     = ( ( '<table style="width:100%;"><tr><td style="width:20%;"></td><td style="width:80%;">' ) . Class_View::form_body ( $_bottom_form ) . ( '</td></tr></table>' ) );
            $_javascript  = '<script type="text/javascript">function init(){ console.log("page loading completed ! "); }function to_submit(form_object){ console.log("form is submit ! "); return true;}</script>';
            $_bottom      = Class_View_Bottom::bottom ( $_bottom_menu , $_content , $_javascript );
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }
}