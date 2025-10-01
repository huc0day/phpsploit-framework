<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 22-12-16
 * Time: 下午7:45
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

session_start ();
date_default_timezone_set ( "PRC" );

function is_development_environment ()
{
    $_development_environment_files = array (
        "Class_Main.php" ,
        "Class_Root.php" ,
        "Class_Base.php" ,
        "Class_Operate.php" ,
        "Class_Controller.php" ,
        "Class_View.php" ,
        "Interface_Main.php" ,
        "Interface_Root.php" ,
        "Interface_Base.php" ,
        "Interface_Operate.php" ,
        "Interface_Controller.php" ,
        "Interface_View.php" ,
    );
    foreach ( $_development_environment_files as $index => $file ) {
        $_file_path = ( dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . $file );
        if ( ( ! file_exists ( $_file_path ) ) || ( ! is_file ( $_file_path ) ) ) {
            return false;
        }
    }
    return true;
}

function check_key_constant_define ()
{
    if ( ( ! defined ( "DEBUG" ) ) || ( ! is_integer ( DEBUG ) ) ) {
        throw new \Exception( "Key constant ( DEBUG ) does not exist!" );
    }
    if ( ( ! defined ( "DEVLOP" ) ) || ( ! is_integer ( DEVLOP ) ) ) {
        throw new \Exception( "Key constant ( DEVLOP ) does not exist!" );
    }
    if ( ( ! defined ( "PRIVILEGE_USER_MODULE_USER" ) ) || ( empty( PRIVILEGE_USER_MODULE_USER ) ) ) {
        throw new \Exception( "Key constant ( PRIVILEGE_USER_MODULE_USER ) does not exist!" );
    }
    if ( ( ! defined ( "PRIVILEGE_USER_MODULE_PASSWORD" ) ) || ( empty( PRIVILEGE_USER_MODULE_PASSWORD ) ) ) {
        throw new \Exception( "Key constant ( PRIVILEGE_USER_MODULE_PASSWORD ) does not exist!" );
    }
}

function is_cli ()
{
    return ( ( PHP_SAPI == "cli" ) || ( php_sapi_name () == "cli" ) );
}

function is_root_permissions ()
{
    if ( ( 0 == posix_getuid () ) || ( 0 == posix_getgid () ) ) {
        return true;
    } else {
        return false;
    }
}

function check_extensions ( $extension_name )
{
    $extensions = get_loaded_extensions ();
    if ( in_array ( $extension_name , $extensions ) ) {
        return true;
    }
    $extension_name = strtolower ( $extension_name );
    foreach ( $extensions as $index => $extension ) {
        $extensions[ $index ] = strtolower ( $extension );
        if ( $extension_name == $extensions[ $index ] ) {
            return true;
        }
    }
    return false;
}

function get_current_process_username ()
{

    if ( function_exists ( 'posix_getpwuid' ) && function_exists ( 'posix_geteuid' ) ) {
        $userInfo = posix_getpwuid ( posix_geteuid () );
        if ( $userInfo && isset( $userInfo[ 'name' ] ) ) {
            return $userInfo[ 'name' ];
        }
    }

    if ( strtoupper ( substr ( PHP_OS , 0 , 3 ) ) === 'WIN' ) {

        if ( extension_loaded ( 'com_dotnet' ) ) {
            try {
                $wmi     = new COM( 'WinMgmts:' );
                $process = $wmi->ExecQuery ( 'SELECT * FROM Win32_Process WHERE ProcessId = ' . getmypid () );
                foreach ( $process as $proc ) {
                    $owner = $proc->GetOwner ();
                    if ( $owner && isset( $owner->User ) ) {
                        return $owner->User;
                    }
                }
            } catch ( Exception $e ) {

                $output = shell_exec ( 'whoami 2> nul' );
                if ( $output ) {
                    return trim ( $output );
                }
                if ( isset( $_SERVER[ 'USERNAME' ] ) ) {
                    return $_SERVER[ 'USERNAME' ];
                }
                if ( isset( $_ENV[ 'USERNAME' ] ) ) {
                    return $_ENV[ 'USERNAME' ];
                }
            }
        }

        return null;
    }

    if ( function_exists ( 'get_current_user' ) ) {
        $user = get_current_user ();
        if ( $user !== false && $user !== '' ) {
            return $user;
        }
    }

    $output = shell_exec ( 'whoami 2>/dev/null' );
    if ( $output !== null ) {
        return trim ( $output );
    }

    return null;
}

