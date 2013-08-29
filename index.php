<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Autocomplete w Images - Default functionality</title>
    <script src="./js/autocomplete.js"></script>
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <div id='search'>
		<form id='searchForm' name='searchForm' method='post' action='http://".$_SERVER['HTTP_HOST']."/search.php'>
            <div id='searchFilters'>
                <select name='type'>
                	<?php
						include ('./includes/initiate.php');
						if ($_SESSION['portal_id']=='') {
							echo "<option value='' selected>all topics\n";
							echo "<option value='38'>music\n";
							echo "<option value='86'>movies and tv\n";
							echo "<option value='19'>anime\n";
							echo "<option value='46'>beers\n";
							echo "<option value='60'>wines\n";
							echo "<option value='54'>teas\n";
						} else {
							$cat_parent=$_SESSION['portal_id'];
							echo "<option value='".$cat_parent."' selected>".$_SESSION['subportal']."\n";
							$query = 	"SELECT categories.cat_id, categories.cat_name 
										FROM categories, 
											cat_relationships
										WHERE categories.cat_id = cat_relationships.cat_child
										AND cat_relationships.cat_parent = '$cat_parent'
										ORDER BY categories.cat_name ASC";
							$result = mysql_query($query);
							while ($row=mysql_fetch_object($result)){
								echo "<option value='".$row->cat_id."'>".$row->cat_name."\n";
							}
						}
						echo "<option value='people'>People\n";
                    ?>
                </select>
            </div>
                        
            <div id='searchText'>
                <input type='text' size='30' id='obj_name' name='obj_name' onkeyup='autocomplete_n(event,"autocomplete_n", "obj_name")'/>
                    <input type='submit' value='search'>
                    <input type='hidden' name='submitted' value='TRUE' />
            </div>
		</form>
	</div>
	<div id='autocomplete_n'><span id='loadingspan'>Loading...</span></div>
</body>
</html>