<?php
use yii\helpers\Html;

?>
<?php $this->beginPage()?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
		<title><?php echo Html::encode($this->title)?></title>
		<link rel="stylesheet" type="text/css" href="/style/css/reset.css">
		<link rel="stylesheet" type="text/css" href="/style/css/animate.css">
		<link rel="stylesheet" type="text/css" href="/style/css/style.css">
	</head>

<body>
<?php $this->beginBody()?>
		
<?php echo $content;?>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>