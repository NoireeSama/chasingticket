@echo off
REM Storage Link Creation Script for Windows
REM Run this as Administrator

setlocal enabledelayedexpansion

cd /d "%~dp0"

echo.
echo ========================================
echo   Creating Storage Symlink for Laravel
echo ========================================
echo.

set "LINK_PATH=%cd%\public\storage"
set "TARGET_PATH=%cd%\storage\app\public"

echo Link:   %LINK_PATH%
echo Target: %TARGET_PATH%
echo.

REM Check if target exists
if not exist "%TARGET_PATH%" (
    echo ERROR: Target directory does not exist!
    pause
    exit /b 1
)

REM Check if link already exists
if exist "%LINK_PATH%" (
    echo Link already exists. Attempting to remove...
    rmdir "%LINK_PATH%" 2>nul
    if exist "%LINK_PATH%" (
        echo ERROR: Could not remove existing link/directory
        pause
        exit /b 1
    )
)

REM Create symlink with mklink
echo Creating symlink...
echo.
mklink /D "%LINK_PATH%" "%TARGET_PATH%"

if errorlevel 1 (
    echo.
    echo ERROR: Failed to create symlink
    echo.
    echo Please try one of these solutions:
    echo 1. Run this script as Administrator
    echo 2. Run PHP script: php setup-storage-link.php
    echo 3. Run manual command: mklink /D "public\storage" "storage\app\public"
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================
echo   SUCCESS! Symlink created!
echo ========================================
echo.
echo You can now:
echo 1. Upload images via Admin Dashboard
echo 2. Images will appear on all pages
echo.
pause
