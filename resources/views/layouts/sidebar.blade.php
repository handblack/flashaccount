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
						<p>Configuracion Almacenes</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_system_sequence')) ? 'd-none' : '' }}">
					<a href="{{ route('sequence.index') }}" class="nav-link  {{ request()->is('system/sequence*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Secuenciadores</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_system_parameter')) ? 'd-none' : '' }}">
					<a href="{{ route('parameter.index') }}" class="nav-link  {{ request()->is('system/parameter*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Parametros</p>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item {{ request()->is('config/*') ? 'menu-open' : '' }} {{ (auth()->user()->menu('m_config')) ? 'd-none' : '' }}">
			<a href="#" class="nav-link {{ request()->is('config/*') ? 'active' : '' }}">								
				<i class="nav-icon fas fa-clipboard-check"></i>
				<p>
					Catalogos
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">				
				<li class="nav-item  {{ (auth()->user()->menu('m_config_product')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('config/product*') ? 'active' : '' }}">						
						<i class="nav-icon fas fa-box-open nav-icon"></i>
						<p>Productos</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_config_productfamily')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('config/productfamily*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Familias</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_config_productline')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('config/productline*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Lineas</p>
					</a>
				</li>			
			</ul>
		</li>


		<li class="nav-item {{ request()->is('bpartner/*') ? 'menu-open' : '' }} {{ (auth()->user()->menu('m_bpartner')) ? 'd-none' : '' }}">
			<a href="#" class="nav-link {{ request()->is('bpartner/*') ? 'active' : '' }}">												
				<i class="nav-icon fas fa-user-tie"></i>
				<p>
					Socio de Negocio
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">				
				<li class="nav-item  {{ (auth()->user()->menu('m_bpartner_manager')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Maestro</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_bpartner_report_move')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('bpartner/report/move*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Reporte Movimientos</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_bpartner_report_account')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('bpartner/report/account*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>EECC Clientes</p>
					</a>
				</li>			
				<li class="nav-item  {{ (auth()->user()->menu('m_bpartner_report_account')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('bpartner/report/account*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>EECC Proveedores</p>
					</a>
				</li>			
			</ul>
		</li>

		<li class="nav-item {{ request()->is('bpartner/*') ? 'menu-open' : '' }} {{ (auth()->user()->menu('m_ventas')) ? 'd-none' : '' }}">
			<a href="#" class="nav-link {{ request()->is('bpartner/*') ? 'active' : '' }}">												
				<i class="nav-icon fas fa-cash-register"></i>
				<p>
					Ventas
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">				
				<li class="nav-item  {{ (auth()->user()->menu('m_ventas_order')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Proforma</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_ventas_invoice')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Emitir Comprobante</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_ventas_credit')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('bpartner/report/move*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Nota de Credito</p>
					</a>
				</li>
			</ul>
		</li>

		<li class="nav-item {{ request()->is('bpartner/*') ? 'menu-open' : '' }} {{ (auth()->user()->menu('m_compras')) ? 'd-none' : '' }}">
			<a href="#" class="nav-link {{ request()->is('bpartner/*') ? 'active' : '' }}">												
				<i class="nav-icon fas fa-dolly"></i>
				<p>
					Compras
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">				
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_order')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Orden de Compra</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_invoice')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Comprobante</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_credit')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('bpartner/report/move*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Nota de Credito</p>
					</a>
				</li>
			</ul>
		</li>

		<li class="nav-item {{ request()->is('bpartner/*') ? 'menu-open' : '' }} {{ (auth()->user()->menu('m_compras')) ? 'd-none' : '' }}">
			<a href="#" class="nav-link {{ request()->is('bpartner/*') ? 'active' : '' }}">												
				<i class="nav-icon fas fa-truck"></i>
				<p>
					Logistica
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">				
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_order')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Orden de Compra</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_invoice')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Comprobante</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_credit')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('bpartner/report/move*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Nota de Credito</p>
					</a>
				</li>
			</ul>
		</li>

		<li class="nav-item {{ request()->is('bpartner/*') ? 'menu-open' : '' }} {{ (auth()->user()->menu('m_compras')) ? 'd-none' : '' }}">
			<a href="#" class="nav-link {{ request()->is('bpartner/*') ? 'active' : '' }}">												
				<i class="nav-icon fab fa-cc-visa"></i>
				<p>
					Caja y Bancos
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">				
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_order')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Ingresos</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_invoice')) ? 'd-none' : '' }}">
					<a href="{{ route('product.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">						
						<i class="far fa-circle nav-icon"></i>
						<p>Egresos</p>
					</a>
				</li>
				<li class="nav-item  {{ (auth()->user()->menu('m_compras_credit')) ? 'd-none' : '' }}">
					<a href="{{ route('productfamily.index') }}" class="nav-link  {{ request()->is('bpartner/report/move*') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Asignacion</p>
					</a>
				</li>
			</ul>
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