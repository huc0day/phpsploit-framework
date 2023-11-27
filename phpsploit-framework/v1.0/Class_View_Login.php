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

class Class_View_Login extends Class_View
{
    public static function login ( $params = array () )
    {
        if ( ! is_cli () ) {
            return ( Class_View::form_page (
                array (
                    "title"   => "login to phpsploit-framework" ,
                    "content" => '<div style="height:16px;"></div><div style="line-height:32px;font-size:32px;text-align: center;">login to phpsploit-framework</div><div style="height:32px;"></div>' ,
                ) ,
                array (
                    "action"    => "/login" ,
                    "inputs"    => array (
                        array (
                            "title"    => "User : " ,
                            "describe" => "user" ,
                            "name"     => "user" ,
                            "value"    => $params[ "user" ] ,
                        ) ,
                        array (
                            "title"    => "Password : " ,
                            "describe" => "password" ,
                            "name"     => "password" ,
                            "value"    => $params[ "password" ] ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "title"    => "Additional Service Terms ： " ,
                            "describe" => 'PhpSploit框架是专为善而非恶而设计的。如果您计划将此工具用于未经您执行评估的公司授权的恶意目的，则表示您违反了此工具集的服务条款和许可证。点击提交（仅一次），即表示您同意服务条款，并且您只能将此工具用于合法目的。' ,
                            "name"     => "additional_service_terms" ,
                            "value"    => 'The PhpSploit-Framework is designed purely for good and not evil. If you are planning on using this tool for malicious purposes that are not authorized by the company you are performing assessments for, you are violating the terms of service and license of this toolset. By hitting submit (only one time), you agree to the terms of service and that you will only use this tool for lawful purposes only.' ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "gets"      => array () ,
                ) ,
                array () )
            );
        }
        return null;
    }
}