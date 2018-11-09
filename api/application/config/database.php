<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
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
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

//$active_group = 'default';
$active_group = 'default3';
$active_record = TRUE;


$db['default']['hostname'] = '10.15.5.122/sggbi';
$db['default']['username'] = 'qviewadmin';
$db['default']['password'] = 'gadjahmada2011';
$db['default']['database'] = '';
$db['default']['dbdriver'] = 'oci8';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['default1']['hostname'] = '10.15.5.96/PMT';
$db['default1']['username'] = 'MSADMIN';
$db['default1']['password'] = 'nGUmBEsiwal4N';
$db['default1']['database'] = '';
$db['default1']['dbdriver'] = 'oci8';
$db['default1']['dbprefix'] = '';
$db['default1']['pconnect'] = FALSE;
$db['default1']['db_debug'] = TRUE;
$db['default1']['cache_on'] = FALSE;
$db['default1']['cachedir'] = '';
$db['default1']['char_set'] = 'utf8';
$db['default1']['dbcollat'] = 'utf8_general_ci';
$db['default1']['swap_pre'] = '';
$db['default1']['autoinit'] = TRUE;
$db['default1']['stricton'] = FALSE;

$db['default2']['hostname'] = '10.15.3.146';
$db['default2']['username'] = 'par4digma';
$db['default2']['password'] = 'S3menGres1k';
$db['default2']['database'] = 'logfeedtuban';
$db['default2']['dbdriver'] = 'mysql';
$db['default2']['dbprefix'] = '';
$db['default2']['pconnect'] = FALSE;
$db['default2']['db_debug'] = TRUE;
$db['default2']['cache_on'] = FALSE;
$db['default2']['cachedir'] = '';
$db['default2']['char_set'] = 'utf8';
$db['default2']['dbcollat'] = 'utf8_general_ci';
$db['default2']['swap_pre'] = '';
$db['default2']['autoinit'] = TRUE;
$db['default2']['stricton'] = FALSE;

//$db['default3']['hostname'] = '10.15.3.144/pdbsi';
//$db['default3']['username'] = 'smigapp';
//$db['default3']['password'] = 'smigapp123';
//$db['default3']['database'] = '';
//$db['default3']['dbdriver'] = 'oci8';
//$db['default3']['dbprefix'] = '';
//$db['default3']['pconnect'] = FALSE;
//$db['default3']['db_debug'] = TRUE;
//$db['default3']['cache_on'] = FALSE;
//$db['default3']['cachedir'] = '';
//$db['default3']['char_set'] = 'utf8';
//$db['default3']['dbcollat'] = 'utf8_general_ci';
//$db['default3']['swap_pre'] = '';
//$db['default3']['autoinit'] = TRUE;
//$db['default3']['stricton'] = FALSE;

$db['default3']['hostname'] = '10.15.3.144/pdbsi';
$db['default3']['username'] = 'smigapp';
$db['default3']['password'] = 'L0ntONgKuP4#ng';
//$db['default3']['hostname'] = '10.15.3.145/smig_dev.semenindonesia.com';
//$db['default3']['username'] = 'devsi';
//$db['default3']['password'] = 'SelaluJaya6102';
$db['default3']['database'] = '';
$db['default3']['dbdriver'] = 'oci8';
$db['default3']['dbprefix'] = '';
$db['default3']['pconnect'] = FALSE;
$db['default3']['db_debug'] = TRUE;
$db['default3']['cache_on'] = FALSE;
$db['default3']['cachedir'] = '';
$db['default3']['char_set'] = 'utf8';
$db['default3']['dbcollat'] = 'utf8_general_ci';
$db['default3']['swap_pre'] = '';
$db['default3']['autoinit'] = TRUE;
$db['default3']['stricton'] = FALSE;

