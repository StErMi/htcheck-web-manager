<?php

class CrawlerQueueTest extends WebTestCase
{
	public $fixtures=array(
		'crawlerQueues'=>'CrawlerQueue',
	);

	public function testShow()
	{
		$this->open('?r=crawlerQueue/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=crawlerQueue/create');
	}

	public function testUpdate()
	{
		$this->open('?r=crawlerQueue/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=crawlerQueue/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=crawlerQueue/index');
	}

	public function testAdmin()
	{
		$this->open('?r=crawlerQueue/admin');
	}
}
