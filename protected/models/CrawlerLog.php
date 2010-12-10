<?php

/**
 * This is the model class for table "crawler_log".
 *
 * The followings are the available columns in table 'crawler_log':
 * @property integer $id
 * @property integer $crawler_id
 * @property string $version
 * @property string $start_time
 * @property string $end_time
 * @property integer $scheduled_urls
 * @property integer $tot_urls
 * @property integer $retrieved_urls
 * @property integer $tcp_connections
 * @property integer $server_changes
 * @property integer $http_requests
 * @property integer $http_seconds
 * @property string $http_bytes
 * @property integer $accessibility_checks
 * @property integer $htdig_notification
 * @property string $user
 */
class CrawlerLog extends WebManagerActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrawlerLog the static model class
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
		return 'crawler_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('crawler_id', 'required'),
			array('crawler_id, scheduled_urls, tot_urls, retrieved_urls, tcp_connections, server_changes, http_requests, http_seconds, accessibility_checks, htdig_notification', 'numerical', 'integerOnly'=>true),
			array('version', 'length', 'max'=>32),
			array('http_bytes', 'length', 'max'=>20),
			array('user', 'length', 'max'=>255),
			array('start_time, end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, crawler_id, version, start_time, end_time, scheduled_urls, tot_urls, retrieved_urls, tcp_connections, server_changes, http_requests, http_seconds, http_bytes, accessibility_checks, htdig_notification, user', 'safe', 'on'=>'search'),
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
			'crawler'=>array(self::BELONGS_TO, 'Crawler', 'crawler_id'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'crawler_id' => 'Crawler',
			'version' => 'Version',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'scheduled_urls' => 'Scheduled Urls',
			'tot_urls' => 'Tot Urls',
			'retrieved_urls' => 'Retrieved Urls',
			'tcp_connections' => 'Tcp Connections',
			'server_changes' => 'Server Changes',
			'http_requests' => 'Http Requests',
			'http_seconds' => 'Http Seconds',
			'http_bytes' => 'Http Bytes',
			'accessibility_checks' => 'Accessibility Checks',
			'htdig_notification' => 'Htdig Notification',
			'user' => 'User',
		);
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

		$criteria->compare('crawler_id', $crawler_id );

		$criteria->compare('version',$this->version,true);

		$criteria->compare('start_time',$this->start_time,true);

		$criteria->compare('end_time',$this->end_time,true);

		$criteria->compare('scheduled_urls',$this->scheduled_urls);

		$criteria->compare('tot_urls',$this->tot_urls);

		$criteria->compare('retrieved_urls',$this->retrieved_urls);

		$criteria->compare('tcp_connections',$this->tcp_connections);

		$criteria->compare('server_changes',$this->server_changes);

		$criteria->compare('http_requests',$this->http_requests);

		$criteria->compare('http_seconds',$this->http_seconds);

		$criteria->compare('http_bytes',$this->http_bytes,true);

		$criteria->compare('accessibility_checks',$this->accessibility_checks);

		$criteria->compare('htdig_notification',$this->htdig_notification);

		$criteria->compare('user',$this->user,true);

		return new CActiveDataProvider('CrawlerLog', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}