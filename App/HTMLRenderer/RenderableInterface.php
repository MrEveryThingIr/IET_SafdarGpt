<?php
namespace App\HTMLRenderer;

interface RenderableInterface
{
    public function render(array $data = []): string;
}
