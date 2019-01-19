<?php
	include 'header.php';
	// Xóa user
	if (isset($_GET['us']))
	{
	    echo "<script type=\"text/javascript\">alert(\"Bạn đã xóa thành công!\");</script>";
	}
	if (isset($_GET['uf']))
	{
	    echo "<script type=\"text/javascript\">alert(\"Không thể xóa user này!\");</script>";
	}
?>

<!-- page content -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="page-header"> Danh sách người dùng </h1>
			</div><!-- /.col -->

			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr align="center">
						<th> STT </th>
						<th> Tên người dùng </th>
						<th> Mật khẩu </th>
						<th> Số điện thoại </th>
						<th> Email </th>
						<th> Địa chỉ </th>
						<th> Xóa </th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once("../model/connect.php");
						error_reporting(2);

						$sql = "SELECT * FROM users WHERE role = 1";
						$result = mysqli_query($conn,$sql);
						if ($result)
						{
							$i = 1;
							while ($row = mysqli_fetch_assoc($result))
							{
					?>
								<tr class="odd gradex" align="center">
									<td><?php echo $i; ?></td>
									<td><?php echo $row['fullname']; ?></td>
									<td><?php echo $row['password']; ?></td>
									<td><?php echo $row['phone']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['address']; ?></td>
									<td>
										<a onclick="return confirm('Bạn có chắc chắn muốn xóa user này không?')" href="user-delete.php?idUser=<?php echo $row['id']; ?>" title="Xóa"><i class="fa fa-trash-o fa-lg"></i></a>
									</td>
								</tr>
					<?php
							$i += 1;
							}
						}
					?>
				</tbody>
			</table>
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /#page-wrapper -->