function get_current_file_owner_name ( $filePath )
{
    if ( ! file_exists ( $filePath ) ) {
        return null;
    }

    $filePath = realpath ( $filePath );


    if ( strtoupper ( substr ( PHP_OS , 0 , 3 ) ) !== 'WIN' ) {

        $fileOwnerUid = fileowner ( $filePath );
        if ( $fileOwnerUid === false ) {
            return null;
        }

        if ( function_exists ( 'posix_getpwuid' ) ) {
            $userInfo = posix_getpwuid ( $fileOwnerUid );
            if ( $userInfo && isset( $userInfo[ 'name' ] ) ) {
                return $userInfo[ 'name' ];
            }
        }

        $output = shell_exec ( "ls -ld " . escapeshellarg ( $filePath ) . " | awk '{print \$3}' 2>/dev/null" );
        if ( $output !== null && trim ( $output ) !== '' ) {
            return trim ( $output );
        }

        return null;

    } else {

        $command = "powershell -Command \"(Get-Acl -Path '" . str_replace ( "'" , "''" , $filePath ) . "').Owner\" 2>nul";
        $output  = shell_exec ( $command );

        if ( $output !== null && trim ( $output ) !== '' ) {

            $owner = trim ( $output );
            $parts = explode ( '\\' , $owner );

            return end ( $parts );
        }

        $command = "icacls " . escapeshellarg ( $filePath ) . " 2>nul";
        $output  = shell_exec ( $command );

        if ( $output !== null && preg_match ( '/.*?([^\\\]+)\\\\([^\\\]+).*?/i' , $output , $matches ) ) {

            if ( isset( $matches[ 2 ] ) ) {
                return $matches[ 2 ];
            }
        }

        if ( extension_loaded ( 'com_dotnet' ) ) {
            try {

                $wmi          = new COM( 'WinMgmts:' );
                $wmiPath      = str_replace ( '\\' , '\\\\' , $filePath );
                $query        = "SELECT * FROM Win32_LogicalFileSecuritySetting WHERE Path='{$wmiPath}'";
                $fileSettings = $wmi->ExecQuery ( $query );

                foreach ( $fileSettings as $setting ) {

                    $securityDescriptor = $setting->GetSecurityDescriptor ();

                    if ( $securityDescriptor->Owner ) {

                        $domain = $securityDescriptor->Owner->Domain;
                        $name   = $securityDescriptor->Owner->Name;

                        if ( ! empty( $domain ) ) {
                            return $domain . '\\' . $name;
                        } else {
                            return $name;
                        }
                    }
                }
            } catch ( COMException $e ) {

                return null;

            } catch ( Exception $e ) {

                return null;

            }
        }

        return null;
    }
}

function current_process_username_is_current_file_owner_username ( $file_path )
{

    $_process_username = get_current_process_username ();

    if ( ( $_process_username !== null ) && ( $_process_username !== false ) ) {

        $_file_username = get_current_file_owner_name ( $file_path );

        if ( ( $_file_username !== null ) && ( $_file_username !== false ) ) {

            if ( strcasecmp ( $_process_username , $_file_username ) == 0 ) {

                return true;

            } elseif ( strpos ( $_file_username , "\\" ) !== false ) {

                $_file_username_items = explode ( $_file_username , "\\" );

                if ( sizeof ( $_file_username_items ) > 1 ) {

                    if ( strcasecmp ( $_process_username , $_file_username_items[ 1 ] ) == 0 ) {

                        return true;

                    }
                }

            }
        }
    }

    return false;
}

function is_file_executable_windows ( $filePath )
{
    $executableExtensions = array ( 'exe' , 'bat' , 'cmd' , 'com' , 'msi' , 'pif' , 'scr' , 'vbs' , 'vbe' , 'ws' , 'wsf' , 'wsh' , 'ps1' , 'psm1' , 'msc' );
    $extension            = strtolower ( pathinfo ( $filePath , PATHINFO_EXTENSION ) );

    if ( in_array ( $extension , $executableExtensions ) ) {

        $command = "icacls " . escapeshellarg ( $filePath ) . " 2>nul";
        $output  = shell_exec ( $command );

        if ( $output !== null ) {

            if ( preg_match ( '/.*?\(RX\).*?/i' , $output ) ) {
                return true;
            }
        }

        if ( is_readable ( $filePath ) ) {

            if ( in_array ( $extension , array ( 'bat' , 'cmd' , 'vbs' , 'ps1' ) ) ) {
                return true;
            }
        }
    }

    if ( extension_loaded ( 'com_dotnet' ) ) {
        try {
            $wmi          = new COM( 'WinMgmts:' );
            $wmiPath      = str_replace ( '\\' , '\\\\' , $filePath );
            $query        = "SELECT * FROM Win32_LogicalFileSecuritySetting WHERE Path='{$wmiPath}'";
            $fileSettings = $wmi->ExecQuery ( $query );

            foreach ( $fileSettings as $setting ) {
                $securityDescriptor = $setting->GetSecurityDescriptor ();
                if ( $securityDescriptor->Dacl ) {
                    foreach ( $securityDescriptor->Dacl as $ace ) {

                        if ( $ace->AccessMask & 0x20 ) {
                            return true;
                        }
                    }
                }
            }
        } catch ( Exception $e ) {
            return false;
        }
    }

    return false;
}

