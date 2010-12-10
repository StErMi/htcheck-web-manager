<?php

Yii::import('zii.widgets.CPortlet');

class AdminMenu extends CPortlet
{
	public $full;
	
	public function init()
	{
		$this->title='Admin Menu';
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('adminMenu', array('full'=>$this->full));
	}
}