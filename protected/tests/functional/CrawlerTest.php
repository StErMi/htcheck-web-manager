<?php

class CrawlerTest extends WebTestCase
{
	public $fixtures=array(
		'crawlers'=>'Crawler',
	);

	public function testShow()
	{
		$this->open('?r=crawler/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=crawler/create');
	}

	public function testUpdate()
	{
		$this->open('?r=crawler/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=crawler/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=crawler/index');
	}

	public function testAdmin()
	{
		$this->open('?r=crawler/admin');
	}
}