$db['default4']['hostname'] = '10.15.3.63';
$db['default4']['username'] = 'pis';
$db['default4']['password'] = 'semengresik';
$db['default4']['database'] = 'pisdb';
$db['default4']['dbdriver'] = 'postgre';
$db['default4']['dbprefix'] = '';
$db['default4']['pconnect'] = FALSE;
$db['default4']['db_debug'] = TRUE;
$db['default4']['cache_on'] = FALSE;
$db['default4']['cachedir'] = '';
$db['default4']['char_set'] = 'utf8';
$db['default4']['dbcollat'] = 'utf8_general_ci';
$db['default4']['swap_pre'] = '';
$db['default4']['autoinit'] = TRUE;
$db['default4']['stricton'] = FALSE;

$db['default5']['hostname'] = '10.15.3.144/pdbsi';
$db['default5']['username'] = 'APPBISD';
$db['default5']['password'] = 'gresik45smigone';
$db['default5']['database'] = '';
$db['default5']['dbdriver'] = 'oci8';
$db['default5']['dbprefix'] = '';
$db['default5']['pconnect'] = FALSE;
$db['default5']['db_debug'] = TRUE;
$db['default5']['cache_on'] = FALSE;
$db['default5']['cachedir'] = '';
$db['default5']['char_set'] = 'utf8';
$db['default5']['dbcollat'] = 'utf8_general_ci';
$db['default5']['swap_pre'] = '';
$db['default5']['autoinit'] = TRUE;
$db['default5']['stricton'] = FALSE;

$db['default6']['hostname'] = '10.15.5.76/cmsdb';
$db['default6']['username'] = 'APPSGG';
$db['default6']['password'] = 'sgmerdeka99';
$db['default6']['database'] = '';
$db['default6']['dbdriver'] = 'oci8';
$db['default6']['dbprefix'] = '';
$db['default6']['pconnect'] = FALSE;
$db['default6']['db_debug'] = TRUE;
$db['default6']['cache_on'] = FALSE;
$db['default6']['cachedir'] = '';
$db['default6']['char_set'] = 'utf8';
$db['default6']['dbcollat'] = 'utf8_general_ci';
$db['default6']['swap_pre'] = '';
$db['default6']['autoinit'] = TRUE;
$db['default6']['stricton'] = FALSE;

$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sggdata3.semenindonesia.com)(PORT = 1521))
        (CONNECT_DATA = (SERVER = DEDICATED) (SID = sgg)))';
$db['default7']['hostname'] = $tnsname;
$db['default7']['username'] = 'par4digma';
$db['default7']['password'] = 'S3m3n6resik';
$db['default7']['database'] = '';
$db['default7']['dbdriver'] = 'oci8';
$db['default7']['dbprefix'] = '';
$db['default7']['pconnect'] = FALSE;
$db['default7']['db_debug'] = TRUE;
$db['default7']['cache_on'] = FALSE;
$db['default7']['cachedir'] = '';
$db['default7']['char_set'] = 'utf8';
$db['default7']['dbcollat'] = 'utf8_general_ci';
$db['default7']['swap_pre'] = '';
$db['default7']['autoinit'] = TRUE;
$db['default7']['stricton'] = FALSE;

$tnsname = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.15.5.122)(PORT=1521))(CONNECT_DATA=(SID=pmdb)))';
$db['oramso']['hostname'] = $tnsname;
$db['oramso']['username'] = 'mso';
$db['oramso']['password'] = 's3mengres1k';
$db['oramso']['database'] = '';
$db['oramso']['dbdriver'] = 'oci8';
$db['oramso']['dbprefix'] = '';
$db['oramso']['pconnect'] = FALSE;
$db['oramso']['db_debug'] = TRUE;
$db['oramso']['cache_on'] = FALSE;
$db['oramso']['cachedir'] = '';
$db['oramso']['char_set'] = 'utf8';
$db['oramso']['dbcollat'] = 'utf8_general_ci';
$db['oramso']['swap_pre'] = '';
$db['oramso']['autoinit'] = TRUE;
$db['oramso']['stricton'] = FALSE;

