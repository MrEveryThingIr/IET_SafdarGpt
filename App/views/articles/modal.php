<?php
declare(strict_types=1);

/**
 * Render a modal form for a given block type.
 */
function render_modal_by_type(string $blockType, int $articleId): string
{
    $title = 'Add ' . ucfirst(str_replace('_', ' ', $blockType));
    $formContent = '';
    $enctype = ''; // Set to multipart/form-data if a file is needed

    switch ($blockType) {
        case 'paragraph':
            $formContent = '
                <label for="content">Content:</label><br>
                <textarea id="content" name="content" class="w-full border rounded p-2" required></textarea>';
            break;

        case 'heading':
            $formContent = '
                <label for="content">Heading Text:</label><br>
                <input type="text" name="content" class="w-full border rounded p-2" required><br>
                <label for="heading_level">Level:</label>
                <select name="heading_level" class="w-full border rounded p-2 mt-2">
                    <option value="1">H1</option>
                    <option value="2">H2</option>
                    <option value="3">H3</option>
                    <option value="4">H4</option>
                    <option value="5">H5</option>
                    <option value="6">H6</option>
                </select>';
            break;

        case 'image':
            $enctype = 'enctype="multipart/form-data"';
            $formContent = '
                <label>Upload Image:</label><br>
                <input type="file" name="file" accept="image/*" class="mb-2"><br>
                <label>Alt Text:</label><br>
                <input type="text" name="image_alt" class="w-full border rounded p-2"><br>
                <label>Caption:</label><br>
                <input type="text" name="image_caption" class="w-full border rounded p-2">';
            break;

        case 'audio':
        case 'video':
            $enctype = 'enctype="multipart/form-data"';
            $formContent = '
                <label>Upload File:</label><br>
                <input type="file" name="file" accept="' . ($blockType === 'audio' ? 'audio/*' : 'video/*') . '" class="mb-2"><br>
                <label>Or External URL:</label><br>
                <input type="url" name="content" class="w-full border rounded p-2">';
            break;

        case 'list':
            $formContent = '
                <label>List Type:</label>
                <select name="list_type" class="w-full border rounded p-2">
                    <option value="unordered">Unordered</option>
                    <option value="ordered">Ordered</option>
                </select><br>
                <label>Items (one per line):</label><br>
                <textarea name="content" class="w-full border rounded p-2" required></textarea>';
            break;

        case 'quote':
            $formContent = '
                <label>Quote Text:</label><br>
                <textarea name="content" class="w-full border rounded p-2" required></textarea>';
            break;

        case 'divider':
            $formContent = '<p class="text-sm text-gray-500">No content needed for divider.</p>';
            break;

        case 'embed':
            $formContent = '
                <label>Embed Code or URL:</label><br>
                <textarea name="content" class="w-full border rounded p-2" required></textarea>';
            break;

        case 'cta':
            $formContent = '
                <label>Button Text:</label><br>
                <input type="text" name="content" class="w-full border rounded p-2" required><br>
                <label>Link URL:</label><br>
                <input type="url" name="additional_data[link_url]" class="w-full border rounded p-2" required>';
            break;

        case 'faq':
            $formContent = '
                <label>Question:</label><br>
                <input type="text" name="content" class="w-full border rounded p-2" required><br>
                <label>Answer:</label><br>
                <textarea name="additional_data[answer]" class="w-full border rounded p-2" required></textarea>';
            break;

        case 'section':
            $formContent = '
                <label>Heading Text:</label><br>
                <input type="text" name="additional_data[heading]" class="w-full border rounded p-2" required><br>
                <label>Heading Level:</label>
                <select name="additional_data[heading_level]" class="w-full border rounded p-2 mt-2">
                    <option value="1">H1</option>
                    <option value="2">H2</option>
                    <option value="3">H3</option>
                </select><br>
                <label>Paragraph Text:</label><br>
                <textarea name="additional_data[paragraph]" class="w-full border rounded p-2" required></textarea>';
            break;

        default:
            return ''; // Unknown block type
    }

    // Generate CSRF token and form
    $csrfField = csrf('field');
    $articleField = '<input type="hidden" name="article_id" value="' . (int)$articleId . '">';

    $formAction = route('ietarticles.block.store');

    return <<<HTML
    <div class="modal-content bg-white p-6 rounded shadow-lg relative w-full max-w-lg">
        <button type="button" class="close-button absolute top-2 right-2 text-gray-500 hover:text-black text-xl">&times;</button>
        <h2 class="text-xl mb-4">{$title}</h2>
        <form method="POST" action="{$formAction}" {$enctype}>
            {$csrfField}
            {$articleField}
            <input type="hidden" name="block_type" value="{$blockType}">
            {$formContent}
            <div class="mt-4">
                <input type="submit" value="Add {$title}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            </div>
        </form>
    </div>
HTML;
}
