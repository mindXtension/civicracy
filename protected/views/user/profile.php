<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.profile') => array('profile'),
);
?>

<h1><?php echo Yii::t('app', 'menu.profile'); ?></h1>

<?php

echo $message;

echo $this->renderPartial('profileForm', array('model'=>$model));

?>
