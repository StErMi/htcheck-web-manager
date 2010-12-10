<?php


class UrlSearchForm extends CFormModel
{
	// search for url value
	public $url_name_text_1;
	public $url_name_text_2;
	public $url_name_text_3;
	public $url_name_type_1;
	public $url_name_type_2;
	public $url_name_type_3;
	
	// search for page title value
	public $url_title_text_1;
	public $url_title_text_2;
	public $url_title_text_3;
	public $url_title_type_1;
	public $url_title_type_2;
	public $url_title_type_3;
	
	// search for page description value
	public $url_desc_text_1;
	public $url_desc_text_2;
	public $url_desc_text_3;
	public $url_desc_type_1;
	public $url_desc_type_2;
	public $url_desc_type_3;
	
	// search for page keywords value
	public $url_key_text_1;
	public $url_key_text_2;
	public $url_key_text_3;
	public $url_key_type_1;
	public $url_key_type_2;
	public $url_key_type_3;
	
	// Search for status code
	public $url_statuscode;
	public $url_statuscode_type;
	// caching status code
	public $_status_code_list = null;
	
	// search for content type
	public $url_contentype_type;
	public $url_contentype;
	// caching content type 
	public $_contentype_list = null;
	
	// search for charset
	public $url_charset_type;
	public $url_charset;
	// caching charset  
	public $_charset_list = null;
	
	// search for doctype
	public $url_doctype_type;
	public $url_doctype;
	// caching doctype
	public $_doctype_list = null;
	
	// search for size
	public $url_size_type;
	public $url_size_text;
	
	// search for size
	public $url_sizeadd_type;
	public $url_sizeadd_text;
	
