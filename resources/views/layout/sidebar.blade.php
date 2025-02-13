<!-- Page sidebar start-->
<aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="sidebar-main-title">
                <div>
                    <h5 class="lan-1 f-w-700 sidebar-title">General</h5>
                </div>
            </li>
            <!-- New Users Dropdown -->
            <li class="sidebar-list"><i class="fa-solid fa-users"></i><a class="sidebar-link" href="javascript:void(0)">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#User"></use>
                    </svg>
                    <h6 class="lan-4">Users</h6><i class="iconly-Arrow-Right-2 icli"></i></a>
                <ul class="sidebar-submenu">
                    <li> <a href="{{route("users.index")}}">Index</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</aside>
<!-- Page sidebar end-->
