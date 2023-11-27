<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-24
 * Time: 上午11:34
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

class Class_Operate_User extends Class_Operate implements Interface_Operate_User
{
    public static function exist_token ()
    {
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key   = Class_Base_Auth::SHM_KEY;
            $_shmid = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( ! empty( $_shmid ) ) {
                $_share_memory_md5_token = Class_Base_Memory::read_share_memory ( $_shmid , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! empty( $_share_memory_md5_token ) ) {
                    $_share_memory_md5_token = Class_Base_Format::data_to_string ( $_share_memory_md5_token );
                    if ( ! empty( $_share_memory_md5_token ) ) {
                        return true;
                    }
                }
            }
        } else {
            return true;
        }

        return false;
    }

    public static function reset_token ( $password = null )
    {
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key           = Class_Base_Auth::SHM_KEY;
            $_security_code = Class_Base_Auth::SECURITY_CODE;
            $_shmid         = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
            if ( ! empty( $_shmid ) ) {
                $_password               = Class_Base_Auth::create_password ();
                $_md5_token              = md5 ( $_password . $_security_code );
                $_share_memory_md5_token = md5 ( $_md5_token . $_security_code );
                $_write_length           = Class_Base_Memory::write_share_memory ( $_shmid , $_share_memory_md5_token , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( empty( $_write_length ) ) {
                    Class_Base_Memory::delete_share_memory_by_key ( $_key , Class_Base_Memory::BLOCK_SIZE_32 );
                    throw new \Exception( "auth password reset is fail" , 0 );
                }
                return $_md5_token;
            }
        } else if ( ( is_string ( $password ) ) && ( strlen ( $password ) > 0 ) ) {
            $_md5_token = md5 ( $password . Class_Base_Auth::SECURITY_CODE );
            return $_md5_token;
        }
        return null;
    }

    public static function create_token ( $password = null )
    {
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key           = Class_Base_Auth::SHM_KEY;
            $_security_code = Class_Base_Auth::SECURITY_CODE;
            $_shmid         = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( empty( $_shmid ) ) {
                $_shmid = Class_Base_Memory::create_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 );
                if ( ! empty( $_shmid ) ) {
                    $_password               = Class_Base_Auth::create_password ();
                    $_md5_token              = md5 ( $_password . $_security_code );
                    $_share_memory_md5_token = md5 ( $_md5_token . $_security_code );
                    $_write_length           = Class_Base_Memory::write_share_memory ( $_shmid , $_share_memory_md5_token , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( empty( $_write_length ) ) {
                        Class_Base_Memory::delete_share_memory_by_key ( $_key , Class_Base_Memory::BLOCK_SIZE_32 );
                        throw new \Exception( "auth password init is fail" , 0 );
                    }
                    return $_md5_token;
                }
            }
        } else if ( ( is_string ( $password ) ) && ( strlen ( $password ) > 0 ) ) {
            $_md5_token = md5 ( $password . Class_Base_Auth::SECURITY_CODE );
            return $_md5_token;
        }
        return null;
    }

    public static function check_md5_token ( $md5_token )
    {
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key   = Class_Base_Auth::SHM_KEY;
            $_shmid = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( ! empty( $_shmid ) ) {
                $_share_memory_md5_token = Class_Base_Memory::read_share_memory ( $_shmid , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! empty( $_share_memory_md5_token ) ) {
                    $_share_memory_md5_token = Class_Base_Format::data_to_string ( $_share_memory_md5_token );
                    if ( ! empty( $_share_memory_md5_token ) ) {
                        if ( ( md5 ( $md5_token . Class_Base_Auth::SECURITY_CODE ) ) == $_share_memory_md5_token ) {
                            return true;
                        }
                    }
                }
            }
        } else {
            if ( ( md5 ( $md5_token . Class_Base_Auth::SECURITY_CODE ) ) == PRIVILEGE_USER_MODULE_PASSWORD ) {
                return true;
            }
        }
        return false;
    }

    public static function create_password ( $password = null )
    {
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key           = Class_Base_Auth::SHM_KEY;
            $_security_code = Class_Base_Auth::SECURITY_CODE;
            $_shmid         = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( empty( $_shmid ) ) {
                $_shmid = Class_Base_Memory::create_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 );
                if ( ! empty( $_shmid ) ) {
                    $_password               = Class_Base_Auth::create_password ();
                    $_md5_token              = md5 ( $_password . $_security_code );
                    $_share_memory_md5_token = md5 ( $_md5_token . $_security_code );
                    $_write_length           = Class_Base_Memory::write_share_memory ( $_shmid , $_share_memory_md5_token , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                    if ( empty( $_write_length ) ) {
                        Class_Base_Memory::delete_share_memory_by_key ( $_key , Class_Base_Memory::BLOCK_SIZE_32 );
                        throw new \Exception( "auth password init is fail" , 0 );
                    }
                    return $_password;
                }
            }
        } else if ( ( is_string ( $password ) ) && ( strlen ( $password ) > 0 ) ) {
            return $password;
        }
        return null;
    }

    public static function password_to_md5_token ( $password )
    {
        if ( ! is_string ( $password ) ) {
            return null;
        }
        $_md5_token = md5 ( $password . Class_Base_Auth::SECURITY_CODE );
        return $_md5_token;
    }

    public static function reset_password ( $password = null )
    {
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key           = Class_Base_Auth::SHM_KEY;
            $_security_code = Class_Base_Auth::SECURITY_CODE;
            $_shmid         = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::FLAGS_SHARE_MEMORY_OPEN );
            if ( ! empty( $_shmid ) ) {
                $_token                  = Class_Base_Auth::create_password ();
                $_md5_token              = md5 ( $_token . $_security_code );
                $_share_memory_md5_token = md5 ( $_md5_token . $_security_code );
                $_write_length           = Class_Base_Memory::write_share_memory ( $_shmid , $_share_memory_md5_token , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( empty( $_write_length ) ) {
                    Class_Base_Memory::delete_share_memory_by_key ( $_key , Class_Base_Memory::BLOCK_SIZE_32 );
                    throw new \Exception( "auth password reset is fail" , 0 );
                }
                return $_token;
            }
        } else if ( ( is_string ( $password ) ) && ( strlen ( $password ) > 0 ) ) {
            return $password;
        }
        return null;
    }

    public static function check_privilege_user_and_password_for_clear ( $privilege_user , $privilege_password )
    {
        if ( ( ! is_string ( $privilege_user ) ) || ( strlen ( $privilege_user ) <= 0 ) ) {
            return false;
        }
        if ( ( ! is_string ( $privilege_password ) ) || ( strlen ( $privilege_password ) <= 0 ) ) {
            return false;
        }
        if ( md5 ( ( md5 ( ( $privilege_user . Class_Base_Auth::SECURITY_CODE ) ) . Class_Base_Auth::SECURITY_CODE ) ) == PRIVILEGE_USER_MODULE_USER ) {
            if ( md5 ( ( md5 ( ( $privilege_password . Class_Base_Auth::SECURITY_CODE ) ) . Class_Base_Auth::SECURITY_CODE ) ) == PRIVILEGE_USER_MODULE_PASSWORD ) {
                return true;
            }
        }
        return false;
    }

    public static function check_privilege_user_and_password ( $privilege_user , $privilege_password , &$user = null , &$password = null , &$md5_token = null )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ( ! is_string ( $privilege_user ) ) || ( strlen ( $privilege_user ) <= 0 ) ) {
            return false;
        }
        if ( ( ! is_string ( $privilege_password ) ) || ( strlen ( $privilege_password ) <= 0 ) ) {
            return false;
        }
        if ( md5 ( ( md5 ( ( $privilege_user . Class_Base_Auth::SECURITY_CODE ) ) . Class_Base_Auth::SECURITY_CODE ) ) == PRIVILEGE_USER_MODULE_USER ) {
            if ( md5 ( ( md5 ( ( $privilege_password . Class_Base_Auth::SECURITY_CODE ) ) . Class_Base_Auth::SECURITY_CODE ) ) == PRIVILEGE_USER_MODULE_PASSWORD ) {
                if ( ( ! isset( $_SESSION ) ) || ( ! is_array ( $_SESSION ) ) ) {
                    $_SESSION = array ();
                }
                if ( ! Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ]      = $user = $privilege_user;
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ]  = $password = $privilege_password;
                    $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] = $md5_token = md5 ( ( $privilege_password . Class_Base_Auth::SECURITY_CODE ) );
                    return true;
                } else {
                    if ( ! self::exist_token () ) {
                        $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ]      = $user = $privilege_user;
                        $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ]  = $password = self::create_password ( $privilege_password );
                        $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] = $md5_token = md5 ( ( $password . Class_Base_Auth::SECURITY_CODE ) );
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public static function check_user_and_password ( $user , $password , &$md5_token = null )
    {
        if ( is_cli () ) {
            global $_SESSION;
            if ( ! is_array ( $_SESSION ) ) {
                $_SESSION = array ();
            }
        }
        if ( ! is_string ( $user ) ) {
            return false;
        }
        if ( ! is_string ( $password ) ) {
            return false;
        }
        if ( Class_Base_Extension::exist_enabled_extensions ( Class_Base_Extension::EXTENSION_NAME_SHMOP ) ) {
            $_key   = Class_Base_Auth::SHM_KEY;
            $_shmid = Class_Base_Memory::open_share_memory ( $_key , Class_Base_Memory::MODE_SHARE_MEMORY_READ_AND_WRITE , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::FLAGS_SHARE_MEMORY_READ_AND_WRITE );
            if ( ! empty( $_shmid ) ) {
                $_share_memory_md5_token = Class_Base_Memory::read_share_memory ( $_shmid , Class_Base_Memory::SHARE_MEMORY_OFFSET_START , Class_Base_Memory::BLOCK_SIZE_32 , Class_Base_Memory::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
                if ( ! empty( $_share_memory_md5_token ) ) {
                    $_share_memory_md5_token = Class_Base_Format::data_to_string ( $_share_memory_md5_token );
                    if ( ! empty( $_share_memory_md5_token ) ) {
                        if ( md5 ( ( md5 ( ( $password . Class_Base_Auth::SECURITY_CODE ) ) . Class_Base_Auth::SECURITY_CODE ) ) == $_share_memory_md5_token ) {
                            if ( ( ! isset( $_SESSION ) ) || ( ! is_array ( $_SESSION ) ) ) {
                                $_SESSION = array ();
                            }
                            $_SESSION[ "PHPSPLOIT_FRAMEWORK_USER" ]      = $user;
                            $_SESSION[ "PHPSPLOIT_FRAMEWORK_PASSWORD" ]  = $password;
                            $_SESSION[ "PHPSPLOIT_FRAMEWORK_MD5_TOKEN" ] = $md5_token = md5 ( ( $password . Class_Base_Auth::SECURITY_CODE ) );
                            return true;
                        }
                    }
                }
            }
        } else {
            return self::check_privilege_user_and_password ( $user , $password );
        }
        return false;
    }

    public static function create_privilege_encode_user ( $user )
    {
        if ( ( ! is_string ( $user ) ) || ( strlen ( $user ) <= 0 ) ) {
            return null;
        }
        $_encode_user = md5 ( md5 ( $user . Class_Base_Auth::SECURITY_CODE ) . Class_Base_Auth::SECURITY_CODE );
        return $_encode_user;
    }

    public static function create_privilege_encode_password ( $password )
    {
        if ( ( ! is_string ( $password ) ) || ( strlen ( $password ) <= 0 ) ) {
            return null;
        }
        $_encode_password = md5 ( md5 ( $password . Class_Base_Auth::SECURITY_CODE ) . Class_Base_Auth::SECURITY_CODE );
        return $_encode_password;
    }

    public static function create_security_code ()
    {
        $_security_code = Class_Base_Request::create_security_code ();
        return $_security_code;
    }
}