<?php

/**
 * This is the model class for table "group_crawler".
 *
 * The followings are the available columns in table 'group_crawler':
 * @property integer $id
 * @property integer $group_id
 * @property integer $crawler_id
 * @property integer $read
 * @property integer $config
 * @property integer $cron
 * @property integer $admin
 */
class GroupCrawler extends WebManagerActiveRecord
{
	
	const NO=0;
	const YES=1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return GroupCrawler the static model class
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
		return 'group_crawler';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('crawler_id, group_id, read, config, cron, admin', 'required'),
			array('crawler_id, group_id, read, config, cron, admin', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, crawler_id, group_id, read, config, cron, admin', 'safe', 'on'=>'search'),
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
			'crawler' => array(self::BELONGS_TO, 'Crawler', 'crawler_id'),
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'group_id' => 'Group ID',
			'crawler_id' => 'Crawler',
			'read' => 'Read',
			'config' => 'Config',
			'cron' => 'Cron',
			'admin' => 'Admin',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('crawler_id',$this->crawler_id);
		
		$criteria->compare('group_id',$this->title);

		$criteria->compare('read',$this->read);

		$criteria->compare('config',$this->config);

		$criteria->compare('cron',$this->cron);

		$criteria->compare('admin',$this->admin);

		return new CActiveDataProvider('GroupCrawler', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}