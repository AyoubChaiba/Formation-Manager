<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('admin-assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">FORMATIONS</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>لوحة تحكم</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('responsible.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>المسؤولون</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('date.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>تاريخ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('program.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>البرامج</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('targetGroup.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>الفئات المستهدفة</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('course.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>الدورات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('beneficiarie.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>المستفيدون</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact.index') }}" class="nav-link">
                        <i class="nav-icon  far fa-file-alt"></i>
                        <p>تواصل</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
