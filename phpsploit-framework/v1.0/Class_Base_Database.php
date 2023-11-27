<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-1
 * Time: 下午3:58
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

class Class_Base_Database extends Class_Base
{
    const TYPE_DRIVE_MYSQL      = "mysql";
    const DOMAIN_LOCALHOST      = "127.0.0.1";
    const PORT_LOCALHOST        = 3306;
    const USER_LOCALHOST        = "root";
    const PASSWORD_LOCALHOST    = "";
    const CREATE_INIT_TEST_USER = "CREATE USER 'test'@'127.0.0.1' IDENTIFIED BY 'test';";

    private static $_connect       = null;
    private static $_sqls          = array ();
    private static $_executed_sqls = array ();
    private static $_error_infos   = array ();

    public static function sqls_string_to_sql_array ( $sqls_string )
    {
        $_sql_array = array ();
        $_items     = explode ( chr ( 59 ) , $sqls_string );
        foreach ( $_items as $index => $item ) {
            if ( ! empty( $item ) ) {
                $_sql_array[] = $item . chr ( 59 );
            }
        }
        return $_sql_array;
    }


    public static function append_sql ( $sql )
    {
        if ( ( ! empty( $sql ) ) && ( is_string ( $sql ) ) && ( substr ( $sql , ( strlen ( $sql ) - 1 ) , 1 ) == chr ( 59 ) ) ) {
            self::$_sqls[] = $sql;
        }
    }

    public static function set_sqls ( $sqls )
    {
        if ( ( ! empty( $sqls ) ) && ( is_array ( $sqls ) ) ) {
            if ( ! empty( self::$_sqls ) ) {
                self::$_sqls = array ();
            }
            foreach ( $sqls as $index => $sql ) {
                if ( ( ! empty( $sql ) ) && ( is_string ( $sql ) ) && ( substr ( $sql , ( strlen ( $sql ) - 1 ) , 1 ) == chr ( 59 ) ) ) {
                    self::$_sqls[] = $sql;
                }
            }
            self::$_sqls;
        }
    }

    public static function get_sqls ()
    {
        if ( ! is_array ( self::$_sqls ) ) {
            self::$_sqls = array ();
        }
        return self::$_sqls;
    }

    public static function append_executed_sql ( $sql )
    {
        if ( ( ! empty( $sql ) ) && ( is_string ( $sql ) ) && ( substr ( $sql , ( strlen ( $sql ) - 1 ) , 1 ) == chr ( 59 ) ) ) {
            self::$_executed_sqls[] = $sql;
        }
    }

    public static function get_executed_sqls ()
    {
        if ( ! is_array ( self::$_executed_sqls ) ) {
            self::$_executed_sqls = array ();
        }
        return self::$_executed_sqls;
    }

    private static function _set_error_info ( $pdo_statement = null , $sql = "" )
    {
        if ( ( empty( self::$_connect ) ) || ( ! is_object ( self::$_connect ) ) || ( ! ( self::$_connect instanceof \PDO ) ) ) {
            throw new \Exception( "database connection is error" , 0 );
        }
        if ( ( ! empty( $pdo_statement ) ) && ( is_object ( $pdo_statement ) ) && ( $pdo_statement instanceof \PDOStatement ) ) {
            $_error_info = $pdo_statement->errorInfo ();
        } else {
            $_error_info = self::$_connect->errorInfo ();
        }
        if ( ! empty( $_error_info ) ) {
            self::$_error_infos[] = array ( "sql" => $sql , "error_info" => array ( "sqlstate" => $_error_info[ 0 ] , "code" => $_error_info[ 1 ] , "message" => $_error_info[ 2 ] ) );
        }
    }

    public static function get_error_infos ()
    {
        return self::$_error_infos;
    }

    public static function get_create_init_test_user_sql_string ( $user , $password , $domain = "127.0.0.1" )
    {
        if ( ! Class_Base_Format::is_user_name ( $user ) ) {
            throw new \Exception( ( "user name is error , user : " . print_r ( $user , true ) ) , 0 );
        }
        if ( ! Class_Base_Format::is_user_password ( $password ) ) {
            throw new \Exception( ( "user password is error , password : " . print_r ( $password , true ) ) , 0 );
        }
        if ( ! Class_Base_Format::is_domain_name ( $domain ) ) {
            throw new \Exception( ( "domain name is error , domain : " . print_r ( $domain , true ) ) , 0 );
        }
        $_sql = "CREATE USER '" . $user . "'@'" . $domain . "' IDENTIFIED BY '" . $password . "';";
        return $_sql;
    }

    public static function get_grant_all_string ( $user , $database , $table , $domain = "127.0.0.1" )
    {
        if ( ! Class_Base_Format::is_user_name ( $user ) ) {
            throw new \Exception( ( "user name is error , user : " . print_r ( $user , true ) ) , 0 );
        }
        if ( ! Class_Base_Format::is_database_name ( $database ) ) {
            throw new \Exception( ( "database name is error , database : " . print_r ( $database , true ) ) , 0 );
        }
        if ( ! Class_Base_Format::is_table_name ( $table ) ) {
            throw new \Exception( ( "table name is error , table : " . print_r ( $table , true ) ) , 0 );
        }
        if ( ! Class_Base_Format::is_domain_name ( $domain ) ) {
            throw new \Exception( ( "domain name is error , domain : " . print_r ( $domain , true ) ) , 0 );
        }
        $_sql = "GRANT ALL ON " . $database . "." . $table . " TO '" . $user . "'@'" . $domain . "';";
        return $_sql;
    }

