<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH.'/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH.'/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_stores extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('store_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('store_name',XOBJ_DTYPE_TXTBOX,null,false);
	}
}


class MyshopMyshop_storesHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//							Table				Classe		 	Id			Libellé
		parent::__construct($db, 'myshop_stores', 'myshop_stores', 'store_id', 'store_name');
	}

	/**
	 * Renvoie la liste de tous les vendeurs du module
	 *
	 * @param integer $start Position de départ
	 * @param integer $limit Nombre total d'enregistrements à renvoyer
	 * @param string $order Champ sur lequel faire le tri
	 * @param string $order Ordre du tri
	 * @param boolean $idaskey Indique si le tableau renvoyé doit avoir pour clé l'identifiant unique de l'enregistrement
	 * @return array tableau d'objets de type stores
	 */
	function getAllStores($start = 0, $limit = 0, $sort = 'store_name', $order='ASC', $idaskey = true)
	{
		$critere = new Criteria('store_id', 0 ,'<>');
		$critere->setLimit($limit);
		$critere->setStart($start);
		$critere->setSort($sort);
		$critere->setOrder($order);
		$tbl_categs = array();
		$tbl_categs = $this->getObjects($critere, $idaskey);
		return $tbl_categs;
	}

	/**
	 * Retourne le nombre de produits associés à un vendeur
	 *
	 * @param integer	$store_id	L'ID du vendeur
	 * @return integer	Le nombre de produits du vendeur
	 */
	function getStoreProductsCount($store_id)
	{
		global $h_myshop_products;
		return $h_myshop_products->getStoreProductsCount($store_id);
	}

	/**
	 * Supprime un vendeur
	 *
	 * @param myshop_stores $store
	 * @return boolean	Le résultat de la suppression
	 */
	function deleteStore(myshop_stores $store)
	{
		return $this->delete($store, true);
	}

	/**
	 * Retourne des vendeurs selon leur ID
	 *
	 * @param array $ids	Les ID des vendeurs à retrouver
	 * @return array	Objets de type myshop_stores
	 */
	function getStoresFromIds($ids)
	{
		$ret = array();
		if(is_array($ids) && count($ids) > 0) {
			$criteria = new Criteria('store_id', '('.implode(',', $ids).')', 'IN');
			$ret = $this->getObjects($criteria, true, true, '*', false);
		}
		return $ret;
	}

}
?>