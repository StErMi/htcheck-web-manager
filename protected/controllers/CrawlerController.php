<?php

class CrawlerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array( 'test', 'crawlerAutoCompleteLookup' ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view', 'create','update', 'admin','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionTest()
    {
    	$HTCHECK_BINDIR='/opt/htcheck/bin';
    	$HTCHECK_BINDIR='/usr/bin';
        $path = Yii::getPathOfAlias('application');
        $path = str_replace('/protected', '', $path);
    	$cronTabsDone = array();
        $pids = array();
        $crawler_list = array();
        $cronTabs = CrawlerCrontab::model()->findAll(); //Controllo prima se ci sono fra i cronjob
        foreach ( $cronTabs as $c ) {
        	//Controllo se il cron e' attivabile. Se e' attivabile controllo se il crwler al momento si sta aggiornando o meno
        	$passed = $this->checkCron($c);
        	if ( $passed )
        		$cronTabsDone[$c->crawler_id] = $c->crawler_id;
        	//$c->delete();
        }
        
        // Controllo se sono presenti fra i le richieste effettuate manualmente
        $queue = CrawlerQueue::model()->findAll();
        foreach ( $queue as $q ) {
        	if (!array_key_exists($q->crawler_id, $cronTabsDone))
        		$cronTabsDone[$q->crawler_id] = $q->crawler_id;
        	$q->delete();
        }
        
        
        
        foreach ( $cronTabsDone as $cID ) {
        	$crawler = Crawler::model()->findByPk($cID);
        	// Check if config file exist.
        	if ( $crawler !== null && $crawler->status == Crawler::STATUS_READY ) {
        		$crawler_list[] = $crawler;
        		$crawler->status = Crawler::STATUS_BUSY;
        		$crawler->save(false);
        		
        		$pids[$cID] = popen($HTCHECK_BINDIR . '/htcheck -vsi -c '.$path.'/crawlers_config/'.$crawler->db_name_prepend.$crawler->db_name.'.conf > '. $path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.out 2>&1' , 'r');
        		//$pids[$cID] = popen($HTCHECK_BINDIR . '/htcheck -vsi -c '.$path.'/crawlers_config/'.$crawler->db_name_prepend.$crawler->db_name.'.conf' , 'r');
        	} else {
        		$confPath = $path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.out';
				$fh = fopen($confPath, 'w') or die("can't open file");
				$confContent = 'db: '.$crawler->db_name_prepend . $crawler->db_name. ' - cstatus: ' . $crawler->status ;
				
				fwrite($fh, $confContent);
				fclose($fh);
        	}
        }
        
    	/*for($i = 0; $i < count($pids); $i++) {
		  pclose($pids[$i]);
		}*/
        
        foreach ( $crawler_list as $crawler ) {
        	pclose($pids[$crawler->id]);
        }
        
		foreach ( $crawler_list as $crawler ) {
			//pclose($pids[$crawler->id]);
			//usleep(500000);
			$db = $crawler->db_name_prepend . $crawler->db_name;
			$config = Configuration::model()->find();
			$connection = new CDbConnection('mysql:host='.$config->htcheck_host.';port='.$config->htcheck_host.';dbname='.$db, $config->htcheck_user, $config->htcheck_password);
			$connection->setActive(true);
			
			$command = $connection->createCommand('SELECT * FROM htCheck');
			$dataReader = $command->query();
			$cLog = new CrawlerLog();
			$dataReader = $dataReader->readAll();
			if ( count($dataReader) > 0 ) {
				$reader = $dataReader[0];
				$cLog->crawler_id = $crawler->id;
				$cLog->version = $reader['Version'];
				$cLog->start_time = $reader['StartTime'];
				$cLog->end_time = $reader['EndTime'];
				$cLog->scheduled_urls = $reader['ScheduledUrls'];
				$cLog->tot_urls = $reader['TotUrls'];
				$cLog->retrieved_urls = $reader['RetrievedUrls'];
				$cLog->tcp_connections = $reader['TCPConnections'];
				$cLog->server_changes = $reader['ServerChanges'];
				$cLog->http_requests = $reader['HTTPRequests'];
				$cLog->http_seconds = $reader['HTTPSeconds'];
				$cLog->http_bytes = $reader['HTTPBytes'];
				$cLog->accessibility_checks = $reader['AccessibilityChecks'];
				$cLog->htdig_notification = $reader['HtDigNotification'];
				$cLog->user = $reader['User'];
				
				$cLog->save(false);
			} else {
				$confPath = $path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.out';
				$fh = fopen($confPath, 'w') or die("can't open file");
				$confContent = 'db: '.$crawler->db_name_prepend . $crawler->db_name. ' - cdr: ' . count($dataReader) . ' - dr: '.print_r($dataReader);
				
				fwrite($fh, $confContent);
				fclose($fh);
			}
			
			$crawler->status = Crawler::STATUS_READY;
        	$crawler->save(false);
        	
		}
    }
    
    public function checkCron( $c ) {
    	$now = getdate();
    	$passed = true;
        if ( $c->minute != $now['minutes'] )
        	$passed = false;
        if ( $passed && $c->hour != $now['hours'] )
        	$passed = false;
        if ( $passed && $c->day != '*' && $c->day !=  $now['mday'] )
        	$passed = false;
        if ( $passed && $c->weekday != '*' && $c->weekday !=  $now['wday'] )
        	$passed = false;
        if ( $passed && $c->month != '*' && $c->month !=  $now['mon'] )
        	$passed = false;
        return $passed;
    }
	
	
	function init()
    {
    	parent::init();
    	
    	/* Controlli e gestione della lingua */
    	if ( !Yii::app()->user->isGuest ) {
        	$app->session['_lang'] = User::getLanguage();
        }
        
        if (isset($app->session['_lang']))
            $app->language = $app->session['_lang'];
        else
            $app->session['_lang'] = $app->language;
    	
        /* Controllo e gestione del cambio del DB */
        /* E' necessario risettare tutte le volte il db altrimenti rimette le impostazioni di default */
        
    	$app = Yii::app();
        if (isset($_POST['_db']))
        {
        	list( $db_prepend, $db ) = explode( '|', $_POST['_db'] );
        	$app->session['_db_prepend'] = $db_prepend;
        	$app->session['_db'] = $db;
        	$db_name = str_replace( Yii::app()->session['_db_prepend'], '', Yii::app()->session['_db']);
			$crawler = Crawler::model()->find('db_name=? AND db_name_prepend=?',array($db_name, Yii::app()->session['_db_prepend']));
			$app->session['_crawler_id'] = $crawler->id;
        	$request = $app->getRequest();
        	
        	$connConf = Configuration::model()->find();
        	
        	//E' stato effettuato lo switch su un altro DB e' necessario controllare che l'utente esiste anche sull'altro DB e abbia certi permessi
        	try {
		        Yii::app()->db->setActive(false);
				Yii::app()->db->connectionString = 'mysql:host='.$connConf->htcheck_host.';port='.$connConf->htcheck_port.';dbname='.$app->session['_db'];
				Yii::app()->db->setActive(true);
        	} catch ( Exception $e ) {
        		$this->redirect( array('htCheck/empty' ) );
        	}	
            
            if (  Yii::app()->user->isGuest ) {
            	Yii::app()->user->setReturnUrl($request->getUrl());
            	$this->redirect( array('site/login' ) );
            }
            
            unset($_POST['_db']); 
        }
        
   		if ( empty( $app->session['_db'] ) || $app->session['_db'] == '' ) 
        	;
        else {
        	$connConf = Configuration::model()->find();
	        try {
		        Yii::app()->db->setActive(false);
				Yii::app()->db->connectionString = 'mysql:host='.$connConf->htcheck_host.';port='.$connConf->htcheck_port.';dbname='.$app->session['_db'];
				Yii::app()->db->setActive(true);
        	} catch ( Exception $e ) {
        		$this->redirect( array('htCheck/empty' ) );
        	}	
        }
        	
    }

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		
		$model = $this->loadModel();
		
		if ( !$model->userHasOwnPermission('read') )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		try {
		$connConf = Configuration::model()->find();
	        Yii::app()->session['_db_prepend'] = $model->db_name_prepend;
	        Yii::app()->session['_db'] = $model->db_name_prepend.$model->db_name;
			Yii::app()->session['_crawler_id'] = $model->id;
			
			Yii::app()->db->setActive(false);
			Yii::app()->db->connectionString = 'mysql:host='.$connConf->htcheck_host.';port='.$connConf->htcheck_port.';dbname='.Yii::app()->session['_db'];
			Yii::app()->db->setActive(true);
        } catch ( Exception $e ) {
        	$this->redirect( array('htCheck/empty' ) );
        }
        
		
		$this->redirect(array('htCheck/index'));
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		
		
		$model=new Crawler('create');
		$model->initDefault();
		
		if ( !User::checkRole(User::ROLE_ADMIN)  )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Crawler']))
		{
			$model->attributes=$_POST['Crawler'];
			if($model->save()){
				$model->saveConfig();
				$this->redirect(array('view', 'id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		
		if ( !$model->userHasOwnPermission('config')  )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Crawler']))
		{
			$model->attributes=$_POST['Crawler'];
			if($model->save()) {
				$model->saveConfig();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		
		
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			if ( !$model->userHasOwnPermission('admin') )
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Crawler');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Crawler('search');
		
		$finded = false;
		$u = User::getMe();
		$permissions = $u->getPermissions();
		foreach ( $permissions as $p ) {
			if ( $p['admin'] == true ) {
				$finded = true;
				break;
			}
		}
		
		if ( !$model->userHasOwnPermission('admin') && !$finded )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Crawler']))
			$model->attributes=$_GET['Crawler'];

		$this->render('admin',array(
			'model'=>$model,
			'user'=>$u,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Crawler::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='crawler-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionCrawlerAutoCompleteLookup()
    {
       if(Yii::app()->request->isAjaxRequest && isset($_GET['q']))
       {
            /* q is the default GET variable name that is used by
            / the autocomplete widget to pass in user input
            */
          $name = $_GET['q']; 
                    // this was set with the "max" attribute of the CAutoComplete widget
          $limit = min($_GET['limit'], 50); 
          $criteria = new CDbCriteria;
          
          $criteria->condition = "(title LIKE :sterm OR db_name LIKE :sterm) AND id=".$_GET['crawler_id'];
          $criteria->params = array(":sterm"=>"%$name%");
          
          $criteria->limit = $limit;
          $modelArray = Crawler::model()->findAll($criteria);
          $returnVal = '';
          foreach($modelArray as $model)
          {
          	$returnVal .= $model->getAttribute('title').'|'.$model->getAttribute('id')."\n";
             
          }
          echo $returnVal;
       }
    }
}

