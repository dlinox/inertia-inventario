<template>
    <v-container>
        <v-row class="pl-3 pr-3 pt-3">
        <v-card class=" flex ">
            <div class="pl-2 pt-2 text-sm bold">Escoge un Area: </div>
            <v-card-title >
                <v-text-field
                style="margin-top:-10px;"
                :v-model="search"
                append-icon="mdi-magnify"
                single-line
                :label="areaElegida"
                @focus="abrirDialogArea"
                :append-outer-icon="'mdi-delete'"
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
        <v-btn height="100" class="ml-3" @click="generarPDF">Generar PDF</v-btn>
        </v-row>
        <div>
        <v-card class="mt-4" >
            <div class="pl-2 pt-2 text-sm bold">Escoge una Persona: </div>
            <v-card-title>
                <v-text-field
                :v-model="searchpersonas"
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
        areas: [],
        areaElegida: null,
        areE:null,
        perE:null,
        personas:[],
        searchpersonas: null,
      }
    },
    created() {
        this.getAreas()
        this.getPersonas()
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
        generarPDF(){
            let res = axios.get("/admin/pdfBienes/"+this.areE);
            this.areE = null;
            this.perE = null;
            this.personaElegida = null;
            this.areaElegida = null;
        }





    },
  }
</script>