function is_file_executable_unix ( $filePath )
{

    if ( is_executable ( $filePath ) ) {
        return true;
    }

    $perms = fileperms ( $filePath );

    if ( $perms & 0x0040 || $perms & 0x0008 || $perms & 0x0001 ) {

        if ( function_exists ( 'posix_geteuid' ) && function_exists ( 'posix_getegid' ) ) {

            $currentUid = posix_geteuid ();
            $currentGid = posix_getegid ();
            $fileOwner  = fileowner ( $filePath );
            $fileGroup  = filegroup ( $filePath );

            if ( $currentUid == $fileOwner && ( $perms & 0x0040 ) ) {
                return true;
            }


            if ( $currentGid == $fileGroup && ( $perms & 0x0008 ) ) {
                return true;
            }

            if ( $perms & 0x0001 ) {
                return true;
            }

        } else {

            return true;
        }
    }


    if ( function_exists ( 'posix_access' ) ) {
        return posix_access ( $filePath , POSIX_X_OK );
    }


    $output = shell_exec ( "test -x " . escapeshellarg ( $filePath ) . " && echo 'executable' || echo 'not executable' 2>/dev/null" );
    if ( strpos ( $output , 'executable' ) !== false ) {
        return true;
    }

    return false;
}

function check_file_executable ( $filePath )
{

    if ( ! file_exists ( $filePath ) ) {
        return false;
    }

    $filePath = realpath ( $filePath );

    if ( strtoupper ( substr ( PHP_OS , 0 , 3 ) ) === 'WIN' ) {
        return is_file_executable_windows ( $filePath );
    }

    return is_file_executable_unix ( $filePath );
}

function check_privilege_environment ()
{
    check_key_constant_define ();
    if ( empty( DEVLOP ) ) {
        if ( PRIVILEGE_USER_MODULE_USER == "38305ac7e5f1b870f6e92aef5e281b2d" ) {
            throw new \Exception( "Due to security reasons, the default initialization username of the framework cannot be used in non development mode!" , 0 );
        }
        if ( PRIVILEGE_USER_MODULE_PASSWORD == "6f02faa1775d964e58b227e0ef3fa7fd" ) {
            throw new \Exception( "Due to security reasons, the default initialization password of the framework cannot be used in non development mode!" , 0 );
        }
        if ( ( PRIVILEGE_USER_MODULE_USER == "38305ac7e5f1b870f6e92aef5e281b2d" ) && ( PRIVILEGE_USER_MODULE_PASSWORD == "6f02faa1775d964e58b227e0ef3fa7fd" ) && ( ! is_cli () ) && ( filter_var ( $_SERVER[ "SERVER_ADDR" ] , FILTER_FLAG_NO_PRIV_RANGE ) ) ) {
            throw new \Exception( "You cannot use a privileged account and password dedicated to development mode to run Phpsploit Framework software under a public IP, as this poses a significant security risk! If you need to run the Phpsploit Framework software in a public IP environment, the correct approach is to use a privileged account and password dedicated to production mode to run the Phpsploit Framework software!" , 0 );
        }
    }
    if ( ( PRIVILEGE_USER_MODULE_USER == "1cbaaf7f640765ae8f4e0766ea5236ca" ) && ( PRIVILEGE_USER_MODULE_PASSWORD == "259eb52b05e6e2bafb1541afe061ba75" ) && ( ! is_cli () ) && ( filter_var ( $_SERVER[ "SERVER_ADDR" ] , FILTER_FLAG_NO_PRIV_RANGE ) ) ) {
        throw new \Exception( "You cannot use a privileged account and password dedicated to testing mode to run Phpsploit Framework software under a public IP, as this poses a significant security risk! If you need to run the Phpsploit Framework software in a public IP environment, the correct approach is to use a privileged account and password dedicated to production mode to run the Phpsploit Framework software!" , 0 );
    }
}

/*
develop privilege init user :     0day
develop privilege init password : 0day_phpsploit-framework_2023v1.0

develop privilege init user md5 :     38305ac7e5f1b870f6e92aef5e281b2d
develop privilege init password md5 : 6f02faa1775d964e58b227e0ef3fa7fd

test privilege init user :     huc0day
test privilege init password : 6PbmX),_+dyc@OIt3C

test privilege init user md5 :     1cbaaf7f640765ae8f4e0766ea5236ca
test privilege init password md5 : 259eb52b05e6e2bafb1541afe061ba75
*/

define ( "PRIVILEGE_USER_MODULE_USER" , "1cbaaf7f640765ae8f4e0766ea5236ca" );
define ( "PRIVILEGE_USER_MODULE_PASSWORD" , "259eb52b05e6e2bafb1541afe061ba75" );

