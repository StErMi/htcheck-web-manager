<?php

/**
 * This is the model class for table "Accessibility".
 *
 * The followings are the available columns in table 'Accessibility':
 * @property integer $IDCheck
 * @property integer $IDUrl
 * @property integer $TagPosition
 * @property integer $AttrPosition
 * @property integer $Code
 */
class Accessibility extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Accessibility the static model class
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
		return 'Accessibility';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDCheck, IDUrl, TagPosition, AttrPosition, Code', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDCheck, IDUrl, TagPosition, AttrPosition, Code', 'safe', 'on'=>'search'),
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
			'url' => array(self::BELONGS_TO, 'Url', 'IDUrl'),
			'hs' => array(self::BELONGS_TO, 'HtmlStatement', 'IDUrl', 'condition'=>'hs.TagPosition=TagPosition'),
			'ha' => array(self::BELONGS_TO, 'HtmlAttribute', 'IDUrl', 'condition'=>'ha.TagPosition=TagPosition AND ha.AttrPosition=AttrPosition'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'IDCheck' => 'Idcheck',
			'IDUrl' => 'Idurl',
			'TagPosition' => 'Tag Position',
			'AttrPosition' => 'Attr Position',
			'Code' => 'Code',
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
		
		$criteria->with = array('url');
		$crietera->order = 'url.Url ASC';
		
		if ( isset($_GET['AccessibilitySearchForm']) ) {
			$search = new AccessibilitySearchForm;
			$search->attributes=$_GET['AccessibilitySearchForm'];
			
			if ( !empty($search->url_name_text_1) ) {
				if ( $search->url_name_type_1 == 'LIKE' || $search->url_name_type_1 == 'NOT LIKE') $criteria->condition .= "url.Url $search->url_name_type_1 '%$search->url_name_text_1%' AND ";
				else $criteria->condition .= "url.Url $search->url_name_type_1 '$search->url_name_text_1' AND ";
			}
			if ( !empty($search->url_name_text_2) ) {
				if ( $search->url_name_type_2 == 'LIKE' || $search->url_name_type_2 == 'NOT LIKE') $criteria->condition .= "url.Url $search->url_name_type_2 '%$search->url_name_text_2%' AND ";
				else $criteria->condition .= "url.Url $search->url_name_type_2 '$search->url_name_text_2' AND ";
			}
			if ( !empty($search->url_name_text_3) ) {
				if ( $search->url_name_type_3 == 'LIKE' || $search->url_name_type_3 == 'NOT LIKE') $criteria->condition .= "url.Url $search->url_name_type_3 '%$search->url_name_text_3%' AND ";
				else $criteria->condition .= "url.Url $search->url_name_type_3 '$search->url_name_text_3' AND ";
			}	
			if ( !empty($search->doctype) && $search->doctype != 'all' ) {
				if ( $search->doctype_type == '!=' ) $criteria->condition .= "url.DocType $search->doctype_type '$search->doctype' AND ";
				else $criteria->condition .= "( url.DocType $search->doctype_type '$search->doctype' OR url.DocType is NULL ) AND ";
			}
			if ( empty($search->doctype) ) {
				$op = $search->doctype_type;
				if ($op  == '!=')
            		$op = 'not';
            	$criteria->condition .= "url.DocType is $search->doctype_type NULL AND ";
			}
			
			if ( !empty($search->errorcode) && count($search->errorcode) > 0 ) {
				$criteria->condition .= '(';
				foreach ( $search->errorcode as $e )
					$criteria->condition .= "Code = $e OR ";
				$criteria->condition = substr($criteria->condition, 0, -3);
				$criteria->condition .= ') AND ';
			}
			
			if ( !empty($search->domain) ) {
				$criteria->condition .= "url.IDServer = $search->domain AND ";
			}
			
			if ( strlen($criteria->condition) > 0 ) $criteria->condition = substr($criteria->condition, 0, -4);
		}
		

		$criteria->compare('IDCheck',$this->IDCheck);

		$criteria->compare('IDUrl',$this->IDUrl);

		$criteria->compare('TagPosition',$this->TagPosition);

		$criteria->compare('AttrPosition',$this->AttrPosition);

		$criteria->compare('Code',$this->Code);

		return new CActiveDataProvider('Accessibility', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
	
	public function getError() {
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
		
		return $strAchecks[$this->Code];
	}
	
	public function getErrorDesc() {
		$e = $this->getError();
		return $e['description'];
	}
	
	public function getErrorRepair() {
		$e = $this->getError();
		return $e['repair'];
	}
	
	public function getErrorErr() {
		$e = $this->getError();
		return $e['error'];
	}
}