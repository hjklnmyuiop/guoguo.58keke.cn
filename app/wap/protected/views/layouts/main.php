<?php
use yii\helpers\Html;

?>
<?php $this->beginPage()?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo Html::encode($this->title)?></title>
	<link rel="stylesheet" type="text/css" href="/style/css/ui.css">
	<link href="favicon.ico" type="image/x-icon" rel="icon">
	<link href="iTunesArtwork@2x.png" sizes="114x114" rel="apple-touch-icon-precomposed">
</head>
<body>
<?php $this->beginBody()?>
		
<?php echo $content;?>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>