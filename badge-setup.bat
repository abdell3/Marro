@echo off
echo Fixing badges for the Marro project...
echo.

cd C:\laragon\www\Marro

echo Assigning welcome badges to users...
php artisan badges:assign-welcome

echo.
echo Checking and updating badges for all users...
php artisan badges:check-all

echo.
echo Badge setup complete!
pause
