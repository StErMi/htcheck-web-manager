<?php 
$this->pageTitle = Yii::app()->name.' - System checks';
$next = true;
?>
<?php echo CHtml::beginForm(array('default/Step2Manager')); ?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">System Checks</legend>
<div class="form">
    
    <div class="content">
    
    <div class="emphasize">Check if htCheck is compatible with your environment</div>
    <ol>
       <li>Web server ... OK</li>
       <li>PHP 5 and required modules ... OK</li>
       <?php if (Yii::getVersion() >= '1.1.4') {
           $yiiVersion = '<span style="color:green">OK</span>';
       } else {
           $next = false;
           $yiiVersion = '<span style="color:red">Fail</span>';
       }
       
       $next = $next && $continue;
       ?>
       <li>Yii 1.1.4 or above ... <?php echo $yiiVersion;?></li>
    </ol>
    <br/>
    <div class="note">
        <div class="emphasize">The fowllowing folders must be writable:</div>
        <ul>
        	<?php 
        		for($i=0; $i<count($folders); $i++)
        			echo ( $writables[$i] == true )?'<li>'.realpath($folders[$i]).' - <span style="color:green">OK</span></li>':'<li>'.realpath($folders[$i]).' - <span style="color:red">NOT OK</span></li>';
        	?>
        </ul>
    </div>
    <?php if ($next === false) : ?>
    <br />
    <div class="flash-error">Make sure all folders listed above exist and are writable before start.</div>
    <?php endif; ?>
    
</div>
</div>
</fieldset>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">License Agreement</legend>

<div class="form">
    <h3></h3>
    <div class="content">
            <div style="height: 250px; width: 800px; overflow: scroll; overflow-x:hidden; border: 1px solid gray; padding: 5px; font-size: 1.2em; margin: 0 auto;">
            <?php
            $copyright = Yii::getPathOfAlias('webroot').'/COPYING';
            if (file_exists($copyright)):?>
                <?php echo '<pre>'.CHtml::encode(file_get_contents($copyright)).'</pre>';?>
            <?php endif;?>
            </div>
        <?php if ($next === true) : ?>
        <div class="output" style="padding-left: 0; text-align: center;">        
            <?php echo CHtml::submitButton('Next', array('class'=>'button-2'));?>
        </div>
        <div class="note" style="text-align: center;">By clicking Next, you agree to the terms stated in the htCheck License Agreement above.</div>
        <?php endif; ?>
    </div>
</div>
</fieldset>
<?php CHtml::endForm(); ?>