define ( 'DEBUG' , ( ( empty( $_REQUEST ) ) ? 0 : ( ( ! is_array ( $_REQUEST ) ) ? 0 : ( ( empty( $_REQUEST[ "debug" ] ) ) ? 0 : ( ( intval ( $_REQUEST[ "debug" ] ) == 0 ) ? 0 : ( 1 ) ) ) ) ) );
define ( "DEVLOP" , ( ( is_development_environment () ? 1 : 0 ) ) );

define ( "DEVELOP_DEFAULT_FRAMEWORK_FOLDER" , dirname ( __FILE__ ) );
define ( "PRODUCTION_DEFAULT_FRAMEWORK_FOLDER" , dirname ( __FILE__ ) );
define ( "DEFAULT_FRAMEWORK_FOLDER" , ( ( ! empty( DEVLOP ) ) ? ( DEVELOP_DEFAULT_FRAMEWORK_FOLDER ) : ( PRODUCTION_DEFAULT_FRAMEWORK_FOLDER ) ) );
define ( "THIRD_PARTY_CLASS_LIBRARIES" , dirname ( __FILE__ ) );


define ( "WIRESHARK_DOCKER_IPV4" , "((ip.src_host==172.17.0.1 and ip.dst_host==172.17.0.2) or (ip.src_host==172.17.0.2 and ip.dst_host==172.17.0.1)) or (ip.addr==127.0.0.1) and (tcp.srcport==40668 or tcp.dstport==40668) and (http)" );
define ( "WIRESHARK_DOCKER_IPV6" , "ip.version==6 and (not icmpv6 ) and (not tcp) and (not udp)" );

define ( "OPENSSL_RAW_DATA_OR_OPENSSL_ZERO_PADDING" , ( OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING ) );
define ( "SIZE_UNSIGNED_CHAR_16" , 16 );

try {
    check_privilege_environment ();
} catch ( \Exception $e ) {
    print_r ( $e->getMessage () );
    exit( 0 );
}

if ( ( ! isset( $_SERVER ) ) || ( ! is_array ( $_SERVER ) ) ) {
    $_SERVER = array ();
}
if ( ( ! isset( $_ENV ) ) || ( ! is_array ( $_ENV ) ) ) {
    $_ENV = array ();
}
if ( ( ! isset( $_SESSION ) ) || ( ! is_array ( $_SESSION ) ) ) {
    $_SESSION = array ();
}
if ( ( ! isset( $_COOKIE ) ) || ( ! is_array ( $_COOKIE ) ) ) {
    $_COOKIE = array ();
}
if ( ( ! isset( $_REQUEST ) ) || ( ! is_array ( $_REQUEST ) ) ) {
    $_REQUEST = array ();
}
if ( ( ! isset( $_GET ) ) || ( ! is_array ( $_GET ) ) ) {
    $_GET = array ();
}
if ( ( ! isset( $_POST ) ) || ( ! is_array ( $_POST ) ) ) {
    $_POST = array ();
}
if ( ( ! isset( $_FILES ) ) || ( ! is_array ( $_FILES ) ) ) {
    $_FILES = array ();
}

if ( DEVLOP ) {

    ini_set ( "display_errors" , 1 );
    ini_set ( "error_reporting" , E_ERROR );
    ini_set ( "error_log" , 'logfile' );
    ini_set ( "log_errors" , 1 );
    ini_set ( "include_path" , "." );

    error_reporting ( E_ALL ^ E_WARNING );

    define ( 'WEB_DIR' , dirname ( __FILE__ ) );
    define ( 'APP_DIR' , dirname ( __FILE__ ) );
    define ( 'CLI_DIR' , dirname ( __FILE__ ) );
    define ( 'CONFIG_DIR' , dirname ( __FILE__ ) );
    define ( 'ROOT_DIR' , $_SERVER[ 'DOCUMENT_ROOT' ] );
    define ( 'INDEX_FILE_URI' , str_replace ( $_SERVER[ "DOCUMENT_ROOT" ] , "" , $_SERVER[ "SCRIPT_FILENAME" ] ) );

} else {

    ini_set ( "display_errors" , 0 );
    ini_set ( "error_reporting" , E_ERROR );
    ini_set ( "error_log" , 'logfile' );
    ini_set ( "log_errors" , 0 );
    ini_set ( "include_path" , "." );

    error_reporting ( E_ALL ^ E_WARNING );

    define ( 'WEB_DIR' , dirname ( __FILE__ ) );
    define ( 'APP_DIR' , dirname ( __FILE__ ) );
    define ( 'CLI_DIR' , dirname ( __FILE__ ) );
    define ( 'CONFIG_DIR' , dirname ( __FILE__ ) );
    define ( 'ROOT_DIR' , $_SERVER[ 'DOCUMENT_ROOT' ] );
    define ( 'INDEX_FILE_URI' , str_replace ( $_SERVER[ "DOCUMENT_ROOT" ] , "" , $_SERVER[ "SCRIPT_FILENAME" ] ) );
}

