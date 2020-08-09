<?php

namespace View;

class TodoView implements ViewInterface
{
    private string $template;

    public function __construct()
    {
        $this->template = dirname(dirname(__DIR__)) . '/resource/views/view.php';
    }

    public function render(array $data): string
    {
        extract($data);
        ob_start();
        require_once $this->template;
        $rendered = ob_get_contents();
        ob_end_clean();

        return $rendered;
    }
}