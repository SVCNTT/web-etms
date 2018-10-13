<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'Ninemobi@123',
	'database' => 'bayersfvn',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

/**
* DB DEV
* start
*/
$db['strikeforce_development']['hostname'] = 'localhost';
$db['strikeforce_development']['port']	   = 3306;
$db['strikeforce_development']['username'] = 'root';
$db['strikeforce_development']['password'] = 'Ninemobi@123';
$db['strikeforce_development']['database'] = 'bayersfvn';
$db['strikeforce_development']['dbdriver'] = 'mysqli';
$db['strikeforce_development']['dbprefix'] = '';
$db['strikeforce_development']['pconnect'] = FALSE;
$db['strikeforce_development']['db_debug'] = TRUE;
$db['strikeforce_development']['cache_on'] = FALSE;
$db['strikeforce_development']['cachedir'] = '';
$db['strikeforce_development']['char_set'] = 'utf8';
$db['strikeforce_development']['dbcollat'] = 'utf8_general_ci';
$db['strikeforce_development']['swap_pre'] = '';
$db['strikeforce_development']['encrypt']  = FALSE;
$db['strikeforce_development']['stricton'] = FALSE;
$db['strikeforce_development']['failover'] = array();
$db['strikeforce_development']['save_queries'] = TRUE;
/**
 * end
 * DB DEV
 */

/**
 * DB Version 2
 * start
 */
$db['strikeforce_v2']['hostname'] = 'localhost';
$db['strikeforce_v2']['port']	  = 3306;
$db['strikeforce_v2']['username'] = 'dev01';
$db['strikeforce_v2']['password'] = '!@QWASZX';
$db['strikeforce_v2']['database'] = 'bayer2016';
$db['strikeforce_v2']['dbdriver'] = 'mysqli';
$db['strikeforce_v2']['dbprefix'] = '';
$db['strikeforce_v2']['pconnect'] = FALSE;
$db['strikeforce_v2']['db_debug'] = TRUE;
$db['strikeforce_v2']['cache_on'] = FALSE;
$db['strikeforce_v2']['cachedir'] = '';
$db['strikeforce_v2']['char_set'] = 'utf8';
$db['strikeforce_v2']['dbcollat'] = 'utf8_general_ci';
$db['strikeforce_v2']['swap_pre'] = '';
$db['strikeforce_v2']['encrypt']  = FALSE;
$db['strikeforce_v2']['stricton'] = FALSE;
$db['strikeforce_v2']['failover'] = array();
$db['strikeforce_v2']['save_queries'] = TRUE;
/**
 * end
 * DB Version 2
 */

/**
 * DB LIVE
 * start
 */
$db['strikeforce_production']['hostname'] = 'localhost';
$db['strikeforce_production']['port']	  = 3306;
$db['strikeforce_production']['username'] = 'root';
$db['strikeforce_production']['password'] = 'Ninemobi@123';
$db['strikeforce_production']['database'] = 'bayersfvn';
$db['strikeforce_production']['dbdriver'] = 'mysqli';
$db['strikeforce_production']['dbprefix'] = '';
$db['strikeforce_production']['pconnect'] = FALSE;
$db['strikeforce_production']['db_debug'] = FALSE;
$db['strikeforce_production']['cache_on'] = FALSE;
$db['strikeforce_production']['cachedir'] = '';
$db['strikeforce_production']['char_set'] = 'utf8';
$db['strikeforce_production']['dbcollat'] = 'utf8_general_ci';
$db['strikeforce_production']['swap_pre'] = '';
$db['strikeforce_production']['encrypt']  = FALSE;
$db['strikeforce_production']['stricton'] = FALSE;
$db['strikeforce_production']['failover'] = array();
$db['strikeforce_production']['save_queries'] = TRUE;
/**
 * end
 * DB LIVE
 */
