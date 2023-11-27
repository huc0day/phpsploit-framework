<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23_1_24
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

class Class_Base_RawSocket extends Class_Base implements Interface_Base_RawSocket
{
    const KEY_LOCAL_DOCKER         = "127.0.0.1:0_127.0.0.1:0";
    const DOMAIN_IPV4              = AF_INET;
    const DOMAIN_IPV6              = AF_INET6;
    const TYPE_RAW                 = SOCK_RAW;
    const PROTOCOL_IP              = 0;
    const PROTOCOL_ICMP            = 1;
    const PROTOCOL_IGMP            = 2;
    const PROTOCOL_GGP             = 3;
    const PROTOCOL_IPENCAP         = 4;
    const PROTOCOL_ST              = 5;
    const PROTOCOL_TCP             = 6;
    const PROTOCOL_EGP             = 8;
    const PROTOCOL_IGP             = 9;
    const PROTOCOL_PUP             = 12;
    const PROTOCOL_UDP             = 17;
    const PROTOCOL_HMP             = 20;
    const PROTOCOL_XNS_IDP         = 22;
    const PROTOCOL_RDP             = 27;
    const PROTOCOL_ISO_TP4         = 29;
    const PROTOCOL_DCCP            = 33;
    const PROTOCOL_XTP             = 36;
    const PROTOCOL_DDP             = 37;
    const PROTOCOL_IDPR_CMTP       = 38;
    const PROTOCOL_IPV6            = 41;
    const PROTOCOL_IPV6_ROUTE      = 43;
    const PROTOCOL_IPV6_FRAG       = 44;
    const PROTOCOL_IDRP            = 45;
    const PROTOCOL_RSVP            = 46;
    const PROTOCOL_GRE             = 47;
    const PROTOCOL_ESP             = 50;
    const PROTOCOL_AH              = 51;
    const PROTOCOL_SKIP            = 57;
    const PROTOCOL_IPV6_ICMP       = 58;
    const PROTOCOL_IPV6_NONXT      = 59;
    const PROTOCOL_IPV6_OPTS       = 60;
    const PROTOCOL_RSPF            = 73;
    const PROTOCOL_VMTP            = 81;
    const PROTOCOL_EIGRP           = 88;
    const PROTOCOL_OSPF            = 89;
    const PROTOCOL_AX_25           = 93;
    const PROTOCOL_IPIP            = 94;
    const PROTOCOL_ETHERIP         = 97;
    const PROTOCOL_ENCAP           = 98;
    const PROTOCOL_PIM             = 103;
    const PROTOCOL_IPCOMP          = 108;
    const PROTOCOL_VRRP            = 112;
    const PROTOCOL_L2TP            = 115;
    const PROTOCOL_ISIS            = 124;
    const PROTOCOL_SCTP            = 132;
    const PROTOCOL_FC              = 133;
    const PROTOCOL_MOBILITY_HEADER = 135;
    const PROTOCOL_UDPLITE         = 136;
    const PROTOCOL_MPLS_IN_IP      = 137;
    const PROTOCOL_MANET           = 138;
    const PROTOCOL_HIP             = 139;
    const PROTOCOL_SHIM6           = 140;
    const PROTOCOL_WESP            = 141;
    const PROTOCOL_ROHC            = 142;

    const ADDRESS_IPV6_INTERNAL               = "::1";
    const ADDRESS_IPV6_PUBLIC_DOCKER_DEFAULT  = "2001:db8:1::242:ac11:2";
    const ADDRESS_IPV6_PRIVATE_DOCKER_DEFAULT = "fe80::42:acff:fe11:2";
    const ADDRESS_IPV4_INTERNAL               = "127.0.0.1";
    const ADDRESS_IPV4_PUBLIC_DOCKER_DEFAULT  = "172.17.0.2";
    const ADDRESS_IPV4_PRIVATE_DOCKER_DEFAULT = "127.0.0.1";

    const SIZE_RECEIVE_BYTE_MAX = 1024;

    const SIZE_BIT_IPV6_HEAD_VERSION             = 4;
    const SIZE_BIT_IPV6_HEAD_TRAFFIC             = 8;
    const SIZE_BIT_IPV6_FLOW_LABEL               = 20;
    const SIZE_BIT_IPV6_HEAD_PAYLOAD_LENGTH      = 16;
    const SIZE_BIT_IPV6_HEAD_NEXT_HEADER         = 8;
    const SIZE_BIT_IPV6_HEAD_HOP_LIMIT           = 8;
    const SIZE_BIT_IPV6_HEAD_SOURCE_ADDRESS      = 128;
    const SIZE_BIT_IPV6_HEAD_DESTINATION_ADDRESS = 128;

