<template>
    <v-container>
        <v-row class="pl-3 pr-3 pt-0">
            <v-card class="mt-4 p-0 flex"        >
            <div class="pl-3 pt-2 text-sm bold">Escoge una Persona: </div>
            <v-card-title>
                <v-text-field
                :v-model="search"
                style="margin-top:-30px;"
                append-icon="mdi-magnify"
                single-line
                :label="areaElegida"
                @focus="abrirDialogArea"
                hide-details
            ></v-text-field>

            </v-card-title>
            <div
            :class="dialogArea"
            max-width="900"
            >
            <v-data-table
            :headers="headersAreas"
            :items="areas"
            :search="search"
            >
            <template v-slot:item.accion ="{ item }">
                 <div>
                    <v-btn color="success" dark text @click="elegirArea(item)"> Elegir</v-btn>
                </div>
            </template>

            </v-data-table>
            </div>
       </v-card>
        <div class="mt-4">
            <v-btn height="75" class="ml-3" @click="generarPDF">Generar PDF</v-btn>
        </div>
            </v-row>
        <div>
        <v-card class="mt-4 p-0" >
            <div class="pl-3 pt-2 text-sm bold">Escoge una Persona: </div>
            <v-card-title>
                <v-text-field
                :v-model="searchpersonas"
                style="margin-top:-30px;"
                append-icon="mdi-magnify"
                single-line
                :label="personaElegida"
                @focus="abrirDialogPersona"
                hide-details
            ></v-text-field>

            </v-card-title>
            <div
            :class="dialogPersona"
            max-width="900"
            >
            <v-data-table
            :headers="headersPersonas"
            :items="personas"
            :search="searchpersonas"
            >
            <template v-slot:item.acciones ="{ item }">
                 <div>
                    <v-btn color="success" dark text @click="elegirPersona(item)"> Elegir</v-btn>
                </div>
            </template>

            </v-data-table>
            </div>
       </v-card>
        </div>

        <v-card class="mt-4 p-0" >
            <div class="pl-3 pt-2 text-sm bold">Documentos Creados: </div>
            <v-card-title>
                <v-text-field
                :v-model="searchdocuments"
                style="margin-top:-30px;"
                append-icon="mdi-magnify"
                single-line
                hide-details
            ></v-text-field>

            </v-card-title>
            <div
            max-width="900"
            >
            <v-data-table
            :headers="headersdocuments"
            :items="documentos"
            :search="searchdocuments"
            >
            <template v-slot:item.id_area="{ item }">
                 <div class="flex">
                    {{ buscaAreabyID(item.id_area) }}
                </div>
            </template>
            <template v-slot:item.acciones="{ item }">
                 <div class="flex">
                    <v-btn class="ml-4" icon color="primary" @click="verDocumento(item)" >
                        <v-icon>mdi-eye</v-icon>
                    </v-btn>
                    <v-btn icon color="pink" @click="eliminarDocumento(item)" >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </div>
            </template>

            </v-data-table>
            </div>
       </v-card>
    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import { assertBinary, throwStatement } from "@babel/types";
export default {
    metaInfo: { title: "Personas" },
    layout: Layout,
    data () {
      return {
        dialog: false,
        dialogArea: "d-none",
        dialogPersona: "d-none",
        areaID: null,
        search: '',
        personaElegida:null,
        headersAreas: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'id', },
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombre', },
          { text: 'Acción', align: 'center', value:'accion' },
        ],
        headersPersonas: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'id', },
          { text: 'DNI', align: 'start', filterable: true, value: 'dni', },
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombres', },
          { text: 'A. Paterno', align: 'start', filterable: true, value: 'paterno', },
          { text: 'A. Materno', align: 'center', filterable: true, value: 'materno', },
          { text: 'Asignar', align: 'center', value:'acciones' },
        ],
        headersdocuments: [
          { text: 'Operaciones', align: 'center', value:'acciones' },
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', },
          { text: 'Responsable', align: 'start', filterable: true, value: 'dni_responsable', },
          { text: 'Area', align: 'start', filterable: true, value: 'id_area', },
        ],
        areas: [],
        areaElegida: null,
        areE:null,
        perE:null,
        personas:[],
        documentoElegido: null,
        searchpersonas: null,
        documentos:[],
        searchdocuments:null,
      }
    },
    created() {
        this.getAreas()
        this.getPersonas()
        this.getDocuments()
    },
    onMounted() {
        this.getAreas()
    },

    watch:{
        areaElegida: function(){
            this.getPersonas();
        },
        personaElegida: function(){
            this.getAreas();
        }
    },

    methods: {
        async getAreas() {
            console.log("VER::: ", this.perE)
            if (this.personaElegida === null ){
                let res = await axios.get("/admin/areas/getAreas");
                this.areas = res.data.datos;
                return res.data.datos.data;
            } else {
                let res = await axios.get("/admin/areas/getAreasByPersona/"+this.perE);
                this.areas = res.data.datos;
                return res.data.datos.data;
            }

        },
        async getPersonas() {
            if (this.areaElegida === null ){
                let res = await axios.get("/admin/personas/getPersonas");
                console.log(res.data);
                this.personas = res.data.datos;
                return res.data.datos.data;
            }
            else {
                let res = await axios.get("/admin/personas/getPersonasByArea/"+this.areE);
                console.log(res.data);
                this.personas = res.data.datos;
                return res.data.datos.data;
            }
        },

        async getDocuments() {
            let res = await axios.get("/admin/documentos/getDocuments");
            console.log(res.data);
            this.documentos = res.data.datos;
            return res.data.datos.data;
        },

        elegirArea(item){
            this.areE = item.id;
            this.areaElegida = item.id+' - '+item.nombre;
            this.cerrarDialogArea();
            console.log(item)
        },
        elegirPersona(item){
            this.perE = item.id;
            this.personaElegida = item.dni+' - '+item.nombres;
            this.cerrarDialogPersona();
            console.log(item)
        },

        abrirDialogArea(){
            this.dialogArea = "show";
        },
        abrirDialogPersona(){
            this.dialogPersona = "show";
        },
        cerrarDialogArea(){
            this.dialogArea = "d-none";

        },
        cerrarDialogPersona(){
            this.dialogPersona = "d-none";

        },
        async asignar(item){

            let res = await axios.put("/admin/areas/asignarPersona/"+this.areaID, item);
            this.dialog = false;
            this.areaID = null;
            this.getAreas()
            return res.data.datos;
        },
        buscabyID(id){
            for(let i in this.personas){
                if (this.personas[i].id === id ){
                    return this.personas[i].dni
                }

            }
        },
        buscaAreabyID(id){
            for(let i in this.areas){
                if (this.areas[i].id === id ){
                    return this.areas[i].nombre
                }

            }
        },
        generarPDF(){
            let res = axios.get("/admin/pdfBienes/"+this.areE);
            this.areE = null;
            this.perE = null;
            this.personaElegida = null;
            this.areaElegida = null;
            this.getDocuments();
        },


        verDocumento(item){
            window.open(item.url, '_blank');
        },

        async eliminarDocumento(item){
            await axios.delete(`/admin/documentos/eliminar/${item.id}`)
             .then(response => {
                 console.log(response);
             });
        }




    },
  }
</script>
