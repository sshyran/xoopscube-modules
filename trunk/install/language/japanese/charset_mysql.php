<?php
/**
 *
 * @package Legacy
 * @version $Id: charset_mysql.php,v 1.2 2007/06/24 07:26:22 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
    $this->db->queryF("/*!40101 SET NAMES ujis */");
    $this->db->queryF("/*!40101 SET SESSION character_set_database=ujis */");
    $this->db->queryF("/*!40101 SET SESSION character_set_server=ujis */");
    $this->db->queryF("/*!40101 SET SESSION collation_connection=ujis_japanese_ci */");
    $this->db->queryF("/*!40101 SET SESSION collation_database=ujis_japanese_ci */");
    $this->db->queryF("/*!40101 SET SESSION collation_server=ujis_japanese_ci */");
?>
