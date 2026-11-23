<?php
namespace App\Views;

class View {
    public static function render(string $view, array $data = []): void {
        extract($data);
        $file = __DIR__ . '/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            throw new \RuntimeException("Vista no encontrada: $view ($file)");
        }
    }
}
