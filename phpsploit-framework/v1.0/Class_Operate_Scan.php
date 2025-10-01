<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-2
 * Time: 下午1:36
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

class Class_Operate_Scan extends Class_Operate
{
    public static function request_webs ( $webs )
    {
        $_result = array ();
        if ( is_array ( $webs ) ) {
            foreach ( $webs as $index => $web ) {
                if ( is_string ( $web ) ) {
                    $_web_string_length              = strlen ( $web );
                    $_communication_protocol_header  = false;
                    $_last_separator_symbol_position = false;
                    if ( ( $_web_string_length > 7 ) ) {
                        $_tmp_string = substr ( $web , 0 , 7 );
                        if ( $_tmp_string == "http://" ) {
                            $_communication_protocol_header  = "http://";
                            $_last_separator_symbol_position = strpos ( $web , chr ( 47 ) , 7 );
                            if ( $_last_separator_symbol_position === 7 ) { /* http:// */
                                continue;
                            }
                        }
                    }
                    if ( ( $_web_string_length > 8 ) ) {
                        $_tmp_string = substr ( $web , 0 , 8 );
                        if ( $_tmp_string == "https://" ) {
                            $_communication_protocol_header  = "https://";
                            $_last_separator_symbol_position = strpos ( $web , chr ( 47 ) , 8 );
                            if ( $_last_separator_symbol_position === 8 ) {
                                continue;
                            }
                        }
                    }
                    if ( ( ( $_communication_protocol_header == "http://" ) || ( $_communication_protocol_header == "https://" ) ) ) {
                        if ( ( $_last_separator_symbol_position === false ) ) {
                            $_web_domain_url = $web;
                        } else {
                            $_web_domain_url = substr ( $web , 0 , $_last_separator_symbol_position );
                        }
                        $_result[ $_web_domain_url ] = self::request_web_get_httpcode ( $_web_domain_url );
                    }
                }
            }
        }
        return $_result;
    }

