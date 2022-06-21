<?php echo $header; ?>
<link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />

<body class="bg-body" id="body-home">

    <main>
        <div class="barra-verde"></div>
        <nav class="navbar navbar-main navbar-expand-lg bg-gradient-yellow position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-3 text-dark" href="javascript:;">
                                <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>shop </title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(0.000000, 148.000000)">
                                                    <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                                    <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item text-sm"><a class="opacity-10 text-dark" href="javascript:;">Inicio</a></li>

                    </ol>


                </nav>

                <div id="cont_menu_end">

                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Account" class="nav-link text-body font-weight-bold  mx-0  px-0">
                                <i class="fa fa-user me-sm-0"></i>

                                <?php
                                $apellido = $datos['surname'];
                                $arr1 = str_split($apellido);

                                ?>
                                <span class="d-sm-inline "><?php echo $datos['name_user'] . " " . $arr1[0] . "."; ?></span>
                            </a>
                        </li>

                        <li class="nav-item d-flex align-items-center">
                            <a href="/Login/cerrarSession" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-power-off me-sm-1"></i>
                                <span class="d-sm-inline ">Logout</span>
                            </a>
                        </li>

                    </ul>

                </div>

                <input type="hidden" name="datos" id="datos" value="<?php echo $datos; ?>">
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group"></div>
                    </div>

                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Account" class="nav-link text-body font-weight-bold mx-lg-4 mx-0  px-0">
                                <i class="fa fa-user me-sm-0"></i>
                                <!-- <span class="d-sm-inline d-none">Mi Cuenta</span> -->
                                <?php
                                $apellido = $datos['surname'];
                                $arr1 = str_split($apellido);

                                ?>
                                <span class="d-sm-inline "><?php echo $datos['name_user'] . " " . $arr1[0] . "."; ?></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Login/cerrarSession" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-power-off me-sm-1"></i>
                                <span class="d-sm-inline ">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


        </nav>

        <div class="container-fluid py-0">
            <div class="card col-lg-12 mt-lg-4 mt-1">
                <div class="card-header pb-0 p-3">
                    <p style="font-size: 14px">(Seleccione a continuación lo que desea pagar y presione el boton de pagar y muestre el codigo de pago en caja)</p>
                </div>
                <div class="card-body px-5 pb-5">



                    <div class="row">
                        <div class="col-md-8">

                            <div id="cont-checks">

                                <?php echo $checks ?>


                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div id="buttons">
                                        <input type="hidden" id="tipo_cambio" value="<?= $tipo_cambio ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>Productos agregados: <span id="productos_agregados"><?= $total_productos ?></span></p>

                                            </div>

                                            <div class="col-md-6">
                                                <p>Su pago en dolares es: $ <span id="total"><?= $total_pago ?></span> USD</p>

                                                <p>Su pago en pesos mexicanos es: $ <span id="total_mx"><?= $total_pago_mx ?></span> </p>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-12">

                                    <div id="buttons">

                                        <div class="row">
                                            <div class="col-md-6">


                                            </div>

                                            <div class="col-md-6" style="display: flex; justify-content: end;">

                                                <button class="btn btn-primary" id="btn_pago" <?= $btn_block ?>>Proceder al pago</button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div id="cont-image">
                                <img src="<?= $src_qr ?>" id="img_qr" style="width: auto; display: block; margin: 0 auto;<?= $ocultar ?>" alt="">
                                <input type="hidden" id="clave" name="clave" value="<?= $clave ?>">

                            </div>
                            <div style="display: flex; justify-content: center;">
                                <?= $btn_imp ?>
                            </div>
                        </div>

                    </div>
                    <br>



                    <br>
                    <div class="row">
                        <div class="col-md-8">

                            <div id="buttons">


                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        

                                    </div>

                                    <div class="col-md-6" style="display: flex; justify-content: end;">
                                        <div class="form-group">
                                            <label>Elige tu metodo de pago *</label>
                                            <select class="multisteps-form__select form-control all_input_second_select metodo_pago" name="metodo_pago" id="metodo_pago" required>
                                                <option value="" disabled selected>Selecciona una Opción</option>
                                                <option value="Paypal">Paypal</option>
                                                <option value="Efectivo">Efectivo / Transferencia electrónica</option>
                                            </select>
                                        </div>
                                    </div>
                               </div> -->


                            </div>
                        </div>
                    </div>


                    <br>




                    <!-- <div class="table-responsive p-0">
                                        <table class="align-items-center mb-0 table table-borderless" style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Productos</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Costo</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><i class="fa fa-eye"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $tabla; ?>
                                        </tbody>
                                    </table>
                                </div>  -->

                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        $(document).ready(function() {

            // var precios=<?php echo json_encode($array_precios); ?>;

            var precios = [];
            var productos = [];
            var total = 0;

            // if (precios.length <= 0) {

            //     $("#btn_pago").attr('disabled','disabled');

            // }

            // console.log(precios_anteriores);

            // console.log(precios_anteriores.length);

            $(".checks_product").on("change", function() {
                var id_product = $(this).val();
                var precio = $(this).attr('data-precio');
                var cantidad = $("#numero_articulos" + id_product).val();
                var nombre_producto = $(this).attr('data-nombre-producto');



                if (this.checked) {

                    precios.push({
                        'id_product': id_product,
                        'precio': precio,
                        'cantidad': cantidad
                    });
                    sumarPrecios(precios);

                    productos.push({
                        'id_product': id_product,
                        'precio': precio,
                        'cantidad': cantidad,
                        'nombre_producto': nombre_producto
                    });

                } else if (!this.checked) {

                    for (var i = 0; i < precios.length; i++) {

                        if (precios[i].id_product === id_product) {
                            console.log("remover");
                            precios.splice(i, 1);

                            productos.splice(i, 1);
                        } else if (precios[i].id_product === id_product && precios[i].cantidad === cantidad) {
                            precios.splice(i, 1);

                            productos.splice(i, 1);

                        }
                    }

                    $.ajax({
                        url: "/Home/removePendientesPago",
                        type: "POST",
                        data: {
                            id_product,cantidad
                        },
                        cache: false,
                        beforeSend: function() {
                            console.log("Procesando....");

                        },
                        success: function(respuesta) {

                            console.log(respuesta);
                            if(respuesta == "success"){
                                location.reload();
                            }

                            // if (respuesta.status == 'success') {
                            //     $("#img_qr").attr("src", respuesta.src);
                            //     $("#img_qr").css('display', 'block');
                            //     Swal.fire("¡Mantenga a la mano su codigo QR para pagar en linea de cajas!", "", "success").
                            //     then((value) => {
                            //         window.location.reload();
                            //     });
                            // }

                        },
                        error: function(respuesta) {
                            console.log(respuesta);
                        }

                    });
                }
                console.log(productos);
                sumarPrecios(precios);

            });

            $(".select_numero_articulos").on("change", function() {
                var id_producto = $(this).attr('data-id-producto');
                var cantidad = $(this).val();
                var precio = $(this).attr('data-precio');
                var nombre_producto = $(this).attr('data-nombre-producto');

                if ($("#check_curso_" + id_producto).is(':checked')) {

                    for (var i = 0; i < precios.length; i++) {

                        if (precios[i].id_product === id_producto && precios[i].cantidad != cantidad) {
                            console.log("remover");
                            precios.splice(i, 1, {
                                'id_product': id_producto,
                                'precio': precio,
                                'cantidad': cantidad
                            });

                            productos.splice(i, 1, {
                                'id_product': id_producto,
                                'precio': precio,
                                'cantidad': cantidad,
                                'nombre_producto': nombre_producto
                            });

                            // precios.push({'id_product':id_product,'precio':precio,'cantidad':cantidad});
                        }

                    }
                    console.log(precios.length);

                    console.log(productos);

                    sumarPrecios(precios);

                }

            });

            function sumarPrecios(precios) {
                console.log(precios);

                var sumaPrecios = <?= $total_pago ?>;
                var sumaArticulos = <?= $total_productos ?>;

                precios.forEach(function(precio, index) {

                    console.log("precio " + index + " | id_product: " + precio.id_product + " precio: " + parseInt(precio.precio) + " cantidad: " + parseInt(precio.cantidad))

                    sumaPrecios += parseInt(precio.precio * precio.cantidad);
                    sumaArticulos += parseInt(precio.cantidad);

                });

                console.log("Suma precios " + sumaPrecios);

                $("#total").html(sumaPrecios);

                $("#total_mx").html(($("#tipo_cambio").val() * sumaPrecios).toFixed(2));

                console.log("Suma Articulos " + sumaArticulos);

                $("#productos_agregados").html(sumaArticulos);

            }

            $("#btn_pago").on("click", function(event) {
                event.preventDefault();
                // var metodo_pago = $("#metodo_pago").val();
                var clave = $("#clave").val();

                if (precios.length <= 0) {

                    Swal.fire("¡Debes seleccionar al menos un producto!", "", "warning")
                   

                } else {
                    var plantilla_productos = '';

                    plantilla_productos += `<ul>`;


                    $.each(productos, function(key, value) {
                        console.log("funcioina");
                        console.log(value);
                        plantilla_productos += `<li style="text-align: justify; font-size:14px;">
                                                    ${value.nombre_producto} Cant. ${value.cantidad}
                                                </li>`;
                    });

                    plantilla_productos += `</ul>`;
                    plantilla_productos += `<p><strong>Total en dolares: $ ${$("#total").text()} USD </strong></p>`;
                    plantilla_productos += `<p><strong>Total en pesos mexicanos: $ ${$("#total_mx").text()}</strong></p>`;

                    plantilla_productos += `<p>Confirme su selección y de clic en procesar compra y espere su turno en línea de cajas.</p>`;


                    Swal.fire({
                        title: 'Usted selecciono los siguientes productos',
                        text: '',
                        html: plantilla_productos,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Procesar Compra'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "/Home/generaterQr",
                                type: "POST",
                                data: {
                                    'array': JSON.stringify(precios),
                                    clave
                                },
                                cache: false,
                                dataType: "json",
                                // contentType: false,
                                // processData: false,
                                beforeSend: function() {
                                    console.log("Procesando....");

                                },
                                success: function(respuesta) {

                                    console.log(respuesta);

                                    if (respuesta.status == 'success') {
                                        $("#img_qr").attr("src", respuesta.src);
                                        $("#img_qr").css('display', 'block');
                                        Swal.fire("¡Mantenga a la mano su codigo QR para pagar en linea de cajas!", "", "success").
                                        then((value) => {
                                            window.location.reload();
                                        });
                                    }

                                },
                                error: function(respuesta) {
                                    console.log(respuesta);
                                }

                            });
                        }
                    })
                }
            });


        });
    </script>


</body>