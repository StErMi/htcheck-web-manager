<?php

/**
 * This is the model class for table "crawler".
 *
 * The followings are the available columns in table 'crawler':
 * @property integer $id
 * @property string $config_header
 * @property string $config_footer
 * @property string $title
 * @property string $limit_urls_to
 * @property string $limit_normalized
 * @property string $exclude_urls
 * @property integer $max_hop_count
 * @property integer $max_urls_count
 * @property string $bad_extensions
 * @property string $bad_querystr
 * @property integer $check_external
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
class CrawlerConfiguration extends WebManagerActiveRecord
{
	
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
		return 'crawler_configuration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			array('config_header, config_footer, title, limit_urls_to, check_external, db_name_prepend, mysql_conf_file_prefix, max_doc_size, store_url_contents, persistent_connections, timeout, max_retries, tcp_wait_time, tcp_max_retries', 'required'),
			array('max_hop_count, max_urls_count, check_external, url_index_length, optimize_db, sql_big_table_option, max_doc_size, store_only_links, store_url_contents, persistent_connections, head_before_get, timeout, max_retries, tcp_wait_time, tcp_max_retries, disable_cookies, summary_anchor_not_found, accessibility_checks', 'numerical', 'integerOnly'=>true),
			array('title, limit_urls_to, limit_normalized, exclude_urls, bad_extensions, bad_querystr, db_name_prepend, mysql_conf_file_prefix, mysql_conf_group, mysql_db_charset, mysql_client_charset, user_agent, authorization, http_proxy, http_proxy_exclude, accept_language, cookies_input_file, url_reserved_chars, status', 'length', 'max'=>255),
			array('check_external, optimize_db, sql_big_table_option, store_only_links, store_url_contents, persistent_connections, head_before_get, disable_cookies, summary_anchor_not_found, accessibility_checks', 'boolean'),
			
			array('config_header, config_footer, title, limit_urls_to, check_external, db_name_prepend, mysql_conf_file_prefix, max_doc_size, store_url_contents, persistent_connections, timeout, max_retries, tcp_wait_time, tcp_max_retries', 'safe'),
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
			'id' => 'Id',
			'config_header' => 'Configuration Header', 
			'config_footer'=> 'Configuration Footer', 
			'title' => 'Configuration Title',
			'limit_urls_to' => 'Limit Urls To',
			'limit_normalized' => 'Limit Normalized',
			'exclude_urls' => 'Exclude Urls',
			'max_hop_count' => 'Max Hop Count',
			'max_urls_count' => 'Max Urls Count',
			'bad_extensions' => 'Bad Extensions',
			'bad_querystr' => 'Bad Querystr',
			'check_external' => 'Check External',
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
		if ( User::checkRole(User::ROLE_ADMIN) ) return true;
		else return false;
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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.		

		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider('CrawlerConfiguration', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['itemsPerPage'],
			),
		));
	}
}



