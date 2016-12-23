@echo off
:: GET ADMIN RIGHTS
(NET FILE||(powershell -command Start-Process '%0' -Verb runAs -ArgumentList '%* '&EXIT /B))>NUL 2>&1
echo Hello!
pause