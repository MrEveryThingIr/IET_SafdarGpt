<?php
declare(strict_types=1);

/**
 * Render a visual HTML block of article content.
 */
function render_article_block(array $block): string
{
    $type = $block['block_type'] ?? '';
    $class = htmlspecialchars($block['css_class'] ?? '');
    $blockId = (int)($block['id'] ?? 0);

    $editTriggerId = "trigger_editBlockModal_{$blockId}";
    $editModalId = "editBlockModal_{$blockId}";
    $deleteUrl = route('ietarticles.block.delete', ['id' => $blockId]);

    $editDeleteButtons = <<<HTML
<div class="absolute top-0 right-0 mt-2 mr-2 flex gap-2 z-10">
    <button id="{$editTriggerId}" class="px-2 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Edit</button>
    <a href="{$deleteUrl}" class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">Delete</a>
</div>
HTML;

    $output = '';
    $content = htmlspecialchars($block['content'] ?? '');

    switch ($type) {
        case 'paragraph':
            $output = '<p class="text-base leading-relaxed my-4 ' . $class . '">' . nl2br($content) . '</p>';
            break;

        case 'heading':
            $level = max(1, min(6, (int)($block['heading_level'] ?? 2)));
            $tag = "h{$level}";
            $output = "<{$tag} class='mt-6 mb-2 font-bold text-xl {$class}'>{$content}</{$tag}>";
            break;

        case 'image':
            $url = htmlspecialchars($block['image_url'] ?? '');
            $alt = htmlspecialchars($block['image_alt'] ?? '');
            $caption = htmlspecialchars($block['image_caption'] ?? '');
            $output = <<<HTML
<div class="text-center {$class}">
    <img src="{$url}" alt="{$alt}" class="inline-block max-w-full h-auto rounded shadow" loading="lazy">
    <p class="text-sm text-gray-500 mt-1">{$caption}</p>
</div>
HTML;
            break;

        case 'video':
        case 'audio':
            $mediaTag = $type;
            $src = htmlspecialchars($block['content'] ?? '');
            $output = <<<HTML
<{$mediaTag} controls class="w-full rounded shadow {$class}">
    <source src="{$src}">
    Your browser does not support {$mediaTag} playback.
</{$mediaTag}>
HTML;
            break;

        case 'list':
            $items = array_filter(array_map('trim', explode("\n", $block['content'] ?? '')));
            $tag = $block['list_type'] === 'ordered' ? 'ol' : 'ul';
            $listItems = '';
            foreach ($items as $item) {
                $listItems .= '<li class="ml-4 list-inside">' . htmlspecialchars($item) . '</li>';
            }
            $output = "<{$tag} class='my-4 list-disc {$class}'>{$listItems}</{$tag}>";
            break;

        case 'quote':
            $output = <<<HTML
<blockquote class="border-l-4 border-blue-500 pl-4 italic text-gray-700 my-4 {$class}">
    {$content}
</blockquote>
HTML;
            break;

        case 'divider':
            $output = '<hr class="my-6 border-gray-300 ' . $class . '">';
            break;

        case 'embed':
            $embed = $block['content'] ?? '';
            $output = <<<HTML
<div class="my-4 embed-container {$class}">
    {$embed}
</div>
HTML;
            break;

        case 'cta':
            $buttonText = $content ?: 'Click here';
            $data = json_decode($block['additional_data'] ?? '{}', true);
            $link = htmlspecialchars($data['link_url'] ?? '#');
            $output = <<<HTML
<div class="text-center {$class}">
    <a href="{$link}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
        {$buttonText}
    </a>
</div>
HTML;
            break;

        case 'faq':
            $question = $content;
            $data = json_decode($block['additional_data'] ?? '{}', true);
            $answer = htmlspecialchars($data['answer'] ?? '');
            $output = <<<HTML
<div class="my-4 {$class}">
    <h3 class="font-semibold text-lg text-blue-800">❓ {$question}</h3>
    <p class="text-sm text-gray-700 mt-1">{$answer}</p>
</div>
HTML;
            break;

        default:
            $output = "<p class='text-red-500'>[Unknown block type: {$type}]</p>";
    }

    return <<<HTML
<div class="relative group border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
    {$editDeleteButtons}
    {$output}
</div>
HTML;
}
