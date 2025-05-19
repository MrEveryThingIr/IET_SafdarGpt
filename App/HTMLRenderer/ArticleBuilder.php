<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

use App\Models\Article;

class ArticleBuilder implements RenderableInterface
{
    private array $config;
    private ?array $articleData = null;
    private array $selectedBlocks = [];
    private array $customStyles = [];
    private bool $isDarkMode = false;

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'template' => 'templates/article_template',
            'stylesPaths' => [],
            'scriptHelpers' => [],
        ], $config);
    }

    public function loadArticle(int $id): self
    {
        $model = new Article();
        $this->articleData = $model->getFullArticle($id);
        return $this;
    }

    public function withArticleData(array $article): self
    {
        $this->articleData = $article;
        return $this;
    }

    public function createArticleForm(): string
    {
        return '<!-- article creation form would be rendered here -->';
    }

    public function withParagraphs(): self { $this->selectedBlocks[] = 'paragraph'; return $this; }
    public function withHeadings(): self { $this->selectedBlocks[] = 'heading'; return $this; }
    public function withImages(): self { $this->selectedBlocks[] = 'image'; return $this; }
    public function withLists(): self { $this->selectedBlocks[] = 'list'; return $this; }
    public function withQuotes(): self { $this->selectedBlocks[] = 'quote'; return $this; }
    public function withEmbeds(): self { $this->selectedBlocks[] = 'embed'; return $this; }
    public function withDividers(): self { $this->selectedBlocks[] = 'divider'; return $this; }
    public function withVideos(): self { $this->selectedBlocks[] = 'video'; return $this; }
    public function withAudio(): self { $this->selectedBlocks[] = 'audio'; return $this; }
    public function withFAQs(): self { $this->selectedBlocks[] = 'faq'; return $this; }
    public function withCTAs(): self { $this->selectedBlocks[] = 'cta'; return $this; }

    public function withDarkMode(bool $enabled = true): self
    {
        $this->isDarkMode = $enabled;
        return $this;
    }

    public function render(array $data = []): string
    {
        if (!$this->articleData) {
            return "<div class='text-red-600 p-4 bg-red-100 rounded-lg'>❌ Article not loaded.</div>";
        }

        if (!empty($this->selectedBlocks)) {
            $this->articleData['blocks'] = array_filter(
                $this->articleData['blocks'] ?? [],
                fn($b) => in_array($b['block_type'], $this->selectedBlocks, true)
            );
        }

        $payload = array_merge($this->config, $this->articleData, [
            'blockRenderer' => $this,
            'isDarkMode' => $this->isDarkMode,
        ]);

        return $this->renderPartial($this->config['template'], $payload);
    }

    private function renderPartial(string $view, array $viewData = []): string
    {
        $path = views_path($view . '.php');
        if (!file_exists($path)) {
            return "<div class='text-red-600 p-4 bg-red-100 rounded-lg'>❌ Article view not found: <code>{$path}</code></div>";
        }

        ob_start();
        extract($viewData);
        include $path;
        return ob_get_clean();
    }

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
            default     => "<div class='text-yellow-600 italic bg-yellow-50 p-2 rounded'>Unknown block type: {$block['block_type']}</div>"
        };
    }

    private function renderParagraph(array $block): string
    {
        $class = trim($this->getStyle('block.paragraph', $block) . ' ' . ($block['css_class'] ?? ''));
        return '<p class="' . htmlspecialchars($class) . '">' . nl2br(htmlspecialchars($block['content'])) . '</p>';
    }

    private function renderHeading(array $block): string
    {
        $level = (int)($block['heading_level'] ?? 2);
        $level = max(1, min(6, $level));
        $class = trim($this->getStyle('block.heading', $block) . ' ' . ($block['css_class'] ?? ''));

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $block['content'])));
        return "<h{$level} id=\"{$slug}\" class=\"" . htmlspecialchars($class) . "\">" .
               "<a href=\"#{$slug}\" class=\"" . htmlspecialchars($this->getStyle('anchor-link')) . "\">" . 
               htmlspecialchars($block['content']) . "</a></h{$level}>";
    }

    private function renderImage(array $block): string
    {
        $class = trim($this->getStyle('block.image', $block) . ' ' . ($block['css_class'] ?? ''));
        $img = sprintf(
            '<img src="%s" alt="%s" class="%s" loading="lazy" %s>',
            htmlspecialchars($block['image_url']),
            htmlspecialchars($block['image_alt'] ?? ''),
            htmlspecialchars($class),
            !empty($block['image_width']) ? 'width="' . (int)$block['image_width'] . '"' : ''
        );

        $figureClass = $this->getStyle('block.image.figure', $block);
        if (!empty($block['image_caption'])) {
            $caption = htmlspecialchars($block['image_caption']);
            return "<figure class=\"{$figureClass}\">{$img}<figcaption class=\"" . $this->getStyle('block.image.caption') . "\">{$caption}</figcaption></figure>";
        }

        return "<figure class=\"{$figureClass}\">{$img}</figure>";
    }

    private function renderList(array $block): string
    {
        $items = explode("\n", $block['content']);
        $tag = $block['list_type'] === 'ordered' ? 'ol' : 'ul';
        $class = trim($this->getStyle('block.list', $block) . ' ' . ($block['css_class'] ?? ''));
        $itemClass = $this->getStyle('block.list.item');

        $html = "<{$tag} class=\"" . htmlspecialchars($class) . "\">";
        foreach ($items as $item) {
            $html .= '<li class="' . htmlspecialchars($itemClass) . '">' . htmlspecialchars(trim($item)) . '</li>';
        }
        $html .= "</{$tag}>";
        return $html;
    }

    private function renderQuote(array $block): string
    {
        $class = trim($this->getStyle('block.quote', $block) . ' ' . ($block['css_class'] ?? ''));
        $cite = !empty($block['cite']) ? '<cite class="' . $this->getStyle('block.quote.cite') . '">— ' . htmlspecialchars($block['cite']) . '</cite>' : '';
        return '<blockquote class="' . htmlspecialchars($class) . '">' .
               '<p class="quote-content">' . htmlspecialchars($block['content']) . '</p>' .
               $cite . '</blockquote>';
    }

    private function renderEmbed(array $block): string
    {
        $class = trim($this->getStyle('block.embed', $block) . ' ' . ($block['css_class'] ?? ''));
        return '<div class="' . htmlspecialchars($class) . '">' . $block['content'] . '</div>';
    }

    private function renderDivider(array $block): string
    {
        $class = trim($this->getStyle('block.divider', $block) . ' ' . ($block['css_class'] ?? ''));
        return '<hr class="' . htmlspecialchars($class) . '">';
    }

    private function renderVideo(array $block): string
    {
        $class = trim($this->getStyle('block.video', $block) . ' ' . ($block['css_class'] ?? ''));
        $poster = !empty($block['poster_url']) ? ' poster="' . htmlspecialchars($block['poster_url']) . '"' : '';
        return '<div class="video-container">' .
               '<video controls class="' . htmlspecialchars($class) . '"' . $poster . '>' .
               '<source src="' . htmlspecialchars($block['content']) . '">' .
               'Your browser does not support the video tag.' .
               '</video></div>';
    }

    private function renderAudio(array $block): string
    {
        $class = trim($this->getStyle('block.audio', $block) . ' ' . ($block['css_class'] ?? ''));
        return '<div class="audio-container">' .
               '<audio controls class="' . htmlspecialchars($class) . '">' .
               '<source src="' . htmlspecialchars($block['content']) . '">' .
               'Your browser does not support the audio element.' .
               '</audio></div>';
    }

    private function renderCTA(array $block): string
    {
        $class = trim($this->getStyle('block.cta', $block) . ' ' . ($block['css_class'] ?? ''));
        $buttonClass = $this->getStyle('block.cta.button');

        $content = is_array($block['content']) ? $block['content'] : ['text' => $block['content']];
        $button = !empty($content['button_url']) ?
            '<a href="' . htmlspecialchars($content['button_url']) . '" class="' . htmlspecialchars($buttonClass) . '">' .
            htmlspecialchars($content['button_text'] ?? 'Learn More') . '</a>' : '';

        return '<div class="' . htmlspecialchars($class) . '">' .
               '<div class="cta-content">' . htmlspecialchars($content['text'] ?? '') . '</div>' .
               $button . '</div>';
    }

    private function renderFAQ(array $block): string
    {
        $faq = json_decode($block['additional_data'] ?? '{}', true);
        $answer = htmlspecialchars($faq['answer'] ?? '');
        $question = htmlspecialchars($block['content']);
        $class = trim($this->getStyle('block.faq', $block) . ' ' . ($block['css_class'] ?? ''));
        return <<<HTML
<div class="{$class}">
    <details class="faq-item">
        <summary class="{$this->getStyle('block.faq.question')}">
            <span class="faq-icon"></span>
            {$question}
        </summary>
        <div class="{$this->getStyle('block.faq.answer')}">{$answer}</div>
    </details>
</div>
HTML;
    }

    public function addStyle(string $target, string $tailwindClasses): self
    {
        $this->customStyles[$target] = $tailwindClasses;
        return $this;
    }

 public function withDefaultTailwindStyles(): self
    {
        $baseStyles = [
            'article.wrapper'       => 'max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12',
            'article.header'        => 'mb-12 pb-8 border-b border-gray-200',
            'title'                 => 'text-4xl font-bold leading-tight text-gray-900 tracking-tight mb-4',
            'meta'                  => 'text-sm text-gray-500 flex items-center space-x-4',
            'field'                 => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800',
            
            'block.paragraph'       => 'text-lg leading-relaxed text-gray-700 mb-6',
            'block.heading.h1'      => 'text-4xl font-bold text-gray-900 mt-12 mb-6',
            'block.heading.h2'      => 'text-3xl font-bold text-gray-900 mt-10 mb-5',
            'block.heading.h3'      => 'text-2xl font-semibold text-gray-900 mt-8 mb-4',
            'block.heading'         => 'text-xl font-semibold text-gray-800 mt-6 mb-3',
            'block.image'          => 'rounded-lg shadow-lg w-full h-auto',
            'block.image.figure'    => 'my-8',
            'block.image.caption'   => 'text-center text-sm text-gray-500 mt-2',
            'block.list'           => 'space-y-2 mb-6 pl-5',
            'block.list.item'       => 'text-gray-700',
            'block.quote'           => 'border-l-4 border-indigo-500 pl-6 py-2 my-6 italic text-gray-700',
            'block.quote.cite'      => 'not-italic text-sm text-gray-500 mt-2 block',
            'block.video'           => 'w-full aspect-video rounded-lg shadow-lg my-6',
            'block.audio'          => 'w-full my-6',
            'block.cta'             => 'bg-indigo-50 border border-indigo-100 rounded-xl p-6 my-6',
            'block.cta.button'     => 'mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700',
            'block.faq'             => 'border border-gray-200 rounded-lg p-4 my-4',
            'block.faq.question'   => 'font-medium text-gray-900 cursor-pointer',
            'block.faq.answer'      => 'mt-2 text-gray-700',
            'block.embed'          => 'aspect-w-16 aspect-h-9 my-8 rounded-lg overflow-hidden',
            'block.divider'         => 'my-8 border-t border-gray-200',
            
            'anchor-link'           => 'no-underline hover:underline text-inherit',
        ];

        if ($this->isDarkMode) {
            $baseStyles = $this->applyDarkMode($baseStyles);
        }

        $this->customStyles = array_merge($this->customStyles, $baseStyles);
        return $this;
    }
 public function withProfessionalTailwindStyles(): self
    {
        $proStyles = [
            'article.wrapper'       => 'max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 font-sans',
            'article.header'        => 'mb-14 pb-8 border-b border-gray-100',
            'title'                 => 'text-5xl font-bold leading-tight text-gray-900 tracking-tighter mb-6',
            'meta'                  => 'text-sm text-gray-500 flex items-center space-x-5',
            'field'                 => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500 to-indigo-600 text-white',
            
            'block.paragraph'       => 'text-lg leading-relaxed text-gray-700 mb-7 tracking-wide',
            'block.heading.h1'      => 'text-5xl font-bold text-gray-900 mt-16 mb-8 tracking-tight',
            'block.heading.h2'      => 'text-4xl font-bold text-gray-900 mt-14 mb-7 tracking-tight',
            'block.heading.h3'      => 'text-3xl font-semibold text-gray-900 mt-12 mb-6',
            'block.heading'         => 'text-2xl font-semibold text-gray-800 mt-10 mb-5',
            'block.image'          => 'rounded-xl shadow-xl w-full h-auto transition-all duration-300 hover:shadow-2xl',
            'block.image.figure'    => 'my-10 group',
            'block.image.caption'   => 'text-center text-sm text-gray-500 mt-3 group-hover:text-gray-700 transition-colors',
            'block.list'           => 'space-y-3 mb-8 pl-6',
            'block.list.item'       => 'text-gray-700 relative pl-3 before:absolute before:left-0 before:top-3 before:w-1.5 before:h-1.5 before:rounded-full before:bg-indigo-500',
            'block.quote'           => 'border-l-4 border-indigo-500 pl-8 py-3 my-8 italic text-gray-700 bg-gradient-to-r from-indigo-50 to-transparent',
            'block.quote.cite'      => 'not-italic text-sm text-gray-500 mt-3 block pl-4',
            'block.video'           => 'w-full aspect-video rounded-xl shadow-xl my-8 overflow-hidden',
            'block.audio'          => 'w-full my-8 rounded-lg border border-gray-200 p-3 shadow-sm',
            'block.cta'             => 'bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 rounded-2xl p-8 my-8 shadow-sm',
            'block.cta.button'     => 'mt-5 inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700',
            'block.faq'             => 'border border-gray-100 rounded-xl p-6 my-6 shadow-sm hover:shadow-md transition-shadow',
            'block.faq.question'   => 'font-semibold text-gray-900 cursor-pointer flex items-center justify-between',
            'block.faq.answer'      => 'mt-3 text-gray-700 pl-8',
            'block.embed'          => 'aspect-w-16 aspect-h-9 my-10 rounded-xl overflow-hidden shadow-lg',
            'block.divider'         => 'my-10 border-t border-gray-100 relative before:absolute before:left-1/2 before:-translate-x-1/2 before:-top-2 before:w-8 before:h-1 before:bg-indigo-500 before:rounded-full',
            
            'anchor-link'           => 'no-underline hover:text-indigo-600 transition-colors',
        ];

        if ($this->isDarkMode) {
            $proStyles = $this->applyDarkMode($proStyles);
        }

        $this->customStyles = array_merge($this->customStyles, $proStyles);
        return $this;
    }

     private function applyDarkMode(array $styles): array
    {
        $darkMap = [
            'text-gray-900' => 'text-gray-100',
            'text-gray-800' => 'text-gray-200',
            'text-gray-700' => 'text-gray-300',
            'text-gray-500' => 'text-gray-400',
            'text-gray-300' => 'text-gray-500',
            'bg-white' => 'bg-gray-900',
            'bg-gray-50' => 'bg-gray-800',
            'bg-indigo-50' => 'bg-indigo-900/20',
            'border-gray-200' => 'border-gray-700',
            'border-gray-100' => 'border-gray-800',
            'from-indigo-50' => 'from-indigo-900/20',
            'to-transparent' => 'to-gray-800',
            'border-indigo-100' => 'border-indigo-900/30',
            'hover:text-gray-700' => 'hover:text-gray-300',
            'bg-indigo-600' => 'bg-indigo-700',
            'hover:bg-indigo-700' => 'hover:bg-indigo-600',
            'from-blue-50' => 'from-blue-900/20',
        ];

        foreach ($styles as &$style) {
            foreach ($darkMap as $light => $dark) {
                $style = str_replace($light, $dark, $style);
            }
            
            // Add dark mode specific styles
            $style .= ' dark';
        }

        return $styles;
    }

    public function enableRtlIfNeeded(): self
    {
        if (($this->articleData['language_code'] ?? '') === 'fa') {
            $this->customStyles['article.wrapper'] .= ' rtl text-right';
            $this->customStyles['block.list'] = str_replace('pl-6', 'pr-6', $this->customStyles['block.list'] ?? '');
            $this->customStyles['block.quote'] = str_replace('pl-8', 'pr-8', $this->customStyles['block.quote'] ?? '');
            $this->customStyles['block.quote'] = str_replace('border-l-4', 'border-r-4', $this->customStyles['block.quote'] ?? '');
        }
        return $this;
    }

    public function getStyle(string $key, ?array $block = null): string
    {
        if (str_starts_with($key, 'block.heading') && isset($block['heading_level'])) {
            $levelKey = $key . '.h' . (int)$block['heading_level'];
            if (isset($this->customStyles[$levelKey])) {
                return $this->customStyles[$levelKey];
            }
        }
        return $this->customStyles[$key] ?? '';
    }

    
}
