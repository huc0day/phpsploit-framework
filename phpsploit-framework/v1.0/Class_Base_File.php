<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-1-24
 * Time: 上午11:36
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

class Class_Base_File extends Class_Base implements Interface_Base_File
{
    const SIZE_FILE_CONTENT_LIMIT   = 1048576;
    const TYPE_FILE_TEXT            = "text";
    const TYPE_FILE_APPLICATION     = "application";
    const TYPE_FILE_IMAGE           = "image";
    const TYPE_FILE_AUDIO           = "audio";
    const TYPE_FILE_VIDEO           = "video";
    const TYPE_DATA_TEXT            = 10000001;
    const TYPE_DATA_BIN             = 10000002;
    const TYPE_NAME_PE              = "PE";
    const TYPE_NAME_ELF             = "ELF";
    const TYPE_NAME_JPG             = "JPG";
    const TYPE_NAME_PNG             = "PNG";
    const TYPE_NAME_GIF             = "GIF";
    const TYPE_NAME_TIF             = "TIF";
    const TYPE_NAME_BMP             = "BMP";
    const TYPE_NAME_DWG             = "DWG";
    const TYPE_NAME_PSD             = "PSD";
    const TYPE_NAME_RTF             = "RTF";
    const TYPE_NAME_XML             = "XML";
    const TYPE_NAME_HTML            = "HTML";
    const TYPE_NAME_EML             = "EML";
    const TYPE_NAME_DBX             = "DBX";
    const TYPE_NAME_PST             = "PST";
    const TYPE_NAME_XLS_DOC         = "XLS_DOC";
    const TYPE_NAME_MDB             = "MDB";
    const TYPE_NAME_WPD             = "WPD";
    const TYPE_NAME_EPS_PS          = "EPS_PS";
    const TYPE_NAME_PDF             = "PDF";
    const TYPE_NAME_PWL             = "PWL";
    const TYPE_NAME_ZIP             = "ZIP";
    const TYPE_NAME_RAR             = "RAR";
    const TYPE_NAME_WAV             = "WAV";
    const TYPE_NAME_AVI             = "AVI";
    const TYPE_NAME_RAM             = "RAM";
    const TYPE_NAME_RM              = "RM";
    const TYPE_NAME_MPG_VIDEO_AUDIO = "MPG_VIDEO_AUDIO";
    const TYPE_NAME_MPG_VIDEO       = "MPG_VIDEO";
    const TYPE_NAME_MOV             = "MOV";
    const TYPE_NAME_ASF             = "ASF";
    const TYPE_NAME_MID             = "MID";

    const TYPE_NAME_RPM   = "RPM";
    const TYPE_NAME_BIN_  = "BIN";
    const TYPE_NAME_BZ2   = "BZ2";
    const TYPE_NAME_CLASS = "CLASS";
    const TYPE_NAME_ISO   = "ISO";
    const TYPE_NAME_DMG   = "DMG";
    const TYPE_NAME_MP4   = "MP4";

    const TYPE_HEX_PE              = "4D5A";
    const TYPE_HEX_ELF             = "7F454C46";
    const TYPE_HEX_JPG             = "FFD8FFE1";
    const TYPE_HEX_PNG             = "89504E47";
    const TYPE_HEX_GIF             = "47494638";
    const TYPE_HEX_TIF             = "49492A00";
    const TYPE_HEX_BMP             = "424D";
    const TYPE_HEX_DWG             = "41433130";
    const TYPE_HEX_PSD             = "38425053";
    const TYPE_HEX_RTF             = "7B5C727466";
    const TYPE_HEX_XML             = "3C3F786D6C";
    const TYPE_HEX_HTML            = "68746D6C3E";
    const TYPE_HEX_EML             = "44656C69766572792D646174";
    const TYPE_HEX_DBX             = "CFAD12FEC5FD746F";
    const TYPE_HEX_PST             = "2142444E";
    const TYPE_HEX_XLS_DOC         = "D0CF11E0";
    const TYPE_HEX_MDB             = "5374616E64617264204A";
    const TYPE_HEX_WPD             = "FF575043";
    const TYPE_HEX_EPS_PS          = "252150532D41646F6265";
    const TYPE_HEX_PDF             = "255044462D312E";
    const TYPE_HEX_PWL             = "E3828596";
    const TYPE_HEX_ZIP             = "504B0304";
    const TYPE_HEX_RAR             = "52617221";
    const TYPE_HEX_WAV             = "57415645";
    const TYPE_HEX_AVI             = "41564920";
    const TYPE_HEX_RAM             = "2E7261FD";
    const TYPE_HEX_RM              = "2E524D46";
    const TYPE_HEX_MPG_VIDEO_AUDIO = "000001BA";
    const TYPE_HEX_MPG_VIDEO       = "000001B3";
    const TYPE_HEX_MOV             = "6D6F6F76";
    const TYPE_HEX_ASF             = "3026B2758E66CF11";
    const TYPE_HEX_MID             = "4D546864";

    const TYPE_HEX_RPM   = "EDABEEDB";
    const TYPE_HEX_BIN_  = "53503031";
    const TYPE_HEX_BZ2   = "425A68";
    const TYPE_HEX_CLASS = "CAFEBABE";
    const TYPE_HEX_ISO   = "4344303031";
    const TYPE_HEX_DMG   = "6B6F6C79";
    const TYPE_HEX_MP4   = "6674797069736F6D";

