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
importDBFunc() {
    echo Processing $1 ...
    $MYSQLPATH -h $DBHOST -u $DBUSERNAME -p$DBPASSWORD $DBNAME < $BASEDIR/$1.sql;
    echo DONE.
}

importDBFunc structure;
importDBFunc store;
importDBFunc useraccount;
importDBFunc person;
importDBFunc role;
importDBFunc useraccountinfotype;
importDBFunc useraccountinfo;
importDBFunc systemsettings;
importDBFunc ingredientinfotype;
importDBFunc ingredient;
importDBFunc ingredientinfo;
importDBFunc materialinfotype;
importDBFunc material;
importDBFunc materialinfo;
importDBFunc productinfotype;
importDBFunc allergent;
importDBFunc servemeasurement;
importDBFunc category;
importDBFunc nutrition;
importDBFunc products;
importDBFunc productinfo;
importDBFunc productinfotype;
importDBFunc storeinfotype;
importDBFunc nutrition_material;
importDBFunc defaultSM;
importDBFunc ../newMessageTable;
importDBFunc ../rawMaterialTable;
echo done
