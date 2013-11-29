<h1>Зарегистрироваться</h1>
<div class="form">
<?php
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    )); 
?>
    <?php echo $form->errorSummary($user); ?>

	<div class="row">
		<?php echo $form->labelEx($user,'name'); ?>
		<?php echo $form->textField($user,'name'); ?>
		<?php echo $form->error($user,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'email'); ?>
		<?php echo $form->textField($user,'email'); ?>
		<?php echo $form->error($user,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'password'); ?>
		<?php echo $form->passwordField($user,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($user,'password'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($user,'_confirmPassword'); ?>
		<?php echo $form->passwordField($user,'_confirmPassword',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($user,'_confirmPassword'); ?>
	</div>
         <div class="row buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>
<?php $this->endWidget(); ?>
</div>   
  
