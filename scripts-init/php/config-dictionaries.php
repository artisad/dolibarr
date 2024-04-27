<?php
/*
	THIS SCRIPT DISABLE ALL THE COUNTRY-RELATED OBJECTS IN DICTIONARIES ("WHERE COLUMN_NAME IN ("fk_pays", "active");
 	AND ENABLE ONLY THOSE OF MAIN COMPANY COUNTRY
*/



require_once '../htdocs/master.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/ccountry.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';

/*
require_once DOL_DOCUMENT_ROOT.'/core/db/DoliDB.class.php';
$db = new DoliDB();
$db->connect();
*/

$sql = "SELECT table_name
FROM information_schema.columns 
WHERE table_schema = '".$dolibarr_main_db_name."'
  AND table_name LIKE '".$dolibarr_main_db_prefix."c_%'
  AND column_name IN ('fk_pays', 'active')
GROUP BY table_name
HAVING COUNT(DISTINCT column_name) = 2;";

$result = $db->query($sql);
if ($result)
{
	$num = $db->num_rows($result);
	$i = 0;
	while ($i < $num)
	{
    $obj = $db->fetch_object($result);
		$table_name = $obj->table_name;

    // ALTER table to default value for active at 0
    $sql = "ALTER TABLE ".$table_name." MODIFY COLUMN active TINYINT(1) DEFAULT 0";
    $db->query($sql);

    // Pass all active at 0
    $sql = "UPDATE $table_name SET active = 0 WHERE 1";
    $db->query($sql);

    // Pass all values of current country to active at 1
    $country_id  = $mysoc->country_id ? $mysoc->country_id : 1;
    $sql = "UPDATE $table_name SET active = 1 WHERE fk_pays = ".$mysoc->country_id;
    $db->query($sql);
		$i++;
	}
}

$db->commit();


?>



    
