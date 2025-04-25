@echo off
echo Compiling assets for Marro...
cd /d %~dp0
npm install
npm run build
echo Assets compiled successfully!
pause