    const SIZE_BYTE_IPV6      = 1024;
    const SIZE_BYTE_IPV6_HEAD = 40;
    const SIZE_BYTE_IPV6_DATA = 984;

    const SIZE_BYTE_BIT_IPV6_0_TO_1023   = 1024;
    const SIZE_BYTE_BIT_IPV6_0_TO_31     = 4;
    const SIZE_BYTE_BIT_IPV6_32_TO_63    = 4;
    const SIZE_BYTE_BIT_IPV6_64_TO_191   = 16;
    const SIZE_BYTE_BIT_IPV6_192_TO_319  = 16;
    const SIZE_BYTE_BIT_IPV6_320_TO_8191 = 984;

    const SIZE_BIT_IPV6      = 8192;
    const SIZE_BIT_IPV6_HEAD = 320;
    const SIZE_BIT_IPV6_DATA = 7872;

    const SIZE_BIT_IPV6_0_TO_8191   = 8192;
    const SIZE_BIT_IPV6_0_TO_31     = 32;
    const SIZE_BIT_IPV6_32_TO_63    = 32;
    const SIZE_BIT_IPV6_64_TO_191   = 128;
    const SIZE_BIT_IPV6_192_TO_319  = 128;
    const SIZE_BIT_IPV6_320_TO_8191 = 7872;

    const SIZE_BIT_IPV6_0_TO_3   = 4;
    const SIZE_BIT_IPV6_4_TO_11  = 8;
    const SIZE_BIT_IPV6_12_TO_31 = 20;
    const SIZE_BIT_IPV6_32_TO_47 = 16;
    const SIZE_BIT_IPV6_48_TO_55 = 8;
    const SIZE_BIT_IPV6_56_TO_63 = 8;

    const VALUE_BIT_IPV6_HEAD_PAYLOAD_LENGTH      = 0b0000001111011000;
    const VALUE_BIT_IPV6_HEAD_NEXT_HEADER         = 0b10011001;
    const VALUE_BIT_IPV6_HEAD_HOP_LIMIT           = 0b11111111;
    const VALUE_BIT_IPV6_HEAD_SOURCE_ADDRESS      = self::ADDRESS_IPV6_INTERNAL;
    const VALUE_BIT_IPV6_HEAD_DESTINATION_ADDRESS = self::ADDRESS_IPV6_INTERNAL;

    const EXCEPTION_MESSAGE_CONNECT_QUIT = "connect is exit";
    const EXCEPTION_MESSAGE_CONNECT_EXIT = "connect service is exit";
    const EXCEPTION_BREAK                = 1;

    const TEST_DOCKER_RUN_CLI_LOCALHOST       = 'sudo docker run -p 40668:40668 -p 40022:22 -p 40080:80 -p 43306:3306 -e MYSQL_PASS="" --ip6 --fixed-cidr-v6  --security-opt seccomp=unconfined -it kali:v1.1 /bin/bash';
    const TEST_WIRESHARK_FILTER_LOCALHOST     = "((ipv6.addr==0:0:0:0:0:0:0:1) or (ipv6.addr==2001:db8:1::242:ac11:1/64) or (ipv6.addr==2001:db8:1::242:ac11:2/64) or(ipv6.addr==2001:db8:1::242:ac11:3/64) or (ipv6.addr==2001:db8:1::242:ac11:4/64) or (ipv6.addr==fe80::42:72ff:fea9:50c1/64)) and (ipv6) and (not icmpv6)";
    const TEST_TCPDUMP_FILTER_LOCALHOST_LO    = "tcpdump -i lo -vnn ip6";
    const TEST_TCPDUMP_FILTER_LOCALHOST_ETH0  = "tcpdump -i eth0 -vnn ip6";
    const TEST_TCPDUMP_FILTER_LOCALHOST_WLAN0 = "tcpdump -i wlan0 -vnn ip6";

    private static $_sockets = array ();