    private static $_file_head_type_hexs = array (
        self::TYPE_NAME_PE              => self::TYPE_HEX_PE ,
        self::TYPE_NAME_ELF             => self::TYPE_HEX_ELF ,
        self::TYPE_NAME_JPG             => self::TYPE_HEX_JPG ,
        self::TYPE_NAME_PNG             => self::TYPE_HEX_PNG ,
        self::TYPE_NAME_GIF             => self::TYPE_HEX_GIF ,
        self::TYPE_NAME_TIF             => self::TYPE_HEX_TIF ,
        self::TYPE_NAME_BMP             => self::TYPE_HEX_BMP ,
        self::TYPE_NAME_DWG             => self::TYPE_HEX_DWG ,
        self::TYPE_NAME_PSD             => self::TYPE_HEX_PSD ,
        self::TYPE_NAME_RTF             => self::TYPE_HEX_RTF ,
        self::TYPE_NAME_XML             => self::TYPE_HEX_XML ,
        self::TYPE_NAME_HTML            => self::TYPE_HEX_HTML ,
        self::TYPE_NAME_EML             => self::TYPE_HEX_EML ,
        self::TYPE_NAME_DBX             => self::TYPE_HEX_DBX ,
        self::TYPE_NAME_PST             => self::TYPE_HEX_PST ,
        self::TYPE_NAME_XLS_DOC         => self::TYPE_HEX_XLS_DOC ,
        self::TYPE_NAME_MDB             => self::TYPE_HEX_MDB ,
        self::TYPE_NAME_WPD             => self::TYPE_HEX_WPD ,
        self::TYPE_NAME_EPS_PS          => self::TYPE_HEX_EPS_PS ,
        self::TYPE_NAME_PDF             => self::TYPE_HEX_PDF ,
        self::TYPE_NAME_PWL             => self::TYPE_HEX_PWL ,
        self::TYPE_NAME_ZIP             => self::TYPE_HEX_ZIP ,
        self::TYPE_NAME_RAR             => self::TYPE_HEX_RAR ,
        self::TYPE_NAME_WAV             => self::TYPE_HEX_WAV ,
        self::TYPE_NAME_AVI             => self::TYPE_HEX_AVI ,
        self::TYPE_NAME_RAM             => self::TYPE_HEX_RAM ,
        self::TYPE_NAME_RM              => self::TYPE_HEX_RM ,
        self::TYPE_NAME_MPG_VIDEO_AUDIO => self::TYPE_HEX_MPG_VIDEO_AUDIO ,
        self::TYPE_NAME_MPG_VIDEO       => self::TYPE_HEX_MPG_VIDEO ,
        self::TYPE_NAME_MOV             => self::TYPE_HEX_MOV ,
        self::TYPE_NAME_ASF             => self::TYPE_HEX_ASF ,
        self::TYPE_NAME_MID             => self::TYPE_HEX_MID ,
        self::TYPE_NAME_RPM             => self::TYPE_HEX_RPM ,
        self::TYPE_NAME_BIN_            => self::TYPE_HEX_BIN_ ,
        self::TYPE_NAME_BZ2             => self::TYPE_HEX_BZ2 ,
        self::TYPE_NAME_CLASS           => self::TYPE_HEX_CLASS ,
        self::TYPE_NAME_ISO             => self::TYPE_NAME_ISO ,
        self::TYPE_NAME_DMG             => self::TYPE_HEX_DMG ,
        self::TYPE_NAME_MP4             => self::TYPE_HEX_MP4 ,
    );

    private static $_file_head_type_names = array (
        self::TYPE_HEX_PE              => self::TYPE_NAME_PE ,
        self::TYPE_HEX_ELF             => self::TYPE_NAME_ELF ,
        self::TYPE_HEX_JPG             => self::TYPE_NAME_JPG ,
        self::TYPE_HEX_PNG             => self::TYPE_NAME_PNG ,
        self::TYPE_HEX_GIF             => self::TYPE_NAME_GIF ,
        self::TYPE_HEX_TIF             => self::TYPE_NAME_TIF ,
        self::TYPE_HEX_BMP             => self::TYPE_NAME_BMP ,
        self::TYPE_HEX_DWG             => self::TYPE_NAME_DWG ,
        self::TYPE_HEX_PSD             => self::TYPE_NAME_PSD ,
        self::TYPE_HEX_RTF             => self::TYPE_NAME_RTF ,
        self::TYPE_HEX_XML             => self::TYPE_NAME_XML ,
        self::TYPE_HEX_HTML            => self::TYPE_NAME_HTML ,
        self::TYPE_HEX_EML             => self::TYPE_NAME_EML ,
        self::TYPE_HEX_DBX             => self::TYPE_NAME_DBX ,
        self::TYPE_HEX_PST             => self::TYPE_NAME_PST ,
        self::TYPE_HEX_XLS_DOC         => self::TYPE_NAME_XLS_DOC ,
        self::TYPE_HEX_MDB             => self::TYPE_NAME_MDB ,
        self::TYPE_HEX_WPD             => self::TYPE_NAME_WPD ,
        self::TYPE_HEX_EPS_PS          => self::TYPE_NAME_EPS_PS ,
        self::TYPE_HEX_PDF             => self::TYPE_NAME_PDF ,
        self::TYPE_HEX_PWL             => self::TYPE_NAME_PWL ,
        self::TYPE_HEX_ZIP             => self::TYPE_NAME_ZIP ,
        self::TYPE_HEX_RAR             => self::TYPE_NAME_RAR ,
        self::TYPE_HEX_WAV             => self::TYPE_NAME_WAV ,
        self::TYPE_HEX_AVI             => self::TYPE_NAME_AVI ,
        self::TYPE_HEX_RAM             => self::TYPE_NAME_RAM ,
        self::TYPE_HEX_RM              => self::TYPE_NAME_RM ,
        self::TYPE_HEX_MPG_VIDEO_AUDIO => self::TYPE_NAME_MPG_VIDEO_AUDIO ,
        self::TYPE_HEX_MPG_VIDEO       => self::TYPE_NAME_MPG_VIDEO ,
        self::TYPE_HEX_MOV             => self::TYPE_NAME_MOV ,
        self::TYPE_HEX_ASF             => self::TYPE_NAME_ASF ,
        self::TYPE_HEX_MID             => self::TYPE_NAME_MID ,
        self::TYPE_HEX_RPM             => self::TYPE_NAME_RPM ,
        self::TYPE_HEX_BIN_            => self::TYPE_NAME_BIN_ ,
        self::TYPE_HEX_BZ2             => self::TYPE_NAME_BZ2 ,
        self::TYPE_HEX_CLASS           => self::TYPE_NAME_CLASS ,
        self::TYPE_HEX_ISO             => self::TYPE_NAME_ISO ,
        self::TYPE_HEX_DMG             => self::TYPE_NAME_DMG ,
        self::TYPE_HEX_MP4             => self::TYPE_NAME_MP4 ,
    );

