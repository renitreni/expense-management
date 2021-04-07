<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header pt-2">
                Components
            </li>
            <li class="sidebar-item @if (in_array(Route::current()->uri, ['home'])) active @endif">
                <a class="sidebar-link" href="{{ route('home') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item @if (in_array(Route::current()->uri, ['categories', 'expense'])) active @endif">
                <a href="#auth" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Expense Management</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse @if (in_array(Route::current()->uri, ['categories', 'expense'])) show @endif"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item @if (in_array(Route::current()->uri, ['categories'])) active @endif">
                        <a class="sidebar-link" href="{{ route('categories.index') }}">Expense Categories</a>
                    </li>
                    <li class="sidebar-item @if (in_array(Route::current()->uri, ['expense'])) active @endif">
                        <a class="sidebar-link" href="{{ route('expense.index') }}">Expenses</a>
                    </li>
                </ul>
            </li>
            @canany(['accounts', 'roles'])
                <li class="sidebar-item @if (in_array(Route::current()->uri, ['users', 'roles'])) active @endif">
                    <a href="#auth" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Manage Users</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse @if (in_array(Route::current()->uri, ['users', 'roles'])) show @endif"
                        data-bs-parent="#sidebar">
                        @can('accounts')
                            <li class="sidebar-item @if (in_array(Route::current()->uri, ['users'])) active @endif">
                                <a class="sidebar-link" href="{{ route('users.index') }}">Accounts</a>
                            </li>
                        @endcan
                        @can('roles')
                            <li class="sidebar-item @if (in_array(Route::current()->uri, ['roles'])) active @endif">
                                <a class="sidebar-link" href="{{ route('roles.index') }}">Roles</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
        </ul>
    </div>
</nav>
