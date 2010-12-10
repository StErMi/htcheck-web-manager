<?php


class DefaultController extends CController
{
    public function init() {
        parent::init();
        Yii::app()->Theme = 'Installer';
        Yii::app()->layout = 'main';
    }
    
    /**
    * Show welcome page
    */
    public function actionIndex() {     	
        $this->render('welcome');
    }
    
	public function actionStep0() {
    	
        $this->render('Step0');
    }

    /**
    * Step 1
    *  - Check writable folders
    *  - Show copyright notice
    *
    * @return void
    */
    public function actionStep1() {
    	//exit ('lol');
        $folders = $this->getFoldersWritable();
        $writables = array();
        clearstatcache();
        $continue = true;
        foreach($folders as $path) {
        	
            if (is_writable($path) === true) {
                $writables[] = true;
            }
             else {
             	$continue = false;
                $writables[] = false;
             }
        }
        
        $this->render('Step1', array('folders'=>$folders, 'writables'=>$writables, 'continue'=>$continue ));
    }
    
    protected function getFoldersWritable() {
        return array(
            Yii::getPathOfAlias('webroot.assets'),
            Yii::getPathOfAlias('webroot.crawlers_config'),
            Yii::getPathOfAlias('application.runtime'),
            Yii::getPathOfAlias('application.config'),
        );
    }


    /**
    * input and check if database connection is valid
    * create ./protected/config/db_web_manager.php file
    *
    * @return void
    */
    public function actionStep2Manager() {
        Yii::app()->session->remove('env');
        $model=new ConfigForm();
        $model->dbName = 'htcheck_webmanager';
        if(isset($_POST['ConfigForm']) === true) {
            $model->attributes=$_POST['ConfigForm'];
            $model->password=$_POST['ConfigForm']['password'];
            if($model->validate() === true) {
                if($model->checkConnection() === true) {
                	
                    //create enviroment file
                    $configPath = Yii::getPathOfAlias('application.config');
                    $envSampleFile = $configPath.DIRECTORY_SEPARATOR.'db_web_manager-sample.php';
                    if (file_exists($envSampleFile) === false) {
                        throw new CHttpException(500, 'File not found "'.$envSampleFile.'"');
                    }

                    $content = file_get_contents($envSampleFile);
                    $searches = array('@db@', '@host@', '@port@', '@dbname@', '@username@', '@password@');
                    $replaces = array($model->db, $model->host, $model->port, $model->dbName, $model->username, $model->password);
                    $content = str_replace($searches, $replaces, $content);
                    
                    Yii::app()->session['web_manager_path'] = $_POST['web_manager_path'];
                    
                    if (is_writable($configPath) === true || is_writable($configPath.'/db_web_manager.php') === true) {
                        file_put_contents($configPath.'/db_web_manager.php', $content);
                        Yii::app()->session['web_manager_db_type'] = $model->db;
                        Yii::app()->session['web_manager_db'] = $model->dbName;
                        Yii::app()->session['web_manager_username'] = $model->username;
                        Yii::app()->session['web_manager_password'] = $model->password;
                        Yii::app()->session['web_manager_host'] = $model->host;
                        Yii::app()->session['web_manager_port'] = $model->port;
                    } else {
                        Yii::app()->session['env'] = $content;
                    }
                    $this->redirect(array('default/Step2General'));
                } else {
                    $this->render('Step2ManagerErrorDb');
                }
            }
        }

        $this->render('Step2Manager', array('model'=>$model));
    }
    
	/**
    * input and check if database connection is valid
    * create ./protected/config/environment.php file
    *
    * @return void
    */
    public function actionStep2General() {
        Yii::app()->session->remove('env');
        $model=new ConfigForm();
        $model->db = 'mysql';
        if ( Yii::app()->session['web_manager_db_type'] != 'mysql' ) $model->dbName = 'mysql';
        else $model->dbName = Yii::app()->session['web_manager_db'];
        $model->host = Yii::app()->session['web_manager_host'];
        $model->port = Yii::app()->session['web_manager_port'];
        if(isset($_POST['ConfigForm']) === true) {
            $model->attributes=$_POST['ConfigForm'];
            $model->password=$_POST['ConfigForm']['password'];
            if($model->validate() === true) {
                //if($model->checkConnection() === true) {
                    //create enviroment file
                    $configPath = Yii::getPathOfAlias('application.config');
                    $envSampleFile = $configPath.DIRECTORY_SEPARATOR.'db-sample.php';
                    if (file_exists($envSampleFile) === false) {
                        throw new CHttpException(500, 'File not found "'.$envSampleFile.'"');
                    }

                    $content = file_get_contents($envSampleFile);
                    $searches = array('@db@', '@host@', '@port@', '@dbname@', '@username@', '@password@');
                    $replaces = array($model->db, $model->host, $model->port, $model->dbName, $model->username, $model->password);
                    $content = str_replace($searches, $replaces, $content);
                    if (is_writable($configPath) === true || is_writable($configPath.'/db.php') === true) {
                        file_put_contents($configPath.'/db.php', $content);
                    } else {
                        Yii::app()->session['env2'] = $content;
                    }
                    Yii::app()->session['web_htcheck_db_type'] = $model->db;
                    Yii::app()->session['web_htcheck_db'] = $model->dbName;
                    Yii::app()->session['web_htcheck_username'] = $model->username;
                    Yii::app()->session['web_htcheck_password'] = $model->password;
                    Yii::app()->session['web_htcheck_host'] = $model->host;
                    Yii::app()->session['web_htcheck_port'] = $model->port;
                    $this->redirect(array('default/Step3'));
                /*} else {
                    $this->render('Step2GeneralErrorDb');
                }*/
            }
        }

        $this->render('Step2General', array('model'=>$model));
    }