$db['viewhris']['hostname'] = '10.15.3.67';
$db['viewhris']['username'] = 'user_hmr';
$db['viewhris']['password'] = '_R34+ch.Th:ePe4k';
$db['viewhris']['database'] = 'hris';
$db['viewhris']['dbdriver'] = 'mysqli';
$db['viewhris']['dbprefix'] = '';
$db['viewhris']['pconnect'] = FALSE;
$db['viewhris']['db_debug'] = TRUE;
$db['viewhris']['cache_on'] = FALSE;
$db['viewhris']['cachedir'] = '';
$db['viewhris']['char_set'] = 'utf8';
$db['viewhris']['dbcollat'] = 'utf8_general_ci';
$db['viewhris']['swap_pre'] = '';
$db['viewhris']['autoinit'] = TRUE;
$db['viewhris']['stricton'] = FALSE;
$db['viewhris']['port'] = "3306";

$db['default8']['hostname'] = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.15.5.101)(PORT=1521))(CONNECT_DATA=(SID=devsgg)))';
$db['default8']['username'] = 'pusb';
$db['default8']['password'] = 'pusb2016';
$db['default8']['database'] = '';
$db['default8']['dbdriver'] = 'oci8';
$db['default8']['dbprefix'] = '';
$db['default8']['pconnect'] = FALSE;
$db['default8']['db_debug'] = TRUE;
$db['default8']['cache_on'] = FALSE;
$db['default8']['cachedir'] = '';
$db['default8']['char_set'] = 'utf8';
$db['default8']['dbcollat'] = 'utf8_general_ci';
$db['default8']['swap_pre'] = '';
$db['default8']['autoinit'] = TRUE;
$db['default8']['stricton'] = FALSE;

$db['portm']['hostname'] = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.96)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = sgg)(SERVER = DEDICATED)))';
$db['portm']['username'] = 'management';
$db['portm']['password'] = 'M4n4g3ment16';
$db['portm']['database'] = '';
$db['portm']['dbdriver'] = 'oci8';
$db['portm']['dbprefix'] = '';
$db['portm']['pconnect'] = FALSE;
$db['portm']['db_debug'] = TRUE;
$db['portm']['cache_on'] = FALSE;
$db['portm']['cachedir'] = '';
$db['portm']['char_set'] = 'utf8';
$db['portm']['dbcollat'] = 'utf8_general_ci';
$db['portm']['swap_pre'] = '';
$db['portm']['autoinit'] = TRUE;
$db['portm']['stricton'] = FALSE;

$db['qm']['hostname'] = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dev-sggdata3.semenindonesia.com)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = devsgg)(SERVER = DEDICATED)))';
$db['qm']['username'] = 'qmuser';
$db['qm']['password'] = 'qmp4sswD';
$db['qm']['database'] = '';
$db['qm']['dbdriver'] = 'oci8';
$db['qm']['dbprefix'] = '';
$db['qm']['pconnect'] = FALSE;
$db['qm']['db_debug'] = TRUE;
$db['qm']['cache_on'] = FALSE;
$db['qm']['cachedir'] = '';
$db['qm']['char_set'] = 'utf8';
$db['qm']['dbcollat'] = 'utf8_general_ci';
$db['qm']['swap_pre'] = '';
$db['qm']['autoinit'] = TRUE;
$db['qm']['stricton'] = FALSE;

$db['logger']['hostname'] = '10.15.3.146';
$db['logger']['username'] = 'par4digma';
$db['logger']['password'] = 'S3menGres1k';
$db['logger']['database'] = 'pis_tes';
$db['logger']['dbdriver'] = 'mysql';
$db['logger']['dbprefix'] = '';
$db['logger']['pconnect'] = FALSE;
$db['logger']['db_debug'] = TRUE;
$db['logger']['cache_on'] = FALSE;
$db['logger']['cachedir'] = '';
$db['logger']['char_set'] = 'utf8';
$db['logger']['dbcollat'] = 'utf8_general_ci';
$db['logger']['swap_pre'] = '';
$db['logger']['autoinit'] = TRUE;
$db['logger']['stricton'] = FALSE;

