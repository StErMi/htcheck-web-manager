<?php

Yii::import('zii.widgets.CPortlet');

class UserMenu extends CPortlet
{
	public function init()
	{
		$this->title='User Menu';
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('userMenu');
	}
}