    /**
    * build database structures,
    * optional: insert data example
    *
    * @return void
    */
    public function actionStep3() {
		$canConnect = false;
        $configPath = Yii::getPathOfAlias('application.config');
        $envFile = $configPath.DIRECTORY_SEPARATOR.'db_web_manager.php';
        if (file_exists($envFile) === true) {
        	$db_conn = Yii::app()->session['web_manager_db_type'].':host='.Yii::app()->session['web_manager_host'].';port='.Yii::app()->session['web_manager_port'].';dbname='.Yii::app()->session['web_manager_db'];
        	$db_user = Yii::app()->session['web_manager_username'];
        	$db_pw = Yii::app()->session['web_manager_password'];
            $connection=new CDbConnection($db_conn, $db_user, $db_pw);
            $connection->charset='utf8';
            $connection->active=true;
            $canConnect = true;
            
        }

        if (isset($_POST['install']) === true) {
            if (is_object($connection) === true) {
                //create db schema
                if ( Yii::app()->session['web_manager_db_type'] == 'mysql' ) {
                	$sql = $this->getSql($this->module->structuresPath);
                	$sqlArr =  $this->splitQueries($sql, false);
                }
                else {
                	$sql = $this->getSql($this->module->structuresPostPath);
                	$sqlArr =  $this->splitQueries($sql, true);
                }
                
                	
                foreach ($sqlArr as $script) {
                    if (preg_match('/(CREATE\s+TABLE|DROP\s+TABLE|ALTER\s+TABLE|CREATE\s+VIEW|DROP\s+VIEW)/i', $script))
                        $result = $connection->createCommand($script)->execute();
                }
                
                //insert example data
           
                $dataPath = $this->module->dataPath;
            	if ( Yii::app()->session['web_manager_db_type'] == 'mysql' ) {
            		$dataPath = $this->module->dataPath;
                	$sql = $this->getSql($dataPath);
                	$sqlDataArr =  $this->splitQueries($sql, false);
                }
                else {
                	$dataPath = $this->module->dataPostPath;
                	$sql = $this->getSql($dataPath);
                	$sqlDataArr =  $this->splitQueries($sql, true);
                }
                
                //$db = $this->getDbConnection( $db_conn, $db_user, $db_pw );
                
                    $remove = array();
                    foreach ($sqlDataArr as $index => $script) {
                        if (preg_match('/insert\s+into/i', $script)) {
                            /*if (mysql_query($script,$db) === true) {
                                $remove[] = $index;
                            }*/
                        	$result = $connection->createCommand($script)->execute();
                        	if ( $result )
                        		$remove[] = $index;
                        } else {
                            $remove[] = $index;
                        }
                    }
                    

                
                //Updating db settings
                
                $command=$connection->createCommand("INSERT INTO configuration VALUES(
                	'".Yii::app()->session['web_manager_db_type']."', 
                	'".Yii::app()->session['web_manager_host']."', 
                	'".Yii::app()->session['web_manager_port']."', 
                	'".Yii::app()->session['web_manager_db']."', 
                	'".Yii::app()->session['web_manager_username']."', 
                	'".Yii::app()->session['web_manager_password']."', 
                	'".Yii::app()->session['web_manager_path']."', 
                	'".Yii::app()->session['web_htcheck_host']."', 
                	'".Yii::app()->session['web_htcheck_port']."', 
                	'".Yii::app()->session['web_htcheck_db']."', 
                	'".Yii::app()->session['web_htcheck_username']."', 
                	'".Yii::app()->session['web_htcheck_password']."'
                )");
                
                $command->execute();
                	
               
                
                
                $this->redirect(array('default/Step4'));
            }
        }

        $this->render('Step3', array('canConnect' => $canConnect));
    }
    
