<?php
class Xsns_Category_View extends Xsns_Admin_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	xoops_cp_header();
	
	// 中カテゴリ
	$category_p = $this->context->getAttribute('category_p');
	$category = $this->context->getAttribute('category');
	$row_count = 0;
        
	include $mytrustdirpath.'/mymenu.php';
	
	echo "<h3>"._AM_XSNS_TITLE_CATEGORY_CONFIG."</h3>";
	echo"<hr /><br />";
	

	echo "<h4>"._AM_XSNS_CATEGORY1._AM_XSNS_CATEGORY_LIST."</h4>";
	
	echo "<table class='outer'>";
	
	echo "<th colspan='4'>"._AM_XSNS_CATEGORY1."</th>";
	
	echo "<tr>".
			"<td class='head'>"._AM_XSNS_CATEGORY_NAME."</td>".
			"<td class='head'>"._AM_XSNS_CATEGORY_ORDER."</td>".
			"<td class='head'>"._AM_XSNS_CATEGORY_OPERATION."</td>".
			"<td class='head'>"._AM_XSNS_CATEGORY2."</td>".
		 "</tr>";
		 
	foreach($category_p as $cat_p){
		$pid = $cat_p['c_commu_category_parent_id'];
 		
		$color1 = "odd";
		$color2 = "even";
		$row_color = ($row_count % 2) ? $color1 : $color2;
		$cc = $row_color;

		echo "<form action='index.php' method='post'>";
		echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_edit_exec'>";
		echo "<input type='hidden' name='mode' value='parent'>";
		echo "<input type='hidden' name='pid' value='".$pid."'>";
		
		echo "<tr class='".$cc."'>".
				"<td><input type='text' name='title".$pid."' size='30' value='".$cat_p['name']."'></td>".
				"<td><input type='text' name='order".$pid."' size='10' value='".$cat_p['sort_order']."'></td>".

				"<td align='center'><input type='image' name='edit' src='".XOOPS_URL."/images/icons/page_edit.png' value='"._AM_XSNS_CATEGORY_EDIT."' style='border:none' /> ".
				"<input type='image' name='delete' src='".XOOPS_URL."/images/icons/delete.png' value='"._AM_XSNS_CATEGORY_DEL."' onclick=\"javascript:return confirm('"._AM_XSNS_CATEGORY_DEL_CONFIRM."');\" style='border:none' /></td>".

								"<td align='center'><a href='index.php?".XSNS_ACTION_ARG."=category#".$pid."'><img src='".XOOPS_URL."/images/icons/view.png' alt='"._AM_XSNS_CATEGORY_LIST."' /</a></td>".

			 "</tr>";
		echo "</form>";
			$row_count++;
	
}
	
	echo "<form action='index.php' method='post'>";
	echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_add_exec'>";
	echo "<input type='hidden' name='mode' value='parent'>";
	
	echo "<tr>".
			"<td class='head'><input type='text' size='30' name='title'></td>".
			"<td colspan='3' class='head'><input type='text' name='order' size='10' value='0'></td>".
			"</tr><tr>".
			"<td colspan='4' class='foot'><input type='submit' name='add' value='"._AM_XSNS_CATEGORY_ADD."'></td>".
		 "</tr>";
	echo "</form>";
	
	echo "</table>";
	
	echo "<br />";
	
	
	// 小カテゴリ
	echo "<h4>"._AM_XSNS_CATEGORY2._AM_XSNS_CATEGORY_LIST."</h4>";
	
	$token_handler =& new XoopsMultiTokenHandler();
	$token_add =& $token_handler->create('CATEGORY_ADD');
	$token_edit =& $token_handler->create('CATEGORY_EDIT');
	
	foreach($category_p as $cat_p){
		$pid = $cat_p['c_commu_category_parent_id'];
		
		echo "<hr /><br>".
			 "<table class='outer'>";
		
		echo "<tr>".
			 "<th colspan='4'><a name='".$pid."'>".$cat_p['name']."</a></th>".
			 "</tr>";
			 
		echo "<tr>".
				"<td class='head'>"._AM_XSNS_CATEGORY_NAME."</td>".
				"<td class='head'>"._AM_XSNS_CATEGORY_ORDER."</td>".
				"<td colspan='2' class='head'>"._AM_XSNS_CATEGORY_OPERATION."</td>".
			 "</tr>";
		
		if(isset($category[$pid])){
			foreach($category[$pid] as $cat){
				$id = $cat['c_commu_category_id'];
				
				echo "<form action='index.php' method='post'>";
				echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_edit_exec'>";
				echo "<input type='hidden' name='id' value='".$id."'>";
				echo $token_edit->getHtml();
				echo "<tr class='even'>".
						"<td><input type='text' name='title".$id."' size='30' value='".$cat['name']."'></td>".
						"<td><input type='text' name='order".$id."' size='10' value='".$cat['sort_order']."'></td>".
						"<td><input type='submit' name='edit' value='"._AM_XSNS_CATEGORY_EDIT."'></td>".
						"<td><input type='submit' name='delete' value='"._AM_XSNS_CATEGORY_DEL."'></td>".
					 "</tr>";
				echo "</form>";

			}
		}
		
		echo "<form action='index.php' method='post'>";
		echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_add_exec'>";
		echo "<input type='hidden' name='pid' value='".$pid."'>";
		echo $token_add->getHtml();
		echo "<tr>".
				"<td class='head'><input type='text' size='30' name='title'></td>".
				"<td colspan='3' class='head'><input type='text' name='order' size='10' value='0'></td>".
			"</tr><tr>".	
				"<td colspan='4' class='foot'><input type='submit' name='add' value='"._AM_XSNS_CATEGORY_ADD."'></td>".
			 "</tr>";
		echo "</table>";
		echo "</form>";
		
		echo "<br />";
	}
	
	xoops_cp_footer();
}

}
?>
