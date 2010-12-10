<?php

class CrawlerCrontabTest extends WebTestCase
{
	public $fixtures=array(
		'crawlerCrontabs'=>'CrawlerCrontab',
	);

	public function testShow()
	{
		$this->open('?r=crawlerCrontab/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=crawlerCrontab/create');
	}

	public function testUpdate()
	{
		$this->open('?r=crawlerCrontab/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=crawlerCrontab/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=crawlerCrontab/index');
	}

	public function testAdmin()
	{
		$this->open('?r=crawlerCrontab/admin');
	}
}