    protected static $_file_type_all = array ( self::TYPE_FILE_TEXT , self::TYPE_FILE_APPLICATION , self::TYPE_FILE_IMAGE , self::TYPE_FILE_AUDIO , self::TYPE_FILE_VIDEO );
    protected static $_data_type_all = array ( self::TYPE_DATA_TEXT , self::TYPE_DATA_BIN );

    public static function get_file_type_all ()
    {
        return self::$_file_type_all;
    }

    public static function get_mime_content_type ( $file_path )
    {
        if ( file_exists ( $file_path ) && is_file ( $file_path ) ) {
            $_file_type = mime_content_type ( $file_path );
            return $_file_type;
        }
        return false;
    }

    public static function get_file_type ( $file_path )
    {
        if ( file_exists ( $file_path ) && is_file ( $file_path ) ) {
            $_file_type = mime_content_type ( $file_path );
            if ( $_file_type !== false ) {
                $_last_path_delimiter_position = strrpos ( $file_path , "/" );
                if ( $_last_path_delimiter_position !== false ) {
                    $_file_type_items = explode ( "/" , $_file_type );
                    $_file_type       = $_file_type_items[ 0 ];
                    return $_file_type;
                }
            }
        }
        return false;
    }

    public static function get_file_data_type ( $file_path )
    {
        if ( file_exists ( $file_path ) && is_file ( $file_path ) ) {
            $_file_type = mime_content_type ( $file_path );
            if ( $_file_type !== false ) {
                if ( strlen ( $_file_type ) > 4 ) {
                    if ( substr ( $_file_type , 0 , 4 ) == self::TYPE_FILE_TEXT ) {
                        $_data_type = Class_Base_Format::TYPE_DATA_TEXT;
                    } else {
                        $_data_type = Class_Base_Format::TYPE_DATA_BIN;
                    }
                    return $_data_type;
                }
            }
        }
        return false;
    }

    public static function get_file_head_type_name ( $hex )
    {
        if ( ! empty( self::$_file_head_type_names[ $hex ] ) ) {
            return self::$_file_head_type_names[ $hex ];
        }
        return null;
    }

    public static function get_file_head_type_hex ( $name )
    {
        if ( ! empty( self::$_file_head_type_hexs[ $name ] ) ) {
            return self::$_file_head_type_hexs[ $name ];
        }
        return null;
    }

    public static function exist_dir ( $dir )
    {
        if ( file_exists ( $dir ) && ( is_dir ( $dir ) ) ) {
            return true;
        }
        return false;
    }

    public static function exist_file ( $file )
    {
        if ( file_exists ( $file ) && ( is_file ( $file ) ) ) {
            return true;
        }
        return false;
    }

    public static function get_file_size ( $file_path )
    {
        if ( file_exists ( $file_path ) && is_file ( $file_path ) ) {
            $_file_size = filesize ( $file_path );
            return $_file_size;
        }
        return false;
    }

    public static function get_file_stat ( $file )
    {

    }

    public static function pack_format_hex_big_endian_byte_order ( $string )
    {
        $_bin = pack ( "H*" , $string );
        if ( isset( $_bin ) ) {
            return $_bin;
        }
        return null;
    }

    public static function uppack_format_hex_big_endian_byte_order ( $bin )
    {
        $_array = unpack ( "H*" , $bin );
        if ( is_array ( $_array ) ) {
            return $_array[ 0 ];
        }
        return null;
    }

    public static function get_head_type ( $file )
    {
        if ( self::exist_file ( $file ) ) {
            $_file_handle = @fopen ( $file , "rb" );
            if ( ! empty( $_file_handle ) ) {
                $_file_header = fread ( $_file_handle , 16 );
                if ( $_file_header !== false ) {
                    fclose ( $_file_handle );
                    foreach ( self::$_file_head_type_hexs as $key => $value ) {
                        $_bin_format_string        = self::pack_format_hex_big_endian_byte_order ( $key );
                        $_bin_format_string_length = strlen ( $_bin_format_string );
                        $_bin                      = substr ( $_file_header , 0 , $_bin_format_string_length );
                        $_upper_hex                = strtoupper ( self::uppack_format_hex_big_endian_byte_order ( $_bin ) );
                        if ( ! empty( self::$_file_head_type_names[ $_upper_hex ] ) ) {
                            return self::$_file_head_type_names[ $_upper_hex ];
                        }
                    }
                } else {
                    fclose ( $_file_handle );
                }
            }
        }
        return null;
    }

