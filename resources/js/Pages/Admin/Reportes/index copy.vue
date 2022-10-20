<template>
    <v-container>
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


    <v-row class="pl-3 pr-3">
        <div class=" pt-0 flex">
            <v-card class="mt-4 p-0"        >
                <div class="pl-3 pt-2 text-sm bold">Escoge un Area: </div>
                    <v-card-title>
                        <v-text-field
                            style="margin-top:-30px;"
                            hide-details
                            v-model="search"
                            append-icon="mdi-magnify"
                            :label="areaElegida"
                            single-line
                            @focus="abrirDialogArea"
                        ></v-text-field>
                        <v-btn v-if="areaElegida !== null" class="ml-1" @click="limpiar" style="width: 30px; height:30px; margin-top: -20px;" icon color="primary"  >
                            <v-icon size="1.5rem">mdi-close</v-icon>
                        </v-btn>
                        <!-- :label="areaElegida" -->
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
                                    <v-btn color="indigo" outlined dark @click="elegirArea(item)"> Elegir</v-btn>
                                </div>
                            </template>
                        </v-data-table>
                    </div>
            </v-card>
            <v-card class="mt-4 p-0">
            <div class="pl-3 pt-2 text-sm bold">Escoge una Persona: </div>
                <v-card-title>
                    <v-text-field
                        v-model="searchpersonas"
                        style="margin-top:-30px;"
                        append-icon="mdi-magnify"
                        single-line
                        :label="personaElegida"
                        @focus="abrirDialogPersona"
                        hide-details
                        >
                    </v-text-field>
                    <v-btn v-if="areaElegida !== null" class="ml-1" @click="limpiar2" style="width: 30px; height:30px; margin-top: -20px;" icon color="primary"  >
                            <v-icon size="1.5rem">mdi-close</v-icon>
                    </v-btn>
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
                            <v-btn outlined color="indigo" dark @click="elegirPersona(item)"> Elegir</v-btn>
                        </div>
                    </template>
                </v-data-table>
            </div>
           </v-card>
        </div>
        <div class="col-xs-12 p-3 pl-3 pt-0 botones" >
            <div class="mt-4">
                <v-btn height="78" class="btn" dark color="primary" @click="generarPDF">Generar PDF</v-btn>
            </div>
            <div class="mt-4">
                <v-btn  height="78" @click="desbloquear" class="btn"> Desloquear </v-btn>
            </div>
        </div>
    </v-row>

    <v-card class="mt-4 p-0" >
        <div class="pl-3 pt-2 text-sm bold">Documentos Creados: </div>
            <v-card-title>
                <v-text-field
                    v-model="searchdocuments"
                    style="margin-top:-30px;"
                    append-icon="mdi-magnify"
                    single-line
                    hide-details
                    >
                </v-text-field>
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
                    <v-btn class="ml-0 p-0" style="width: 25px; height:25px;;" icon color="warning" @click="desbloqueardeLista(item)" >
                        <v-icon size="1.1rem">mdi-lock</v-icon>
                    </v-btn>
                    <v-btn class="ml-0" style="width: 25px; height:25px;;" icon color="primary" @click="verDocumento(item)" >
                        <v-icon size="1.1rem">mdi-eye</v-icon>
                    </v-btn>
                    <v-btn style="width: 25px; height:25px;;" icon color="pink" @click="eliminarDocumento(item)" >
                        <v-icon size="1.1rem">mdi-delete</v-icon>
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
import axios from 'axios';
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
        areas2:[],
        searchdocuments:null,
        snackbar: false,
        text: 'My timeout is set to 2000.',
        timeout: 2000,
      }
    },
    created() {
        this.getAreas()
        this.getPersonas()
        this.getDocuments()
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
                this.areas2 = res.data.datos;
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
            for(let i in this.areas2){
                if (this.areas2[i].id === id ){
                    return this.areas2[i].nombre
                }

            }
        },
        generarPDF(){
            let res = axios.get("/admin/pdfBienes/"+this.perE+"/"+this.areE);
            this.actualizar()
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
             this.text = "Documento eliminado"
             this.snackbar = true
             this.getDocuments()
        },

        async actualizar(){
            const resp = await axios.get("/admin/getAreaPersonSelected/"+this.perE+"/"+this.areE+";");
            console.log("centrate: ", resp.data[0])
            let res = await axios.put("/admin/bloquear/"+resp.data[0].id, resp[0]);
            this.getDocuments()
            this.text = "Nuevo Documento de cargo creado"
             this.snackbar = true
            return res.data.datos;
        },

        async desbloquear(){
            const resp = await axios.get("/admin/getAreaPersonSelected/"+this.perE+"/"+this.areE+";");
            console.log("centrate: ", resp.data[0])
            let res = await axios.put("/admin/desbloquear/"+resp.data[0].id, resp[0]);
            this.areE = null;
            this.perE = null;
            this.personaElegida = null;
            this.areaElegida = null;
            this.getDocuments()
            this.text = "Bienes Desbloquedos"
            this.snackbar = true
            return res.data.datos;

        },

        async desbloqueardeLista(item){
            console.log(item)
            let res = await axios.put("/admin/desbloquear/"+item.id_area_persona, item);
            this.text = "bienes Desbloquedos"
             this.snackbar = true
            this.getDocuments()
            return res.data.datos;
        },
        limpiar() {
            this.areaElegida = null;
            this.areE = null;
        },
        limpiar2() {
            this.perE = null;
            this.personaElegida = null;
        }
    },
  }
</script>
<style scoped>
@media (max-width: 600px) {
  .botones {
    width: 100%;
    justify-content: space-between;
    margin-left: -5px;
    margin-right: -10px;
    margin-bottom: 5px;
  }
  .btn{
    width: 100%;
  }
}
</style>
