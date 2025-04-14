<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['compras']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Compra     </h1></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>ID Compra</th>
                            <th>ID Pedido</th>
                            <th>Proveedor</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>ID Compra</th>
                            <th>ID Pedido</th>
                            <th>Proveedor</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                        
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="hidden" name="idcompra" id="idcompra">
                            <input type="date" class="form-control" name="fecha" id="fecha" required="">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                               <option value="Boleta">Boleta</option>
                               <option value="Factura">Factura</option>
                               <option value="Ticket">Ticket</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Serie:</label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="10" placeholder="Serie">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Número:</label>
                            <input type="text" class="form-control" name="nro_comprobante" id="nro_comprobante" maxlength="10" placeholder="Número" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Impuesto:</label>
                            <input type="text" class="form-control" name="impuesto" id="impuesto" required="">
                          </div>
                          <?php
                          $v1=$_GET['id'];
                          $v2=$_GET['idp'];
                          $v3=$_GET['mt'];
                         ?>
                         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro Pedido:</label>
                            <input type="text" class="form-control" name="idpedido" id="idpedido" value=<?php echo $v1 ?>>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Nro Proveedor:</label>
                            <input type="text" class="form-control" name="idproveedor" id="idproveedor" value=<?php echo $v2 ?>>
                          </div>
                               <button  class="btn btn-success" onclick="mostrarpedido(<?php echo $v1 ?>)"><i class="fa fa-plus-circle"></i> Ver Detalle</button>
                                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" >
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Gs/.0.00 </h4><input type="hidden" name=total_compra id="total_compra"></th> 
                                </tfoot>
                                <tbody>
                                  
                                </tbody>
                            </table>
                            

                          </div>
                        
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Total Compra Gs:</label>
                            <input type="text" class="form-control" name="total_compra" id="total_compra" value=<?php echo $v3 ?>>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>


                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/compra.js"></script>
<?php 
}
ob_end_flush();
?>