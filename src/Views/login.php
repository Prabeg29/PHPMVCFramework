<?php
  use \app\Core\Form\Form;

  /*
   * @var $model \app\models\LoginForm
   */
  /*
   * @var $this app\Core|View
   */
    $this->title = 'Login';
?>

<h1>Login</h1>
<?php $form = Form::begin("", "post");?>
  <?php echo $form->field($model, 'email')->fieldEmail();?>
  <?php echo $form->field($model, 'password')->fieldPassword();?>
  <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end();?>