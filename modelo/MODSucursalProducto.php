<?php
/**
*@package pXP
*@file gen-MODSucursalProducto.php
*@author  (admin)
*@date 21-04-2015 03:18:44
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSucursalProducto extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSucursalProducto(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='vef.ft_sucursal_producto_sel';
		$this->transaccion='VF_SPROD_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sucursal_producto','int4');
		$this->captura('id_sucursal','int4');
		$this->captura('id_item','int4');
		$this->captura('descripcion_producto','text');
		$this->captura('precio','numeric');
		$this->captura('nombre_producto','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo_producto','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
        $this->captura('nombre_item','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSucursalProducto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='vef.ft_sucursal_producto_ime';
		$this->transaccion='VF_SPROD_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_item','id_item','int4');
		$this->setParametro('descripcion_producto','descripcion_producto','text');
		$this->setParametro('precio','precio','numeric');
		$this->setParametro('nombre_producto','nombre_producto','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo_producto','tipo_producto','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSucursalProducto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='vef.ft_sucursal_producto_ime';
		$this->transaccion='VF_SPROD_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_producto','id_sucursal_producto','int4');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_item','id_item','int4');
		$this->setParametro('descripcion_producto','descripcion_producto','text');
		$this->setParametro('precio','precio','numeric');
		$this->setParametro('nombre_producto','nombre_producto','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo_producto','tipo_producto','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSucursalProducto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='vef.ft_sucursal_producto_ime';
		$this->transaccion='VF_SPROD_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_producto','id_sucursal_producto','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>