<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-18
 * Time: 下午4:54
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

class Class_Base_Security_Rsa extends Class_Base implements Interface_Base_Security_Rsa
{
    public static function construct ( $private_key = null , $public_key = null )
    {
        $_keys = array ();
        if ( is_string ( $private_key ) ) {
            $pem                             = chunk_split ( $private_key , 64 , "\n" );
            $pem                             = "-----BEGIN PRIVATE KEY-----\n" . $pem . "-----END PRIVATE KEY-----\n";
            $_keys[ "private_key_resource" ] = openssl_pkey_get_private ( $pem );
        }
        if ( is_string ( $public_key ) ) {
            $pem                            = chunk_split ( $public_key , 64 , "\n" );
            $pem                            = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
            $_keys[ "public_key_resource" ] = openssl_pkey_get_public ( $pem );
        }
        return $_keys;
    }

    public static function destruct ( $private_key_resource , $public_key_resource )
    {
        if ( is_resource ( $private_key_resource ) ) {
            @openssl_free_key ( $private_key_resource );
        }
        if ( is_resource ( $public_key_resource ) ) {
            @openssl_free_key ( $public_key_resource );
        }
    }

    /**
     * * setup the private key
     */
    public static function create_private_key_resource ( $private_key )
    {
        if ( ! is_string ( $private_key ) ) {
            return null;
        }
        $pem                   = chunk_split ( $private_key , 64 , "\n" );
        $pem                   = "-----BEGIN PRIVATE KEY-----\n" . $pem . "-----END PRIVATE KEY-----\n";
        $_private_key_resource = openssl_pkey_get_private ( $pem );
        return $_private_key_resource;
    }

    /**
     * * setup the public key
     */
    public static function create_public_key_resource ( $public_key )
    {
        if ( ! is_string ( $public_key ) ) {
            return null;
        }
        $pem                  = chunk_split ( $public_key , 64 , "\n" );
        $pem                  = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
        $_public_key_resource = openssl_pkey_get_public ( $pem );
        return $_public_key_resource;
    }

    /**
     * * encrypt with the private key
     */
    public static function private_encode ( $public_decode_data , $private_key_resource )
    {
        if ( ! is_string ( $public_decode_data ) ) {
            return null;
        }
        if ( ( ! is_resource ( $private_key_resource ) ) && ( ! is_object ( $private_key_resource ) ) ) {
            return null;
        }
        $r = openssl_private_encrypt ( $public_decode_data , $private_encode_data , $private_key_resource );
        if ( $r ) {
            return base64_encode ( $private_encode_data );
        }
        return null;
    }

    /**
     * * decrypt with the private key
     */
    public static function private_decode ( $public_encode_data , $private_key_resource )
    {
        if ( ! is_string ( $public_encode_data ) ) {
            return null;
        }
        if ( ( ! is_resource ( $private_key_resource ) ) && ( ! is_object ( $private_key_resource ) ) ) {
            return null;
        }
        $public_encode_data = base64_decode ( $public_encode_data );
        $r                  = openssl_private_decrypt ( $public_encode_data , $private_decode_data , $private_key_resource );
        if ( $r ) {
            return $private_decode_data;
        }
        return null;
    }

    /**
     * * encrypt with public key
     */
    public static function public_encode ( $private_decode_data , $public_key_resource )
    {
        if ( ! is_string ( $private_decode_data ) ) {
            return null;
        }
        if ( ( ! is_resource ( $public_key_resource ) ) && ( ! is_object ( $public_key_resource ) ) ) {
            return null;
        }
        $r = openssl_public_encrypt ( $private_decode_data , $public_encode_data , $public_key_resource );
        if ( $r ) {
            return base64_encode ( $public_encode_data );
        }
        return null;
    }

    /**
     * * decrypt with the public key
     */
    public static function public_decode ( $private_encode_data , $public_key_resource )
    {
        if ( ! is_string ( $private_encode_data ) ) {
            return null;
        }
        if ( ( ! is_resource ( $public_key_resource ) ) && ( ! is_object ( $public_key_resource ) ) ) {
            return null;
        }
        $private_encode_data = base64_decode ( $private_encode_data );
        $r                   = openssl_public_decrypt ( $private_encode_data , $public_decode_data , $public_key_resource );
        if ( $r ) {
            return $public_decode_data;
        }
        return null;
    }

    public static function sign ( $data , $private_key_resource )
    {
        if ( ( ! is_resource ( $private_key_resource ) ) && ( ! is_object ( $private_key_resource ) ) ) {
            return null;
        }
        $signature = false;
        openssl_sign ( $data , $signature , $private_key_resource );
        return base64_encode ( $signature );
    }

    public static function verify ( $data , $sign , $public_key_resource )
    {
        if ( ( ! is_resource ( $public_key_resource ) ) && ( ! is_object ( $public_key_resource ) ) ) {
            return null;
        }
        $signature = base64_decode ( $sign );
        $flag      = openssl_verify ( $data , $signature , $public_key_resource );
        return $flag;
    }

}
