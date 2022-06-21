<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

use \Core\View;
use \Core\Controller;
use \App\models\Home AS HomeDao;
use App\models\RegistroAcceso as RegistroAccesoDao;
use \App\models\Talleres as TalleresDao;

class Home extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function index() {
     $extraHeader =<<<html
      <link id="pagestyle" href="/assets/css/style.css" rel="stylesheet" />
      <title>
            Home
      </title>
html;

        $data_user = HomeDao::getDataUser($this->__usuario);

        $productos_pendientes_comprados = HomeDao::getProductosPendComprados($data_user['user_id']);
        $checks = '';
        $total_productos = 0;
        $total_pago = 0;
        $check_disabled = '';
        $array_precios = [];

        $clave = HomeDao::getProductosPendCompradosClave($data_user['user_id'])[0]['clave'];


        if($clave != ""){
            $src_qr = '/qrs/'.$productos_pendientes_comprados[0]['clave'].'.png';
            // $src_qr = '/qrs/'.$clave.'.png';           
            // $btn_block = 'style = "display:none"';
            // $check_disabled = 'disabled';
        }else{
            $src_qr = '';
            $btn_block = '';
            
        }   

        

        foreach($productos_pendientes_comprados as $key => $value) {
            $disabled = '';
            $checked = '';
            $pend_validar ='';

            if($value['es_congreso'] == 1 && $value['clave_socio'] == ""){
                $precio = $value['amout_due'];
            }elseif($value['es_congreso'] == 1 && $value['clave_socio'] != ""){
                $precio = $value['amout_due'];
            }
            else if($value['es_servicio'] == 1 && $value['clave_socio'] == ""){
                $precio = $value['precio_publico'];
            }else if($value['es_servicio'] == 1 && $value['clave_socio'] != ""){
                $precio = 0;
            }
            else if($value['es_curso'] == 1  && $value['clave_socio'] == ""){
                $precio = $value['precio_publico'];
            }else if($value['es_curso'] == 1  && $value['clave_socio'] != ""){
                $precio = 0;
            }
            
            $count_producto = HomeDao::getCountProductos($_SESSION['user_id'],$value['id_producto'])[0];

            

            if($value['estatus_compra'] == 1){
                $disabled = 'disabled';
                $checked = 'checked';
                $pend_validar ='Pagado y validado por APM';
                // $btn_imp = '';
                $productos_pendientes_comprados[0]['clave'].'" target="blank_">Imprimir Formato de Pago</a>';
                // $ocultar = 'display:none;';
                
            }else if($value['estatus_compra'] == null){
                $pend_validar = 'Pendiente de validar';
                $btn_imp = '<a class="btn btn-primary" href="/Home/print/'.$productos_pendientes_comprados[0]['clave'].'" target="blank_">Imprimir Formato de Pago</a>';
                $ocultar = '';
                // $disabled = 'disabled';
                $checked = 'checked';
                $total_productos += $count_producto['numero_productos'];
                $total_pago += $count_producto['numero_productos'] * $precio;
                array_push($array_precios,['id_product'=>$value['id_producto'],'precio'=>$precio,'cantidad'=>$count_producto['numero_productos']]);
            }

            if($value['max_compra'] <= 1){
                $numero_productos = '<input type="number" id="numero_articulos'.$value['id_producto'].'" name="numero_articulos" value="'.$value['max_compra'].'" style="border:none;" readonly>';
            }else{
                $numero_productos = '<select class="form-control select_numero_articulos" id="numero_articulos'.$value['id_producto'].'" name="numero_articulos" data-id-producto="'.$value['id_producto'].'" data-precio="'.$precio.'" data-nombre-producto="'.$value['nombre_producto'].'" '.$disabled.'>';
                for($i = 1; $i <= $value['max_compra']; $i++){                    
                    $numero_productos .= '<option value="'.$i.'">'.$i.'</option>';                
                }
                $numero_productos .= '</select>';
            }

            $checks .= <<<html
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input checks_product" type="checkbox" value="{$value['id_producto']}" id="check_curso_{$value['id_producto']}" name="checks_cursos[]" {$disabled} {$checked} data-precio="{$precio}" data-nombre-producto="{$value['nombre_producto']}">
                            <label class="form-check-label" for="check_curso_{$value['id_producto']}">
                                {$value['nombre_producto']} <span style="font-size: 13px; text-decoration: underline; color: green;">{$pend_validar} - No. productos {$count_producto['numero_productos']}</span>
                            </label>
                        </div>
                    </div>
                   
                    <div class="col-md-2">
                        {$precio} - {$value['tipo_moneda']}
                    </div>

                    <div class="col-md-2">
                        {$numero_productos}
                    </div>
                </div>

                <hr>
                  
html;            
                $numero_productos = '';

        }

