<?php
  use \app\Core\Form\Form;

  /* 
   * @var $model \app\models\User
   */
?>

<h1>Create an account</h1>
<?php $form = Form::begin("", "post");?>
  <div class="row">
    <div class="col">
      <?php echo $form->field($model, 'firstName');?>
    </div>
    <div class="col">
      <?php echo $form->field($model, 'lastName');?>
    </div>
  </div>
  <?php echo $form->field($model, 'email')->fieldEmail();?>
  <?php echo $form->field($model, 'password')->fieldPassword();?>
  <?php echo $form->field($model, 'confirmPassword')->fieldPassword();?>
  <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end();?>