<?php

use CodeIgniter\View\View;

if (!function_exists('registerCustomDirectives')) {
    function registerCustomDirectives(View $view)
    {
        $view->setData([
            'directives' => [
                // Custom @foreach
                'foreach' => function ($expression) {
                    return "<?php foreach {$expression}: ?>";
                },
                // Custom @endforeach
                'endforeach' => function () {
                    return "<?php endforeach; ?>";
                }
            ]
        ]);
    }
}
