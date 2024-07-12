<div class="container-fluid">
    <div class="row">
        <div class="sidebar col-md-3">
                <img src="https://i.postimg.cc/K8Qv2MQF/Pharmy-Go-Logo.png" alt="Logo" class="sidebar-logo">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.add.drugs') ? 'active' : '' }}" href="{{ route('admin.add.drugs') }}">
                        <i class="fas fa-pills"></i> Add Drugs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.approval') ? 'active' : '' }}" href="{{ route('admin.approval') }}">
                        <i class="fas fa-user-check"></i> Approval Pharmacists
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.patients') ? 'active' : '' }}" href="{{ route('admin.patients') }}">
                        <i class="fas fa-users"></i> Show Patients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.pharmacists') ? 'active' : '' }}" href="{{ route('admin.pharmacists') }}">
                        <i class="fas fa-user-md"></i> Show Pharmacists
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.pharmacies') ? 'active' : '' }}" href="{{ route('admin.pharmacies') }}">
                        <i class="fas fa-hospital"></i> Show Pharmacies
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}" href="{{ route('admin.orders') }}">
                        <i class="fas fa-receipt"></i> Show Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.donation') ? 'active' : '' }}" href="{{ route('admin.donation') }}">
                        <i class="fas fa-hand-holding-medical"></i> Show Donations
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-9">
            <!-- Main content goes here -->
        </div>
    </div>
</div>
