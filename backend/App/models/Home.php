<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Home{

    public static function getCountByUser($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
    SELECT count(*) as count from pickup where utilerias_asistentes_id = '$id';
sql;
      return $mysqli->queryAll($query);
    }

    public static function getCountPickUp($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT count(*) as count from pickup where utilerias_asistentes_id = '$id';
sql;
        return $mysqli->queryOne($query);
    }

    public static function getQRById($id){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      SELECT ra.*
      FROM registros_acceso ra
      INNER JOIN utilerias_asistentes ua
      ON  ra.id_registro_acceso = ua.id_registro_acceso

      WHERE ua.utilerias_asistentes_id = '$id'
sql;
      return $mysqli->queryOne($query);
  }

  public static function getDataUser($user){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT * FROM utilerias_administradores WHERE usuario = '$user'
sql;
    return $mysqli->queryOne($query);
  }

  public static function getItinerarioAsistente($id){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    SELECT 
      i.id_itinerario,
      cao.nombre as aerolinea_origen, 
      caeo.nombre as aerolinea_escala_origen, 
      cad.nombre as aerolinea_destino, 
      caed.nombre as aerolinea_escala_destino,
      i.fecha_escala_salida,
      i.hora_escala_salida,
      i.fecha_escala_regreso,
      i.hora_escala_regreso,
      i.fecha_salida, 
      i.hora_salida, 
      i.fecha_regreso, 
      i.hora_regreso,
      i.nota,        
      a.aeropuerto as aeropuerto_salida, 
      ae.aeropuerto as aeropuerto_escala_salida, 
      aa.aeropuerto as aeropuerto_regreso,
      aae.aeropuerto as aeropuerto_escala_regreso,        
      concat(ra.nombre, " ", ra.segundo_nombre, " ", ra.apellido_paterno, " ", ra.apellido_materno) as nombre 
    FROM itinerario i 
    INNER JOIN catalogo_aerolinea cao on cao.id_aerolinea = i.aerolinea_origen 
    LEFT JOIN catalogo_aerolinea caeo on caeo.id_aerolinea = i.aerolinea_escala_origen
    INNER JOIN catalogo_aerolinea cad on cad.id_aerolinea = i.aerolinea_destino
    LEFT JOIN catalogo_aerolinea caed on caed.id_aerolinea = i.aerolinea_escala_destino
    INNER JOIN aeropuertos a on a.id_aeropuerto = i.aeropuerto_salida 
    LEFT JOIN aeropuertos ae on ae.id_aeropuerto = i.aeropuerto_escala_salida
    INNER JOIN aeropuertos aa on aa.id_aeropuerto = i.aeropuerto_regreso
    LEFT JOIN aeropuertos aae on aae.id_aeropuerto = i.aeropuerto_escala_regreso
    INNER JOIN utilerias_asistentes ua on ua.utilerias_asistentes_id = i.utilerias_asistentes_id 
    INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso
    WHERE ua.utilerias_asistentes_id = $id
    
sql;
    return $mysqli->queryAll($query);
  }


  public static function getAllUsers(){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT r.*
    FROM registrados r
sql;

    return $mysqli->queryAll($query);
  }

  public static function getFreeCourses(){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT *
      FROM cursos
      WHERE free = 1
sql;

      return $mysqli->queryAll($query);
  }

  public static function getAsignaCursoByUser($registrado, $curso){
    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT *
    FROM asigna_curso
    WHERE id_registrado = '$registrado' AND id_curso = '$curso'
sql;

    return $mysqli->queryOne($query);
  }

  public static function insertCursos($registrado, $curso){
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO asigna_curso (
        id_asigna_curso, 
        id_registrado, 
        id_curso, 
        fecha_asignacion,
        status)

    VALUES (
        null, 
        $registrado, 
        $curso, 
        NOW(), 
        1)
sql;
      // $parametros = array(
      //     ':utilerias_asistentes_id'=>$data->_utilerias_asistentes_id,
      //     ':utilerias_administradores_id'=>$data->_utilerias_administradores_id,
      //     ':clave'=>$data->_clave,
      //     ':escala'=>$data->_escala,
      //     ':url'=>$data->_url,
      //     ':nota'=>$data->_notas
      // );

      $id = $mysqli->insert($query);

      // $accion = new \stdClass();
      // $accion->_sql= $query;
      // $accion->_id_asistente = $data->_utilerias_asistentes_id;
      // $accion->_titulo = "Pase de abordar";
      // $accion->_descripcion = 'Un ejecutivo ha cargado su '.$accion->_titulo;
      // $accion->_id = $id;

      $log = new \stdClass();
      $log->_sql= $query;
      // $log->_parametros = $parametros;
      $log->_id = $id;

  return $id;

  }

  public static function getProductosPendComprados($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT pp.id_producto,pp.clave, pp.comprado_en,pp.status,ua.name_user,ua.clave_socio,aspro.status as estatus_compra,ua.amout_due,pro.nombre as nombre_producto, pro.precio_publico, pro.tipo_moneda, pro.max_compra, pro.es_congreso, pro.es_servicio, pro.es_curso
    FROM pendiente_pago pp
    INNER JOIN utilerias_administradores ua ON(ua.user_id = pp.user_id)
    INNER JOIN productos pro ON (pp.id_producto = pro.id_producto)
    LEFT JOIN asigna_producto aspro ON(pp.user_id = aspro.user_id AND pp.id_producto = aspro.id_producto)
    WHERE ua.user_id = $id GROUP BY id_producto;
sql;
    return $mysqli->queryAll($query);
  }

  public static function getProductosPendCompradosClave($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT pp.id_producto,pp.clave, pp.comprado_en,pp.status,ua.name_user,ua.amout_due,aspro.status as estatus_compra,pro.nombre as nombre_producto, pro.precio_publico, pro.tipo_moneda, pro.max_compra, pro.es_congreso, pro.es_servicio, pro.es_curso
    FROM pendiente_pago pp
    INNER JOIN utilerias_administradores ua ON(ua.user_id = pp.user_id)
    INNER JOIN productos pro ON (pp.id_producto = pro.id_producto)
    LEFT JOIN asigna_producto aspro ON(aspro.id_producto = pp.id_producto)
    WHERE ua.user_id = $id AND pp.comprado_en = 2 GROUP BY pp.id_producto
sql;
    return $mysqli->queryAll($query);
  }

  public static function getProductosNoComprados($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT p.id_producto, p.nombre as nombre_producto, p.precio_publico, p.tipo_moneda, p.max_compra, p.es_congreso, p.es_servicio, p.es_curso, ua.clave_socio, ua.amout_due 
    FROM productos p
    INNER JOIN utilerias_administradores ua
    WHERE id_producto NOT IN (SELECT id_producto FROM pendiente_pago WHERE user_id = $id) AND ua.user_id = $id;
sql;
    return $mysqli->queryAll($query);
  }

  public static function getCountProductos($user_id,$id_producto){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT count(*) as numero_productos FROM pendiente_pago WHERE user_id = $user_id and id_producto = $id_producto;
sql;
    return $mysqli->queryAll($query);
  }

    /* Pendiente de Pago */
    public static function inserPendientePago($data){ 
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO pendiente_pago (id_producto, user_id, reference, clave,fecha, monto, tipo_pago, status) VALUES (:id_producto, :user_id, :reference,:clave,:fecha, :monto, :tipo_pago, :status);
  sql;
  
    $parametros = array(
      ':id_producto'=>$data->_id_producto,
      ':user_id'=>$data->_user_id,
      ':reference'=>$data->_reference,
      ':clave'=>$data->_clave,
      ':fecha'=>$data->_fecha,
      ':monto'=>$data->_monto,
      ':tipo_pago'=>$data->_tipo_pago,
      ':status'=>$data->_status
          
    );
    $id = $mysqli->insert($query,$parametros);
    // $accion = new \stdClass();
    // $accion->_sql= $query;
    // $accion->_parametros = $parametros;
    // $accion->_id = $id;
  
    //UtileriasLog::addAccion($accion);
    return $id;
      // return "insert"+$data;
  }

  public static function getTipoCambio(){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM tipo_cambio WHERE id_tipo_cambio = 1
sql;
    return $mysqli->queryOne($query);
  }

  
}