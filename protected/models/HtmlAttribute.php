<?php

/**
 * This is the model class for table "HtmlAttribute".
 *
 * The followings are the available columns in table 'HtmlAttribute':
 * @property integer $IDUrl
 * @property integer $TagPosition
 * @property integer $AttrPosition
 * @property string $Attribute
 * @property string $Content
 */
class HtmlAttribute extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return HtmlAttribute the static model class
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
		return 'HtmlAttribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDUrl, TagPosition, AttrPosition', 'numerical', 'integerOnly'=>true),
			array('Attribute', 'length', 'max'=>32),
			array('Content', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDUrl, TagPosition, AttrPosition, Attribute, Content', 'safe', 'on'=>'search'),
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
			'AttrPosition' => 'Attr Position',
			'Attribute' => 'Attribute',
			'Content' => 'Content',
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

		$criteria->compare('AttrPosition',$this->AttrPosition);

		$criteria->compare('Attribute',$this->Attribute,true);

		$criteria->compare('Content',$this->Content,true);

		return new CActiveDataProvider('HtmlAttribute', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}