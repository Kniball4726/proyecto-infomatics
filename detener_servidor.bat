@echo off
echo ==============================================
echo   Deteniendo servidor InfoMatics (Puerto 3000)
echo ==============================================
echo.

:: Cerrar procesos escuchando en el puerto 3000
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :3000 ^| findstr LISTENING') do (
    taskkill /F /PID %%a >nul 2>&1
)

:: Detener cualquier instancia de php.exe
taskkill /F /IM php.exe >nul 2>&1

echo [OK] El servidor ha sido detenido correctamente.
timeout /t 2 >nul
