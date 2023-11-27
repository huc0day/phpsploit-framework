<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-4-7
 * Time: 下午1:22
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

class Class_Base_Bootstrap extends Class_Base
{
    const DEFAULT_DOWNLOAD_PACKAGE_LINK    = "https://github.com/twbs/bootstrap/releases/download/v5.3.0-alpha3/bootstrap-5.3.0-alpha3-dist.zip";
    const DEFAULT_DOWNLOAD_SOURCE_LINK     = "https://github.com/twbs/bootstrap/archive/v5.3.0-alpha3.zip";
    const DEFAULT_DOWNLOAD_EXAMPLES_LINK   = "https://github.com/twbs/bootstrap/releases/download/v5.3.0-alpha3/bootstrap-5.3.0-alpha3-examples.zip";
    const DEFAULT_DOWNLOAD_JQUERY_LINK     = 'https://code.jquery.com/jquery-3.6.4.min.js';
    const DEFAULT_DOWNLOAD_JQUERY_MAP_LINK = 'https://code.jquery.com/jquery-3.6.4.min.map';
    const DEFAULT_JQUERY_GIT_CLONE         = 'https://github.com/jquery/jquery.git';
    const DEFAULT_BOOTSTRAP_GIT_CLONE      = "https://github.com/twbs/bootstrap.git";
    const DEFAULT_CSS_LABEL                = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">';
    const DEFAULT_JS_LABEL                 = '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>';
    const DEFAULT_JQUERY_JS_LABEL          = '<script src=https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    const DEFAULT_NPM_INSTALL              = 'npm install bootstrap@5.3.0-alpha3';
    const DEFAULT_GEM_INSTALL              = 'gem install bootstrap -v 5.3.0-alpha3';
    const DEFAULT_YARN_INSTALL             = 'yarn add bootstrap@5.3.0-alpha3';
    const DEFAULT_COMPOSER_INSTALL         = 'composer require twbs/bootstrap:5.3.0-alpha3';
    const DEFAULT_NU_GET_CSS_INSTALL       = 'Install-Package bootstrap';
    const DEFAULT_NU_GET_SASS_INSTALL      = 'Install-Package bootstrap.sass';
    const DEFAULT_CHARSET                  = "utf-8";

    public static function get_html_head ( $language = "en" , $charset = "utf-8" , $title = "phpsploit-framework" )
    {
        $_html = '<!doctype html><html lang="' . $language . '"><head><meta charset="' . $charset . '"><meta name="viewport" content="width=device-width, initial-scale=1"><title>' . $title . '</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.6.4.min.js"></script></head><body><div class="container py-4 px-3 mx-auto">';
        return $_html;
    }

    public static function get_html_body ( $html_code )
    {
        $_html = $html_code;
        return $_html;
    }

    public static function get_html_foot ( $javascript_code )
    {
        $_html = '<script type="text/javascript">$(document).ready(function(){' . $javascript_code . '});</script></div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script></body></html>';
        return $_html;
    }

    public static function get_html ( $head , $body , $foot )
    {
        $_html = $head . $body . $foot;
        return $_html;
    }
}