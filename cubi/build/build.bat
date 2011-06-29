@echo on

rem *********************************************************************
rem cubi builder script. Usage: build app_name
rem *********************************************************************

set PHING_HOME=C:\xampp\htdocs\ob3\cubi\bin\phing
set PHP_CLASSPATH=%PHING_HOME%\classes

%PHING_HOME%\bin\phing -buildfile %1.xml %2

