<?php

Yii::import('zii.widgets.CPortlet');

class DbBox extends CPortlet
{

    public $crawler_list;
	public $title='Database List';

	protected function renderContent()
	{
		$currentDb = null;
		if ( isset(Yii::app()->session['_db_prepend']) && isset(Yii::app()->session['_db']) )
			$currentDb = Yii::app()->session['_db_prepend'].'|'.Yii::app()->session['_db'];
		
		/*if ( empty( $currentDb ) || $currentDb == '' ) 
        	throw new CHttpException(404,'No database selected. Please select one.');*/
		$this->render('dbBox', array('currentDb' => $currentDb, 'crawler_list' => $this->crawler_list));
	}
    
}
