<?php 
$this->pageTitle = Yii::app()->name.' - System checks';
$next = true;
?>
<?php echo CHtml::beginForm(array('default/Step1')); ?>
<h1>Pre Configuration</h1>
<div class="form">
    
    <div class="content">
    <fieldset>
    
<h2>Requirements</h2>
<ul>
<li>Apache Web Server</li>
<li>PHP >= 5.1.0</li>
<li>Yii Framework 1.1.x (http://www.yiiframework.com/)</li>
<li>PostgreSQL 8.x/9.x or MySQL 4/5 (for the web manager interface)</li>
<li>ht://Check 2.0.1</li>
</ul>


<h2>PostgreSQL database setup</h2>

<p>Log into your PostgreSQL server (8.4/9.0) as postgres user and execute the following
SQL commands which create the '<code>htcheck_webmanager</code>' and the '<code>htcheck_webmanager</code>'
database (feel free to set a different password from <code>PASSWORD</code>):</p>

<pre>CREATE USER htcheck_webmanager WITH ENCRYPTED PASSWORD 'PASSWORD';
CREATE DATABASE htcheck_webmanager WITH OWNER htcheck_webmanager;
</pre>

<h2>MySQL database setup</h2>

<p>Log into your MySQL server as <code>root</code> user and execute the following
SQL commands which create the '<code>htcheck</code>' user and grant to him the needed privileges (feel free to set a different password from <code>PASSWORD</code>):</p>

<pre>
CREATE USER 'htcheck'@'localhost' IDENTIFIED BY 'PASSWORD';
GRANT ALL PRIVILEGES ON *.* TO 'htcheck'@'localhost' IDENTIFIED BY 'PASSWORD';</pre>


<h2>ht://Check automatic and manual scan configuration</h2>

<p>To enable ht://Check - Web Manager to check for new scans and active them you have to</p>

<ol>
<li>create a new Linux user</li>
<li>add the .my.cnf on its home folder</li>
<li>add the cronjob htcheck_cronjob to the user's crontab</li>
</ol>

<ol>
<li>create the new Linux 'htcheck' with your preferred 'PASSWORD'</li>
<li>Copy the file '.my.cnf' from ht://Check - Web Manager root directory and paste it into 'htcheck' home folder. Change the MySQL auth credentials with the username and password used in the step "MySQL database setup"</li>
<li>Copy the file "htcheck_cronjob" from ht://Check - Web Manager root directory and paste it where you want. Edit the file replacing HTCHECK_WEBMANAGER_PATH with the ht://Check - Web Manager directory path. After this add to 'htcheck' crotab with the command "crontab htcheck_cronjob"</li>
</ol>


<h2>Yii Framework local installation</h2>

<p>You can install the Yii framework locally, next to the document root directory.<br />
Download the source code and unzip it, then link yii to the latest<br />
stable release. The procedure is higlighted below:<br />

<pre>
cd ..
wget http://www.yiiframework.com/files/yii-1.1.4.tar.gz
tar xzvf yii-1.1.4.rXXXX.tar.gz
ln -s yii-1.1.4.rXXXX yii
rm yii-1.1.4.rXXXX.tar.gz</pre></p>



<h2>Directory permissions</h2>

<pre>
chmod 777 crawlers_config assets protected/runtime protected/config</pre>
    

    <br/>
    <?php echo CHtml::submitButton('Next', array('class'=>'button-2'));?>
    </fieldset>
	</div>
</div>
<?php CHtml::endForm(); ?>
