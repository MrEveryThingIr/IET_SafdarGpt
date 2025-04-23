   <!-- Text Input -->
    <?php
    $label_class="block text-sm font-medium text-gray-700 mb-1";
    $label="label";
    $requiredFieldClass='text-red-500';
    $input_type='text';
    $input_name='input_name';
    $input_class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500";
    $required=1==1;
    ?>
   <div>
        <label class="<?php echo $label_class ?>">
          <?php echo $label ?> <span class="<?php echo $requiredFieldClass ?>">*</span>
        </label>
        <input type="<?php echo $requiredFieldClass ?>" name="<?php echo $input_name ?>" 
               class="<?php echo $input_lass ?>" />
      </div>