    public static function get_text_content ( $file )
    {
        if ( ( self::exist_file ( $file ) ) && ( self::get_file_size ( $file ) <= ( 1024 * 1024 * 16 ) ) ) {
            $_fp = @fopen ( $file , "r" );
            if ( ! empty( $_fp ) ) {
                $_content = fread ( $_fp , ( 1024 * 1024 * 16 ) );
                if ( $_content !== false ) {
                    fclose ( $_fp );
                    return $_content;
                } else {
                    fclose ( $_fp );
                }
            }
        }
        return null;
    }

    public static function get_bin_content ( $file )
    {
        if ( ( self::exist_file ( $file ) ) && ( self::get_file_size ( $file ) <= ( 1024 * 1024 * 16 ) ) ) {
            $_fp = @fopen ( $file , "rb" );
            if ( ! empty( $_fp ) ) {
                $_content = fread ( $_fp , ( 1024 * 1024 * 16 ) );
                if ( $_content !== false ) {
                    fclose ( $_fp );
                    return $_content;
                } else {
                    fclose ( $_fp );
                }
            }
        }
        return null;
    }

    public static function get_file_info ( $file_path , $file_content_read_offset = 0 , $data_type = Class_Base_File::TYPE_DATA_BIN )
    {
        $_file_info = array ( "path" => $file_path , "parent_directory" => "" , "exist" => 0 , "type" => "" , "file_type" => "" , "data_type" => "" , "size" => 0 , "perms" => "" , "group" => array () , "owner" => array () , "atime" => 0 , "mtime" => 0 , "inode" => 0 , "ctime" => 0 , "content" => "" , "content_size" => 0 , "content_read_limit" => Class_Base_File::SIZE_FILE_CONTENT_LIMIT , "content_read_offset" => 0 , "content_read_remain" => 0 , "content_read_next_offset" => 0 );
        if ( is_string ( $file_path ) && ( $file_path != "" ) && file_exists ( $file_path ) && is_file ( $file_path ) ) {
            $_file_info[ "exist" ] = 1;
            clearstatcache ( true , $file_path );
            $_parent_directory = dirname ( $file_path );
            if ( $_parent_directory !== false ) {
                $_file_info[ "parent_directory" ] = $_parent_directory;
            }
            $_file_type = mime_content_type ( $file_path );
            if ( $_file_type !== false ) {
                $_file_info[ "type" ]      = $_file_type;
                $_file_info[ "file_type" ] = $_file_type;
            }
            if ( ! is_integer ( $data_type ) ) {
                $data_type = self::TYPE_DATA_BIN;
            }
            if ( ! in_array ( $data_type , self::$_data_type_all ) ) {
                $data_type = self::TYPE_DATA_BIN;
            }
            $_file_info[ "data_type" ] = $data_type;
            $_file_size                = filesize ( $file_path );
            if ( $_file_size !== false ) {
                $_file_info[ "size" ] = $_file_size;
            }
            $_file_perms = fileperms ( $file_path );
            if ( $_file_perms !== false ) {
                $_oct_perms = decoct ( $_file_perms );
                if ( $_oct_perms !== false ) {
                    $_file_info[ "perms" ] = substr ( $_oct_perms , - 4 , 4 );
                }
            }
            $_file_group = filegroup ( $file_path );
            if ( $_file_group !== false ) {
                if ( strtoupper ( substr ( PHP_OS , 0 , 3 ) ) === 'WIN' ) {
                    $_file_group_info      = array();
                }else{
                    $_file_group_info      = posix_getgrgid ( $_file_group );
                }
                $_file_info[ "group" ] = $_file_group_info;
            }
            $_file_owner = fileowner ( $file_path );
            if ( $_file_owner !== false ) {
                if ( strtoupper ( substr ( PHP_OS , 0 , 3 ) ) === 'WIN' ) {
                    $_file_owner_info = array();
                }else{
                    $_file_owner_info      = posix_getpwuid ( $_file_owner );
                }
                $_file_info[ "owner" ] = $_file_owner_info;
            }
            $_file_atime = fileatime ( $file_path );
            if ( $_file_atime !== false ) {
                $_file_info[ "atime" ] = $_file_atime;
            }
            $_file_mtime = filemtime ( $file_path );
            if ( $_file_mtime !== false ) {
                $_file_info[ "mtime" ] = $_file_mtime;
            }
            $_file_inode = fileinode ( $file_path );
            if ( $_file_inode !== false ) {
                $_file_info[ "inode" ] = $_file_inode;
            }
            $_file_ctime = filectime ( $file_path );
            if ( $_file_ctime !== false ) {
                $_file_info[ "ctime" ] = $_file_ctime;
            }
            $_file_point = fopen ( $file_path , "r" );
            if ( $_file_point !== false ) {
                if ( $file_content_read_offset < 0 ) {
                    $file_content_read_offset = 0;
                }
                if ( $file_content_read_offset >= $_file_info[ "size" ] ) {
                    $file_content_read_offset                 = $_file_info[ "size" ];
                    $_file_info[ "content_read_offset" ]      = $file_content_read_offset;
                    $_file_info[ "content_read_next_offset" ] = 0;
                    $_file_info[ "content_read_remain" ]      = 0;
                    $_file_info[ "content" ]                  = "";
                    $_file_info[ "content_size" ]             = 0;
                    @fclose ( $_file_point );
                    return $_file_info;
                }
                $_file_info[ "content_read_offset" ]      = $file_content_read_offset;
                $_file_info[ "content_read_next_offset" ] = ( $_file_info[ "content_read_offset" ] + $_file_info[ "content_read_limit" ] );
                if ( $_file_info[ "content_read_next_offset" ] >= $_file_info[ "size" ] ) {
                    $_file_info[ "content_read_next_offset" ] = $_file_info[ "size" ];
                    $_file_info[ "content_read_remain" ]      = 0;
                } else {
                    $_file_info[ "content_read_remain" ] = ( $_file_info[ "size" ] - ( $_file_info[ "content_read_next_offset" ] ) );
                }
                fseek ( $_file_point , $_file_info[ "content_read_offset" ] , SEEK_SET );
                $_file_content = fread ( $_file_point , $_file_info[ "content_read_limit" ] );
                if ( $_file_content === false ) {
                    @fclose ( $_file_point );
                    throw new \Exception( "Error reading file content" , 0 );
                }
                if ( $data_type == Class_Base_Format::TYPE_DATA_BIN ) {
                    $_file_info[ "content" ]      = Class_Base_Format::get_format_hex_content ( $_file_content );
                    $_file_info[ "content_size" ] = Class_Base_Format::get_format_hex_content_size ( $_file_info[ "content" ] );
                } else {
                    $_file_info[ "content" ]      = $_file_content;
                    $_file_info[ "content_size" ] = strlen ( $_file_content );
                }
                @fclose ( $_file_point );
            }
        }
        return $_file_info;
    }

