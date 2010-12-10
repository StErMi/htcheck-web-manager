<?php

/**
 * This is the model class for table "htCheck".
 *
 * The followings are the available columns in table 'htCheck':
 * @property string $Version
 * @property string $StartTime
 * @property string $EndTime
 * @property integer $ScheduledUrls
 * @property integer $TotUrls
 * @property integer $RetrievedUrls
 * @property integer $TCPConnections
 * @property integer $ServerChanges
 * @property integer $HTTPRequests
 * @property integer $HTTPSeconds
 * @property string $HTTPBytes
 * @property integer $AccessibilityChecks
 * @property integer $HtDigNotification
 * @property string $User
 */
class HtCheck extends CActiveRecord
{
	
	private $_dbs;
	/**
	 * Returns the static model of the specified AR class.
	 * @return HtCheck the static model class
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
		return 'htCheck';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ScheduledUrls, TotUrls, RetrievedUrls, TCPConnections, ServerChanges, HTTPRequests, HTTPSeconds, AccessibilityChecks, HtDigNotification', 'numerical', 'integerOnly'=>true),
			array('Version', 'length', 'max'=>32),
			array('HTTPBytes', 'length', 'max'=>20),
			array('User', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Version, StartTime, EndTime, ScheduledUrls, TotUrls, RetrievedUrls, TCPConnections, ServerChanges, HTTPRequests, HTTPSeconds, HTTPBytes, AccessibilityChecks, HtDigNotification, User', 'safe', 'on'=>'search'),
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
			'Version' => 'Version',
			'StartTime' => 'Start Time',
			'EndTime' => 'End Time',
			'ScheduledUrls' => 'Scheduled Urls',
			'TotUrls' => 'Tot Urls',
			'RetrievedUrls' => 'Retrieved Urls',
			'TCPConnections' => 'Tcpconnections',
			'ServerChanges' => 'Server Changes',
			'HTTPRequests' => 'Httprequests',
			'HTTPSeconds' => 'Httpseconds',
			'HTTPBytes' => 'Httpbytes',
			'AccessibilityChecks' => 'Accessibility Checks',
			'HtDigNotification' => 'Ht Dig Notification',
			'User' => 'User',
		);
	}
	
	public static function getDbList() {
		
		/*if($this->_dbs===null)
		{*/
			$model = new HtCheck;
			$connection = $model->dbConnection;
			$dbs = array();
			$host = explode(';', $connection->connectionString);
			$host = str_replace('mysql:host=', '', $host[0]);
			$link = mysql_connect( $host, $connection->username, $connection->password);
			
			if ( ! $dbtable = @mysql_list_dbs ($link) ) {
				//Gestione egli errori
				//exit ( 'Errore selezione lista db');
				return array();
			} else {
				$numdbs = mysql_num_rows($dbtable);
				
				
				
				for ( $i = 0; $i < $numdbs; $i++ ) {
					$dbname = mysql_table_name( $dbtable, $i );
					
					mysql_select_db( $dbname );
					
					$result = mysql_query('show tables');
					if (!$result) {
					    echo 'Could not run query: ' . mysql_error();
					    exit;
					}
					
					while ( $row = mysql_fetch_row($result) ) {
						//TODO a seconda del db o sistema che usi devi controllare questo IF
						
						if ( $row[0]=='accessibility' ) {
							$dbs[$dbname] = $dbname;
							break;
						}
					}
					
				}
			}
			//exit ( print_r($dbs) );
			return $dbs;
			//$this->_dbs = $dbs;
		/*}
		return $this->_dbs;*/
		
		
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

		$criteria->compare('Version',$this->Version,true);

		$criteria->compare('StartTime',$this->StartTime,true);

		$criteria->compare('EndTime',$this->EndTime,true);

		$criteria->compare('ScheduledUrls',$this->ScheduledUrls);

		$criteria->compare('TotUrls',$this->TotUrls);

		$criteria->compare('RetrievedUrls',$this->RetrievedUrls);

		$criteria->compare('TCPConnections',$this->TCPConnections);

		$criteria->compare('ServerChanges',$this->ServerChanges);

		$criteria->compare('HTTPRequests',$this->HTTPRequests);

		$criteria->compare('HTTPSeconds',$this->HTTPSeconds);

		$criteria->compare('HTTPBytes',$this->HTTPBytes,true);

		$criteria->compare('AccessibilityChecks',$this->AccessibilityChecks);

		$criteria->compare('HtDigNotification',$this->HtDigNotification);

		$criteria->compare('User',$this->User,true);

		return new CActiveDataProvider('HtCheck', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}