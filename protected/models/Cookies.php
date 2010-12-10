<?php

/**
 * This is the model class for table "Cookies".
 *
 * The followings are the available columns in table 'Cookies':
 * @property integer $IDCookie
 * @property string $Name
 * @property string $Value
 * @property string $Path
 * @property string $Domain
 * @property integer $MaxAge
 * @property integer $Version
 * @property string $SrcUrl
 * @property string $Expires
 * @property integer $Secure
 * @property integer $DomainValid
 */
class Cookies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cookies the static model class
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
		return 'Cookies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Value', 'required'),
			array('IDCookie, MaxAge, Version, Secure, DomainValid', 'numerical', 'integerOnly'=>true),
			array('Name, Path, Domain, SrcUrl', 'length', 'max'=>255),
			array('Expires', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDCookie, Name, Value, Path, Domain, MaxAge, Version, SrcUrl, Expires, Secure, DomainValid', 'safe', 'on'=>'search'),
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
			'IDCookie' => 'Idcookie',
			'Name' => 'Name',
			'Value' => 'Value',
			'Path' => 'Path',
			'Domain' => 'Domain',
			'MaxAge' => 'Max Age',
			'Version' => 'Version',
			'SrcUrl' => 'Src Url',
			'Expires' => 'Expires',
			'Secure' => 'Secure',
			'DomainValid' => 'Domain Valid',
		);
	}
	
	/**	
	 * Get the count of records selected from the DB
	 * @return Integer count of records selected from the DB
	 */
	public function Cookies_results_count() {
		return Cookies::model()->countBySql( 
			'SELECT COUNT(*) FROM Cookies WHERE Name=:Name AND Value=:Value AND Path=:Path AND Domain=:Domain AND SrcUrl=:SrcUrl',
			array( 
				':Name' => $this->Name,
				':Value' => $this->Value,
				':Path' => $this->Path,
				':Domain' => $this->Domain,
				':SrcUrl' => $this->SrcUrl,
			)
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function Cookies_results()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'Name, Value, Path, Domain, SrcUrl';
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Value',$this->Value,true);
		$criteria->compare('Path',$this->Path,true);
		$criteria->compare('Domain',$this->Domain,true);
		$criteria->compare('SrcUrl',$this->SrcUrl,true);
		
		return new CActiveDataProvider('Cookies', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
		));
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

		$criteria->compare('IDCookie',$this->IDCookie);

		$criteria->compare('Name',$this->Name,true);

		$criteria->compare('Value',$this->Value,true);

		$criteria->compare('Path',$this->Path,true);

		$criteria->compare('Domain',$this->Domain,true);

		$criteria->compare('MaxAge',$this->MaxAge);

		$criteria->compare('Version',$this->Version);

		$criteria->compare('SrcUrl',$this->SrcUrl,true);

		$criteria->compare('Expires',$this->Expires,true);

		$criteria->compare('Secure',$this->Secure);

		$criteria->compare('DomainValid',$this->DomainValid);

		return new CActiveDataProvider('Cookies', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}