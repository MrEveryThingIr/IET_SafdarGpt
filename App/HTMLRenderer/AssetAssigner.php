<?php

namespace App\Assets;

class AssetAssigner
{
    protected string $componentName;
    protected array $config;
    protected array $dependencies = [];
    
    public function __construct(string $componentName, array $config = [])
    {
        $this->componentName = $componentName;
        $this->loadComponentConfig();
        $this->mergeConfig($config);
    }
    
    protected function loadComponentConfig(): void
    {
        $configPath = base_path("{$this->componentName}.json");
        $this->config = json_file_read($configPath) ?? [];
    }
    
    protected function mergeConfig(array $config): void
    {
        $this->config = array_merge($this->config, $config);
    }
    
    public function addDependency(string $type, string $path): self
    {
        $this->dependencies[$type][] = $path;
        return $this;
    }
    
    public function getDependencies(): array
    {
        return $this->dependencies;
    }
    
    public function getConfig(): array
    {
        return $this->config;
    }
    
    public function generateHtmlAttributes(): string
    {
        $attrs = $this->config['html_attributes'] ?? [];
        return implode(' ', array_map(
            fn($k, $v) => "{$k}=\"{$v}\"",
            array_keys($attrs),
            $attrs
        ));
    }
    
    public function register(): void
    {
        $manifest = json_file_read(asset_manifest_path());
        $manifest[$this->componentName] = $this->config;
        json_file_write(asset_manifest_path(), $manifest);
    }
}