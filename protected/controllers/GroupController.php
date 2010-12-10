<?php

class GroupController extends Controller
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view', 'manageUser', 'create','update', 'admin','delete', 'deleteFromGroup', 'addToGroup'),
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
		
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Group;
		
		if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		// Initialisation
		$cgArray = array();
		$clTitle = array();
		$cl = Crawler::model()->findAll(); //list of crawlers
		
		foreach ( $cl as $c ) {
			$clTitle[$c->id] = $c->title;
			$cgArray[$c->id] = new GroupCrawler;
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			
			
			foreach ( $cgArray as $crawlerID => $m ) {
				$cgArray[$crawlerID]->read = $_POST['GroupCrawler']['read'][$crawlerID];
				$cgArray[$crawlerID]->config = $_POST['GroupCrawler']['config'][$crawlerID];
				$cgArray[$crawlerID]->cron = $_POST['GroupCrawler']['cron'][$crawlerID];
				$cgArray[$crawlerID]->admin = $_POST['GroupCrawler']['admin'][$crawlerID];
			}
			
			
			if($model->save()) {
				//Salvo tutti i GroupCrawler
				foreach ( $cgArray as $crawlerID => $m ) {
					$m->crawler_id = $crawlerID;
					$m->group_id = $model->id;
					$m->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'cgArray'=>$cgArray,
			'clTitle' => $clTitle,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		
		$model=$this->loadModel();
		
		if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		//Prendo i GroupCrawler gia' inseriti nel database
		//$model->crawler_groups;
		$cgArray = array(); //array di GroupCrawler
		$clTitle = array();
		$crawlerAlreadyIn = array();
		foreach ( $model->crawler_groups as $cg ) {
			$cgArray[$cg->crawler_id] = $cg;
			$crawlerAlreadyIn[$cg->crawler_id] = $cg->crawler_id;
		}
		
		//Adesso devo aggiungere i crawler a cui non e' ancora stato dato un gruppo
		$cl = Crawler::model()->findAll(); //list of crawlers
		
		foreach ( $cl as $c ) {
			if ( !in_array($c->id, $crawlerAlreadyIn) )
				$cgArray[$c->id] = new GroupCrawler;
			$clTitle[$c->id] = $c->title;
		}
		
		//exit(print_r($cgArray));
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			
			
			foreach ( $cgArray as $crawlerID => $m ) {
				$cgArray[$crawlerID]->read = $_POST['GroupCrawler']['read'][$crawlerID];
				$cgArray[$crawlerID]->config = $_POST['GroupCrawler']['config'][$crawlerID];
				$cgArray[$crawlerID]->cron = $_POST['GroupCrawler']['cron'][$crawlerID];
				$cgArray[$crawlerID]->admin = $_POST['GroupCrawler']['admin'][$crawlerID];
			}
			
			
			if($model->save()) {
				//Salvo tutti i GroupCrawler
				foreach ( $cgArray as $crawlerID => $m ) {
					$m->crawler_id = $crawlerID;
					$m->group_id = $model->id;
					$m->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'cgArray'=>$cgArray,
			'clTitle' => $clTitle,
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
			
			if ( !User::checkRole(User::ROLE_ADMIN) )
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
			
			$ul = $model->users;
			
			$model->delete();
			
			foreach ( $ul as $u )
				$u->setCrawlersPermissions(); //Group has been deleted. Needed to refresh his permissions.

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		/*if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		$dataProvider=new CActiveDataProvider('Group');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Group']))
			$model->attributes=$_GET['Group'];

		$this->render('admin',array(
			'model'=>$model,
		));
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Group']))
			$model->attributes=$_GET['Group'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAddToGroup() {
		
		if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		if(Yii::app()->request->isPostRequest)
		{
			if ( !isset($_GET['id']) || !isset($_GET['user_id']) )
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again. Missing parameters for the requested opetation.');
				
			$ug = new UserGroup;
			$ug->user_id = $_GET['user_id'];
			$ug->group_id = $_GET['id'];
			$ug->save(false);
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
				
		} else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionDeleteFromGroup() {
		
		if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		if(Yii::app()->request->isPostRequest)
		{
			if ( !isset($_GET['id']) || !isset($_GET['user_id']) )
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again. Missing parameters for the requested opetation.');
				
			$ug = UserGroup::model()->find('user_id=? AND group_id=?', array( $_GET['user_id'] , $_GET['id']));
			if ( $ug === null )
				throw new CHttpException(400,'Invalid request. Please do not repeat this request againz.');
			$user = $ug->user;
			$ug->delete();
			// UserGroup deleted, now the system refresh in real-time the related user permissions
			$user->setCrawlersPermissions();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
				
		} else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionManageUser() {
		
		if ( !User::checkRole(User::ROLE_ADMIN) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
		
		$model=$this->loadModel();
		
		$userIN=new User('searchGroup');
		$userIN->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$userIN->attributes=$_GET['User'];
			
		$userOUT=new User('searchGroup');
		$userOUT->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$userOUT->attributes=$_GET['User'];

		$this->render('manageUser',array(
			'model'=>$model,
			'userOUT'=>$userOUT,
			'userIN'=>$userIN,
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
				$this->_model=Group::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
