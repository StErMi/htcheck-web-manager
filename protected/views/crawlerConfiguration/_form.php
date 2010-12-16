
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app', 'form_obbligo_1'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'form_obbligo_2'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	
	<div id="tabs">
	<ul>
		<li><a href="#tabs-1">General Informations</a></li>
		<li><a href="#tabs-2">Database Info</a></li>
		<li><a href="#tabs-3">Information storing settings</a></li>
		<li><a href="#tabs-4">Connection Info</a></li>
		<li><a href="#tabs-5">Report & Accessibility Checks</a></li>
	</ul>
	
	<div id="tabs-1">
	
		<div class="row">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'Enter the Configuration\'s Mnemonic Title', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
		
		<?php if ( User::checkRole(User::ROLE_ADMIN)): ?>
		<div class="row">
			<?php echo $form->labelEx($model,'config_header'); ?>
			<?php echo $form->textArea($model,'config_header',array('cols'=>70,'rows'=>5, 'class'=>'qtipped', 'title'=>'Enter the configuration header (loaded before htcheck config)', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'config_header'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'config_footer'); ?>
			<?php echo $form->textArea($model,'config_footer',array('cols'=>70,'rows'=>5, 'class'=>'qtipped', 'title'=>'Enter the configuration footer (loaded after htcheck config)', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'config_footer'); ?>
		</div>
		<?php endif; ?>	
	
	
		<div class="row">
			<?php echo $form->labelEx($model,'limit_urls_to'); ?>
			<?php echo $form->textField($model,'limit_urls_to',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'This specifies a set of patterns that all URLs have to
						match against in order for them to be included in the
						search. Any number of strings can be specified,
						separated by spaces. If multiple patterns are given, at
						least one of the patterns has to match the URL.
						Matching is a case-insensitive string match on the URL
						to be used. The match will be performed after
						the relative references have been converted to a valid
						URL.
						Granted, this is not the perfect way of doing this,
						but it is simple enough and it covers most cases.
						EXAMPLE limit_urls_to: .sdsu.edu kpbs', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'limit_urls_to'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'limit_normalized'); ?>
			<?php echo $form->textField($model,'limit_normalized',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'This specifies a set of patterns that all URLs have to
					match against in order for them to be included in the
					search. Unlike the limit_urls_to directive, this is done
					after the URL is normalized. EXAMPLE limit_normalized: http://www.mydomain.com', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'limit_normalized'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'exclude_urls'); ?>
			<?php echo $form->textField($model,'exclude_urls',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'If a URL contains any of the space separated patterns,
						it will be rejected. This is used to exclude such
						common things such as an infinite virtual web-tree
						which start with cgi-bin.
						EXAMPLE exclude_urls: students.html cgi-bin', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'exclude_urls'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'max_hop_count'); ?>
			<?php echo $form->textField($model,'max_hop_count',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'Max number of clicks from the first crawled page
						After that number, URL won\'t be retrieved anymore.
						EXAMPLE max_hop_count: 10', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'max_hop_count'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'max_urls_count'); ?>
			<?php echo $form->textField($model,'max_urls_count',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'Maximum number of URLs to be parsed 
						After that number, ht://Check stops parsing URLs and performs
						a simple check for existance. Default: -1 (infinite). EXAMPLE max_urls_count: 70', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'max_urls_count'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'bad_extensions'); ?>
			<?php echo $form->textField($model,'bad_extensions',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'This is a list of extensions on URLs which are
						considered non-parsable. This list is used mainly to
						supplement the MIME-types that the HTTP server provides
						with documents. Some HTTP servers do not have a correct
						list of MIME-types and so can advertise certain
						documents as text while they are some binary format. EXAMPLE bad_extensions: .foo .bar .bad', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'bad_extensions'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'bad_querystr'); ?>
			<?php echo $form->textField($model,'bad_querystr',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'This is a list of CGI query strings to be excluded from
						indexing. This can be used in conjunction with CGI-generated
						portions of a website to control which pages are
						indexed. EXAMPLE bad_querystr: forum=private section=topsecret&amp;passwd=required', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'bad_querystr'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'check_external'); ?>
			<?php echo $form->checkBox($model,'check_external', array( 'class'=>'qtipped', 'title'=> 'If set to true, htcheck check if external Urls exist or not.
						An external Url is an Url which doesn\'t match limit configuration
						attributes. External URLs aren\'t parsed. EXAMPLE check_external: true', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'check_external'); ?>
		</div>
	</div>
	<div id="tabs-2">
		<div class="row">
			<?php echo $form->labelEx($model,'db_name_prepend'); ?>
			<?php echo $form->textField($model,'db_name_prepend',array('size'=>70,'maxlength'=>255, 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'db_name_prepend'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'mysql_conf_file_prefix'); ?>
			<?php echo $form->textField($model,'mysql_conf_file_prefix',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'Prefix for the MySQL configuration file to be searched. Default is \'my\' and
						the file searched is usually \'~/.my.cnf\' (suggested). If it is not found the
						default system-wide MySQL config file is searched (on Debian, this is
						/etc/mysql/my.cnf).  For its syntax, look at \'Option File\' contents inside
						the MySQL documentation. ht://Check at the moment accept only the host, user,
						password, port and socket settings.
						IMPORTANT: only for MySQL 3.23, 4.0, 4.1 and 5.0', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'mysql_conf_file_prefix'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'mysql_conf_group'); ?>
			<?php echo $form->textField($model,'mysql_conf_group',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'Group to be searched inside the .my.cnf file of MySQL for getting the
						settings for the connection to the server. In other words, it\'s the
						section marked with [<group>] inside the MySQL option file (default
						is [client]). EXAMPLE mysql_conf_group: htcheck', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'mysql_conf_group'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'mysql_db_charset'); ?>
			<?php echo $form->textField($model,'mysql_db_charset',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'Database charset (charset of the database that will be created by htcheck)
						Default value is \'default\' which maps to the value of the --with-db-charset
						configure option (compilation time) or - alternatively - the server\'s default. EXAMPLE mysql_db_charset: utf8', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'mysql_db_charset'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'mysql_client_charset'); ?>
			<?php echo $form->textField($model,'mysql_client_charset',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'Client charset. Charset to be used by htcheck when sending queries to the
						mysql server. Default value is empty (server\'s setting). EXAMPLE mysql_client_charset: utf8', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'mysql_client_charset'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'url_index_length'); ?>
			<?php echo $form->textField($model,'url_index_length',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=>'This number specifies the length of the index of the
						Url field in the Schedule and Url tables of the database.
						You can set different values depending on the average
						length of the URLs that htcheck can find in your
						sites. If you don\'t want to set any limitation, just
						put a \'-1\' value.
						This now allows the user to control the length of the index
						for the Url field in the Schedule and Url tables. This attribute
						may affect the performance of the crawls, as long as the length
						of an index can either slow down or speed up the spidering process.
						Default value is 64. EXAMPLE url_index_length: -1', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'url_index_length'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'optimize_db'); ?>
			<?php echo $form->checkBox($model,'optimize_db', array( 'class'=>'qtipped', 'title'=> 'Optimize the database tables at the end of the crawl. Disable it if
						the database server doesn\'t support it. Default is \'false\'. EXAMPLE optimize_db: true', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'optimize_db'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'sql_big_table_option'); ?>
			<?php echo $form->checkBox($model,'sql_big_table_option', array( 'class'=>'qtipped', 'title'=> 'Enable or disable this option that is useful when performing huge queries.
						Otherwise, sometimes when it\'s not set, the MySQL db server may return
						a \'table is full\' error. Default is \'true\'. EXAMPLE sql_big_table_option: false', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'sql_big_table_option'); ?>
		</div>
	
	</div>
	
	<div id="tabs-3">
		
		<div class="row">
			<?php echo $form->labelEx($model,'max_doc_size'); ?>
			<?php echo $form->textField($model,'max_doc_size',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'Maximum size of the document. EXAMPLE max_doc_size:	700000', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'max_doc_size'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'store_only_links'); ?>
			<?php echo $form->checkBox($model,'store_only_links', array( 'class'=>'qtipped', 'title'=> 'If set to false, htcheck will store in the DB <every> tag he finds
						in every document he crawls.
						If set to true, htcheck stores only those Html attributes and statements
						that produce a link or set an anchor
						(identified by the pair tag: A, attribute: name). EXAMPLE store_only_links: false', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'store_only_links'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'store_url_contents'); ?>
			<?php echo $form->checkBox($model,'store_url_contents', array( 'class'=>'qtipped', 'title'=> 'This attribute allows to store the contents of the parsed URLs.
						It is very useful, but also dangerous. You must know what you
						are doing, if you enable this your performances may slow down
						and your disk requirements can get extremely high. It is recommended
						to use this only for small crawls. EXAMPLE store_url_contents: true', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'store_url_contents'); ?>
		</div>
	</div>
	<div id="tabs-4">
		
		<div class="row">
			<?php echo $form->labelEx($model,'user_agent'); ?>
			<?php echo $form->textField($model,'user_agent',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'User Agent for HTTP connections. EXAMPLE user_agent:	ht://check', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'user_agent'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'persistent_connections'); ?>
			<?php echo $form->checkBox($model,'persistent_connections', array( 'class'=>'qtipped', 'title'=> 'HTTP/1.1 persistent connections (if possible on every server). EXAMPLE persistent_connections: true', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'persistent_connections'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'head_before_get'); ?>
			<?php echo $form->checkBox($model,'head_before_get', array( 'class'=>'qtipped', 'title'=> 'We make a HEAD call before a GET call (HTTP/1.1). EXAMPLE head_before_get: true', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'head_before_get'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'timeout'); ?>
			<?php echo $form->textField($model,'timeout',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'Connection timeout. EXAMPLE timeout:	3', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'timeout'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'authorization'); ?>
			<?php echo $form->textField($model,'authorization',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'This tells htcheck to send the supplied
					username:password with each HTTP request.
					The credentials will be encoded using the "Basic" authentication
					scheme. There must be a colon (:) between the username and
					password. EXAMPLE authorization: myusername:mypassword', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'authorization'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'max_retries'); ?>
			<?php echo $form->textField($model,'max_retries',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'Number of attempts for retrieving a document. EXAMPLE max_retries: 1', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'max_retries'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'tcp_wait_time'); ?>
			<?php echo $form->textField($model,'tcp_wait_time',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'Wait time after a connection timeouts. EXAMPLE tcp_wait_time: 1', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'tcp_wait_time'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'tcp_max_retries'); ?>
			<?php echo $form->textField($model,'tcp_max_retries',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'And number of retries (TCP layer). EXAMPLE tcp_max_retries: 1', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'tcp_max_retries'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'http_proxy'); ?>
			<?php echo $form->textField($model,'http_proxy',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'When this attribute is set, all HTTP document
						retrievals will be done using the HTTP-PROXY protocol.
						The URL specified in this attribute points to the host
						and port where the proxy server resides.
						The use of a proxy server greatly improves performance
						of the indexing process. Default: empty. EXAMPLE http_proxy: http://proxy.bigbucks.com:3128', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'http_proxy'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'http_proxy_exclude'); ?>
			<?php echo $form->textField($model,'http_proxy_exclude',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'When this is set, URLs matching this will not use the
						proxy. This is useful when you have a mixture of sites
						near to the digging server and far away. EXAMPLE http_proxy_exclude: http://intranet.foo.com/', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'http_proxy_exclude'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'accept_language'); ?>
			<?php echo $form->textField($model,'accept_language',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'This attribute allows to restrict the set of natural languages that are
						preferred as a response to an HTTP request performed by the digger. This can be
						done by putting one or more language tags (as defined by RFC 1766) in the
						preferred order, separated by spaces. By doing this, when the server performs a
						content negotiation based on the \'accept-language\' given by the HTTP user agent,
						a different content can be shown depending on the value of this attribute. If
						set empty, no language will be sent and the server default will be returned. EXAMPLE accept_language: en-us en it', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'accept_language'); ?>
		</div>
		
		<div class="row"> 
			<?php echo $form->labelEx($model,'disable_cookies'); ?>
			<?php echo $form->checkBox($model,'disable_cookies', array( 'class'=>'qtipped', 'title'=> 'If set to \'true\', htcheck will disable the HTTP cookies management. EXAMPLE disable_cookies: true', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'disable_cookies'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'cookies_input_file'); ?>
			<?php echo $form->textField($model,'cookies_input_file',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'Set the input file to be used when importing cookies for the
						crawl; cookies must be specified according to Netscape\'s format.
						For more information, give a look at the example cookies file
						distributed with ht://Check. By default, no input file is read. EXAMPLE cookies_input_file: /tmp/cookies.txt', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'cookies_input_file'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'url_reserved_chars'); ?>
			<?php echo $form->textField($model,'url_reserved_chars',array('size'=>70,'maxlength'=>255, 'class'=>'qtipped', 'title'=> 'This string allows to customise the set of characters that can be considered
						as reserverd in a URL, avoiding their coding under the <tt>RFC1738</tt> standard.
						This string is used when checking whether a URL is well-encoded or not,
						issuing a \'<em>BadEncoded</em>\' state for the link which created it.
						The default value is slightly different from what the RFC says, giving
						more flexibility to the spider (it is suggested not to change it unless you
						are extremely sure of what you are doing). EXAMPLE url_reserved_chars: \\;/?:@&=+\$,._%-x~', 'readonly'=>$readOnly)); ?>
			<?php echo $form->error($model,'url_reserved_chars'); ?>
		</div>
	</div>
	
	<div id="tabs-5">
		
		<div class="row">
			<?php echo $form->labelEx($model,'summary_anchor_not_found'); ?>
			<?php echo $form->checkBox($model,'summary_anchor_not_found', array( 'class'=>'qtipped', 'title'=> 'Enable or disable the show of the summary of the HTML anchors that
						have not been found. Default is enabled (true). EXAMPLE summary_anchor_not_found: false', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'summary_anchor_not_found'); ?>
		</div>
		
		
		<div class="row">
			<?php echo $form->labelEx($model,'accessibility_checks'); ?>
			<?php echo $form->checkBox($model,'accessibility_checks', array( 'class'=>'qtipped', 'title'=> 'Enable or disable the recognition of accessibility problems, using
					some of the checks proposed by the Open Accessibility Checks project
					by the Adaptive TechnologyResource Center at the University Of Toronto.
					From version 1.2.3, ht://Checks internally stores this kind of
					information in the \'AccessibilityChecks\' table using the code number
					specified in OAC (http://oac.atrc.utoronto.ca). EXAMPLE accessibility_checks: false', 'readonly'=>$readOnly )); ?>
			<?php echo $form->error($model,'accessibility_checks'); ?>
		</div>
	</div>
	
	</div> <!-- Fine TABS -->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">
	$(function(){
		// Tabs
		$('#tabs').tabs();
		
		// qtips
		$(".qtipped").qtip({ 
			style: { 
			 	width: 450,
		      	padding: 5,						
				name: 'cream', 
				tip: true 
			},
			position: {
		      corner: {
		         target: 'rightMiddle',
		         tooltip: 'leftMiddle'
		      }
		   },
			show: 'focus',
			hide: 'unfocus'
						  
					 
		});


		
	});
</script>


	



