<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $id
 * @property string $title
 */
class Group extends WebManagerActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return group the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'crawler_groups' => array(self::HAS_MANY, 'GroupCrawler', 'group_id'),
			'users'=>array(self::MANY_MANY, 'User', 'user_group(group_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
		);
	}
	
	/**
	 * This is invoked before the record is deleted.
	 */
	protected function beforeDelete()
	{
		parent::beforeDelete();
		
		//deleting all references to the crawler
		$ml = UserGroup::model()->findAll('group_id=?', array($this->id));
		foreach ( $ml as $m ) $m->delete();
		$ml = GroupCrawler::model()->findAll('group_id=?', array($this->id));
		foreach ( $ml as $m ) $m->delete();
		
		
		return true;
	}
	
	
	/**
	 * @return string the URL that shows the detail of the Group
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('group/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->order = 'title ASC';
		return new CActiveDataProvider('Group', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPageGroup'],
			),
		));
	}
	
	public function searchUser( $userID, $inGroup ) {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		
		$u = User::model()->findByPk($userID);
		$addedList = array();
		foreach ( $u->user_groups as $g  )
			$addedList[$g->id] = $g->id;
		
		
		$ap = new CActiveDataProvider('Group', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
		
		$data = $ap->getData();
		$newData = array();
		foreach  ( $data as $m ) {
			if ( $inGroup && in_array($m->id, $addedList)) $newData[] = $m;
			if ( !$inGroup && !in_array($m->id, $addedList)) $newData[] = $m;
		}
		
		$ap->setData($newData);
		return $ap;
		
	}
}