    public static function get_icmp_socket ( $key , $domain = self::DOMAIN_IPV4 , $protocol = self::PROTOCOL_ICMP )
    {
        if ( empty( self::$_sockets[ $key ] ) || ( ( ! is_resource ( self::$_sockets[ $key ] ) ) && ( ( ! is_object ( self::$_sockets[ $key ] ) ) || ( ! ( self::$_sockets[ $key ] instanceof \Socket ) ) ) ) ) {
            self::$_sockets[ $key ] = socket_create ( $domain , self::TYPE_RAW , $protocol );
            if ( self::$_sockets[ $key ] === false ) {
                $_error_code    = socket_last_error ();
                $_error_message = socket_strerror ( $_error_code );
                throw new \Exception( $_error_message , $_error_code );
            }
        }
        return self::$_sockets[ $key ];
    }

    public static function select_icmp_socket ( $key , $timeout = 6 )
    {
        $_socket = self::get_icmp_socket ( $key );
        $_read   = array ( $_socket );//初始化socket
        $_write  = array ( $_socket );
        $_except = array ( $_socket );
        $_select = socket_select ( $_read , $_write , $_except , $timeout );
        if ( $_select === false ) {
            $_error_code    = socket_last_error ();
            $_error_message = socket_strerror ( $_error_code );
            self::clear_icmp_socket ( $key );
            throw new \Exception( $_error_message , $_error_code );
        } else if ( $_select === 0 ) {
            self::clear_icmp_socket ( $key );
            throw new \Exception( "sockets [ " . $key . " ] select request is time out" , $_select );
        }
        $_return = array ( "read" => $_read , "write" => $_write , "except" => $_except , "select" => $_select );
        return $_return;
    }

    public static function clear_icmp_socket ( $key )
    {
        $_socket = self::get_icmp_socket ( $key );
        @socket_close ( $_socket );
        self::$_sockets[ $key ] = null;
        unset( self::$_sockets[ $key ] );
    }

    private static function _create_icmp_data_package_header ()
    {
        $_mode                      = ( chr ( 8 ) . chr ( 0 ) );
        $_checksum                  = ( chr ( 0 ) . chr ( 0 ) );
        $_id                        = ( "RC" );
        $_seq                       = ( chr ( 0 ) . chr ( 1 ) );
        $_header                    = ( $_mode . $_checksum . $_id . $_seq );
        $_header_size               = strlen ( $_header );
        $_fill_in_placeholders_size = 64;
        $_fill_in_placeholders      = "";
        for ( $fill_in_placeholders_index = $_header_size ; $fill_in_placeholders_index < $_fill_in_placeholders_size ; $fill_in_placeholders_index ++ ) {
            $_fill_in_placeholders .= chr ( 0 );
        }
        $_package_header = "";
        $_package_header .= $_header;
        $_package_header .= $_fill_in_placeholders;
        return $_package_header;
    }

    public static function create_icmp_data_package ()
    {
        $_package_header      = self::_create_icmp_data_package_header ();
        $_checksum            = self::create_checksum ( $_package_header );
        $_package_header[ 2 ] = ( $_checksum[ 0 ] );
        $_package_header[ 3 ] = ( $_checksum[ 1 ] );
        $_package             = ( $_package_header );
        return $_package;
    }

    public static function send_icmp_data_package ( $key , $package , $host = "127.0.0.1" , $flags = 0 , $port = 0 )
    {
        $_socket       = self::get_icmp_socket ( $key );
        $_package_size = strlen ( $package );
        $_length       = socket_sendto ( $_socket , $package , $_package_size , $flags , $host , $port );
        if ( $_length === false ) {
            $_error_code    = socket_last_error ();
            $_error_message = socket_strerror ( $_error_code );
            throw new \Exception( $_error_message , $_error_code );
        }
        return $_length;
    }

    public static function receive_icmp_data_package ( $key , &$data , $host = "127.0.0.1" , $receive_size = 65535 , $flags = 0 , $port = 0 , $unpack = 0 )
    {
        $_socket = self::get_icmp_socket ( $key );
        $_length = socket_recvfrom ( $_socket , $data , $receive_size , $flags , $host , $port );
        if ( $_length === false ) {
            $_error_code    = socket_last_error ();
            $_error_message = socket_strerror ( $_error_code );
            throw new \Exception( $_error_message , $_error_code );
        }
        if ( ! empty( $unpack ) ) {
            $data = unpack ( "C*" , $data );
        }
        return $_length;
    }

