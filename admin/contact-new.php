<?php
	include 'header.php';

	$status = 0;
	if (isset($_GET['idStatus']))
	{
		$idStatus = $_GET['idStatus'];
		if (isset($_POST['updateStatus']))
		{
			if (isset($_POST['status'])) {
				$status = 1;
			}
		}
		$sql = "UPDATE contacts SET status = $status WHERE id = $idStatus";
		$result = mysqli_query($conn,$sql);
	}
?>

<!-- page-wrapper -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="page-header"> Danh sách liên hệ mới </h1>
			</div><!-- /.col -->

			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr align="center">
						<th> STT </th>
						<th> Tên người dùng </th>
						<th> Email </th>
						<th> Chủ đề </th>
						<th> Nội dung </th>
						<th> Ngày gửi </th>
						<th> Trả lời </th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once("../model/connect.php");
						error_reporting(2);

						$sql = "SELECT * FROM contacts WHERE status = 0";
						$result = mysqli_query($conn,$sql);
						if ($result)
						{
							$i = 1;
							while ($row = mysqli_fetch_assoc($result))
							{
					?>			
								<tr class="odd gradeX" align="center">
									<td><?php echo $i; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['title']; ?></td>
									<td><?php echo $row['contents']; ?></td>
									<td><?php echo $row['created']; ?></td>
									<td>
										<!-- status = 1 là đã đọc liên hệ -->
										<form action="contact-list.php?idStatus=<?php echo $row['id']; ?>" method="POST">
                                            <div class="row">
                                            	<div class ="col-lg-2 col-md-2 hidden-sm"></div>
                                                <div class ="col-lg-3 col-md-3 col-sm-3">
                                                    <label class="checkbox">
                                                        <?php
                                                        	if ($row['status'] == 1)
                                                        	{
                                                        ?>    
                                                            <input  value="<?php echo $row['status']; ?>" type="checkbox" checked="" name="status">
                                                        <?php
                                                        	} else
                                                        	{
                                                        ?>
                                                            	<input  value="<?php echo $row['status']; ?>" type="checkbox" name="status">
														<?php
															}
														?>
                                                    </label>
                                                    <br/>
                                                </div>
                                                <div class ="col-lg-3 col-md-3 col-sm-3">
                                                    <button style="background: transparent;" type="submit" name="updateStatus" class="btn btn-md"> Cập nhật </button>
                                                </div>
                                                <div class ="col-lg-3 col-md-3"></div>
                                            </div>
                                        </form>
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
	</div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->