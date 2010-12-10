<?php

class GroupTest extends WebTestCase
{
	public $fixtures=array(
		'groups'=>'Group',
	);

	public function testShow()
	{
		$this->open('?r=group/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=group/create');
	}

	public function testUpdate()
	{
		$this->open('?r=group/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=group/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=group/index');
	}

	public function testAdmin()
	{
		$this->open('?r=group/admin');
	}
}
