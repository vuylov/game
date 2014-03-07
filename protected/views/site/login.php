<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Авторизация';
$this->breadcrumbs=array(
	'Авторизация',
);
?>
<div class="form-authorize">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	
        <div class="row auth-header">
            Авторизация
        </div>
        <div>
            <?php //echo $form->errorSummary($model); ?>
        </div>
	<div class="row">
		<?php //echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email', array('placeholder' => 'Почтовый адрес')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('placeholder' => 'Пароль')); ?>
                <?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row auth-buttons">
		<?php echo CHtml::submitButton('Войти'); ?>
	</div>
        
    
<?php $this->endWidget(); ?>
</div><!-- form -->