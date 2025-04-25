<?php

/**
 * Custom helper for Vite to avoid errors when running without building assets
 */
if (!function_exists('vite_assets')) {
    function vite_assets(): string
    {
        $devServerIsRunning = false;
        
        if ($devServerIsRunning) {
            return <<<HTML
            <script type="module" src="http://localhost:5173/@vite/client"></script>
            <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
            HTML;
           
        }
        
        // Fallback to basic CSS and JS if Vite is not running or build is not available
        return <<<HTML
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        HTML;
    }
}
