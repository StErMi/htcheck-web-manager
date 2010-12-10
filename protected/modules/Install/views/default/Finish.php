<?php $this->pageTitle = Yii::app()->name.' - Congratulation, you made it!';?>
<h1>Congratulation, you made it!</h1>
<p class="emphasize">htCheck has been installed. It is important that you rename or remove <?php echo Yii::getPathOfAlias('application.modules.Install');?> folder to avoid other to run the installation again and delete your database.</p>
<div class="form">
    <h3></h3>
    <div class="content">
    <fieldset>
    <div class="input">
        <label>Username</label><strong><?php if (Yii::app()->session->contains('username')) echo Yii::app()->session['username'];?></strong>
    </div>
    <div class="input">
        <label>Password</label><strong><?php if (Yii::app()->session->contains('password')) echo Yii::app()->session['password'];?></strong>
        <div class="note">Note that password carefully!</div>
    </div>
    <br />
    <font color="green"><b>Now you can start using HtCheck WebManager! Go to the index page!</b></font>
    </fieldset>
    </div>
</div>
