<h1><?= htmlspecialchars($data['form_config']['formname']) ?></h1>

<form 
    action="<?= htmlspecialchars($data['form_config']['action']) ?>" 
    method="<?= htmlspecialchars($data['form_config']['method']) ?>" 
    class="<?= htmlspecialchars($data['form_config']['classes']) ?>">

    <?php foreach ($data['form_config']['inputs'] as $input): ?>
        <div class="mb-4">
            <input 
                type="<?= htmlspecialchars($input['type']) ?>"
                name="<?= htmlspecialchars($input['name']) ?>"
                placeholder="<?= htmlspecialchars($input['placeholder']) ?>"
                id="<?= htmlspecialchars($input['id']) ?>"
                value="<?= htmlspecialchars($input['value']) ?>"
                class="<?= htmlspecialchars($input['class']) ?>"
            />
        </div>
    <?php endforeach; ?>

    <?php foreach ($data['form_config']['selects'] as $select): ?>
        <div class="mb-4">
            <select 
                name="<?= htmlspecialchars($select['name']) ?>" 
                id="<?= htmlspecialchars($select['id']) ?>"
                class="<?= htmlspecialchars($select['classes']) ?>">
                <?php foreach ($select['options'] as $option): ?>
                    <option value="<?= htmlspecialchars($option['value']) ?>">
                        <?= htmlspecialchars($option['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endforeach; ?>

    <button type="submit">
        <?= htmlspecialchars($data['form_config']['submitbutton']) ?>
    </button>
</form>
