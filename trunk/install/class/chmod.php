

<?php
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
/// ///
/// systeme de gestion des droits utilisateurs de fichiers ///
/// ou des repertoires sur le serveur ///
/// Les remarques sont les bienvenues ///
/// ///
/// Developpé par Alfred Timagni T. SITEWEB http://www.bbsecurit.com ///
/// copyright 2007-2008 Tchalftechnology, Inc ///
/// ///
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
/*

EXEMPLE D'UTILISATION DE CETTE CLASSE
/*
$chmod = new Chmod;
$chmod->setOwnermodes(true,true,true);
$chmod->setGroupmodes(true,true,true);
$chmod->setPublicmodes(true,true,true);
setchmod($dir);
*/
// fixe les droits de $dir à 0777


class Chmod
{
/*notre repertoire[de la forme (/NOM_DE_REPERTOIRE/) ou (/NOM_DE_REPERTOIRE/NOM_DE_FICHIER.EXT)]à chmoder.
*/
private $dir;
//initialisation des droits
private $modes = array('owner' => 0 , 'group' => 0 , 'public' => 0);
//fonction definissant les droits du proprietaire du fichier ou du repertoire
public function setOwnermodes($read,$write,$execute) {
$this->modes['owner'] = $this->setMode($read,$write,$execute);
}
//definition de droits du groupe utilisateur
public function setGroupmodes($read,$write,$execute) {
$this->modes['group'] = $this->setMode($read,$write,$execute);
}
// definition des droits des visiteurs(publique)
public function setPublicmodes($read,$write,$execute) {
$this->modes['public'] = $this->setMode($read,$write,$execute);
}
   
public function getMode() {
return 0 . $this->modes['owner'] . $this->modes['group'] . $this->modes['public'];
}
   
private function setMode($r,$w,$e) {
$mode = 0;
if($r) $mode+=4;
if($w) $mode+=2;
if($e) $mode+=1;
return $mode;
}
  
public function setChmod($target)
{
if(!is_file($target) && !is_dir($target)){
return false;
}else{
   
return chmod($target , $this->getMode());}
}
  
}
   
?>

