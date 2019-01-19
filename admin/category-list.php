<?php
	include 'header.php';
	// Chèn thêm danh mục
	if (isset($_POST['insertCategory']))
	{
		if ($_POST['txtCateName'])
		{
	        $categoryName = $_POST['txtCateName'];
	        $sqlInsertCate = "INSERT INTO categories(name) VALUES('$categoryName')";
	        $resCate = mysqli_query($conn,$sqlInsertCate);
    	}
	}
	// Cập nhật danh mục
	if (isset($_POST['updateCategory']))
	{
	    if($_POST['idCate'])
	    {
	        $idCate = $_POST['idCate'];
		    if ($_POST['txtCateName'])
		    {
		        $categoryName = $_POST['txtCateName'];
		        $sqlUpdateCate = "UPDATE categories SET name = '$categoryName' WHERE id =$idCate";
		        // echo $sqlUpdateCate; hiển thị id danh mục đã chọn để sửa
		        $resCate = mysqli_query($conn,$sqlUpdateCate);
		    }
	    }
	}
	// Xóa danh mục
	if (isset($_GET['cs']))
	{
	    echo "<script type=\"text/javascript\">alert(\"Bạn đã xóa thành công!\");</script>";
	}
	if (isset($_GET['cf']))
	{
	    echo "<script type=\"text/javascript\">alert(\"Không thể xóa danh mục này!\");</script>";
	}
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="page-header"> Danh mục sản phẩm </h1>

	            <div class="row">
	            	<!-- Thêm danh mục sản phẩm -->
	                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	                    <a href="category-list.php?addCategory=add" style="color: red; text-decoration: none;"><button class="btn btn-info"> Thêm danh mục </button></a>
	                    <?php 
	                    	if(isset($_GET['addCategory']))
	                    	{
	                    ?>
			                    <form action ="category-list.php?addCategory=add" method="POST">
			                        <div class="form-group">
			                            <label> Tên danh mục </label>
			                            <input class="form-control" name="txtCateName" placeholder="Vui lòng nhập tên danh mục sản phẩm" />
			                        </div>
			                        <button type="submit" name="insertCategory" class="btn btn-warning"> Thêm </button>
			                        <button type="reset" class="btn btn-default"> Thiết lập lại </button>
			                    </form>
	                    <?php }?>
	                </div><!-- /col -->

					<!-- Chỉnh sửa danh mục sản phẩm -->
	                <?php
		                if (isset($_GET['idCate']))
		                {
		                    $idCate = $_GET['idCate'];
		                    $sqlSelectEachCategory = "SELECT * FROM categories WHERE id = $idCate";
		                    $resEachCategory = mysqli_query($conn,$sqlSelectEachCategory);

		                    while($rowEach = mysqli_fetch_assoc($resEachCategory))
		                    {
	                ?>
				                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				                    <h4> Chỉnh sửa sản phẩm </h4>
				                    <form name="form-categories" action ="category-list.php" method="POST">
				                        <div class="form-group">
				                            <label> Tên danh mục(Loại) </label>
				                            <input class="form-control" name="txtCateName" value="<?php echo $rowEach['name'];?>" />
				                            <input type="hidden" name="idCate" value="<?php echo $rowEach['id']?>">
				                        </div>
				                        <button type="submit" name="updateCategory" class="btn btn-warning"> Chỉnh sửa </button>
				                    </form>
				                </div><!-- /col -->
	            	<?php 	}
	                	}
	           		?>
	            </div><!-- /row -->
	            <hr/>

	            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
	                <thead>
	                    <tr>
	                        <th>ID</th>
	                        <th>Danh mục sản phẩm</th>
	                        <th>Chỉnh sửa</th>
	                        <th>Xóa</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php
							$sql = "SELECT * FROM categories";
							$result = mysqli_query($conn,$sql);
		                    if ($result) 
		                    {
		                        while ($row = mysqli_fetch_assoc($result))
		                        {
	                    ?>
		                            <tr class="odd gradeX" align="center">
		                                <td><?php echo $row['id']; ?></td>
		                                <td>
		                                    <div class="form-group">
		                                        <input class="form-control" name="nameCate" type="text" value="<?php echo $row['name']; ?>" style="background: transparent; border: none;" readonly>
		                                    </div>
		                                </td>
		                                <td class="center">
		                                    <a href="category-list.php?idCate=<?php echo $row['id']; ?>" title="Chỉnh sửa"><i class="fa fa-pencil fa-lg"></i></a>
		                                </td>
		                                <td class="center">
		                                	<a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" href="category-delete.php?idCate=<?php echo $row['id']; ?>" title="Xóa"><i class="fa fa-trash-o fa-lg"></i></a>
		                                </td>
		                            </tr>
	                    <?php
		                        }
		                    }
	                    ?>
	                </tbody>
	            </table>
            </div><!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->