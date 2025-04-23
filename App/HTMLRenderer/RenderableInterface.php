<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

/**
 * Components that can produce HTML from data.
 */
interface RenderableInterface
{
    /**
     * Render HTML for this component.
     *
     * @param array $data Optional runtime data for the template
     * @return string     The rendered HTML
     */
    public function render(array $data = []): string;
}
