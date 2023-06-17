<?php include "layout/header.php" ?>
<?php require '../ADMIN/modelo/conect/conect_r.php'; ?>

<?php 
  $web_php = 'SELECT * FROM web WHERE id_web = 1';
  $resulta_web = $mysqli->query($web_php);
  $data_web = mysqli_fetch_assoc($resulta_web);
?>

<style>
  .carousel-item {
    background: -webkit-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto1']; ?>) no-repeat;
    background: -moz-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto1']; ?>) no-repeat;
    background: -ms-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto1']; ?>) no-repeat;
    background: linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto1']; ?>) no-repeat;
    background-size: cover;
  }

  .carousel-item.item2 {
    background: -webkit-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto2']; ?>) no-repeat;
    background: -moz-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto2']; ?>) no-repeat;
    background: -ms-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto2']; ?>) no-repeat;
    background: linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto2']; ?>) no-repeat;
    background-size: cover;
  }

  .carousel-item.item3 {
    background: -webkit-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto3']; ?>) no-repeat;
    background: -moz-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto3']; ?>) no-repeat;
    background: -ms-linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto3']; ?>) no-repeat;
    background: linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(../ADMIN/<?php echo $data_web['foto3']; ?>) no-repeat;
    background-size: cover;
  }
</style>

<!-- banner -->
<div class="banner">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      <!-- <li data-target="#carouselExampleIndicators" data-slide-to="3"></li> -->
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="carousel-item active">
        <div class="carousel-caption text-center">
          <h3>
          <?php echo $data_web['detalle1']; ?>
            <!-- <span>Cool summer sale 50% off</span> -->
          </h3>
          <!-- <a href="index.php" class="btn btn-sm animated-button gibson-three mt-4">Shop Now</a> -->
        </div>
      </div>
      <div class="carousel-item item2">
        <div class="carousel-caption text-center">
          <h3>
          <?php echo $data_web['detalle2']; ?>
            <!-- <span>Want to Look Your Best?</span> -->
          </h3>
          <!-- <a href="index.php" class="btn btn-sm animated-button gibson-three mt-4">Shop Now</a> -->
        </div>
      </div>
      <div class="carousel-item item3">
        <div class="carousel-caption text-center">
          <h3>
          <?php echo $data_web['detalle3']; ?>
            <!-- <span>Cool summer sale 50% off</span> -->
          </h3>
          <!-- <a href="index.php" class="btn btn-sm animated-button gibson-three mt-4">Shop Now</a> -->
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <!--//banner -->
</div>
</div>
<!--//banner-sec-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
  <div class="container-fluid">
    <div class="inner-sec-shop px-lg-4 px-3">
      <h3 class="tittle-w3layouts">Productos disponibles</h3>

      <div class="col-lg-6"> <label for="codigo_prod">Buscar producto...</label>
        <div class="input-group input-group-sm">
          <input type="text" id="buscar_prod" class="form-control" placeholder="Ingrese el nombre del producto">
          <span class="input-group-btn">
            <button type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </div>

      <div class="row p-3" id="unir_carrito">
        <!-- /womens -->
        <div class="col-md-3 product-men women_two">
          <div class="product-googles-info googles">
            <div class="men-pro-item">
              <div class="men-thumb-item">
                <img src="images/s1.jpg" class="img-fluid" alt="" />
                <div class="men-cart-pro">
                  <div class="inner-men-cart-pro">
                    <a href="single.html" class="link-product-add-cart">VISTA RÁPIDA</a>
                  </div>
                </div>
              </div>
              <div class="item-info-product">
                <div class="info-product-price">
                  <div class="grid_meta">
                    <div class="product_price">
                      <h4>
                        <a href="single.html">Farenheit (Grey)</a>
                      </h4>
                      <div class="grid-price mt-2">
                        <span class="money">$575.00</span>
                      </div>
                    </div>
                  </div>
                  <div class="googles single-item hvr-outline-out">
                    <form action="#" method="post">
                      <input type="hidden" name="cmd" value="_cart" />
                      <input type="hidden" name="add" value="1" />
                      <input type="hidden" name="googles_item" value="Farenheit" />
                      <input type="hidden" name="amount" value="575.00" />
                      <button type="submit" class="googles-cart pgoogles-cart">
                        <i class="fas fa-cart-plus"></i>
                      </button>
                    </form>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <ul class="pagination justify-content-center" id="pagination_pro">
      </ul>

      <!-- //////////////////////////// -->

      <hr>

      <div class="container-fluid">
        <div class="inner-sec-shop ">
          <!--/slide-->

          <!--//banner-sec-->
          <h3 class="tittle-w3layouts text-left my-lg-1 my-1">
            Productos en oferta
          </h3>

          <div class="col-lg-6"> <label for="codigo_prod">Buscar producto...</label>
            <div class="input-group input-group-sm">
              <input type="text" id="buscar_prod_oferta" class="form-control" placeholder="Ingrese el nombre del producto">
              <span class="input-group-btn">
                <button type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>

          <div class="mid-slider">
            <div class="row p-3" id="unir_carrito_oferta">


            </div>
          </div>

          <ul class="pagination justify-content-center" id="pagination_oferta">
          </ul>
        </div>
        <!--//slider-->
      </div>


      <div class="row galsses-grids pt-lg-5 pt-3">
        <div class="col-lg-6 galsses-grid-left">
          <figure class="effect-lexi">
            <img src="images/camara1.jpg" style="height: 400px;" alt="" class="img-fluid" />
            <figcaption>
              <h3>
                Mejor
                <span>Calidad</span>
              </h3>
              <!-- <p>Express your style now.</p> -->
            </figcaption>
          </figure>
        </div>
        <div class="col-lg-6 galsses-grid-left">
          <figure class="effect-lexi">
            <img src="images/camara2.jpg" style="height: 400px;" alt="" class="img-fluid" />
            <figcaption>
              <h3>
                Instalación
                <span>Inmediata</span>
              </h3>
              <!-- <p>Express your style now.</p> -->
            </figcaption>
          </figure>
        </div>
      </div>
      <!-- /grids -->
      <div class="bottom-sub-grid-content py-lg-5 py-3">
        <div class="row">
          <div class="col-lg-4 bottom-sub-grid text-center">
            <div class="bt-icon">
              <span class="far fa-hand-paper"></span>
            </div>

            <h4 class="sub-tittle-w3layouts my-lg-4 my-3">
              Satisfacción garantizada
            </h4>
          </div>
          <!-- /.col-lg-4 -->
          <div class="col-lg-4 bottom-sub-grid text-center">
            <div class="bt-icon">
              <span class="fas fa-rocket"></span>
            </div>

            <h4 class="sub-tittle-w3layouts my-lg-4 my-3">Envío rápido</h4>
          </div>
          <!-- /.col-lg-4 -->
          <div class="col-lg-4 bottom-sub-grid text-center">
            <div class="bt-icon">
              <span class="far fa-sun"></span>
            </div>

            <h4 class="sub-tittle-w3layouts my-lg-4 my-3">Intalación inmediata</h4>
          </div>
          <!-- /.col-lg-4 -->
        </div>
      </div>
      <!-- //grids -->

      <?php include "layout/footer.php" ?>

      <script>
        pagination_carrito(1);
        pagination_carrito_oferta(1);
      </script>