	public $_conn_status_list;
	public $_reason_phrase_list;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('url_name_text_1, url_name_text_2, url_name_text_3, url_name_type_1, url_name_type_2, url_name_type_3,
					url_statuscode, url_statuscode_type, url_charset_type, url_charset, url_doctype_type, url_doctype,
					url_size_type, url_size_text, url_sizeadd_type, url_sizeadd_text,
					url_title_text_1, url_title_text_2, url_title_text_3, url_title_type_1, url_title_type_2, url_title_type_3,
					url_desc_text_1, url_desc_text_2, url_desc_text_3, url_desc_type_1, url_desc_type_2, url_desc_type_3,
					url_key_text_1, url_key_text_2, url_key_text_3, url_key_type_1, url_key_type_2, url_key_type_3', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'url_statuscode_type' => 'Status Code',
			'url_contentype_type' => 'Content type',
			'url_charset_type' => 'Charset',
			'url_doctype_type' => 'Document Type',
			'url_size_type' => 'Size',
			'url_sizeadd_type' => 'Total weight of the page (caching supposed) ',
		);
	}
	
	public static function getUrlNameTypeList() {
		$list = array();
		$list['LIKE'] = 'Like';
		$list['NOT LIKE'] = 'Not like';
		$list['REGEXP'] = 'RegExp';
		$list['NOT REGEXP'] = 'Not RegExp';
		return $list;
	}
	
	public static function getUrlStatusCodeTypeList() {
		$list = array();
		$list['='] = 'Like';
		$list['!='] = 'Not like';
		return $list;
	}
	
	public static function getUrlSizeTypeList() {
		$list = array();
		$list['>'] = 'Greater than';
		$list['<'] = 'Less than';
		$list['='] = 'Like';
		return $list;
	}
	
	public function getUrlStatusCodeList( $withAll = true ) {
		//if ( $this->_status_code_list !== null ) return $this->_status_code_list;
		$strSQL="SELECT count(*) as Count, StatusCode "
	      . "FROM Url GROUP BY StatusCode "
	      . "ORDER BY StatusCode ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_status_code_list = $command->queryAll();
		
		$list = array();
		if ( $withAll ) $list['all'] = 'All';
		foreach ( $this->_status_code_list as $sc ) {
			$list[$sc['StatusCode']] = $sc['StatusCode'] . ' ('.$sc['Count'].')';
		}
		$this->_status_code_list = $list;
		
		return $this->_status_code_list;
		
	}	
	
	public function getUrlReasonPhraseList( ) {
		if ( $this->_reason_phrase_list !== null ) return $this->_reason_phrase_list;
		$strSQL="SELECT count(*) as Count, ReasonPhrase "
	      . "FROM Url GROUP BY ReasonPhrase "
	      . "ORDER BY ReasonPhrase ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_reason_phrase_list = $command->queryAll();
		
		$list = array();
		
		foreach ( $this->_reason_phrase_list as $sc ) {
			$list[$sc['ReasonPhrase']] = $sc['ReasonPhrase'] . ' ('.$sc['Count'].')';
		}
		$this->_reason_phrase_list = $list;
		
		return $this->_reason_phrase_list;
		
	}
	
	public function getUrlConnStatusList( ) {
		if ( $this->_conn_status_list !== null ) return $this->_conn_status_list;
		$strSQL="SELECT count(*) as Count, ConnStatus "
	      . "FROM Url GROUP BY ConnStatus "
	      . "ORDER BY ConnStatus ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_conn_status_list = $command->queryAll();
		
		$list = array();
		
		foreach ( $this->_conn_status_list as $sc ) {
			$list[$sc['ConnStatus']] = $sc['ConnStatus'] . ' ('.$sc['Count'].')';
		}
		$this->_conn_status_list = $list;
		
		return $this->_conn_status_list;
		
	}
	
	public static function getUrlContentypeTypeList() {
		$list = array();
		$list['='] = 'Like';
		$list['!='] = 'Not like';
		return $list;
	}
	
	public function getUrlContentypeList() {
		if ( $this->_contentype_list !== null ) return $this->_contentype_list;
		$strSQL="SELECT count(*) as Count, ContentType "
	      . "FROM Url GROUP BY ContentType "
	      . "ORDER BY ContentType ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_contentype_list = $command->queryAll();
		
		$list = array();
		$list['all'] = 'All';
		foreach ( $this->_contentype_list as $ct ) {
			
			
			if ( $ct['ContentType'] == null ) $list[$ct['ContentType']] = 'Not Defined ('.$ct['Count'].')';
			else $list[$ct['ContentType']] = $ct['ContentType'] . ' ('.$ct['Count'].')';
		}
		$this->_contentype_list = $list;
		
		return $this->_contentype_list;
		
	}
	
	public static function getUrlCharsetTypeList() {
		$list = array();
		$list['='] = 'Like';
		$list['!='] = 'Not like';
		return $list;
	}
	
	public function getUrlCharsetList() {
		
		if ( $this->_charset_list !== null ) return $this->_charset_list;
		$strSQL="SELECT count(*) as Count, Charset "
	      . "FROM Url GROUP BY Charset "
	      . "ORDER BY Charset ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_charset_list = $command->queryAll();
		
		$list = array();
		$list['all'] = 'All';
		foreach ( $this->_charset_list as $cs ) {
			if ( $cs['Charset'] == 'unknown' ) $list[$cs['Charset']] = 'Other ('.$cs['Count'].')';
			else if ( $cs['Charset'] == null ) $list[$cs['Charset']] = 'Not Defined ('.$cs['Count'].')';
			else $list[$cs['Charset']] = $cs['Charset'] . ' ('.$cs['Count'].')';
		}
		$this->_charset_list = $list;
		
		return $this->_charset_list;
		
	}
	
	public static function getUrlDoctypeTypeList() {
		$list = array();
		$list['='] = 'Like';
		$list['!='] = 'Not like';
		return $list;
	}
	
	public function getUrlDoctypeList() {
		if ( $this->_doctype_list !== null ) return $this->_doctype_list;
		$strSQL="SELECT count(*) as Count, DocType "
	      . "FROM Url GROUP BY DocType "
	      . "ORDER BY DocType ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_doctype_list = $command->queryAll();
		
		$list = array();
		$list['all'] = 'All';
		foreach ( $this->_doctype_list as $ct ) {
			if ( $ct['DocType'] == null ) $list[$ct['DocType']] = 'Not Defined ('.$ct['Count'].')';
			else $list[$ct['DocType']] = $ct['DocType'] . ' ('.$ct['Count'].')';
		}
		$this->_doctype_list = $list;
		
		return $this->_doctype_list;
		
	}
	
	

	
}

