<?php

/**
 * This is the model class for table "crawler_crontab".
 *
 * The followings are the available columns in table 'crawler_crontab':
 * @property integer $id
 * @property integer $crawler_id
 * @property string $minute
 * @property string $hour
 * @property string $day
 * @property string $month
 * @property string $weekday
 */
class CrawlerCrontab extends WebManagerActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrawlerCrontab the static model class
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
		return 'crawler_crontab';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('crawler_id, minute, hour, day, month, weekday', 'required'),
			array('crawler_id', 'numerical', 'integerOnly'=>true),
			array('minute, hour, day', 'length', 'max'=>4),
			array('month', 'length', 'max'=>2),
			array('weekday', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, crawler_id, minute, hour, day, month, weekday', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'crawler_id' => 'Crawler',
			'minute' => 'Minute',
			'hour' => 'Hour',
			'day' => 'Day',
			'month' => 'Month',
			'weekday' => 'Weekday',
		);
	}
	
	public function toString() {
		$ml = CrawlerCrontab::getMonthList();
		$dl = CrawlerCrontab::getDayList();
		$wdl = CrawlerCrontab::getWeekDayList();
		$minl = CrawlerCrontab::getMinuteList();
		$hl = CrawlerCrontab::getHourList();
		$s = '';
		$s .= 'Month: ' .(($this->month == '*')?'Every':$ml[$this->month]).' - ';
		$s .= 'Day: ' .(($this->day == '*')?'Every':$dl[$this->day]).' - ';
		$s .= 'Week Day: ' .(($this->weekday == '*')?'Every':$wdl[$this->weekday]).' - ';
		$s .= 'Time: ' . $hl[$this->hour] . ':' .$minl[$this->minute];
		return $s;
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search( $cID = -1 )
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		if ( $cID != -1 ) $criteria->compare('crawler_id',$cID);
		else $criteria->compare('crawler_id',$this->crawler_id);

		$criteria->compare('minute',$this->minute,true);

		$criteria->compare('hour',$this->hour,true);

		$criteria->compare('day',$this->day,true);

		$criteria->compare('month',$this->month,true);

		$criteria->compare('weekday',$this->weekday,true);

		return new CActiveDataProvider('CrawlerCrontab', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
	
	public static function getMinuteList() {
		for ( $i = 0; $i < 59; $i++ ) { 
			if ( $i < 10 ) $list[$i] = '0'.$i;
			else $list[$i] = $i;
		}
			
		return $list;
	}
	
	public static function getHourList() {
		
		for ( $i = 0; $i < 23; $i++ ) {
			if ( $i < 10 ) $list[$i] = '0'.$i;
			else $list[$i] = $i;
		}	
		return $list;
	}
	
	public static function getDayList() {
		$list['*'] = 'Every';
		
		for ( $i = 1; $i < 31; $i++ ) {
			if ( $i < 10 ) $list[$i] = '0'.$i;
			else $list[$i] = $i;
		}	
		return $list;
	}
	
	public static function getMonthList() {
		$list['*'] = 'Every';
		
		for ( $i = 1; $i < 12; $i++ ) {
			if ( $i < 10 ) $list[$i] = '0'.$i;
			else $list[$i] = $i;
		}	
			
		return $list;
	}
	
	public static function getWeekDayList() {
		$list['*'] = 'Every';
		$list['1'] = 'Lun';
		$list['2'] = 'Mar';
		$list['3'] = 'Mer';
		$list['4'] = 'Gio';
		$list['5'] = 'Ven';
		$list['6'] = 'Sab';
		$list['7'] = 'Dom';
			
		return $list;
	}
}