    public static function get_file_full_name_info ( $file_full_name )
    {
        $_file_full_name_info = array ( "filename" => null , "extension" => null );
        if ( is_string ( $file_full_name ) ) {
            if ( strlen ( $file_full_name ) > 0 ) {
                $_file_full_name_items              = explode ( chr ( 46 ) , $file_full_name );
                $_file_full_name_info[ "filename" ] = $_file_full_name_items[ 0 ];
                if ( count ( $_file_full_name_items ) > 1 ) {
                    $_file_full_name_info[ "extension" ] = $_file_full_name_items[ 1 ];
                }
            }
        }
        return $_file_full_name_info;
    }

    public static function exist_file_type ( $file_path , $file_types = array ( self::TYPE_FILE_TEXT , self::TYPE_FILE_APPLICATION , self::TYPE_FILE_IMAGE , self::TYPE_FILE_AUDIO , self::TYPE_FILE_VIDEO ) )
    {
        if ( ( ! file_exists ( $file_path ) ) ) {
            throw new \Exception( "file is not exist , file_path : " . $file_path , 0 );
        }
        $_file_type        = mime_content_type ( $file_path );
        $_file_type_items  = explode ( "/" , $_file_type );
        $_file_common_type = $_file_type_items[ 0 ];
        if ( in_array ( strtolower ( $_file_common_type ) , $file_types ) ) {
            return true;
        }
        return false;
    }

    public static function parent_directory ( $file_path )
    {
        if ( Class_Base_Format::is_directory ( $file_path ) || Class_Base_Format::is_file ( $file_path ) ) {
            $_parent_directory = dirname ( $file_path );
            return $_parent_directory;
        }
        return false;
    }

    public static function get_file_name ( $file_path )
    {
        $_file_name = false;
        if ( Class_Base_Format::is_directory ( $file_path ) || Class_Base_Format::is_file ( $file_path ) ) {
            $file_path                     = str_replace ( "\\" , "/" , $file_path );
            $_last_path_delimiter_position = strrpos ( $file_path , "/" );
            if ( $_last_path_delimiter_position === false ) {
                $_file_name = $file_path;
            } else if ( $_last_path_delimiter_position == ( strlen ( $file_path ) - 1 ) ) {
                $_file_name = "";
            } else {
                $_file_name = substr ( $file_path , ( $_last_path_delimiter_position + 1 ) );
            }
        }
        return $_file_name;
    }

    public static function pathinfo ( $file_path )
    {
        if ( ! is_string ( $file_path ) ) {
            return false;
        }
        if ( strlen ( $file_path ) < 1 ) {
            return false;
        }
        $file_path = str_replace ( "\\" , "/" , $file_path );
        if ( ( $file_path == "." ) || ( $file_path == ".." ) ) {
            return false;
        }
        $_pathinfo                     = array ( "dirname" => null , "basename" => null , "extension" => null , "filename" => null );
        $_last_path_delimiter_position = strrpos ( $file_path , "/" );
        if ( $_last_path_delimiter_position === false ) {
            $file_path = ( chr ( 46 ) . "/" . $file_path );
        }
        $_full_file_name         = substr ( $file_path , $_last_path_delimiter_position );
        $_pathinfo[ "basename" ] = $_full_file_name;
        $_last_path_dot_position = strrpos ( $_full_file_name , "." );
        if ( $_last_path_dot_position !== false ) {
            $_full_file_name_items    = explode ( "." , $_full_file_name );
            $_pathinfo[ "filename" ]  = $_full_file_name_items[ 0 ];
            $_pathinfo[ "extension" ] = $_full_file_name_items[ 1 ];
        } else {
            $_pathinfo[ "filename" ] = $_full_file_name;
        }
        $_pathinfo[ "dirname" ] = substr ( $file_path , 0 , $_last_path_delimiter_position );
        return $_pathinfo;
    }

