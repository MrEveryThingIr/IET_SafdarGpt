<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

use App\Models\Article;
use App\Models\ArticleBlock;


class ArticleBuilder implements RenderableInterface
{
    private array $config;
    private ?array $articleData = null;
    private array $selectedBlocks = [];

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'template' => 'templates/article_template',
            'stylesPaths' => [],
            'scriptHelpers' => [],
        ], $config);
    }

    /** Load article and its blocks */
    public function loadArticle(int $id): self
    {
        $model = new Article();
        $this->articleData = $model->getFullArticle($id);
        return $this;
    }

    /** Optional method to render a form for creating a new article */
    public function createArticleForm(): string
    {
        return '<!-- article creation form would be rendered here -->';
    }

    /** Selectively add block types */
    public function withParagraphs(): self
    {
        $this->selectedBlocks[] = 'paragraph';
        return $this;
    }

    public function withHeadings(): self
    {
        $this->selectedBlocks[] = 'heading';
        return $this;
    }

    public function withImages(): self
    {
        $this->selectedBlocks[] = 'image';
        return $this;
    }

    public function withLists(): self
    {
        $this->selectedBlocks[] = 'list';
        return $this;
    }

    public function withQuotes(): self
    {
        $this->selectedBlocks[] = 'quote';
        return $this;
    }

    public function withEmbeds(): self
    {
        $this->selectedBlocks[] = 'embed';
        return $this;
    }

    public function withDividers(): self
    {
        $this->selectedBlocks[] = 'divider';
        return $this;
    }

    public function withVideos(): self
    {
        $this->selectedBlocks[] = 'video';
        return $this;
    }

    public function withAudio(): self
    {
        $this->selectedBlocks[] = 'audio';
        return $this;
    }

    public function withFAQs(): self
    {
        $this->selectedBlocks[] = 'faq';
        return $this;
    }

    public function withCTAs(): self
    {
        $this->selectedBlocks[] = 'cta';
        return $this;
    }

    public function withArticleData(array $article): self
    {
        $this->articleData = $article;
        return $this;
    }

    public function render(array $data = []): string
    {
        if (!$this->articleData) {
            return "<div class='text-red-600 p-4 bg-red-100'>❌ Article not loaded.</div>";
        }

        // Filter selected blocks
        $this->articleData['blocks'] = array_filter(
            $this->articleData['blocks'] ?? [],
            fn($b) => in_array($b['block_type'], $this->selectedBlocks, true)
        );

        $payload = array_merge($this->config, $this->articleData);
        $payload['blockRenderer'] = $this;

        return $this->renderPartial($this->config['template'], $payload);
    }

    private function renderPartial(string $view, array $viewData = []): string
    {
        $path = views_path($view . '.php');
        if (!file_exists($path)) {
            return "<div class='text-red-600 p-4 bg-red-100'>❌ Article view not found: <code>{$path}</code></div>";
        }

        ob_start();
        extract($viewData);
        include $path;
        return ob_get_clean();
    }

    /** Generic method to render a block */
    public function renderBlock(array $block): string
    {
        return match ($block['block_type']) {
            'paragraph' => $this->renderParagraph($block),
            'heading'   => $this->renderHeading($block),
            'image'     => $this->renderImage($block),
            'list'      => $this->renderList($block),
            'quote'     => $this->renderQuote($block),
            'embed'     => $this->renderEmbed($block),
            'divider'   => $this->renderDivider($block),
            'video'     => $this->renderVideo($block),
            'audio'     => $this->renderAudio($block),
            'faq'       => $this->renderFAQ($block),
            'cta'       => $this->renderCTA($block),
            default     => "<div class='text-yellow-600 italic'>Unknown block type: {$block['block_type']}</div>"
        };
    }

    /** Block renderers */
    private function renderParagraph(array $block): string
    {
        return '<p>' . nl2br(htmlspecialchars($block['content'])) . '</p>';
    }

    private function renderHeading(array $block): string
    {
        $level = (int)($block['heading_level'] ?? 2);
        $level = ($level >= 1 && $level <= 6) ? $level : 2;
        return "<h{$level}>" . htmlspecialchars($block['content']) . "</h{$level}>";
    }

    private function renderImage(array $block): string
    {
        $img = sprintf(
            '<img src="%s" alt="%s" class="w-full h-auto rounded">',
            htmlspecialchars($block['image_url']),
            htmlspecialchars($block['image_alt'] ?? '')
        );

        if (!empty($block['image_caption'])) {
            $caption = htmlspecialchars($block['image_caption']);
            return "<figure>{$img}<figcaption class='text-sm text-gray-500 mt-1'>{$caption}</figcaption></figure>";
        }

        return "<figure>{$img}</figure>";
    }

    private function renderList(array $block): string
    {
        $items = explode("\n", $block['content']);
        $tag = $block['list_type'] === 'ordered' ? 'ol' : 'ul';
        $html = "<{$tag} class='pl-6 " . ($tag === 'ol' ? 'list-decimal' : 'list-disc') . "'>";
        foreach ($items as $item) {
            $html .= '<li>' . htmlspecialchars(trim($item)) . '</li>';
        }
        $html .= "</{$tag}>";
        return $html;
    }

    private function renderQuote(array $block): string
    {
        return '<blockquote class="border-l-4 pl-4 italic text-gray-600">' .
            htmlspecialchars($block['content']) .
            '</blockquote>';
    }

    private function renderEmbed(array $block): string
    {
        return '<div class="aspect-w-16 aspect-h-9">' . $block['content'] . '</div>';
    }

    private function renderDivider(array $block): string
    {
        return '<hr class="my-4 border-t border-gray-300">';
    }

    private function renderVideo(array $block): string
    {
        return '<video controls class="w-full rounded"><source src="' .
            htmlspecialchars($block['content']) .
            '">Your browser does not support the video tag.</video>';
    }

    private function renderAudio(array $block): string
    {
        return '<audio controls class="w-full"><source src="' .
            htmlspecialchars($block['content']) .
            '">Your browser does not support the audio element.</audio>';
    }

    private function renderCTA(array $block): string
    {
        return '<div class="p-4 bg-blue-50 border border-blue-200 rounded">' .
            $block['content'] .
            '</div>';
    }

    private function renderFAQ(array $block): string
    {
        $faq = json_decode($block['additional_data'] ?? '{}', true);
        $answer = htmlspecialchars($faq['answer'] ?? '');
        $question = htmlspecialchars($block['content']);
        return <<<HTML
<details class="border rounded p-2">
    <summary class="font-semibold">{$question}</summary>
    <div class="mt-2 text-sm text-gray-700">{$answer}</div>
</details>
HTML;
    }
}
