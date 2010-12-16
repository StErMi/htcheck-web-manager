
<?php echo CHtml::beginForm(''); ?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Error establishing database connection</legend>
<div class="form">
    <div class="content">
        <p>Cannot connect to the database. Please check:</p>
        <ul>
            <li>Database server is running, database host name is correct.</li>
            <li>Username and password are correct.</li>
            <li>If database is not created, you have to create it first.</li>
        </ul>
        <p>Note that you should not install ht://Check Web Manager on an existing database used by other site(s).
        Tables with same name will be dropped and you data might be lost.</p>
        <a class="btn" href="<?php echo $this->createUrl('default/step2General'); ?>">Back</a>
    </div>
</div>
</fieldset>
<?php echo CHtml::endForm(); ?>