$db['tonasa1']['hostname'] = '172.16.2.7';
$db['tonasa1']['username'] = 'arfan';
$db['tonasa1']['password'] = '12345678';
$db['tonasa1']['database'] = 'FICO';
$db['tonasa1']['dbdriver'] = 'mysql';
$db['tonasa1']['dbprefix'] = '';
$db['tonasa1']['pconnect'] = FALSE;
$db['tonasa1']['db_debug'] = TRUE;
$db['tonasa1']['cache_on'] = FALSE;
$db['tonasa1']['cachedir'] = '';
$db['tonasa1']['char_set'] = 'utf8';
$db['tonasa1']['dbcollat'] = 'utf8_general_ci';
$db['tonasa1']['swap_pre'] = '';
$db['tonasa1']['autoinit'] = TRUE;
$db['tonasa1']['stricton'] = FALSE;

$db['tonasa']['hostname'] = '172.16.2.7';
$db['tonasa']['username'] = 'thamrin';
$db['tonasa']['password'] = '12345678';
$db['tonasa']['database'] = 'dashboard_pap';
$db['tonasa']['dbdriver'] = 'mysql';
$db['tonasa']['dbprefix'] = '';
$db['tonasa']['pconnect'] = FALSE;
$db['tonasa']['db_debug'] = TRUE;
$db['tonasa']['cache_on'] = FALSE;
$db['tonasa']['cachedir'] = '';
$db['tonasa']['char_set'] = 'utf8';
$db['tonasa']['dbcollat'] = 'utf8_general_ci';
$db['tonasa']['swap_pre'] = '';
$db['tonasa']['autoinit'] = TRUE;
$db['tonasa']['stricton'] = FALSE;

// $db['tonasa'] = array(
// 	'dsn'	=> '',
// 	'hostname' => '172.16.2.7',
// 	'username' => 'arfan',
// 	'password' => '12345678',
// 	'database' => 'dashboard_pap',
// 	'dbdriver' => 'mysql',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => FALSE,
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
//);

$db['mso_prod'] = array(
	'dsn'	=> '',
	'hostname' => '10.15.5.122',
	'username' => 'mso',
	'password' => 's3mengres1k',
	'database' => 'pmdb',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
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

$db['opcclient']['hostname'] = '10.15.3.146';
$db['opcclient']['username'] = 'par4digma';
$db['opcclient']['password'] = 'S3menGres1k';
$db['opcclient']['database'] = 'opctags';
$db['opcclient']['dbdriver'] = 'mysql';
$db['opcclient']['dbprefix'] = '';
$db['opcclient']['pconnect'] = FALSE;
$db['opcclient']['db_debug'] = TRUE;
$db['opcclient']['cache_on'] = FALSE;
$db['opcclient']['cachedir'] = '';
$db['opcclient']['char_set'] = 'utf8';
$db['opcclient']['dbcollat'] = 'utf8_general_ci';
$db['opcclient']['swap_pre'] = '';
$db['opcclient']['autoinit'] = TRUE;
$db['opcclient']['stricton'] = FALSE;

$db['opcqmo']['hostname'] = '10.15.3.146';
$db['opcqmo']['username'] = 'par4digma';
$db['opcqmo']['password'] = 'S3menGres1k';
$db['opcqmo']['database'] = 'qmo';
$db['opcqmo']['dbdriver'] = 'mysql';
$db['opcqmo']['dbprefix'] = '';
$db['opcqmo']['pconnect'] = FALSE;
$db['opcqmo']['db_debug'] = TRUE;
$db['opcqmo']['cache_on'] = FALSE;
$db['opcqmo']['cachedir'] = '';
$db['opcqmo']['char_set'] = 'utf8';
$db['opcqmo']['dbcollat'] = 'utf8_general_ci';
$db['opcqmo']['swap_pre'] = '';
$db['opcqmo']['autoinit'] = TRUE;
$db['opcqmo']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */