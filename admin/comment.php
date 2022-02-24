<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="index.php"><svg class="glyph stroked home">
						<use xlink:href="#stroked-home"></use>
					</svg></a></li>
			<li class="active">Quản lý bình luận</li>
		</ol>
	</div>
	<!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Quản lý bình luận</h1>
		</div>
	</div>
	<!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table data-toolbar="#toolbar" data-toggle="table">

						<thead>
							<tr>
								<th data-field="id" data-sortable="true">ID</th>
                                <th>Người bình luận</th>
                                <th>Sản phẩm</th>
								<th>Bình luận</th>
                                <th>Thời điểm</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
						    <?php
                            if(isset($_GET["page"])){
                                $page = $_GET["page"];
                            } else{
                                $page = 1;
                            }
                            $rows_per_page = 10;
                            $per_row = $page * $rows_per_page - $rows_per_page;
                            $total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comment"));
                            $total_pages = ceil($total_rows/$rows_per_page);  //hàm làm tròn lên

                            $list_pages = '<ul class="pagination">';
                            //Page Previous
                            $page_prev = $page - 1;
                            if($page_prev == 0){
                                $page_prev = 1;
                            }
                            $list_pages .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=comment&page='.$page_prev.'">&laquo;</a></li>';
                            //End Page Previous
                            for($i = 1; $i <= $total_pages; $i++){
                                $list_pages .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=comment&page='.$i.'">'.$i.'</a></li>';
                            }
                            //Page Next
                            $page_next = $page + 1;
                            if($page_next > $total_pages){
                                $page_next = $total_pages;
                            }
                            $list_pages .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=comment&page='.$page_next.'">&raquo;</a></li>';
                            //End Page Next
                            $list_pages .= '</ul>';
                            echo $list_pages;
                            $sql = "SELECT comment.*, product.prd_name 
                            FROM comment INNER JOIN product ON comment.prd_id = product.prd_id
                            ORDER BY comm_id ASC
                            LIMIT $per_row, $rows_per_page
                            ";
                            $query = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td style><?php echo $row["comm_id"];?></td>
                                    <td style><?php echo $row["comm_name"]?></td>
                                    <td style><?php echo $row["prd_name"];?></td>
                                    <td style><?php echo $row["comm_details"];?></td>
                                    <td style><?php echo $row["comm_date"];?></td>
                                    <td class="form-group">
                                        <a href="delete_comment.php?comm_id=<?php echo $row["comm_id"]?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
							
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<nav aria-label="Page navigation example">
						<ul class="pagination">
							<?php
                            echo $list_pages;
							?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!--/.row-->
</div>
<!--/.main-->

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-table.js"></script>