        $productos_no_comprados = HomeDao::getProductosNoComprados($data_user['user_id']);

        foreach($productos_no_comprados as $key => $value) {

            
            // if($data_user['amout_due'] != null || $data_user['amout_due'] != ''){

                // if($value['es_congreso'] == 1){
                //     $precio = $data_user['amout_due'];
                // }else if($value['es_servicio'] == 1){
                //     $precio = $value['precio_publico'];
                // }else if($value['es_curso'] == 1){
                //     $precio = $value['precio_publico'];
                // }
            // }else{
            //     $precio = $value['precio_publico'];
            // }

            if($value['es_congreso'] == 1 && $value['clave_socio'] == ""){
                $precio = $value['amout_due'];
            }elseif($value['es_congreso'] == 1 && $value['clave_socio'] != ""){
                $precio = $value['amout_due'];
            }
            else if($value['es_servicio'] == 1 && $value['clave_socio'] == ""){
                $precio = $value['precio_publico'];
            }else if($value['es_servicio'] == 1 && $value['clave_socio'] != ""){
                $precio = 0;
            }
            else if($value['es_curso'] == 1  && $value['clave_socio'] == ""){
                $precio = $value['precio_publico'];
            }else if($value['es_curso'] == 1  && $value['clave_socio'] != ""){
                $precio = 0;
            }

            if($value['max_compra'] <= 1){
                $numero_productos = '<input type="number" id="numero_articulos'.$value['id_producto'].'" name="numero_articulos" value="'.$value['max_compra'].'" style="border:none;" readonly>';
            }else{
                $numero_productos = '<select class="form-control select_numero_articulos" id="numero_articulos'.$value['id_producto'].'" name="numero_articulos" data-id-producto="'.$value['id_producto'].'"  data-precio="'.$precio.'" data-nombre-producto="'.$value['nombre_producto'].'">';
                for($i = 1; $i <= $value['max_compra']; $i++){                    
                    $numero_productos .= '<option value="'.$i.'">'.$i.'</option>';                
                }
                $numero_productos .= '</select>';
            }
            
            $checks .= <<<html

            <div class="row">
                <div class="col-md-8">
                    <div class="form-check">
                        <input class="form-check-input checks_product" type="checkbox" value="{$value['id_producto']}" id="check_curso_{$value['id_producto']}" name="checks_cursos[]" data-precio="{$precio}" data-nombre-producto="{$value['nombre_producto']}" {$check_disabled}>
                        <label class="form-check-label" for="check_curso_{$value['id_producto']}">
                            {$value['nombre_producto']}
                        </label>
                    </div>
                </div>
               
                <div class="col-md-2">
                    {$precio} - {$value['tipo_moneda']}
                </div>

                <div class="col-md-2">
                       {$numero_productos}
                </div>

            </div>

            <hr>
            
               
html;            
            $numero_productos = '';

        }

        $tipo_cambio = HomeDao::getTipoCambio();

        $total_mx = intval($total_pago) * floatval($tipo_cambio['tipo_cambio']);

        // var_dump($array_precios);
        // exit;

        // var_dump($tipo_cambio['tipo_cambio']);
        // exit;
        //las dos lineas de arriba son para sacar el tipo de cambio por posicion

        // if($src_qr != ''){
        //     // $btn_imp = '<a class="btn btn-primary" onclick="javascript:window.print();">Imprimir</a>';
        //     $btn_imp = '<a class="btn btn-primary" href="/Home/print/'.$productos_pendientes_comprados[0]['clave'].'" target="blank_">Imprimir</a>';
        //     $ocultar = '';
        // }else{
        //     $btn_imp = '';
        //     $ocultar = 'display:none;';
        // }
  
        View::set('header',$this->_contenedor->header($extraHeader));   
        View::set('datos',$data_user);
        View::set('clave',$clave);    
        View::set('checks',$checks);
        View::set('src_qr',$src_qr); 
        View::set('btn_block',$btn_block); 
        View::set('total_productos',$total_productos); 
        View::set('total_pago',$total_pago); 
        View::set('total_pago_mx',$total_mx); 
        View::set('btn_imp',$btn_imp); 
        View::set('ocultar',$ocultar);
        View::set('tipo_cambio',$tipo_cambio['tipo_cambio']);
        View::set('array_precios',$array_precios);
        View::render("principal_all");
    }

    public function removePendientesPago(){
        // echo $_POST['id_product'];
        // echo $_POST['cantidad'];

        $delete = TalleresDao::deletePendientesProductosByUser($_SESSION['user_id'],$_POST['id_product']);

        if($delete){
            echo "success";
        }else{
            echo "fail";
        }
    }

    public function generateModalComprar($datos){
        $modal = <<<html
        <div class="modal fade" id="comprar-curso{$datos['id_curso']}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                Comprar curso
                </h5>

                <span type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
html;



        return $modal;
    }

    public function getData(){
      echo $_POST['datos'];
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function generaterQr(){

        $bandera = false;

        if(!empty($_POST['clave'])){
            $clave = $_POST['clave'];            
        }else{
            $clave = $this->generateRandomString();           
        }
       
        $datos = json_decode($_POST['array'],true);

        $datos_user = HomeDao::getDataUser($this->getUsuario());
        // $metodo_pago = $_POST['metodo_pago'];
        
        $user_id = $datos_user['user_id'];
        $reference = $datos_user['reference'];
        // $tipo_pago = $metodo_pago;
        $fecha =  date("Y-m-d");


       foreach($datos as $key => $value){                       
        

            for($i = 1; $i <= $value['cantidad']; $i++){
                $documento = new \stdClass();
            
                $id_producto = $value['id_product'];  
                $monto = $value['precio'];                
                $status = 0;

                $documento->_id_producto = $id_producto;
                $documento->_user_id = $user_id;
                $documento->_reference = $reference;
                $documento->_fecha = $fecha;
                $documento->_monto = $monto;
                // $documento->_tipo_pago = $tipo_pago;
                $documento->_clave = $clave;
                $documento->_status = $status;

                $id = TalleresDao::inserPendientePago($documento); 

                if($id){
                    $bandera = true;
                }

                // echo 'Se inserta '.$i. 'veces' .' la cantidad '.$value['cantidad'];
                // echo "<br>";
            }
       }

       if($bandera){

        $config = array(
            'ecc' => 'H',    // L-smallest, M, Q, H-best
            'size' => 12,    // 1-50
            'dest_file' => '../public/qrs/'.$clave.'.png',
            'quality' => 90,
            'logo' => 'logo.jpg',
            'logo_size' => 100,
            'logo_outline_size' => 20,
            'logo_outline_color' => '#FFFF00',
            'logo_radius' => 15,
            'logo_opacity' => 100,
          );
    
          // Contenido del código QR
          $data = $clave;
    
          // Crea una clase de código QR
          $oPHPQRCode = new PHPQRCode();
    
          // establecer configuración
          $oPHPQRCode->set_config($config);
    
          // Crea un código QR
          $qrcode = $oPHPQRCode->generate($data);
    
        //   $url = explode('/', $qrcode );
          $src = '../qrs/'.$clave.'.png';
            
              
        $res = [
            'status' => 'success',
            'src' => $src,
            'code' => $clave

        ];
        

       }else{
        $res = [
            'status' => 'fail'

        ];
        
        
       }
       
       echo json_encode($res);
       
    }

    public function print($clave)
    {
        date_default_timezone_set('America/Mexico_City');

        // $this->generaterQr($clave);

        $datos_user = HomeDao::getDataUser($this->getUsuario());
        $user_id = $datos_user['user_id'];
        


        $productos = TalleresDao::getProductosPendientesPagoTicketSitio($user_id);

        
        $reference = $productos[0]['reference'];
        $fecha = $productos[0]['fecha'];
        
        $nombre_completo = $datos_user['name_user'] . " " . $datos_user['middle_name'] . " " . $datos_user['surname'] . " " . $datos_user['second_surname'];


        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('constancias/plantillas/ticket_esp.jpeg', 0, 0, 210, 300);
        
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        //$pdf->Image('1.png', 1, 0, 190, 190);
        $pdf->SetFont('Arial', 'B', 5);    //Letra Arial, negrita (Bold), tam. 20
        //$nombre = utf8_decode("Jonathan Valdez Martinez");
        //$num_linea =utf8_decode("Línea: 39");
        //$num_linea2 =utf8_decode("Línea: 39");

        $espace = 140;
        $total = array();
        foreach($productos as $key => $value){            
            
            
            // if($value['es_congreso'] == 1){
            //     $precio = $value['amout_due'];
            // }else if($value['es_servicio'] == 1){
            //     $precio = $value['precio_publico'];
            // }else if($value['es_curso'] == 1){
            //     $precio = $value['precio_publico'];
            // }

            if($value['es_congreso'] == 1 && $value['clave_socio'] == ""){
                $precio = $value['amout_due'];
                $socio = "";
            }elseif($value['es_congreso'] == 1 && $value['clave_socio'] != ""){
                $precio = $value['amout_due'];
                $socio = "";
            }
            else if($value['es_servicio'] == 1 && $value['clave_socio'] == ""){
                $precio = $value['precio_publico'];
                $socio = "";
            }else if($value['es_servicio'] == 1 && $value['clave_socio'] != ""){
                $precio = 0;
                $socio = "Socio APM - Sin Costo";
            }
            else if($value['es_curso'] == 1  && $value['clave_socio'] == ""){
                $precio = $value['precio_publico'];
            }else if($value['es_curso'] == 1  && $value['clave_socio'] != ""){
                $precio = 0;
                $socio = "Socio APM - Sin Costo";
            }
            

            $total_productos = TalleresDao::getCountProductos($user_id,$value['id_producto'])[0];

            $count_productos = $total_productos['numero_productos'];

            // array_push($total,$precio);
            array_push($total,($precio * $count_productos));


            //Nombre Curso
            $pdf->SetXY(22, $espace);
            $pdf->SetFont('Arial', 'B', 8);  
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(100, 4, utf8_decode($value['nombre']) ." - cant.".$count_productos." - ".$socio, 0, 'C');

            //Costo
            $pdf->SetXY(125, $espace);
            $pdf->SetFont('Arial', 'B', 8);  
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(100, 4, '$ '.number_format(($precio * $count_productos),2).' ' .$value['tipo_moneda'], 0, 'C');

            $espace = $espace + 8;
        }

        $tipo_cambio = HomeDao::getTipoCambio()['tipo_cambio'];
        // echo $tipo_cambio;
        // exit;

        //folio
        $pdf->SetXY(92, 60.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $reference, 0, 'C');

        //fecha
        $pdf->SetXY(90, 70.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $fecha, 0, 'C');

      

        //total dolares
        $pdf->SetXY(125, 202);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, number_format(array_sum($total)).' USD', 0, 'C');

        //total pesos
        $pdf->SetXY(125, 210.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, '$ '.number_format($tipo_cambio * array_sum($total),2), 0, 'C');

        //imagen Qr
        $pdf->Image('qrs/'.$clave.'.png' , 152 ,245, 35 , 38,'PNG');


        $pdf->Output();
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }

}


