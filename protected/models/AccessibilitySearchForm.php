<?php


class AccessibilitySearchForm extends CFormModel
{
	
	// search for url value
	public $url_name_text_1;
	public $url_name_text_2;
	public $url_name_text_3;
	public $url_name_type_1;
	public $url_name_type_2;
	public $url_name_type_3;
	
	// Search for link domain
	public $domain;
	// caching link type
	public $_domain_list = null;
	
	
	// search for doctype
	public $doctype_type;
	public $doctype;
	// caching doctype
	public $_doctype_list = null;
	
	// search for errorcode
	public $errorcode;
	// caching doctype
	public $_errorcode_list = null;
	
	
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('url_name_text_1, url_name_text_2, url_name_text_3, url_name_type_1, url_name_type_2, url_name_type_3,
					doctype_type, doctype, errorcode, errorcode_type
					domain', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'domain' => 'Select a server',
			'doctype_type' => 'Document Type',	
			'errorcode' => 'Choose which accessibility errors to search',
		);
	}
	
	public static function getFullTypeList() {
		$list = array();
		$list['LIKE'] = 'Like';
		$list['NOT LIKE'] = 'Not like';
		$list['REGEXP'] = 'RegExp';
		$list['NOT REGEXP'] = 'Not RegExp';
		return $list;
	}
	
	public static function getSmallTypeList() {
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
	
	public function getDomainList() {
		if ( $this->_domain_list !== null ) return $this->_domain_list;
		$strSQL="SELECT DISTINCT s.IDServer, s.Server FROM Accessibility a JOIN Url u USING (IDUrl) JOIN Server s USING (IDServer) ORDER BY Server ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_domain_list = $command->queryAll();
		
		$list = array();
		foreach ( $this->_domain_list as $ld ) {
			if ( $ld['IDServer'] == null ) $list[$ld['Server']] = 'Unknown ';
			else $list[$ld['IDServer']] = $ld['Server'];
		}
		$this->_domain_list = $list;
		
		return $this->_domain_list;
		
	}
	
	public function getDoctypeList() {
		if ( $this->_doctype_list !== null ) return $this->_doctype_list;
		$strSQL="SELECT count(*) as Count, DocType "
	      . "FROM Url, Accessibility "
	      . "WHERE Url.IDUrl = Accessibility.IDUrl "
	      . "GROUP BY DocType "
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
	
	public function getErrorcodeList() {
		
		$strAchecks = array();

		// OAC #1
		$strAchecks[1] = array(
			'description' => 'All IMG elements must have an ALT attribute',
			'error' => 'IMG missing ALT attribute',
			'repair' => 'Add an ALT attribute to your IMG element'
		);
		
		// OAC #2 
		$strAchecks[2] = array(
			'description' => 'IMG element cannot have ALT attribute value '
				. 'that is the same as its SRC attribute',
			'error' => 'Suspicious ALT text (same as filename)',
			'repair' => ''
		);
		
		// OAC #3 
		$strAchecks[3] = array(
			'description' => 'IMG element must have ALT attribute value of '
				. 'less than 150 characters (English)',
			'error' => 'ALT text may be too long (greater than 150 characters)',
			'repair' => ''
		);
		
		// OAC # 7
		$strAchecks[7] = array(
			'description' => 'IMG element cannot have ALT attribute value of '
				. 'null or whitespace if the IMG element is contained by an '
				. 'A element',
			'error' => 'Image used as anchor is missing valid ALT text',
			'repair' => 'Modify the text in the ALT attribute to your IMG element'
		);
		
		// OAC #27 
		$strAchecks[27] = array(
			'description' => 'This error is generated for all BLINK elements',
			'error' => 'BLINK element used',
			'repair' => 'Remove the BLINK element (replace with STRONG or EM)'
		);
		
		// OAC #37 
		$strAchecks[37] = array(
			'description' => 'First heading element prior to H2 element must be '
				. 'an H1 element',
			'error' => 'Header nesting - H2 does not follow an H1',
			'repair' => 'Modify the header levels so H2 follows H1'
		);
		
		// OAC #38 
		$strAchecks[38] = array(
			'description' => 'First heading element prior to H3 element must be '
				. 'an H2 element',
			'error' => 'Header nesting - H3 does not follow an H2',
			'repair' => 'Modify the header levels so H3 follows H2'
		);
		
		// OAC #39 
		$strAchecks[39] = array(
			'description' => 'First heading element prior to H4 element must be '
				. 'an H3 element',
			'error' => 'Header nesting - H4 does not follow an H3',
			'repair' => 'Modify the header levels so H4 follows H3'
		);
		
		// OAC #40 
		$strAchecks[40] = array(
			'description' => 'First heading element prior to H5 element must be '
				. 'an H4 element',
			'error' => 'Header nesting - H5 does not follow an H4',
			'repair' => 'Modify the header levels so H5 follows H4'
		);
		
		// OAC #41 
		$strAchecks[41] = array(
			'description' => 'First heading element prior to H6 element must be '
				. 'an H5 element',
			'error' => 'Header nesting - H6 does not follow an H5',
			'repair' => 'Modify the header levels so H6 follows H5'
		);
		
		// OAC #48 
		$strAchecks[48] = array(
			'description' => 'HTML element must contain a LANG attribute',
			'error' => 'Document language not identified',
			'repair' => 'Add a LANG attribute to the HTML element of your '
				. 'document. The LANG attribute must be set to a valid 2 or '
				. '3 letter language code as defined in the ISO specification 639'
		);
		
		// OAC #50 
		$strAchecks[50] = array(
			'description' => 'TITLE element must be present in HEAD section of document',
			'error' => 'Document missing TITLE element',
			'repair' => 'Add a TITLE element to the HEAD section of your document'
		);
		
		// OAC #51 
		$strAchecks[51] = array(
			'description' => 'TITLE element content cannot be empty or whitespace',
			'error' => 'TITLE element is empty',
			'repair' => 'Add text to the TITLE element'
		);
		
		// OAC #52 
		$strAchecks[52] = array(
			'description' => 'TITLE element content must be less than 150 '
				. 'characters (English)',
			'error' => 'TITLE text may be too long',
			'repair' => ''
		);
		
		// OAC #58 
		$strAchecks[58] = array(
			'description' => 'INPUT element that contains a TYPE attribute '
				. 'value of "image" must have an ALT attribute',
			'error' => 'Image used for INPUT control is missing ALT text',
			'repair' => 'Add an ALT attribute that describes the image to INPUT control'
		);
		
		// OAC #61 
		$strAchecks[61] = array(
			'description' => 'INPUT elements cannot have ALT attribute values '
				. 'that are the same as their SRC attribute values',
			'error' => 'Image used in INPUT element - '
				. 'Suspicious Alt text (same as filename)',
			'repair' => ''
		);
		
		// OAC #69 
		$strAchecks[69] = array(
			'description' => '',
			'error' => 'MARQUEE element should not be used',
			'repair' => ''
		);
		
		// OAC #71 
		$strAchecks[71] = array(
			'description' => '',
			'error' => 'Auto-redirect should not be used',
			'repair' => ''
		);
		
		// OAC #72 
		$strAchecks[72] = array(
			'description' => '',
			'error' => 'Auto-refresh should not be used',
			'repair' => ''
		);
		
		// OAC #116 
		$strAchecks[116] = array(
			'description' => 'This error will be generated for all B elements',
			'error' => 'B element used (use EM or STRONG instead)',
			'repair' => 'Replace your B elements with EM or STRONG'
		);
		
		// OAC #117 
		$strAchecks[117] = array(
			'description' => 'This error will be generated for all I elements',
			'error' => 'I element used (use EM or STRONG instead)',
			'repair' => 'Replace your I elements with EM or STRONG'
		);
		
		if ( $this->_errorcode_list !== null ) return $this->_errorcode_list;
		$strSQL="SELECT count(*) as Count, Code "
	      . "FROM Accessibility GROUP BY Code "
	      . "ORDER BY Code ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_errorcode_list = $command->queryAll();
		
		$list = array();
		foreach ( $this->_errorcode_list as $ct ) {
			if ( $ct['Code'] == null ) $list[$ct['Code']] = 'Not Defined ('.$ct['Count'].')';
			else $list[$ct['Code']] = $strAchecks[$ct['Code']]['error'] . ' ('.$ct['Count'].')';
		}
		$this->_errorcode_list = $list;
		
		return $this->_errorcode_list;
		
	}
	
}
