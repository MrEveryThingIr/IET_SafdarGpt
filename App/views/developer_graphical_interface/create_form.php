<?php
$form_configs=[
  'action'=>route('ietdev.create.form'),
  'class'=>'',
  'id'=>'',
  'method'=>'post',
  'inputs'=>[
    'container_class'=>'input_container',
    'fields'=>[
      'name'=>'inputtype',
      'type'=>'text',
      'class'=>''
    ]
  ]

]
?>

<form 
action="<?php echo $form_configs['action'] ?>"
 class= "<?php echo $form_configs['class'] ?>" 
 method="<?php echo $form_configs['method'] ?>" 
 id="<?php echo $form_configs['id'] ?>"  >

 <fieldset class="border border-gray-300 p-4 rounded-md">
  <legend class="font-semibold text-lg mb-2">Select Input Type</legend>
  <div class="grid grid-cols-2 gap-2">
    <label><input type="radio" name="input_type" value="text"> Text</label>
    <label><input type="radio" name="input_type" value="password"> Password</label>
    <label><input type="radio" name="input_type" value="email"> Email</label>
    <label><input type="radio" name="input_type" value="number"> Number</label>
    <label><input type="radio" name="input_type" value="tel"> Tel</label>
    <label><input type="radio" name="input_type" value="url"> URL</label>
    <label><input type="radio" name="input_type" value="date"> Date</label>
    <label><input type="radio" name="input_type" value="datetime-local"> Datetime Local</label>
    <label><input type="radio" name="input_type" value="time"> Time</label>
    <label><input type="radio" name="input_type" value="month"> Month</label>
    <label><input type="radio" name="input_type" value="week"> Week</label>
    <label><input type="radio" name="input_type" value="checkbox"> Checkbox</label>
    <label><input type="radio" name="input_type" value="radio"> Radio</label>
    <label><input type="radio" name="input_type" value="range"> Range</label>
    <label><input type="radio" name="input_type" value="color"> Color</label>
    <label><input type="radio" name="input_type" value="file"> File</label>
    <label><input type="radio" name="input_type" value="search"> Search</label>
    <label><input type="radio" name="input_type" value="hidden"> Hidden</label>
    <label><input type="radio" name="input_type" value="submit"> Submit</label>
    <label><input type="radio" name="input_type" value="reset"> Reset</label>
    <label><input type="radio" name="input_type" value="button"> Button</label>
  </div>
</fieldset>


</form>