<?php include "layout/header.php" ?>

<!-- banner -->
<div class="banner_inner">
    <div class="services-breadcrumb">
        <div class="inner_breadcrumb">
            <ul class="short">
                <li>
                    <a href="index.php">INICIO</a>
                    <i>|</i>
                </li>
                <li>OFERTAS</li>
            </ul>
        </div>
    </div>
</div>

<!--//banner -->
<!--/shop-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
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
</section>


<?php include "layout/footer.php" ?>

<script>
    pagination_carrito_oferta(1);
</script>