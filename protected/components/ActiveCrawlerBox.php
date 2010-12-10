<?php

Yii::import('zii.widgets.CPortlet');

class ActiveCrawlerBox extends CPortlet
{
	
	public function init()
	{
		$this->title='Active Crawlers';
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('activeCrawlerBox');
	}
}