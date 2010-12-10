<?php

// this contains the application parameters that can be maintained via GUI
return array(
	'class' => 'CDBConnection',
	'connectionString' => '@db@:host=@host@;port=@port@;dbname=@dbname@',
	'emulatePrepare' => true,
	'username' => '@username@',
	'password' => '@password@',
	'charset' => 'utf8',
);
