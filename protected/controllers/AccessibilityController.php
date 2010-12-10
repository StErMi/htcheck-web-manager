<?php

class AccessibilityController extends Controller
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
				'actions'=>array('index','view', 'search'),
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
        		$this->redirect( array('htCheck/empty' ) );
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
        		$this->redirect( array('htCheck/empty' ) );
        	}		
        }
        	
    }
    
    /**
	 * Manages all models.
	 */
	public function actionSearch()
	{
		$model=new Accessibility('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Accessibility']))
			$model->attributes=$_GET['Accessibility'];

		$this->render('search',array(
			'model'=>$model,
		));
	}
	

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$criteria=new CDbCriteria;
		$cWith = array();
		$cParam=array();
		$criteria->with = array('url', 'ha', 'hs');
		$criteria->condition='';
		
		if ( !empty($_GET['AttrPosition']) ) {
			//$criteria->with[] = 'ha';
			$criteria->condition.='AttrPosition=:AttrPosition AND ';
			$cParam[':AttrPosition'] = $_GET['AttrPosition'];
		} else {
			$criteria->condition.='AttrPosition IS NULL AND ';
		}
		
		if ( !empty($_GET['TagPosition']) ) {
			//$criteria->with[] = 'hs';
			$criteria->condition.='t.TagPosition=:tp AND ';
			$cParam[':tp'] = $_GET['TagPosition'];
		} else {
			$criteria->condition.='TagPosition IS NULL AND ';
		}
		
		$criteria->with = $cWith;
		$criteria->condition.='t.IDUrl=:IDUrl AND Code=:Code';
		$cParam[':IDUrl'] = $_GET['IDUrl'];
		$cParam[':Code'] = $_GET['Code'];
		$criteria->params=$cParam;
				
		$model = Accessibility::model()->find($criteria);
		$displayOps = Url::model()->find('IDUrl=? AND Contents IS NOT NULL', array($model->IDUrl));
		
		$this->render('view',array(
			'model'=>$model,
			'displayOps'=>$displayOps,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Accessibility');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
				$this->_model=Accessibility::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='accessibility-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
