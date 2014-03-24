<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/game.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Главная', 'url'=>array('/site/index')),
                                array('label'=>'Мои игры', 'url'=>array('/game/list'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Регистрация', 'url'=>array('/site/registration'), 'visible'=>Yii::app()->user->isGuest),
                                array('label'=>'Рекорды', 'url' => array('/site/ranking')),
				array('label'=>'Войти', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
</div><!-- mainmenu -->
<div class="container" id="page">
	
	<?php echo $content; ?>
        
	<div class="clear"></div>
        
</div><!-- page -->
<div id="footer">
    <div class="game-tester-note">
        <span class="tester-word">Уважаемые пользователи, на данный момент приложение "<?php echo Yii::app()->name; ?>" проходит 
            альфа-тестирование на работоспособность основных функций игры. Если в процессе игры обнаружили баг (нерабочую функцию или ошибку), то сделайте скриншот экрана и в подробностях опишите предыдущие действия, приведшие к этой ошибке. Информацию отправляйте по адресу <a href="mailto:vuylov@gmail.com">vuylov@gmail.com</a>. Заранее очень признательны и благодарны за участие в разработке проекта.</span>
        <p>
            В игре недоступно или будут внесены изменения:
            <ul>
                <li>Механизм "Новости - события" (функции реализованы, агрегируется банк новостей и соответствующих им событий)</li>
                <li>Руководство пользователя (в процессе написания)</li>
		<li>Отображение стартовой страницы, раздела "Мои игры" и "Рекорды" (а также некоторые другие элементы) будут дорабатываться</li>
            </ul>
        </p>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/highcharts.js"></script>
</body>
</html>
