<?php

include "login1.php";
// Now you can use $pdo for database queries

$hide =true;
$p = "index.php";
if(isset($_GET['p'])){
    $p=$_GET['p'];
    switch($p){
        
        case "add":{
            $add="add.php";
            $hide=false;
            break;
        }
        case "view":{
            $view="view.php";
            $hide=false;
            break;
        }
        case "addcg":{
            $addcg="addcg.php";
            $hide=false;
            break;
        }
        case "edit":{
            $edit="edit.php";
            $hide=false;
            break;
        }
        case "addaside":{
            $addaside="addaside.php";
            $hide=false;
            break;
        }
        case "viewaside":{
            $viewaside="viewaside.php";
            $hide=false;
            break;
        }
        case "editaside":{
            $editaside="editaside.php";
            $hide=false;
            break;
        }
        case "logoedit":{
            $logoedit="logoedit.php";
            $hide=false;
            break;
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">


<?php include ("input/head.php");?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include ("input/sidebar.php");?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include ("input/topbar.php");?>
                <!-- End of Topbar -->
                <?php
                if($hide)
                 include("content.php");
                ?>

                <!-- Begin Page Content -->
                
                <?php
                
                if(!empty($p=="add")){
                    include ("$add");
                }
                elseif($p=="view"){
                    include ("$view");
                }
                elseif($p=="addcg"){
                    include ("$addcg");
                }
                elseif($p=="edit"){
                    include ("$edit");
                }
                elseif($p=="addaside"){
                    include ("$addaside");
                }
                elseif($p=="viewaside"){
                    include ("$viewaside");
                }
                elseif($p=="editaside"){
                    include ("$editaside");
                }
                elseif($p=="logoedit"){
                    include ("$logoedit");
                }
                ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php if($hide) include ("input/footer.php");?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php //include ("");?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>