<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->titolo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_url')); ?>:</b>
	<?php echo CHtml::encode($data->start_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit_urls_to')); ?>:</b>
	<?php echo CHtml::encode($data->limit_urls_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('limit_normalized')); ?>:</b>
	<?php echo CHtml::encode($data->limit_normalized); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exclude_urls')); ?>:</b>
	<?php echo CHtml::encode($data->exclude_urls); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('max_hop_count')); ?>:</b>
	<?php echo CHtml::encode($data->max_hop_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_urls_count')); ?>:</b>
	<?php echo CHtml::encode($data->max_urls_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bad_extensions')); ?>:</b>
	<?php echo CHtml::encode($data->bad_extensions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bad_querystr')); ?>:</b>
	<?php echo CHtml::encode($data->bad_querystr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('check_external')); ?>:</b>
	<?php echo CHtml::encode($data->check_external); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_name')); ?>:</b>
	<?php echo CHtml::encode($data->db_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('db_name_prepend')); ?>:</b>
	<?php echo CHtml::encode($data->db_name_prepend); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mysql_conf_file_prefix')); ?>:</b>
	<?php echo CHtml::encode($data->mysql_conf_file_prefix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mysql_conf_group')); ?>:</b>
	<?php echo CHtml::encode($data->mysql_conf_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mysql_db_charset')); ?>:</b>
	<?php echo CHtml::encode($data->mysql_db_charset); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mysql_client_charset')); ?>:</b>
	<?php echo CHtml::encode($data->mysql_client_charset); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_index_length')); ?>:</b>
	<?php echo CHtml::encode($data->url_index_length); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('optimize_db')); ?>:</b>
	<?php echo CHtml::encode($data->optimize_db); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sql_big_table_option')); ?>:</b>
	<?php echo CHtml::encode($data->sql_big_table_option); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_doc_size')); ?>:</b>
	<?php echo CHtml::encode($data->max_doc_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_only_links')); ?>:</b>
	<?php echo CHtml::encode($data->store_only_links); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_url_contents')); ?>:</b>
	<?php echo CHtml::encode($data->store_url_contents); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_agent')); ?>:</b>
	<?php echo CHtml::encode($data->user_agent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('persistent_connections')); ?>:</b>
	<?php echo CHtml::encode($data->persistent_connections); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('head_before_get')); ?>:</b>
	<?php echo CHtml::encode($data->head_before_get); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeout')); ?>:</b>
	<?php echo CHtml::encode($data->timeout); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('authorization')); ?>:</b>
	<?php echo CHtml::encode($data->authorization); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_retries')); ?>:</b>
	<?php echo CHtml::encode($data->max_retries); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tcp_wait_time')); ?>:</b>
	<?php echo CHtml::encode($data->tcp_wait_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tcp_max_retries')); ?>:</b>
	<?php echo CHtml::encode($data->tcp_max_retries); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('http_proxy')); ?>:</b>
	<?php echo CHtml::encode($data->http_proxy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('http_proxy_exclude')); ?>:</b>
	<?php echo CHtml::encode($data->http_proxy_exclude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accept_language')); ?>:</b>
	<?php echo CHtml::encode($data->accept_language); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disable_cookies')); ?>:</b>
	<?php echo CHtml::encode($data->disable_cookies); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cookies_input_file')); ?>:</b>
	<?php echo CHtml::encode($data->cookies_input_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_reserved_chars')); ?>:</b>
	<?php echo CHtml::encode($data->url_reserved_chars); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('summary_anchor_not_found')); ?>:</b>
	<?php echo CHtml::encode($data->summary_anchor_not_found); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accessibility_checks')); ?>:</b>
	<?php echo CHtml::encode($data->accessibility_checks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cron_minute')); ?>:</b>
	<?php echo CHtml::encode($data->cron_minute); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cron_hour')); ?>:</b>
	<?php echo CHtml::encode($data->cron_hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cron_day')); ?>:</b>
	<?php echo CHtml::encode($data->cron_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cron_month')); ?>:</b>
	<?php echo CHtml::encode($data->cron_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cron_weekday')); ?>:</b>
	<?php echo CHtml::encode($data->cron_weekday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>
