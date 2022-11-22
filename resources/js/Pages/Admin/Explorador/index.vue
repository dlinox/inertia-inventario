<template>
    <div class="wrapper-page">
        <div class="content-wrapper">
            <v-navigation-drawer
                absolute
                v-model="drawer"
                color="grey lighten-5"
            >

                <v-container>

                    <div class="mt-5">
                        <h4 class="pb-3 grey--text text--darken-2">
                            Filtros
                        </h4>
                        <v-menu
                            ref="menux"
                            v-model="menux"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="auto"
                            >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                v-model="date"
                                dense
                                label="Fecha Inicio"
                                outlined
                                clearable
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                >
                                    <v-icon
                                        slot="append">
                                        mdi-calendar
                                    </v-icon>
                                </v-text-field>
                            </template>
                            <v-date-picker
                                locale="es"
                                dense
                                first-day-of-week = "1"
                                v-model="date"
                                :active-picker.sync="activePicker"

                                min="2010-01-01"
                            ></v-date-picker>
                        </v-menu>

                        <v-menu
                            ref="menuf"
                            v-model="menuf"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="auto"
                            >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                v-model="datef"
                                dense
                                label="Fecha Fin"
                                outlined
                                clearable
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                >
                                    <v-icon
                                        slot="append">
                                        mdi-calendar
                                    </v-icon>
                                </v-text-field>
                            </template>
                            <v-date-picker
                                locale="es"
                                first-day-of-week = "1"
                                v-model="datef"
                                :active-picker.sync="activePickerf"

                                min="2010-01-01"
                            ></v-date-picker>
                        </v-menu>
                        <v-autocomplete
                            v-model="estado"
                            :items="estados"
                            item-text="name"
                            item-value="id"
                            label="Estado"
                            outlined
                            dense
                            clearable
                        ></v-autocomplete>

                    </div>
                </v-container>

                <template v-slot:append>
                    <div class="pa-2" >
                        <v-btn @click="Filtrar" block color="primary" >
                        Filtrar
                        </v-btn>
                    </div>
                </template>
            </v-navigation-drawer>

            <div class="content" :class="drawer ? '' : 'full'">
                <v-container>

                    <div class="mt-0  p-4"  style="margin: 0px; min-height: 530px; background-color: white; " >
                        <v-card-title>
                            <div style="width:100%; margin-bottom:10px;" >
                                <h5>
                                    Cargos personales
                                </h5>

                            </div>

                            <div style="width:100%; display: flex; justify-content: space-between; ">
                                <v-btn
                                    x-small
                                    outlined
                                       rounded
                                    color="primary"
                                    dark
                                    @click="drawer = !drawer"
                                    style="margin-top:10px;"
                                    >
                                    Avanzado
                                    <v-icon dense  style="font-size: 0.8rem">mdi-filter-outline</v-icon>
                                </v-btn>

                                <div style="width:300px; display:flex;" >
                                    <v-text-field
                                    v-model="searchdocuments"
                                    append-icon="mdi-magnify"
                                    outlined
                                    dense
                                    hide-details
                                    >
                                    </v-text-field>
                                    <!-- <v-icon  outlined style=" margin-left:10px; font-size: 1.2rem" @click="drawer = !drawer">mdi-filter-outline</v-icon> -->
                                </div>
                            </div>
                        </v-card-title>
                        <div
                        max-width="900"
                        >
                        <v-data-table
                            :headers="headersdocuments"
                            :items="documentos"
                            :search="searchdocuments"
                            :itemsPerPage="pages"
                            :mobile-breakpoint="100"
                            :page="page"
                            hide-default-footer
                            >
                        <template v-slot:item.acciones="{ item }" >
                            <div>
                            <v-menu offset-y>
                                    <template
                                        v-slot:activator="{
                                            attrs,
                                            on,
                                        }"
                                    >
                                        <v-btn
                                            icon
                                            text
                                            color="primary"
                                            class=""
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <v-icon>
                                                mdi-dots-vertical
                                            </v-icon>
                                        </v-btn>
                                    </template>

                                    <v-list dense>
                                        <v-subheader
                                            >Opciones
                                        </v-subheader
                                        >
                                        <v-list-item-group
                                            color="primary"
                                        >

                                        <v-list-item @click="desbloquear(item)">
                                            <v-list-item-icon  style="margin-right: -10px;" >
                                                <v-icon color="primary" v-if="item.estado === 0" size="1.1rem">mdi-lock</v-icon>
                                                <v-icon v-else color="grey" size="1.1rem">mdi-lock-open</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <span style="margin-left: 10px;" >Desbloquear</span>
                                            </v-list-item-content>
                                        </v-list-item>

                                        <v-list-item @click="verDocumento(item)">
                                            <v-list-item-icon  style="margin-right: -10px;" >
                                                <v-icon color="primary" size="1.1rem">mdi-eye</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <span style="margin-left: 10px;" >Ver</span>
                                            </v-list-item-content>
                                        </v-list-item>

                                        <v-list-item @click="abrirModalEliminar(item)">
                                            <v-list-item-icon  style="margin-right: -10px;" >
                                                <v-icon color="primary" size="1.1rem">mdi-delete</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <span style="margin-left: 10px;" >Eliminar</span>
                                            </v-list-item-content>
                                        </v-list-item>

                                        <v-list-item @click="descargarExcel(item)">
                                            <v-list-item-icon  style="margin-right: -10px;" >
                                                <v-icon color="primary" size="1.1rem">mdi-download</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <span style="margin-left: 10px;" >Descargar</span>
                                            </v-list-item-content>
                                        </v-list-item>
                                        </v-list-item-group>
                                    </v-list>
                                </v-menu>
                            </div>
                        </template>
                        <template v-slot:item.codigo="{ item }">
                            <div class="d-flex">
                                <span class="mdi mdi-clipboard-text mr-3"></span>
                                <span>{{ item.codigo }}</span>
                            </div>
                        </template>
                        <template v-slot:item.responsable="{ item }" style="min-width:660px;">
                            <div class="d-flex">
                                <span>{{ item.dni  }}</span>
                            </div>
                        </template>

                        </v-data-table>
                        <div>
                            <v-pagination
                                v-model="page"
                                :length="nregistros + 1"
                                :total-visible="5"
                            ></v-pagination>
                        </div>
                        </div>
                </div>

                <div class="text-center">
                <v-snackbar
                    v-model="snackbar"
                    :timeout="timeout"
                >
                    {{ text }}

                    <template v-slot:action="{ attrs }">
                    <v-btn
                        color="blue"
                        text
                        v-bind="attrs"
                        @click="snackbar = false"
                    >
                        Close
                    </v-btn>
                    </template>
                </v-snackbar>
                </div>



                <v-row justify="center">
                    <v-dialog
                        v-model="dialogError"
                        persistent
                        max-width="300"
                        >
                        <v-card>
                            <!-- <v-card-title class="text-h6 white--text primary lighten-1">
                                !Error!
                            </v-card-title> -->
                        <v-card-text>
                            <div>
                                <div style="height:90px; justify-content: center; align-items: center;" class="d-flex pt-4">
                                    <v-icon dark color="red" style="font-size:4.5rem">
                                        mdi-alert-circle-outline
                                    </v-icon>
                                </div>
                            </div>
                            <h3 class="mt-5 m-2" style="text-align:center;" >
                                No tiene permiso para realizar esta acción
                                <!-- Ya se  generó un documento para <span v-if="docSeleccionado !== null"> <span color="black"> {{docSeleccionado.dni}} </span> de {{ docSeleccionado.nombre }}, si desea continuar debe desbloquear el documento {{docSeleccionado.codigo }} </span> -->
                            </h3>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary dark"
                            @click="dialogError = false"
                        >
                            Aceptar
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>

                    <v-row justify="center">
                        <v-dialog
                            v-model="dialogEliminar"
                            persistent
                            max-width="300"
                            >
                            <v-card>
                            <v-card-title class="text-h6 white--text primary lighten-1">
                                    Advertencia!
                            </v-card-title>
                            <v-card-text>
                                <h4 class="mt-5 m-2" style="text-align:center;" >
                                    Está seguro que quiere eliminar el cargo <span v-if="docSeleccionado !== null"> <span color="black"> {{docSeleccionado.codigo }} </span></span>
                                </h4>
                            </v-card-text>
                            <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="danger darken-1"
                                outlined
                                text
                                @click="dialogEliminar = false"
                            >
                                Cancelar
                            </v-btn>
                            <v-btn
                                color="primary lighten-1"
                                @click="eliminarDocumento"
                            >
                                Continuar
                            </v-btn>
                            </v-card-actions>
                        </v-card>
                        </v-dialog>
                    </v-row>

                </v-row>

                </v-container>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";

