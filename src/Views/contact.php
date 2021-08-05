<?php
  /* *
  * @var $this app\Core|View
  */
  $this->title = 'Contact';
  use \app\Core\Form\Form;
  use app\Core\Form\TextAreaField;

  /*
   * @var $model \app\models\ContactForm
   */
?>

<h1>Contact</h1>
<?php $form = Form::begin("", "post");?>
  <?php echo $form->field($model, 'subject');?>
  <?php echo $form->field($model, 'email')->fieldEmail();?>
  <?php echo new TextAreaField($model, 'body');?>
  <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end();?>