    /**
    * split queries for execute
    * 
    * @param string $sql
    * @return string
    */
    protected function splitQueries($sql , $ispsql = false)
    {
        // Initialise variables.
        $buffer        = array();
        $queries    = array();
        $in_string    = false;

        // Trim any whitespace.
        $sql = trim($sql);

        // Remove comment lines.
        $sql = preg_replace("/\n\#[^\n]*/", '', "\n".$sql);
        if ( $ispsql )
        	$sql = preg_replace("/\n--[^\n]*/", '', "\n".$sql);

        // Parse the schema file to break up queries.
        for ($i = 0; $i < strlen($sql) - 1; $i ++)
        {
            if ($sql[$i] == ";" && !$in_string) {
                $queries[] = substr($sql, 0, $i);
                $sql = substr($sql, $i +1);
                $i = 0;
            }

            if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
                $in_string = false;
            }
            elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\")) {
                $in_string = $sql[$i];
            }
            if (isset ($buffer[1])) {
                $buffer[0] = $buffer[1];
            }
            $buffer[1] = $sql[$i];
        }

        // If there is anything left over, add it to the queries.
        if (!empty($sql)) {
            $queries[] = $sql;
        }

        return $queries;
    }
    
    protected function getDbConnection( $db_conn, $db_user, $db_pw ) {
        list(,$str) = explode(':', $db_conn);
        //export to $host,$port,$dbname
        $dbinfo = explode(';', $str);
        foreach($dbinfo as $info)
            parse_str($info);
        $db=mysql_connect($host.':'.$port,$db_user,$db_pw);
        mysql_select_db($dbname, $db);
        return $db;
    }

    /**
    * get schema file
    *
    * @param string $file schema filename
    *
    * @return string
    */
    protected function getSql($path){
        if (strpos('/',$path) === false)
            $filePath = Yii::getPathOfAlias($path).'.sql';
        else
            $filePath = $path;
        if (file_exists($filePath) === false) {
            throw new Exception("File not found '{$filePath}.");
        }

        //mb_internal_encoding('UTF-8');
        $sql = @file_get_contents($filePath);
        //remove comment
        $sql = preg_replace('/\/\*.*?\*\/;/', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//', '', $sql);
        return $sql;
    }

    /**
    * finish install applcation
    * redirect user to admin panel or home site.
    *
    * @return void
    */
    public function actionStep4() {
        $model = new UserForm();
        if (isset($_POST['UserForm']) === true) {
            $model->attributes=$_POST['UserForm'];
            if($model->validate() === true)
            {
                
                $db_conn = Yii::app()->session['web_manager_db_type'].':host='.Yii::app()->session['web_manager_host'].';port='.Yii::app()->session['web_manager_port'].';dbname='.Yii::app()->session['web_manager_db'];
	        	$db_user = Yii::app()->session['web_manager_username'];
	        	$db_pw = Yii::app()->session['web_manager_password'];
	            $connection=new CDbConnection($db_conn, $db_user, $db_pw);
	            $connection->charset='utf8';
	            $connection->active=true;
	            
	            
                
                //Administrator account                
                $password = $model->password;
                $model->password = md5($model->password);
                if ( Yii::app()->session['web_manager_db_type'] == 'mysql' )
                	$command=$connection->createCommand("INSERT INTO user (username, password, language, role, email) VALUES ('$model->username', '$model->password', 0, 1, '$model->email')");
                else
                	$command=$connection->createCommand("INSERT INTO \"user\" (username, password, language, role, email) VALUES ('$model->username', '$model->password', 0, 1, '$model->email')");
	            $rowCount=$command->execute();
                
               
                
                if ($rowCount > 0 ) {
                	Yii::app()->session['username'] = $model->username;
                	Yii::app()->session['password'] = $password;
                	unset(Yii::app()->session['web_manager_db_type']);
	                unset(Yii::app()->session['web_manager_username']);
	                unset(Yii::app()->session['web_manager_password']);
	                unset(Yii::app()->session['web_manager_host']);
	                unset(Yii::app()->session['web_manager_port']);
	                unset(Yii::app()->session['web_manager_db']);
	                unset(Yii::app()->session['web_htcheck_username']);
	                unset(Yii::app()->session['web_htcheck_password']);
	                unset(Yii::app()->session['web_htcheck_host']);
	                unset(Yii::app()->session['web_htcheck_port']);
	                unset(Yii::app()->session['web_htcheck_db']);
                    $this->render('Finish');
                    Yii::app()->end();
                }
            }
        }
        $this->render('Step4', array('model' => $model));
    }

    

    /**
    * send environment.php file
    *
    * @return void
    */
    public function actionDownloadEnvironment() {
        if (Yii::app()->session->contains('env') === true) {
            $fileName = 'environment.php';
            $content = Yii::app()->session['env'];
            $mimeType = 'txt/php';
            Yii::app()->request->sendFile($fileName, $content, $mimeType);
        } else {
            throw new CHttpException(404,'File not found. Your session might be expired, please try again.');
        }
    }

   
    protected function initDbConnection( $db_conn, $db_user, $db_pw ) {
        include_once Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'db.php';
        include_once Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'db_web_manager.php';
        $db = Yii::createComponent(array(
            'connectionString'=>$db_conn,
            'username'=>$db_user,
            'password'=>$db_pw,
            'charset'=>'utf8',
            'emulatePrepare' => true,
            'enableParamLogging'=>true,
        ));
        Yii::app()->setComponent('db', $db);
        $db = Yii::createComponent(array(
            'class'=>'CDbConnection',
            'connectionString'=>$db_conn,
            'username'=>$db_user,
            'password'=>$db_pw,
            'charset'=>'utf8',
            'emulatePrepare' => true,
            'enableParamLogging'=>true,
        ));
        Yii::app()->setComponent('db_web_manager', $db_web_manager);
    }
}