$GLOBALS[ "ROUTE_MAPS" ] = array (
    "/"                                                           => "Class_Controller_Default::index" ,
    "/init"                                                       => "Class_Controller_Init::index" ,
    "/init_user_info"                                             => "Class_Controller_Init::init_user_info" ,
    "/login"                                                      => "Class_Controller_Login::index" ,
    "/logout"                                                     => "Class_Controller_Logout::index" ,
    "/build"                                                      => "Class_Controller_Build::index" ,
    "/encode_build"                                               => "Class_Controller_Build::encode_build" ,
    "/decode_build"                                               => "Class_Controller_Build::decode_build" ,
    "/user"                                                       => "Class_Controller_User::index" ,
    "/user/user_info"                                             => "Class_Controller_User::user_info" ,
    "/user/create_production_privilege_user_password"             => "Class_Controller_User::create_production_privilege_user_password" ,
    "/server"                                                     => "Class_Controller_Server::index" ,
    "/server/server_info"                                         => "Class_Controller_Server::server_info" ,
    "/session"                                                    => "Class_Controller_Session::index" ,
    "/session/session_info"                                       => "Class_Controller_Session::session_info" ,
    "/cookie"                                                     => "Class_Controller_Cookie::index" ,
    "/cookie/cookie_info"                                         => "Class_Controller_Cookie::cookie_info" ,
    "/index"                                                      => "Class_Controller_Index::index" ,
    "/debug"                                                      => "Class_Controller_Index::debug" ,
    "/guide"                                                      => "Class_Controller_PenetrationTestCommands::index" ,
    "/guide/penetration_test_commands"                            => "Class_Controller_PenetrationTestCommands::index" ,
    "/guide/penetration_test_commands/information_gathering"      => "Class_Controller_PenetrationTestCommands::information_gathering" ,
    "/guide/penetration_test_commands/vulnerability_analysis"     => "Class_Controller_PenetrationTestCommands::vulnerability_analysis" ,
    "/guide/penetration_test_commands/web_program"                => "Class_Controller_PenetrationTestCommands::web_program" ,
    "/guide/penetration_test_commands/database_evaluation"        => "Class_Controller_PenetrationTestCommands::database_evaluation" ,
    "/guide/penetration_test_commands/password_attack"            => "Class_Controller_PenetrationTestCommands::password_attack" ,
    "/guide/penetration_test_commands/wireless_attacks"           => "Class_Controller_PenetrationTestCommands::wireless_attacks" ,
    "/guide/penetration_test_commands/reverse_engineering"        => "Class_Controller_PenetrationTestCommands::reverse_engineering" ,
    "/guide/penetration_test_commands/vulnerability_exploitation" => "Class_Controller_PenetrationTestCommands::vulnerability_exploitation" ,
    "/guide/penetration_test_commands/sniff_deception"            => "Class_Controller_PenetrationTestCommands::sniff_deception" ,
    "/guide/penetration_test_commands/permission_maintenance"     => "Class_Controller_PenetrationTestCommands::permission_maintenance" ,
    "/guide/penetration_test_commands/data_forensics"             => "Class_Controller_PenetrationTestCommands::data_forensics" ,
    "/guide/penetration_test_commands/reporting"                  => "Class_Controller_PenetrationTestCommands::reporting" ,
    "/guide/penetration_test_commands/social_engineering"         => "Class_Controller_PenetrationTestCommands::social_engineering" ,
    "/guide/adversarial_exercise"                                 => "Class_Controller_Guide::adversarial_exercise" ,
    "/guide/security_managements_software"                        => "Class_Controller_Guide::security_managements_software" ,
    "/guide/vulnerability_warehouse"                              => "Class_Controller_Guide::vulnerability_warehouse" ,
    "/guide/part_time_projects"                                   => "Class_Controller_Guide::part_time_projects" ,
    "/clear"                                                      => "Class_Controller_Clear::index" ,
    "/memory"                                                     => "Class_Controller_Memory::index" ,
    "/memory/system"                                              => "Class_Controller_Memory::system" ,
    "/memory/list"                                                => "Class_Controller_Memory::show_list" ,
    "/memory/search"                                              => "Class_Controller_Memory::show_search" ,
    "/memory/detail"                                              => "Class_Controller_Memory::show_detail" ,
    "/memory/add"                                                 => "Class_Controller_Memory::add" ,
    "/memory/edit"                                                => "Class_Controller_Memory::edit" ,
    "/memory/delete"                                              => "Class_Controller_Memory::delete" ,
    "/memory/clear"                                               => "Class_Controller_Memory::clear" ,
    "/file"                                                       => "Class_Controller_File::index" ,
    "/file/explorer"                                              => "Class_Controller_File::show_explorer" ,
    "/file/search"                                                => "Class_Controller_File::show_search" ,
    "/file/detail"                                                => "Class_Controller_File::show_detail" ,
    "/file/create"                                                => "Class_Controller_File::show_create" ,
    "/file/upload"                                                => "Class_Controller_File::show_upload" ,
    "/file/edit"                                                  => "Class_Controller_File::show_edit" ,
    "/file/delete"                                                => "Class_Controller_File::show_delete" ,
    "/file/clear"                                                 => "Class_Controller_File::show_clear" ,
    "/database"                                                   => "Class_Controller_Database::index" ,
    "/database/query"                                             => "Class_Controller_Database::query" ,
    "/database/exec"                                              => "Class_Controller_Database::exec" ,
    "/security"                                                   => "Class_Controller_Security::index" ,
    "/security/url"                                               => "Class_Controller_Security::url" ,
    "/security/base64"                                            => "Class_Controller_Security::base64" ,
    "/security/sha1"                                              => "Class_Controller_Security::sha1" ,
    "/security/md5"                                               => "Class_Controller_Security::md5" ,
    "/security/crc32"                                             => "Class_Controller_Security::crc32" ,
    "/security/crypt"                                             => "Class_Controller_Security::crypt" ,
    "/security/hash_hmac"                                         => "Class_Controller_Security::hash_hmac" ,
    "/security/openssl"                                           => "Class_Controller_Security::openssl" ,
    "/security/hash"                                              => "Class_Controller_Security::hash" ,
    "/security/password_hash"                                     => "Class_Controller_Security::password_hash" ,
    "/security/sodium"                                            => "Class_Controller_Security::sodium" ,
    "/scan"                                                       => "Class_Controller_Scan::index" ,
    "/scan/webs"                                                  => "Class_Controller_Scan::webs" ,
    "/scan/domain"                                                => "Class_Controller_Scan::domain" ,
    "/scan/tamperproof"                                           => "Class_Controller_Scan::tamperproof" ,
    "/elf"                                                        => "Class_Controller_Elf::index" ,
    "/elf/elf64"                                                  => "Class_Controller_Elf::elf64" ,
    "/elf/elf_h"                                                  => "Class_Controller_Elf::elf_h" ,
    "/shell"                                                      => "Class_Controller_Shell::index" ,
    "/shell/web_shell"                                            => "Class_Controller_Shell::web_shell" ,
    "/shell/server_shell"                                         => "Class_Controller_Shell::server_shell" ,
    "/shell/server_shell_client"                                  => "Class_Controller_Shell::server_shell_client" ,
    "/shell/reverse_shell"                                        => "Class_Controller_Shell::reverse_shell" ,
    "/shell/background_shell"                                     => "Class_Controller_Shell::background_shell" ,
    "/shell/proxy_shell"                                          => "Class_Controller_ProxyShell::index" ,
    "/shell/proxy_shell/create_session_id"                        => "Class_Controller_ProxyShell::create_session_id" ,
    "/shell/proxy_shell/clear_session_id"                         => "Class_Controller_ProxyShell::clear_session_id" ,
    "/shell/proxy_shell/send"                                     => "Class_Controller_ProxyShell::send" ,
    "/shell/proxy_shell/receive"                                  => "Class_Controller_ProxyShell::receive" ,
    "/shell/proxy_shell/listen"                                   => "Class_Controller_ProxyShell::listen" ,
    "/chat"                                                       => "Class_Controller_Chat::index" ,
    "/chat/server_chat"                                           => "Class_Controller_Chat::server_chat" ,
    "/chat/reverse_chat"                                          => "Class_Controller_Chat::reverse_chat" ,
    "/router"                                                     => "Class_Controller_Router::index" ,
    "/wget"                                                       => "Class_Controller_Wget::index" ,
    "/report"                                                     => "Class_Controller_Report::index" ,
    "/report/create_vulnerability_report"                         => "Class_Controller_Report::create_vulnerability_report" ,
    "/report/edit_vulnerability_report"                           => "Class_Controller_Report::edit_vulnerability_report" ,
    "/report/delete_vulnerability_report"                         => "Class_Controller_Report::delete_vulnerability_report" ,
    "/report/show_vulnerability_report"                           => "Class_Controller_Report::show_vulnerability_report" ,
    "/report/export_vulnerability_report"                         => "Class_Controller_Report::export_vulnerability_report" ,
    "/report/clear_vulnerability_report"                          => "Class_Controller_Report::clear_vulnerability_report" ,
    "/test"                                                       => "Class_Controller_Test::index" ,
    "/cli/create_token"                                           => "Class_Controller_Cli::create_token" ,
    "/cli/clear_token"                                            => "Class_Controller_Cli::clear_token" ,
);

