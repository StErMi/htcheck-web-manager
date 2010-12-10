<?php

class HtCheckController extends Controller
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
				'actions'=>array( ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'empty'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
        		/*unset($app->session['_db_prepend']);
				unset($app->session['_db']);*/
        		//break;
        	}	
            
            if (  Yii::app()->user->isGuest ) {
            	Yii::app()->user->setReturnUrl($request->getUrl());
            	$this->redirect( array('site/login' ) );
            }
            
            unset($_POST['_db']); 
        }
        
    	if ( empty( $app->session['_db'] ) || empty( $app->session['_db_prepend'] ) ) {
        	unset($app->session['_db_prepend']);
			unset($app->session['_db']);
			//unset($app->session['_crawler_id']);
			$this->redirect( array('site/index' ) );
    	} else {
	        $connConf = Configuration::model()->find();
	        try {
		        Yii::app()->db->setActive(false);
				Yii::app()->db->connectionString = 'mysql:host='.$connConf->htcheck_host.';port='.$connConf->htcheck_port.';dbname='.$app->session['_db'];
				Yii::app()->db->setActive(true);
        	} catch ( Exception $e ) {
        		//unset($app->session['_db_prepend']);
				//unset($app->session['_db']);
        		//$this->redirect( array('htCheck/empty' ) );
        	}		
        }
        	
    }

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('index',array(
			'model'=>$this->loadModel(),
		));
	}

	
	/**
	 * Lists all models.
	 */
	public function actionEmpty()
	{
		
		$model = $this->loadModel();
		if ( $model !== null ) $this->redirect('index');
		$db = str_replace( Yii::app()->session['_db_prepend'], '', Yii::app()->session['_db']);
		$crawler = Crawler::model()->find('db_name=? AND db_name_prepend=?',array($db, Yii::app()->session['_db_prepend']));
		
		//Collectin all users of the db
		$crons = $crawler->crons;
		
		foreach ( $crawler->groups as $gc ) {
			foreach ( $gc->group->users as $u ) {
					$users[$u->id] = $u;
			}
		}
		foreach ( $crawler->users as $u ) {
			$users[$u->user->id] = $u->user;
		}
		
		unset(Yii::app()->session['_db_prepend']);
		unset(Yii::app()->session['_db']);
			
		$this->render('empty',array(
			'crawler'=>$crawler,
			'users'=>$users,
			'model'=> $model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Yii::import('application.extensions.crontab.Crontab');
		$model = $this->loadModel();
		
		if ( $model === null ) $this->redirect('empty');
		
		$tblnames = array("Schedule", "HtmlAttribute", "HtmlStatement", "Link", "Server", "Url");
		$num = count($tblnames);
		$db_info = array();
		
		$connection = $model->dbConnection;
		//TODO modificare con query count Yii
		foreach ( $tblnames as $t ) {
			$sql = 'SELECT count(*) as '.$t.' FROM ' . $t;
			$command = $connection->createCommand($sql);
			$count = $command->queryAll();
			
			$db_info[$t] = $count[0][$t];
		}
		
		/* HTTP results */
		$http_results = new Url('HTTP_results');
		$http_results->unsetAttributes();  // clear any default values
		if(isset($_GET['Url']))
			$http_results->attributes=$_GET['Url'];

		/* Servers seen */
		$server_seen = new Server('Server_seen');
		$server_seen->unsetAttributes();  // clear any default values
		if(isset($_GET['Server']))
			$server_seen->attributes=$_GET['Server'];
			
		/* Connection results */
		$connection_results = new Url('Connection_results');
		$connection_results->unsetAttributes();  // clear any default values
		if(isset($_GET['Url']))
			$connection_results->attributes=$_GET['Url'];
			
		/* Content-Type results */
		$contenttype_results = new Url('ContentType_results');
		$contenttype_results->unsetAttributes();  // clear any default values
		if(isset($_GET['Url']))
			$contenttype_results->attributes=$_GET['Url'];	
			
		/* Cookies */
		$cookies_results = new Cookies('Cookies_results');
		$cookies_results->unsetAttributes();  // clear any default values
		if(isset($_GET['Cookies']))
			$cookies_results->attributes=$_GET['Cookies'];		
			
		
		
		//Crawler
		$db = str_replace( Yii::app()->session['_db_prepend'], '', Yii::app()->session['_db']);
		$crawler = Crawler::model()->find('db_name=? AND db_name_prepend=?',array($db, Yii::app()->session['_db_prepend']));
		
		//Collectin all users of the db
		foreach ( $crawler->groups as $gc ) {
			foreach ( $gc->group->users as $u ) {
					$users[$u->id] = $u;
			}
		}
		foreach ( $crawler->users as $u ) {
			$users[$u->user->id] = $u->user;
		}
		
		$this->render('index',array(
			'users'=>$users,
			'model'=> $model,
			'db_info' => $db_info,
			'http_results' => $http_results,
			'server_seen' => $server_seen,
			'connection_results' => $connection_results,
			'contenttype_results' => $contenttype_results,
			'cookies_results' => $cookies_results,
			'crawler'=>$crawler,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		
		$currentDb = Yii::app()->session['_db'];
		if ( empty( $currentDb ) || $currentDb == '' ) 
        	throw new CHttpException(404,'No database selected. Please select one.');
		
		if($this->_model===null)
		{
			/*
			 * Essendoci un solo record per volta devo provare a caricare quello.
			 */
			try {
				$this->_model=HtCheck::model()->find();
			} catch ( Exception $e ) {
				$this->_model=null;
        		return $this->_model;
        	}	
			if($this->_model===null) {
				$db = str_replace( Yii::app()->session['_db_prepend'], '', Yii::app()->session['_db']);
				$crawler = Crawler::model()->find('db_name=? AND db_name_prepend=?',array($db, Yii::app()->session['_db_prepend']));
				
				if ( $crawler === null )
					throw new CHttpException(404,'The requested page does not exist.');
				else {
					$this->redirect(array('empty'));
				}
			}
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	/*protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='HtCheck-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}*/
}

