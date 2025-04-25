@echo off
echo Reinstalling npm dependencies...
cd /d %~dp0
del /q package-lock.json
rmdir /s /q node_modules
npm install
echo Dependencies reinstalled successfully!
echo Now run: npm run dev
pause
