@echo off
cd /d %~dp0
del postcss.config.js
ren postcss.config.cjs postcss.config.js
echo Renamed postcss config file!
pause
