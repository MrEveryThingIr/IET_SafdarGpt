<?php

use App\HTMLServices\FormService;

$formService = new FormService();

// Handle form preview generation from POST request (temporary, no DB yet)
$previewForm = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_preview'])) {
    $fields = [];
    foreach ($_POST['field'] as $field) {
        $fields[] = [
            'type'        => $field['type'] ?? 'text',
            'name'        => $field['name'] ?? '',
            'label'       => $field['label'] ?? '',
            'placeholder' => $field['placeholder'] ?? '',
            'required'    => isset($field['required']),
        ];
    }

    $previewForm = $formService->createDefaultForm([
        'action' => '#',
        'fields' => $fields,
    ]);
}
?>

<h2 class="text-2xl font-bold mb-4">🔧 Create New Form (Preview Only)</h2>

<form method="POST" class="space-y-4 bg-white p-6 rounded shadow-md border">
    <div id="form-fields-container" class="space-y-4">
        <!-- First default field block -->
        <div class="field-group space-y-2 border-b pb-4">
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="field[0][label]" placeholder="Label" class="form-input" required>
                <input type="text" name="field[0][name]" placeholder="Name" class="form-input" required>
                <input type="text" name="field[0][placeholder]" placeholder="Placeholder" class="form-input">
                <select name="field[0][type]" class="form-select">
                    <option value="text">Text</option>
                    <option value="email">Email</option>
                    <option value="password">Password</option>
                </select>
            </div>
            <label class="inline-flex items-center mt-2">
                <input type="checkbox" name="field[0][required]" class="form-checkbox">
                <span class="ml-2">Required</span>
            </label>
        </div>
    </div>

    <button type="button" id="add-field-btn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Add Field</button>

    <div class="mt-6">
        <button type="submit" name="form_preview" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Preview Form
        </button>
    </div>
</form>

<?php if ($previewForm): ?>
    <div class="mt-10 p-6 bg-gray-100 rounded-lg shadow-inner">
        <h3 class="text-xl font-semibold mb-4">🧪 Live Preview:</h3>
        <?= $previewForm->render() ?>
    </div>
<?php endif; ?>

<!-- Add JS logic to duplicate input group -->
<script>
    let fieldIndex = 1;
    document.getElementById('add-field-btn').addEventListener('click', () => {
        const container = document.getElementById('form-fields-container');
        const group = document.createElement('div');
        group.classList.add('field-group', 'space-y-2', 'border-b', 'pb-4', 'mt-4');

        group.innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="field[${fieldIndex}][label]" placeholder="Label" class="form-input" required>
                <input type="text" name="field[${fieldIndex}][name]" placeholder="Name" class="form-input" required>
                <input type="text" name="field[${fieldIndex}][placeholder]" placeholder="Placeholder" class="form-input">
                <select name="field[${fieldIndex}][type]" class="form-select">
                    <option value="text">Text</option>
                    <option value="email">Email</option>
                    <option value="password">Password</option>
                </select>
            </div>
            <label class="inline-flex items-center mt-2">
                <input type="checkbox" name="field[${fieldIndex}][required]" class="form-checkbox">
                <span class="ml-2">Required</span>
            </label>
        `;
        container.appendChild(group);
        fieldIndex++;
    });
</script>

<style>
    .form-input, .form-select {
        width: 100%;
        padding: 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
    }

    .form-checkbox {
        accent-color: #2563eb;
    }
</style>
