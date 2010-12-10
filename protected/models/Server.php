<?php

/**
 * This is the model class for table "Server".
 *
 * The followings are the available columns in table 'Server':
 * @property integer $IDServer
 * @property string $Server
 * @property string $IPAddress
 * @property integer $Port
 * @property string $HttpServer
 * @property string $HttpVersion
 * @property integer $PersistentConnection
 * @property integer $Requests
 */
class Server extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Server the static model class
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
		return 'Server';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDServer, Port, PersistentConnection, Requests', 'numerical', 'integerOnly'=>true),
			array('Server, HttpServer, HttpVersion', 'length', 'max'=>255),
			array('IPAddress', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDServer, Server, IPAddress, Port, HttpServer, HttpVersion, PersistentConnection, Requests', 'safe', 'on'=>'search'),
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
			'IDServer' => 'Idserver',
			'Server' => 'Server',
			'IPAddress' => 'Ipaddress',
			'Port' => 'Port',
			'HttpServer' => 'Http Server',
			'HttpVersion' => 'Http Version',
			'PersistentConnection' => 'Persistent Connection',
			'Requests' => 'Requests',
		);
	}
	
	/**	
	 * Get the count of records selected from the DB
	 * @return Integer count of records selected from the DB
	 */
	public function Server_seen_count() {
		return Server::model()->countBySql( 
			'SELECT COUNT(*) FROM Server WHERE Server=:Server AND Port=:Port AND HttpServer=:HttpServer AND HttpVersion=:HttpVersion AND Requests>1',
			array( 
				':Server' => $this->Server,
				':Port' => $this->Port,
				':HttpServer' => $this->HttpServer,
				':HttpVersion' => $this->HttpVersion,
			)
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function Server_seen()
	{

		$criteria = new CDbCriteria;
		
		$criteria->select = 'Server, Port, HttpServer, HttpVersion, Requests';

		$criteria->compare('Server',$this->Server,true);
		$criteria->compare('Port',$this->Port);
		$criteria->compare('HttpServer',$this->HttpServer,true);
		$criteria->compare('HttpVersion',$this->HttpVersion,true);
		//$criteria->compare('Requests',$this->Requests);
		
		$criteria->addCondition( 'Requests>1' );
		$criteria->order = 'Requests DESC';


		return new CActiveDataProvider('Server', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
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

		$criteria->compare('IDServer',$this->IDServer);

		$criteria->compare('Server',$this->Server,true);

		$criteria->compare('IPAddress',$this->IPAddress,true);

		$criteria->compare('Port',$this->Port);

		$criteria->compare('HttpServer',$this->HttpServer,true);

		$criteria->compare('HttpVersion',$this->HttpVersion,true);

		$criteria->compare('PersistentConnection',$this->PersistentConnection);

		$criteria->compare('Requests',$this->Requests);

		return new CActiveDataProvider('Server', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}