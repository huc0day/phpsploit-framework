<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-2
 * Time: 下午5:33
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

class Class_Base_Format extends Class_Base implements Interface_Base_Format
{
    const TYPE_DATA_TEXT  = 10000001;
    const TYPE_DATA_BIN   = 10000002;
    const TYPE_FILE_IMAGE = 10000003;
    const TYPE_FILE_AUDIO = 10000004;
    const TYPE_FILE_VIDEO = 10000005;

    const TYPE_FIELD_CONVENTIONAL = "conventional";
    const TYPE_FIELD_VAR          = "var";

    private static $_field_name_conventional_matchings  = array ( 'a' , 'b' , 'c' , 'd' , 'e' , 'f' , 'g' , 'h' , 'i' , 'j' , 'k' , 'l' , 'm' , 'n' , 'o' , 'p' , 'q' , 'r' , 's' , 't' , 'u' , 'v' , 'w' , 'x' , 'y' , 'z' , '0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' , '8' , '9' , '_' );
    private static $_field_name_var_head_char_matchings = array ( 'a' , 'b' , 'c' , 'd' , 'e' , 'f' , 'g' , 'h' , 'i' , 'j' , 'k' , 'l' , 'm' , 'n' , 'o' , 'p' , 'q' , 'r' , 's' , 't' , 'u' , 'v' , 'w' , 'x' , 'y' , 'z' , '_' );
    private static $_field_name_var_matchings           = array ( 'a' , 'b' , 'c' , 'd' , 'e' , 'f' , 'g' , 'h' , 'i' , 'j' , 'k' , 'l' , 'm' , 'n' , 'o' , 'p' , 'q' , 'r' , 's' , 't' , 'u' , 'v' , 'w' , 'x' , 'y' , 'z' , '0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' , '8' , '9' , '_' );
    private static $_type_fields                        = array (
        self::TYPE_FIELD_CONVENTIONAL ,
        self::TYPE_FIELD_VAR ,
    );
    private static $_file_name_conventional_matchings   = array ( 'a' , 'b' , 'c' , 'd' , 'e' , 'f' , 'g' , 'h' , 'i' , 'j' , 'k' , 'l' , 'm' , 'n' , 'o' , 'p' , 'q' , 'r' , 's' , 't' , 'u' , 'v' , 'w' , 'x' , 'y' , 'z' , '0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' , '8' , '9' , '_' , '.' );

    public static function is_empty ( $data )
    {
        if ( is_string ( $data ) ) {
            $data = str_replace ( "\0" , "" , $data );
        }
        $_bool = empty( $data );
        return $_bool;
    }

    public static function is_empty_string ( $data )
    {
        if ( is_string ( $data ) ) {
            $data = str_replace ( "\0" , "" , $data );
        }
        if ( $data == "" ) {
            return true;
        }
        return false;
    }