class PHPQRCode{ // class start

    /** Configuración predeterminada */
    private $_config = array(
        'ecc' => 'H',                       // Calidad del código QR L-menor, M, Q, H-mejor
        'size' => 15,                       // Tamaño del código QR 1-50
        'dest_file' => '',        // Ruta de código QR creada
        'quality' => 100,                    // Calidad de imagen
        'logo' => '',                       // Ruta del logotipo, vacío significa que no hay logotipo
        'logo_size' => null,                // tamaño del logotipo, nulo significa que se calcula automáticamente de acuerdo con el tamaño del código QR
        'logo_outline_size' => null,        // Tamaño del trazo del logotipo, nulo significa que se calculará automáticamente de acuerdo con el tamaño del logotipo
        'logo_outline_color' => '#FFFFFF',  // color del trazo del logo
        'logo_opacity' => 100,              // opacidad del logo 0-100
        'logo_radius' => 0,                 // ángulo de empalme del logo 0-30
    );
  
    
    public function set_config($config){
  
        // Permitir configurar la configuración
        $config_keys = array_keys($this->_config);
  
        // Obtenga la configuración entrante y escriba la configuración
        foreach($config_keys as $k=>$v){
            if(isset($config[$v])){
                $this->_config[$v] = $config[$v];
            }
        }
  
    }
  
