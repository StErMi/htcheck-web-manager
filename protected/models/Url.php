<?php

/**
 * This is the model class for table "Url".
 *
 * The followings are the available columns in table 'Url':
 * @property integer $IDUrl
 * @property integer $IDServer
 * @property string $Url
 * @property string $HTTPContentType
 * @property string $ContentType
 * @property string $ConnStatus
 * @property string $ContentLanguage
 * @property string $TransferEncoding
 * @property string $LastModified
 * @property string $LastAccess
 * @property integer $Size
 * @property integer $StatusCode
 * @property string $ReasonPhrase
 * @property string $Location
 * @property string $Title
 * @property string $Contents
 * @property string $DocType
 * @property string $HTTPCharset
 * @property string $Charset
 * @property string $Description
 * @property string $Keywords
 * @property string $HtDigEmail
 * @property string $HtDigEmailSubject
 * @property string $HtDigNotificationDate
 * @property integer $SizeAdd
 */
class Url extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Url the static model class
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
		return 'Url';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDUrl, IDServer, Size, StatusCode, SizeAdd', 'numerical', 'integerOnly'=>true),
			array('Url, Location, Title, Description, Keywords, HtDigEmail, HtDigEmailSubject', 'length', 'max'=>255),
			array('HTTPContentType, ContentType, TransferEncoding, ReasonPhrase', 'length', 'max'=>32),
			array('ConnStatus', 'length', 'max'=>15),
			array('ContentLanguage', 'length', 'max'=>16),
			array('DocType', 'length', 'max'=>23),
			array('HTTPCharset, Charset', 'length', 'max'=>12),
			array('LastModified, LastAccess, Contents, HtDigNotificationDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDUrl, IDServer, Url, HTTPContentType, ContentType, ConnStatus, ContentLanguage, TransferEncoding, LastModified, LastAccess, Size, StatusCode, ReasonPhrase, Location, Title, Contents, DocType, HTTPCharset, Charset, Description, Keywords, HtDigEmail, HtDigEmailSubject, HtDigNotificationDate, SizeAdd', 'safe', 'on'=>'search'),
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
			'server' => array(self::BELONGS_TO, 'Server', 'IDServer'),
			'schedule' => array(self::HAS_ONE, 'Schedule', 'IDUrl'),
			// Info about outgoing links (both retrieved or not)
			'outgoing_links' => array(
					self::HAS_MANY, 'Link', 'IDUrlSrc',
					'order'=>'outgoing_links.TagPosition, outgoing_links.AttrPosition',
					'with'=>'schedule',
			),
			// Info about incoming links - only retrieved, of course
			'incoming_links' => array(
					self::HAS_MANY, 'Link', 'IDUrlDest',
					'order'=>'Url.Url',
			),
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
			'HTTPContentType' => 'Httpcontent Type',
			'ContentType' => 'Content Type',
			'ConnStatus' => 'Conn Status',
			'ContentLanguage' => 'Content Language',
			'TransferEncoding' => 'Transfer Encoding',
			'LastModified' => 'Last Modified',
			'LastAccess' => 'Last Access',
			'Size' => 'Size',
			'StatusCode' => 'Status Code',
			'ReasonPhrase' => 'Reason Phrase',
			'Location' => 'Location',
			'Title' => 'Title',
			'Contents' => 'Contents',
			'DocType' => 'Doc Type',
			'HTTPCharset' => 'Httpcharset',
			'Charset' => 'Charset',
			'Description' => 'Description',
			'Keywords' => 'Keywords',
			'HtDigEmail' => 'Ht Dig Email',
			'HtDigEmailSubject' => 'Ht Dig Email Subject',
			'HtDigNotificationDate' => 'Ht Dig Notification Date',
			'SizeAdd' => 'Size Add',
		);
	}
	
	/**
	 * @return string the URL that shows the detail of the Url
	 */
	public function getUrl( $IDUrl = -1)
	{
		if ( $IDUrl == -1 )
			return Yii::app()->createUrl('url/view', array( 'id'=>$this->IDUrl ));
		else
			return Yii::app()->createUrl('url/view', array( 'id'=>$IDUrl ));
	}
	
	/**	
	 * Get the count of records selected from the DB
	 * @return Integer count of records selected from the DB
	 */
	public function ContentType_results_count() {
		return Url::model()->countBySql( 
			'SELECT COUNT(*) FROM Url WHERE ContentType=:ContentType GROUP BY ContentType',
			array( 
				':ContentType' => $this->ContentType,
			)
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function ContentType_results()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'ContentType';
		$criteria->compare('ContentType',$this->ConnStatus,true);
		$criteria->group = 'ContentType';
		
		return new CActiveDataProvider('Url', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
	
	
	/**	
	 * Get the count of records selected from the DB
	 * @return Integer count of records selected from the DB
	 */
	public function Connection_results_count() {
		return Url::model()->countBySql( 
			'SELECT COUNT(*) FROM Url WHERE ConnStatus=:ConnStatus GROUP BY ConnStatus',
			array( 
				':ConnStatus' => $this->ConnStatus,
			)
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function Connection_results()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'ConnStatus';
		$criteria->compare('ConnStatus',$this->ConnStatus,true);
		$criteria->group = 'ConnStatus';
		
		return new CActiveDataProvider('Url', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
	
	/**	
	 * Get the count of records selected from the DB
	 * @return Integer count of records selected from the DB
	 */
	public function HTTP_results_count() {
		return Url::model()->countBySql( 
			'SELECT COUNT(*) FROM Url WHERE StatusCode=:StatusCode AND ReasonPhrase=:ReasonPhrase GROUP BY StatusCode, ReasonPhrase',
			array( 
				':StatusCode' => $this->StatusCode,
				':ReasonPhrase' => $this->ReasonPhrase,
			)
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function HTTP_results()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'StatusCode, ReasonPhrase, COUNT(*)';
		$criteria->compare('StatusCode',$this->StatusCode);
		$criteria->compare('ReasonPhrase',$this->ReasonPhrase,true);
		$criteria->group = 'StatusCode, ReasonPhrase';
		return new CActiveDataProvider('Url', array(
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
		
		if ( isset($_GET['UrlSearchForm']) ) {
			$search = new UrlSearchForm;
			$search->attributes=$_GET['UrlSearchForm'];
			
			if ( !empty($search->url_name_text_1) ) {
				if ( $search->url_name_type_1 == 'LIKE' || $search->url_name_type_1 == 'NOT LIKE') $criteria->condition .= "Url $search->url_name_type_1 '%$search->url_name_text_1%' AND ";
				else $criteria->condition .= "Url $search->url_name_type_1 '$search->url_name_text_1' AND ";
			}
			if ( !empty($search->url_name_text_2) ) {
				if ( $search->url_name_type_2 == 'LIKE' || $search->url_name_type_2 == 'NOT LIKE') $criteria->condition .= "Url $search->url_name_type_2 '%$search->url_name_text_2%' AND ";
				else $criteria->condition .= "Url $search->url_name_type_2 '$search->url_name_text_2' AND ";
			}
			if ( !empty($search->url_name_text_3) ) {
				if ( $search->url_name_type_3 == 'LIKE' || $search->url_name_type_3 == 'NOT LIKE') $criteria->condition .= "Url $search->url_name_type_3 '%$search->url_name_text_3%' AND ";
				else $criteria->condition .= "Url $search->url_name_type_3 '$search->url_name_text_3' AND ";
			}	
			if ( !empty($search->url_title_text_1) ) {
				if ( $search->url_title_type_1 == 'LIKE' || $search->url_title_type_1 == 'NOT LIKE') $criteria->condition .= "Title $search->url_title_type_1 '%$search->url_title_text_1%' AND ";
				else $criteria->condition .= "Title $search->url_title_type_1 '$search->url_title_text_1' AND ";
			}
			if ( !empty($search->url_title_text_2) ) {
				if ( $search->url_title_type_2 == 'LIKE' || $search->url_title_type_2 == 'NOT LIKE') $criteria->condition .= "Title $search->url_title_type_2 '%$search->url_title_text_2%' AND ";
				else $criteria->condition .= "Title $search->url_title_type_2 '$search->url_title_text_2' AND ";
			}
			if ( !empty($search->url_title_text_3) ) {
				if ( $search->url_title_type_3 == 'LIKE' || $search->url_title_type_3 == 'NOT LIKE') $criteria->condition .= "Title $search->url_title_type_3 '%$search->url_title_text_3%' AND ";
				else $criteria->condition .= "Title $search->url_title_type_3 '$search->url_title_text_3' AND ";
			}	
			if ( !empty($search->url_desc_text_1) ) {
				if ( $search->url_desc_type_1 == 'LIKE' || $search->url_desc_type_1 == 'NOT LIKE') $criteria->condition .= "Description $search->url_desc_type_1 '%$search->url_desc_text_1%' AND ";
				else $criteria->condition .= "Description $search->url_desc_type_1 '$search->url_desc_text_1' AND ";
			}
			if ( !empty($search->url_desc_text_2) ) {
				if ( $search->url_desc_type_2 == 'LIKE' || $search->url_desc_type_2 == 'NOT LIKE') $criteria->condition .= "Description $search->url_desc_type_2 '%$search->url_desc_text_2%' AND ";
				else $criteria->condition .= "Description $search->url_desc_type_2 '$search->url_desc_text_2' AND ";
			}
			if ( !empty($search->url_desc_text_3) ) {
				if ( $search->url_desc_type_3 == 'LIKE' || $search->url_desc_type_3 == 'NOT LIKE') $criteria->condition .= "Description $search->url_desc_type_3 '%$search->url_desc_text_3%' AND ";
				else $criteria->condition .= "Description $search->url_desc_type_3 '$search->url_desc_text_3' AND ";
			}	
			if ( !empty($search->url_key_text_1) ) {
				if ( $search->url_key_type_1 == 'LIKE' || $search->url_key_type_1 == 'NOT LIKE') $criteria->condition .= "Keywords $search->url_key_type_1 '%$search->url_key_text_1%' AND ";
				else $criteria->condition .= "Keywords $search->url_key_type_1 '$search->url_key_text_1' AND ";
			}
			if ( !empty($search->url_key_text_2) ) {
				if ( $search->url_key_type_2 == 'LIKE' || $search->url_key_type_2 == 'NOT LIKE') $criteria->condition .= "Keywords $search->url_key_type_2 '%$search->url_key_text_2%' AND ";
				else $criteria->condition .= "Keywords $search->url_key_type_2 '$search->url_key_text_2' AND ";
			}
			if ( !empty($search->url_key_text_3) ) {
				if ( $search->url_key_type_3 == 'LIKE' || $search->url_key_type_3 == 'NOT LIKE') $criteria->condition .= "Keywords $search->url_key_type_3 '%$search->url_key_text_3%' AND ";
				else $criteria->condition .= "Keywords $search->url_key_type_3 '$search->url_key_text_3' AND ";
			}	
			if ( !empty($search->url_statuscode) && $search->url_statuscode != 'all' )
				$criteria->condition .= "StatusCode $search->url_statuscode_type '$search->url_statuscode' AND ";
			if ( !empty($search->url_contentype) && $search->url_contentype != 'all' )
				$criteria->condition .= "ContentType $search->url_contentype_type '$search->url_contentype' AND ";	
			if ( !empty($search->url_charset) && $search->url_charset != 'all' )
				$criteria->condition .= "Charset $search->url_charset_type '$search->url_charset' AND ";	
			if ( !empty($search->url_doctype) && $search->url_doctype != 'all' )
				$criteria->condition .= "DocType $search->url_doctype_type '$search->url_doctype' AND ";
			if ( !empty($search->url_size_text) && is_numeric($search->url_size_text) ) {
				$size = $search->url_size_text * 1024;
				$criteria->condition .= "Size $search->url_size_type $size AND Size >= 0 AND ";
			}	
			if ( !empty($search->url_sizeadd_text) && is_numeric($search->url_sizeadd_text) ) {
				$sizeadd = $search->url_sizeadd_text * 1024;
				$criteria->condition .= "(SizeAdd + Size) $search->url_sizeadd_type $sizeadd AND Size >= 0 AND ";
			}					
			if ( strlen($criteria->condition) > 0 ) $criteria->condition = substr($criteria->condition, 0, -4);
		}

		


		$criteria->compare('Url',$this->Url,true);

		//$criteria->compare('HTTPContentType',$this->HTTPContentType,true);

		$criteria->compare('ContentType',$this->ContentType,true);

		$criteria->compare('ConnStatus',$this->ConnStatus,true);

		$criteria->compare('ContentLanguage',$this->ContentLanguage,true);

		$criteria->compare('TransferEncoding',$this->TransferEncoding,true);

		$criteria->compare('LastModified',$this->LastModified,true);

		$criteria->compare('LastAccess',$this->LastAccess,true);

		$criteria->compare('Size',$this->Size);

		$criteria->compare('StatusCode',$this->StatusCode);

		$criteria->compare('ReasonPhrase',$this->ReasonPhrase,true);

		$criteria->compare('Location',$this->Location,true);

		$criteria->compare('Title',$this->Title,true);

		$criteria->compare('Contents',$this->Contents,true);

		$criteria->compare('DocType',$this->DocType,true);

		//$criteria->compare('HTTPCharset',$this->HTTPCharset,true);

		$criteria->compare('Charset',$this->Charset,true);

		$criteria->compare('Description',$this->Description,true);

		$criteria->compare('Keywords',$this->Keywords,true);

		//$criteria->compare('HtDigEmail',$this->HtDigEmail,true);

		$criteria->compare('HtDigEmailSubject',$this->HtDigEmailSubject,true);

		$criteria->compare('HtDigNotificationDate',$this->HtDigNotificationDate,true);

		$criteria->compare('SizeAdd',$this->SizeAdd);

		return new CActiveDataProvider('Url', array(
			'criteria'=>$criteria,	
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}