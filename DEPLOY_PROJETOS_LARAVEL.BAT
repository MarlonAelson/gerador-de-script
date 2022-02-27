@echo on
php artisan clear-compiled
php artisan auth:clear-resets
php artisan cache:clear
php artisan config:clear
php artisan event:clear
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
pause