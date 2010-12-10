<?php

/**
 * This is the model class for table "HtmlStatement".
 *
 * The followings are the available columns in table 'HtmlStatement':
 * @property integer $IDUrl
 * @property integer $TagPosition
 * @property integer $Row
 * @property integer $Col
 * @property string $Tag
 * @property string $Statement
 * @property integer $LinkTagPosition
 * @property string $LinkDescription
 */
class HtmlStatement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return HtmlStatement the static model class
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
		return 'HtmlStatement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDUrl, TagPosition, Row, Col, LinkTagPosition', 'numerical', 'integerOnly'=>true),
			array('Tag', 'length', 'max'=>32),
			array('Statement, LinkDescription', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDUrl, TagPosition, Row, Col, Tag, Statement, LinkTagPosition, LinkDescription', 'safe', 'on'=>'search'),
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
			'TagPosition' => 'Tag Position',
			'Row' => 'Row',
			'Col' => 'Col',
			'Tag' => 'Tag',
			'Statement' => 'Statement',
			'LinkTagPosition' => 'Link Tag Position',
			'LinkDescription' => 'Link Description',
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

		$criteria->compare('IDUrl',$this->IDUrl);

		$criteria->compare('TagPosition',$this->TagPosition);

		$criteria->compare('Row',$this->Row);

		$criteria->compare('Col',$this->Col);

		$criteria->compare('Tag',$this->Tag,true);

		$criteria->compare('Statement',$this->Statement,true);

		$criteria->compare('LinkTagPosition',$this->LinkTagPosition);

		$criteria->compare('LinkDescription',$this->LinkDescription,true);

		return new CActiveDataProvider('HtmlStatement', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}