    /**
           * Crea un código QR
     * @param    Contenido del código QR String $ data
     * @return String
     */
    public function generate($data){
  
        // Crea una imagen de código QR temporal
        $tmp_qrcode_file = $this->create_qrcode($data);
  
        // Combinar la imagen del código QR temporal y la imagen del logotipo
        $this->add_logo($tmp_qrcode_file);
  
        // Eliminar la imagen del código QR temporal
        if($tmp_qrcode_file!='' && file_exists($tmp_qrcode_file)){
            unlink($tmp_qrcode_file);
        }
  
        return file_exists($this->_config['dest_file'])? $this->_config['dest_file'] : '';
  
    }
  
    /**
           * Crea una imagen de código QR temporal
     * @param    Contenido del código QR String $ data
     * @return String
     */
    private function create_qrcode($data){
  
        // Imagen de código QR temporal
        $tmp_qrcode_file = dirname(__FILE__).'/tmp_qrcode_'.time().mt_rand(100,999).'.png';
  
        // Crea un código QR temporal
        \QRcode::png($data, $tmp_qrcode_file, $this->_config['ecc'], $this->_config['size'], 2);
  
        // Regresar a la ruta temporal del código QR
        return file_exists($tmp_qrcode_file)? $tmp_qrcode_file : '';
  
    }
  
