# Fix Tailwind CSS Installation

Follow these exact steps to fix the Tailwind CSS installation:

## Step 1: Fix Vite Config
The vite.config.js file has been updated to remove incorrect imports.

## Step 2: Install Dependencies
Run these commands in your terminal:

```bash
# Make sure you're in the project directory
cd C:\laragon\www\Marro

# Clean npm cache 
npm cache clean --force

# Install dependencies properly
npm install -D tailwindcss postcss autoprefixer alpinejs
```

## Step 3: Verify Configuration Files
The following files have been updated/fixed:
- vite.config.js - Removed incorrect Tailwind import
- tailwind.config.js - Updated content paths
- postcss.config.js - Verified correct configuration

## Step 4: Rebuild Assets
```bash
# Run the dev command to rebuild assets
npm run dev
```

## Troubleshooting
If you still encounter issues:

1. Delete node_modules folder:
```bash
rm -rf node_modules
```

2. Delete package-lock.json:
```bash
rm package-lock.json
```

3. Reinstall all dependencies:
```bash
npm install
```

4. Rebuild:
```bash
npm run dev
```

5. Clear Laravel cache:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```
