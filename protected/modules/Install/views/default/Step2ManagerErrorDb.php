<h1>Error establishing database connection</h1>
<?php echo CHtml::beginForm(''); ?>
<div class="form">
    <h3></h3>
    <div class="content">
    <fieldset>
        <p>Cannot connect to the database. Please check:</p>
        <ul>
            <li>Database server is running, database host name is correct.</li>
            <li>Username and password are correct.</li>
            <li>If database is not created, you have to create it first.</li>
        </ul>
        <p>Note that you should not install FlexciaCMS on an existing database used by other site(s).
        Tables with same name will be dropped and you data might be lost.</p>
        <a class="btn" href="<?php echo $this->createUrl('default/step2Manager'); ?>">Back</a>
    </fieldset>
    </div>
</div>
<?php echo CHtml::endForm(); ?>