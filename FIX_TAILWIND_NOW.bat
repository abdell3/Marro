@echo off
echo Fixing Tailwind CSS installation...

echo 1. Deleting node_modules folder...
rd /s /q node_modules

echo 2. Deleting package-lock.json...
del /f package-lock.json

echo 3. Installing tailwindcss with exact path...
npm install --save-dev tailwindcss@latest postcss@latest autoprefixer@latest

echo 4. Creating new tailwind.config.js...
npx tailwindcss init -p --force

echo 5. Rebuilding project...
npm run dev

echo Installation completed! If you still have issues, try running:
echo php artisan cache:clear
echo php artisan view:clear
