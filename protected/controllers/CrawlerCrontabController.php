<?php

class CrawlerCrontabController extends Controller
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
				'actions'=>array('create','update', 'admin','delete'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CrawlerCrontab;
		$model2 = new CrawlerQueue;
		
		$crawler = Crawler::model()->findByPk($_GET['crawlerID']);
		if ( $crawler === null )
			throw new CHttpException(404,'The requested page does not exist. Invalid CrawlerID');
		
		if ( !$model->userHasOwnPermission('cron', $crawler->id) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CrawlerCrontab']))
		{
			$model->attributes=$_POST['CrawlerCrontab'];
			$model->crawler_id = $crawler->id;
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'Your programmed scan #'.$model->id.' has been <b>added</b> without problems! It will be served on <b>'.$model->toString().'</b>' );
				$this->redirect(array('admin','crawlerID'=>$crawler->id));
			}
		}
		
		if(isset($_POST['CrawlerQueue']))
		{
			$model2->attributes=$_POST['CrawlerQueue'];
			$model2->crawler_id = $crawler->id;
			$model2->user_id = User::getUserID();
			if($model2->save()) {
				Yii::app()->user->setFlash('success', 'Your manual scan #'.$model2->id.' has been <b>added</b> without problems! It will be served as soon as possible.');
				$this->redirect(array('admin','crawlerID'=>$crawler->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'model2'=>$model2,
			'crawler'=>$crawler,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		
		if ( !$model->userHasOwnPermission('cron', $model->crawler_id) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CrawlerCrontab']))
		{
			$model->attributes=$_POST['CrawlerCrontab'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'Your programmed scan #'.$model->id.' has been <b>updated</b> without problems! It will be served on <b>'.$model->toString().'</b>' );
				$this->redirect(array('admin','crawlerID'=>$model->crawler->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'crawler'=>$model->crawler,
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
			
			if ( !$model->userHasOwnPermission('cron', $model->crawler_id) )
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');
			
			Yii::app()->user->setFlash('success', 'Your programmed scan #'.$model->id.' has been <b>deleted</b> without problems!' );
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirect(array('admin','crawlerID'=>$model->crawler->id));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$crawler = Crawler::model()->findByPk($_GET['crawlerID']);
		if ( $crawler === null )
			throw new CHttpException(404,'The requested page does not exist. Invalid CrawlerID');
		
		
		$model=new CrawlerCrontab('search');
		
		if ( !$model->userHasOwnPermission('cron', $crawler->id) )
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again. You don\'t have sufficient permissions to access to this operation');	
			
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CrawlerCrontab']))
			$model->attributes=$_GET['CrawlerCrontab'];

		$this->render('admin',array(
			'model'=>$model,
			'crawler' => $crawler,
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
				$this->_model=CrawlerCrontab::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='crawler-crontab-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