    public static function format_receive_icmp_data_for_ping ( $receive_data )
    {
        $_format_receive_data = array (
            "receive_data_content_size" => 0 ,
            "ttl"                       => 0 ,
            "seq"                       => 0 ,
        );
        if ( ( ! empty( $receive_data ) ) && ( is_array ( $receive_data ) ) ) {
            $_format_receive_data[ "receive_data_content_size" ] = ( count ( $receive_data ) - 20 );
            $_format_receive_data[ "ttl" ]                       = intval ( $receive_data[ 9 ] );
            $_format_receive_data[ "seq" ]                       = intval ( $receive_data[ 28 ] );
        }
        return $_format_receive_data;
    }

    public static function create_checksum ( $package )
    {
        $_tmp      = unpack ( "n*" , $package );
        $_sum      = array_sum ( $_tmp );
        $_sum      = ( ( $_sum >> 16 ) + ( $_sum & 0xFFFF ) );
        $_sum      = ( $_sum + ( $_sum >> 16 ) );
        $_sum      = ( ~$_sum );
        $_checksum = pack ( "n*" , $_sum );
        return $_checksum;
    }

    public static function long4_to_ipv4 ( $long4 )
    {
        $_long = ( 4294967295 - ( $long4 - 1 ) );
        $_long = long2ip ( - $_long );
        return $_long;
    }

    public static function ipv4_to_long4 ( $ipv4 )
    {
        $_ipv4 = sprintf ( "%u" , ip2long ( $ipv4 ) );
        return $_ipv4;
    }

    public static function ping ( $host = "127.0.0.1" , $timeout = 6 , $connect_domain_List_id = "connect_domain_list_id" )
    {
        self::get_icmp_socket ( $host );
        self::select_icmp_socket ( $host , $timeout );
        $_start_time          = microtime ();
        $_package             = self::create_icmp_data_package ();
        $_send_length         = self::send_icmp_data_package ( $host , $_package , $host , 0 , 0 );
        $_receive_length      = self::receive_icmp_data_package ( $host , $_receive_data , $host , 65535 , 0 , 0 , 1 );
        $_format_receive_data = self::format_receive_icmp_data_for_ping ( $_receive_data );
        self::clear_icmp_socket ( $host );
        $_end_time  = microtime ();
        $_exec_time = intval ( ( $_end_time - $_start_time ) * 1000 );
        if ( ! is_cli () ) {
            Class_Base_Response::output_textarea_inner_html ( $connect_domain_List_id , ( "receive " . $_format_receive_data[ "receive_data_content_size" ] . " bytes data from " . $host . " , seq ( " . $_format_receive_data[ "seq" ] . " )  , ttl ( " . $_format_receive_data[ "ttl" ] . " ) , response time ( " . $_exec_time . " ) ms" ) , Class_Base_Response::FLAG_JS_CONTENT_INNER_HTML_APPEND );
        } else {
            Class_Base_Response::outputln ( "\n" . ( "receive " . $_format_receive_data[ "receive_data_content_size" ] . " bytes data from " . $host . " , seq ( " . $_format_receive_data[ "seq" ] . " )  , ttl ( " . $_format_receive_data[ "ttl" ] . " ) , response time ( " . $_exec_time . " ) ms" ) . "\n" );
        }
    }

