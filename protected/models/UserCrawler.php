<?php

/**
 * This is the model class for table "user_crawler".
 *
 * The followings are the available columns in table 'user_crawler':
 * @property integer $id
 * @property integer $user_id
 * @property integer $crawler_id
 * @property integer $can_read
 * @property integer $admin
 */
class UserCrawler extends WebManagerActiveRecord
{
	
	const NULL=0;
	const NO=1;
	const YES=2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return user_crawler the static model class
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
		return 'user_crawler';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, crawler_id, can_read, admin', 'required'),
			array('user_id, crawler_id, can_read, admin', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, crawler_id, read, admin', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'user_id' => 'User',
			'crawler_id' => 'Crawler',
			'can_read' => 'Read',
			'admin' => 'Admin',
		);
	}
	
	
	
	/**
	 * @param $permType String Permission type: admin / read / confin / cron
	 * @param $crawler_id Integer The Crawler ID
	 * @return boolean Check if the user is allowed to do that action
	 */
	public function userHasOwnPermission( $permType, $crawler_id ) { 
		if ( Yii::app()->user->isGuest ) return false;
		if ( User::checkRole(User::ROLE_ADMIN) ) return true;
		$u = User::getMe();
		$permissions = $u->getCrawlersPermissions( $crawler_id );
		return (!empty($permissions[$permType])&&($permissions[$permType]==true||$permissions[$permType]==1))?true:false;
	}
	
	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		//Permission for the user need to be refreshed
		$this->user->setCrawlersPermissions();
		
		return true;
	}
	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search( $crawler_id )
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('user_id',$this->user_id);

		$criteria->compare('crawler_id', $crawler_id);

		$criteria->compare('can_read',$this->can_read);

		$criteria->compare('admin',$this->admin);

		return new CActiveDataProvider('UserCrawler', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}