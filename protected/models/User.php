<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $language
 * @property integer $role
 */
class User extends WebManagerActiveRecord
{
	/** Costanti utilizzate per determinare il ruolo dell'utente */
	const ROLE_USER=0;
	const ROLE_ADMIN=1;
	
	public $crawler_permissions;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, language, role', 'required'),
			array('language, role', 'numerical', 'integerOnly'=>true),
			array('username, email', 'length', 'max'=>255),
			array('password', 'length', 'max'=>32),
			array('email', 'email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, language, role, email', 'safe'),
			array('id, username, language, role', 'safe', 'on'=>'search'),
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
			'crawlers' => array(self::HAS_MANY, 'UserCrawler', 'user_id'),
			'crawlersCount' => array(self::STAT, 'UserCrawler', 'user_id'),
			//'user_groups'=>array(self::MANY_MANY, 'Group', 'user_group(user_id, group_id)'),
			'groups' => array(self::HAS_MANY, 'UserGroup', 'user_id'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'email' => 'Email',
			'username' => 'Username',
			'password' => 'Password',
			'language' => 'Language',
			'role' => 'Role',
		
		);
	}
	
	public function getPermissions (  ) {
		if ( empty($this->crawler_permissions) || count($this->crawler_permissions) == 0 )
			$this->setCrawlersPermissions();
		return $this->crawler_permissions;
	}
	
	public function unsetCrawlersPermissions ( $crawler_id ) {
		if ( empty($this->crawler_permissions) || count($this->crawler_permissions) == 0 )
			$this->setCrawlersPermissions();
		if ( !empty($this->crawler_permissions[$crawler_id]) && isset($this->crawler_permissions[$crawler_id]) ) 
			unset($this->crawler_permissions[$crawler_id]);
		return true;
	}
	
	public function getCrawlersPermissions ( $crawler_id ) {
		if ( empty($this->crawler_permissions) || count($this->crawler_permissions) == 0 )
			$this->setCrawlersPermissions();
		return $this->crawler_permissions[$crawler_id];
	}
	
	public function getUser_groups() {
		$ug = array();
		foreach ( $this->groups as $g )
			$ug[] = $g->group;
		return $ug;
	}
	
	public function setCrawlersPermissions() {
		
		static $default_permissions = array(
               'admin' => false,
               'read' => false,
               'cron' => false,
               'config' => false,
		);
		
		
		
		//User crawler permissions
		$crawlers = array(); //if a crawler is not setted in this array it means that the user doesn't have any kind of permissions
		try {
		if ( $this->user_groups !== null ) {
			foreach ( $this->user_groups as $ug ) {
				foreach ( $ug->crawler_groups as $cg ) {
					if (!isset($crawlers[$cg->crawler->id])) {
		               $crawlers[$cg->crawler->id] = $default_permissions;
		               $crawlers[$cg->crawler_id]['db_name_prepend'] = $cg->crawler->db_name_prepend;
						$crawlers[$cg->crawler_id]['db_name'] = $cg->crawler->db_name;
						$crawlers[$cg->crawler_id]['title'] = $cg->crawler->title;
						$crawlers[$cg->crawler_id]['model'] = $cg->crawler;
					}
					
					//Check all
					if ( $crawlers[$cg->crawler_id]['read'] != true )
						$crawlers[$cg->crawler_id]['read'] = ($cg->read==GroupCrawler::YES)?true:false;
					if ( $crawlers[$cg->crawler_id]['admin'] != true )
						$crawlers[$cg->crawler_id]['admin'] = ($cg->admin==GroupCrawler::YES)?true:false;
					if ( $crawlers[$cg->crawler_id]['cron'] != true )
						$crawlers[$cg->crawler_id]['cron'] = ($cg->cron==GroupCrawler::YES)?true:false;
					if ( $crawlers[$cg->crawler_id]['config'] != true )
						$crawlers[$cg->crawler_id]['config'] = ($cg->config==GroupCrawler::YES)?true:false;
					if ( $crawlers[$cg->crawler_id]['admin'] == true ) {
						$crawlers[$cg->crawler_id]['read'] = true;
						$crawlers[$cg->crawler_id]['cron'] = true;
						$crawlers[$cg->crawler_id]['config'] = true;
					}
				}
					
			}
		}
		} catch ( Exception $e ) {
			exit ( print_r($e) );
		}
		if ( $this->crawlers !== null ) {
			foreach ( $this->crawlers as $uc ) {
				if (!isset($crawlers[ $uc->crawler_id ])) {
	               $crawlers[ $uc->crawler_id ] = $default_permissions;
	               $crawlers[$uc->crawler_id]['db_name_prepend'] = $uc->crawler->db_name_prepend;
					$crawlers[$uc->crawler_id]['db_name'] = $uc->crawler->db_name;
					$crawlers[$uc->crawler_id]['title'] = $uc->crawler->title;
					$crawlers[$uc->crawler_id]['model'] = $uc->crawler;
				}
				
				if ( $uc->can_read != UserCrawler::NULL )
					$crawlers[$uc->crawler_id]['read'] = ($uc->can_read == UserCrawler::NO)?false:true;
				if ( $uc->admin != UserCrawler::NULL ) {
					$crawlers[$uc->crawler_id]['admin'] = ($uc->admin == UserCrawler::NO)?false:true;
					if ( $uc->admin == UserCrawler::YES ) {
						$crawlers[$uc->crawler_id]['read'] = true;
						$crawlers[$uc->crawler_id]['admin'] = true;
						$crawlers[$uc->crawler_id]['cron'] = true;
						$crawlers[$uc->crawler_id]['config'] = true;
						
					}
				}
			}
		}
		$this->crawler_permissions = $crawlers;
       
       
	}
	
	public function getCrawlersIDString() {
		if ( empty($this->crawler_permissions) || count($this->crawler_permissions) == 0 )
			$this->setCrawlersPermissions();
		$list = '';
		if ( count($this->crawler_permissions) > 0 ) {
			foreach ( $this->crawler_permissions as $c_id => $p ) {
				if ( $p['read'] == true || $p['admin'] == true )
					$list .= $p['model']->id . ', ';
			}
			$list = substr($list, 0, -2);
		}
		return $list;
	}
	
	/**
	 * @return array Get the crawler related to the user
	 */
	public function getCrawlersList() { 
		//TODO need to add crawler related to USER GROUP!
		if ( empty($this->crawler_permissions) || count($this->crawler_permissions) == 0 )
			$this->setCrawlersPermissions();
		//This was the old alg to get the list of allowed crawler. Now it uses also groups and select only dbs where AT LEAST read permission is on.
		/*
		if ( $this->crawlersCount > 0 ) {
			foreach ( $this->crawlers as $c ) {
				//exit( print_r($c) );
				$list[$c->crawler->db_name_prepend.'|'.$c->crawler->db_name_prepend.$c->crawler->db_name] = $c->crawler->title;
			}
		}
		*/
		$list = array();	
		foreach ( $this->crawler_permissions as $c_id => $p ) {
			if ( $p['read'] == true || $p['admin'] == true )
				$list[$p['db_name_prepend'].'|'.$p['db_name_prepend'].$p['db_name']] = $p['title'];
		}
		return $list;
	}
	
	/**
	 * Check if the user has the required access level role
	 * @param accessLevel The access level role
	 * @return boolean if the user has the required access level
	 */
	public static function checkRole( $acessLevel ) {
        return Yii::app()->user->getState('role') == $acessLevel;
    }
    
    /**
	 * @return integer The current user role { 0: normal user, 1: admin }
	 */
	public static function getRole() {
        return Yii::app()->user->getState('role');
    }
    
    /**
	 * @return User Get the current User object
	 */
    public static function getMe() {
    	return User::model()->findByPk(User::getUserID());
    }
    
    /**
	 * @return string Return the current language choosen by the User
	 */
	public static function getLanguage() {
		if ( Yii::app()->user->getState('language') === null)
			$langID = 1;
		else
			$langID = Yii::app()->user->getState('language');
		
		if ( $langID == 0 ) return 'it';
		else return 'en';
		
    }
    
    /**
	 * @return integer Return the current ID of the User
	 */
	public static function getUserID() {
        return Yii::app()->user->getId();
    }
    
    /**
	 * @return boolean Check if the user is allowed to do that action
	 */
	public function userHasOwnPermission() {
		 return ( $this->checkRole( self::ROLE_ADMIN ) || $this->id == Yii::app()->user->getId() );
	}
	
	
	
	/**
	 * This is invoked before the record is deleted.
	 */
	protected function beforeDelete()
	{
		parent::beforeDelete();
		//deleting all references to the crawler
		$ml = UserGroup::model()->findAll('user_id=?', array($this->id));
		foreach ( $ml as $m ) $m->delete();
		$ml = UserCrawler::model()->findAll('user_id=?', array($this->id));
		foreach ( $ml as $m ) $m->delete();
		
		return true;
	}
	
	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return md5($password)===$this->password;
	}
	
	/**
	 * @return string the URL that shows the detail of the User
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('user/view', array(
			'id'=>$this->id,
			'username'=>$this->username,
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
		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('language',$this->language);
		$criteria->compare('role',$this->role);
		$criteria->compare('email',$this->email,true);

		$criteria->order = 'username ASC';

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPageUser'],
			),
		));
	}
	
	public function searchGroup( $groupID, $inGroup )
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$g = Group::model()->findByPk($groupID);
		$addedList = array();
		foreach ( $g->users as $u  )
			$addedList[$u->id] = $u->id;

		$criteria=new CDbCriteria;
		$criteria->compare('username',$this->username,true);
		$criteria->order = 'username ASC';
		$ap = new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>999,
			),
		));
		
		$data = $ap->getData();
		$newData = array();
		foreach  ( $data as $m ) {
			if ( $inGroup && in_array($m->id, $addedList)) $newData[] = $m;
			if ( !$inGroup && !in_array($m->id, $addedList)) $newData[] = $m;
		}
		
		$ap->setData($newData);
		return $ap;
	}
	
}
