# PHP 8.0.30 Compatibility Fix for formatBytes() Function

## Issue
The `formatBytes()` function works on PHP 8.1.30 but shows "Call to undefined function formatBytes()" error on PHP 8.0.30.

## Root Cause
The helper function might not be properly autoloaded due to:
1. Composer autoloader not regenerated after adding helpers.php
2. PHP version differences in autoloading behavior
3. File path or permission issues

## Solutions (Apply in order)

### Solution 1: Regenerate Composer Autoloader
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Solution 2: Verify helpers.php file exists and is readable
```bash
ls -la app/helpers.php
cat app/helpers.php | head -10
```

### Solution 3: Manual inclusion (if autoloader fails)
Add to `bootstrap/app.php` before the return statement:
```php
// Load helper functions manually if needed
if (file_exists(__DIR__ . '/../app/helpers.php')) {
    require_once __DIR__ . '/../app/helpers.php';
}
```

### Solution 4: Check composer.json autoload section
Ensure this exists in composer.json:
```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    },
    "files": [
        "app/helpers.php"
    ]
}
```

### Solution 5: Service Provider approach
The HelperServiceProvider has been added to ensure functions are loaded.

### Solution 6: Blade template fallback
The show.blade.php template now includes fallback logic for compatibility.

## Test the fix
```bash
php artisan tinker
>>> formatBytes(1048576)
=> "1 MB"
```

## Emergency Fallback
If all else fails, replace the formatBytes() call in templates with:
```php
@php
$fileSize = Storage::disk('public')->size($dokumen->file);
$units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
for ($i = 0; $fileSize > 1024 && $i < count($units) - 1; $i++) {
    $fileSize /= 1024;
}
$formattedSize = round($fileSize, 2) . ' ' . $units[$i];
@endphp
{{ $formattedSize }}
```
