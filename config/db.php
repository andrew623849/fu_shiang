<?php

	if(!empty($_SERVER['HTTP_HOST'])){
		$dbname = explode('.',$_SERVER['HTTP_HOST'])[0];
		if($dbname != 'cowbtool' && $dbname != 'cowbtest'){
			$link = mysqli_connect("localhost", 'root', '7939$584&79eD', "cowbtool_main");
			$sql_ID = mysqli_query($link, "select * from admin_sheet where admin='$dbname'");
			$sql_data = $sql_ID->fetch_assoc();
			if(empty($sql_data)){
//			header("location: http://cowbtool.com");
//			exit;
				$sql_data['password'] = 'main';

			}
			mysqli_close($link);
		}else{
			$sql_data['password'] = 'main';
		}
	}else{
		$sql_data['password'] = 'main';
	}

	return [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=localhost;dbname=cowbtool_'.$sql_data['password'],
		'username' => 'root',
		'password' => '7939$584&79eD',
		'charset' => 'utf8',

		// Schema cache options (for production environment)
		//'enableSchemaCache' => true,
		//'schemaCacheDuration' => 60,
		//'schemaCache' => 'cache',
	];
	return [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=localhost;dbname=cowbtool_k537',
		'username' => 'root',
		'password' => 'andrew623401',
		'charset' => 'utf8',

		// Schema cache options (for production environment)
		//'enableSchemaCache' => true,
		//'schemaCacheDuration' => 60,
		//'schemaCache' => 'cache',
	];