<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<?php Yii::app()->clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/main.css' ); ?>
	<?php Yii::app()->clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/form.css' ); ?>
	
	<?php Yii::app()->clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/redmond/jquery-ui-1.8.7.custom.css', 'screen' ); ?>	
	
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.qtip-1.0.0-rc3.min.js'); ?>
	
	<?php Yii::app()->clientScript->registerCss( 'install_custom', 
			'fieldset { margin: 20px auto 20px auto; padding: 10px; }
			legend { margin: 0.2em 0px 0.2em 20px; padding: 4px; }'
	); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu" align="center">
		<?php $this->widget('zii.widgets.CMenu',array(
            'id'=>'menu',
            'items'=>array(
				array('label'=>'Welcome', 'url'=>array('/install.php')),
				array('label'=>'Pre Installations', 'url'=>array('/Install/default/Step0')),
                array('label'=>'System checks', 'url'=>array('/Install/default/Step1')),
                array('label'=>'Environment settings', 'url'=>array('/Install/default/Step2Manager')),
                array('label'=>'Crawlers DB Settings', 'url'=>array('/Install/default/Step2General')),
                array('label'=>'Database setup', 'url'=>array('/Install/default/Step3')),
                array('label'=>'Administrator account', 'url'=>array('/Install/default/Step4')),
                array('label'=>'Final step!', 'url'=>array('/Install/default/Finish')),
            ),
        )); ?>
        <script type="text/javascript">
        $(function(){
           //disable click on menu
            $('#menu a').click(function(){
                return false;
            });
        });
        </script>
	</div><!-- mainmenu -->

	<div class="container">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::link('Devise.it', 'http://www.devise.it'); ?>.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>


