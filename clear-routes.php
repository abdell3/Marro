<?php

// Simple script to clear Laravel's route cache
// Run this file directly from the command line with "php clear-routes.php"

echo "Clearing Laravel route cache...\n";

// Change to the project directory if needed
chdir(__DIR__);

// Execute Artisan commands to clear various caches
system('php artisan route:clear');
system('php artisan config:clear');
system('php artisan cache:clear');
system('php artisan view:clear');

echo "Cache clearing complete!\n";
echo "Please restart your web server for the changes to take effect.\n";
