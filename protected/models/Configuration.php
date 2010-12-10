<?php

/**
 * This is the model class for table "configuration".
 *
 * The followings are the available columns in table 'configuration':
 * @property integer $webmanger_host
 * @property integer $webmanger_db
 * @property integer $webmanger_user
 * @property integer $webmanger_password
 * @property integer $htcheck_host
 * @property integer $htcheck_db
 * @property integer $htcheck_user
 * @property integer $htcheck_password
 */
class Configuration extends WebManagerActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Configuration the static model class
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
		return 'configuration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('webmanger_db_type, webmanger_host, webmanger_port, webmanger_db, webmanger_user, webmanger_password, htcheck_host, htcheck_port, htcheck_db, htcheck_user, htcheck_password', 'required'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('webmanger_db_type, webmanger_host, webmanger_port, webmanger_db, webmanger_user, webmanger_password, htcheck_host, htcheck_port, htcheck_db, htcheck_user, htcheck_password', 'safe', 'on'=>'search'),
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
			'webmanger_host' => 'Webmanger Host',
			'webmanger_db' => 'Webmanger Db',
			'webmanger_user' => 'Webmanger User',
			'webmanger_password' => 'Webmanger Password',
			'htcheck_host' => 'Htcheck Host',
			'htcheck_db' => 'Htcheck Db',
			'htcheck_user' => 'Htcheck User',
			'htcheck_password' => 'Htcheck Password',
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

		$criteria->compare('webmanger_host',$this->webmanger_host);

		$criteria->compare('webmanger_db',$this->webmanger_db);

		$criteria->compare('webmanger_user',$this->webmanger_user);

		$criteria->compare('webmanger_password',$this->webmanger_password);

		$criteria->compare('htcheck_host',$this->htcheck_host);

		$criteria->compare('htcheck_db',$this->htcheck_db);

		$criteria->compare('htcheck_user',$this->htcheck_user);

		$criteria->compare('htcheck_password',$this->htcheck_password);

		return new CActiveDataProvider('Configuration', array(
			'criteria'=>$criteria,
		));
	}
}