@echo off
echo ======================================================
echo RÉPARATION COMPLÈTE DU STOCKAGE ET AVATARS POUR MARRO
echo ======================================================
echo.
echo Ce script va réparer les problèmes de stockage et d'avatars.
echo Il faut l'exécuter en tant qu'administrateur.
echo.
echo Appuyez sur une touche pour continuer...
pause > nul

php storage-fix.php

echo.
echo ======================================================
echo Script terminé. Vérifiez les résultats ci-dessus.
echo ======================================================
echo.
echo Appuyez sur une touche pour quitter...
pause > nul
