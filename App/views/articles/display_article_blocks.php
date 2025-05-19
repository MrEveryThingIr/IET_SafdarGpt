<?php
declare(strict_types=1);

/**
 * Render a visual HTML block of article content.
 */
function render_article_block(array $block): string
{
    $type = $block['block_type'] ?? '';
    $class = htmlspecialchars($block['css_class'] ?? '');
    $output = '';

    switch ($type) {
        case 'paragraph':
            $output = '<p class="text-base leading-relaxed my-4 ' . $class . '">' . nl2br(htmlspecialchars($block['content'] ?? '')) . '</p>';
            break;

        case 'heading':
            $level = (int)($block['heading_level'] ?? 2);
            $level = max(1, min(6, $level));
            $tag = "h{$level}";
            $output = "<{$tag} class='mt-6 mb-2 font-bold text-xl {$class}'>" . htmlspecialchars($block['content'] ?? '') . "</{$tag}>";
            break;

        case 'image':
            $url = htmlspecialchars($block['image_url'] ?? '');
            $alt = htmlspecialchars($block['image_alt'] ?? '');
            $caption = htmlspecialchars($block['image_caption'] ?? '');
            $output = <<<HTML
<div class="my-4 text-center {$class}">
    <img src="{$url}" alt="{$alt}" class="inline-block max-w-full h-auto rounded shadow" loading="lazy">
    <p class="text-sm text-gray-500 mt-1">{$caption}</p>
</div>
HTML;
            break;

        case 'video':
        case 'audio':
            $mediaTag = $type === 'video' ? 'video' : 'audio';
            $src = htmlspecialchars($block['content'] ?? '');
            $output = <<<HTML
<div class="my-4 {$class}">
    <{$mediaTag} controls class="w-full rounded shadow">
        <source src="{$src}">
        Your browser does not support {$mediaTag} playback.
    </{$mediaTag}>
</div>
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
            $quote = htmlspecialchars($block['content'] ?? '');
            $output = <<<HTML
<blockquote class="border-l-4 border-blue-500 pl-4 italic text-gray-700 my-4 {$class}">
    {$quote}
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
            $buttonText = htmlspecialchars($block['content'] ?? 'Click here');
            $data = json_decode($block['additional_data'] ?? '{}', true);
            $link = htmlspecialchars($data['link_url'] ?? '#');
            $output = <<<HTML
<div class="my-6 text-center {$class}">
    <a href="{$link}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
        {$buttonText}
    </a>
</div>
HTML;
            break;

case 'faq':
    $question = htmlspecialchars($block['content'] ?? '');
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

    return $output;
}