    public static function create_file ( $current_directory_path , $file_name , $data_type , $file_content , $file_size_limit = Class_Base_File::SIZE_FILE_CONTENT_LIMIT , $debug = 0 )
    {
        if ( $data_type == self::TYPE_DATA_BIN ) {
            $file_content = trim ( $file_content , chr ( 10 ) );
            $file_content = trim ( $file_content , chr ( 13 ) );
            $file_content = trim ( $file_content , chr ( 9 ) );
            $file_content = trim ( $file_content , chr ( 32 ) );
        }
        $_file_content_length = strlen ( $file_content );
        if ( is_string ( $current_directory_path ) && ( strlen ( $current_directory_path ) > 0 ) && is_string ( $file_name ) && ( strlen ( $file_name ) > 0 ) && is_string ( $file_content ) && ( $_file_content_length > 0 ) && ( $_file_content_length <= $file_size_limit ) && ( is_integer ( $data_type ) ) && ( in_array ( $data_type , array ( Class_Base_Format::TYPE_DATA_TEXT , Class_Base_Format::TYPE_DATA_BIN ) ) ) ) {
            $current_directory_path = str_replace ( "\\" , "/" , $current_directory_path );
            $file_name              = Class_Base_Format::filter_file_name_special_symbols ( str_replace ( "/" , "_" , str_replace ( "\\" , "/" , $file_name ) ) );
            $_file_name_length      = strlen ( $file_name );
            $_dot_position          = strrpos ( $file_name , chr ( 46 ) );

            if ( $_dot_position === false ) {
                $file_name .= ( $file_name . ( chr ( 46 ) . time () . chr ( 46 ) . "phpsploit" ) );
            } else if ( $_dot_position === ( $_file_name_length - 1 ) ) {
                if ( $_file_name_length == 1 ) {
                    $file_name .= ( time () . chr ( 46 ) . "phpsploit" );
                } else {
                    $file_name .= ( substr ( $file_name , 0 , ( $_file_name_length - 1 ) ) . ( chr ( 46 ) . time () . chr ( 46 ) . "phpsploit" ) );
                }
            } else {
                $_extend_name = substr ( $file_name , ( $_dot_position + 1 ) , ( $_file_name_length - ( $_dot_position + 1 ) ) );
                $file_name    = ( substr ( $file_name , 0 , ( $_dot_position ) ) . chr ( 46 ) . time () . chr ( 46 ) . "phpsploit" . chr ( 46 ) . $_extend_name );
            }
            if ( substr ( $file_name , 0 , 1 ) == "." ) {
                $file_name = ( time () . chr ( 46 ) . $file_name );
            }
            if ( $current_directory_path == "/" ) {
                $_file_path = $current_directory_path . $file_name;
            } else {
                if ( substr ( $current_directory_path , ( strlen ( $current_directory_path ) - 1 ) , 1 ) == "/" ) {
                    $_file_path = $current_directory_path . $file_name;
                } else {
                    $_file_path = $current_directory_path . "/" . $file_name;
                }
            }
            $_file_content_size = Class_Base_Format::get_bin_content_size ( $file_content , $data_type );
            $_file_content      = Class_Base_Format::get_bin_content ( $file_content , $data_type );
            if ( $_file_content_size != strlen ( $_file_content ) ) {
                throw new \Exception( "Inconsistent calculation results of data content size" , 0 );
            }
            if ( ! file_exists ( $_file_path ) ) {
                $_mode       = ( ( $data_type == Class_Base_Format::TYPE_DATA_BIN ) ? "wb" : "w" );
                $_file_point = fopen ( $_file_path , $_mode );
                if ( ! empty( $_file_point ) ) {
                    $_file_write_length = fwrite ( $_file_point , $_file_content , $file_size_limit );
                    fclose ( $_file_point );
                    if ( ! empty( $_file_write_length ) ) {
                        $_return = array ( "file_path" => $_file_path , "content_size" => $_file_content_size , "content_write_size" => $_file_write_length , "content_remain_size" => ( $_file_content_size - $_file_write_length ) );
                        return $_return;
                    }
                }
            }
        }
        return null;
    }

    public static function update_file ( $file_path , $file_content , $data_type , $file_size_limit = Class_Base_File::SIZE_FILE_CONTENT_LIMIT , $debug = 0 )
    {
        if ( file_exists ( $file_path ) && is_file ( $file_path ) && Class_Base_File::is_permission ( $file_path ) ) {
            $_file_content_size = Class_Base_Format::get_bin_content_size ( $file_content , $data_type );
            $_file_content      = Class_Base_Format::get_bin_content ( $file_content , $data_type );
            if ( $_file_content_size != strlen ( $_file_content ) ) {
                throw new \Exception( "Inconsistent calculation results of data content size" , 0 );
            }
            if ( $_file_content_size <= 0 ) {
                throw new \Exception( "The data content size cannot be empty" , 0 );
            }
            if ( $_file_content_size > $file_size_limit ) {
                throw new \Exception( "The data content size has exceeded the writable limit" , 0 );
            }
            $_mode       = ( ( $data_type == Class_Base_Format::TYPE_DATA_BIN ) ? "wb" : "w" );
            $_file_point = fopen ( $file_path , $_mode );
            if ( ! empty( $_file_point ) ) {
                $_file_write_length = fwrite ( $_file_point , $_file_content , $file_size_limit );
                fclose ( $_file_point );
                if ( ! empty( $_file_write_length ) ) {
                    $_return = array ( "file_path" => $file_path , "content_size" => $_file_content_size , "content_write_size" => $_file_write_length , "content_remain_size" => ( $_file_content_size - $_file_write_length ) );
                    return $_return;
                }
            }
        }
        return false;
    }

