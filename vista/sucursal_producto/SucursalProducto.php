<?php
/**
*@package pXP
*@file gen-SucursalProducto.php
*@author  (admin)
*@date 21-04-2015 03:18:44
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SucursalProducto=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.SucursalProducto.superclass.constructor.call(this,config);
		this.init();
		this.grid.getTopToolbar().disable();
        this.grid.getBottomToolbar().disable();
        this.iniciarEventos();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_sucursal_producto'
			},
			type:'Field',
			form:true 
		},
		{
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_sucursal'
            },
            type:'Field',
            form:true 
        },        
        
        {
                config:{
                    name:'tipo_producto',
                    fieldLabel:'Tipo de Producto',
                    allowBlank:false,
                    emptyText:'Tip...',                    
                    triggerAction: 'all',
                    lazyRender:true,
                    mode: 'local',                    
                    store:['item_almacen','servicio_o_producto']
                    
                },
                type:'ComboBox',
                id_grupo:0,
                filters:{   
                         type: 'list',
                         options: ['item_almacen','servicio_o_producto'], 
                    },
                grid:true,
                form:true
            },
		
		{
            config : {
                name : 'id_item',
                fieldLabel : 'Item',
                allowBlank : false,
                emptyText : 'Elija un Item...',
                store : new Ext.data.JsonStore({
                    url : '../../sis_almacenes/control/Item/listarItemNotBase',
                    id : 'id_item',
                    root : 'datos',
                    sortInfo : {
                        field : 'nombre',
                        direction : 'ASC'
                    },
                    totalProperty : 'total',
                    fields : ['id_item', 'nombre', 'codigo', 'desc_clasificacion', 'codigo_unidad'],
                    remoteSort : true,
                    baseParams : {
                        par_filtro : 'item.nombre#item.codigo#cla.nombre'
                    }
                }),
                valueField : 'id_item',
                displayField : 'nombre',
                gdisplayField : 'nombre_item',
                tpl : '<tpl for="."><div class="x-combo-list-item"><p>Nombre: {nombre}</p><p>Código: {codigo}</p><p>Clasif.: {desc_clasificacion}</p></div></tpl>',
                hiddenName : 'id_item',
                forceSelection : true,
                typeAhead : false,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'remote',
                pageSize : 10,
                queryDelay : 1000,
                anchor : '100%',
                gwidth : 250,
                minChars : 2,
                turl : '../../../sis_almacenes/vista/item/BuscarItem.php',
                tasignacion : true,
                tname : 'id_item',
                ttitle : 'Items',
                tdata : {},
                tcls : 'BuscarItem',
                pid : this.idContenedor,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_item']);
                },
                resizable: true
            },
            type : 'TrigguerCombo',
            id_grupo : 1,
            filters : {
                pfiltro : 'item.nombre',
                type : 'string'
            },
            grid : true,
            form : true
        },
        
        {
            config:{
                name: 'nombre_producto',
                fieldLabel: 'Nombre Producto/Servicio',
                allowBlank: false,
                anchor: '100%',
                gwidth: 200,
                maxLength:150
            },
                type:'TextField',
                filters:{pfiltro:'sprod.nombre_producto',type:'string'},
                id_grupo:2,
                grid:true,
                form:true
        },
        
        
		{
			config:{
				name: 'descripcion_producto',
				fieldLabel: 'Descripcion Producto/Servicio',
				allowBlank: true,
				anchor: '100%',
				gwidth: 250
			},
				type:'TextArea',
				filters:{pfiltro:'sprod.descripcion_producto',type:'string'},
				id_grupo:2,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'precio',
				fieldLabel: 'Precio',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:1179650
			},
				type:'NumberField',
				filters:{pfiltro:'sprod.precio',type:'numeric'},
				id_grupo:0,
				grid:true,
				form:true
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
				filters:{pfiltro:'sprod.estado_reg',type:'string'},				
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
				filters:{pfiltro:'sprod.fecha_reg',type:'date'},
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
				filters:{pfiltro:'sprod.usuario_ai',type:'string'},
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
				filters:{pfiltro:'sprod.id_usuario_ai',type:'numeric'},
				grid:false,
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
				filters:{pfiltro:'sprod.fecha_mod',type:'date'},
				grid:true,
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
				grid:true,
				form:false
		}
	],
	
	onReloadPage : function(m) {
        this.maestro=m;
        this.Atributos[1].valorInicial = this.maestro.id_sucursal;
        this.store.baseParams={id_sucursal:this.maestro.id_sucursal};
        this.load({params:{start:0, limit:50}});
            
    },
    iniciarEventos :  function () {
        this.Cmp.tipo_producto.on('select',function (c,r,v) {
            if (r.data.field1 == 'item_almacen') {
                this.mostrarGrupo(1);
                this.allowBlankGrupo(1, false);
                this.ocultarGrupo(2);
                this.allowBlankGrupo(2, true);
                this.resetGroup(2)
                
            } else {
                this.mostrarGrupo(2);
                this.allowBlankGrupo(2, false);
                this.ocultarGrupo(1);
                this.allowBlankGrupo(1, true);
                this.resetGroup(1)
            }
        },this);
    },
	tam_pag:50,	
	title:'Productos',
	ActSave:'../../sis_ventas_farmacia/control/SucursalProducto/insertarSucursalProducto',
	ActDel:'../../sis_ventas_farmacia/control/SucursalProducto/eliminarSucursalProducto',
	ActList:'../../sis_ventas_farmacia/control/SucursalProducto/listarSucursalProducto',
	id_store:'id_sucursal_producto',
	fields: [
		{name:'id_sucursal_producto', type: 'numeric'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'id_item', type: 'numeric'},
		{name:'nombre_item', type: 'string'},
		{name:'descripcion_producto', type: 'string'},
		{name:'precio', type: 'numeric'},
		{name:'nombre_producto', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'tipo_producto', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_sucursal_producto',
		direction: 'ASC'
	},
	
	Grupos: [
            {
                layout: 'column',
                border: false,
                // defaults are applied to all child items unless otherwise specified by child item
                defaults: {
                   // columnWidth: '.5',
                    border: false
                },            
                items: [{
                               
                                bodyStyle: 'padding-right:5px;',
                                items: [{
                                    xtype: 'fieldset',
                                    title: 'Datos Generales',
                                    autoHeight: true,
                                    items: [],
                                    id_grupo:0
                                }]
                            }, {
                                bodyStyle: 'padding-left:5px;',
                                items: [{
                                    xtype: 'fieldset',
                                    title: 'Item',
                                    autoHeight: true,
                                    items: [],
                                    id_grupo:1
                                }]
                            }
                        , {
                            bodyStyle: 'padding-left:5px;',
                            items: [{
                                xtype: 'fieldset',
                                title: 'Producto Sucursal',
                                autoHeight: true,
                                items: [],
                                id_grupo:2
                            }]
                        }]
            }
        ],
        
    fheight:'60%',
    fwidth:'60%',
        
    onButtonNew:function() {                    
            Phx.vista.SucursalProducto.superclass.onButtonNew.call(this);
            this.ocultarGrupo(2);
            this.ocultarGrupo(1);  
                      
            
    },
    
    onButtonEdit:function() {                    
            Phx.vista.SucursalProducto.superclass.onButtonEdit.call(this);
            if (this.Cmp.tipo_producto.getValue() == 'item_almacen') {
                this.mostrarGrupo(1);
                this.allowBlankGrupo(1, false);
                this.ocultarGrupo(2);
                this.allowBlankGrupo(2, true);
                this.resetGroup(2)
                
            } else {
                this.mostrarGrupo(2);
                this.allowBlankGrupo(2, false);
                this.ocultarGrupo(1);
                this.allowBlankGrupo(1, true);
                this.resetGroup(1)
            }                      
            
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
    
    arrayDefaultColumHidden:['estado_reg','usuario_ai',
    'fecha_reg','fecha_mod','usr_reg','usr_mod'],
    
	}
)
</script>
		
		