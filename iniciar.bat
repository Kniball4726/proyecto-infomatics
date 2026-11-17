@echo off
cd /d "%~dp0"
where php >nul 2>nul
if errorlevel 1 (
    if exist "C:\php\php.exe" (
        "C:\php\php.exe" servidor.php
    ) else (
        echo No se encontro PHP en el PATH ni en C:\php\php.exe.
        pause
        exit /b 1
    )
) else (
    php servidor.php
)
pause