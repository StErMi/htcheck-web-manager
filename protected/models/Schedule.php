<?php

/**
 * This is the model class for table "Schedule".
 *
 * The followings are the available columns in table 'Schedule':
 * @property integer $IDUrl
 * @property integer $IDServer
 * @property string $Url
 * @property string $Status
 * @property string $Domain
 * @property string $CreationTime
 * @property integer $IDReferer
 * @property integer $HopCount
 */
class Schedule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Schedule the static model class
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
		return 'Schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDUrl, IDServer, IDReferer, HopCount', 'numerical', 'integerOnly'=>true),
			array('Url', 'length', 'max'=>255),
			array('Status', 'length', 'max'=>15),
			array('Domain', 'length', 'max'=>8),
			array('CreationTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDUrl, IDServer, Url, Status, Domain, CreationTime, IDReferer, HopCount', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'IDUrl' => 'Idurl',
			'IDServer' => 'Idserver',
			'Url' => 'Url',
			'Status' => 'Status',
			'Domain' => 'Domain',
			'CreationTime' => 'Creation Time',
			'IDReferer' => 'Idreferer',
			'HopCount' => 'Hop Count',
			'StatusUpdate' => 'Status Update'
		);
	}
	
	/**
	 * @return string the URL that shows the detail of the Schedule
	 */
	public function getUrl( $IDUrl = -1)
	{
		if ( $IDUrl == -1 )
			return Yii::app()->createUrl('url/view', array( 'id'=>$this->IDUrl ));
		else
			return Yii::app()->createUrl('url/view', array( 'id'=>$IDUrl ));
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

		$criteria->compare('IDUrl',$this->IDUrl);

		$criteria->compare('IDServer',$this->IDServer);

		$criteria->compare('Url',$this->Url,true);

		$criteria->compare('Status',$this->Status,true);

		$criteria->compare('Domain',$this->Domain,true);

		$criteria->compare('CreationTime',$this->CreationTime,true);

		$criteria->compare('IDReferer',$this->IDReferer);

		$criteria->compare('HopCount',$this->HopCount);

		return new CActiveDataProvider('Schedule', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}