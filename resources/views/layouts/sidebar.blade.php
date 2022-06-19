<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
		<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
		<li class="nav-item {{ request()->is('dashboard*') ? 'menu-open' : '' }}">
			<a href="{{ route('dashboard') }}" class="nav-link  {{ request()->is('dashboard*') ? 'active' : '' }}">
				<i class="nav-icon fas fa-tachometer-alt"></i>
				<p>Dashboard</p>
			</a>
		</li>
		<li class="nav-item {{ request()->is('system/*') ? 'menu-open' : '' }} {{ (auth()->user()->menu('m_system')) ? 'd-none' : '' }}">
			<a href="#" class="nav-link {{ request()->is('system/*') ? 'active' : '' }}">
				<i class="nav-icon fas fa-rocket"></i>
				<p>
					Sistema
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">
				
				<li class="nav-item  {{ (auth()->user()->menu('m_system_user')) ? 'd-none' : '' }}">
					<a href="{{ route('user.index') }}" class="nav-link {{ request()->is('system/user*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Usuarios</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_system_team')) ? 'd-none' : '' }}">
					<a href="{{ route('team.index') }}" class="nav-link  {{ request()->is('system/team*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Grupos &amp; Accesos</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_system_currency')) ? 'd-none' : '' }}">
					<a href="{{ route('currency.index') }}" class="nav-link  {{ request()->is('system/currency*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Configuracion Divisas</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_system_warehouse')) ? 'd-none' : '' }}">
					<a href="{{ route('warehouse.index') }}" class="nav-link  {{ request()->is('system/warehouse*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Configuracion Divisas</p>
					</a>
				</li>
			</ul>
		</li>
		 
		<li class="nav-item">
			<a href="#" class="nav-link">
				<i class="fas fa-circle nav-icon"></i>
				<p>Level 1</p>
			</a>
		</li>
		<li class="nav-header"><!-- LABELS --></li>
		<li class="nav-item">
			<a href="{{ route('logout') }}" class="nav-link">
				<i class="nav-icon far fa-circle text-danger"></i>
				<p class="text">Salir</p>
			</a>
		</li>		
	</ul>
</nav>