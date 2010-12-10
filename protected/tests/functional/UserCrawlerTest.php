<?php

class UserCrawlerTest extends WebTestCase
{
	public $fixtures=array(
		'userCrawlers'=>'UserCrawler',
	);

	public function testShow()
	{
		$this->open('?r=userCrawler/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=userCrawler/create');
	}

	public function testUpdate()
	{
		$this->open('?r=userCrawler/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=userCrawler/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=userCrawler/index');
	}

	public function testAdmin()
	{
		$this->open('?r=userCrawler/admin');
	}
}
