<div class="form-authorize">
<?php
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    )); 
?>
    <div class="row auth-header">Регистрация</div>
    <?php //echo $form->errorSummary($user); ?>
        
	<div class="row">
		<?php //echo $form->labelEx($user,'name'); ?>
		<?php echo $form->textField($user,'name', array('placeholder' => 'Ваше имя')); ?>
		<?php echo $form->error($user,'name'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($user,'email'); ?>
		<?php echo $form->textField($user,'email', array('placeholder' => 'Почтовый адрес')); ?>
		<?php echo $form->error($user,'email'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($user,'password'); ?>
		<?php echo $form->passwordField($user,'password',array('size'=>60,'maxlength'=>128, 'placeholder' => 'Пароль')); ?>
		<?php echo $form->error($user,'password'); ?>
	</div>
    
	<div class="row">
		<?php //echo $form->labelEx($user,'_confirmPassword'); ?>
		<?php echo $form->passwordField($user,'_confirmPassword',array('size'=>60,'maxlength'=>128, 'placeholder' => 'Подтверждение пароля')); ?>
		<?php echo $form->error($user,'_confirmPassword'); ?>
	</div>
         <div class="row auth-buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>
<?php $this->endWidget(); ?>
</div>