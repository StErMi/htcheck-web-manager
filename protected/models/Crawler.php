<?php

/**
 * This is the model class for table "crawler".
 *
 * The followings are the available columns in table 'crawler':
 * @property integer $id
 * @property string $config_header
 * @property string $config_footer
 * @property string $title
 * @property string $start_url
 * @property string $limit_urls_to
 * @property string $limit_normalized
 * @property string $exclude_urls
 * @property integer $max_hop_count
 * @property integer $max_urls_count
 * @property string $bad_extensions
 * @property string $bad_querystr
 * @property integer $check_external
 * @property string $db_name
 * @property string $db_name_prepend
 * @property string $mysql_conf_file_prefix
 * @property string $mysql_conf_group
 * @property string $mysql_db_charset
 * @property string $mysql_client_charset
 * @property integer $url_index_length
 * @property integer $optimize_db
 * @property integer $sql_big_table_option
 * @property integer $max_doc_size
 * @property integer $store_only_links
 * @property integer $store_url_contents
 * @property string $user_agent
 * @property integer $persistent_connections
 * @property integer $head_before_get
 * @property integer $timeout
 * @property string $authorization
 * @property integer $max_retries
 * @property integer $tcp_wait_time
 * @property integer $tcp_max_retries
 * @property string $http_proxy
 * @property string $http_proxy_exclude
 * @property string $accept_language
 * @property integer $disable_cookies
 * @property string $cookies_input_file
 * @property string $url_reserved_chars
 * @property integer $summary_anchor_not_found
 * @property integer $accessibility_checks
 * @property integer $status
 */
