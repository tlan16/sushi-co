BASEDIR=$(dirname $0)
FNAME=`date +"%d_%m_%Y"`
FPASSWORD=
DBNAME=sushico
DBHOST=localhost
DBUSERNAME=root
DBPASSWORD=root
MYSQLPATH=mysql

echo Directory: $BASEDIR
echo FileName: $FNAME
echo DatabaseName: $DBNAME

echo create database $DBNAME if not exists
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD -e "CREATE DATABASE IF NOT EXISTS $DBNAME DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;"

echo import sql files
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../structure.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../useraccount.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../person.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../role.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../userprofiletype.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../userprofile.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../person.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../systemsettings.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../ingredientinfotype.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../allergent.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../product.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../productinfo.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../productinfotype.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../category.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../material.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../nutrition.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../materialinfo.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../materialinfotype.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../materialnutrition.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../store.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../storeinfo.sql
$MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/../storeinfotype.sql
echo done
