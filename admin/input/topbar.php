

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php
                    if ($_SESSION['role'] === 'admin') {
                        echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Guest';
                    } else {
                        echo "admin";
                    }
                     ?>
                </span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
        </li>
    </ul>
</nav>
