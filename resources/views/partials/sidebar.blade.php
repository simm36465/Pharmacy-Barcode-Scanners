<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-primary elevation-1">
    <!-- Brand Logo -->
    <a href="{{ route('num') }}" class="brand-link">
        <img src="dist/img/unnamed.png" alt="CMSS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Controle pharmacie</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block" style="text-transform:uppercase;">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->is('dashboard') ? 'nav-link active' : 'nav-link' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Tableau de bord
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('searchmedi') }}"
                        class="{{ request()->is('searchmedi') ? 'nav-link active' : 'nav-link' }}">

                        <i class="nav-icon fas fa-search"></i>
                        <p>
                            Recherche médicament
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('addmedicament') }}"
                        class="{{ request()->is('addmedicament') ? 'nav-link active' : 'nav-link' }}">

                        <i class="nav-icon fas fa-plus-square"></i>
                        <p>
                            Ajouter médicament
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('editmedicament') }}"
                        class="{{ request()->is('editmedicament') ? 'nav-link active' : 'nav-link' }}">

                        <i class="nav-icon fas fa-pen"></i>
                        <p>
                            Modifier médicament
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('delmedicament') }}"
                        class="{{ request()->is('delmedicament') ? 'nav-link active' : 'nav-link' }}">
                        <i class="nav-icon fas fa-minus-square"></i>
                        <p>
                            Supprimer médicament
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-download"></i>
                        <p>
                            Exporter les données
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">

                        <li class="nav-item">
                            <a href="{{ route('exportdata') }}"
                                class="{{ request()->is('exportdata') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-hospital-user"></i>
                                <p>
                                    Les ordonnances
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route("exportmedidata")}}" class="{{ request()->is('exportmedidata') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-pills"></i>
                                <p>Les médicaments</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