    /**
           * Combinar imágenes de códigos QR temporales e imágenes de logotipos
     * @param  String $ tmp_qrcode_file Imagen de código QR temporal
     */
    private function add_logo($tmp_qrcode_file){
  
        // Crear carpeta de destino
        $this->create_dirs(dirname($this->_config['dest_file']));
  
        // Obtener el tipo de imagen de destino
        $dest_ext = $this->get_file_ext($this->_config['dest_file']);
  
        // Necesito agregar logo
        if(file_exists($this->_config['logo'])){
  
            // Crear objeto de imagen de código QR temporal
            $tmp_qrcode_img = imagecreatefrompng($tmp_qrcode_file);
  
            // Obtener el tamaño de la imagen del código QR temporal
            list($qrcode_w, $qrcode_h, $qrcode_type) = getimagesize($tmp_qrcode_file);
  
            // Obtener el tamaño y el tipo de la imagen del logotipo
            list($logo_w, $logo_h, $logo_type) = getimagesize($this->_config['logo']);
  
            // Crea un objeto de imagen de logo
            switch($logo_type){  
                case 1: $logo_img = imagecreatefromgif($this->_config['logo']); break;  
                case 2: $logo_img = imagecreatefromjpeg($this->_config['logo']); break;  
                case 3: $logo_img = imagecreatefrompng($this->_config['logo']); break;  
                default: return '';  
            }
  
            // Establezca el tamaño combinado de la imagen del logotipo, si no se establece, se calculará automáticamente de acuerdo con la proporción
            $new_logo_w = isset($this->_config['logo_size'])? $this->_config['logo_size'] : (int)($qrcode_w/5);
            $new_logo_h = isset($this->_config['logo_size'])? $this->_config['logo_size'] : (int)($qrcode_h/5);
  
            // Ajusta la imagen del logo según el tamaño establecido
            $new_logo_img = imagecreatetruecolor($new_logo_w, $new_logo_h);
            imagecopyresampled($new_logo_img, $logo_img, 0, 0, 0, 0, $new_logo_w, $new_logo_h, $logo_w, $logo_h);
  
            // Determinar si se necesita un golpe
            if(!isset($this->_config['logo_outline_size']) || $this->_config['logo_outline_size']>0){
                list($new_logo_img, $new_logo_w, $new_logo_h) = $this->image_outline($new_logo_img);
            }
  
            // Determine si se necesitan esquinas redondeadas
            if($this->_config['logo_radius']>0){
                $new_logo_img = $this->image_fillet($new_logo_img);
            }
  
            // Combinar logotipo y código QR temporal
            $pos_x = ($qrcode_w-$new_logo_w)/2;
            $pos_y = ($qrcode_h-$new_logo_h)/2;
  
            imagealphablending($tmp_qrcode_img, true);
  
            // Combinar las imágenes y mantener su transparencia
            $dest_img = $this->imagecopymerge_alpha($tmp_qrcode_img, $new_logo_img, $pos_x, $pos_y, 0, 0, $new_logo_w, $new_logo_h, $this->_config['logo_opacity']);
  
            // Generar imagen
            switch($dest_ext){
                case 1: imagegif($dest_img, $this->_config['dest_file'], $this->_config['quality']); break;
                case 2: imagejpeg($dest_img, $this->_config['dest_file'], $this->_config['quality']); break;
                case 3: imagepng($dest_img, $this->_config['dest_file'], (int)(($this->_config['quality']-1)/10)); break;
            } 
  
        // No es necesario agregar logo
        }else{
  
            $dest_img = imagecreatefrompng($tmp_qrcode_file);
  
            // Generar imagen
            switch($dest_ext){
                case 1: imagegif($dest_img, $this->_config['dest_file'], $this->_config['quality']); break;
                case 2: imagejpeg($dest_img, $this->_config['dest_file'], $this->_config['quality']); break;
                case 3: imagepng($dest_img, $this->_config['dest_file'], (int)(($this->_config['quality']-1)/10)); break;
            }
        }
  
    }
  