class Crawler extends WebManagerActiveRecord
{
	const STATUS_READY = 0;
	const STATUS_BUSY = 1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Crawler the static model class
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
		return 'crawler';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			array('config_header, config_footer, title, start_url, limit_urls_to, check_external, db_name, db_name_prepend, mysql_conf_file_prefix, max_doc_size, store_url_contents, persistent_connections, timeout, max_retries, tcp_wait_time, tcp_max_retries', 'required'),
			array('max_hop_count, max_urls_count, check_external, url_index_length, optimize_db, sql_big_table_option, max_doc_size, store_only_links, store_url_contents, persistent_connections, head_before_get, timeout, max_retries, tcp_wait_time, tcp_max_retries, disable_cookies, summary_anchor_not_found, accessibility_checks', 'numerical', 'integerOnly'=>true),
			array('title, start_url, limit_urls_to, limit_normalized, exclude_urls, bad_extensions, bad_querystr, db_name, db_name_prepend, mysql_conf_file_prefix, mysql_conf_group, mysql_db_charset, mysql_client_charset, user_agent, authorization, http_proxy, http_proxy_exclude, accept_language, cookies_input_file, url_reserved_chars, status', 'length', 'max'=>255),
			array('check_external, optimize_db, sql_big_table_option, store_only_links, store_url_contents, persistent_connections, head_before_get, disable_cookies, summary_anchor_not_found, accessibility_checks', 'boolean'),
			array('db_name', 'checkDbName', 'on'=>array('create')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, config_header, config_footer, title, start_url, limit_urls_to, limit_normalized, exclude_urls, max_hop_count, max_urls_count, bad_extensions, bad_querystr, check_external, db_name, db_name_prepend, mysql_conf_file_prefix, mysql_conf_group, mysql_db_charset, mysql_client_charset, url_index_length, optimize_db, sql_big_table_option, max_doc_size, store_only_links, store_url_contents, user_agent, persistent_connections, head_before_get, timeout, authorization, max_retries, tcp_wait_time, tcp_max_retries, http_proxy, http_proxy_exclude, accept_language, disable_cookies, cookies_input_file, url_reserved_chars, summary_anchor_not_found, accessibility_checks, status', 'safe', 'on'=>'search'),
		);
	}
	
	/**
	 * Check existing DB.
	 * This is the 'checkDbName' validator as declared in rules().
	 */
	public function checkDbName($attribute,$params)
	{
		$crawler = Crawler::model()->find('LOWER(db_name)=? AND LOWER(db_name_prepend)=?',array(strtolower($this->db_name), strtolower($this->db_name_prepend)));
		
		if( $crawler !== null ) {
			$this->addError('db_name','The Crawler ' . $this->db_name_prepend . $this->db_name . ' has already been created.');
			return false;
		}
		return true;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'groups' => array(self::HAS_MANY, 'GroupCrawler', 'crawler_id'),
			'users' => array(self::HAS_MANY, 'UserCrawler', 'crawler_id'),
			'logs' => array(self::HAS_MANY, 'CrawlerLog', 'crawler_id', 'order'=>'logs.id DESC'),
			'crons' => array(self::HAS_MANY, 'CrawlerCrontab', 'crawler_id'),
			'queue' => array(self::HAS_MANY, 'CrawlerQueue', 'crawler_id', 'order'=>'queue.id DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'config_header' => 'Configuration Header', 
			'config_footer'=> 'Configuration Footer', 
			'title' => 'Crawler Title',
			'start_url' => 'Start Url',
			'limit_urls_to' => 'Limit Urls To',
			'limit_normalized' => 'Limit Normalized',
			'exclude_urls' => 'Exclude Urls',
			'max_hop_count' => 'Max Hop Count',
			'max_urls_count' => 'Max Urls Count',
			'bad_extensions' => 'Bad Extensions',
			'bad_querystr' => 'Bad Querystr',
			'check_external' => 'Check External',
			'db_name' => 'Db Name',
			'db_name_prepend' => 'Db Name Prepend',
			'mysql_conf_file_prefix' => 'Mysql Conf File Prefix',
			'mysql_conf_group' => 'Mysql Conf Group',
			'mysql_db_charset' => 'Mysql Db Charset',
			'mysql_client_charset' => 'Mysql Client Charset',
			'url_index_length' => 'Url Index Length',
			'optimize_db' => 'Optimize Db',
			'sql_big_table_option' => 'Sql Big Table Option',
			'max_doc_size' => 'Max Doc Size',
			'store_only_links' => 'Store Only Links',
			'store_url_contents' => 'Store Url Contents',
			'user_agent' => 'User Agent',
			'persistent_connections' => 'Persistent Connections',
			'head_before_get' => 'Head Before Get',
			'timeout' => 'Timeout',
			'authorization' => 'Authorization',
			'max_retries' => 'Max Retries',
			'tcp_wait_time' => 'Tcp Wait Time',
			'tcp_max_retries' => 'Tcp Max Retries',
			'http_proxy' => 'Http Proxy',
			'http_proxy_exclude' => 'Http Proxy Exclude',
			'accept_language' => 'Accept Language',
			'disable_cookies' => 'Disable Cookies',
			'cookies_input_file' => 'Cookies Input File',
			'url_reserved_chars' => 'Url Reserved Chars',
			'summary_anchor_not_found' => 'Summary Anchor Not Found',
			'accessibility_checks' => 'Accessibility Checks',
			'cron_minute' => 'Cron Minute',
			'cron_hour' => 'Cron Hour',
			'cron_day' => 'Cron Day',
			'cron_month' => 'Cron Month',
			'cron_weekday' => 'Cron Weekday',
			'status' => 'Status',
		);
	}
	
	/**
	 * @param $permType String Permission type: admin / read / confin / cron
	 * @return boolean Check if the user is allowed to do that action
	 */
	public function userHasOwnPermission( $permType ) { 
		if ( Yii::app()->user->isGuest ) return false;
		if ( User::checkRole(User::ROLE_ADMIN) ) return true;
		$u = User::getMe();
		$permissions = $u->getCrawlersPermissions( $this->id );
		return (!empty($permissions[$permType])&&($permissions[$permType]==true||$permissions[$permType]==1))?true:false;
	}
	
	/**
	 * @return string the URL that shows the detail of the User
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('crawler/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}
	
	public function initDefault() {
		// OLD DEFAULT CONFIG
		$this->config_header = '# ht://check Configuration Header Start Here #';
		$this->config_footer = '# ht://check Configuration Footer Start Here #';
		$this->limit_urls_to = '$(start_url)';
		$this->max_urls_count = -1;
		$this->check_external = true;
		$this->db_name_prepend = 'htcheck_';
		$this->db_name = str_replace($this->db_name_prepend, '', Yii::app()->session['_db']);
		$this->url_index_length = 64;
		$this->optimize_db = false;
		$this->sql_big_table_option = true;
		$this->max_doc_size = 1000000;
		$this->store_only_links = false;
		$this->store_url_contents = false;
		$this->user_agent = 'ht://Check';
		$this->persistent_connections = true;
		//$this->head_before_get = true;
		$this->head_before_get = false;
		$this->timeout = 30;
		$this->max_retries = 3;
		$this->tcp_wait_time = 5;
		$this->tcp_max_retries = 1;
		$this->mysql_conf_file_prefix = 'my';
		//$this->mysql_conf_group = 'client';
		$this->max_hop_count = -1;
		$this->disable_cookies = false;
		//$this->summary_anchor_not_found = true;
		//$this->accessibility_checks = true;
		$this->summary_anchor_not_found = false;
		$this->accessibility_checks = false;
		
			
			
	}
	
	public function toString( $newLineFile = true ) {
		
		$newLine = ( $newLineFile ) ? "\r\n" : "<br />";
		$confContent = '';
		
		$this->db_name = strtolower($this->db_name);
		
		/* converto bool */
		if (!empty($this->check_external) && $this->check_external != '' ) $this->check_external = ($this->check_external==1||$this->check_external) ? 'true' : 'false';
		if (!empty($this->optimize_db) && $this->optimize_db != '' ) $this->optimize_db = ($this->optimize_db==1||$this->optimize_db) ? 'true' : 'false';
		if (!empty($this->sql_big_table_option) && $this->sql_big_table_option != '' ) $this->sql_big_table_option = ($this->sql_big_table_option==1||$this->sql_big_table_option) ? 'true' : 'false';
		if (!empty($this->store_only_links) && $this->store_only_links != '' ) $this->store_only_links = ($this->store_only_links==1||$this->store_only_links) ? 'true' : 'false';
		if (!empty($this->store_url_contents) && $this->store_url_contents != '' ) $this->store_url_contents = ($this->store_url_contents==1||$this->store_url_contents) ? 'true' : 'false';
		if (!empty($this->persistent_connections) && $this->persistent_connections != '' ) $this->persistent_connections = ($this->persistent_connections==1||$this->persistent_connections) ? 'true' : 'false';
		if (!empty($this->head_before_get) && $this->head_before_get != '' ) $this->head_before_get = ($this->head_before_get==1||$this->head_before_get) ? 'true' : 'false';
		if (!empty($this->disable_cookies) && $this->disable_cookies != '' ) $this->disable_cookies = ($this->disable_cookies==1||$this->disable_cookies) ? 'true' : 'false';
		if (!empty($this->summary_anchor_not_found) && $this->summary_anchor_not_found != '' ) $this->summary_anchor_not_found = ($this->summary_anchor_not_found==1||$this->summary_anchor_not_found) ? 'true' : 'false';
		if (!empty($this->accessibility_checks) && $this->accessibility_checks != '' ) $this->accessibility_checks = ($this->accessibility_checks==1||$this->accessibility_checks) ? 'true' : 'false';
		
		if (!empty($this->config_header) && $this->config_header != '' ) $confContent .= $this->config_header. $newLine;
		if (!empty($this->start_url) && $this->start_url != '' ) $confContent .= 'start_url: '. $this->start_url. $newLine;
		if (!empty($this->start_url) && $this->start_url != '' ) $confContent .= 'start_url: '. $this->start_url. $newLine;
		if (!empty($this->limit_urls_to) && $this->limit_urls_to != '' ) $confContent .= 'limit_urls_to: '. $this->limit_urls_to. $newLine;
		if (!empty($this->limit_normalized) && $this->limit_normalized != '' ) $confContent .= 'limit_normalized: '. $this->limit_normalized. $newLine;
		if (!empty($this->exclude_urls) && $this->exclude_urls != '' ) $confContent .= 'exclude_urls: '. $this->exclude_urls. $newLine;
		if (!empty($this->max_hop_count) && $this->max_hop_count != '' ) $confContent .= 'max_hop_count: '. $this->max_hop_count. $newLine;
		if (!empty($this->max_urls_count) && $this->max_urls_count != '' ) $confContent .= 'max_urls_count: '. $this->max_urls_count. $newLine;
		if (!empty($this->bad_extensions) && $this->bad_extensions != '' ) $confContent .= 'bad_extensions: '. $this->bad_extensions. $newLine;
		if (!empty($this->bad_querystr) && $this->bad_querystr != '' ) $confContent .= 'bad_querystr: '. $this->bad_querystr. $newLine;
		if (!empty($this->check_external) && $this->check_external != '' ) $confContent .= 'check_external: '. $this->check_external. $newLine;
		if (!empty($this->db_name) && $this->db_name != '' ) $confContent .= 'db_name: '. $this->db_name. $newLine;
		if (!empty($this->db_name_prepend) && $this->db_name_prepend != '' ) $confContent .= 'db_name_prepend: '. $this->db_name_prepend. $newLine;
		if (!empty($this->mysql_conf_file_prefix) && $this->mysql_conf_file_prefix != '' ) $confContent .= 'mysql_conf_file_prefix: '. $this->mysql_conf_file_prefix. $newLine;
		if (!empty($this->mysql_conf_group) && $this->mysql_conf_group != '' ) $confContent .= 'mysql_conf_group: '. $this->mysql_conf_group. $newLine;
		if (!empty($this->mysql_db_charset) && $this->mysql_db_charset != '' ) $confContent .= 'mysql_db_charset: '. $this->mysql_db_charset. $newLine;
		if (!empty($this->mysql_client_charset) && $this->mysql_client_charset != '' ) $confContent .= 'mysql_client_charset: '. $this->mysql_client_charset. $newLine;
		if (!empty($this->url_index_length) && $this->url_index_length != '' ) $confContent .= 'url_index_length: '. $this->url_index_length. $newLine;
		if (!empty($this->optimize_db) && $this->optimize_db != '' ) $confContent .= 'optimize_db: '. $this->optimize_db. $newLine;
		if (!empty($this->sql_big_table_option) && $this->sql_big_table_option != '' ) $confContent .= 'sql_big_table_option: '. $this->sql_big_table_option. $newLine;
		if (!empty($this->max_doc_size) && $this->max_doc_size != '' ) $confContent .= 'max_doc_size: '. $this->max_doc_size. $newLine;
		if (!empty($this->store_only_links) && $this->store_only_links != '' ) $confContent .= 'store_only_links: '. $this->store_only_links. $newLine;
		if (!empty($this->store_url_contents) && $this->store_url_contents != '' ) $confContent .= 'store_url_contents: '. $this->store_url_contents. $newLine;
		if (!empty($this->user_agent) && $this->user_agent != '' ) $confContent .= 'user_agent: '. $this->user_agent. $newLine;
		if (!empty($this->persistent_connections) && $this->persistent_connections != '' ) $confContent .= 'persistent_connections: '. $this->persistent_connections. $newLine;
		if (!empty($this->head_before_get) && $this->head_before_get != '' ) $confContent .= 'head_before_get: '. $this->head_before_get. $newLine;
		if (!empty($this->timeout) && $this->timeout != '' ) $confContent .= 'timeout: '. $this->timeout. $newLine;
		if (!empty($this->authorization) && $this->authorization != '' ) $confContent .= 'authorization: '. $this->authorization. $newLine;
		if (!empty($this->max_retries) && $this->max_retries != '' ) $confContent .= 'max_retries: '. $this->max_retries. $newLine;
		if (!empty($this->tcp_wait_time) && $this->tcp_wait_time != '' ) $confContent .= 'tcp_wait_time: '. $this->tcp_wait_time. $newLine;
		if (!empty($this->tcp_max_retries) && $this->tcp_max_retries != '' ) $confContent .= 'tcp_max_retries: '. $this->tcp_max_retries. $newLine;
		if (!empty($this->http_proxy) && $this->http_proxy != '' ) $confContent .= 'http_proxy: '. $this->http_proxy. $newLine;
		if (!empty($this->http_proxy_exclude) && $this->http_proxy_exclude != '' ) $confContent .= 'http_proxy_exclude: '. $this->http_proxy_exclude. $newLine;
		if (!empty($this->accept_language) && $this->accept_language != '' ) $confContent .= 'accept_language: '. $this->accept_language. $newLine;
		if (!empty($this->disable_cookies) && $this->disable_cookies != '' ) $confContent .= 'disable_cookies: '. $this->disable_cookies. $newLine;
		if (!empty($this->cookies_input_file) && $this->cookies_input_file != '' ) $confContent .= 'cookies_input_file: '. $this->cookies_input_file. $newLine;
		if (!empty($this->url_reserved_chars) && $this->url_reserved_chars != '' ) $confContent .= 'url_reserved_chars: '. $this->url_reserved_chars. $newLine;
		if (!empty($this->summary_anchor_not_found) && $this->summary_anchor_not_found != '' ) $confContent .= 'summary_anchor_not_found: '. $this->summary_anchor_not_found. $newLine;
		if (!empty($this->accessibility_checks) && $this->accessibility_checks != '' ) $confContent .= 'accessibility_checks: '. $this->accessibility_checks. $newLine;
		if (!empty($this->config_footer) && $this->config_footer != '' ) $confContent .= $this->config_footer. $newLine;
		return $confContent;
	}
	
	/**
	 * This is invoked before the record is saved.
	 */
	protected function beforeSave()
	{
		if($this->isNewRecord)
		{
			$this->status = Crawler::STATUS_READY;
		}
		return true;
	
	}
	
	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		// Creo il rispettivo UserCrawler
		if($this->isNewRecord)
		{
			$user_crawler = new UserCrawler;
			$user_crawler->can_read = UserCrawler::YES;
			$user_crawler->admin = UserCrawler::YES;
			$user_crawler->crawler_id = $this->id;
			$user_crawler->user_id = User::getUserID();
			$user_crawler->save(false);
		}
		
		
	}
	
	public function saveConfig( $path='' ) {
		//save the config
		
		$confPath = './crawlers_config/' . $this->db_name_prepend . $this->db_name . '.conf';
		if ( $path != '' ) $confPath = $path;
		$fh = fopen($confPath, 'w') or die("can't open file");
		$confContent = $this->toString();
		
		fwrite($fh, $confContent);
		fclose($fh);
	}
	
	public function unlinkConfig( $path='' ) {
		//deleting the config
		$confPath = './crawlers_config/' . $this->db_name_prepend . $this->db_name . '.conf';
		if ( $path != '' ) $confPath = $path;
		@unlink($confPath);
		return;
	}
	
	/**
	 * This is invoked before the record is deleted.
	 */
	protected function beforeDelete()
	{
		parent::beforeDelete();
		
		//deleting all references to the crawler
		$ml = UserCrawler::model()->findAll('crawler_id=?', array($this->id));
		foreach ( $ml as $m ) {
			// updating all users permissions
			$m->user->unsetCrawlersPermissions($this->id);
			$m->delete();
		}
		$ml = GroupCrawler::model()->findAll('crawler_id=?', array($this->id));
		foreach ( $ml as $m ) {
			//Updating all users permissions
			foreach ( $m->group->users as $u ) 
				$u->unsetCrawlersPermissions($this->id);
			$m->delete();
		}
		$ml = CrawlerLog::model()->findAll('crawler_id=?', array($this->id));
		foreach ( $ml as $m ) $m->delete();
		$ml = CrawlerCrontab::model()->findAll('crawler_id=?', array($this->id));
		foreach ( $ml as $m ) $m->delete();
		$ml = CrawlerQueue::model()->findAll('crawler_id=?', array($this->id));
		foreach ( $ml as $m ) $m->delete();
		
		
		
		//deleting the config
		$this->unlinkConfig();
		return true;
	}
	
	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search( $user )
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$idList = $user->getCrawlersIDString( );
		

		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title,true);
		$criteria->compare('start_url',$this->start_url,true);
		$criteria->compare('db_name',$this->db_name,true);
		$criteria->compare('db_name_prepend',$this->db_name_prepend,true);
		
		if ( !empty($idList) && count($idList) > 0 )
			$criteria->condition  = 'id IN ('.$idList.')';
		

		return new CActiveDataProvider('Crawler', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}