function env_init ()
{
    if ( is_cli () ) {
        global $_SERVER;
        global $_ENV;
        global $_SESSION;
        global $_COOKIE;
        global $_REQUEST;
        global $_GET;
        global $_POST;
        global $_FILES;
    }
    if ( ( ! isset( $_SERVER[ "DOCUMENT_ROOT" ] ) ) || ( ! is_string ( $_SERVER[ "DOCUMENT_ROOT" ] ) ) ) {
        $_SERVER[ "DOCUMENT_ROOT" ] = dirname ( __FILE__ );
    }
    if ( ( ! isset( $_SERVER[ "SCRIPT_FILENAME" ] ) ) || ( ! is_string ( $_SERVER[ "SCRIPT_FILENAME" ] ) ) ) {
        $_SERVER[ "SCRIPT_FILENAME" ] = __FILE__;
    }

    if ( ! isset( $_SERVER[ "HTTP_X_FORWARDED_FOR" ] ) ) {
        $_SERVER[ "HTTP_X_FORWARDED_FOR" ] = "";
    }
    if ( empty( $_REQUEST[ "url" ] ) ) {
        $_REQUEST[ "url" ] = "/";
    }
    if ( is_cli () ) {
        cli_parameter_to_request ();
    }
    $_SERVER[ "REQUEST_URI" ] = str_replace ( "\\" , "/" , $_REQUEST[ "url" ] );
    if ( array_key_exists ( "url" , $_REQUEST ) ) {
        unset( $_REQUEST[ "url" ] );
    }
    if ( array_key_exists ( "url" , $_GET ) ) {
        unset( $_GET[ "url" ] );
    }
    if ( array_key_exists ( "url" , $_POST ) ) {
        unset( $_POST[ "url" ] );
    }
}

