<form id="<?= htmlspecialchars($form_id ?? '') ?>"
      action="<?= htmlspecialchars($action ?? '') ?>"
      method="<?= htmlspecialchars($method ?? 'POST') ?>"
      enctype="<?= htmlspecialchars($enctype ?? '') ?>"
      class="<?= htmlspecialchars($classes ?? '') ?>">

    <?php foreach ($fields ?? [] as $field): ?>
        <div class="form-group">
            <?php if (!empty($field['label'])): ?>
                <label for="<?= htmlspecialchars($field['name']) ?>" class="block font-semibold text-gray-700 mb-1">
                    <?= htmlspecialchars($field['label']) ?>
                </label>
            <?php endif; ?>

            <input
                type="<?= htmlspecialchars($field['type'] ?? 'text') ?>"
                name="<?= htmlspecialchars($field['name']) ?>"
                id="<?= htmlspecialchars($field['name']) ?>"
                placeholder="<?= htmlspecialchars($field['placeholder'] ?? '') ?>"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                <?= !empty($field['required']) ? 'required' : '' ?>
            >
        </div>
    <?php endforeach; ?>

    <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
        ارسال فرم
    </button>
</form>