import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

export default {
    metaInfo: { title: "Usuarios" },
    layout: Layout,

    data: () => ({

        estados: [
            {'id': 2, 'name': 'Todos'},
            {'id': 1, 'name': 'Activos'},
            {'id': 0, 'name': 'Desactivados'},
        ],

        estado: 1,
        picker: null,
        drawer: false,

        activePicker: null,
        activePickerf: null,
        date: null,
        datef: null,
        menux: false,
        menuf: false,

        dialog: false,
        personas:[],
        areas:[],
        documentos:[],
        snackbar:false,
        timeout: 2000,
        text:'',
        documentoElegido: null,
        searchdocuments:'',
        headersdocuments: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', width:"220px", class:'grey lighten-1' },
          { text: 'Responsable', align: 'center', filterable: false, width:"130px", value: 'dni', class:'grey lighten-1',  },
          { text: 'Area', align: 'start', filterable: true, value: 'nombre', width:"300px", minWidth:'250px', class:'grey lighten-1' },
          { text: ' ', align: 'right', value:'acciones', maxWidth:'50px', class:'grey lighten-1'  },
        ],

        dialogError:false,
        dialogEliminar:false,
        page:1,
        pages:8,
        nregistros:1,

        docSeleccionado:null,

        itemsOptions: [
            { text: "Desbloquear", icon: "mdi-lock-open" },
            { text: "Ver cargo", icon: "mdi-eye" },
            { text: "Descargar Excel", icon: "mdi-download" },
            { text: "Eliminar", icon: "mdi-delete" },
        ],

    }),
    created() {
        this.getDocuments()
    },
    methods: {

        async getDocuments() {
            if(this.estado === null && this.date === null && this.datef === null ) {
                let res = await axios.get("/admin/reportes/getDocumentsF/2,'1900-01-01','2100-12-31'");
                this.documentos = res.data.datos;
                let resto = res.data.count[0].registros % this.pages;
                if(resto > 0){
                    this.nregistros = parseInt((res.data.count[0].registros / this.pages).toFixed(0) );

                }
                else {
                    this.nregistros = (res.data.count[0].registros / this.pages) - 1;
                }
                //this.nregistros = res.registros;
                return res.data.datos.data;
            }
            if(this.estado === null && this.date === null && this.datef !== null ) {
                let res = await axios.get("/admin/reportes/getDocumentsF/"+this.estado+",'1900-01-01',"+this.datef);
                this.documentos = res.data.datos;
                let resto = res.data.count[0].registros % this.pages;
                if(resto > 0){
                    this.nregistros = parseInt((res.data.count[0].registros / this.pages).toFixed(0));
                }
                else {
                    this.nregistros = (res.data.count[0].registros / this.pages) - 1;
                }
                //this.nregistros = res.registros;
                return res.data.datos.data;
            }
            if(this.estado !== null && this.date === null && this.datef === null ) {
                let res = await axios.get("/admin/reportes/getDocumentsF/"+this.estado+",'1900-01-01','2100-12-31'");
                this.documentos = res.data.datos;
                let resto = res.data.count[0].registros % this.pages;
                if(resto > 0){
                    this.nregistros = parseInt((res.data.count[0].registros / this.pages).toFixed(0));

                }
                else {
                    this.nregistros = (res.data.count[0].registros / this.pages) - 1;
                }
                //this.nregistros = res.registros;
                return res.data.datos.data;
            }

            if(this.estado === null && this.date !== null && this.datef === null ) {
                let res = await axios.get("/admin/reportes/getDocumentsF/2,'"+this.date+"','2100-12-31'");
                this.documentos = res.data.datos;
                let resto = res.data.count[0].registros % this.pages;
                if(resto > 0){
                    this.nregistros = parseInt((res.data.count[0].registros / this.pages).toFixed(0));

                }
                else {
                    this.nregistros = (res.data.count[0].registros / this.pages) - 1;
                }
                //this.nregistros = res.registros;
                return res.data.datos.data;
            }

            if(this.estado !== null && this.date !== null && this.datef === null ) {
                let res = await axios.get("/admin/reportes/getDocumentsF/"+this.estado+",'"+this.date+"','2100-12-31'");
                this.documentos = res.data.datos;
                let resto = res.data.count[0].registros % this.pages;
                if(resto > 0){
                    this.nregistros = parseInt((res.data.count[0].registros / this.pages).toFixed(0));
                }
                else {
                    this.nregistros = (res.data.count[0].registros / this.pages) - 1;
                }
                //this.nregistros = res.registros;
                return res.data.datos.data;
            }

            if(this.estado === null && this.date !== null && this.datef !== null ) {
                let res = await axios.get("/admin/reportes/getDocumentsF/2,'"+this.date+"','"+this.datef+"'");
                this.documentos = res.data.datos;
                let resto = res.data.count[0].registros % this.pages;
                if(resto > 0){
                    this.nregistros = parseInt((res.data.count[0].registros / this.pages).toFixed(0));

                }
                else {
                    this.nregistros = (res.data.count[0].registros / this.pages) - 1;
                }
                //this.nregistros = res.registros;
                return res.data.datos.data;
            }

            if(this.estado !== null && this.date !== null && this.datef !== null ) {
                let res = await axios.get("/admin/reportes/getDocumentsF/"+this.estado+",'"+this.date+"','"+this.datef+"'");
                this.documentos = res.data.datos;
                let resto = res.data.count[0].registros % this.pages;
                if(resto > 0){
                    this.nregistros = parseInt((res.data.count[0].registros / this.pages).toFixed(0));
                    // this.nregistros = (res.data.count[0].registros - resto)  + 1;
                }
                else {
                    this.nregistros = (res.data.count[0].registros / this.pages) - 1;
                }
                //this.nregistros = res.registros;
                return res.data.datos.data;
            }

        },
        verDocumento(item){
            window.open(item.url, '_blank');
        },

        abrirModalEliminar(item){
            this.docSeleccionado = item;
            this.dialogEliminar = true;
        },

        async eliminarDocumento(item){
            await axios.delete(`/admin/documentos/eliminar/${item.id}`)
             .then(response => {
                this.text = "Documento eliminado"
                this.snackbar = true
                this.getDocuments()
             }, error => {
                if (error.response.status === 401) {
                    this.dialogError = true;
                    return error;
                }
             });
            this.docSeleccionado = null;
            this.dialogEliminar = false;
        },

        async descargarExcel(item){
            window.location.href ="/admin/documentos/excel/"+item.id_area+"/"+item.id_persona, '_blank';
            // await axios.get("/admin/documentos/excel/"+item.id_area+"/"+item.id_persona)
            //  .then(response => {
            //      console.log(response);
            //  });
        },

        async desbloquear( item ){
            await axios.get(`/admin/documentos/desbloquearBienes/${item.id}`);
            this.getDocuments()
            this.text = "Bienes Desbloquedos"
            this.snackbar = true
        },
        Filtrar (){
            this.getDocuments()
        }

    },

    watch: {

    },
};
</script>

<style>
.wrapper-page {
    width: 100%;
    height: 100%;
    background-color: #fafafa;
}

.page-heading {
    display: flex;
    justify-content: space-between;
}
.page-details {
    width: 256px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    border-right: 1px solid rgba(0, 0, 0, 0.1);
}
.page-search {
    display:flex;
    align-items:center;
    width: calc(100% - 0px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.content-wrapper {
    position: relative;
    display: flex;
    width: 100%;
    height: 100%;
}

.content {
    width: 100%;
    margin-left: 256px;
    transition: all 0.3s ease;
}
.filter{
    border-radius: 15px;
    border:solid 0.5px #cdcdcd;
    cursor:pointer;
}
.filter:hover{
    color:red;
}

.content.full {
    width: 100%;
    margin-left: 0;
}

@media (max-width: 960px) {
    .content {
        margin-left: 0;
    }

    .page-details {
        width: 200px;
    }
    .page-search {
        width: calc(100% - 200px);
    }
}

@media (max-width: 740px) {
    .page-details {
        width: 0px;
    }
    .page-search {
        width: calc(100% - 0px);
    }
}
</style>
