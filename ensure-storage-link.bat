@echo off
echo ======================================================
echo CONFIGURATION DU STOCKAGE POUR MARRO
echo ======================================================
echo.
echo Ce script va s'assurer que le stockage est correctement configuré.
echo.
echo Appuyez sur une touche pour continuer...
pause > nul

php ensure-storage-link.php

echo.
echo ======================================================
echo Script terminé. Vérifiez les résultats ci-dessus.
echo ======================================================
echo.
echo Appuyez sur une touche pour quitter...
pause > nul
