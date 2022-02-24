<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg></a></li>
            <li class="active">Danh sách đơn hàng</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Danh sách đơn hàng</h1>
        </div>
    </div>
    <!--/.row-->
    
    <div id="toolbar" class="btn-group">
        <a href="index.php?page_layout=order&order_status=0" class="btn btn-success">
            Đang giao
        </a>
        <a href="index.php?page_layout=order&order_status=1" class="btn btn-success">
            Thành công
        </a>
        <a href="index.php?page_layout=order&order_status=2" class="btn btn-success">
            Bị hủy
        </a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toolbar="#toolbar" data-toggle="table">
                        <thead>
                            <tr>

                                <th data-field="id" data-sortable="true">ID</th>
                                <th>Mã đơn hàng</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="name" data-sortable="true">Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $order_status = 0;
                            if (isset($_GET["page"])) {
                                $page = $_GET["page"];
                            } else {
                                $page = 1;
                            }
                            $rows_per_page = 5;
                            $per_row = $page * $rows_per_page - $rows_per_page;

                            if (isset($_GET['order_status'])) {
                                $order_status = $_GET['order_status'];
                            }

                            $total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE order_status=$order_status"));
                            $total_pages = ceil($total_rows / $rows_per_page);  //hàm làm tròn lên

                            $list_pages = '<ul class="pagination">';
                            //Page Previous
                            $page_prev = $page - 1;
                            if ($page_prev == 0) {
                                $page_prev = 1;
                            }
                            //Page Next
                            $page_next = $page + 1;
                            if ($page_next > $total_pages) {
                                $page_next = $total_pages;
                            }

                            $list_pages .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=order&order_status='.$order_status.'&page=' . $page_prev . '">&laquo;</a></li>';
                                //End Page Previous
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $list_pages .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=order&order_status='.$order_status.'&page=' . $i . '">' . $i . '</a></li>';
                            }

                            $list_pages .= '<li class="page-item"><a class="page-link" href="index.php?page_layout=order&order_status='.$order_status.'&page=' . $page_next . '">&raquo;</a></li>';
                            //End Page Next
                            $list_pages .= '</ul>';
                            echo $list_pages;

                            $sql = "SELECT o.order_id, o.order_code, o.user_mail, p.prd_name, o.order_quantity, o.order_status, o.order_time 
                            FROM orders AS o INNER JOIN product AS p 
                            ON o.prd_id = p.prd_id 
                            WHERE o.order_status = $order_status 
                            ORDER BY o.order_id DESC
                            LIMIT $per_row, $rows_per_page
                            ";
                            $query = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td style><?php echo $row["order_id"]; ?></td>
                                    <td style><?php echo $row["order_code"]; ?></td>
                                    <td style><?php echo $row["user_mail"]; ?></td>
                                    <td style><?php echo $row["prd_name"]; ?></td>
                                    <td style><?php echo $row["order_quantity"]; ?></td>
                                    <td style><?php echo $row["order_time"]; ?></td>
                                    <?php if ($order_status == 0) { ?>
                                        <td class="form-group">
                                            <a href="update_order.php?order_id=<?php echo $row["order_id"] ?>" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i></a>
                                            <a href="cancel_order.php?order_id=<?php echo $row["order_id"] ?>" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i></a>
                                        </td>
                                    <?php } else { ?>
                                        <td class="form-group">
                                            <a href="delete_order.php?order_id=<?php echo $row["order_id"] ?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <nav aria-label="Page navigation example">
                        <?php
                        echo $list_pages;
                        ?>
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