    public static function connect ( $drive_type = self::TYPE_DRIVE_MYSQL , $domain = self::DOMAIN_LOCALHOST , $port = self::PORT_LOCALHOST , $user = self::USER_LOCALHOST , $password = self::PASSWORD_LOCALHOST , $options = array ( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION ) )
    {
        try {
            $_dsn           = ( $drive_type . ':host=' . $domain . ';port=' . $port . ';' );
            self::$_connect = new \PDO( $_dsn , $user , $password , $options );
            return self::$_connect;
        } catch ( \PDOException $e ) {
            if ( is_cli () ) {
                Class_Base_Response::outputln ( $e );
            } else {
                Class_Base_Response::output ( ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( $e , true ) ) , "text" );
            }
            exit( 1 );
        }
    }

    public static function check_connect ()
    {
        if ( ( empty( self::$_connect ) ) || ( ! is_object ( self::$_connect ) ) || ( ! ( self::$_connect instanceof \PDO ) ) ) {
            throw new \Exception( "database connection is error" , 0 );
        }
    }

    public static function beginTransaction ()
    {
        self::check_connect ();
        $_bool = self::$_connect->beginTransaction ();
        return $_bool;
    }

    public static function commit ()
    {
        self::check_connect ();
        $_bool = self::$_connect->commit ();
        return $_bool;
    }

    public static function rollBack ()
    {
        self::check_connect ();
        $_bool = self::$_connect->rollBack ();
        return $_bool;
    }

    public static function query ( $sql )
    {
        self::check_connect ();
        if ( ( ! empty( $sql ) ) && ( is_string ( $sql ) ) && ( substr ( $sql , ( strlen ( $sql ) - 1 ) , 1 ) == chr ( 59 ) ) ) {
            self::append_executed_sql ( $sql );
            $_pdo_statement = self::$_connect->query ( $sql );
            if ( empty( $_pdo_statement ) ) {
                self::_set_error_info ( null );
                if ( is_cli () ) {
                    Class_Base_Response::output ( print_r ( self::get_error_infos () , true ) , "text" );
                } else {
                    Class_Base_Response::output ( ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( self::get_error_infos () , true ) ) , "text" );
                }
                exit( 1 );
            }
            $_results = $_pdo_statement->fetchAll ( ( \PDO::FETCH_COLUMN ) );
            if ( ! is_array ( $_results ) ) {
                self::_set_error_info ( null );
                if ( is_cli () ) {
                    Class_Base_Response::output ( print_r ( self::get_error_infos () , true ) , "text" );
                } else {
                    Class_Base_Response::output ( ( '<a href="' . urldecode ( Class_Base_Response::get_http_referer ( 1 ) ) . '">Return to the previous page ! </a>' . chr ( 10 ) . '<span>exception : </span>' . print_r ( self::get_error_infos () , true ) ) , "text" );
                }
                exit( 1 );
            }
            foreach ( $_results as $index => $items ) {
                if ( is_array ( $items ) ) {
                    foreach ( $items as $key => $item ) {
                        if ( Class_Base_Format::is_integer ( $key ) ) {
                            $items[ $key ] = null;
                            unset( $items[ $key ] );
                        }
                    }
                }
            }
            return $_results;
        }
        return false;
    }

    public static function exec ( $sql )
    {
        self::check_connect ();
        if ( ( ! empty( $sql ) ) && ( is_string ( $sql ) ) && ( substr ( $sql , ( strlen ( $sql ) - 1 ) , 1 ) == chr ( 59 ) ) ) {
            self::append_executed_sql ( $sql );
            $_count = self::$_connect->exec ( $sql );
            if ( $_count === false ) {
                self::_set_error_info ( null , $sql );
                throw new \Exception( print_r ( self::get_error_infos () , true ) , 0 );
            }
            return $_count;
        }
        return false;
    }

    public static function querys ( $sqls )
    {
        if ( is_array ( $sqls ) ) {
            $_results = array ();
            foreach ( $sqls as $index => $sql ) {
                if ( is_string ( $sql ) ) {
                    $_results[ $sql ] = self::query ( $sql );
                }
            }
            return $_results;
        }
        return false;
    }

    public static function execs ( $sqls )
    {
        if ( is_array ( $sqls ) ) {
            $_results = array ();
            foreach ( $sqls as $index => $sql ) {
                if ( is_string ( $sql ) ) {
                    $_results[ $sql ] = self::exec ( $sql );
                }
            }
            return $_results;
        }
        return false;
    }

    public static function query_sqls_string ( $sqls_string )
    {
        if ( is_string ( $sqls_string ) ) {
            $_sqls = self::sqls_string_to_sql_array ( $sqls_string );
            if ( ! empty( $_sqls ) ) {
                self::set_sqls ( $_sqls );
                $_results = self::querys ( $_sqls );
                return $_results;
            }
        }
        return false;
    }

    public static function exec_sqls_string ( $sqls_string )
    {
        if ( is_string ( $sqls_string ) ) {
            $_sqls = self::sqls_string_to_sql_array ( $sqls_string );
            if ( ! empty( $_sqls ) ) {
                self::set_sqls ( $_sqls );
                self::beginTransaction ();
                try {
                    $_results = self::execs ( $_sqls );
                    self::commit ();
                    return $_results;
                } catch ( \PDOException $e ) {
                    try {
                        self::rollBack ();
                    } catch ( \Exception $e ) {
                        return false;
                    }
                } catch ( \Exception $e ) {
                    try {
                        self::rollBack ();
                    } catch ( \Exception $e ) {
                        return false;
                    }
                }
            }
        }
        return false;
    }
}