@echo off
REM CakePHP CustomerStatsCommand バッチ実行用
cd /d %~dp0..
REM PHPのパスを環境に合わせて修正してください
set PHP_PATH=C:\xampp\php\php.exe
set APP_PATH=C:\xampp\htdocs\php\sisukai\bin\cake.php

"%PHP_PATH%" "%APP_PATH%" customer_stats > "C:\xampp\htdocs\php\sisukai\logs\customer_stats.log" 2>&1
exit /b %ERRORLEVEL%
