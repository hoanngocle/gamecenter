<?php include('../includes/backend/header-admin.php');?>
<?php include('../includes/backend/mysqli_connect.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php include('../includes/backend/sidebar-admin.php'); ?>

<div id="content">
	<h2>Manage Categories</h2>
    <table>
    	<thead>
    		<tr>
    			<th><a href="view_categories.php?sort=id">ID</a></th>
    			<th><a href="view_categories.php?sort=cat">Categories</a></th>
    			<th><a href="view_categories.php?sort=pos">Position</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
		<?php 
			 // Sap xep theo thu tu cua table head
				if(isset($_GET['sort'])){
					switch ($_GET['sort']) {
						case 'id':
							$order_by = 'cat_id';
							break;
						
						case 'cat':
							$order_by = 'cat_name';
							break;

						case 'pos':
							$order_by = 'position';
							break;

						default:
							$order_by = 'cat_id';
							break;

					} // END Switch
				} else {
					$order_by = 'cat_id';
				}

			// Truy xuat csdl de hien thi category
			$query = "SELECT c.cat_id, c.cat_name, c.position ";
			$query .= " FROM tblcategories AS c ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
				confirm_query($result, $query);

			// vong lap while de hien thi ket qua tu csdl ra
		 	while($cats = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		 		// in ra cac cot cua bang
		 		echo "
	 				<tr>
		                <td>{$cats['cat_id']}</td>
		                <td>{$cats['cat_name']}</td>
		                <td>{$cats['position']}</td>
		                <td><a class='edit' href='edit_category.php?cid={$cats['cat_id']}'>Edit</a></td>
		                <td><a class='delete' href='delete_category.php?cid={$cats['cat_id']}&cat_name={$cats['cat_name']}'>Delete</a></td>
	            	</tr>
		 		";
		 	}// END While loop
		 ?>

    	</tbody>
    </table>
</div><!--end content-->

<?php include('../includes/backend/sidebar-b.php');?>
<?php include('../includes/backend/footer-admin.php'); ?>