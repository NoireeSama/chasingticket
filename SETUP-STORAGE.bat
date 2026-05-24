@echo off
REM =====================================================
REM   AmikomHub Event Poster - Storage Setup Script
REM =====================================================
REM   This script creates the symlink needed for uploaded
REM   event posters to display on your website.
REM
REM   IMPORTANT: Run this as Administrator!
REM =====================================================

setlocal enabledelayedexpansion

echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║    AmikomHub - Event Poster Storage Setup                     ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

cd /d "%~dp0"

if "%cd%"=="" (
    echo ERROR: Could not get directory
    pause
    exit /b 1
)

set "LINK=%cd%\public\storage"
set "TARGET=%cd%\storage\app\public"

echo Project Path: %cd%
echo.
echo Creating symlink:
echo   From: %LINK%
echo   To:   %TARGET%
echo.

REM Check if running as admin
openfiles >nul 2>&1
if errorlevel 1 (
    echo ⚠️  WARNING: Not running as Administrator!
    echo.
    echo This script needs Administrator privileges to create symlinks.
    echo Please right-click this batch file and select "Run as administrator".
    echo.
    pause
    exit /b 1
)

REM Check if target exists
if not exist "%TARGET%" (
    echo ❌ ERROR: Target directory does not exist!
    echo Location: %TARGET%
    pause
    exit /b 1
)

echo ✓ Target directory found
echo.

REM Remove existing if present
if exist "%LINK%" (
    echo Removing existing directory/link...
    rmdir "%LINK%" 2>nul
    if exist "%LINK%" (
        echo Could not remove existing link. It might be in use.
        pause
        exit /b 1
    )
)

REM Create the symlink
echo Creating symlink...
mklink /D "%LINK%" "%TARGET%"

if errorlevel 1 (
    echo.
    echo ❌ ERROR: Failed to create symlink!
    echo.
    echo Please try these solutions:
    echo 1. Make sure you're running as Administrator
    echo 2. Close any file explorer windows showing these directories
    echo 3. Restart your computer
    echo.
    pause
    exit /b 1
)

REM Verify
echo.
if exist "%LINK%" (
    echo ╔════════════════════════════════════════════════════════════════╗
    echo ║                  ✅ SUCCESS!                                  ║
    echo ╚════════════════════════════════════════════════════════════════╝
    echo.
    echo Your storage symlink has been created!
    echo.
    echo Next steps:
    echo   1. Open Admin Dashboard
    echo   2. Go to "Kelola Event"
    echo   3. Click "+ Tambah Event Baru"
    echo   4. Upload an event poster image
    echo   5. Save the event
    echo.
    echo The image should now appear on:
    echo   - Admin dashboard (thumbnail)
    echo   - Homepage (event grid)
    echo   - Event detail page (full size)
    echo.
) else (
    echo ❌ Symlink not found after creation
    pause
    exit /b 1
)

pause