function cli_parameter_to_request ()
{
    if ( is_cli () ) {
        global $_SERVER;
        global $_REQUEST;
    }
    if ( ( ! empty( $_SERVER[ 'argv' ] ) ) && ( is_array ( $_SERVER[ 'argv' ] ) ) && ( count ( $_SERVER[ 'argv' ] ) > 1 ) ) {
        $_cli_params_string      = urldecode ( $_SERVER[ 'argv' ][ 1 ] );
        $_cli_param_string_group = explode ( "?" , $_cli_params_string );
        $_cli_uri                = $_cli_param_string_group[ 0 ];
        $_params_string_group    = array ();
        if ( count ( $_cli_param_string_group ) > 1 ) {
            $_params_string_group = explode ( "&" , $_cli_param_string_group[ 1 ] );
        }
        foreach ( $_params_string_group as $index => $param_string ) {
            if ( strpos ( $param_string , "=" ) === false ) {
                throw new Exception( "cli params format is error" , 0 );
            }
            $item                   = explode ( "=" , $param_string );
            $_REQUEST[ $item[ 0 ] ] = urldecode ( $item[ 1 ] );
        }
        $_REQUEST[ "url" ] = $_cli_uri;
    } else {
        if ( ( ! isset( $_REQUEST ) ) || ( ! is_array ( $_REQUEST ) ) ) {
            $_REQUEST = array ();
        }
        if ( empty( $_REQUEST[ "url" ] ) ) {
            $_REQUEST[ "url" ] = "/";
        }
    }
}

function load_class ( $class )
{
    if ( ! class_exists ( $class ) ) {
        $filename = $class . ".php";
        if ( ( ! file_exists ( $filename ) ) && ( ! file_exists ( DEFAULT_FRAMEWORK_FOLDER . DIRECTORY_SEPARATOR . $filename ) ) && ( ! file_exists ( THIRD_PARTY_CLASS_LIBRARIES . DIRECTORY_SEPARATOR . $filename ) ) ) {
            throw new Exception( "class file " . $filename . " not found" , 9000000001 );
        } else {
            if ( file_exists ( $filename ) ) {
                include_once ( $filename );
            } else if ( file_exists ( DEFAULT_FRAMEWORK_FOLDER . DIRECTORY_SEPARATOR . $filename ) ) {
                include_once ( DEFAULT_FRAMEWORK_FOLDER . DIRECTORY_SEPARATOR . $filename );
            } else if ( file_exists ( THIRD_PARTY_CLASS_LIBRARIES . DIRECTORY_SEPARATOR . $filename ) ) {
                include_once ( THIRD_PARTY_CLASS_LIBRARIES . DIRECTORY_SEPARATOR . $filename );
            }
        }
    }
}