    public static function delete_file ( $file_path , $file_size_limit = Class_Base_File::SIZE_FILE_CONTENT_LIMIT , $debug = 0 )
    {
        if ( is_string ( $file_path ) && ( strlen ( $file_path ) > 0 ) && self::is_permission ( $file_path ) ) {
            $_file_size = self::get_file_size ( $file_path );
            if ( $_file_size > $file_size_limit ) {
                throw new \Exception( 'The volume size ( ' . $_file_size . ' byte )  of the current file exceeds the maximum volume size ( ' . $file_size_limit . ' byte ) limit for file deletion. Unable to successfully delete file ( ' . $file_path . ')' , Class_Base_Error::FILE_EXCEPTION_DELETE );
            }
            $_parent_directory  = dirname ( $file_path );
            $_file_type         = self::get_file_type ( $file_path );
            $_delete_start_time = time ();
            $_deleted           = @unlink ( $file_path );
            if ( empty( $_deleted ) ) {
                return false;
            }
            $_delete_end_time  = time ();
            $_delete_exec_time = ( $_delete_end_time - $_delete_start_time );
            $_return           = array ( "file_path" => $file_path , "parent_directory" => $_parent_directory , "file_type" => $_file_type , "file_size" => $_file_size , "file_size_limit" => $file_size_limit , "deleted" => $_deleted , "delete_start_time" => $_delete_start_time , "delete_end_time" => $_delete_end_time , "delete_exec_time" => $_delete_exec_time , );
            return $_return;

        }
        return false;
    }

    public static function get_file_content ( $file_path , $data_type , &$content_remain_read_size = 0 , $limit_read_size = Class_Base_File::SIZE_FILE_CONTENT_LIMIT )
    {
        if ( file_exists ( $file_path ) && is_file ( $file_path ) ) {
            if ( ! is_integer ( $data_type ) ) {
                throw new \Exception( ( "data_type is not a integer number , data_type : " . print_r ( $data_type , true ) ) , 0 );
            }
            if ( ( ! in_array ( $data_type , array ( Class_Base_Format::TYPE_DATA_TEXT , Class_Base_Format::TYPE_DATA_BIN ) ) ) ) {
                throw new \Exception( ( "data_type is not within the valid range , data_type : " . print_r ( $data_type , true ) ) , 0 );
            }
            $_file_size = self::get_file_size ( $file_path );
            if ( $_file_size !== false ) {
                if ( $_file_size > $limit_read_size ) {
                    $content_remain_read_size = ( $_file_size - $limit_read_size );
                }
                $_mode = "r";
                if ( $data_type == Class_Base_Format::TYPE_DATA_BIN ) {
                    $_mode = "rb";
                }
                $_file_point = fopen ( $file_path , $_mode );
                if ( ! empty( $_file_point ) ) {
                    $_file_content = fread ( $_file_point , $limit_read_size );
                    fclose ( $_file_point );
                    $_file_content_length = strlen ( $_file_content );
                    if ( $data_type !== false ) {
                        $_return_content = "";
                        if ( $data_type == Class_Base_Format::TYPE_DATA_BIN ) {
                            for ( $index = 0 ; $index < $_file_content_length ; $index ++ ) {
                                $_return_content .= ( '\x' . ( str_pad ( dechex ( ord ( substr ( $_file_content , $index , 1 ) ) ) , 2 , '0' , STR_PAD_LEFT ) ) );
                            }
                        } else {
                            $_return_content = $_file_content;
                        }
                        return $_return_content;
                    }
                }
            }
        }
        return false;
    }

    public static function get_file_content_size ( $file_content , $data_type = self::TYPE_DATA_BIN )
    {
        if ( ! is_string ( $file_content ) ) {
            throw new \Exception( "The file content is not a valid string" , 0 );
        }
        if ( strlen ( $file_content ) > 1024 * 1024 * 10 ) {
            throw new \Exception( "The data volume is too large to calculate the data size in real-time" , 0 );
        }
        $_file_content_size = Class_Base_Format::get_bin_content_size ( $file_content , $data_type );
        return $_file_content_size;
    }

    public static function is_permission ( $file_path )
    {
        if ( file_exists ( $file_path ) && ( is_file ( $file_path ) ) ) {
            $_path_info = pathinfo ( $file_path );
            if ( ! array_key_exists ( "extension" , $_path_info ) ) {
                return false;
            }
            if ( $_path_info[ "extension" ] == "phpsploit" ) {
                return true;
            }
            $_file_name              = $_path_info[ "filename" ];
            $_last_path_dot_position = strrpos ( $_file_name , chr ( 46 ) );
            if ( $_last_path_dot_position === false ) {
                return false;
            }
            $_file_name_items       = explode ( chr ( 46 ) , $_file_name );
            $_file_name_items_count = count ( $_file_name_items );
            if ( $_file_name_items_count <= 1 ) {
                return false;
            }
            $_extend_name = $_file_name_items[ $_file_name_items_count - 1 ];
            if ( $_extend_name == "phpsploit" ) {
                return true;
            }
        }
        return false;
    }

    public static function check_permission ( $file_path )
    {
        if ( ! self::is_permission ( $file_path ) ) {
            throw new \Exception( "Insufficient access permissions, you cannot perform operations on the current file (" . strval ( $file_path ) . ")!" , 0 );
        }
    }

