<?php

class CrawlerLogTest extends WebTestCase
{
	public $fixtures=array(
		'crawlerLogs'=>'CrawlerLog',
	);

	public function testShow()
	{
		$this->open('?r=crawlerLog/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=crawlerLog/create');
	}

	public function testUpdate()
	{
		$this->open('?r=crawlerLog/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=crawlerLog/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=crawlerLog/index');
	}

	public function testAdmin()
	{
		$this->open('?r=crawlerLog/admin');
	}
}