    /**
           * Acaricia el objeto de la imagen
     * @param    Objeto de imagen Obj $ img
     * @return Array
     */
    private function image_outline($img){
  
        // Obtener ancho y alto de la imagen
        $img_w = imagesx($img);
        $img_h = imagesy($img);
  
        // Calcula el tamaño del trazo, si no está configurado, se calculará automáticamente de acuerdo con la proporción
        $bg_w = isset($this->_config['logo_outline_size'])? intval($img_w + $this->_config['logo_outline_size']) : $img_w + (int)($img_w/5);
        $bg_h = isset($this->_config['logo_outline_size'])? intval($img_h + $this->_config['logo_outline_size']) : $img_h + (int)($img_h/5);
  
        // Crea un objeto de mapa base
        $bg_img = imagecreatetruecolor($bg_w, $bg_h);
  
        // Establecer el color del mapa base
        $rgb = $this->hex2rgb($this->_config['logo_outline_color']);
        $bgcolor = imagecolorallocate($bg_img, $rgb['r'], $rgb['g'], $rgb['b']);
  
        // Rellena el color del mapa base
        imagefill($bg_img, 0, 0, $bgcolor);
  
        // Combina la imagen y el mapa base para lograr el efecto de trazo
        imagecopy($bg_img, $img, (int)(($bg_w-$img_w)/2), (int)(($bg_h-$img_h)/2), 0, 0, $img_w, $img_h);
  
        $img = $bg_img;
  
        return array($img, $bg_w, $bg_h);
  
    }
  
    
    private function image_fillet($img){
  
        // Obtener ancho y alto de la imagen
        $img_w = imagesx($img);
        $img_h = imagesy($img);
  
        // Crea un objeto de imagen con esquinas redondeadas
        $new_img = imagecreatetruecolor($img_w, $img_h);
  
        // guarda el canal transparente
        imagesavealpha($new_img, true);
  
        // Rellena la imagen con esquinas redondeadas
        $bg = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
        imagefill($new_img, 0, 0, $bg);
  
        // Radio de redondeo
        $r = $this->_config['logo_radius'];
  
        // Realizar procesamiento de esquinas redondeadas
        for($x=0; $x<$img_w; $x++){
            for($y=0; $y<$img_h; $y++){
                $rgb = imagecolorat($img, $x, $y);
  
                // No en las cuatro esquinas de la imagen, dibuja directamente
                if(($x>=$r && $x<=($img_w-$r)) || ($y>=$r && $y<=($img_h-$r))){
                    imagesetpixel($new_img, $x, $y, $rgb);
  
                // En las cuatro esquinas de la imagen, elige dibujar
                }else{
                    // arriba a la izquierda
                    $ox = $r; // centro x coordenada
                    $oy = $r; // centro coordenada y
                    if( ( ($x-$ox)*($x-$ox) + ($y-$oy)*($y-$oy) ) <= ($r*$r) ){
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }
  
                    // parte superior derecha
                    $ox = $img_w-$r; // centro x coordenada
                    $oy = $r;        // centro coordenada y
                    if( ( ($x-$ox)*($x-$ox) + ($y-$oy)*($y-$oy) ) <= ($r*$r) ){
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }
  
                    // abajo a la izquierda
                    $ox = $r;        // centro x coordenada
                    $oy = $img_h-$r; // centro coordenada y
                    if( ( ($x-$ox)*($x-$ox) + ($y-$oy)*($y-$oy) ) <= ($r*$r) ){
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }
  
                    // abajo a la derecha
                    $ox = $img_w-$r; // centro x coordenada
                    $oy = $img_h-$r; // centro coordenada y
                    if( ( ($x-$ox)*($x-$ox) + ($y-$oy)*($y-$oy) ) <= ($r*$r) ){
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }
  
                }
  
            }
        }
  
        return $new_img;
  
    }
  
    // Combinar las imágenes y mantener su transparencia
    private function imagecopymerge_alpha($dest_img, $src_img, $pos_x, $pos_y, $src_x, $src_y, $src_w, $src_h, $opacity){
  
        $w = imagesx($src_img);
        $h = imagesy($src_img);
  
        $tmp_img = imagecreatetruecolor($src_w, $src_h);
  
        imagecopy($tmp_img, $dest_img, 0, 0, $pos_x, $pos_y, $src_w, $src_h);
        imagecopy($tmp_img, $src_img, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dest_img, $tmp_img, $pos_x, $pos_y, $src_x, $src_y, $src_w, $src_h, $opacity);
  
        return $dest_img;
  
    }
  
    
    private function create_dirs($path){
  
        if(!is_dir($path)){
            return mkdir($path, 0777, true);
        }
  
        return true;
  
    }
  
   
    private function hex2rgb($hexcolor){
        $color = str_replace('#', '', $hexcolor);
        if (strlen($color) > 3) {
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
        } else {
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        return $rgb;
    }
  
     
    private function get_file_ext($file){
        $filename = basename($file);
        list($name, $ext)= explode('.', $filename);
  
        $ext_type = 0;
  
        switch(strtolower($ext)){
            case 'jpg':
            case 'jpeg':
                $ext_type = 2;
                break;
            case 'gif':
                $ext_type = 1;
                break;
            case 'png':
                $ext_type = 3;
                break;
        }
  
        return $ext_type;
    }
  
  } // class end