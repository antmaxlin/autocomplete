<?php
	include ('./includes/initiate.php');
	include ('./includes/functions.php');
	if (isset($_POST['st']) && ($_POST['st'] !='')){  //Retrieve the search term
		$st=$_POST['st']; $aws_s3 = 'http://s3.amazonaws.com/weflect-objects/'; $last_cat=''; $y=1;
		$div=$_POST['div'];
		if (is_numeric($_SESSION['portal_id'])) {
			$portal=" AND ("; $x=1;
			$cat_id=$_SESSION['portal_id'];
			$query = 	"SELECT cat_child
						FROM cat_rel
						WHERE cat_parent='$cat_id'";
			$result = mysql_query($query);
			while ($row=mysql_fetch_object($result)){
				if ($x!=1) $portal.=" OR ";
				$portal.="cat_id=".$row->cat_child;
				$x++;
			}
			$portal.=")";
		} else {
			$portal="";	$cat_id='';
		}
		$query =	"SELECT *
					FROM popular
					WHERE obj_name REGEXP '$st'".$portal."
					ORDER BY cat_id ASC";
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 0) {
			echo "<input type='hidden' id='auto_counter' value='0'>\n";
			echo "<input type='hidden' id='auto_url' value=''>\n";
			while ($row=mysql_fetch_object($result)){
				echo "<div class='auto_row'>";
				if ($row->cat_name!=$last_cat) {
					echo "<div class='auto_cat'><b>".$row->cat_name."</b></div>\n";
					$last_cat=$row->cat_name; $show=1;
				} else {
					$show++;
					if ($show<6) echo "<div class='auto_cat'> </div>\n";
				}
				if ($show<6) {
					$url='http://'.$_SERVER['HTTP_HOST']."/object/".url_in($row->obj_name)."/".$row->obj_id."/".$row->cat_id.'/';
					echo "<div class='auto_obj' id='auto_obj_$y' onmouseover='".'mouseSelect("'.$y.'")'."'><a href='$url'>
					<div class='img_xs'>";
					if (strlen($row->prim_photo_url) > 30) {
						echo "<img src='$aws_s3".$row->prim_photo_url."-xs.jpg'/>";
					} else {
						echo "<img src='http://static.weflect.com/system/default_16.gif'/>";
					}
					echo "</div><span style='float: left; margin-left: 2px;'>".truncate_text(nl2br2($row->obj_name), 30, ' ','')."</span></a></div>\n";
					echo "<input type='hidden' id='auto_url_$y' value='$url'>\n";
					$y++;
				}
				echo "</div>";
			}
			echo "<div class='auto_row'><a href='http://www.weflect.com/search.php?st=$st'>See all results for '$st' ></a></div>";
		} else {
			echo "";
		}
	} else {
		echo "";
	}
?>