<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-10">
            <img src="../images/logo1.png" alt="" width="40" >
        </div>
        
        <div class="sidebar-brand-text mx-3">MB Admin </div>
    </a>
    

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php?p=db">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Category Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
            aria-expanded="true" aria-controls="collapseCategory">
            <i class="fas fa-fw fa-cog"></i>
            <span>Category</span>
        </a>
        <div id="collapseCategory" class="collapse" aria-labelledby="headingCategory"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category</h6>
                <a class="collapse-item <?= ($p == 'addcg' ? 'active' : '') ?>" href="index.php?p=addcg">
                    <i class="fa fa-plus-circle"></i> Add
                </a>
            </div>
        </div>
    </li>

    <!-- Product Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
            aria-expanded="true" aria-controls="collapseProduct">
            <i class="fas fa-fw fa-cog"></i>
            <span>Product</span>
        </a>
        <div id="collapseProduct" class="collapse" aria-labelledby="headingProduct"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product</h6>
                <a class="collapse-item <?= ($p == 'add' ? 'active' : '') ?>" href="index.php?p=add">
                    <i class="fa fa-plus-circle"></i> Add
                </a>
                <a class="collapse-item <?= ($p == 'view' ? 'active' : '') ?>" href="index.php?p=view">
                    <i class="fa fa-eye"></i> View
                </a>
            </div>
        </div>
    </li>

    <!-- Aside Menu (Fixed ID issue) -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAside"
            aria-expanded="true" aria-controls="collapseAside">
            <i class="fas fa-fw fa-cog"></i>
            <span>Aside</span>
        </a>
        <div id="collapseAside" class="collapse" aria-labelledby="headingAside"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Aside Section</h6>
                <a class="collapse-item <?= ($p == 'addaside' ? 'active' : '') ?>" href="index.php?p=addaside">
                    <i class="fa fa-plus-circle"></i> Add
                </a>
                <a class="collapse-item <?= ($p == 'viewaside' ? 'active' : '') ?>" href="index.php?p=viewaside">
                    <i class="fa fa-eye"></i> View
                </a>
                <a class="collapse-item <?= ($p == 'logoedit' ? 'active' : '') ?>" href="index.php?p=logoedit">
                    <i class="fa fa-eye"></i> logo
                </a>
            </div>
        </div>
    </li>

    <br><br>
    <li class="nav-item center">
        <a href="/projectlab2/login/logout.php" class="btn btn-primary">
            <h6>Log out</h6>
        </a>
    </li>

    <br><br>
    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<style>
    .center {
        text-align: center;
    }
</style>