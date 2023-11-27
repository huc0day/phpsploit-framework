<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-16
 * Time: 下午6:44
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

class Class_View_Memory extends Class_View
{
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
        $_html = self::top ( $top ) . self::list_table ( $list[ "page" ] , $list[ "pagesize" ] , $list[ "total" ] , $list[ "list" ] , $list[ "search" ] ) . self::bottom ( $bottom );
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
        $_form_top    = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Show Share Memory Data List</div>';
        $_form_top    .= '<div style="margin-top:16px;text-align: left;font-size: 18px;"><span style="font-size: 18px;color:red;">This interface displays all found shared memory data that can be controlled by the Phpsploit Framework software framework.</div>';
        $_list      = '';
        $_list      .= '<div>';
        $_list      .= '<div style="padding-top: 32px;font-size: 18px;"><table style="width:100%;"><tr><td width="20%">search:</td><td width="80%" style="text-align: left;"><form action="' . Class_Base_Format::htmlentities ( Class_Base_Format::action ( $search[ "action" ] ) ) . '" method="post"><input name="' . Class_Base_Format::htmlentities ( $search[ "name" ] ) . '" type="text" value="' . Class_Base_Format::htmlentities ( $search[ "value" ] ) . '" style="width:60%;line-height:24px;font-size:18px;border-width:2px;text-align:center;">&nbsp;&nbsp;<input name="submit" type="submit" value="&nbsp;submit&nbsp;" style="line-height:25px;font-size:20px;border-width:2px;"></form></td></tr></table></div>';
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
                    $_list .= '<td style="text-align: left;padding-top: 14px;padding-bottom: 14px;"><a href="' . $value[ "link" ] . '">' . $key . '</a> : </td><td style="text-align: left;padding-top: 14px;padding-bottom: 14px;padding-right: 64px;">' . $value[ "value" ] . '</td>';
                    $_item_index++;
                }
                while ( $_item_index < $_item_size ) {
                    $_list .= '<td style="text-align: left;padding-top: 14px;padding-bottom: 14px;">&nbsp;</td><td style="text-align: left;padding-top: 14px;padding-bottom: 14px;">&nbsp;</td>';
                    $_item_index++;
                }
                $_list .= '</tr>';
            }
        }
        $_list .= '</table></div>';
        $_list .= '<div style="padding-top: 32px;font-size:18px;"><table style="width:100%;text-align: left;"><tr><td>page:</td><td style="text-align: left;padding-right:32px;">' . $page . '</td><td>page size:</td><td style="text-align: left;padding-right:32px;">' . ( empty( $list ) ? 0 : $page_size ) . '</td><td>max page:</td><td style="text-align: left;padding-right:32px;">' . ( empty( $list ) ? 0 : $max_page ) . '</td><td>row total:</td><td style="text-align: left;padding-right:32px;">' . ( empty( $list ) ? 0 : $row_total ) . '</td><td>to page:</td><td>';
        $_list .= '<select name="page" size="1" style="width:100%;height:32px;line-height:24px;font-size:18px;border-width:2px;text-align:center;" onchange="document.location.href=\'' . Class_Base_Response::get_url ( $search[ "action" ] ) . '&page=\'+this.value+\'&page_size=' . $page_size . '&key=' . Class_Base_Format::htmlentities ( $search[ "value" ] ) . '\';">';
        for ( $index = 1 ; $index <= $max_page ; $index++ ) {
            $_list .= '<option value="' . $index . '" ' . ( ( $page != $index ) ? "" : "selected" ) . '>' . $index . '</option>';
        }
        $_list .= "</select>";
        $_list .= '</td><td width="10%;"></td></tr></table></div>';
        $_list .= '</div>';
        $_form_body = ($_form_top.$_list);
        return $_form_body;
    }
}