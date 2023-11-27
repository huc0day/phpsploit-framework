<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-13
 * Time: 下午12:31
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

class Class_View extends Class_Root implements Interface_View
{
    private static $_menu = array (
        'home' => '/' ,
    );

    public static function test ()
    {
        return debug_backtrace ( true );
    }

    public static function index ( $top = array ( "menu" => null , "content" => null ) , $body = array ( "menu" => null , "content" => null ) , $bottom = array ( "menu" => null , "content" => null ) )
    {
        return self ::index_page ( $top , $body , $bottom );
    }

    public static function top ( $top )
    {
        if ( ! is_array ( $top ) ) {
            $top = array ();
        }
        if ( ( ! isset( $top[ "lang" ] ) ) || ( ! is_string ( $top[ "lang" ] ) ) ) {
            $top[ "lang" ] = "en";
        }
        if ( ( ! isset( $top[ "charset" ] ) ) || ( ! is_string ( $top[ "charset" ] ) ) ) {
            $top[ "charset" ] = "utf-8";
        }
        if ( ( ! isset( $top[ "title" ] ) ) || ( ! is_string ( $top[ "title" ] ) ) ) {
            $top[ "title" ] = "";
        }
        if ( ( ! isset( $top[ "javascript" ] ) ) || ( ! is_string ( $top[ "javascript" ] ) ) ) {
            $top[ "javascript" ] = '<script type="text/javascript"></script>';
        }
        if ( ( ! array_key_exists ( "menu" , $top ) ) || ( ! is_array ( $top ) ) ) {
            $top[ "menu" ] = array ();
        }
        if ( ( ! isset( $top[ "content" ] ) ) || ( ! is_string ( $top[ "content" ] ) ) ) {
            $top[ "content" ] = "";
        }
        $_charset    = $top[ "charset" ];
        $_title      = $top[ "title" ];
        $_javascript = $top[ "javascript" ];
        $_menu       = '<table style="width:100%;height:100%;"><tr>';
        foreach ( $top[ "menu" ] as $key => $item ) {
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ! is_string ( $item[ "describe" ] ) ) ) {
                $item[ "describe" ] = "";
            }
            if ( ( ! isset( $item[ "href" ] ) ) || ( ! is_string ( $item[ "href" ] ) ) ) {
                $item[ "href" ] = "#";
            }
            if ( ! isset( $item[ "title" ] ) || ( ! is_string ( $item[ "title" ] ) ) ) {
                $item[ "title" ] = "";
            }
            $_menu .= '<td style="text-align: center;"><a href="' . Class_Base_Format ::htmlentities ( $item[ "href" ] ) . '">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</a></td>';
        }
        $_menu    .= '</tr></table>';
        $_content = $top[ "content" ];
        $_html    = '<!DOCTYPE html><html lang="' . $top[ "lang" ] . '"><head><meta charset="' . Class_Base_Format ::htmlentities ( $_charset ) . '"><meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /><meta http-equiv="Pragma" content="no-cache" /><meta http-equiv="Expires" content="0" /><title>' . Class_Base_Format ::htmlentities ( $_title ) . '</title>' . $_javascript . '</head><body onload="init();"><div style="padding-top:3%;">' . $_content . '</div><div>' . $_menu . '</div>';
        return $_html;
    }

    public static function bottom ( $bottom )
    {
        if ( ! is_array ( $bottom ) ) {
            $bottom = array ();
        }
        if ( ( ! array_key_exists ( "menu" , $bottom ) ) || ( ! is_array ( $bottom ) ) ) {
            $bottom[ "menu" ] = array ();
        }
        if ( ( ! isset( $bottom[ "content" ] ) ) || ( ! is_string ( $bottom[ "content" ] ) ) ) {
            $bottom[ "content" ] = "";
        }
        if ( ( ! isset( $bottom[ "javascript" ] ) ) || ( ! is_string ( $bottom[ "javascript" ] ) ) ) {
            $bottom[ "javascript" ] = '<script type="text/javascript">function init(){ console.log("Page loading completed ! "); }function submit(form_object){ return true;}</script>';
        }
        $_menu = '<table style="width:100%;height:100%;font-size: 18px;"><tr>';
        foreach ( $bottom[ "menu" ] as $key => $item ) {
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ! is_string ( $item[ "describe" ] ) ) ) {
                $item[ "describe" ] = "";
            }
            if ( ( ! isset( $item[ "href" ] ) ) || ( ! is_string ( $item[ "href" ] ) ) ) {
                $item[ "href" ] = "#";
            }
            if ( ! isset( $item[ "title" ] ) || ( ! is_string ( $item[ "title" ] ) ) ) {
                $item[ "title" ] = "";
            }
            $_menu .= '<td style="text-align: center;"><a title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '" href="' . Class_Base_Format ::htmlentities ( $item[ "href" ] ) . '">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</a></td>';
        }
        $_menu       .= '</tr></table>';
        $_content    = $bottom[ "content" ];
        $_javascript = $bottom[ "javascript" ];
        $_html       = '<div style="height:32px;"></div><div>' . $_menu . '</div><div>' . $_content . '</div></body>' . $_javascript . '</html>';
        return $_html;
    }

    public static function menu ( $menu )
    {
        if ( ! is_array ( $menu ) ) {
            $menu = array ();
        }
        $_html = '<div>';
        foreach ( $menu as $key => $item ) {
            if ( ! is_array ( $item ) ) {
                $item = array ();
            }
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ! is_string ( $item[ "describe" ] ) ) ) {
                $item[ "describe" ] = "";
            }
            if ( ( ! isset( $item[ "href" ] ) ) || ( ! is_string ( $item[ "href" ] ) ) ) {
                $item[ "href" ] = "";
            }
            if ( ( ! isset( $item[ "title" ] ) ) || ( ! is_string ( $item[ "title" ] ) ) ) {
                $item[ "title" ] = "";
            }
            $_html .= '<div style="text-align: center;" title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '"><a href="' . Class_Base_Format ::htmlentities ( $item[ "href" ] ) . '">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</a></div>';
        }
        $_html .= '</div>';
        return $_html;
    }

    public static function content ( $content = "" )
    {
        $html = '<div>' . $content . '</div>';
        return $html;
    }

    public static function body ( $body )
    {
        if ( ! is_array ( $body ) ) {
            $body = array ();
        }
        if ( ! is_array ( $body[ "menu" ] ) ) {
            $body[ "menu" ] = array ();
        }
        if ( ( ! isset( $body[ "content" ] ) ) || ( ! is_string ( $body[ "content" ] ) ) ) {
            $body[ "content" ] = "";
        }
        $_menu = '<table style="width:100%;height:100%;">';
        foreach ( $body[ "menu" ] as $key => $item ) {
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ! is_string ( $item[ "describe" ] ) ) ) {
                $item[ "describe" ] = "";
            }
            if ( ( ! isset( $item[ "href" ] ) ) || ( ! is_string ( $item[ "href" ] ) ) ) {
                $item[ "href" ] = "#";
            }
            if ( ! isset( $item[ "title" ] ) || ( ! is_string ( $item[ "title" ] ) ) ) {
                $item[ "title" ] = "";
            }
            $_menu .= '<tr style="height:64px;line-height: 64px;"><td style="text-align: left;"><a title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '" href="' . Class_Base_Format ::htmlentities ( $item[ "href" ] ) . '" target="' . ( empty( $item[ "window" ] ) ? "_self" : "_blank" ) . '" >' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</a></td></tr>';
        }
        $_menu    .= '</table>';
        $_content = $body[ "content" ];
        $_html    = '<div style="width:100%;"><table style="width:100%;"><tr><td style="width:20%;padding-left:2%;padding-right:5%;padding-top:64px;font-size:16px;text-align: center;">' . $_menu . '</td><td style="width:80%;padding-top:0;text-align: center;"><div style="">' . $_content . '</div></td></tr></table></div>';
        return $_html;
    }

    public static function index_page ( $top = array ( "menu" => null , "content" => null , "javascript" => null ) , $body = array ( "menu" => null , "content" => null ) , $bottom = array ( "menu" => null , "content" => null , "javascript" => null ) )
    {
        $_html = self ::top ( $top ) . self ::body ( $body ) . self ::bottom ( $bottom );
        return $_html;
    }

    public static function list_page ( $top = array ( "menu" => null , "content" => null ) , $list = array ( "page" => 1 , "pagesize" => 20 , "total" => 0 , "list" => array () , "search" => "" ) , $bottom = array ( "menu" => null , "content" => null ) )
    {
        if ( ! is_array ( $list ) ) {
            $list = array ();
        }
        if ( ( ! isset( $list[ "page" ] ) ) || ( ! is_integer ( $list[ "page" ] ) ) ) {
            $list[ "page" ] = 1;
        }
        if ( ( ! isset( $list[ "pagesize" ] ) ) || ( ! is_integer ( $list[ "pagesize" ] ) ) ) {
            $list[ "pagesize" ] = 20;
        }
        if ( ( ! isset( $list[ "total" ] ) ) || ( ! is_integer ( $list[ "total" ] ) ) ) {
            $list[ "total" ] = 0;
        }
        if ( ( ! isset( $list[ "list" ] ) ) || ( ! is_array ( $list[ "list" ] ) ) ) {
            $list[ "list" ] = array ();
        }
        if ( ( ! isset( $list[ "search" ] ) ) || ( ! is_string ( $list[ "search" ] ) ) ) {
            $list[ "search" ] = "";
        }
        $_html = self ::top ( $top ) . self ::list_table ( $list[ "page" ] , $list[ "pagesize" ] , $list[ "total" ] , $list[ "list" ] , $list[ "search" ] ) . self ::bottom ( $bottom );
        return $_html;
    }

    public static function list_table ( $page , $page_size , $max_page , $row_total , $list = array () , $search = array ( "action" => null , "name" => null , "value" => null ) )
    {
        $page      = intval ( $page );
        $page_size = intval ( $page_size );
        $row_total = intval ( $row_total );
        if ( ! is_array ( $list ) ) {
            $list = array ();
        }
        if ( ! is_array ( $search ) ) {
            $search = array ();
        }
        if ( ( ! array_key_exists ( "action" , $search ) ) || ( ! is_string ( $search[ "action" ] ) ) ) {
            $search[ "action" ] = "";
        }
        if ( ( ! array_key_exists ( "name" , $search ) ) || ( ! is_string ( $search[ "name" ] ) ) ) {
            $search[ "name" ] = "search";
        }
        if ( ( ! array_key_exists ( "value" , $search ) ) || ( ! is_string ( $search[ "value" ] ) ) ) {
            $search[ "value" ] = "";
        }

        $_list      = '';
        $_list      .= '<div>';
        $_list      .= '<div style="padding-top: 32px;font-size: 18px;"><table style="width:100%;"><tr><td width="20%">search:</td><td width="80%" style="text-align: left;"><form action="' . Class_Base_Format ::htmlentities ( Class_Base_Format ::action ( $search[ "action" ] ) ) . '" method="post"><input name="' . Class_Base_Format ::htmlentities ( $search[ "name" ] ) . '" type="text" value="' . Class_Base_Format ::htmlentities ( $search[ "value" ] ) . '" style="width:60%;line-height:24px;font-size:18px;border-width:2px;text-align:center;">&nbsp;&nbsp;<input name="submit" type="submit" value="&nbsp;submit&nbsp;" style="line-height:25px;font-size:20px;border-width:2px;"></form></td></tr></table></div>';
        $_list      .= '<div style="padding-top: 32px;"><table style="width:90%;">';
        $_item_size = 0;
        foreach ( $list as $index => $item ) {
            if ( is_array ( $item ) ) {
                $_item_index = 0;
                if ( $_item_size <= 0 ) {
                    $_item_size = count ( $item );
                }
                $_list .= '<tr>';
                foreach ( $item as $key => $value ) {
                    $_list .= '<td style="text-align: left;padding-top: 14px;padding-bottom: 14px;">' . $key . ' : </td><td style="text-align: left;padding-top: 14px;padding-bottom: 14px;padding-right: 64px;">' . $value . '</td>';
                    $_item_index ++;
                }
                while ( $_item_index < $_item_size ) {
                    $_list .= '<td style="text-align: left;padding-top: 14px;padding-bottom: 14px;">&nbsp;</td><td style="text-align: left;padding-top: 14px;padding-bottom: 14px;">&nbsp;</td>';
                    $_item_index ++;
                }
                $_list .= '</tr>';
            }
        }
        $_list .= '</table></div>';
        $_list .= '<div style="padding-top: 32px;font-size:18px;"><table style="width:100%;text-align: left;"><tr><td>page:</td><td style="text-align: left;padding-right:32px;">' . $page . '</td><td>page size:</td><td style="text-align: left;padding-right:32px;">' . $page_size . '</td><td>max page:</td><td style="text-align: left;padding-right:32px;">' . $max_page . '</td><td>row total:</td><td style="text-align: left;padding-right:32px;">' . $row_total . '</td><td>to page:</td><td>';
        $_list .= '<select name="page" size="1" style="width:100%;height:32px;line-height:24px;font-size:18px;border-width:2px;text-align:center;" onchange="document.location.href=\'' . Class_Base_Response ::get_url ( $search[ "action" ] ) . '&page=\'+this.value+\'&page_size=' . $page_size . '&key=' . Class_Base_Format ::htmlentities ( $search[ "value" ] ) . '\';">';
        for ( $index = 1 ; $index <= $max_page ; $index ++ ) {
            $_list .= '<option value="' . $index . '" ' . ( ( $page != $index ) ? "" : "selected" ) . '>' . $index . '</option>';
        }
        $_list .= "</select>";
        $_list .= '</td><td width="10%;"></td></tr></table></div>';
        $_list .= '</div>';
        return $_list;
    }

    public static function detail_page ( $top , $detail , $bottom )
    {
        $_html = self ::top ( $top ) . self ::detail ( $detail ) . self ::bottom ( $bottom );
        return $_html;
    }

    public static function detail ( $detail )
    {
        $_form = '';
        $_form .= '<div>';
        $_form .= '<table style="width:100%;">';
        foreach ( $detail as $index => $item ) {
            $_form .= '<tr><td width="20%;">' . $item[ 'title' ] . '</td><td width="20%;">' . $item[ 'content' ] . '</td></tr>';
        }
        $_form .= '</table>';
        $_form .= '</div>';
        return $_form;
    }

    public static function init_form ( $form )
    {
        if ( ! is_array ( $form ) ) {
            $form = array ();
        }
        if ( ( ! isset( $form[ "action" ] ) ) || ( ! is_string ( $form[ "action" ] ) ) ) {
            $form[ "action" ] = "";
        }
        if ( ( ! isset( $form[ "hiddens" ] ) ) || ( ! is_array ( $form[ "hiddens" ] ) ) ) {
            $form[ "hiddens" ] = array ();
        }
        if ( ( ! isset( $form[ "selects" ] ) ) || ( ! is_array ( $form[ "selects" ] ) ) ) {
            $form[ "selects" ] = array ();
        }
        if ( ( ! isset( $form[ "inputs" ] ) ) || ( ! is_array ( $form[ "inputs" ] ) ) ) {
            $form[ "inputs" ] = array ();
        }
        if ( ( ! isset( $form[ "textareas" ] ) ) || ( ! is_array ( $form[ "textareas" ] ) ) ) {
            $form[ "textareas" ] = array ();
        }
        if ( ( ! isset( $form[ "files" ] ) ) || ( ! is_array ( $form[ "files" ] ) ) ) {
            $form[ "files" ] = array ();
        }
        if ( ( ! isset( $form[ "gets" ] ) ) || ( ! is_array ( $form[ "gets" ] ) ) ) {
            $form[ "gets" ] = array ();
        }
        if ( ( ! isset( $form[ "id" ] ) ) || ( ! is_string ( $form[ "id" ] ) ) ) {
            $form[ "id" ] = "form_id_1";
        }
        if ( ( ! isset( $form[ "name" ] ) ) || ( ! is_string ( $form[ "name" ] ) ) ) {
            $form[ "name" ] = "form1";
        }
        if ( ( ! isset( $form[ "enctype" ] ) ) || ( ! is_string ( $form[ "enctype" ] ) ) ) {
            $form[ "enctype" ] = "multipart/form-data";
        }
        if ( ( ! isset( $form[ "submit" ] ) ) || ( ! is_array ( $form[ "submit" ] ) ) ) {
            $form[ "submit" ] = array ();
        }
        if ( ( ! isset( $form[ "submit" ][ "display" ] ) ) || ( ! is_bool ( $form[ "submit" ][ "display" ] ) ) ) {
            $form[ "submit" ][ "display" ] = true;
        }
        if ( ( ! isset( $form[ "submit" ][ "id" ] ) ) || ( ! is_string ( $form[ "submit" ][ "id" ] ) ) ) {
            $form[ "submit" ][ "id" ] = "";
        }
        if ( ( ! isset( $form[ "submit" ][ "name" ] ) ) || ( ! is_string ( $form[ "submit" ][ "name" ] ) ) ) {
            $form[ "submit" ][ "name" ] = "";
        }
        if ( ( ! isset( $form[ "submit" ][ "type" ] ) ) || ( ! is_string ( $form[ "submit" ][ "type" ] ) ) ) {
            $form[ "submit" ][ "type" ] = "submit";
        }
        if ( ( ! isset( $form[ "submit" ][ "value" ] ) ) || ( ! is_string ( $form[ "submit" ][ "value" ] ) ) ) {
            $form[ "submit" ][ "value" ] = " submit ";
        }
        if ( ( ! isset( $form[ "submit" ][ "title" ] ) ) || ( ! is_string ( $form[ "submit" ][ "title" ] ) ) ) {
            $form[ "submit" ][ "title" ] = "";
        }
        if ( ( ! isset( $form[ "submit" ][ "disabled" ] ) ) || ( ! is_string ( $form[ "submit" ][ "disabled" ] ) ) ) {
            $form[ "submit" ][ "disabled" ] = "";
        }
        if ( ( ! isset( $form[ "submit" ][ "events" ] ) ) || ( ! is_array ( $form[ "submit" ][ "events" ] ) ) ) {
            $form[ "submit" ][ "events" ] = array ();
        }
        $_event_processing = '';
        foreach ( $form[ "submit" ][ "events" ] as $event => $processing ) {
            if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
            }
        }
        $form[ "submit" ][ "event_processing" ] = $_event_processing;
        if ( ( ! isset( $form[ "reset" ] ) ) || ( ! is_array ( $form[ "reset" ] ) ) ) {
            $form[ "reset" ] = array ();
        }
        if ( ( ! isset( $form[ "reset" ][ "display" ] ) ) || ( ! is_bool ( $form[ "reset" ][ "display" ] ) ) ) {
            $form[ "reset" ][ "display" ] = true;
        }
        if ( ( ! isset( $form[ "reset" ][ "id" ] ) ) || ( ! is_string ( $form[ "reset" ][ "id" ] ) ) ) {
            $form[ "reset" ][ "id" ] = "";
        }
        if ( ( ! isset( $form[ "reset" ][ "name" ] ) ) || ( ! is_string ( $form[ "reset" ][ "name" ] ) ) ) {
            $form[ "reset" ][ "name" ] = "";
        }
        if ( ( ! isset( $form[ "reset" ][ "type" ] ) ) || ( ! is_string ( $form[ "reset" ][ "type" ] ) ) ) {
            $form[ "reset" ][ "type" ] = "reset";
        }
        if ( ( ! isset( $form[ "reset" ][ "value" ] ) ) || ( ! is_string ( $form[ "reset" ][ "value" ] ) ) ) {
            $form[ "reset" ][ "value" ] = " reset ";
        }
        if ( ( ! isset( $form[ "reset" ][ "title" ] ) ) || ( ! is_string ( $form[ "reset" ][ "title" ] ) ) ) {
            $form[ "reset" ][ "title" ] = "";
        }
        if ( ( ! isset( $form[ "reset" ][ "disabled" ] ) ) || ( ! is_string ( $form[ "reset" ][ "disabled" ] ) ) ) {
            $form[ "reset" ][ "disabled" ] = "";
        }
        if ( ( ! isset( $form[ "reset" ][ "events" ] ) ) || ( ! is_array ( $form[ "reset" ][ "events" ] ) ) ) {
            $form[ "reset" ][ "events" ] = array ();
        }
        $_event_processing = '';
        foreach ( $form[ "reset" ][ "events" ] as $event => $processing ) {
            if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
            }
        }
        $form[ "reset" ][ "event_processing" ] = $_event_processing;
        if ( ( ! isset( $form[ "button" ] ) ) || ( ! is_array ( $form[ "button" ] ) ) ) {
            $form[ "button" ] = array ();
        }
        if ( ( ! isset( $form[ "button" ][ "display" ] ) ) || ( ! is_bool ( $form[ "button" ][ "display" ] ) ) ) {
            $form[ "button" ][ "display" ] = false;
        }
        if ( ( ! isset( $form[ "button" ][ "id" ] ) ) || ( ! is_string ( $form[ "button" ][ "id" ] ) ) ) {
            $form[ "button" ][ "id" ] = "";
        }
        if ( ( ! isset( $form[ "button" ][ "name" ] ) ) || ( ! is_string ( $form[ "button" ][ "name" ] ) ) ) {
            $form[ "button" ][ "name" ] = "";
        }
        if ( ( ! isset( $form[ "button" ][ "type" ] ) ) || ( ! is_string ( $form[ "button" ][ "type" ] ) ) ) {
            $form[ "button" ][ "type" ] = "button";
        }
        if ( ( ! isset( $form[ "button" ][ "value" ] ) ) || ( ! is_string ( $form[ "button" ][ "value" ] ) ) ) {
            $form[ "button" ][ "value" ] = " button ";
        }
        if ( ( ! isset( $form[ "button" ][ "title" ] ) ) || ( ! is_string ( $form[ "button" ][ "title" ] ) ) ) {
            $form[ "button" ][ "title" ] = "";
        }
        if ( ( ! isset( $form[ "button" ][ "disabled" ] ) ) || ( ! is_string ( $form[ "button" ][ "disabled" ] ) ) ) {
            $form[ "button" ][ "disabled" ] = "";
        }
        if ( ( ! isset( $form[ "button" ][ "events" ] ) ) || ( ! is_array ( $form[ "button" ][ "events" ] ) ) ) {
            $form[ "button" ][ "events" ] = array ();
        }
        $_event_processing = '';
        foreach ( $form[ "button" ][ "events" ] as $event => $processing ) {
            if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
            }
        }
        $form[ "button" ][ "event_processing" ] = $_event_processing;
        if ( ( ! isset( $form[ "div_show_dyn_id" ] ) ) || ( ! is_string ( $form[ "div_show_dyn_id" ] ) ) || ( strlen ( $form[ "div_show_dyn_id" ] ) <= 0 ) ) {
            $form[ "div_show_dyn_id" ] = "div_show_dyn_form1";
        }
        return $form;
    }

    public static function form_page ( $top , $form , $bottom )
    {
        $form  = self ::init_form ( $form );
        $_html = self ::top ( $top ) . self ::form ( $form[ "action" ] , $form[ "hiddens" ] , $form[ "selects" ] , $form[ "inputs" ] , $form[ "textareas" ] , $form[ "files" ] , $form[ "gets" ] , $form[ "id" ] , $form[ "name" ] , $form[ "enctype" ] , $form[ "submit" ] , $form[ "reset" ] , $form[ "button" ] , $form[ "div_show_dyn_id" ] ) . self ::bottom ( $bottom );
        return $_html;
    }

    public static function form_body ( $form )
    {
        $form  = self ::init_form ( $form );
        $_html = self ::form ( $form[ "action" ] , $form[ "hiddens" ] , $form[ "selects" ] , $form[ "inputs" ] , $form[ "textareas" ] , $form[ "files" ] , $form[ "gets" ] , $form[ "id" ] , $form[ "name" ] , $form[ "enctype" ] , $form[ "submit" ] , $form[ "reset" ] , $form[ "button" ] , $form[ "div_show_dyn_id" ] );
        return $_html;
    }

    public static function form ( $action , $hiddens = array () , $selects = array () , $inputs = array () , $textareas = array () , $files = array () , $gets = array () , $form_id = "form_id_1" , $form_name = "form1" , $form_enctype = "multipart/form-data" , $submit = array () , $reset = array () , $button = array () , $div_show_dyn_id = "div_show_dyn_form1" )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ! empty( $action ) ) {
            if ( substr ( $action , 0 , 1 ) != "/" ) {
                $action = "/" . $action;
            }
            $_index_file_name = INDEX_FILE_URI;
            $action           = $_index_file_name . '?url=' . $action;
        }
        if ( ( empty( $form_id ) ) || ( ! is_string ( $form_id ) ) ) {
            $form_id = "form_id_0";
        }
        if ( ( empty( $form_name ) ) || ( ! is_string ( $form_name ) ) ) {
            $form_name = "form_0";
        }
        if ( ( empty( $form_enctype ) ) || ( ! is_string ( $form_enctype ) ) ) {
            $form_enctype = "multipart/form-data";
        }
        if ( ( ! empty( $gets ) ) && ( is_array ( $gets ) ) ) {
            foreach ( $gets as $k => $v ) {
                if ( is_string ( $k ) && ( ! Class_Base_Format ::is_integer ( $k ) ) ) {
                    $action .= '&' . $k . '=' . urlencode ( $v );
                }
            }
        }
        if ( empty( $gets[ "rand" ] ) ) {
            $action .= '&rand=' . rand ( 100000000000000000 , 999999999999999999 );
        }
        $action .= '&csrf=' . ( empty( $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] ) ? ( $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] = ( time () . rand ( 10000000 , 99999999 ) ) ) : $_SESSION[ "PHPSPLOIT_PERMISSION_CSRF" ] );
        $_form  = '';
        $_form  .= '<div>';
        $_form  .= '<form id="' . Class_Base_Format ::htmlentities ( $form_id ) . '" name="' . Class_Base_Format ::htmlentities ( $form_name ) . '" action="' . Class_Base_Format ::htmlentities ( $action ) . '" method="post" enctype="' . Class_Base_Format ::htmlentities ( $form_enctype ) . '" onsubmit="return to_submit(this);">';
        if ( ( ! isset( $submit ) ) || ( ! is_array ( $submit ) ) ) {
            $submit = array ();
        }
        if ( ( ! isset( $submit[ "display" ] ) ) || ( ! is_bool ( $submit[ "display" ] ) ) ) {
            $submit[ "display" ] = true;
        }
        if ( ( ! isset( $submit[ "id" ] ) ) || ( ! is_string ( $submit[ "id" ] ) ) ) {
            $submit[ "id" ] = ( "submit_" . 0 );
        }
        if ( ( ! isset( $submit[ "name" ] ) ) || ( ! is_string ( $submit[ "name" ] ) ) ) {
            $submit[ "name" ] = ( "submit_" . 0 );
        }
        if ( ( ! isset( $submit[ "type" ] ) ) || ( ! is_string ( $submit[ "type" ] ) ) ) {
            $submit[ "type" ] = "submit";
        }
        if ( ( ! isset( $submit[ "value" ] ) ) || ( ! is_string ( $submit[ "value" ] ) ) ) {
            $submit[ "value" ] = " submit ";
        }
        if ( ( ! isset( $submit[ "title" ] ) ) || ( ! is_string ( $submit[ "title" ] ) ) ) {
            $submit[ "title" ] = "";
        }
        if ( ( ! isset( $submit[ "disabled" ] ) ) || ( ! is_string ( $submit[ "disabled" ] ) ) ) {
            $submit[ "disabled" ] = "";
        }
        if ( ( ! isset( $submit[ "style" ] ) ) || ( ! is_string ( $submit[ "style" ] ) ) ) {
            $submit[ "style" ] = "";
        }
        if ( ( ! isset( $submit[ "events" ] ) ) || ( ! is_array ( $submit[ "events" ] ) ) ) {
            $submit[ "events" ] = array ();
        }
        if ( ( ! isset( $submit[ "event_processing" ] ) ) || ( ! is_string ( $submit[ "event_processing" ] ) ) ) {
            $_event_processing = '';
            foreach ( $submit[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $submit[ "event_processing" ] = $_event_processing;
        }
        if ( ( ! isset( $reset ) ) || ( ! is_array ( $reset ) ) ) {
            $reset = array ();
        }
        if ( ( ! isset( $reset[ "display" ] ) ) || ( ! is_bool ( $reset[ "display" ] ) ) ) {
            $reset[ "display" ] = true;
        }
        if ( ( ! isset( $reset[ "id" ] ) ) || ( ! is_string ( $reset[ "id" ] ) ) ) {
            $reset[ "id" ] = ( "reset_" . 0 );
        }
        if ( ( ! isset( $reset[ "name" ] ) ) || ( ! is_string ( $reset[ "name" ] ) ) ) {
            $reset[ "name" ] = ( "reset_" . 0 );
        }
        if ( ( ! isset( $reset[ "type" ] ) ) || ( ! is_string ( $reset[ "type" ] ) ) ) {
            $reset[ "type" ] = "reset";
        }
        if ( ( ! isset( $reset[ "value" ] ) ) || ( ! is_string ( $reset[ "value" ] ) ) ) {
            $reset[ "value" ] = " reset ";
        }
        if ( ( ! isset( $reset[ "title" ] ) ) || ( ! is_string ( $reset[ "title" ] ) ) ) {
            $reset[ "title" ] = "";
        }
        if ( ( ! isset( $reset[ "disabled" ] ) ) || ( ! is_string ( $reset[ "disabled" ] ) ) ) {
            $reset[ "disabled" ] = "";
        }
        if ( ( ! isset( $reset[ "style" ] ) ) || ( ! is_string ( $reset[ "style" ] ) ) ) {
            $reset[ "style" ] = "";
        }
        if ( ( ! isset( $reset[ "events" ] ) ) || ( ! is_array ( $reset[ "events" ] ) ) ) {
            $reset[ "events" ] = array ();
        }
        if ( ( ! isset( $reset[ "event_processing" ] ) ) || ( ! is_string ( $reset[ "event_processing" ] ) ) ) {
            $_event_processing = '';
            foreach ( $reset[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $reset[ "event_processing" ] = $_event_processing;
        }
        if ( ( ! isset( $button ) ) || ( ! is_array ( $button ) ) ) {
            $button = array ();
        }
        if ( ( ! isset( $button[ "display" ] ) ) || ( ! is_bool ( $button[ "display" ] ) ) ) {
            $button[ "display" ] = true;
        }
        if ( ( ! isset( $button[ "id" ] ) ) || ( ! is_string ( $button[ "id" ] ) ) ) {
            $button[ "id" ] = ( "button_" . 0 );
        }
        if ( ( ! isset( $button[ "name" ] ) ) || ( ! is_string ( $button[ "name" ] ) ) ) {
            $button[ "name" ] = ( "button_" . 0 );
        }
        if ( ( ! isset( $button[ "type" ] ) ) || ( ! is_string ( $button[ "type" ] ) ) ) {
            $button[ "type" ] = "button";
        }
        if ( ( ! isset( $button[ "value" ] ) ) || ( ! is_string ( $button[ "value" ] ) ) ) {
            $button[ "value" ] = " button ";
        }
        if ( ( ! isset( $button[ "title" ] ) ) || ( ! is_string ( $button[ "title" ] ) ) ) {
            $button[ "title" ] = "";
        }
        if ( ( ! isset( $button[ "disabled" ] ) ) || ( ! is_string ( $button[ "disabled" ] ) ) ) {
            $button[ "disabled" ] = "";
        }
        if ( ( ! isset( $button[ "style" ] ) ) || ( ! is_string ( $button[ "style" ] ) ) ) {
            $button[ "style" ] = "";
        }
        if ( ( ! isset( $button[ "events" ] ) ) || ( ! is_array ( $button[ "events" ] ) ) ) {
            $button[ "events" ] = array ();
        }
        if ( ( ! isset( $button[ "event_processing" ] ) ) || ( ! is_string ( $button[ "event_processing" ] ) ) ) {
            $_event_processing               = '';
            $button[ "events" ][ "onclick" ] = 'click_dyn_add_button("' . Class_Base_Format ::htmlentities ( $form_id ) . '","dyn_form_hidden_index_id");';
            foreach ( $button[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $button[ "event_processing" ] = $_event_processing;
        }
        $hiddens[] = array ( "id" => "dyn_form_hidden_index_id" , "name" => "dyn_form_hidden_index_name" , "value" => 0 , "events" => array () );
        foreach ( $hiddens as $hidden_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "hiddens_" . $hidden_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "hiddens_" . $hidden_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ( ! isset( $item[ "events" ] ) ) || ( ! is_array ( $item[ "events" ] ) ) ) {
                $item[ "events" ] = array ();
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<input id="' . Class_Base_Format ::htmlentities ( $item[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" type="hidden" value="' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '" ' . $_event_processing . '>';
        }
        $_form .= '<div>';
        foreach ( $selects as $select_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "selects_" . $select_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "selects_" . $select_index );
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            if ( ( ! isset( $item[ "options" ] ) ) || ( ! is_array ( $item[ "options" ] ) ) ) {
                $item[ "options" ] = array ();
            }
            if ( ( ! isset( $item[ "events" ] ) ) || ( ! is_array ( $item[ "events" ] ) ) ) {
                $item[ "events" ] = array ();
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="margin-top: 32px;">';
            $_form .= '<table style="width:100%;font-size:18px;"><tr><td width="20%" style="text-align: left;">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</td><td width="60%" style="text-align: center;"><select id="' . Class_Base_Format ::htmlentities ( $item[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" size="1" style="width:100%;height:32px;line-height:24px;font-size:18px;border-width:2px;text-align:center;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '"  ' . $item[ "disabled" ] . ' ' . $_event_processing . '><option value=""> ------ SELECT ------ </option>';
            foreach ( $item[ "options" ] as $option_index => $option ) {
                if ( isset( $option[ "value" ] ) ) {
                    if ( ( ! isset( $option[ "title" ] ) ) || ( ( ! is_string ( $option[ "title" ] ) ) && ( is_numeric ( $option[ "title" ] ) ) ) ) {
                        $option[ "title" ] = $option[ "value" ];
                    }
                    if ( ( ! isset( $option[ "describe" ] ) ) || ( ( ! is_string ( $option[ "describe" ] ) ) && ( is_numeric ( $option[ "describe" ] ) ) ) ) {
                        $option[ "describe" ] = $option[ "title" ];
                    }
                    if ( ( ! isset( $option[ "selected" ] ) ) || ( ( ! is_string ( $option[ "selected" ] ) ) ) ) {
                        $option[ "selected" ] = "";
                    }
                    $_form .= '<option title="' . Class_Base_Format ::htmlentities ( $option[ "describe" ] ) . '" value="' . Class_Base_Format ::htmlentities ( $option[ "value" ] ) . '" ' . $option[ "selected" ] . '>' . Class_Base_Format ::htmlentities ( $option[ "title" ] ) . '</option>';
                }
            }
            $_form .= '</select></td><td width="20%" style="padding-left:10px;text-align:left;color:red;">' . Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] ) . '</td></tr></table>';
            $_form .= '</div>';
        }
        $_form .= '</div>';
        $_form .= '<div>';
        foreach ( $inputs as $input_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "inputs_" . $input_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "inputs_" . $input_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ( ! isset( $item[ "title" ] ) ) || ( ( ! is_string ( $item[ "title" ] ) ) && ( ! is_numeric ( $item[ "title" ] ) ) ) ) {
                $item[ "title" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ( ! is_string ( $item[ "describe" ] ) ) && ( ! is_numeric ( $item[ "describe" ] ) ) ) ) {
                $item[ "describe" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            if ( ( ! isset( $item[ "events" ] ) ) || ( ! is_array ( $item[ "events" ] ) ) ) {
                $item[ "events" ] = array ();
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="height:32px;"></div>';
            $_form .= '<div>';
            $_form .= '<table style="width:100%;line-height:24px;font-size:18px;"><tr><td width="20%" style="text-align: left;">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</td><td width="60%">';
            $_form .= '<input id="' . Class_Base_Format ::htmlentities ( $item[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" type="text" title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '" style="width:100%;line-height:24px;font-size:18px;border-width:2px;text-align:center;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '"  value="' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '" ' . Class_Base_Format ::htmlentities ( $item[ "disabled" ] ) . ' ' . $_event_processing . '>';
            $_form .= '</td><td width="20%" style="padding-left:10px;text-align:left;color:red;">' . Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] ) . '</td></tr></table>';
            $_form .= '</div>';
        }
        $_form .= '</div>';
        $_form .= '<div>';
        foreach ( $textareas as $textarea_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "textareas_" . $textarea_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "textareas_" . $textarea_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ( ! isset( $item[ "title" ] ) ) || ( ( ! is_string ( $item[ "title" ] ) ) && ( ! is_numeric ( $item[ "title" ] ) ) ) ) {
                $item[ "title" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ( ! is_string ( $item[ "describe" ] ) ) && ( ! is_numeric ( $item[ "describe" ] ) ) ) ) {
                $item[ "describe" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            if ( ( ! isset( $item[ "events" ] ) ) || ( ! is_array ( $item[ "events" ] ) ) ) {
                $item[ "events" ] = array ();
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="height:32px;"></div>';
            $_form .= '<div>';
            $_form .= '<table style="width:100%;line-height:24px;font-size:18px;">';
            $_form .= '<tr>';
            $_form .= '<td width="20%" style="text-align: left;">';
            $_form .= Class_Base_Format ::htmlentities ( $item[ "title" ] );
            $_form .= '</td>';
            $_form .= '<td width="60%" style="text-align: left;">';
            $_form .= '<textarea id="' . Class_Base_Format ::htmlentities ( $item[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" style="width:100%;height:200px;font-size:18px;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '" ' . Class_Base_Format ::htmlentities ( $item[ "disabled" ] ) . ' ' . $_event_processing . ' title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '">' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '</textarea>';
            $_form .= '</td>';
            $_form .= '<td width="20%" style="padding-left:10px;text-align: left;color:red;">';
            $_form .= Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] );
            $_form .= '</td>';
            $_form .= '</tr>';
            $_form .= '</table>';
            $_form .= '</div>';
        }
        $_form .= '</div>';
        $_form .= "<div>";
        foreach ( $files as $file_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "files_" . $file_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "files_" . $file_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ( ! isset( $item[ "title" ] ) ) || ( ( ! is_string ( $item[ "title" ] ) ) && ( ! is_numeric ( $item[ "title" ] ) ) ) ) {
                $item[ "title" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ( ! is_string ( $item[ "describe" ] ) ) && ( ! is_numeric ( $item[ "describe" ] ) ) ) ) {
                $item[ "describe" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            if ( ( ! isset( $item[ "events" ] ) ) || ( ! is_array ( $item[ "events" ] ) ) ) {
                $item[ "events" ] = array ();
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="height:32px;"></div>';
            $_form .= '<div>';
            $_form .= '<table style="width:100%;line-height:24px;font-size:18px;"><tr><td width="20%" style="text-align: left;">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</td><td width="60%" style="text-align: left;">';
            $_form .= '<input id="' . Class_Base_Format ::htmlentities ( $item[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" type="file" title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '" style="width:100%;line-height:24px;font-size:18px;border-width:2px;text-align:left;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '"  value="' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '" ' . Class_Base_Format ::htmlentities ( $item[ "disabled" ] ) . ' ' . $_event_processing . '>';
            $_form .= '</td><td width="20%" style="padding-left:10px;text-align:left;color:red;">' . Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] ) . '</td></tr></table>';
            $_form .= '</div>';
        }
        $_form .= "</div>";
        $_form .= '<div id="div_id_dyn_form_show_' . Class_Base_Format ::htmlentities ( $form_id ) . '" style="display: block;">';
        $_form .= '</div>';
        $_form .= '<div style="height:32px;"></div>';
        $_form .= '  <div>';
        $_form .= '    <table style="width:100%;line-height:28px;font-size:20px;">';
        $_form .= '      <tr>';
        $_form .= '        <td width="20%"></td><td width="20%">' . ( ( empty( $submit[ "display" ] ) ) ? "" : ( '<input id="' . Class_Base_Format ::htmlentities ( $submit[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $submit[ "name" ] ) . '" type="' . Class_Base_Format ::htmlentities ( $submit[ "type" ] ) . '" value="&nbsp;' . Class_Base_Format ::htmlentities ( $submit[ "value" ] ) . '&nbsp;" ' . ( $submit[ "event_processing" ] ) . ' title="' . Class_Base_Format ::htmlentities ( $submit[ "value" ] ) . '" style="line-height:28px;font-size:20px;border-width:2px;' . Class_Base_Format ::htmlentities ( $submit[ "style" ] ) . '" >' ) ) . '</td>';
        $_form .= '        <td width="20%"></td><td width="20%">' . ( ( empty( $reset[ "display" ] ) ) ? "" : ( '<input id="' . Class_Base_Format ::htmlentities ( $reset[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $reset[ "name" ] ) . '" type="' . Class_Base_Format ::htmlentities ( $reset[ "type" ] ) . '" value="&nbsp;' . Class_Base_Format ::htmlentities ( $reset[ "value" ] ) . '&nbsp;" ' . ( $reset[ "event_processing" ] ) . ' title="' . Class_Base_Format ::htmlentities ( $reset[ "title" ] ) . '" style="line-height:28px;font-size:20px;border-width:2px;' . Class_Base_Format ::htmlentities ( $reset[ "style" ] ) . '" >' ) ) . '</td>';
        $_form .= '        <td width="20%" style="text-align: center;">' . ( ( empty( $button[ "display" ] ) ) ? "" : ( '<input id="' . Class_Base_Format ::htmlentities ( $button[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $button[ "name" ] ) . '" type="' . Class_Base_Format ::htmlentities ( $button[ "type" ] ) . '" value="&nbsp;' . Class_Base_Format ::htmlentities ( $button[ "value" ] ) . '&nbsp;" ' . ( $button[ "event_processing" ] ) . ' title="' . Class_Base_Format ::htmlentities ( $button[ "title" ] ) . '" style="line-height:28px;font-size:20px;border-width:2px;' . Class_Base_Format ::htmlentities ( $button[ "style" ] ) . '" >' ) ) . '</td>';
        $_form .= '      </tr>';
        $_form .= '    </table>';
        $_form .= '  </div>';
        $_form .= '</form>';
        $_form .= '</div>';
        return $_form;
    }

    public static function dyn_form_body ( $form )
    {
        $form  = self ::init_form ( $form );
        $_html = self ::dyn_form ( $form[ "hiddens" ] , $form[ "selects" ] , $form[ "inputs" ] , $form[ "textareas" ] , $form[ "files" ] , $form[ "submit" ] , $form[ "reset" ] , $form[ "button" ] , $form[ "id" ] , $form[ "style" ] );
        return $_html;
    }

    public static function dyn_form ( $hiddens = array () , $selects = array () , $inputs = array () , $textareas = array () , $files = array () , $submit = array () , $reset = array () , $button = array () , $div_id = "form_div_id" , $div_style = "display:none;" )
    {
        $_form = '';
        $_form .= '<div id="div_dyn_form_id_' . $div_id . '" style="' . $div_style . '">';
        if ( ! is_array ( $submit ) ) {
            $submit = array ();
        }
        if ( ( ! isset( $submit[ "name" ] ) ) || ( ! is_string ( $submit[ "name" ] ) ) ) {
            $submit[ "name" ] = "submit_0";
        }
        if ( ! is_array ( $reset ) ) {
            $reset = array ();
        }
        if ( ( ! isset( $reset[ "name" ] ) ) || ( ! is_string ( $reset[ "name" ] ) ) ) {
            $reset[ "name" ] = "reset_0";
        }
        if ( ! is_array ( $button ) ) {
            $button = array ();
        }
        if ( ( ! isset( $button[ "name" ] ) ) || ( ! is_string ( $button[ "name" ] ) ) ) {
            $button[ "name" ] = "button_0";
        }
        foreach ( $hiddens as $hidden_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "hiddens_" . $hidden_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "hiddens_" . $hidden_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ! isset( $item[ "events" ] ) ) {
                $item[ "events" ] = array ();
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<input id="' . Class_Base_Format ::htmlentities ( $item[ "id" ] ) . '" name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" type="hidden" value="' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '" ' . $_event_processing . '>';
        }
        $_form .= '<div>';
        foreach ( $selects as $select_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "selects_" . $select_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "selects_" . $select_index );
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            if ( ( ! isset( $item[ "options" ] ) ) || ( ! is_array ( $item[ "options" ] ) ) ) {
                $item[ "options" ] = array ();
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="margin-top: 32px;">';
            $_form .= '<table style="width:100%;font-size:18px;"><tr><td width="20%" style="text-align: left;">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</td><td width="60%" style="text-align: center;"><select name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" size="1" style="width:100%;height:32px;line-height:24px;font-size:18px;border-width:2px;text-align:center;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '"  ' . $item[ "disabled" ] . ' ' . $_event_processing . '><option value=""> ------ SELECT ------ </option>';
            foreach ( $item[ "options" ] as $option_index => $option ) {
                if ( isset( $option[ "value" ] ) ) {
                    if ( ( ! isset( $option[ "title" ] ) ) || ( ( ! is_string ( $option[ "title" ] ) ) && ( is_numeric ( $option[ "title" ] ) ) ) ) {
                        $option[ "title" ] = $option[ "value" ];
                    }
                    if ( ( ! isset( $option[ "describe" ] ) ) || ( ( ! is_string ( $option[ "describe" ] ) ) && ( is_numeric ( $option[ "describe" ] ) ) ) ) {
                        $option[ "describe" ] = $option[ "title" ];
                    }
                    if ( ( ! isset( $option[ "selected" ] ) ) || ( ( ! is_string ( $option[ "selected" ] ) ) ) ) {
                        $option[ "selected" ] = "";
                    }
                    $_form .= '<option title="' . Class_Base_Format ::htmlentities ( $option[ "describe" ] ) . '" value="' . Class_Base_Format ::htmlentities ( $option[ "value" ] ) . '" ' . $option[ "selected" ] . '>' . Class_Base_Format ::htmlentities ( $option[ "title" ] ) . '</option>';
                }
            }
            $_form .= '</select></td><td width="20%" style="padding-left:10px;text-align:left;color:red;">' . Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] ) . '</td></tr></table>';
            $_form .= '</div>';
        }
        $_form .= '</div>';
        $_form .= '<div>';
        foreach ( $inputs as $input_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "inputs_" . $input_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "inputs_" . $input_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ( ! isset( $item[ "title" ] ) ) || ( ( ! is_string ( $item[ "title" ] ) ) && ( ! is_numeric ( $item[ "title" ] ) ) ) ) {
                $item[ "title" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ( ! is_string ( $item[ "describe" ] ) ) && ( ! is_numeric ( $item[ "describe" ] ) ) ) ) {
                $item[ "describe" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="height:32px;"></div>';
            $_form .= '<div>';
            $_form .= '<table style="width:100%;line-height:24px;font-size:18px;"><tr><td width="20%" style="text-align: left;">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</td><td width="60%">';
            $_form .= '<input name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" type="text" title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '" style="width:100%;line-height:24px;font-size:18px;border-width:2px;text-align:center;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '"  value="' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '" ' . Class_Base_Format ::htmlentities ( $item[ "disabled" ] ) . ' ' . $_event_processing . '>';
            $_form .= '</td><td width="20%" style="padding-left:10px;text-align:left;color:red;">' . Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] ) . '</td></tr></table>';
            $_form .= '</div>';
        }
        $_form .= '</div>';
        $_form .= '<div>';
        foreach ( $textareas as $textarea_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "textareas_" . $textarea_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "textareas_" . $textarea_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ( ! isset( $item[ "title" ] ) ) || ( ( ! is_string ( $item[ "title" ] ) ) && ( ! is_numeric ( $item[ "title" ] ) ) ) ) {
                $item[ "title" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ( ! is_string ( $item[ "describe" ] ) ) && ( ! is_numeric ( $item[ "describe" ] ) ) ) ) {
                $item[ "describe" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="height:32px;"></div>';
            $_form .= '<div>';
            $_form .= '<table style="width:100%;line-height:24px;font-size:18px;">';
            $_form .= '<tr>';
            $_form .= '<td width="20%" style="text-align: left;">';
            $_form .= Class_Base_Format ::htmlentities ( $item[ "title" ] );
            $_form .= '</td>';
            $_form .= '<td width="60%" style="text-align: left;">';
            $_form .= '<textarea name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" style="width:100%;height:200px;font-size:18px;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '" ' . Class_Base_Format ::htmlentities ( $item[ "disabled" ] ) . ' ' . $_event_processing . '>' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '</textarea>';
            $_form .= '</td>';
            $_form .= '<td width="20%" style="padding-left:10px;text-align: left;color:red;">';
            $_form .= Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] );
            $_form .= '</td>';
            $_form .= '</tr>';
            $_form .= '</table>';
            $_form .= '</div>';
        }
        $_form .= '</div>';
        $_form .= '<div>';
        foreach ( $files as $file_index => $item ) {
            if ( ( ! isset( $item[ "id" ] ) ) || ( ! is_string ( $item[ "id" ] ) ) ) {
                $item[ "id" ] = ( "files_" . $file_index );
            }
            if ( ( ! isset( $item[ "name" ] ) ) || ( ! is_string ( $item[ "name" ] ) ) ) {
                $item[ "name" ] = ( "files_" . $file_index );
            }
            if ( ( ! isset( $item[ "value" ] ) ) || ( ( ! is_string ( $item[ "value" ] ) ) && ( ! is_numeric ( $item[ "value" ] ) ) ) ) {
                $item[ "value" ] = "";
            }
            if ( ( ! isset( $item[ "title" ] ) ) || ( ( ! is_string ( $item[ "title" ] ) ) && ( ! is_numeric ( $item[ "title" ] ) ) ) ) {
                $item[ "title" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "describe" ] ) ) || ( ( ! is_string ( $item[ "describe" ] ) ) && ( ! is_numeric ( $item[ "describe" ] ) ) ) ) {
                $item[ "describe" ] = $item[ "value" ];
            }
            if ( ( ! isset( $item[ "explanatory_note" ] ) ) || ( ( ! is_string ( $item[ "explanatory_note" ] ) ) && ( ! is_numeric ( $item[ "explanatory_note" ] ) ) ) ) {
                $item[ "explanatory_note" ] = "";
            }
            if ( ( ! isset( $item[ "disabled" ] ) ) || ( ! is_string ( $item[ "disabled" ] ) ) ) {
                $item[ "disabled" ] = "";
            }
            if ( ( ! isset( $item[ "style" ] ) ) || ( ! is_string ( $item[ "style" ] ) ) ) {
                $item[ "style" ] = "";
            }
            $_event_processing = '';
            foreach ( $item[ "events" ] as $event => $processing ) {
                if ( ( is_string ( $event ) ) & ( strlen ( $event ) > 0 ) && ( is_string ( $event ) ) && ( strlen ( $processing ) > 0 ) ) {
                    $_event_processing .= chr ( 32 ) . ( $event ) . chr ( 61 ) . chr ( 34 ) . ( $processing ) . chr ( 34 ) . chr ( 59 ) . chr ( 32 );
                }
            }
            $_form .= '<div style="height:32px;"></div>';
            $_form .= '<div>';
            $_form .= '<table style="width:100%;line-height:24px;font-size:18px;"><tr><td width="20%" style="text-align: left;">' . Class_Base_Format ::htmlentities ( $item[ "title" ] ) . '</td><td width="60%" style="text-align: left;">';
            $_form .= '<input name="' . Class_Base_Format ::htmlentities ( $item[ "name" ] ) . '" type="file" title="' . Class_Base_Format ::htmlentities ( $item[ "describe" ] ) . '" style="width:100%;line-height:24px;font-size:18px;border-width:2px;text-align:left;' . Class_Base_Format ::htmlentities ( $item[ "style" ] ) . '"  value="' . Class_Base_Format ::htmlentities ( $item[ "value" ] ) . '" ' . Class_Base_Format ::htmlentities ( $item[ "disabled" ] ) . ' ' . $_event_processing . '>';
            $_form .= '</td><td width="20%" style="padding-left:10px;text-align:left;color:red;">' . Class_Base_Format ::htmlentities ( $item[ "explanatory_note" ] ) . '</td></tr></table>';
            $_form .= '</div>';
        }
        $_form .= "</div>";
        $_form .= '<div style="height:32px;"></div>';
        $_form .= '</div>';
        $_form .= '<script type="text/javascript">';
        $_form .= 'var source_form_element_names=new Array(),source_form_element_names_index=0;';
        $_form .= 'function exist_form_elements(form_elements,name)';
        $_form .= '{';
        $_form .= '   for(index=0;index<form_elements.length;index++)';
        $_form .= '   {';
        $_form .= '       if(form_elements[index]==undefined){ console.log("form_elements["+index+"] is undefined , in exist_form_elements");  }';
        $_form .= '       if(form_elements[index].name==name)';
        $_form .= '       {';
        $_form .= '           console.log("form elements [ "+name+" ] is exist");';
        $_form .= '           return true;';
        $_form .= '       }';
        $_form .= '   }';
        $_form .= '   console.log("form elements [ "+name+" ] not is exist");';
        $_form .= '   return false;';
        $_form .= '}';
        $_form .= 'function get_form_source_element_names_index(form_elements,name)';
        $_form .= '{';
        $_form .= '   for(index=0;index<form_elements.length;index++)';
        $_form .= '   {';
        $_form .= '       if(form_elements[index]==undefined){ console.log("form_elements["+index+"] is undefined , in get_form_source_element_names_index");  }';
        $_form .= '       if(form_elements[index]["name"]==name)';
        $_form .= '       {';
        $_form .= '           console.log(name+" index is "+index);';
        $_form .= '           return index;';
        $_form .= '       }';
        $_form .= '   }';
        $_form .= '   console.log(name+" index is not found");';
        $_form .= '   console.log(form_elements);';
        $_form .= '   return false;';
        $_form .= '}';
        $_form .= 'function click_dyn_add_button(form_id,input_hidden_field_id)';
        $_form .= '{';
        $_form .= '    console.clear();';
        $_form .= '    var index = parseInt(document.getElementById(input_hidden_field_id).value);';
        $_form .= '    if(index>=9){alert("Considering the limitation of interface space, the current number of dynamic forms is limited to 10."); return ; }';
        $_form .= '    if(document.getElementById("div_id_dyn_form_show_"+form_id).innerHTML==""){';
        $_form .= '       document.getElementById("div_id_dyn_form_show_"+form_id).innerHTML = document.getElementById("div_dyn_form_id_"+form_id).innerHTML;';
        $_form .= '       for(i=0;i<document.getElementById(form_id).elements.length;i++)';
        $_form .= '       {';
        $_form .= '           if(!document.getElementById(form_id).elements[i].id){ source_form_element_names[source_form_element_names_index]=new Array(); source_form_element_names[source_form_element_names_index]["name"]=document.getElementById(form_id).elements[i].name;  console.log(source_form_element_names[source_form_element_names_index]);   source_form_element_names_index++; }';
        $_form .= '       }';
        $_form .= '       source_form_element_names_index=0;';
        $_form .= '       console.log(source_form_element_names); ';
        $_form .= '    }else{';
        $_form .= '       document.getElementById("div_id_dyn_form_show_"+form_id).innerHTML += document.getElementById("div_dyn_form_id_"+form_id).innerHTML;';
        $_form .= '    }';
        $_form .= '    console.log(document.getElementById(form_id).elements);';
        $_form .= '    for(i=0;i<document.getElementById(form_id).elements.length;i++)';
        $_form .= '    {';
        $_form .= '        var name_items = document.getElementById(form_id).elements[i].name.split("_");';
        $_form .= '        if(name_items.length>=1)';
        $_form .= '        {';
        $_form .= '            console.log(name_items);';
        $_form .= '            var name_last_item = name_items[name_items.length-1];';
        $_form .= '            console.log("name_last_item : "+name_last_item);';
        $_form .= '            var name_last_item_is_not_a_integer = (!is_integer(name_last_item));';
        $_form .= '            console.log("name_last_item_is_not_a_integer : "+name_last_item_is_not_a_integer);';
        $_form .= '            var element_name_neq_dyn_form_hidden_index_name = (document.getElementById(form_id).elements[i].name!="dyn_form_hidden_index_name");';
        $_form .= '            console.log("element_name_neq_dyn_form_hidden_index_name : "+element_name_neq_dyn_form_hidden_index_name);';
        $_form .= '            var element_name_neq_submit_name = (document.getElementById(form_id).elements[i].name!="' . Class_Base_Format ::htmlentities ( $submit[ "name" ] ) . '");';
        $_form .= '            console.log("element_name_neq_submit_name : "+element_name_neq_submit_name);';
        $_form .= '            var element_name_neq_reset_name = (document.getElementById(form_id).elements[i].name!="' . Class_Base_Format ::htmlentities ( $reset[ "name" ] ) . '");';
        $_form .= '            console.log("element_name_neq_reset_name : "+element_name_neq_reset_name);';
        $_form .= '            var element_name_neq_button_name = (document.getElementById(form_id).elements[i].name!="' . Class_Base_Format ::htmlentities ( $button[ "name" ] ) . '");';
        $_form .= '            console.log("element_name_neq_button_name : "+element_name_neq_button_name);';
        $_form .= '            elment_name_in_source_form_element_index = get_form_source_element_names_index(source_form_element_names,document.getElementById(form_id).elements[i].name);';
        $_form .= '            console.log("elment_name_in_source_form_element_index : "+elment_name_in_source_form_element_index);';
        $_form .= '            source_form_element_is_not_undefined = (elment_name_in_source_form_element_index!==false);';
        $_form .= '            console.log("source_form_element_is_not_undefined : "+source_form_element_is_not_undefined);';
        $_form .= '            var element_name_is_not_exist = ((source_form_element_is_not_undefined)&&(!exist_form_elements((document.getElementById(form_id).elements),(source_form_element_names[elment_name_in_source_form_element_index]["name"]+"_"+index))));';
        $_form .= '            console.log("element_name_is_not_exist : "+element_name_is_not_exist);';
        $_form .= '            var element_id_is_not_exist = (!document.getElementById(form_id).elements[i].id);';
        $_form .= '            console.log("element_id_is_not_exist : "+element_id_is_not_exist);';
        $_form .= '            if((name_last_item_is_not_a_integer)&&(element_name_neq_dyn_form_hidden_index_name)&&(element_name_neq_submit_name)&&(element_name_neq_reset_name)&&(element_name_neq_button_name)&&(source_form_element_is_not_undefined )&&(element_name_is_not_exist)&&(element_id_is_not_exist)){ ';
        $_form .= '                document.getElementById(form_id).elements[i].name=(source_form_element_names[elment_name_in_source_form_element_index]["name"]+"_"+index); console.log("new element name : "+document.getElementById(form_id).elements[i].name); ';
        $_form .= '            }';
        $_form .= '        }';
        $_form .= '    }';
        $_form .= '    console.log(source_form_element_names);';
        $_form .= '    document.getElementById(input_hidden_field_id).value=(index+1); ';
        $_form .= '    document.getElementById("div_id_dyn_form_show_"+form_id).style.display="block";';
        $_form .= '}';
        $_form .= '</script>';

        return $_form;
    }

    public static function json ( $object = null )
    {
        if ( ( ! is_array ( $object ) ) && ( ! is_object ( $object ) ) ) {
            if ( is_integer ( $object ) ) {
                $object = array ( 'integer' => $object );
            } else if ( is_float ( $object ) ) {
                $object = array ( 'float' => $object );
            } else if ( is_double ( $object ) ) {
                $object = array ( 'double' => $object );
            } else if ( is_bool ( $object ) ) {
                $object = array ( 'boolean' => $object );
            } else if ( is_string ( $object ) ) {
                $object = array ( 'string' => $object );
            }
        }
        $_json = json_encode ( $object , JSON_PRETTY_PRINT );
        return $_json;
    }
}