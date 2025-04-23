<?php
$inputs    = $data['form_config']['input'] ?? [];
$selects   = $data['form_config']['select'] ?? [];
$textareas = $data['form_config']['textarea'] ?? [];
?>

<h1 class="text-3xl font-bold text-center mb-6">
  <?= escape($data['form_config']['formname'] ?? 'Untitled Form') ?>
</h1>

<form action="<?= escape($data['form_config']['action'] ?? '#') ?>"
      method="<?= escape($data['form_config']['method'] ?? 'post') ?>"
      class="<?= escape($data['form_config']['classes'] ?? '') ?>">

  <!-- Inputs -->
  <?php foreach ($inputs as $name => $input): ?>
    <?php
      $type = $input['type'] ?? 'text';
      $label = escape($input['label'] ?? ucfirst($name));
      $id = escape($input['id'] ?? '');
      $placeholder = escape($input['placeholder'] ?? '');
      $value = escape($input['value'] ?? '');
      $class = escape($input['class'] ?? '');
      $validation = $input['validation'] ?? '';
      $message = escape($input['message'] ?? '');

      $options = [];
      if (in_array($type, ['radio', 'checkbox']) && isset($input['options'])) {
          $labels = $input['options']['labels'] ?? [];
          $values = $input['options']['values'] ?? [];
          foreach ($labels as $optKey => $optLabel) {
              $optVal = $values[$optKey] ?? '';
              if (flattenValue($optLabel) !== '' || flattenValue($optVal) !== '') {
                  $options[] = [
                      'label' => flattenValue($optLabel),
                      'value' => flattenValue($optVal),
                  ];
              }
          }
      }
    ?>
    <div class="mb-4">
      <?php if (in_array($type, ['radio', 'checkbox']) && count($options)): ?>
        <label class="block text-gray-700 font-medium mb-1"><?= $label ?></label>
        <div class="flex gap-4">
          <?php foreach ($options as $option): ?>
            <label class="inline-flex items-center">
              <input type="<?= $type ?>"
                     name="<?= $name ?>"
                     value="<?= escape($option['value']) ?>"
                     class="<?= $class ?>"
                     <?= str_contains($validation, 'required') ? 'required' : '' ?> />
              <span class="ml-2"><?= escape($option['label']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <label class="block text-gray-700 font-medium mb-1"><?= $label ?></label>
        <input type="<?= $type ?>"
               name="<?= $name ?>"
               id="<?= $id ?>"
               placeholder="<?= $placeholder ?>"
               value="<?= $value ?>"
               class="<?= $class ?>"
               <?= str_contains($validation, 'required') ? 'required' : '' ?> />
      <?php endif; ?>
      <?php if ($message): ?>
        <p class="text-sm text-gray-500"><?= $message ?></p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <!-- Selects -->
  <?php foreach ($selects as $name => $select): ?>
    <?php
      $label = escape($select['label'] ?? ucfirst($name));
      $id = escape($select['id'] ?? '');
      $class = escape($select['class'] ?? '');
      $validation = $select['validation'] ?? '';
      $message = escape($select['message'] ?? '');

      $options = [];
      $labels = $select['options']['labels'] ?? [];
      $values = $select['options']['values'] ?? [];

      foreach ($labels as $optKey => $optLabel) {
          $optVal = $values[$optKey] ?? '';
          if (flattenValue($optLabel) !== '' || flattenValue($optVal) !== '') {
              $options[] = [
                  'label' => flattenValue($optLabel),
                  'value' => flattenValue($optVal),
              ];
          }
      }
    ?>
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-1"><?= $label ?></label>
      <select name="<?= $name ?>" id="<?= $id ?>" class="<?= $class ?>"
              <?= str_contains($validation, 'required') ? 'required' : '' ?>>
        <?php foreach ($options as $option): ?>
          <option value="<?= escape($option['value']) ?>"><?= escape($option['label']) ?></option>
        <?php endforeach; ?>
      </select>
      <?php if ($message): ?>
        <p class="text-sm text-gray-500"><?= $message ?></p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <!-- Textareas -->
  <?php foreach ($textareas as $name => $ta): ?>
    <?php
      $label = escape($ta['label'] ?? ucfirst($name));
      $id = escape($ta['id'] ?? '');
      $placeholder = escape($ta['placeholder'] ?? '');
      $class = escape($ta['class'] ?? '');
      $validation = $ta['validation'] ?? '';
      $message = escape($ta['message'] ?? '');
    ?>
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-1"><?= $label ?></label>
      <textarea name="<?= $name ?>" id="<?= $id ?>" placeholder="<?= $placeholder ?>"
                class="<?= $class ?>"
                <?= str_contains($validation, 'required') ? 'required' : '' ?>></textarea>
      <?php if ($message): ?>
        <p class="text-sm text-gray-500"><?= $message ?></p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md">
    <?= escape($data['form_config']['submitbutton'] ?? 'Submit') ?>
  </button>
</form>

<!-- Save Form -->
<form action="<?= route('developer.store_form') ?>" method="post" class="mt-6 text-center">
  <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">
    ✅ Confirm &amp; Save Form
  </button>
</form>
