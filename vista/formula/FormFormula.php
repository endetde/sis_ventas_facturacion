<?php
/**
*@package pXP
*@file    FormSolicitud.php
*@author  Rensi Arteaga Copari 
*@date    30-01-2014
*@description permites subir archivos a la tabla de documento_sol
*/
header("content-type: text/javascript; charset=UTF-8");
?>

<script>
Phx.vista.FormFormula=Ext.extend(Phx.frmInterfaz,{
    ActSave:'../../sis_ventas_farmacia/control/Formula/insertarFormulaCompleta',
    tam_pag: 10,
    //layoutType: 'wizard',
    layout: 'fit',
    autoScroll: false,
    breset: false,
    labelSubmit: '<i class="fa fa-check"></i> Guardar',
    constructor:function(config)
    {   
        
        this.addEvents('beforesave');
        this.addEvents('successsave');
        
        this.buildComponentesDetalle();
        this.buildDetailGrid();
        this.buildGrupos();
        
        Phx.vista.FormFormula.superclass.constructor.call(this,config);
        this.init();    
        this.iniciarEventos();
        //this.iniciarEventosDetalle();
        //this.onNew();
                
    },
    buildComponentesDetalle: function(){
        this.detCmp = {
                   'id_item': new Ext.form.ComboBox({
                                            name : 'id_item',
                                            fieldLabel : 'Item',
                                            allowBlank : false,
                                            msgTarget: 'title',
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
                                            qtip:'Seleccione un item',
                                            tpl : '<tpl for="."><div class="x-combo-list-item"><p>Nombre: {nombre}</p><p>Código: {codigo}</p><p>Clasif.: {desc_clasificacion}</p></div></tpl>',
                                            hiddenName : 'id_item',
                                            forceSelection : true,
                                            typeAhead : false,
                                            triggerAction : 'all',
                                            lazyRender : true,
                                            mode : 'remote',
                                            pageSize : 10,
                                            queryDelay : 1000,                
                                            minChars : 2,                                        
                                            resizable: true
                                         }),                  
                    'cantidad': new Ext.form.NumberField({
                                        name: 'cantidad_sol',
                                        msgTarget: 'title',
                                        fieldLabel: 'Cantidad',
                                        allowBlank: false,
                                        allowDecimals: false,
                                        maxLength:10
                                })
                    
              }
            
            
    }, 
    
    
    
    onCancelAdd: function(re,save){
        if(this.sw_init_add){
            this.mestore.remove(this.mestore.getAt(0));
        }
        
        this.sw_init_add = false;
        this.evaluaGrilla();
    },
    onUpdateRegister: function(){
        this.sw_init_add = false;
    },
    
    onAfterEdit:function(re, o, rec, num){
        //set descriptins values ...  in combos boxs
        
        var cmb_rec = this.detCmp['id_item'].store.getById(rec.get('id_item'));
        if(cmb_rec) {
            
            rec.set('nombre_item', cmb_rec.get('nombre')); 
        }        
        
    },
        
    buildDetailGrid: function(){
        
        //cantidad,detalle,peso,totalo
        var Items = Ext.data.Record.create([{
                        name: 'cantidad',
                        type: 'int'
                    }, {
                        name: 'id_item',
                        type: 'int'
                    }
                    ]);
        
        this.mestore = new Ext.data.JsonStore({
                    url: '../../sis_ventas_farmacia/control/FormulaDetalle/listarFormulaDetalle',
                    id: 'id_formula_detalle',
                    root: 'datos',
                    totalProperty: 'total',
                    fields: ['id_formula_detalle','id_item','id_formula', 'cantidad',
                             'nombre_item'
                    ],remoteSort: true,
                    baseParams: {dir:'ASC',sort:'id_formula_detalle',limit:'50',start:'0'}
                });
        
        this.editorDetail = new Ext.ux.grid.RowEditor({
                saveText: 'Aceptar',
                name: 'btn_editor'
               
            });            
        
                
        //al cancelar la edicion
        this.editorDetail.on('canceledit', this.onCancelAdd , this);
        
        //al cancelar la edicion
        this.editorDetail.on('validateedit', this.onUpdateRegister, this);
        
        this.editorDetail.on('afteredit', this.onAfterEdit, this);
        
        
        
        
        
        
        
        this.megrid = new Ext.grid.GridPanel({
                    layout: 'fit',
                    store:  this.mestore,
                    region: 'center',
                    split: true,
                    border: false,
                    plain: true,
                    //autoHeight: true,
                    plugins: [ this.editorDetail],
                    stripeRows: true,
                    tbar: [{
                        /*iconCls: 'badd',*/
                        text: '<i class="fa fa-plus-circle fa-lg"></i> Agregar Componente',
                        scope: this,
                        width: '100',
                        handler: function() {                                
                                 var e = new Items({
                                    id_item: undefined,
                                    cantidad: 0});
                                
                                this.editorDetail.stopEditing();
                                this.mestore.insert(0, e);
                                this.megrid.getView().refresh();
                                this.megrid.getSelectionModel().selectRow(0);
                                this.editorDetail.startEditing(0);
                                this.sw_init_add = true;
                                                       
                        }
                    },{
                        ref: '../removeBtn',
                        text: '<i class="fa fa-trash fa-lg"></i> Eliminar',
                        scope:this,
                        handler: function(){
                            this.editorDetail.stopEditing();
                            var s = this.megrid.getSelectionModel().getSelections();
                            for(var i = 0, r; r = s[i]; i++){
                                this.mestore.remove(r);
                            }
                            this.evaluaGrilla();
                        }
                    }],
            
                    columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Item',
                        dataIndex: 'id_item',
                        width: 200,
                        sortable: false,
                        renderer:function(value, p, record){return String.format('{0}', record.data['nombre_item']);},
                        editor: this.detCmp.id_item 
                    },                    
                    {
                       
                        header: 'Cantidad',
                        dataIndex: 'cantidad',
                        align: 'center',
                        width: 50,
                        editor: this.detCmp.cantidad 
                    }]
                });
    },
    buildGrupos: function(){
        this.Grupos = [{
                        layout: 'border',
                        border: false,
                         frame:true,
                        items:[
                          {
                            xtype: 'fieldset',
                            border: false,
                            split: true,
                            layout: 'column',
                            region: 'north',
                            autoScroll: true,
                            autoHeight: true,
                            collapseFirst : false,
                            collapsible: true,
                            width: '100%',
                            //autoHeight: true,
                            padding: '0 0 0 10',
                            items:[
                                   {
                                    bodyStyle: 'padding-right:5px;',
                                   
                                    autoHeight: true,
                                    border: false,
                                    items:[
                                       {
                                        xtype: 'fieldset',
                                        frame: true,
                                        border: false,
                                        layout: 'form', 
                                        title: 'Tipo',
                                        width: '40%',
                                        
                                        //margins: '0 0 0 5',
                                        padding: '0 0 0 10',
                                        bodyStyle: 'padding-left:5px;',
                                        id_grupo: 0,
                                        items: [],
                                     }]
                                 },
                                 {
                                  bodyStyle: 'padding-right:5px;',
                                
                                  border: false,
                                  autoHeight: true,
                                  items: [{
                                        xtype: 'fieldset',
                                        frame: true,
                                        layout: 'form',
                                        title: ' Datos básicos ',
                                        width: '33%',
                                        border: false,
                                        //margins: '0 0 0 5',
                                        padding: '0 0 0 10',
                                        bodyStyle: 'padding-left:5px;',
                                        id_grupo: 1,
                                        items: [],
                                     }]
                                 },
                                 
                              ]
                          },
                            this.megrid
                         ]
                 }];
        
        
    },
    onSubmit: function(o) {
        //  validar formularios
        var arra = [], i, me = this;
        for (i = 0; i < me.megrid.store.getCount(); i++) {
            record = me.megrid.store.getAt(i);
            arra[i] = record.data;            
        }        
        
        me.argumentExtraSubmit = { 'json_new_records': JSON.stringify(arra, function replacer(key, value) {
                       if (typeof value === 'string') {
                                    return String(value).replace(/&/g, "%26")
                                }
                                return value;
                            }) };
        if( i > 0 &&  !this.editorDetail.isVisible()){
             Phx.vista.FormFormula.superclass.onSubmit.call(this,o);
        }
        else{
            alert('no tiene ningun elemento en la formula')
        }
    },    
    
    successSave:function(resp)
    {
        Phx.CP.loadingHide();
        Phx.CP.getPagina(this.idContenedorPadre).reload();
        this.panel.close();
    },        
    
    
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_formulario'
            },
            type:'Field',
            form:true 
        },
        {
            config : {
                name : 'id_medico',
                fieldLabel : 'Medico',
                allowBlank : false,
                emptyText : 'Medico...',
                store : new Ext.data.JsonStore({
                    url : '../../sis_ventas_farmacia/control/Medico/listarMedico',
                    id : 'id_medico',
                    root : 'datos',
                    sortInfo : {
                        field : 'nombres',
                        direction : 'ASC'
                    },
                    totalProperty : 'total',
                    fields : ['id_medico', 'nombres', 'primer_apellido', 'segundo_apellido'],
                    remoteSort : true,
                    baseParams : {
                        par_filtro : 'med.nombres#med.primer_apellido#med.segundo_apellido'
                    }
                }),
                valueField : 'id_medico',
                displayField : 'primer_apellido',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nombres} {primer_apellido} {segundo_apellido}</p> </div></tpl>',
                hiddenName : 'id_medico',
                forceSelection : true,
                typeAhead : false,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'remote',
                turl:'../../../sis_ventas_farmacia/vista/medico/Medico.php',
                ttitle:'Medicos',
                tasignacion : true,           
                tname : 'id_medico',
                // tconfig:{width:1800,height:500},
                tdata:{},
                tcls:'Medico',
                pageSize : 10,
                queryDelay : 1000,
                gwidth : 150,
                minChars : 2
            },
            type : 'TrigguerCombo',
            id_grupo : 0,            
            form : true
        },
        {
            config:{
                name: 'nombre',
                fieldLabel: 'Nombre Formula',
                allowBlank: false,
                anchor: '100%',
                gwidth: 200,
                maxLength:200
            },
                type:'TextField',                
                id_grupo:0,                
                form:true
        },
        {
            config:{
                name: 'descripcion',
                fieldLabel: 'Descripcion Formula',
                allowBlank: true,
                anchor: '100%',
                gwidth: 250
            },
                type:'TextArea',                
                id_grupo:0,                
                form:true,
        },
        
        {
            config:{
                name: 'cantidad',
                fieldLabel: 'Cantidad',
                allowBlank: false,
                anchor: '80%',                
                maxLength:4
            },
                type:'NumberField',                
                id_grupo:1,               
                form:true
        },
        {
            config : {
                name : 'id_unidad_medida',
                fieldLabel : 'Unidad de Medida',
                allowBlank : false,
                emptyText : 'Unidad...',
                store : new Ext.data.JsonStore({
                    url : '../../sis_parametros/control/UnidadMedida/listarUnidadMedida',
                    id : 'id_unidad_medida',
                    root : 'datos',
                    sortInfo : {
                        field : 'codigo',
                        direction : 'ASC'
                    },
                    totalProperty : 'total',
                    fields : ['id_unidad_medida', 'codigo', 'descripcion'],
                    remoteSort : true,
                    baseParams : {
                        par_filtro : 'ume.nombre'
                    }
                }),
                valueField : 'id_unidad_medida',
                displayField : 'descripcion',                
                hiddenName : 'id_unidad_medida',
                forceSelection : true,
                typeAhead : false,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'remote',
                pageSize : 10,
                queryDelay : 1000,
                gwidth : 130,
                minChars : 2
            },
            type : 'ComboBox',
            id_grupo : 1,            
            form : true
        },   
          
        
    ],
    title: 'Form Formula'
})    
</script>