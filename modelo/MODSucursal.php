<?php
/**
*@package pXP
*@file gen-MODSucursal.php
*@author  (admin)
*@date 20-04-2015 15:07:50
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSucursal extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSucursal(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='vef.ft_sucursal_sel';
		$this->transaccion='VF_SUC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sucursal','int4');
		$this->captura('correo','varchar');
		$this->captura('nombre','varchar');
		$this->captura('telefono','varchar');
		$this->captura('tiene_precios_x_sucursal','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_clasificaciones_para_formula','text');
		$this->captura('codigo','varchar');
		$this->captura('id_clasificaciones_para_venta','text');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
        $this->captura('desc_clasificaciones_para_formula','varchar');
        $this->captura('desc_clasificaciones_para_venta','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='vef.ft_sucursal_ime';
		$this->transaccion='VF_SUC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('correo','correo','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('telefono','telefono','varchar');
		$this->setParametro('tiene_precios_x_sucursal','tiene_precios_x_sucursal','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_clasificaciones_para_formula','id_clasificaciones_para_formula','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('id_clasificaciones_para_venta','id_clasificaciones_para_venta','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='vef.ft_sucursal_ime';
		$this->transaccion='VF_SUC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('correo','correo','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('telefono','telefono','varchar');
		$this->setParametro('tiene_precios_x_sucursal','tiene_precios_x_sucursal','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_clasificaciones_para_formula','id_clasificaciones_para_formula','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('id_clasificaciones_para_venta','id_clasificaciones_para_venta','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='vef.ft_sucursal_ime';
		$this->transaccion='VF_SUC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>