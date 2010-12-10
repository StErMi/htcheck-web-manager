<?php


class LinkSearchForm extends CFormModel
{
	
	// search for Referencing URL
	public $referencing_url_text_1;
	public $referencing_url_text_2;
	public $referencing_url_text_3;
	public $referencing_url_type_1;
	public $referencing_url_type_2;
	public $referencing_url_type_3;
	
	// search for Referencing URL
	public $referenced_url_text_1;
	public $referenced_url_text_2;
	public $referenced_url_text_3;
	public $referenced_url_type_1;
	public $referenced_url_type_2;
	public $referenced_url_type_3;
	
	// search for Anchor URL
	public $anchor_text_1;
	public $anchor_text_2;
	public $anchor_text_3;
	public $anchor_type_1;
	public $anchor_type_2;
	public $anchor_type_3;
	
	// Search for result
	public $result;
	public $result_type;
	// caching result
	public $_result_list = null;
	
	// Search for link type
	public $linktype;
	public $linktype_type;
	// caching link type
	public $_linktype_list = null;
	
	// Search for link domain
	public $linkdomain;
	public $linkdomain_type;
	// caching link type
	public $_linkdomain_list = null;
	
	
	public $_link_result_list;
	
	
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('referencing_url_text_1, referencing_url_text_2, referencing_url_text_3, referencing_url_type_1, referencing_url_type_2, referencing_url_type_3,
					referenced_url_text_1, referenced_url_text_2, referenced_url_text_3, referenced_url_type_1, referenced_url_type_2, referenced_url_type_3,
					anchor_text_1, anchor_text_2, anchor_text_3, anchor_type_1, anchor_type_2, anchor_type_3,
					result, result_type, linktype, linktype_type, linkdomain, linkdomain_type', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'result_type' => 'Result',
			'linktype_type' => 'Link Type',
			'linkdomain_type' => 'Link Domain',	
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
	
	public function getResultList() {
		if ( $this->_result_list !== null ) return $this->_result_list;
		$strSQL="SELECT count(*) as Count, LinkResult "
	      . "FROM Link GROUP BY LinkResult "
	      . "ORDER BY LinkResult ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_result_list = $command->queryAll();
		
		$list = array();
		$list['all'] = 'All of them';
		foreach ( $this->_result_list as $rl ) {
			$list[$rl['LinkResult']] = $rl['LinkResult'] . ' ('.$rl['Count'].')';
		}
		$this->_result_list = $list;
		
		return $this->_result_list;
		
	}
	
	public function getLinktypeList( $showAll=true, $urlIDsrc = -1, $urlIDdest = -1) {
		//if ( $this->_linktype_list !== null ) return $this->_linktype_list;
		$strSQL="SELECT IDUrlSrc, IDUrlDest, count(*) as Count, LinkType "
	      . "FROM Link";
	    if ( $urlIDsrc != -1 )  $strSQL .= " WHERE IDUrlSrc=".$urlIDsrc;
	    if ( $urlIDdest != -1 )  $strSQL .= " WHERE IDUrlDest=".$urlIDdest;
	    $strSQL .= " GROUP BY LinkType ORDER BY LinkType ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_linktype_list = $command->queryAll();
		
		$list = array();
		if ( $showAll ) $list['all'] = 'All of them';
		foreach ( $this->_linktype_list as $lt ) {
			$list[$lt['LinkType']] = $lt['LinkType'] . ' ('.$lt['Count'].')';
		}
		$this->_linktype_list = $list;
		
		return $this->_linktype_list;
		
	}
	
	public function getLinkresultList( ) {
		if ( $this->_link_result_list !== null ) return $this->_link_result_list;
		$strSQL="SELECT count(*) as Count, LinkResult "
	      . "FROM Link GROUP BY LinkResult "
	      . "ORDER BY LinkResult ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_link_result_list = $command->queryAll();
		
		$list = array();
		foreach ( $this->_link_result_list as $lt ) {
			$list[$lt['LinkResult']] = $lt['LinkResult'] . ' ('.$lt['Count'].')';
		}
		$this->_link_result_list = $list;
		
		return $this->_link_result_list;
		
	}
	
	public function getLinkdomainList() {
		if ( $this->_linkdomain_list !== null ) return $this->_linkdomain_list;
		$strSQL="SELECT count(*) as Count, LinkDomain "
	      . "FROM Link GROUP BY LinkDomain "
	      . "ORDER BY LinkDomain ASC";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($strSQL);
		$this->_linkdomain_list = $command->queryAll();
		
		$list = array();
		$list['all'] = 'All of them';
		foreach ( $this->_linkdomain_list as $ld ) {
			if ( $ld['LinkDomain'] == null ) $list[$ld['LinkDomain']] = 'Unknown ('.$ld['Count'].')';
			else $list[$ld['LinkDomain']] = $ld['LinkDomain'] . ' ('.$ld['Count'].')';
		}
		$this->_linkdomain_list = $list;
		
		return $this->_linkdomain_list;
		
	}
	
	
	
	

	
}

