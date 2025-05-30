<?php
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Beardi | www.beardi.com</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">Ferreteria Beardi</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Ferreteria Beardi</b></span>
        </a>
        

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                   
                      <small class="hidden-xs"><?php echo $_SESSION['razon_social']; ?></small>
                   
                  </li>

                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>

                  </li>
                </ul>
               </li>     
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php 
            if ($_SESSION['escritorio']==1)
            {
              echo '<li>
              <a href="escritorio.php">
                <i class="fa fa-tasks"></i> <span>Escritorio</span>
              </a>
            </li>';
            }
            ?>
            <?php 
            if ($_SESSION['configuracion']==1)
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i>
                <span>Configuración</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="general.php"><i class="fa fa-circle-o"></i> General</a></li>
                <li><a href="sucursal.php"><i class="fa fa-circle-o"></i> Sucursales</a></li>
                <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                <li><a href="role.php"><i class="fa fa-circle-o"></i> Roles</a></li>
              </ul>
            </li>';
            }
            ?>

            <?php 
            if ($_SESSION['stock']==1)
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Control de Stock</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Artículos</a></li>
                <li><a href="unidad_medida.php"><i class="fa fa-circle-o"></i> Unidades de medidas</a></li>
              </ul>
            </li>';
            }
            ?>

            <?php 
            if ($_SESSION['compras']==1)
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Compras</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="comprarealizada.php"><i class="fa fa-circle-o"></i> Compras Realizadas</a></li>
                <li><a href="pedido.php"><i class="fa fa-circle-o"></i> Pedidos</a></li>
                <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
              </ul>
            </li>';
            }
            ?>
            
            <?php 
            if ($_SESSION['ventas']==1)
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Ventas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
              </ul>
            </li>';
            }
            ?>
            
            <?php 
            if ($_SESSION['reportes']==1)
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="rptventastotales.php"><i class="fa fa-circle-o"></i>Ventas Totales por Vendedor</a></li>
                <li><a href="rptventa.php"><i class="fa fa-circle-o"></i>Ventas Totales por Vendedor Porcentaje</a></li>
                <li><a href="rptcomprastotales.php"><i class="fa fa-circle-o"></i>Compras Totales por Cajero </a></li>
              </ul>
            </li>';
            }
            ?>    
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>