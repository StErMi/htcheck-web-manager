<?php

class GroupCrawlerTest extends WebTestCase
{
	public $fixtures=array(
		'groupCrawlers'=>'GroupCrawler',
	);

	public function testShow()
	{
		$this->open('?r=groupCrawler/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=groupCrawler/create');
	}

	public function testUpdate()
	{
		$this->open('?r=groupCrawler/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=groupCrawler/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=groupCrawler/index');
	}

	public function testAdmin()
	{
		$this->open('?r=groupCrawler/admin');
	}
}
