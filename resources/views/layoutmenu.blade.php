<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/img/cp-logo-sm.png') }}">


    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->


    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">




    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&family=Prompt&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: "IBM Plex Sans Thai", sans-serif;
        }
    </style>

</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>

    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="#" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('/img/cp-logo-lg.png') }}" alt="" height="60">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('/img/cp-logo-sm.png') }}" alt="" height="55">
                </span>
            </a>

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('/img/cp-logo-lg.png') }}" alt="" height="60">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('/img/cp-logo-sm.png') }}" alt="" height="55">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item h6">ครุภัณฑ์</li>
                    <li class="side-nav-item">
                        <a href="{{ route('index') }}" class="side-nav-link">
                            <i class="uil-box"></i> <!-- ใช้ไอคอน search-alt -->
                            <span> รายการครุภัณฑ์ </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('search') }}" class="side-nav-link">
                            <i class="uil-search-alt"></i> <!-- ใช้ไอคอน search-alt -->
                            <span> ค้นหาครุภัณฑ์ </span>
                        </a>
                    </li>

                    <li class="side-nav-title side-nav-item">คำร้องยืมครุภัณฑ์</li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false"
                            aria-controls="sidebarEmail" class="side-nav-link">
                            <i class="uil-envelope"></i>
                            <span> ยืมครุภัณฑ์ </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('borrowlist') }}">คำร้องทั้งหมด</a>
                                </li>
                                <li>
                                    <a href="{{ route('borrowpending') }}">รอดำเนินการ</a>
                                </li>
                                <li>
                                    <a href="{{ route('borrowcompleted') }}">เสร็จสิ้น</a>
                                </li>
                                <li>
                                    <a href="{{ route('borrowrejected') }}">ถูกปฏิเสธ</a>
                                </li>
                            </ul>
                        </div>
                    </li>



                    <li class="side-nav-title side-nav-item">นำเข้าข้อมูล</li>

                    <li class="side-nav-item">
                        <a href="{{ route('import-excel') }}" class="side-nav-link">
                            <i class="uil-database"></i>
                            <span> นำเข้าข้อมูลครุภัณฑ์ </span>
                        </a>
                    </li>

                    <li class="side-nav-title side-nav-item mt-1">ระบบเเจ้งซ่อม</li>

                    <li class="side-nav-item">
                        <a href="{{ route('repairmain') }}" class="side-nav-link">
                            <i class=" uil-graph-bar"></i>
                            <span> ภาพรวมระบบแจ้งซ่อม </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('repairlist') }}" class="side-nav-link">
                            <i class="uil-notes"></i>
                            <span> รายการเเจ้งซ่อม </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('searchrepair') }}" class="side-nav-link">
                            <i class="uil-search"></i>
                            <span> ค้นหาประวัติการซ่อม </span>
                        </a>
                    </li>

                    <li class="side-nav-title side-nav-item">จัดการข้อมูล</li>

                    <li class="side-nav-item">
                        <a href="{{ route('manageuser.index') }}" class="side-nav-link">
                            <i class="uil-users-alt"></i>
                            <span> จัดการข้อมูลผู้ใช้งาน </span>
                        </a>
                    </li>

                    <li class="side-nav-title side-nav-item">ยืมเเละเเจ้งซ่อม</li>

                    <li class="side-nav-item">
                        <a href="{{ route('storeborrowrequest') }}" class="side-nav-link">
                            <i class="uil-users-alt"></i>
                            <span>แบบฟอร์มการยืมครุภัณฑ์</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('borrowhistory') }}" class="side-nav-link">
                            <i class="uil-history-alt"></i>
                            <span>ประวัติยืมครุภัณฑ์</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href={{ route('requestrepair') }} class="side-nav-link">
                            <i class="uil-wrench"></i>
                            <span>เเจ้งซ่อม</span>
                        </a>
                    </li>

                </ul>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                <span class="noti-icon-badge"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="javascript: void(0);" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>

                                <div style="max-height: 230px;" data-simplebar="">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">1 min ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                        <p class="notify-details">New user registered.
                                            <small class="text-muted">5 hours ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="assets/images/users/avatar-2.jpg"
                                                class="img-fluid rounded-circle" alt="">
                                        </div>
                                        <p class="notify-details">Cristina Pride</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Hi, How are you? What about our next meeting</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">4 days ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="assets/images/users/avatar-4.jpg"
                                                class="img-fluid rounded-circle" alt="">
                                        </div>
                                        <p class="notify-details">Karen Robinson</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Wow ! this admin looks good and awesome design</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <p class="notify-details">Carlos Crouch liked
                                            <b>Admin</b>
                                            <small class="text-muted">13 days ago</small>
                                        </p>
                                    </a>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    View All
                                </a>

                            </div>
                        </li>




                        <li class="notification-list">
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="assets/images/users/avatar-1.jpg" alt="user-image"
                                        class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">Rattaphoom thanachot</span>
                                    <span class="account-position">dev</span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-edit me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lifebuoy me-1"></i>
                                    <span>Support</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lock-outline me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>

                    </ul>

                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>

                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-left">
                                    <ol class="breadcrumb m-0">
                                        @yield('breadcrumb')
                                    </ol>
                                </div>
                                <h4 class="page-title">@yield('contentitle')</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        @yield('nonconten')
                    </div>

                    <!-- start conten -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    @yield('conten')
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end conten -->

                </div> <!-- container -->






            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © KKU - Asset management system by KKU
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="end-bar">

        <div class="rightbar-title">
            <a href="javascript:void(0);" class="end-bar-toggle float-end">
                <i class="dripicons-cross noti-icon"></i>
            </a>
            <h5 class="m-0">Settings</h5>
        </div>

        <div class="rightbar-content h-100" data-simplebar="">

            <div class="p-3">

                <!-- Settings -->
                <h5 class="mt-3">Color Scheme</h5>
                <hr class="mt-1">

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light"
                        id="light-mode-check" checked="">
                    <label class="form-check-label" for="light-mode-check">Light Mode</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark"
                        id="dark-mode-check">
                    <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                </div>


                <!-- Width -->
                <h5 class="mt-4">Width</h5>
                <hr class="mt-1">
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="width" value="fluid" id="fluid-check"
                        checked="">
                    <label class="form-check-label" for="fluid-check">Fluid</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="width" value="boxed" id="boxed-check">
                    <label class="form-check-label" for="boxed-check">Boxed</label>
                </div>


                <!-- Left Sidebar-->
                <h5 class="mt-4">Left Sidebar</h5>
                <hr class="mt-1">
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="theme" value="default"
                        id="default-check">
                    <label class="form-check-label" for="default-check">Default</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="theme" value="light" id="light-check"
                        checked="">
                    <label class="form-check-label" for="light-check">Light</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="theme" value="dark" id="dark-check">
                    <label class="form-check-label" for="dark-check">Dark</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="fixed" id="fixed-check"
                        checked="">
                    <label class="form-check-label" for="fixed-check">Fixed</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="condensed"
                        id="condensed-check">
                    <label class="form-check-label" for="condensed-check">Condensed</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="scrollable"
                        id="scrollable-check">
                    <label class="form-check-label" for="scrollable-check">Scrollable</label>
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                </div>
            </div> <!-- end padding-->

        </div>
    </div>

    <div class="rightbar-overlay"></div>


    <!-- /End-bar -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <script src="{{ asset('./assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('./assets/js/app.min.js') }}"></script>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // ดักจับการคลิกที่เมนู
        const menuItem = document.querySelectorAll('.side-nav-title');
        menuItem.forEach(item => {
            item.addEventListener('click', function () {
                if (this.textContent.includes('ยืมครุภัณฑ์')) { // ตรวจสอบข้อความเมนู
                    window.location.href = "http://127.0.0.1:8000/storeborrowrequest"; // เปลี่ยนเส้นทาง
                }
            });
        });
    });
</script>





    <script>
        let table = new DataTable('#basic-datatable', {
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'ทั้งหมด']
            ]
        });
    </script>



    @yield('scripts')

</body>

</html>

