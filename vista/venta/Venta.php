<?php
/**
*@package pXP
*@file gen-Venta.php
*@author  (admin)
*@date 01-06-2015 05:58:00
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Venta=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Venta.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_venta'
			},
			type:'Field',
			form:true 
		},
		
		{
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_proceso_wf'
            },
            type:'Field',
            form:true 
        },
        
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_estado_wf'
            },
            type:'Field',
            form:true 
        },
        {
            config:{
                name: 'nro_tramite',
                fieldLabel: 'Nro',              
                gwidth: 110
            },
                type:'TextField',
                filters:{pfiltro:'ven.nro_tramite',type:'string'},              
                grid:true,
                form:false,
                bottom_filter: true
        },
        
        {
            config : {
                name : 'id_cliente',
                fieldLabel : 'Cliente',
                allowBlank : false,
                emptyText : 'Cliente...',
                store : new Ext.data.JsonStore({
                    url : '../../sis_ventas_farmacia/control/Cliente/listarCliente',
                    id : 'id_cliente',
                    root : 'datos',
                    sortInfo : {
                        field : 'nombres',
                        direction : 'ASC'
                    },
                    totalProperty : 'total',
                    fields : ['id_cliente', 'nombres', 'primer_apellido', 'segundo_apellido'],
                    remoteSort : true,
                    baseParams : {
                        par_filtro : 'cli.nombres#cli.primer_apellido#cli.segundo_apellido'
                    }
                }),
                valueField : 'id_cliente',
                displayField : 'primer_apellido',
                gdisplayField : 'nombre_completo',
                hiddenName : 'id_cliente',
                forceSelection : true,
                typeAhead : false,
                tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nombres} {primer_apellido} {segundo_apellido}</p> </div></tpl>',
                triggerAction : 'all',
                lazyRender : true,
                mode : 'remote',
                pageSize : 10,
                queryDelay : 1000,
                turl:'../../../sis_ventas_farmacia/vista/cliente/Cliente.php',
                ttitle:'Clientes',
                // tconfig:{width:1800,height:500},
                tasignacion : true,           
                tname : 'id_cliente',
                tdata:{},
                tcls:'Cliente',
                gwidth : 170,
                minChars : 2,
                renderer: function(value, p, record){                    
                    return String.format('{0}', record.data['nombre_completo']);
                }
            },
            type : 'TrigguerCombo',
            id_grupo : 0,
            filters : {
                pfiltro : 'cli.nombre_completo',
                type : 'string'
            },
            grid : true,
            form : true,
            bottom_filter: true
        },		
		
		{
            config:{
                name: 'total_venta',
                fieldLabel: 'Total Venta',
                allowBlank: false,
                anchor: '80%',
                gwidth: 120,
                maxLength:5,
                disabled:true
            },
                type:'NumberField',
                filters:{pfiltro:'ven.total_venta',type:'numeric'},
                id_grupo:1,
                grid:true,
                form:true
        },
		
		
		{
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
		},
		
		{
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
		},
		{
            config: {
                name: 'id_sucursal',
                fieldLabel: 'Sucursal',
                allowBlank: false,
                emptyText: 'Elija una Suc...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_ventas_farmacia/control/Sucursal/listarSucursal',
                    id: 'is_sucursal',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_sucursal', 'nombre', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'suc.nombre#suc.codigo'}
                }),
                valueField: 'id_sucursal',
                displayField: 'nombre',
                gdisplayField: 'nombre_sucursal',
                hiddenName: 'id_sucursal',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,               
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_sucursal']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'suc.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'estado',
                fieldLabel: 'Estado',                
                gwidth: 100
            },
                type:'TextField',
                filters:{pfiltro:'ven.estado',type:'string'},                
                grid:true,
                form:false
        },
        {
            config:{
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
                type:'TextField',
                filters:{pfiltro:'ven.estado_reg',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
        },
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'ven.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'ven.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'ven.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'ven.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Ventas',
	ActSave:'../../sis_ventas_farmacia/control/Venta/insertarVenta',
	ActDel:'../../sis_ventas_farmacia/control/Venta/eliminarVenta',
	ActList:'../../sis_ventas_farmacia/control/Venta/listarVenta',
	id_store:'id_venta',
	fields: [
		{name:'id_venta', type: 'numeric'},
		{name:'id_cliente', type: 'numeric'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'id_proceso_wf', type: 'numeric'},
		{name:'id_estado_wf', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre_completo', type: 'string'},
		{name:'nombre_sucursal', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'nro_tramite', type: 'string'},
		{name:'a_cuenta', type: 'numeric'},
		{name:'total_venta', type: 'numeric'},
		{name:'fecha_estimada_entrega', type: 'date',dateFormat:'Y-m-d'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_venta',
		direction: 'DESC'
	},
	bdel:true,
	bsave:true,
	rowExpander: new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                '<br>',                
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha de Registro:&nbsp;&nbsp;</b> {fecha_reg:date("d/m/Y")}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha Ult. Modificación:&nbsp;&nbsp;</b> {fecha_mod:date("d/m/Y")}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Creado por:&nbsp;&nbsp;</b> {usr_reg}</p>',
                '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Modificado por:&nbsp;&nbsp;</b> {usr_mod}</p><br>'
            )
    }),
    loadValoresIniciales:function()
    {
        this.Cmp.total_venta.setValue(0);          
        Phx.vista.Venta.superclass.loadValoresIniciales.call(this);        
    },
    
    onButtonNew:function(){
        //llamamos primero a la funcion new de la clase padre por que reseta el valor los componentes
        this.Cmp.id_sucursal.store.load({params:{start:0,limit:this.tam_pag}, 
           callback : function (r) {
                if (r.length == 1 ) {                       
                    this.Cmp.id_sucursal.setValue(r[0].data.id_sucursal);
                    this.Cmp.id_sucursal.fireEvent('select', r[0]);
                }    
                                
            }, scope : this
        });
        
        Phx.vista.Venta.superclass.onButtonNew.call(this);
    },
    
    
    
    
    
    south : {
            url : '../../../sis_ventas_farmacia/vista/venta_detalle/VentaDetalle.php',
            title : 'Detalle',
            height : '50%',
            cls : 'VentaDetalle'
    },
    onButtonNew : function () {
        //abrir formulario de solicitud
           var me = this;
           me.objSolForm = Phx.CP.loadWindows('../../../sis_ventas_farmacia/vista/venta/FormVenta.php',
                                    'Formulario de Venta',
                                    {
                                        modal:true,
                                        width:'80%',
                                        height:'90%'
                                    }, {data:{objPadre: me}
                                    }, 
                                    this.idContenedor,
                                    'FormVenta',
                                    {
                                        config:[{
                                                  event:'successsave',
                                                  delegate: this.onSaveForm,
                                                  
                                                }],
                                        
                                        scope:this
                                     });      
    },
    
    arrayDefaultColumHidden:['estado_reg','usuario_ai',
    'fecha_reg','fecha_mod','usr_reg','usr_mod'],
	}
)
</script>
		
		