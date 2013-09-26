<?php


$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Simqel\Tests', __DIR__);

/*
$config = array(


	'sqlite_db' => ,

	'mysql_db'  => 'mysql://root:gsub@localhost/mlsql',

	'mysql_dsn' => 'mysql://root:gsub@127.0.0.1/information_schema',

	'pgsql_dsn' => 'pgsql://renq:test@localhost/mlsql',


);
*/

if (!file_exists(__DIR__ . '/../temp/')) {
	mkdir(__DIR__ . '/../temp/');
}

define('TEST_PGSQL', false);
define('SQLITE_DB', __DIR__ . '/../temp/sqlite_test.db');
define('SQLITE_DB_DIR', __DIR__ . '/../temp/');
define('MYSQL_DB', 'mysql://root:gsub@localhost/mlsql');
define('MYSQL_DSN', 'mysql://root:gsub@127.0.0.1/information_schema');
define('PGSQL_DSN', 'pgsql://renq:test@localhost/mlsql');
