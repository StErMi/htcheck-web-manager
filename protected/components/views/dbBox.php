
<?php echo CHtml::beginForm(); ?>
    <div id="dbdrop">
        <?php 
        	//$u = User::getMe();
        	
        	$dbs = $this->crawler_list;
        	//exit ( print_r($currentDb));
        	if ( count($dbs) > 0 ) {
	        	if ( !isset($currentDb) || empty($currentDb) ) {
	        		$keys = array_keys($dbs);
	        		$currentDb = $dbs[$keys[0]];
	        		echo CHtml::dropDownList('_db', null, $dbs, array('submit' => '', 'empty' => 'Choose a Database'));
	        	} else
	        		echo CHtml::dropDownList('_db', $currentDb, $dbs, array('submit' => ''));
	        	
        	} else {
        		unset(Yii::app()->session['_db_prepend']);
	        	unset(Yii::app()->session['_db']);
        		echo 'At the moment you can\'t access to any crawler.';
        	}
        	
        	
        ?>
    </div>
<?php echo CHtml::endForm(); ?>
