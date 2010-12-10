<?php

/**
 * This is the model class for table "Link".
 *
 * The followings are the available columns in table 'Link':
 * @property integer $IDUrlSrc
 * @property integer $IDUrlDest
 * @property integer $TagPosition
 * @property integer $AttrPosition
 * @property string $Anchor
 * @property string $LinkType
 * @property string $LinkResult
 * @property string $LinkDomain
 */
class Link extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Link the static model class
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
		return 'Link';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IDUrlSrc, IDUrlDest, TagPosition, AttrPosition', 'numerical', 'integerOnly'=>true),
			array('Anchor', 'length', 'max'=>255),
			array('LinkType', 'length', 'max'=>11),
			array('LinkResult', 'length', 'max'=>14),
			array('LinkDomain', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDUrlSrc, IDUrlDest, TagPosition, AttrPosition, Anchor, LinkType, LinkResult, LinkDomain', 'safe', 'on'=>'search'),
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
			'schedule' => array(self::BELONGS_TO, 'Schedule', 'IDUrlDest'),
			/*'dest_url' => array(self::BELONGS_TO, 'Url', 'IDUrlDest'),
			'source_url' => array(self::BELONGS_TO, 'Url', 'IDUrlSrc'),*/
			/*'outgoing_url' => array(self::BELONGS_TO, 'Url', 'IDUrlSrc'),
			'incoming_url' => array(self::BELONGS_TO, 'Url', 'IDUrlDest'),*/
			'incoming_url' => array(self::BELONGS_TO, 'Url', 'IDUrlDest'),
			'outgoing_url' => array(self::BELONGS_TO, 'Url', 'IDUrlSrc'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'IDUrlSrc' => 'Idurl Src',
			'IDUrlDest' => 'Idurl Dest',
			'TagPosition' => 'Tag Position',
			'AttrPosition' => 'Attr Position',
			'Anchor' => 'Anchor',
			'LinkType' => 'Link Type',
			'LinkResult' => 'Link Result',
			'LinkDomain' => 'Link Domain',
		);
	}
	
	/**	
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function incoming_results( $idURL )
	{
		$criteria = new CDbCriteria;
		$criteria->with = 'schedule';
		//$criteria->select = 'Schedule.Url, Schedule.Status, Link.*, Url.StatusCode, Url.ReasonPhrase, Url.ContentType';
		//$criteria->compare('ConnStatus', $this->ConnStatus,true);
		$criteria->addCondition( 'IDUrlDest='.$idURL );
		$criteria->order = 'Url';
		
		return new CActiveDataProvider('Link', array(
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
	public function outgoing_results( $idURL )
	{
		$criteria = new CDbCriteria;
		$criteria->with = 'schedule';
		//$criteria->select = 'Schedule.Url, Schedule.Status, Link.*, Url.StatusCode, Url.ReasonPhrase, Url.ContentType';
		//$criteria->compare('ConnStatus', $this->ConnStatus,true);
		$criteria->addCondition( 'IDUrlSrc='.$idURL );
		$criteria->order = 'TagPosition, AttrPosition';
		
		return new CActiveDataProvider('Link', array(
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
		
		$criteria->with = array('schedule', 'outgoing_url');
		
		if ( isset($_GET['LinkSearchForm']) ) {
			$search = new LinkSearchForm;
			$search->attributes=$_GET['LinkSearchForm'];
			
			if ( !empty($search->referencing_url_text_1) ) {
				if ( $search->referencing_url_type_1 == 'LIKE' || $search->referencing_url_type_1 == 'NOT LIKE') $criteria->condition .= "outgoing_url.Url $search->referencing_url_type_1 '%$search->referencing_url_text_1%' AND ";
				else $criteria->condition .= "outgoing_url.Url $search->referencing_url_type_1 '$search->referencing_url_text_1' AND ";
			}
			if ( !empty($search->referencing_url_text_2) ) {
				if ( $search->referencing_url_type_2 == 'LIKE' || $search->referencing_url_type_2 == 'NOT LIKE') $criteria->condition .= "outgoing_url.Url $search->referencing_url_type_2 '%$search->referencing_url_text_2%' AND ";
				else $criteria->condition .= "outgoing_url.Url $search->referencing_url_type_2 '$search->referencing_url_text_2' AND ";
			}
			if ( !empty($search->referencing_url_text_3) ) {
				if ( $search->referencing_url_type_3 == 'LIKE' || $search->referencing_url_type_3 == 'NOT LIKE') $criteria->condition .= "outgoing_url.Url $search->referencing_url_type_3 '%$search->referencing_url_text_3%' AND ";
				else $criteria->condition .= "outgoing_url.Url $search->referencing_url_type_3 '$search->referencing_url_text_3' AND ";
			}	
			
			if ( !empty($search->referenced_url_text_1) ) {
				if ( $search->referenced_url_type_1 == 'LIKE' || $search->referenced_url_type_1 == 'NOT LIKE') $criteria->condition .= "schedule.Url $search->referenced_url_type_1 '%$search->referenced_url_text_1%' AND ";
				else $criteria->condition .= "schedule.Url $search->referenced_url_type_1 '$search->referenced_url_text_1' AND ";
			}
			if ( !empty($search->referenced_url_text_2) ) {
				if ( $search->referenced_url_type_2 == 'LIKE' || $search->referenced_url_type_2 == 'NOT LIKE') $criteria->condition .= "schedule.Url $search->referenced_url_type_2 '%$search->referenced_url_text_2%' AND ";
				else $criteria->condition .= "schedule.Url $search->referenced_url_type_2 '$search->referenced_url_text_2' AND ";
			}
			if ( !empty($search->referenced_url_text_3) ) {
				if ( $search->referenced_url_type_3 == 'LIKE' || $search->referenced_url_type_3 == 'NOT LIKE') $criteria->condition .= "schedule.Url $search->referenced_url_type_3 '%$search->referenced_url_text_3%' AND ";
				else $criteria->condition .= "schedule.Url $search->referenced_url_type_3 '$search->referenced_url_text_3' AND ";
			}	
			
			if ( !empty($search->anchor_text_1) ) {
				if ( $search->anchor_type_1 == 'LIKE' || $search->anchor_type_1 == 'NOT LIKE') $criteria->condition .= "Anchor $search->anchor_type_1 '%$search->anchor_text_1%' AND ";
				else $criteria->condition .= "Anchor $search->anchor_type_1 '$search->anchor_text_1' AND ";
			}
			if ( !empty($search->anchor_text_2) ) {
				if ( $search->anchor_type_2 == 'LIKE' || $search->anchor_type_2 == 'NOT LIKE') $criteria->condition .= "Anchor $search->anchor_type_2 '%$search->anchor_text_2%' AND ";
				else $criteria->condition .= "Anchor $search->anchor_type_2 '$search->anchor_text_2' AND ";
			}
			if ( !empty($search->anchor_text_3) ) {
				if ( $search->anchor_type_3 == 'LIKE' || $search->anchor_type_3 == 'NOT LIKE') $criteria->condition .= "Anchor $search->anchor_type_3 '%$search->anchor_text_3%' AND ";
				else $criteria->condition .= "Anchor $search->anchor_type_3 '$search->anchor_text_3' AND ";
			}	
			
			if ( !empty($search->result) && $search->result != 'all' )
				$criteria->condition .= "LinkResult $search->result_type '$search->result' AND ";
			if ( !empty($search->linktype) && $search->linktype != 'all' )
				$criteria->condition .= "LinkType $search->linktype_type '$search->linktype' AND ";
			if ( !empty($search->linkdomain) && $search->linkdomain != 'all' )
				$criteria->condition .= "LinkDomain $search->linkdomain_type '$search->linkdomain' AND ";
			
			if ( strlen($criteria->condition) > 0 ) $criteria->condition = substr($criteria->condition, 0, -4);
		}
		
		$criteria->compare('LinkType',$this->LinkType,true);
		$criteria->compare('LinkResult',$this->LinkResult,true);

		/*$criteria->compare('IDUrlSrc',$this->IDUrlSrc);

		$criteria->compare('IDUrlDest',$this->IDUrlDest);

		$criteria->compare('TagPosition',$this->TagPosition);

		$criteria->compare('AttrPosition',$this->AttrPosition);

		$criteria->compare('Anchor',$this->Anchor,true);

		$criteria->compare('LinkType',$this->LinkType,true);

		$criteria->compare('LinkResult',$this->LinkResult,true);

		$criteria->compare('LinkDomain',$this->LinkDomain,true);*/

		return new CActiveDataProvider('Link', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}
