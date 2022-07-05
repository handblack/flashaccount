<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy nav-compact font-weight-light" 
		data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item {{ request()->is('dashboard*') ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard') }}" class="nav-link  {{ request()->is('dashboard*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        {{-- SISTEMAS --}}
        <li
            class="nav-item {{ request()->is('system/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_system')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('system/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-rocket"></i>
                <p>
                    Sistema
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_system_user')? 'd-none': '' }}">
                    <a href="{{ route('user.index') }}"
                        class="nav-link {{ request()->is('system/user*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_system_team')? 'd-none': '' }}">
                    <a href="{{ route('team.index') }}"
                        class="nav-link  {{ request()->is('system/team*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Grupos &amp; Accesos</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_system_currency')? 'd-none': '' }}">
                    <a href="{{ route('currency.index') }}"
                        class="nav-link  {{ request()->is('system/currency*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Configuracion Divisas</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_system_warehouse')? 'd-none': '' }}">
                    <a href="{{ route('warehouse.index') }}"
                        class="nav-link  {{ request()->is('system/warehouse*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Configuracion Almacenes</p>
                    </a>
                </li>
                
                <li class="nav-item  {{ !auth()->user()->menu('m_system_sequence')? 'd-none': '' }}">
                    <a href="{{ route('sequence.index') }}"
                        class="nav-link  {{ request()->is('system/sequence*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Configuracion Series</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_system_bankaccount')? 'd-none': '' }}">
                    <a href="{{ route('bankaccount.index') }}"
                        class="nav-link  {{ request()->is('system/bankaccount*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cuentas Bancarias</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_system_parameter')? 'd-none': '' }}">
                    <a href="{{ route('parameter.index') }}"
                        class="nav-link  {{ request()->is('system/parameter*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Parametros</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- CATALOGO --}}
        <li class="nav-item {{ request()->is('config/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_config')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('config/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-clipboard-check"></i>
                <p>
                    Catalogos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_config_product')? 'd-none': '' }}">
                    <a href="{{ route('product.index') }}"
                        class="nav-link {{ request()->is('config/product*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open nav-icon"></i>
                        <p>Productos</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_config_productfamily')? 'd-none': '' }}">
                    <a href="{{ route('productfamily.index') }}"
                        class="nav-link  {{ request()->is('config/productfamily*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Familias</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_config_productline')? 'd-none': '' }}">
                    <a href="{{ route('productline.index') }}"
                        class="nav-link  {{ request()->is('config/productline*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Lineas</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- SOCIO DE NEGOCIO --}}
        <li
            class="nav-item {{ request()->is('bpartner/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_bpartner')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('bpartner/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                    Socio de Negocio
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_bpartner_manager')? 'd-none': '' }}">
                    <a href="{{ route('bpartner.index') }}"
                        class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Maestro</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_bpartner_report_move')? 'd-none': '' }}">
                    <a href="{{ route('bpartner_rpt_move') }}"
                        class="nav-link  {{ request()->is('bpartner/report/move*') ? 'active' : '' }}">
                        <i class="fas fa-print nav-icon"></i>
                        <p>Reporte Movimientos</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_bpartner_report_receivable')? 'd-none': '' }}">
                    <a href="{{ route('bpartner_rpt_receivable') }}"
                        class="nav-link  {{ request()->is('bpartner/report/receivable*') ? 'active' : '' }}">
                        <i class="fas fa-print nav-icon"></i>
                        <p>Cuentas por Cobrar</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_bpartner_report_payable')? 'd-none': '' }}">
                    <a href="{{ route('bpartner_rpt_payable') }}"
                        class="nav-link  {{ request()->is('bpartner/report/payable*') ? 'active' : '' }}">
                        <i class="fas fa-print nav-icon"></i>
                        <p>Cuentas por Pagar</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- VENTAS / CLIENTES --}}
        <li
            class="nav-item {{ request()->is('ventas/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_ventas')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('ventas/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cash-register"></i>
                <p>
                    Ventas / Clientes
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_ventas_order')? 'd-none': '' }}">
                    <a href="{{ route('corder.index') }}"
                        class="nav-link {{ request()->is('ventas/order/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Orden de Venta</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_ventas_invoice')? 'd-none': '' }}">
                    <a href="{{ route('cinvoice.index') }}"
                        class="nav-link {{ request()->is('ventas/invoice/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Comprobantes de Venta</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_ventas_credit')? 'd-none': '' }}">
                    <a href="{{ route('ccredit.index') }}"
                        class="nav-link  {{ request()->is('ventas/credit/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nota de Credito</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_ventas_debit')? 'd-none': '' }}">
                    <a href="{{ route('cdebit.index') }}"
                        class="nav-link  {{ request()->is('ventas/debit/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nota de Debito</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- COMPRAS / PROVEEDORES --}}
        <li
            class="nav-item {{ request()->is('compras/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_compras')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('compras/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-dolly"></i>
                <p>
                    Compras / Proveedores
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_compras_order')? 'd-none': '' }}">
                    <a href="{{ route('porder.index') }}"
                        class="nav-link {{ request()->is('compras/order/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Orden de Compra</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_compras_invoice')? 'd-none': '' }}">
                    <a href="{{ route('pinvoice.index') }}"
                        class="nav-link {{ request()->is('compras/invoice/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Registro de Compras</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_compras_credit')? 'd-none': '' }}">
                    <a href="{{ route('productfamily.index') }}"
                        class="nav-link  {{ request()->is('bpartner/report/move*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nota de Credito</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- CAJA Y BANCOS --}}
        <li
            class="nav-item {{ request()->is('bank/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_bank')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('bank/*') ? 'active' : '' }}">
                <i class="nav-icon fab fa-cc-visa"></i>
                <p>
                    Caja y Bancos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_bank_income')? 'd-none': '' }}">
                    <a href="{{ route('bincome.index') }}"
                        class="nav-link {{ request()->is('bank/income*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ingresos</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_bank_expense')? 'd-none': '' }}">
                    <a href="{{ route('bexpense.index') }}"
                        class="nav-link {{ request()->is('bank/expense*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Egresos</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_bank_allocate')? 'd-none': '' }}">
                    <a href="{{ route('ballocate.index') }}"
                        class="nav-link  {{ request()->is('bank/allocate*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Asignacion</p>
                    </a>
                </li>
            </ul>
        </li>
        
        {{-- LOGISTICA --}}
        <li
            class="nav-item {{ request()->is('logistic/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_logistic')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('logistic/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-truck"></i>
                <p>
                    Logistica
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_logistic_input')? 'd-none': '' }}">
                    <a href="{{ route('linput.index') }}"
                        class="nav-link {{ request()->is('logistic/input/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ingreso</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_logistic_outpu')? 'd-none': '' }}">
                    <a href="{{ route('loutput.index') }}"
                        class="nav-link {{ request()->is('logistic/output/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Salida</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_logistic_transfer')? 'd-none': '' }}">
                    <a href="{{ route('ltransfer.index') }}"
                        class="nav-link  {{ request()->is('logistic/transfer/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transferencia</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_logistic_inventory')? 'd-none': '' }}">
                    <a href="{{ route('linventory.index') }}"
                        class="nav-link  {{ request()->is('logistic/inventory/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Inventario</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_logistic_rpt_kardex')? 'd-none': '' }}">
                    <a href="{{ route('lkardex.index') }}"
                        class="nav-link  {{ request()->is('logistic/kardex/manager*') ? 'active' : '' }}">
                        <i class="fas fa-print nav-icon"></i>
                        <p>Kardex de Productos</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_logistic_rpt_stock')? 'd-none': '' }}">
                    <a href="{{ route('lstock.index') }}"
                        class="nav-link  {{ request()->is('logistic/stock/manager*') ? 'active' : '' }}">
                        <i class="fas fa-print nav-icon"></i>
                        <p>Stock de Productos</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- PRODUCCION --}}
        <li
            class="nav-item {{ request()->is('production/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_production')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('production/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-industry"></i>
                <p>
                    Produccion
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_production_order')? 'd-none': '' }}">
                    <a href="{{ route('product.index') }}"
                        class="nav-link {{ request()->is('production/order/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Orden Produccion</p>
                    </a>
                </li>
                <li class="nav-item  {{ !auth()->user()->menu('m_production_lfa')? 'd-none': '' }}">
                    <a href="{{ route('product.index') }}"
                        class="nav-link {{ request()->is('logistic/liquidation/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Liquidacion Fabricacion</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- UTILITY --}}
        <li
            class="nav-item {{ request()->is('tools/*') ? 'menu-open' : '' }} {{ !auth()->user()->menu('m_utility')? 'd-none': '' }}">
            <a href="#" class="nav-link {{ request()->is('tools/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tools"></i>
                <p>
                    Utilidades
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item  {{ !auth()->user()->menu('m_production_order')? 'd-none': '' }}">
                    <a href="{{ route('product.index') }}"
                        class="nav-link {{ request()->is('production/order/manager*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Partidas Abiertas</p>
                    </a>
                </li>
                
            </ul>
        </li>
        


        <li class="nav-header">
            <!-- LABELS -->
        </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Salir</p>
            </a>
        </li>
    </ul>
</nav>
