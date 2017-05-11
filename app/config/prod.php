<?php

// Doctrine (db)
$app['db.options'] = array(
	'driver'   => 'pdo_mysql',
	'charset'  => 'utf8',
	'host'     => 'tceppinitamcms.mysql.db',
	'port'     => '3306',
	'dbname'   => 'tceppinitamcms',
	'user'     => 'tceppinitamcms',
	'password' => 'Gtars57574',
	);

// define log level
$app['monolog.level'] = 'WARNING';
