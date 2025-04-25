@echo off
echo Ajout des colonnes media_path et media_type a la table posts...
php add-media-columns.php
echo.
echo Si le script PHP a echoue, vous pouvez executer le fichier SQL 'add_media_columns.sql' via phpMyAdmin.
echo.
pause
