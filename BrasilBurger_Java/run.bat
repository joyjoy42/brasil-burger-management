@echo off
echo ========================================
echo Brasil Burger - Application Java
echo ========================================
echo.

REM Vérifier si Maven est installé
where mvn >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo [OK] Maven detecte
    echo.
    echo Compilation du projet...
    call mvn clean compile
    if %ERRORLEVEL% NEQ 0 (
        echo [ERREUR] La compilation a echoue
        pause
        exit /b 1
    )
    echo.
    echo Execution de l'application...
    call mvn exec:java
) else (
    echo [ATTENTION] Maven n'est pas installe
    echo.
    echo Options:
    echo 1. Installer Maven: choco install maven
    echo 2. Utiliser un IDE (IntelliJ, Eclipse, VS Code)
    echo 3. Voir TEST_GUIDE.md pour plus d'options
    echo.
    pause
)

