@ECHO OFF

SET BASEDIR=%~dp0
SET FPASSWORD=
SET DBNAME=sushico
SET DBHOST=localhost
SET DBUSERNAME=root
SET DBPASSWORD=
SET MYSQLPATH=C:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe

echo Directory: %BASEDIR%
echo DatabaseName: %DBNAME%

echo create database %DBNAME% if not exists
%MYSQLPATH% -h %DBHOST% -u %DBUSERNAME% -p%DBPASSWORD% -e "CREATE DATABASE IF NOT EXISTS %DBNAME% DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;"

echo import sql files
call:importDBFunc structure
call:importDBFunc store
call:importDBFunc useraccount
call:importDBFunc person
call:importDBFunc role
call:importDBFunc useraccountinfotype
call:importDBFunc useraccountinfo
call:importDBFunc systemsettings
call:importDBFunc ingredientinfotype
call:importDBFunc ingredient
call:importDBFunc ingredientinfo
call:importDBFunc materialinfotype
call:importDBFunc material
call:importDBFunc materialinfo
call:importDBFunc productinfotype
call:importDBFunc allergent
call:importDBFunc servemeasurement
call:importDBFunc category
call:importDBFunc nutrition
call:importDBFunc products
call:importDBFunc productinfo
call:importDBFunc productinfotype
call:importDBFunc storeinfotype
call:importDBFunc nutrition_material
call:importDBFunc [new_table]defaultnutrition
echo done
echo.&pause&goto:eof


:importDBFunc
echo Processing %~1 ...
%MYSQLPATH% --host=%DBHOST% --user=%DBUSERNAME% --password=%DBPASSWORD% %DBNAME% < %BASEDIR%/../%~1.sql
echo DONE.
goto:eof