    public static function request_web_get_httpcode ( $web )
    {
        $request_timeout = 4;
        $_curl_handle    = curl_init ();
        curl_setopt ( $_curl_handle , CURLOPT_FOLLOWLOCATION , 1 );
        curl_setopt ( $_curl_handle , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt ( $_curl_handle , CURLOPT_HEADER , 1 );
        curl_setopt ( $_curl_handle , CURLOPT_CONNECTTIMEOUT , $request_timeout );
        curl_setopt ( $_curl_handle , CURLOPT_URL , $web );
        curl_exec ( $_curl_handle );
        $_http_code = curl_getinfo ( $_curl_handle , CURLINFO_HTTP_CODE );
        curl_close ( $_curl_handle );
        return $_http_code;

    }

    public static function request_domain_ports ( $ip , $ports )
    {
        $_result = array ();
        if ( ( is_string ( $ip ) ) && ( strlen ( $ip ) > 0 ) && ( Class_Base_Format::is_ip_address ( $ip ) ) && ( $ip != "0.0.0.0" ) && ( $ip != "255.255.255.255" ) && ( is_array ( $ports ) ) && ( count ( $ports ) > 0 ) ) {
            foreach ( $ports as $index => $port ) {
                $_key             = ( $ip . chr ( 58 ) . $port );
                $_result[ $_key ] = ( ( self::request_domain_port ( $ip , $port ) ) ? 1 : 0 );
            }
        }
        return $_result;
    }

    public static function request_domain_port ( $ip , $port )
    {
        try {
            $_socket  = Class_Base_Socket::create ( AF_INET , SOCK_STREAM , SOL_TCP );
            $_connect = Class_Base_Socket::connect ( $_socket , $ip , $port );
            return $_connect;
        } catch ( \Exception $e ) {
            try {
                Class_Base_Socket::close ( $_socket );
            } catch ( \Exception $e ) {
            }
            return false;
        }
    }

    public static function scan_directory_exception ( $sampling_directory_path , $detection_directory_path , $search_sampling_progress_id , $search_detection_progress_id , $search_errors_id , $search_result_id , $usleep = 100 , $debug = 0 )
    {
        self::forward_matching_for_scan_directory_exception ( $sampling_directory_path , $detection_directory_path , $search_sampling_progress_id , $search_detection_progress_id , $search_errors_id , $search_result_id , $usleep , $debug );
        self::reverse_matching_for_scan_directory_exception ( $detection_directory_path , $sampling_directory_path , $search_sampling_progress_id , $search_detection_progress_id , $search_errors_id , $search_result_id , $usleep , $debug );
    }

    public static function forward_matching_for_scan_directory_exception ( $sampling_directory_path , $detection_directory_path , $search_sampling_progress_id , $search_detection_progress_id , $search_errors_id , $search_result_id , $usleep = 100 , $debug = 0 )
    {
        $_current_sampling_directory_object  = null;
        $_current_detection_directory_object = null;

        if ( ( ! is_string ( $sampling_directory_path ) ) || ( strlen ( $sampling_directory_path ) <= 0 ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The sampling directory path (  <span style="color:red;">' . $sampling_directory_path . '</span> ) is invalid ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( ' The sampling directory path ( ' . $sampling_directory_path . ' ) is invalid! ' ) );
            }
            return;
        } else if ( ( ! file_exists ( $sampling_directory_path ) ) || ( ! is_dir ( $sampling_directory_path ) ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The sampling directory path ( <span style="color:red;">' . $sampling_directory_path . '</span> ) is not a valid directory ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'The sampling directory path ( ' . $sampling_directory_path . ' ) is not a valid directory ! ' ) );
            }
            return;
        } else if ( ( ( $_current_sampling_directory_object = dir ( $sampling_directory_path ) ) === false ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'Directory <span style="color:red;">' . $sampling_directory_path . '</span> is not authorized to access, search has skipped this directory' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( $sampling_directory_path . ' is not authorized to access, search has skipped this directory ! ' ) );
            }
            return;
        }

        if ( ( ! is_string ( $detection_directory_path ) ) || ( strlen ( $detection_directory_path ) <= 0 ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The detection directory path (  <span style="color:red;">' . $detection_directory_path . '</span> ) is invalid ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( ' The detection directory path ( ' . $detection_directory_path . ' ) is invalid! ' ) );
            }
            return;
        } else if ( ( ! file_exists ( $detection_directory_path ) ) || ( ! is_dir ( $detection_directory_path ) ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The detection directory path ( <span style="color:red;">' . $detection_directory_path . '</span> ) is not a valid directory ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'The detection directory path ( ' . $detection_directory_path . ' ) is not a valid directory ! ' ) );
            }
            return;
        } else if ( ( ( $_current_detection_directory_object = dir ( $detection_directory_path ) ) === false ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'Directory <span style="color:red;">' . $detection_directory_path . '</span> is not authorized to access, search has skipped this directory' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( $detection_directory_path . ' is not authorized to access, search has skipped this directory ! ' ) );
            }
            return;
        }

        if ( $_current_sampling_directory_object !== false ) {

            while ( $file = $_current_sampling_directory_object->read () ) {

                Class_Base_Response::check_browser_service_stop ();

                if ( $file !== false ) {

                    $_current_child_item = ( $sampling_directory_path . "/" . $file );

                    if ( ! is_cli () ) {
                        Class_Base_Response::output_div_inner_html ( $search_sampling_progress_id , ( 'Current sampling path: <span style="color:red;">' . ( $sampling_directory_path . "/" . $file ) . '</span> ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                    } else {
                        Class_Base_Response::outputln ( ( 'Current sampling path: ' . ( $sampling_directory_path . "/" . $file ) ) );
                    }

                    if ( ! is_cli () ) {
                        Class_Base_Response::output_div_inner_html ( $search_detection_progress_id , ( 'Current detection path: <span style="color:red;">' . ( $detection_directory_path . "/" . $file ) . '</span> ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                    } else {
                        Class_Base_Response::outputln ( ( 'Current detection path: ' . ( $detection_directory_path . "/" . $file ) ) );
                    }

                    if ( is_dir ( $_current_child_item ) && ( $_current_child_item != ( $sampling_directory_path . "/." ) ) && ( $_current_child_item != ( $sampling_directory_path . "/.." ) ) ) {

                        $_current_sampling_child_directory  = ( $sampling_directory_path . "/" . $file );
                        $_current_detection_child_directory = ( $detection_directory_path . "/" . $file );

                        if ( ( ! file_exists ( $_current_detection_child_directory ) ) || ( ! is_dir ( $_current_detection_child_directory ) ) ) {
                            if ( ! is_cli () ) {
                                Class_Base_Response::output_div_inner_html ( $search_result_id , ( 'Detected abnormality ! After sample comparison, the current detection directory (  <span style="color:red;">' . $_current_detection_child_directory . '</span> ) is missing ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                            } else {
                                Class_Base_Response::outputln ( ( 'Detected abnormality ! After sample comparison, the current detection directory ( ' . $_current_detection_child_directory . ' ) is missing ! ' ) );
                            }
                        } else {
                            self::scan_directory_exception ( $_current_sampling_child_directory , $_current_detection_child_directory , $search_sampling_progress_id , $search_errors_id , $search_result_id , $usleep , $debug );
                        }

                    } else if ( is_file ( $_current_child_item ) ) {

                        $_current_sampling_child_file  = ( $sampling_directory_path . "/" . $file );
                        $_current_detection_child_file = ( $detection_directory_path . "/" . $file );

                        if ( ( ! file_exists ( $_current_detection_child_file ) ) || ( ! is_file ( $_current_detection_child_file ) ) ) {
                            if ( ! is_cli () ) {
                                Class_Base_Response::output_div_inner_html ( $search_result_id , ( 'Detected abnormality ! After sample comparison, the current detection file ( <span style="color:red;">' . $_current_detection_child_file . '</span> ) is missing ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                            } else {
                                Class_Base_Response::outputln ( ( 'Detected abnormality ! After sample comparison, the current detection file ( ' . $_current_detection_child_file . ' ) is missing ! ' ) );
                            }
                        } else {
                            self::calculate_content_matching ( $_current_sampling_child_file , $_current_detection_child_file , $search_errors_id , $search_result_id );
                        }
                    }
                }
            }
        }
    }

    public static function reverse_matching_for_scan_directory_exception ( $detection_directory_path , $sampling_directory_path , $search_sampling_progress_id , $search_detection_progress_id , $search_errors_id , $search_result_id , $usleep = 100 , $debug = 0 )
    {
        $_current_detection_directory_object = null;
        $_current_sampling_directory_object  = null;

        if ( ( ! is_string ( $detection_directory_path ) ) || ( strlen ( $detection_directory_path ) <= 0 ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The detection directory path (  <span style="color:red;">' . $detection_directory_path . '</span> ) is invalid ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( ' The detection directory path ( ' . $detection_directory_path . ' ) is invalid! ' ) );
            }
            return;
        } else if ( ( ! file_exists ( $detection_directory_path ) ) || ( ! is_dir ( $detection_directory_path ) ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The detection directory path ( <span style="color:red;">' . $detection_directory_path . '</span> ) is not a valid directory ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'The detection directory path ( ' . $detection_directory_path . ' ) is not a valid directory ! ' ) );
            }
            return;
        } else if ( ( ( $_current_detection_directory_object = dir ( $detection_directory_path ) ) === false ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'Directory <span style="color:red;">' . $detection_directory_path . '</span> is not authorized to access, search has skipped this directory' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'Directory ' . $detection_directory_path . ' is not authorized to access, search has skipped this directory ! ' ) );
            }
            return;
        }

        if ( ( ! is_string ( $sampling_directory_path ) ) || ( strlen ( $sampling_directory_path ) <= 0 ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The sampling directory path (  <span style="color:red;">' . $sampling_directory_path . '</span> ) is invalid ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( ' The sampling directory path ( ' . $sampling_directory_path . ' ) is invalid! ' ) );
            }
            return;
        } else if ( ( ! file_exists ( $sampling_directory_path ) ) || ( ! is_dir ( $sampling_directory_path ) ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'The sampling directory path ( <span style="color:red;">' . $sampling_directory_path . '</span> ) is not a valid directory ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'The sampling directory path ( ' . $sampling_directory_path . ' ) is not a valid directory ! ' ) );
            }
            return;
        } else if ( ( ( $_current_sampling_directory_object = dir ( $sampling_directory_path ) ) === false ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'Directory <span style="color:red;">' . $sampling_directory_path . '</span> is not authorized to access, search has skipped this directory' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'Directory ' . $sampling_directory_path . ' is not authorized to access, search has skipped this directory ! ' ) );
            }
            return;
        }

        if ( $_current_detection_directory_object !== false ) {

            while ( $file = $_current_detection_directory_object->read () ) {

                Class_Base_Response::check_browser_service_stop ();

                if ( $file !== false ) {

                    $_current_child_item = ( $detection_directory_path . "/" . $file );

                    if ( ! is_cli () ) {
                        Class_Base_Response::output_div_inner_html ( $search_detection_progress_id , ( 'Current detection path: <span style="color:red;">' . ( $detection_directory_path . "/" . $file ) . '</span> ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                    } else {
                        Class_Base_Response::outputln ( ( 'Current detection path: ' . ( $detection_directory_path . "/" . $file ) ) );
                    }

                    if ( ! is_cli () ) {
                        Class_Base_Response::output_div_inner_html ( $search_sampling_progress_id , ( 'Current sampling path: <span style="color:red;">' . ( $sampling_directory_path . "/" . $file ) . '</span> ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_COVER );
                    } else {
                        Class_Base_Response::outputln ( ( 'Current sampling path: ' . ( $sampling_directory_path . "/" . $file ) ) );
                    }

                    if ( is_dir ( $_current_child_item ) && ( $_current_child_item != ( $detection_directory_path . "/." ) ) && ( $_current_child_item != ( $detection_directory_path . "/.." ) ) ) {

                        $_current_detection_child_directory = ( $detection_directory_path . "/" . $file );
                        $_current_sampling_child_directory  = ( $sampling_directory_path . "/" . $file );


                        if ( ( ! file_exists ( $_current_sampling_child_directory ) ) || ( ! is_dir ( $_current_sampling_child_directory ) ) ) {
                            if ( ! is_cli () ) {
                                Class_Base_Response::output_div_inner_html ( $search_result_id , ( 'There is an abnormality in the current detected directory (  <span style="color:red;">' . $_current_detection_child_directory . '</span>  ), and the corresponding sample cannot be found in the sample directory ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                            } else {
                                Class_Base_Response::outputln ( ( 'There is an abnormality in the current detected directory ( ' . $_current_detection_child_directory . ' ), and the corresponding sample cannot be found in the sample directory ! ' ) );
                            }
                        } else {
                            self::scan_directory_exception ( $_current_detection_child_directory , $_current_sampling_child_directory , $search_sampling_progress_id , $search_errors_id , $search_result_id , $usleep , $debug );
                        }

                    } else if ( is_file ( $_current_child_item ) ) {

                        $_current_detection_child_file = ( $detection_directory_path . "/" . $file );
                        $_current_sampling_child_file  = ( $sampling_directory_path . "/" . $file );

                        if ( ( ! file_exists ( $_current_sampling_child_file ) ) || ( ! is_file ( $_current_sampling_child_file ) ) ) {
                            if ( ! is_cli () ) {
                                Class_Base_Response::output_div_inner_html ( $search_result_id , ( 'The currently detected file ( <span style="color:red;">' . $_current_detection_child_file . '</span> ) has an exception, and the corresponding sampling cannot be found in the sampling directory ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
                            } else {
                                Class_Base_Response::outputln ( ( 'The currently detected file ( ' . $_current_detection_child_file . ' ) has an exception, and the corresponding sampling cannot be found in the sampling directory ! ' ) );
                            }
                        } else {
                            self::calculate_content_matching ( $_current_sampling_child_file , $_current_detection_child_file , $search_errors_id , $search_result_id );
                        }
                    }
                }
            }
        }
    }

    public static function calculate_content_matching ( $current_sampling_child_file , $current_detection_child_file , $search_errors_id , $search_result_id )
    {
        $_is_error                          = false;
        $_is_exception                      = false;
        $_current_sampling_child_file_size  = Class_Base_File::get_file_size ( $current_sampling_child_file );
        $_current_detection_child_file_size = Class_Base_File::get_file_size ( $current_detection_child_file );
        if ( $_current_sampling_child_file_size === false ) {
            $_is_error = true;
        } else if ( $_current_detection_child_file_size === false ) {
            $_is_error = true;
        } else if ( $_current_sampling_child_file_size != $_current_detection_child_file_size ) {
            $_is_exception = true;
        } else {
            $_current_sampling_child_file_md5  = md5_file ( $current_sampling_child_file );
            $_current_detection_child_file_md5 = md5_file ( $current_detection_child_file );
            if ( $_current_sampling_child_file_md5 === false ) {
                $_is_error = true;
            } else if ( $_current_detection_child_file_md5 === false ) {
                $_is_error = true;
            } else if ( $_current_sampling_child_file_md5 != $_current_detection_child_file_md5 ) {
                $_is_exception = true;
            } else {
                $_current_sampling_child_file_sha1  = sha1_file ( $current_sampling_child_file );
                $_current_detection_child_file_sha1 = sha1_file ( $current_detection_child_file );
                if ( $_current_sampling_child_file_sha1 === false ) {
                    $_is_error = true;
                } else if ( $_current_detection_child_file_sha1 === false ) {
                    $_is_error = true;
                } else if ( $_current_sampling_child_file_sha1 != $_current_detection_child_file_sha1 ) {
                    $_is_exception = true;
                }
            }
        }
        if ( ! empty( $_is_error ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_errors_id , ( 'An error occurred during the matching detection between the target file ( <span style="color:red;">' . $current_detection_child_file . '</span> ) and the sample file (  ' . $current_sampling_child_file . ' ) ! Unable to successfully perform matching detection ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'An error occurred during the matching detection between the target file ( ' . $current_detection_child_file . ' ) and the sample file ( ' . $current_sampling_child_file . ' ) ! Unable to successfully perform matching detection ! ' ) );
            }
        }
        if ( ! empty( $_is_exception ) ) {
            if ( ! is_cli () ) {
                Class_Base_Response::output_div_inner_html ( $search_result_id , ( 'During matching detection between the target file ( <span style="color:red;">' . $current_detection_child_file . '</span> ) and the sample file ( <span style="color:red;">' . $current_sampling_child_file . '</span> ) , it was found that the matching results were inconsistent ! There may be an issue with the target file ( <span style="color:red;">' . $current_detection_child_file . '</span> ) , please check for any abnormalities ! ' ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
            } else {
                Class_Base_Response::outputln ( ( 'During matching detection between the target file ( ' . $current_detection_child_file . ' ) and the sample file ( ' . $current_sampling_child_file . ' ) , it was found that the matching results were inconsistent ! There may be an issue with the target file ( ' . $current_detection_child_file . ' ) , please check for any abnormalities ! ' ) );
            }
        }
    }
}