    public static function is_field_name ( $field_name , $field_name_limit_length = 255 , $field_type = self::TYPE_FIELD_CONVENTIONAL )
    {
        if ( ! is_string ( $field_name ) ) {
            return false;
        }
        $field_name_length = strlen ( $field_name );
        if ( $field_name_length > $field_name_limit_length ) {
            return false;
        }
        if ( ! in_array ( $field_type , self::$_type_fields ) ) {
            return false;
        }
        for ( $field_name_index = 0 ; $field_name_index < $field_name_length ; $field_name_index ++ ) {
            $_field_name_index_char = substr ( $field_name , $field_name_index , 1 );
            if ( $field_type == self::TYPE_FIELD_CONVENTIONAL ) {
                if ( ! in_array ( $_field_name_index_char , self::$_field_name_conventional_matchings ) ) {
                    return false;
                }
            }
            if ( $field_type == self::TYPE_FIELD_VAR ) {
                if ( $field_name_index == 0 ) {
                    if ( ! in_array ( $_field_name_index_char , self::$_field_name_var_head_char_matchings ) ) {
                        return false;
                    }
                } else {
                    if ( ! in_array ( $_field_name_index_char , self::$_field_name_var_matchings ) ) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public static function is_directory ( $file_path )
    {
        if ( is_string ( $file_path ) ) {
            if ( file_exists ( $file_path ) ) {
                if ( is_dir ( $file_path ) ) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function is_file ( $file_path )
    {
        if ( is_string ( $file_path ) ) {
            if ( file_exists ( $file_path ) ) {
                if ( is_file ( $file_path ) ) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function is_text_file ( $file_path )
    {
        if ( ! self::is_file ( $file_path ) ) {
            throw new \Exception( ( print_r ( $file_path , true ) . " is not a valid file" ) , 0 );
        }
        $_file_type = mime_content_type ( $file_path );
        if ( $_file_type === false ) {
            throw new \Exception( ( "Failed to obtain file type for " . print_r ( $file_path , true ) ) , 0 );
        }
        if ( ( strlen ( $_file_type ) > 5 ) && ( substr ( $_file_type , 0 , 5 ) == "text/" ) ) {
            return true;
        }
        return false;
    }

    public static function is_image_file ( $file_path )
    {
        if ( ! self::is_file ( $file_path ) ) {
            throw new \Exception( ( print_r ( $file_path , true ) . " is not a valid file" ) , 0 );
        }
        $_file_type = mime_content_type ( $file_path );
        if ( $_file_type === false ) {
            throw new \Exception( ( "Failed to obtain file type for " . print_r ( $file_path , true ) ) , 0 );
        }
        if ( ( strlen ( $_file_type ) > 6 ) && ( substr ( $_file_type , 0 , 6 ) == "image/" ) ) {
            return true;
        }
        return false;
    }

    public static function is_audio_file ( $file_path )
    {
        if ( ! self::is_file ( $file_path ) ) {
            throw new \Exception( ( print_r ( $file_path , true ) . " is not a valid file" ) , 0 );
        }
        $_file_type = mime_content_type ( $file_path );
        if ( $_file_type === false ) {
            throw new \Exception( ( "Failed to obtain file type for " . print_r ( $file_path , true ) ) , 0 );
        }
        if ( ( strlen ( $_file_type ) > 6 ) && ( substr ( $_file_type , 0 , 6 ) == "audio/" ) ) {
            return true;
        }
        return false;
    }

    public static function is_video_file ( $file_path )
    {
        if ( ! self::is_file ( $file_path ) ) {
            throw new \Exception( ( print_r ( $file_path , true ) . " is not a valid file" ) , 0 );
        }
        $_file_type = mime_content_type ( $file_path );
        if ( $_file_type === false ) {
            throw new \Exception( ( "Failed to obtain file type for " . print_r ( $file_path , true ) ) , 0 );
        }
        if ( ( strlen ( $_file_type ) > 6 ) && ( substr ( $_file_type , 0 , 6 ) == "video/" ) ) {
            return true;
        }
        return false;
    }

    public static function is_bin_file ( $file_path )
    {
        if ( ! self::is_file ( $file_path ) ) {
            throw new \Exception( ( print_r ( $file_path , true ) . " is not a valid file" ) , 0 );
        }
        $_file_type = mime_content_type ( $file_path );
        if ( $_file_type === false ) {
            throw new \Exception( ( "Failed to obtain file type for " . print_r ( $file_path , true ) ) , 0 );
        }
        if ( ( strlen ( $_file_type ) > 12 ) && ( substr ( $_file_type , 0 , 12 ) == "application/" ) ) {
            return true;
        }
        return false;
    }

    public static function string_to_content ( $string , $size )
    {
        $_string = self::string_to_data ( $string , $size );
        return $_string;
    }

    public static function content_to_string ( $string )
    {
        $_string = self::data_to_string ( $string );
        return $_string;
    }

    public static function string_to_data ( $string , $size )
    {
        if ( is_null ( $string ) ) {
            $string = "";
        }
        $_strlen = strlen ( $string );
        if ( empty( $_strlen ) ) {
            $string = str_repeat ( "\0" , $size );
        } else if ( $_strlen > $size ) {
            $string = substr ( $string , 0 , $size );
        } else {
            $string = str_pad ( $string , $size , self::ASCII_CODE_ZERO , STR_PAD_RIGHT );
        }
        return $string;
    }

    public static function data_to_string ( $data )
    {
        $_data = str_replace ( "\0" , "" , $data );
        return $_data;
    }

    public static function is_min_to_max_integer ( $integer , $min , $max )
    {
        $_min_length = strlen ( $min );
        $_max_length = strlen ( $max );
        if ( ! self::is_minlen_to_maxlen_integer ( $integer , $_min_length , $_max_length ) ) {
            return false;
        }
        $integer = intval ( $integer );
        if ( ( $integer < $min ) || ( $integer > $max ) ) {
            return false;
        }
        return true;
    }

    public static function is_minlen_to_maxlen_string ( $string , $min = self::STRING_MIN_LENGTH , $max = self::STRING_MAX_LENGTH )
    {
        if ( ! is_string ( $string ) ) {
            if ( ! is_integer ( $string ) ) {
                return false;
            }
            $string = strval ( $string );
        }
        $string  = str_replace ( "\0" , "" , $string );
        $_length = strlen ( $string );
        if ( ( $_length >= $min ) && ( $_length <= $max ) ) {
            return true;
        }
        return false;
    }

    public static function is_integer ( $integer )
    {
        if ( is_string ( $integer ) ) {
            $integer = str_replace ( "\0" , "" , $integer );
            $length  = strlen ( $integer );
            if ( $length <= 0 ) {
                return false;
            }
            for ( $index = 0 ; $index < $length ; $index ++ ) {
                $_char = substr ( $integer , $index , 1 );
                if ( ( $_char != '0' ) && ( $_char != '1' ) && ( $_char != '2' ) && ( $_char != '3' ) && ( $_char != '4' ) && ( $_char != '5' ) && ( $_char != '6' ) && ( $_char != '7' ) && ( $_char != '8' ) && ( $_char != '9' ) ) {
                    return false;
                }
            }
            return true;
        } else {
            $_ret = is_integer ( $integer );
            return $_ret;
        }
    }

    public static function is_minlen_to_maxlen_integer ( $integer , $min = self::INTEGER_MIN_LENGTH , $max = self::INTEGER_MAX_LENGTH )
    {
        if ( ! is_string ( $integer ) ) {
            $integer = strval ( $integer );
        }
        $integer = str_replace ( "\0" , "" , $integer );
        $_length = strlen ( $integer );
        if ( ( $_length > 1 ) && ( substr ( $integer , 0 , 1 ) == '0' ) ) {
            return false;
        }
        if ( ( $_length >= $min ) && ( $_length <= $max ) ) {
            if ( self::is_integer ( $integer ) ) {
                return true;
            }
        }
        return false;
    }

    public static function is_oct ( $oct )
    {
        if ( ! is_string ( $oct ) ) {
            if ( ! is_integer ( $oct ) ) {
                return false;
            }
            $oct = strval ( $oct );
        }
        $oct    = str_replace ( "\0" , "" , $oct );
        $length = strlen ( $oct );
        if ( $length <= 0 ) {
            return false;
        }
        for ( $index = 0 ; $index < $length ; $index ++ ) {
            $_char = substr ( $oct , $index , 1 );
            if ( ( $_char != '0' ) && ( $_char != '1' ) && ( $_char != '2' ) && ( $_char != '3' ) && ( $_char != '4' ) && ( $_char != '5' ) && ( $_char != '6' ) && ( $_char != '7' ) ) {
                return false;
            }
        }
        return true;
    }

    public static function is_minlen_to_maxlen_oct ( $oct , $min = self::OCT_MIN_LENGTH , $max = self::OCT_MAX_LENGTH )
    {
        if ( ! is_string ( $oct ) ) {
            $oct = strval ( $oct );
        }
        $oct     = str_replace ( "\0" , "" , $oct );
        $_length = strlen ( $oct );
        if ( ( $_length >= $min ) && ( $_length <= $max ) ) {
            if ( self::is_oct ( $oct ) ) {
                return true;
            }
        }
        return false;
    }

    public static function is_hex ( $hex )
    {
        if ( ! is_string ( $hex ) ) {
            if ( ! is_integer ( $hex ) ) {
                return false;
            }
            $hex = strval ( $hex );
        }
        $hex = str_replace ( "\0" , "" , $hex );
        $hex = strtolower ( $hex );
        if ( ( strlen ( $hex ) > 2 ) && ( ( substr ( $hex , 0 , 2 ) == "0x" ) ) ) {
            $hex = substr ( $hex , 2 );
        }
        $_length = strlen ( $hex );
        if ( $_length <= 0 ) {
            return false;
        }
        for ( $index = 0 ; $index < $_length ; $index ++ ) {
            $_char = substr ( $hex , $index , 1 );
            if ( ( $_char != '0' ) && ( $_char != '1' ) && ( $_char != '2' ) && ( $_char != '3' ) && ( $_char != '4' ) && ( $_char != '5' ) && ( $_char != '6' ) && ( $_char != '7' ) && ( $_char != '8' ) && ( $_char != '9' ) && ( $_char != 'a' ) && ( $_char != 'b' ) && ( $_char != 'c' ) && ( $_char != 'd' ) && ( $_char != 'e' ) && ( $_char != 'f' ) ) {
                return false;
            }
        }
        return true;
    }

    public static function is_min_to_max_hex ( $hex , $min = self::HEX_MIN_VALUE , $max = self::HEX_KEY_MAX_VALUE )
    {
        if ( is_string ( $hex ) ) {
            if ( ! self::is_hex ( $hex ) ) {
                return false;
            }
            $_num = self::hex_to_dec ( $hex );
        }
        if ( ( ! is_integer ( $min ) ) || ( ! is_integer ( $max ) ) ) {
            return false;
        }
        if ( ( strlen ( strval ( $hex ) ) < strlen ( strval ( $min ) ) ) || ( strlen ( strval ( $hex ) ) > strlen ( strval ( $max ) ) ) ) {
            return false;
        }
        if ( ( $_num >= $min ) && ( $_num <= $max ) ) {
            return true;
        }
        return false;
    }

    public static function is_minlen_to_maxlen_hex ( $hex , $min = self::HEX_MIN_LENGTH , $max = self::HEX_MAX_LENGTH )
    {
        if ( ! is_string ( $hex ) ) {
            $hex = strval ( $hex );
        }
        $hex = str_replace ( "\0" , "" , $hex );
        if ( ( strlen ( $hex ) > 2 ) && ( substr ( strtolower ( $hex ) , 0 , 2 ) == "0x" ) ) {
            $hex = substr ( $hex , 2 );
        }
        $_length = strlen ( $hex );
        if ( $_length < self::HEX_MIN_LENGTH ) {
            return false;
        }
        if ( $_length > self::HEX_MAX_LENGTH ) {
            return false;
        }
        if ( ( $_length == self::HEX_MAX_LENGTH ) && ( substr ( $hex , 0 , 1 ) != "0" ) ) {
            return false;
        }
        if ( ( $_length >= $min ) && ( $_length <= $max ) ) {
            if ( self::is_hex ( $hex ) ) {
                return true;
            }
        }
        return false;
    }

    public static function dec_to_hex ( $dec , $hex_string_length = self::SIZE_INTEGER_SPACE )
    {
        if ( ! self::is_minlen_to_maxlen_integer ( $dec , self::INTEGER_MIN_LENGTH , self::INTEGER_MAX_LENGTH ) ) {
            throw new \Exception( 'dec ( ' . $dec . ' )' , 0 );
        }
        if ( ! is_integer ( $dec ) ) {
            $dec = intval ( $dec );
        }
        if ( $dec > self::INTEGER_MAX_VALUE ) {
            throw new \Exception( "dec greater than max value" , 0 );
        }
        $_hex     = dechex ( $dec );
        $_hex_len = strlen ( $_hex );
        if ( $_hex_len < $hex_string_length ) {
            $_hex = str_pad ( $_hex , $hex_string_length , self::CHAR_ZERO , STR_PAD_LEFT );
        }
        return $_hex;
    }

    public static function hex_to_dec ( $hex )
    {
        if ( ! self::is_minlen_to_maxlen_hex ( $hex , self::HEX_MIN_LENGTH , self::HEX_MAX_LENGTH ) ) {
            throw new \Exception( "hex value format is error , hex : " . $hex , 0 );
        }
        $_dec = hexdec ( $hex );
        if ( $_dec > self::INTEGER_MAX_VALUE ) {
            throw new \Exception( "dec greater than max value , dec : " . $_dec , 0 );
        }
        return $_dec;
    }

    public static function string_to_name ( $string , $size )
    {
        if ( ! is_string ( $string ) ) {
            if ( ! is_integer ( $string ) ) {
                throw new \Exception( ( print_r ( $string , true ) . " is data type is neither string nor integer, and its data type is " . gettype ( $string ) ) , 0 );
            }
            $string = strval ( $string );
        }
        $_strlen = strlen ( $string );
        if ( empty( $_strlen ) ) {
            $string = str_repeat ( "\0" , $size );
        } else if ( $_strlen > $size ) {
            $string = substr ( $string , 0 , $size );
        } else {
            $string = str_pad ( $string , $size , self::ASCII_CODE_ZERO , STR_PAD_RIGHT );
        }
        return $string;
    }

    public static function boolean_to_status ( $boolean )
    {
        if ( $boolean === false ) {
            $boolean = 0;
        }
        if ( $boolean === true ) {
            $boolean = 1;
        }
        if ( ( ( $boolean != 0 ) && ( $boolean != 1 ) ) && ( $boolean != '0' ) && ( $boolean != '1' ) ) {
            throw new \Exception( ( "The value of " . print_r ( $boolean , true ) . " is not a valid Boolean type, AAA's type is: " . gettype ( $boolean ) ) , 0 );
        }
        return strval ( $boolean );
    }

    public static function oct_to_mode ( $oct )
    {
        if ( is_string ( $oct ) ) {
            $_oct_length = strlen ( $oct );
            if ( $_oct_length == 3 ) {
                $oct = decoct ( intval ( $oct ) );
            } else if ( $_oct_length != 4 ) {
                throw new \Exception( ( "Error encountered while converting octal number to permission mode! Exception in permission mode format: " . print_r ( $oct , true ) ) , 0 );
            }
            $oct = octdec ( $oct );
        } else if ( ! is_integer ( $oct ) ) {
            throw new \Exception( ( "Error encountered while converting octal number to permission mode! Exception in permission mode format: " . print_r ( $oct , true ) ) , 0 );
        }
        if ( ( $oct < 384 ) || ( $oct > 511 ) ) {
            throw new \Exception( ( "Error encountered while converting octal number to permission mode! Exception in permission mode format: " . print_r ( $oct , true ) ) , 0 );
        }
        $_mode = strval ( $oct );
        $_mode = str_pad ( $_mode , 3 , '0' , STR_PAD_LEFT );
        return $_mode;
    }

    public static function integer_to_type ( $integer )
    {
        $_integer = strval ( $integer );
        if ( ! self::is_minlen_to_maxlen_integer ( $_integer , 4 , 4 ) ) {
            throw new \Exception( ( "Encountered an error converting integer numbers to type! Type format exception: " . print_r ( $integer , true ) ) , 0 );
        }
        return $_integer;
    }

    public static function integer_to_offset ( $integer )
    {
        if ( ! self::is_min_to_max_integer ( $integer , self::OFFSET_BLOCK_MIN , self::OFFSET_BLOCK_MAX ) ) {
            throw new \Exception( ( "Encountered an error converting integer numbers to offset! Type format exception: " . print_r ( $integer , true ) ) , 0 );
        }
        $_integer = self::dec_to_hex ( $integer );
        return $_integer;
    }

    public static function string_to_reserved ( $string , $size )
    {
        if ( ! is_string ( $string ) ) {
            if ( is_null ( $string ) ) {
                $string = "";
            } else if ( is_integer ( $string ) ) {
                $string = strval ( $string );
            } else {
                throw new \Exception( ( "Encountered an error converting string to reserved data! Reserved data format exception: " . print_r ( $string , true ) ) , 0 );
            }
        }
        $_strlen = strlen ( $string );
        if ( $_strlen < $size ) {
            $string = str_repeat ( "\0" , $size );
        } else if ( $_strlen > $size ) {
            $string = substr ( $string , 0 , $size );
        } else {
            $string = str_pad ( $string , $size , self::ASCII_CODE_ZERO , STR_PAD_RIGHT );
        }
        return $string;
    }

    public static function end_flag_to_string ( $string , $size )
    {
        if ( ! self::is_minlen_to_maxlen_string ( $string , $size , $size ) ) {
            throw new \Exception( ( "Encountered an error converting the end flag to a string! End flag format exception: " . print_r ( $string , true ) ) , 0 );
        }
        $_ret = str_replace ( "\0" , "" , strval ( $string ) );
        return $_ret;
    }

    public static function string_to_end_flag ( $string , $size )
    {
        if ( ! self::is_minlen_to_maxlen_string ( $string , $size , $size ) ) {
            throw new \Exception( ( "Encountered an error converting the string to a end flag! string format exception: " . print_r ( $string , true ) ) , 0 );
        }
        $_ret = strval ( $string );
        return $_ret;
    }

    public static function format_name_write ( $name , $size )
    {
        $_name = self::string_to_name ( $name , $size );
        return $_name;
    }

    public static function format_key_write ( $key )
    {
        $_key = self::dec_to_hex ( $key );
        if ( ( ! is_string ( $_key ) ) || ( strlen ( $_key ) != self::SIZE_INTEGER_SPACE ) ) {
            throw new \Exception( "Key type format error , key ( " . print_r ( $key , true ) . " ) , key type ( " . gettype ( $key ) . " ) " , 0 );
        }
        return $_key;
    }

    public static function format_size_write ( $size )
    {
        $_size = self::dec_to_hex ( $size );
        return $_size;
    }

    public static function format_status_write ( $status )
    {
        $_status = self::boolean_to_status ( $status );
        return $_status;
    }

    public static function format_mode_write ( $mode )
    {
        $_mode = self::oct_to_mode ( $mode );
        return $_mode;
    }

    public static function format_type_write ( $type )
    {
        $_type = self::integer_to_type ( $type );
        return $_type;
    }

    public static function format_offset_write ( $offset )
    {
        $_offset = self::integer_to_offset ( $offset );
        return $_offset;
    }

    public static function format_reserved_write ( $reserved , $size )
    {
        $_reserved = self::string_to_reserved ( $reserved , $size );
        return $_reserved;
    }

    public static function format_end_flag_write ( $end_flag , $size )
    {
        $_end_flag = self::string_to_end_flag ( $end_flag , $size );
        return $_end_flag;
    }

    public static function format_content_write ( $content , $size , $format_type = Interface_Base_FormatType::TYPE_FORMAT_STRING )
    {
        if ( $format_type == Interface_Base_FormatType::TYPE_FORMAT_INTEGER ) {
            $_content = self::dec_to_hex ( $content );
        } else if ( $format_type == Interface_Base_FormatType::TYPE_FORMAT_STRING ) {
            $_content = self::string_to_content ( $content , $size );
        } else {
            $_content = self::string_to_content ( $content , $size );
        }
        return $_content;
    }

    public static function format_resource_write ( $resource )
    {
        if ( ! is_resource ( $resource ) ) {
            throw new \Exception( "resource format is error , resource ( " . print_r ( $resource , true ) . " ) " , 0 );
        }
        $_integer = get_resource_id ( $resource );
        if ( ! self::is_min_to_max_integer ( $_integer , self::INTEGER_MIN_VALUE , self::INTEGER_MAX_VALUE ) ) {
            throw new \Exception( "resource_id format write is error , resource_id ( " . print_r ( $_integer , true ) . " ) " , 0 );
        }
        $_hex = self::dec_to_hex ( $_integer );
        return $_hex;
    }

    public static function format_object_write ( $object , $format = self::TYPE_OBJECT_SERIALIZE )
    {
        if ( $format == self::TYPE_OBJECT_SERIALIZE ) {
            $_string = serialize ( $object );
            return $_string;
        } else if ( $format == self::TYPE_OBJECT_JSON ) {
            $_string = json_encode ( $object );
            return $_string;
        } else {
            throw new \Exception( "object format is error , json ( " . print_r ( $object , true ) . " ) " , 0 );
        }
    }

    public static function format_socket_write ( $socket )
    {
        if ( is_resource ( $socket ) ) {
            return self::format_resource_write ( $socket );
        } else if ( is_object ( $socket ) && ( class_exists ( Interface_Base_ResourceType::TYPE_RESOURCE_SOCKET ) ) && ( ( $socket instanceof \Socket ) ) ) {
            $_data        = self::format_object_write ( $socket );
            $_data_length = strlen ( $_data );
            if ( $_data_length > self::HEX_MAX_LENGTH ) {
                throw new \Exception( "After serialization, the string length has exceeded the storage space limit , socket ( " . print_r ( $socket , true ) . " ) , string ( " . $_data . " ) , strlen ( " . $_data_length . " ) " , 0 );
            }
            $_data = self::string_to_data ( $_data , self::HEX_MAX_LENGTH );
            return $_data;
        } else {
            throw new \Exception( "socket format is error , socket ( " . print_r ( $socket , true ) . " ) " , 0 );
        }
    }

    public static function format_name_read ( $name )
    {
        $_name = strval ( $name );
        $_name = str_replace ( "\0" , "" , $_name );
        return $_name;
    }

    public static function format_key_read ( $key )
    {
        if ( ( ! is_string ( $key ) ) || ( strlen ( $key ) != self::SIZE_INTEGER_SPACE ) ) {
            throw new \Exception( "Key type format error , key ( " . print_r ( $key , true ) . " ) , key type ( " . gettype ( $key ) . " ) " , 0 );
        }
        $_key = self::hex_to_dec ( $key );
        return $_key;
    }

    public static function format_size_read ( $size )
    {
        if ( ( ! is_string ( $size ) ) || ( strlen ( $size ) != self::SIZE_INTEGER_SPACE ) ) {
            throw new \Exception( "size type format error , size ( " . print_r ( $size , true ) . " ) , size type ( " . gettype ( $size ) . " ) " , 0 );
        }
        $_size = self::hex_to_dec ( $size );
        return $_size;
    }

    public static function format_status_read ( $status )
    {
        $_status = intval ( $status );
        return $_status;
    }

    public static function format_mode_read ( $mode )
    {
        $_mode = intval ( $mode );
        return $_mode;
    }

    public static function format_type_read ( $type )
    {
        $_type = intval ( $type );
        return $_type;
    }

    public static function format_reserved_read ( $reserved )
    {
        $_reserved = strval ( $reserved );
        $_reserved = str_replace ( "\0" , "" , $_reserved );
        return $_reserved;
    }

    public static function format_offset_read ( $offset )
    {
        if ( ( ! is_string ( $offset ) ) || ( strlen ( $offset ) != self::SIZE_INTEGER_SPACE ) ) {
            throw new \Exception( "offset type format error , offset ( " . print_r ( $offset , true ) . " ) , offset type ( " . gettype ( $offset ) . " ) " , 0 );
        }
        $_offset = self::hex_to_dec ( $offset );
        return $_offset;
    }

    public static function format_end_flag_read ( $end_flag )
    {
        $_end_flag = strval ( $end_flag );
        $_end_flag = str_replace ( "\0" , "" , $_end_flag );
        return $_end_flag;
    }

    public static function format_content_read ( $content , $format_type = Interface_Base_FormatType::TYPE_FORMAT_STRING )
    {
        if ( $format_type == Interface_Base_FormatType::TYPE_FORMAT_INTEGER ) {
            $_content = self::hex_to_dec ( $content );
        } else if ( $format_type == Interface_Base_FormatType::TYPE_FORMAT_STRING ) {
            $_content = self::content_to_string ( $content );
        } else {
            $_content = self::content_to_string ( $content );
        }
        return $_content;
    }

    public static function format_resource_read ( $hex )
    {
        $_integer   = self::hex_to_dec ( $hex );
        $_resources = get_resources ();
        if ( empty( $_resources ) ) {
            throw new \Exception( "resources is empty , resources : " . print_r ( $_resources , true ) , 0 );
        }
        if ( ! is_array ( $_resources ) ) {
            throw new \Exception( "resources is not a array , resources : " . print_r ( $_resources , true ) , 0 );
        }
        if ( ! array_key_exists ( $_integer , $_resources ) ) {
            throw new \Exception( "resources ( " . $_integer . " ) is not a exist , resources : " . print_r ( $_resources , true ) , 0 );
        }
        if ( ! is_resource ( $_resources[ $_integer ] ) ) {
            throw new \Exception( "resource_id ( " . $_integer . " ) is not a resource , resources : " . print_r ( $_resources , true ) , 0 );
        }
        return $_resources[ $_integer ];
    }

    public static function format_object_read ( $encode_data , $format = self::TYPE_OBJECT_SERIALIZE )
    {
        if ( $format == self::TYPE_OBJECT_SERIALIZE ) {
            $encode_data = self::data_to_string ( $encode_data );
            $_object     = unserialize ( $encode_data );
            return $_object;
        } else if ( $format == self::TYPE_OBJECT_JSON ) {
            $encode_data = self::data_to_string ( $encode_data );
            if ( ! self::is_json ( $encode_data ) ) {
                throw new \Exception( "json string format is error , encode_json ( " . print_r ( $encode_data , true ) . " ) " , 0 );
            }
            $_json = json_decode ( $encode_data );
            if ( ( ! is_object ( $_json ) ) ) {
                throw new \Exception( "json object format is error , json ( " . print_r ( $_json , true ) . " ) " , 0 );
            }
            return $_json;
        } else {
            throw new \Exception( "object format is error , json ( " . print_r ( $encode_data , true ) . " ) " , 0 );
        }
    }

    public static function format_socket_read ( $encode_socket )
    {
        if ( self::is_minlen_to_maxlen_hex ( $encode_socket , self::HEX_MAX_LENGTH , self::HEX_MAX_LENGTH ) ) {
            return self::format_resource_read ( $encode_socket );
        } else if ( self::is_json ( $encode_socket ) ) {
            return self::format_object_read ( $encode_socket );
        } else {
            throw new \Exception( "encode socket format is error , encode_socket ( " . $encode_socket . " ) " , 0 );
        }
    }

    public static function path ( $path )
    {
        $_path = str_replace ( "\\" , "/" , $path );
        return $_path;
    }

    public static function check_pack_integer ( $integer )
    {
        if ( ! self::is_minlen_to_maxlen_integer ( $integer , self::INTEGER_MIN_LENGTH , self::INTEGER_MAX_LENGTH ) ) {
            throw new \Exception( "pack integer data is error , data : " . print_r ( $integer , true ) , 0 );
        }
    }

    public static function pack ( $data , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_format = self::DATA_FORMAT_STRING_NULL_FILL_PACK;
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            self::check_pack_integer ( $data );
            $_format = self::DATA_FORMAT_64_INTEGER_PACK;
            $data    = dechex ( $data );
        }
        $_pack_data = pack ( $_format , $data );
        return $_pack_data;
    }

    public static function unpack ( $pack_data , $format_type = self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK )
    {
        $_format = self::DATA_FORMAT_STRING_NULL_FILL_PACK;
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            $_format = self::DATA_FORMAT_64_INTEGER_PACK;
        }
        $_data = unpack ( $_format , $pack_data );
        if ( is_array ( $_data ) ) {
            $_data = $_data[ 1 ];
        }
        if ( $format_type == self::DATA_FORMAT_TYPE_64_INTEGER_PACK ) {
            $_data = hexdec ( $_data );
            if ( ! self::is_minlen_to_maxlen_integer ( $_data , self::INTEGER_MIN_LENGTH , self::INTEGER_MAX_LENGTH ) ) {
                throw new \Exception( "unpack integer data is error , data : " . print_r ( $_data , true ) , 0 );
            }
        }
        return $_data;
    }

    public static function encode ( $data )
    {
        $data = urlencode ( $data );
        $data = self::pack ( $data , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        $data = base64_encode ( $data );
        return $data;
    }

    public static function decode ( $data )
    {
        $data = base64_decode ( $data );
        $data = self::unpack ( $data , self::DATA_FORMAT_TYPE_STRING_NULL_FILL_PACK );
        $data = urldecode ( $data );
        return $data;
    }

    public static function ip_to_integer ( $ip )
    {
        $_integer = ip2long ( $ip );
        return $_integer;
    }

    public static function integer_to_ip ( $integer )
    {
        $_ip = long2ip ( $integer );
        return $_ip;
    }

    public static function ip_to_hex ( $ip )
    {
        $_integer = self::ip_to_integer ( $ip );
        $_hex     = self::dec_to_hex ( $_integer );
        return $_hex;
    }

    public static function hex_to_ip ( $hex )
    {
        $_integer = self::hex_to_dec ( $hex );
        $_ip      = self::integer_to_ip ( $_integer );
        return $_ip;
    }

    public static function port_to_hex ( $port )
    {
        $_hex = self::dec_to_hex ( $port );
        return $_hex;
    }

    public static function hex_to_port ( $hex )
    {
        $_port = self::hex_to_dec ( $hex );
        return $_port;
    }

    public static function format_ip_read ( $hex )
    {
        $_integer = self::hex_to_dec ( $hex );
        $_ip      = self::integer_to_ip ( $_integer );
        return $_ip;
    }

    public static function format_ip_write ( $ip )
    {
        $_integer = self::ip_to_integer ( $ip );
        $_hex     = self::dec_to_hex ( $_integer );
        return $_hex;
    }

    public static function format_port_read ( $hex )
    {
        $_port = self::hex_to_dec ( $hex );
        return $_port;
    }

    public static function format_port_write ( $port )
    {
        $_hex = self::dec_to_hex ( $port );
        return $_hex;
    }

    public static function is_socket ( $socket )
    {
        if ( ( is_resource ( $socket ) ) && ( get_resource_type ( $socket ) == Interface_Base_ResourceType::TYPE_RESOURCE_SOCKET ) ) {
            return true;
        }
        if ( ( is_object ( $socket ) ) && ( ( class_exists ( Interface_Base_ResourceType::TYPE_RESOURCE_SOCKET ) ) && ( $socket instanceof \Socket ) ) ) {
            return true;
        }
        return false;
    }

    public static function is_json ( $json )
    {
        if ( self::is_empty ( $json ) ) {
            return false;
        }
        $_left_brace             = "{";
        $_right_brace            = "}";
        $_left_bracket           = "[";
        $_right_bracket          = "]";
        $_left_brace_position    = stripos ( $json , $_left_brace );
        $_right_brace_position   = stripos ( $json , $_right_brace );
        $_left_bracket_position  = stripos ( $json , $_left_bracket );
        $_right_bracket_position = stripos ( $json , $_right_bracket );
        if ( ( false === $_left_brace_position ) && ( false === $_right_brace_position ) && ( false === $_left_bracket_position ) && ( false === $_right_bracket_position ) ) {
            return false;
        }
        if ( ( false !== $_left_brace_position ) && ( false === $_right_brace_position ) ) {
            return false;
        }
        if ( ( false !== $_right_brace_position ) && ( false === $_left_brace_position ) ) {
            return false;
        }
        if ( ( false !== $_left_bracket_position ) && ( false === $_right_bracket_position ) ) {
            return false;
        }
        if ( ( false !== $_right_bracket_position ) && ( false === $_left_bracket_position ) ) {
            return false;
        }
        if ( $_left_brace_position > $_right_brace_position ) {
            return false;
        }
        if ( $_left_bracket_position > $_right_bracket_position ) {
            return false;
        }
        try {
            json_decode ( $json , true );
            $_bool = ( JSON_ERROR_NONE === json_last_error () );
            return $_bool;
        } catch ( \Exception $e ) {
            return false;
        }
    }

    public static function format_message_read ( $message )
    {
        if ( is_null ( $message ) ) {
            return "";
        }
        $_message = str_replace ( "\r\n" , "" , $message );
        $_message = str_replace ( "\r" , "" , $_message );
        $_message = str_replace ( "\n" , "" , $_message );
        return $_message;
    }

    public static function format_package_bin_to_hex ( $package )
    {
        if ( ! is_string ( $package ) ) {
            $package = strval ( $package );
        }
        $package = bin2hex ( $package );
        return $package;
    }

    public static function format_ipv6_data_write ( $data , $format = "a*" )
    {
        $_data = pack ( $format , $data );
        return $_data;
    }

    public static function format_ipv6_data_read ( $data , $format = "a*" )
    {
        $_data = unpack ( $format , $data );
        if ( is_array ( $_data ) ) {
            $_data = $_data[ 1 ];
        }
        return $_data;
    }

    public static function ipv6_to_long6 ( $ipv6 )
    {
        if ( ( strlen ( $ipv6 ) > 3 ) && ( substr ( $ipv6 , - 3 , 3 ) == "/64" ) ) {
            $ipv6 = substr ( $ipv6 , 0 , ( strlen ( $ipv6 ) - 3 ) );
        }
        $_ipv6_bin_string = "";
        $_ipv6_bin        = inet_pton ( $ipv6 );
        for ( $_ipv6_bin_index = 15 ; $_ipv6_bin_index >= 0 ; $_ipv6_bin_index -- ) {
            $_ascii           = ord ( $_ipv6_bin[ $_ipv6_bin_index ] );
            $_ascii_bin       = str_pad ( decbin ( $_ascii ) , 8 , '0' , STR_PAD_LEFT );
            $_ipv6_bin_string = ( $_ascii_bin . $_ipv6_bin_string );
        }
        $_long6 = self::bin_string_to_dec ( $_ipv6_bin_string );
        return $_long6;
    }

    public static function long6_to_complete_ipv6 ( $long6 )
    {
        $_ipv6_bin_string = Class_Base_RawSocket::dec_to_bin_string ( $long6 );
        if ( strlen ( $_ipv6_bin_string ) < 128 ) {
            $_ipv6_bin_string = str_pad ( $long6 , 128 , "0" , STR_PAD_LEFT );
        }
        $_ipv6 = "";
        for ( $_ipv6_bin_index = 0 ; $_ipv6_bin_index <= 7 ; $_ipv6_bin_index ++ ) {
            $_16_bit_bin = substr ( $_ipv6_bin_string , ( $_ipv6_bin_index * 16 ) , 16 );
            $_hex        = dechex ( bindec ( $_16_bit_bin ) );
            if ( $_ipv6_bin_index < 7 ) {
                $_ipv6 .= $_hex . ":";
            } else {
                $_ipv6 .= $_hex;
            }
        }
        return $_ipv6;
    }

    public static function long6_to_ipv6 ( $long6 )
    {
        $_ipv6 = self::long6_to_complete_ipv6 ( $long6 );
        $_ipv6 = inet_ntop ( inet_pton ( $_ipv6 ) );
        return $_ipv6;
    }

    public static function dec_to_bin_string ( $integer )
    {
        if ( ( ! is_integer ( $integer ) ) && ( ! is_string ( $integer ) ) ) {
            throw new \Exception( ( "integer is error , integer : " . print_r ( $integer , true ) ) , 0 );
        }
        $_integer = $integer;
        $_tmp     = "";
        if ( is_integer ( $integer ) ) {
            while ( $_integer >= 1 ) {
                $_mod     = ( $_integer % 2 );
                $_tmp     .= $_mod;
                $_integer = $_integer / 2;
            }
        } else if ( is_string ( $integer ) ) {
            if ( ! Class_Base_Format::is_integer ( $integer ) ) {
                throw new \Exception( ( "integer is error , integer : " . print_r ( $integer , true ) ) , 0 );
            }
            while ( ( bccomp ( $_integer , 1 ) == 1 ) || ( bccomp ( $_integer , 1 ) == 0 ) ) {
                $_mod     = bcmod ( $_integer , 2 );
                $_tmp     .= $_mod;
                $_integer = bcdiv ( $_integer , 2 );
            }
        }
        $_tmp_length = strlen ( $_tmp );
        $_bin        = "";
        for ( $i = ( $_tmp_length - 1 ) ; $i >= 0 ; $i -- ) {
            $_bin .= substr ( $_tmp , $i , 1 );
        }
        $_bin_length = strlen ( $_bin );
        if ( $_bin_length < 8 ) {
            $_bin = str_pad ( $_bin , 8 , '0' , STR_PAD_LEFT );
        }
        if ( ( $_bin_length % 8 ) != 0 ) {
            for ( $i = 1 ; $i < 8 ; $i ++ ) {
                $_tmp = ( $_bin_length + $i );
                if ( ( $_tmp % 8 ) == 0 ) {
                    break;
                }
            }
            $_bin = str_pad ( $_bin , $_tmp , '0' , STR_PAD_LEFT );
        }
        return $_bin;
    }

    public static function bin_string_to_dec ( $string )
    {
        $_dec    = 0;
        $_strlen = strlen ( $string );
        $_j      = 0;
        for ( $i = ( $_strlen - 1 ) ; $i >= 0 ; $i -- ) {
            $_char     = substr ( $string , $i , 1 );
            $_char_dec = intval ( $_char );
            if ( $_strlen <= 64 ) {
                $_dec += ( $_char_dec * pow ( 2 , $_j ) );
            } else {
                if ( ! is_string ( $_dec ) ) {
                    $_dec = strval ( $_dec );
                }
                $_dec = bcadd ( $_dec , ( bcmul ( $_char_dec , bcpow ( 2 , $_j ) ) ) );
            }
            $_j ++;
        }
        return $_dec;
    }

    public static function bin_string_to_bin ( $string )
    {
        $_bin    = "";
        $_strlen = strlen ( $string );
        if ( ( $_strlen < 8 ) || ( ( $_strlen % 8 ) != 0 ) ) {
            throw new \Exception( ( "string is error , string : " . print_r ( $string , true ) ) , 0 );
        }
        for ( $i = 0 ; $i < $_strlen ; $i += 8 ) {
            $_str  = substr ( $string , $i , 8 );
            $_dec  = bindec ( $_str );
            $_char = chr ( $_dec );
            $_bin  .= $_char;
        }
        return $_bin;
    }

    public static function bin_to_bin_string ( $bin )
    {
        $_bin_string = "";
        $_bin_length = strlen ( $bin );
        for ( $i = 0 ; $i < $_bin_length ; $i += 1 ) {
            $_char     = substr ( $bin , $i , 1 );
            $_dec      = ord ( $_char );
            $_bin_char = decbin ( $_dec );
            if ( strlen ( $_bin_char ) < 8 ) {
                $_bin_char = str_pad ( $_bin_char , 8 , '0' , STR_PAD_LEFT );
            }
            $_bin_string .= $_bin_char;
        }
        return $_bin_string;
    }

    public static function format_ipv6_address_to_128_bit ( $ipv6 )
    {
        $_integer    = self::ipv6_to_long6 ( $ipv6 );
        $_bin_string = self::dec_to_bin_string ( $_integer );
        $_bin        = self::bin_string_to_bin ( $_bin_string );
        return $_bin;
    }

    public static function format_128_bit_to_ipv6_address ( $bin )
    {
        $_bin_string = self::bin_to_bin_string ( $bin );
        $_dec        = self::bin_string_to_dec ( $_bin_string );
        $_ipv6       = self::long6_to_ipv6 ( $_dec );
        return $_ipv6;
    }

    public static function htmlentities ( $string )
    {
        if ( ! is_string ( $string ) ) {
            $string = strval ( $string );
        }
        $_string = htmlentities ( $string );
        return $_string;
    }

    public static function action ( $action )
    {
        $_action = strval ( $action );
        if ( ! empty( $_action ) ) {
            if ( substr ( $_action , 0 , 1 ) != "/" ) {
                $_action = "/" . $_action;
            }
        }
        $_index_file_name = INDEX_FILE_URI;
        $_action          = $_index_file_name . '?url=' . $_action;
        return $_action;
    }

    public static function string_to_hexs_string ( $string )
    {
        $_hexs_string   = "";
        $_string_length = strlen ( $string );
        for ( $index = 0 ; $index < $_string_length ; $index ++ ) {
            $_hexs_string .= "\\x" . str_pad ( dechex ( ord ( substr ( $string , $index , 1 ) ) ) , 2 , '0' , STR_PAD_LEFT );
        }
        return $_hexs_string;
    }

    public static function hexs_string_to_string ( $hexs_string )
    {
        $_string    = "";
        $_hexs      = explode ( "\\x" , $hexs_string );
        $_hexs_size = count ( $_hexs );
        if ( $_hexs_size <= 1 ) {
            throw new \Exception( "Hexadecimal string format error , hexs : " . print_r ( $_hexs , true ) , 0 );
        }
        for ( $index = 1 ; $index < $_hexs_size ; $index ++ ) {
            if ( ! Class_Base_Format::is_minlen_to_maxlen_hex ( $_hexs[ $index ] , 2 , 2 ) ) {
                throw new \Exception( "Hexadecimal string format error , hex : " . ( $_hexs[ $index ] ) , 0 );
            }
            $_string .= chr ( hexdec ( $_hexs[ $index ] ) );
        }
        return $_string;
    }

    public static function map_to_list ( $map , $cols_size = 10 , $keyword = null )
    {
        if ( ( ! is_integer ( $cols_size ) ) || ( $cols_size < 1 ) ) {
            $cols_size = 1;
        }
        if ( ! is_array ( $map ) ) {
            throw new \Exception( ( "map is not a array , map : " . print_r ( $map , true ) ) , 0 );
        }
        if ( is_null ( $keyword ) ) {
            $keyword = "";
        }
        if ( ( ! is_string ( $keyword ) ) ) {
            $keyword = strval ( $keyword );
        }
        $_rows_index = 0;
        $_cols_index = 0;
        $_list       = array ();
        if ( $keyword != "" ) {
            foreach ( $map as $key => $value ) {
                if ( strpos ( strval ( $key ) , $keyword ) !== false ) {
                    if ( ! is_array ( $_list[ $_rows_index ] ) ) {
                        $_list[ $_rows_index ] = array ();
                    }
                    $_list[ $_rows_index ][ $key ] = $value;
                    $_cols_index ++;
                    if ( ( $_cols_index >= $cols_size ) && ( ( $_cols_index % $cols_size ) == 0 ) ) {
                        $_cols_index = 0;
                        $_rows_index ++;
                    }
                }
            }
        } else {
            foreach ( $map as $key => $value ) {
                if ( ! is_array ( $_list[ $_rows_index ] ) ) {
                    $_list[ $_rows_index ] = array ();
                }
                $_list[ $_rows_index ][ $key ] = $value;
                $_cols_index ++;
                if ( ( $_cols_index >= $cols_size ) && ( ( $_cols_index % $cols_size ) == 0 ) ) {
                    $_cols_index = 0;
                    $_rows_index ++;
                }
            }
        }
        return $_list;
    }

    public static function set_page_params ( $total , &$page , &$page_size , &$max_page )
    {
        if ( ! is_integer ( $page ) ) {
            throw new \Exception( ( "page is not a integer , page : " . print_r ( $page , true ) ) , 0 );
        }
        if ( ! is_integer ( $page_size ) ) {
            throw new \Exception( ( "page_size is not a integer , page_size : " . print_r ( $page_size , true ) ) , 0 );
        }
        if ( ! is_integer ( $max_page ) ) {
            throw new \Exception( ( "max_page is not a integer , max_page : " . print_r ( $page , true ) ) , 0 );
        }
        if ( $page < 1 ) {
            $page = 1;
        }
        if ( $page_size < 1 ) {
            $page_size = 1;
        }
        if ( $page_size > $total ) {
            $page_size = $total;
        }
        if ( $max_page < 1 ) {
            $max_page = 1;
        }
        if ( $total > $page_size ) {
            if ( ( $total % $page_size ) == 0 ) {
                $max_page = ( $total / $page_size );
            } else {
                $max_page = ( ( $total / $page_size ) + 1 );
            }
        }
        if ( $page > $max_page ) {
            $page = $max_page;
        }
        $max_page = ( intval ( $max_page ) );
    }

    public static function list_to_page_list ( $list , &$page , &$page_size , &$max_page )
    {
        if ( ! is_array ( $list ) ) {
            throw new \Exception( ( "list is not a array , list : " . print_r ( $list , true ) ) , 0 );
        }
        if ( ! is_integer ( $page ) ) {
            throw new \Exception( ( "page is not a integer number , page : " . print_r ( $page , true ) ) , 0 );
        }
        if ( ! is_integer ( $page_size ) ) {
            throw new \Exception( ( "page_size is not a integer number , page_size : " . print_r ( $page_size , true ) ) , 0 );
        }
        $_page_list = array ();
        $_list_size = count ( $list );
        if ( $page < 1 ) {
            $page = 1;
        }
        if ( $page_size < 1 ) {
            $page_size = 1;
        }
        if ( $page_size > $_list_size ) {
            $page_size = $_list_size;
        }
        if ( $max_page < 1 ) {
            $max_page = 1;
        }
        if ( $_list_size > $page_size ) {
            if ( ( $_list_size % $page_size ) == 0 ) {
                $max_page = ( $_list_size / $page_size );
            } else {
                $max_page = ( ( $_list_size / $page_size ) + 1 );
            }
        }
        $max_page = ( intval ( $max_page ) );
        if ( $page > $max_page ) {
            $page = $max_page;
        }
        $_row_offset       = ( $page_size * ( $page - 1 ) );
        $_row_offset_limit = ( ( $page_size * ( $page - 1 ) ) + $page_size );
        for ( $list_index = $_row_offset ; $list_index < $_list_size ; $list_index ++ ) {
            if ( $list_index >= $_row_offset_limit ) {
                break;
            }
            $_page_list[] = $list[ $list_index ];
        }
        return $_page_list;
    }

    public static function page_list_to_page_link_list ( $page_list , $action )
    {
        $_page_link_list = array ();
        foreach ( $page_list as $index => $item ) {
            $_page_link_list[] = array ( "link" => Class_Base_Response::get_url ( $action , $item ) , "item" => $item );
        }
        return $_page_link_list;
    }

    public static function memory_page_list_to_memory_page_link_list ( $page_list , $action )
    {
        $_page_link_list = array ();
        foreach ( $page_list as $index => $item ) {
            $_page_link_list[ $index ] = $item;
            foreach ( $item as $k => $v ) {
                $_page_link_list[ $index ][ $k ] = array (
                    "link"  => Class_Base_Response::get_url ( $action , array ( "key" => $k ) ) ,
                    "value" => $v ,
                );
            }
        }
        return $_page_link_list;
    }

    public static function get_bin_content_size ( $file_content , $data_type = self::TYPE_DATA_BIN )
    {
        $_file_content_size = 0;
        if ( ! is_string ( $file_content ) ) {
            throw new \Exception( "The data content is not a valid string" , 0 );
        }
        if ( ! is_integer ( $data_type ) ) {
            throw new \Exception( "The data type is not a valid integer number" , 0 );
        }
        if ( $data_type == self::TYPE_DATA_TEXT ) {
            $_file_content_size = strlen ( $file_content );
        } else if ( $data_type == self::TYPE_DATA_BIN ) {
            $_string_length = strlen ( $file_content );
            for ( $index = 0 ; $index < $_string_length ; $index += 4 ) {
                $_hex = substr ( $file_content , $index , 4 );
                if ( strlen ( $_hex ) == 4 ) {
                    if ( substr ( $file_content , 0 , 2 ) == "\x" ) {
                        if ( Class_Base_Format::is_minlen_to_maxlen_hex ( substr ( $file_content , 2 , 2 ) , 2 , 2 ) ) {
                            $_file_content_size ++;
                        }
                    }
                }
            }
        } else {
            throw new \Exception( "The data type is not within the acceptable range" , 0 );
        }
        return $_file_content_size;
    }

    public static function get_bin_content ( $file_content , $data_type = self::TYPE_DATA_BIN )
    {
        $_file_content = "";
        if ( ! is_string ( $file_content ) ) {
            throw new \Exception( "The data content is not a valid string" , 0 );
        }
        if ( ! is_integer ( $data_type ) ) {
            throw new \Exception( "The data type is not a valid integer number" , 0 );
        }
        if ( $data_type == self::TYPE_DATA_TEXT ) {
            $_file_content = $file_content;
        } else if ( $data_type == self::TYPE_DATA_BIN ) {
            $_string_length = strlen ( $file_content );
            for ( $index = 0 ; $index < $_string_length ; $index += 4 ) {
                $_hex = substr ( $file_content , $index , 4 );
                if ( strlen ( $_hex ) == 4 ) {
                    $_hex_0_2 = substr ( $_hex , 0 , 2 );
                    $_hex_2_4 = substr ( $_hex , 2 , 2 );
                    if ( $_hex_0_2 == '\x' ) {
                        if ( Class_Base_Format::is_minlen_to_maxlen_hex ( $_hex_2_4 , 2 , 2 ) ) {
                            $_char         = chr ( hexdec ( $_hex_2_4 ) );
                            $_file_content .= $_char;
                        }
                    }
                }
            }
        } else {
            throw new \Exception( "The data type is not within the acceptable range" , 0 );
        }
        return $_file_content;
    }

    public static function get_format_hex_content ( $bin_content )
    {
        if ( is_string ( $bin_content ) ) {
            $_bin_content_length = strlen ( $bin_content );
            $_return_content     = "";
            for ( $index = 0 ; $index < $_bin_content_length ; $index ++ ) {
                $_return_content .= ( '\x' . ( str_pad ( dechex ( ord ( substr ( $bin_content , $index , 1 ) ) ) , 2 , '0' , STR_PAD_LEFT ) ) );
            }
            return $_return_content;
        }
        return false;
    }

    public static function get_format_hex_content_size ( $format_hex_content )
    {
        if ( ! is_string ( $format_hex_content ) ) {
            throw new \Exception( "The binary content is not a valid string" , 0 );
        }
        if ( strlen ( $format_hex_content ) > 1024 * 1024 * 10 ) {
            throw new \Exception( "The data volume is too large to calculate the data size in real-time" , 0 );
        }
        $_format_hex_content_size = self::get_bin_content_size ( $format_hex_content , self::TYPE_DATA_BIN );
        return $_format_hex_content_size;
    }

    public static function filter_file_name_special_symbols ( $file_name )
    {
        $_file_name        = "";
        $_file_name_length = strlen ( $file_name );
        for ( $index = 0 ; $index < $_file_name_length ; $index ++ ) {
            $_file_name_index_char = substr ( $file_name , $index , 1 );
            if ( in_array ( $_file_name_index_char , self::$_file_name_conventional_matchings ) ) {
                $_file_name .= $_file_name_index_char;
            }
        }
        return $_file_name;
    }

    public static function is_user_name ( $user )
    {
        return false;
    }

    public static function is_user_password ( $password )
    {
        return false;
    }

    public static function is_domain_name ( $domain )
    {
        return false;
    }

    public static function is_database_name ( $database )
    {
        return false;
    }

    public static function is_table_name ( $table )
    {
        return false;
    }

    public static function is_ipv4_address ( $ipv4 )
    {
        $_bool = filter_var ( $ipv4 , FILTER_VALIDATE_IP , FILTER_FLAG_IPV4 );
        return $_bool;
    }

    public static function is_ipv6_address ( $ipv6 )
    {
        $_bool = filter_var ( $ipv6 , FILTER_VALIDATE_IP , FILTER_FLAG_IPV6 );
        return $_bool;
    }

    public static function is_ip_address ( $ip )
    {
        $_bool = filter_var ( $ip , FILTER_VALIDATE_IP , ( FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 ) );
        return $_bool;
    }

    public static function show_format_hex_number ( $hex )
    {
        $_hex = ( ( '0x' ) . str_pad ( $hex , 16 , self::CHAR_ZERO , STR_PAD_LEFT ) );
        return $_hex;
    }

    public static function array_to_string ( $array )
    {
        $_return = "";
        if ( is_array ( $array ) || ( is_object ( $array ) ) ) {
            foreach ( $array as $key => $value ) {
                $_return .= ( print_r ( $value , true ) . ( chr ( 10 ) ) );
            }
        }
        return $_return;
    }

}