    public static function dec_to_bin_string ( $integer )
    {
        if ( ( ! is_integer ( $integer ) ) && ( ! is_string ( $integer ) ) ) {
            throw new \Exception( ( "integer is neither a number nor a string , integer : " . print_r ( $integer , true ) ) , 0 );
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
                throw new \Exception( ( "integer is not a integer number , integer : " . print_r ( $integer , true ) ) , 0 );
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
            throw new \Exception( ( "string is error , stirng : " . print_r ( $string , true ) ) , 0 );
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

    public static function create_ipv6_data_package ( $src_ip = "2001:db8:1::242:ac11:2" , $dst_ip = "2001:db8:1::242:ac11:2" , $data = null )
    {
        $_128_bit_src = self::format_ipv6_address_to_128_bit ( $src_ip );
        $_128_bit_dst = self::format_ipv6_address_to_128_bit ( $dst_ip );

        $_head_version_traffic_flow_label = chr ( 0b01100000 ) . chr ( 0b00000000 ) . chr ( 0b00000000 ) . chr ( 0b00000000 );
        $_head_payload_length             = self::VALUE_BIT_IPV6_HEAD_PAYLOAD_LENGTH;
        $_head_next_header                = chr ( self::VALUE_BIT_IPV6_HEAD_NEXT_HEADER );
        $_head_hop_limit                  = chr ( self::VALUE_BIT_IPV6_HEAD_HOP_LIMIT );
        $_head_source_address             = $_128_bit_src;
        $_head_destination__address       = $_128_bit_dst;

        if ( ! is_string ( $data ) ) {
            if ( is_integer ( $data ) ) {
                $data = strval ( $data );
            } else {
                $data = str_repeat ( chr ( 0 ) , self::SIZE_BYTE_IPV6_DATA );
            }
        }
        $_data_length = strlen ( $data );
        if ( $_data_length < self::SIZE_BYTE_IPV6_DATA ) {
            $data = str_pad ( $data , self::SIZE_BYTE_IPV6_DATA , chr ( 0 ) , STR_PAD_RIGHT );
        }
        if ( $_data_length > self::SIZE_BYTE_IPV6_DATA ) {
            $data = substr ( $data , 0 , self::SIZE_BYTE_IPV6_DATA );
        }
        $_package = "";
        $_package .= self::format_ipv6_data_write ( $_head_version_traffic_flow_label , "a*" );
        $_package .= self::format_ipv6_data_write ( $_head_payload_length , "n*" );
        $_package .= self::format_ipv6_data_write ( $_head_next_header );
        $_package .= self::format_ipv6_data_write ( $_head_hop_limit );
        $_package .= $_head_source_address;
        $_package .= $_head_destination__address;
        $_package .= self::format_ipv6_data_write ( $data );
        return $_package;
    }

    public static function get_ipv6_socket ( $key )
    {
        if ( empty( self::$_sockets[ $key ] ) || ( ( ! is_resource ( self::$_sockets[ $key ] ) ) && ( ( ! is_object ( self::$_sockets[ $key ] ) ) || ( ! ( self::$_sockets[ $key ] instanceof \Socket ) ) ) ) ) {
            self::$_sockets[ $key ] = socket_create ( self::DOMAIN_IPV6 , self::TYPE_RAW , self::PROTOCOL_IPV6 );
            if ( self::$_sockets[ $key ] === false ) {
                $_error_code    = socket_last_error ();
                $_error_message = socket_strerror ( $_error_code );
                throw new \Exception( $_error_message , $_error_code );
            }
        }
        return self::$_sockets[ $key ];
    }

    public static function select_ipv6_socket ( $key , $timeout = 5 )
    {
        $_socket = self::get_ipv6_socket ( $key );
        $_read   = array ( $_socket );
        $_write  = array ( $_socket );
        $_except = array ( $_socket );
        $_select = socket_select ( $_read , $_write , $_except , $timeout );
        if ( $_select === false ) {
            $_error_code    = socket_last_error ();
            $_error_message = socket_strerror ( $_error_code );
            self::clear_ipv6_socket ( $key );
            throw new \Exception( $_error_message , $_error_code );
        } else if ( $_select === 0 ) {
            self::clear_ipv6_socket ( $key );
            throw new \Exception( "sockets [ " . $key . " ] select request is time out" , $_select );
        }
        $_return = array ( "read" => $_read , "write" => $_write , "except" => $_except , "select" => $_select );
        return $_return;
    }

    public static function clear_ipv6_socket ( $key )
    {
        $_socket = self::get_ipv6_socket ( $key );
        @socket_close ( $_socket );
        self::$_sockets[ $key ] = null;
        unset( self::$_sockets[ $key ] );
    }

    public static function send_ipv6_data_package ( $key , $package , $host = "2001:db8:1::242:ac11:2" , $flags = 0 , $port = 0 )
    {
        $_socket       = self::get_ipv6_socket ( $key );
        $_package_size = strlen ( $package );
        $_length       = socket_sendto ( $_socket , $package , $_package_size , $flags , $host , $port );
        if ( $_length === false ) {
            $_error_code    = socket_last_error ();
            $_error_message = socket_strerror ( $_error_code );
            throw new \Exception( $_error_message , $_error_code );
        }
        return $_length;
    }

    public static function receive_ipv6_data_package ( $key , &$data , $host = "2001:db8:1::242:ac11:2" , $receive_size = self::SIZE_RECEIVE_BYTE_MAX , $flags = 0 , $port = 0 )
    {
        $_socket = self::get_ipv6_socket ( $key );
        $_length = socket_recvfrom ( $_socket , $data , $receive_size , $flags , $host , $port );
        if ( $_length === false ) {
            $_error_code    = socket_last_error ();
            $_error_message = socket_strerror ( $_error_code );
            throw new \Exception( $_error_message , $_error_code );
        }
        $_head_version_traffic_flow_label = self::format_ipv6_data_read ( substr ( $data , 0 , 4 ) , "a*" );
        $_head_payload_length             = self::format_ipv6_data_read ( substr ( $data , 4 , 2 ) , "n*" );
        $_head_next_header                = self::format_ipv6_data_read ( substr ( $data , 6 , 1 ) );
        $_head_hop_limit                  = self::format_ipv6_data_read ( substr ( $data , 7 , 1 ) );
        $_head_source_address             = self::format_128_bit_to_ipv6_address ( substr ( $data , 8 , 16 ) );
        $_head_destination__address       = self::format_128_bit_to_ipv6_address ( substr ( $data , 24 , 16 ) );
        $_data                            = self::format_ipv6_data_read ( substr ( $data , 40 , 984 ) );
        $_package                         = array (
            "package_size"                    => $_length ,
            "package_length"                  => $_length ,
            "head_version_traffic_flow_label" => self::bin_to_bin_string ( $_head_version_traffic_flow_label ) ,
            "head_payload_length"             => $_head_payload_length ,
            "head_next_head"                  => self::bin_to_bin_string ( $_head_next_header ) ,
            "head_hop_limit"                  => self::bin_to_bin_string ( $_head_hop_limit ) ,
            "head_source_address"             => $_head_source_address ,
            "head_destination_address"        => $_head_destination__address ,
            "data"                            => Class_Base_Format::data_to_string ( $_data ) ,
            "data_length"                     => strlen ( $_data ) ,
        );
        return $_package;
    }

    public static function get_local_ipv6_address ()
    {
        $_local_ipv6 = null;
        $_ipv6s      = Class_Base_Shell::command ( "ip addr show | grep inet6" );
        if ( ! empty( $_ipv6s ) ) {
            foreach ( $_ipv6s as $index => $ipv6 ) {
                if ( ( strpos ( $ipv6 , "global" ) !== false ) ) {
                    $_local_ipv6 = substr ( ( substr ( ltrim ( $ipv6 ) , 0 , strpos ( ltrim ( $ipv6 ) , "/" ) ) ) , 6 );
                    break;
                }
            }
        }
        return $_local_ipv6;
    }

    public static function get_local_ipv4_address ()
    {
        $_local_ipv4 = null;
        $_ipv4s      = Class_Base_Shell::command ( "ip addr show | grep inet" );
        if ( ! empty( $_ipv4s ) ) {
            foreach ( $_ipv4s as $index => $ipv6 ) {
                if ( ( strpos ( $ipv6 , "inet6" ) === false ) && ( strpos ( $ipv6 , "global" ) !== false ) ) {
                    $_local_ipv4 = substr ( ( substr ( ltrim ( $ipv6 ) , 0 , strpos ( ltrim ( $ipv6 ) , "/" ) ) ) , 5 );
                    break;
                }
            }
        }
        return $_local_ipv4;
    }

    public static function get_remote_ipv6_address ( $key )
    {
        $_socket  = self::get_ipv6_socket ( $key );
        $_address = null;
        $_bool    = socket_getpeername ( $_socket , $_address );
        if ( empty( $_bool ) ) {
            $_error_code    = socket_last_error ();
            $_error_message = socket_strerror ( $_error_code );
            throw new \Exception( $_error_message , $_error_code );
        }
        return $_address;
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

    public static function format_package_bin_to_hex ( $package )
    {
        if ( ! is_string ( $package ) ) {
            $package = strval ( $package );
        }
        $package = bin2hex ( $package );
        return $package;
    }

    public static function create_data_package ( $data , $type = self::PROTOCOL_IPV6 )
    {
        if ( $type == self::PROTOCOL_IPV6 ) {
            $_package = self::create_ipv6_data_package ( $data[ "src_ip" ] , $data[ "dst_ip" ] , $data );
            return $_package;
        }
        return null;
    }

    public static function format_package_checksum_write ( $checksum )
    {
        $_checksum = pack ( "n*" , $checksum );//打包成2字节
        return $_checksum;
    }

    public static function format_package_checksum_read ( $package )
    {
        $_data = unpack ( "n*" , $package );
        return $_data;
    }

    public static function check_browser_service_stop ()
    {
        if ( ! is_cli () ) {
            while ( ob_get_level () ) {
                ob_end_clean ();
            }
            Class_Base_Response::outputln ( "" );
            flush ();
            if ( connection_aborted () ) {
                throw new \Exception( self::EXCEPTION_MESSAGE_CONNECT_EXIT , self::EXCEPTION_BREAK );
            }
        }
    }
}