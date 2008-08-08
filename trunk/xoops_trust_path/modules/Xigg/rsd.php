<?php
require dirname(__FILE__) . '/common.php';
$api_link = XOOPS_URL . '/modules/' . $module_dirname . '/xmlrpc.php';
?>
<?php echo "<?xml version=\"1.0\" ?>\n";?>
<rsd version="1.0" xmlns="http://archipelago.phrasewise.com/rsd">
  <service>
    <engineName>Xigg powerd by Sabai PHP Framework</engineName>
    <engineLink>http://xigg.org/</engineLink>
    <homePageLink><?php echo XOOPS_URL;?></homePageLink>
    <apis>
      <api name="MetaWeblog" preferred="true" apiLink="<?php echo $api_link;?>" blogID="" />
      <api name="Blogger" preferred="false" apiLink="<?php echo $api_link;?>" blogID="" />
    </apis>
  </service>
</rsd>