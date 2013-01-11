<?
/**
 * content_cache
 * 
 * @author		Chris Polewiak <chris@polewiak.pl>
 * @version		5.0.0
 * @package		sql
 * @category	content_usergroupacl
 */

/**
 * @category	content_usergroupacl
 * @package		sql
 * @version		5.0.0
*/
function content_usergroupacl_add( $content_access__id, $content_usergroup__id, $content_usergroupacl__bit ) {

	$dane["record_create_date"] = time();
	$dane["record_create_id"] = $_SESSION["content_user"]["content_user__id"];

	if ($content_access__id && $content_usergroup__id && $content_usergroupacl__bit) {
		$SQL_QUERY  = "REPLACE INTO ".DB_TABLEPREFIX."_content_usergroupacl \n";
		$SQL_QUERY .= "VALUES ( \n";
		$SQL_QUERY .= "'". sm_secure_string_sql( $content_access__id)."', \n";
		$SQL_QUERY .= "'". sm_secure_string_sql( $content_usergroup__id)."', \n";
		$SQL_QUERY .= "'". sm_secure_string_sql( $content_usergroupacl__bit)."', \n";
		$SQL_QUERY .= "'". sm_secure_string_sql( $dane["record_create_date"])."', \n";
		$SQL_QUERY .= "'". sm_secure_string_sql( $dane["record_create_id"])."'\n";
		$SQL_QUERY .= ")";

		try { $result = $GLOBALS["SM_PDO"]->query($SQL_QUERY); } catch(PDOException $e) { sqlerr("content_usergroupacl_add()",$SQL_QUERY,$e); }

 		return $content_access__id;
	}
}

/**
 * @category	content_usergroupacl
 * @package		sql
 * @version		5.0.0
*/
function content_usergroupacl_delete( $content_access__id, $content_usergroup__id ) {

	$SQL_QUERY  = "DELETE FROM ".DB_TABLEPREFIX."_content_usergroupacl \n";
	$SQL_QUERY .= "WHERE content_access__id='". sm_secure_string_sql( $content_access__id)."' \n";
	$SQL_QUERY .= "  AND content_usergroup__id='". sm_secure_string_sql( $content_usergroup__id)."'";

	try { $result = $GLOBALS["SM_PDO"]->query($SQL_QUERY); } catch(PDOException $e) { sqlerr("content_usergroupacl_delete()",$SQL_QUERY,$e); }

	return $result->rowCount();
}

/**
 * @category	content_usergroupacl
 * @package		sql
 * @version		5.0.0
*/
function content_usergroupacl_delete_content_usergroup( $content_usergroup__id ) {

	$SQL_QUERY  = "DELETE FROM ".DB_TABLEPREFIX."_content_usergroupacl \n";
	$SQL_QUERY .= "WHERE content_usergroup__id='". sm_secure_string_sql( $content_usergroup__id)."'";

	try { $result = $GLOBALS["SM_PDO"]->query($SQL_QUERY); } catch(PDOException $e) { sqlerr("content_usergroupacl_delete_content_usergroup()",$SQL_QUERY,$e); }

	return $result->rowCount();
}

/**
 * @category	content_usergroupacl
 * @package		sql
 * @version		5.0.0
*/
function content_usergroupacl_delete_content_access( $content_access__id ) {

	$SQL_QUERY  = "DELETE FROM ".DB_TABLEPREFIX."_content_usergroupacl \n";
	$SQL_QUERY .= "WHERE content_access__id='". sm_secure_string_sql( $content_access__id)."'";

	try { $result = $GLOBALS["SM_PDO"]->query($SQL_QUERY); } catch(PDOException $e) { sqlerr("content_usergroupacl_delete_content_access()",$SQL_QUERY,$e); }

	return $result->rowCount();
}

/**
 * @category	content_usergroupacl
 * @package		sql
 * @version		5.0.0
*/
function content_usergroupacl_fetch_by_usergroup( $content_usergroup__id ) {

	$SQL_QUERY  = "SELECT access.*,acl.* \n";
	$SQL_QUERY .= "FROM ".DB_TABLEPREFIX."_content_access AS access, ".DB_TABLEPREFIX."_content_usergroupacl AS acl \n";
	$SQL_QUERY .= "WHERE access.content_access__id=acl.content_access__id \n";
	if( is_array($content_usergroup__id) ) {
		$SQL_QUERY .= " AND acl.content_usergroup__id IN ('" . join("','",$content_usergroup__id) . "') \n";
	}
	else {
		$SQL_QUERY .= " AND acl.content_usergroup__id='". sm_secure_string_sql( $content_usergroup__id)."' \n";
	}

	try { $result = $GLOBALS["SM_PDO"]->query($SQL_QUERY); } catch(PDOException $e) { sqlerr("content_usergroupacl_fetch_by_usergroup()",$SQL_QUERY,$e); }

	return ($result->rowCount()>0 ? $result : 0);
}

?>