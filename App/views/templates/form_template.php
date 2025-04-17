<h1><?php echo $data['form_config']['formname'] ?></h1>

<form 
action=<?php echo $data['form_config']['action'].' ' ?>
method=<?php echo $data['form_config']['method'].' ' ?>
class=<?php  echo $data['form_config']['classes'].' '?>>



<button type="submit"><?php echo $data['form_config']['submitbutton']?></button>
</form>

