<?php
/**
*@package pXP
*@file gen-SistemaDist.php
*@author  (fprudencio)
*@date 20-09-2011 10:22:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.VentaVendedorFarmacia = {
    require:'../../../sis_ventas_facturacion/vista/venta/VentaVendedor.php',
	requireclase:'Phx.vista.VentaVendedor',
	title:'Venta',
	nombreVista: 'VentaVendedorFarmacia',
	formUrl : '../../../sis_ventas_facturacion/vista/venta_farmacia/FormVentaFarmacia.php',
	formClass : 'FormVentaFarmacia',
	constructor: function(config) {	
		Phx.vista.VentaVendedorFarmacia.superclass.constructor.call(this,config);		
   },
   successGetVariables :function (response,request) {     				  		
  		this.addElements();
		Phx.vista.VentaVendedorFarmacia.superclass.successGetVariables.call(this,response,request); 
		this.formUrl = '../../../sis_ventas_facturacion/vista/venta_farmacia/FormVentaFarmacia.php';
        this.formClass = 'FormVentaFarmacia'; 
  },
   addElements : function () {
  	this.Atributos.push({
			config:{
				name: 'a_cuenta',
				fieldLabel: 'A cuenta',
				allowBlank: false,
				anchor: '80%',
				gwidth: 120,
				maxLength:5
			},
				type:'NumberField',
				filters:{pfiltro:'ven.a_cuenta',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		});
		
	this.Atributos.push({
			config:{
				name: 'fecha_estimada_entrega',
				fieldLabel: 'Fecha de Entrega Estimada',
				allowBlank: false,				
				gwidth: 150,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'ven.fecha_estimada_entrega',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		});
  }
   
	
};
</script>