function load_interface ( $interface )
{
    if ( ! interface_exists ( $interface ) ) {
        $filename = $interface . ".php";

        if ( ( ! file_exists ( $filename ) ) && ( ! file_exists ( DEFAULT_FRAMEWORK_FOLDER . DIRECTORY_SEPARATOR . $filename ) ) && ( ! file_exists ( THIRD_PARTY_CLASS_LIBRARIES . DIRECTORY_SEPARATOR . $filename ) ) ) {
            throw new Exception( "interface file " . $filename . " not found" , 0 );
        } else {
            if ( file_exists ( $filename ) ) {
                include_once ( $filename );
            } else if ( file_exists ( DEFAULT_FRAMEWORK_FOLDER . DIRECTORY_SEPARATOR . $filename ) ) {
                include_once ( DEFAULT_FRAMEWORK_FOLDER . DIRECTORY_SEPARATOR . $filename );
            } else if ( file_exists ( THIRD_PARTY_CLASS_LIBRARIES . DIRECTORY_SEPARATOR . $filename ) ) {
                include_once ( THIRD_PARTY_CLASS_LIBRARIES . DIRECTORY_SEPARATOR . $filename );
            }
        }
    }
}

function exception_handler ( $exception )
{
    if ( is_cli () ) {
        global $_SERVER;
        global $_REQUEST;
    }
    if ( ! empty( DEVLOP ) ) {
        if ( is_cli () ) {
            Class_Base_Response::output ( $exception , "object" , 0 );
        } else {
            Class_Base_Response::output ( ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( $exception , true ) ) , "text" , 1 );
        }
    } else {
        if ( ! empty( DEBUG ) ) {
            if ( is_cli () ) {
                Class_Base_Response::output ( $exception , "object" , 0 );
            } else {
                Class_Base_Response::output ( ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( $exception , true ) ) , "text" , 1 );
            }
        } else {
            if ( is_cli () ) {
                Class_Base_Response::output ( array ( "code" => $exception->getCode () , "message" => $exception->getMessage () ) , "object" , 0 );
            } else {
                Class_Base_Response::output ( ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( array ( "code" => $exception->getCode () , "message" => $exception->getMessage () ) , true ) ) , "text" , 1 );
            }
        }
    }

    exit( 1 );
}

function error_handler ( $code , $message , $file , $line )
{
    if ( is_cli () ) {
        global $_SERVER;
        global $_REQUEST;
    }
    if ( ! empty( DEVLOP ) ) {
        if ( is_cli () ) {
            Class_Base_Response::output ( ( new \Exception( "code : " . $code . " , file : " . $file . " , line : " . $line . " : " . $message , $code ) ) , "object" , 0 );
        } else {
            Class_Base_Response::output ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( new \Exception( "code : " . $code . " , file : " . $file . " , line : " . $line . " : " . $message , $code ) , true ) , "text" , 1 );
        }
    } else {
        if ( ! empty( DEBUG ) ) {
            if ( is_cli () ) {
                Class_Base_Response::output ( ( new \Exception( "code : " . $code . " , file : " . $file . " , line : " . $line . " : " . $message , $code ) ) , "object" , 0 );
            } else {
                Class_Base_Response::output ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( new \Exception( "code : " . $code . " , file : " . $file . " , line : " . $line . " : " . $message , $code ) , true ) , "text" , 1 );
            }
        } else {
            if ( is_cli () ) {
                Class_Base_Response::output ( ( new \Exception( $message , $code ) ) , "object" , 0 );
            } else {
                Class_Base_Response::output ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( new \Exception( $message , $code ) , true ) , "text" , 1 );
            }
        }
    }
    exit( 1 );
}

function shutdown_function ()
{

}


spl_autoload_register ( "load_class" );
set_exception_handler ( "exception_handler" );
set_error_handler ( "error_handler" , E_ERROR );
register_shutdown_function ( "shutdown_function" );

function main ()
{
    if ( is_cli () ) {
        global $_SERVER;
        global $_REQUEST;
    }
    try {
        env_init ();
        Class_Main::route_execute ();

    } catch ( Exception $e ) {
        if ( ! empty( DEVLOP ) ) {
            if ( is_cli () ) {
                Class_Base_Response::output ( $e , "object" , 0 );
            } else {
                Class_Base_Response::output ( print_r ( $e , true ) , "text" );
            }
        } else {
            if ( ! empty( $_REQUEST[ "debug" ] ) ) {
                if ( is_cli () ) {
                    Class_Base_Response::output ( $e , "object" , 0 );
                } else {
                    Class_Base_Response::output ( print_r ( $e , true ) , "text" );
                }
            } else {
                if ( is_cli () ) {
                    Class_Base_Response::output ( $e , "object" , 0 );
                } else {
                    Class_Base_Response::output ( print_r ( $e , true ) , "text" );
                }
            }
        }
    }
}

function index ()
{
    main ();
}

index ();


