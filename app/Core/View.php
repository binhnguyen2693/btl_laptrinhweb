<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    public function render(string $template, array $data = [], ?string $layout = null): void
    {
        $viewFile = $this->path($template);
        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        if ($layout === null) {
            echo $content;
            return;
        }

        require $this->path($layout);
    }

    private function path(string $name): string
    {
        $path = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $name) . '.php';
        if (!is_file($path)) {
            throw new RuntimeException('View not found: ' . $name);
        }
        return $path;
    }
}