    public static function upload ( $form_file_field_name , $save_directory_path , $limit_file_size = self::SIZE_FILE_CONTENT_LIMIT , $limit_file_types = array ( self::TYPE_FILE_TEXT , self::TYPE_FILE_APPLICATION , self::TYPE_FILE_IMAGE , self::TYPE_FILE_AUDIO , self::TYPE_FILE_VIDEO ) )
    {
        if ( ( is_string ( $form_file_field_name ) && ( strlen ( $form_file_field_name ) > 0 ) ) && ( is_string ( $save_directory_path ) && ( strlen ( $save_directory_path ) > 0 ) ) ) {
            if ( ( ! empty( $_FILES[ $form_file_field_name ] ) ) && ( is_array ( $_FILES[ $form_file_field_name ] ) ) ) {
                if ( ( array_key_exists ( "error" , $_FILES[ $form_file_field_name ] ) ) && ( is_integer ( $_FILES[ $form_file_field_name ][ "error" ] ) ) && ( $_FILES[ $form_file_field_name ][ "error" ] > 0 ) ) {
                    throw new \Exception( "upload file , error code : " . $_FILES[ $form_file_field_name ][ "error" ] , 0 );
                }
                if ( ( ! empty( $_FILES[ $form_file_field_name ][ "name" ] ) ) && ( ! empty( $_FILES[ $form_file_field_name ][ "type" ] ) ) && ( ! empty( $_FILES[ $form_file_field_name ][ "size" ] ) ) && ( ! empty( $_FILES[ $form_file_field_name ][ "tmp_name" ] ) ) ) {
                    if ( ! is_uploaded_file ( $_FILES[ $form_file_field_name ][ "tmp_name" ] ) ) {
                        throw new \Exception( "The file upload method is illegal, access is prohibited! Temporary file path : " . $_FILES[ $form_file_field_name ][ "tmp_name" ] , 0 );
                    }
                    if ( ! self::exist_file_type ( $_FILES[ $form_file_field_name ][ "tmp_name" ] , $limit_file_types ) ) {
                        throw new \Exception( "The upload file type is not within the acceptable range. Current upload file type : " . $_FILES[ $form_file_field_name ][ "type" ] , 0 );
                    }
                    if ( $_FILES[ $form_file_field_name ][ "size" ] > $limit_file_size ) {
                        throw new \Exception( "The size of the uploaded file exceeds the upload limit , The current uploaded file size is : " . $_FILES[ $form_file_field_name ][ "size" ] , 0 );
                    }
                    $_file_full_name_info = self::get_file_full_name_info ( $_FILES[ $form_file_field_name ][ "name" ] );
                    if ( empty( $_file_full_name_info ) || ( ! is_array ( $_file_full_name_info ) ) || ( ! array_key_exists ( "filename" , $_file_full_name_info ) ) || ( ! is_string ( $_file_full_name_info[ "filename" ] ) ) || ( strlen ( $_file_full_name_info[ "filename" ] ) < 1 ) ) {
                        throw new \Exception( "Failed to obtain relevant information about the uploaded file , Current uploaded file name is  : " . $_FILES[ $form_file_field_name ][ "name" ] );
                    }
                    $save_directory_path = str_replace ( "\\" , "/" , $save_directory_path );
                    if ( ( ! file_exists ( $save_directory_path ) ) || ( ! is_dir ( $save_directory_path ) ) ) {
                        throw new \Exception( "The file save directory path you set does not exist , Please check and reset the file save directory path , The current file save directory path is set to : " . $save_directory_path , 0 );
                    }
                    $_file_name = Class_Base_Format::filter_file_name_special_symbols ( $_file_full_name_info[ "filename" ] );
                    if ( ( ! is_string ( $_file_name ) ) || ( strlen ( $_file_name ) <= 0 ) ) {
                        $_file_name = "file_create_time_" . time ();
                    }
                    $_extend_name = $_file_full_name_info[ "extension" ];
                    if ( substr ( $save_directory_path , ( strlen ( $save_directory_path ) - 1 ) , 1 ) != "/" ) {
                        $save_directory_path .= "/";
                    }
                    if ( $_FILES[ $form_file_field_name ][ "error" ] == UPLOAD_ERR_OK ) {
                        $_file_save_path = $save_directory_path . $_file_name . chr ( 46 ) . time () . chr ( 46 ) . "phpsploit" . ( ( ( ! is_string ( $_extend_name ) ) || ( strlen ( $_extend_name ) < 1 ) ) ? "" : ( chr ( 46 ) . $_extend_name ) );
                        if ( file_exists ( $_file_save_path ) ) {
                            throw new \Exception( "The target file already exists and cannot be overwritten ! Target file : " . $_file_save_path , 0 );
                        }
                        $_move_success = move_uploaded_file ( $_FILES[ $form_file_field_name ][ "tmp_name" ] , $_file_save_path );
                        if ( empty( $_move_success ) ) {
                            throw new \Exception( "Failed to save the uploaded file ! Upload file save path : " . $_file_save_path , 0 );
                        }
                        $_file_info   = self::get_file_info ( $_file_save_path , 0 );
                        $_file_object = self::get_new_object ( $_file_info );
                        return $_file_object;
                    }
                }
            }
        }
        return null;
    }

    public static function get_new_object ( $file_info )
    {
        $_object = new Class_Base_File( $file_info );
        return $_object;
    }

    public function __construct ( $file_info )
    {
        if ( is_array ( $file_info ) && ( ! empty( $file_info ) ) ) {
            foreach ( $file_info as $key => $item ) {
                $this->{$key} = $item;
            }
        }
    }

    public function __destruct ()
    {
        /* TODO: Implement __destruct() method. */
    }
}