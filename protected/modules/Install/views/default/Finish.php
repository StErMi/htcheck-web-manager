<?php $this->pageTitle = Yii::app()->name.' - Congratulation, you made it!';?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Congratulation, you made it!</legend>

<p class="emphasize">htCheck has been installed. It is important that you rename or remove <?php echo Yii::getPathOfAlias('application.modules.Install');?> folder to avoid other to run the installation again and delete your database.</p>
<div class="form">
    <div class="content">
    <div class="input">
        <label>Username</label><strong><?php if (Yii::app()->session->contains('username')) echo Yii::app()->session['username'];?></strong>
    </div>
    <div class="input">
        <label>Password</label><strong><?php if (Yii::app()->session->contains('password')) echo Yii::app()->session['password'];?></strong>
        <div class="note">Note that password carefully!</div>
    </div>
    <br />
    <font color="green"><b>Now you can start using HtCheck WebManager! Go to the index page!</b></font>
    </div>
</div>

</fieldset>