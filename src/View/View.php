<?php

namespace View;

use RuntimeException;

class View
{
    private string $template;
    private array $data;
    private string $resourcePath;

    public function __construct(string $template, array $data, string $resourcePath)
    {
        $this->template = $template;
        $this->data = $data;
        $this->resourcePath = $resourcePath;
    }

    private function validateTemplate()
    {
        if (!file_exists($this->resourcePath . '/' . $this->template)) {
            throw new RuntimeException('View template does not exists');
        }
    }

    public function render(): string
    {
        extract($this->data);
        ob_start();
        require_once $this->resourcePath . '/' . $this->template;
        $rendered = ob_get_contents();
        ob_end_clean();

        return $rendered;
    }
}
