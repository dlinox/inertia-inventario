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

    <v-row style="" class="inputs" >

        <v-col sx="12" sm="12" md="4" lg="4" style=" margin:0px; padding: 0;" class="p-0 col-sm-12  col-xs-12 col-md-4  col-lg-4 col-xl-4" >

            <div class=" p-0" style="background:white; "  >
                    <v-card-title>
                        <v-text-field
                            hide-details
                            v-model="oficinaElegida"
                            append-icon="mdi-chevron-down"
                            label="Escoge una Oficina"
                            outlined
                            dense
                            clearable
                            @focus="abrirDialogOficina()"
                        ></v-text-field>
                        <!-- <v-btn v-if="areaElegida !== null" class="ml-1" @click="limpiar" style="width: 30px; height:30px; margin-top: -20px;" icon color="primary"  >
                            <v-icon size="1.5rem">mdi-close</v-icon>
                        </v-btn> -->
                        <!-- :label="areaElegida" -->
                    </v-card-title>

                    <div
                        :class="dialogOficina"
                        >
                        <v-data-table
                        :headers="headersoficinas"
                        :items="oficinas"
                        dense
                        hide-default-header
                        size="0.6rem"
                        :search="oficinaElegida"
                        hide-default-footer
                        class="pb-4"
                        style="height: 250px; overflow-y: scroll;"
                        >
                            <template v-slot:item.nombre ="{ item }">
                                    <div class="pt-1 pb-1" style="margin-left: -10px; ">
                                        {{ item.nombre}}
                                    </div>
                            </template>
                            <template v-slot:item.acciones ="{ item }">
                                <div class="pt-1 pb-1">
                                    <v-btn color="indigo" small  outlined dark @click="elegirOficina(item)"> Elegir</v-btn>
                                </div>
                            </template>
                        </v-data-table>
                    </div>
            </div>
        </v-col>

        <v-col sx="12" sm="12" md="4" lg="4" style="margin:0px; padding: 0;" class="p-0 col-xs-12 col-sm-12  col-md-4  col-lg-4 col-xl-4">
            <div class=" p-0" style="background:white;">
                    <v-card-title>
                        <v-text-field
                            hide-details
                            v-model="areaElegida"
                            append-icon="mdi-chevron-down"
                            label="Escoge un Area"
                            outlined
                            dense
                            clearable
                            @focus="abrirDialogArea()"
                        ></v-text-field>
                        <!-- <v-btn v-if="areaElegida !== null" class="ml-1" @click="limpiar" style="width: 30px; height:30px; margin-top: -20px;" icon color="primary"  >
                            <v-icon size="1.5rem">mdi-close</v-icon>
                        </v-btn> -->
                        <!-- :label="areaElegida" -->
                    </v-card-title>

                    <div
                        :class="dialogArea"
                        max-width="400"
                        >
                        <v-data-table
                        :headers="headersAreas"
                        :items="areas"
                        dense
                        hide-default-header
                        size="0.6rem"
                        :search="areaElegida"
                        hide-default-footer
                        class="pb-4"
                        style="height: 250px; overflow-y: scroll;"
                        >
                            <template v-slot:item.id ="{item } ">
                                <div class="pt-1 pb-1" >
                                    {{ item.id }}
                                </div>
                            </template>
                            <template v-slot:item.nombre ="{ item }">
                                    <div class="pt-1 pb-1" style="margin-left: -10px; ">
                                        {{ item.nombre}}
                                    </div>
                            </template>
                            <template v-slot:item.accion ="{ item }">
                                <div class="pt-1 pb-1">
                                    <v-btn color="indigo" small  outlined dark @click="elegirArea(item)"> Elegir</v-btn>
                                </div>
                            </template>
                        </v-data-table>
                    </div>
            </div>
        </v-col>

        <v-col sx="12" sm="12" md="4" lg="4" style="margin:0px; padding: 0;" class="p-0 col-sm-12  col-xs-12 col-md-4  col-lg-4 col-xl-4"  >
          <div class=" p-0 " style="background:white;" >
                <v-card-title>
                    <v-text-field
                        v-model="personaElegida"
                        append-icon="mdi-magnify"
                        outlined
                        clearable
                        dense
                        label="Selecciona una persona"

                        @focusin="abrirDialogPersona"
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
                    dense
                    :items="personas"
                    :search="personaElegida"
                    hide-default-header
                    hide-default-footer
                    style="height: 250px; overflow-y: scroll;"
                    >
                    <template v-slot:item.dni ="{ item }">
                        <div style="display:none;">
                            {{ item.id }} - {{item.dni}}
                        </div>
                    </template>
                    <template v-slot:item.nombres ="{ item }">
                        <div style="margin-left:-30px;">
                            <div>
                                <span> {{item.nombres}} {{item.paterno}} {{item.materno}}</span>
                            </div>

                            <div style="justify-content: space-between; display: flex; margin-bottom: 3px; align-items: center;">
                                <div>
                                    {{ item.id }} - {{item.dni}}
                                </div>
                                <div>
                                    <v-btn outlined color="indigo" small dark @click="elegirPersona(item)"> Elegir</v-btn>
                                </div>
                            </div>
                        </div>
                    </template>
                </v-data-table>
            </div>
           </div>

        </v-col>
    </v-row>

    <v-row v-if="PDF !== null" class="pl-4 pr-4 " style="background:white" >
        <iframe :src="PDF.url" style="width:100%; height:500px;" frameborder="0" ></iframe>
    </v-row>

        <div class="col-xs-12 p-3  pt-0 botones" >
            <div class="mt-4">
                <v-btn height="38" class="btn" dark color="primary" @click="generarPDF">Previsualizar</v-btn>
            </div>
            <div class="mt-4">
                <v-btn height="38" class="btn" dark color="primary" @click="Guardar" >Guardar PDF</v-btn>
            </div>
        </div>


    <!-- <v-card class="mt-4 p-0" >
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
       </v-card> -->
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
        dialogOficina: "d-none",
        dialogArea: "d-none",
        dialogPersona: "d-none",
        areaID: null,
        search: '',
        personaElegida:null,
        headersAreas: [
          { text: 'Codigo', align: 'start', filterable: true, maxWidth:'30', value: 'id', },
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombre', },
          { text: 'Acción', align: 'right', value:'accion' },
        ],
        headersPersonas: [
          { text: 'DNI', align: 'start', filterable: true, value: 'dni', },
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombres', },
        ],
        headersdocuments: [
          { text: 'Operaciones', align: 'center', value:'acciones' },
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', },
          { text: 'Responsable', align: 'start', filterable: true, value: 'dni_responsable', },
          { text: 'Area', align: 'start', filterable: true, value: 'id_area', },
        ],
        headersoficinas: [
          { text: 'codigo', align: 'start', filterable: true, value:'codigo' },
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombre', },
          { text: 'Asignar', align: 'center', value:'acciones' },
        ],
        areas: [],
        oficinas: [],
        areaElegida: null,
        areE:null,
        areEO:null,
        perE:null,
        ofiE:null,
        personas:[],
        oficinaElegida: null,
        documentoElegido: null,
        searchpersonas: null,
        searchoficinas: null,
        documentos:[],
        areas2:[],
        searchdocuments:null,
        snackbar: false,
        text: '',
        urltemp:'',
        PDF:null,
        timeout: 2000,
      }
    },
    created() {
        this.getAreas()
        this.getPersonas()
        this.getDocuments()
        this.getOficinas()
    },

    watch:{
        areaElegida: function(){
            this.getPersonas();
            this.buscabyOficinaID(this.areEO)

        },
        personaElegida: function(){
            this.getAreas();
        }
    },

    methods: {
        customFilterArea(item, queryText, itemText) {
            const nombre = item.nombre.toLowerCase();
            const id = item.id.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombre.indexOf(searchText) > -1 ||
                id.indexOf(searchText) > -1
            );
        },

        async getOficinas() {
            if (this.areaElegida === null ){
                let res = await axios.get("/admin/oficinas/getallOficinas");
                console.log(res.data);
                this.oficinas = res.data.datos;
                return res.data.datos.data;
            } else {
                if(this.areaElegida !== null ){

                }
            }
        },

        async getAreas() {

            if (this.personaElegida === null && this.oficinaElegida === null){
                let res = await axios.get("/admin/areas/getAreasAllInv");
                this.areas = res.data.datos;
                this.areas2 = res.data.datos;
                return res.data.datos.data;
            }
            else
            {
                if (this.oficinaElegida !== null  && this.personaElegida === null){
                    let res = await axios.get("/admin/areas/getAreasByOficinaInv/"+this.ofiE);
                    this.areas = res.data.datos;
                    return res.data.datos.data;
                }else {
                    if (this.oficinaElegida === null && this.personaElegida !== null ){
                        let res = await axios.get("/admin/areas/getAreasByPersonaInv/"+this.perE);
                        this.areas = res.data.datos;
                        return res.data.datos.data;
                    }

                }

            }

        },
        async getPersonas() {
            if (this.areaElegida === null ){
                let res = await axios.get("/admin/personas/getPersonasInv");
                console.log(res.data);
                this.personas = res.data.datos;
                return res.data.datos.data;
            }
            else {
                let res = await axios.get("/admin/personas/getPersonasByAreaInv/"+this.areE);
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
            this.areEO = item.id_oficina;
            this.areaElegida = item.id+' - '+item.nombre;
            this.cerrarDialogArea();
            console.log(item)
        },
        elegirOficina(item){
            this.ofiE = item.id;
            this.oficinaElegida = item.id+' - '+item.nombre;
            this.getAreas()
            this.cerrarDialogOficina();
            console.log(item)
        },
        elegirPersona(item){
            this.perE = item.id;
            // this.personaElegida = item.dni+' - '+item.nombres;
            this.personaElegida = item.nombres;
            this.cerrarDialogPersona();
            console.log(item)
        },

        abrirDialogArea(){
            if(this.dialogArea === 'show'){
                this.dialogArea = "d-none";
            }else {
                if(this.dialogArea === 'd-none') {
                    this.dialogArea = 'show';
                }
            }

        },
        abrirDialogOficina(){
            this.dialogOficina = "show";
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
        cerrarDialogOficina(){
            this.dialogOficina = "d-none";
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
        buscabyOficinaID(id){
            console.log(id)
            for(let i in this.oficinas){
                if (this.oficinas[i] === id ){
                    this.ofiE = this.oficinas[i].id
                    this.oficinaElegida = this.oficinas[i].nombre
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
            let res = axios.get("/admin/pdfBienes/"+this.perE+"/"+this.areE)
            .then(response => {
                 console.log(response);
                 this.PDF=response.data.datos;
             });
            // this.actualizar()
            // this.areE = null;
            // this.perE = null;
            // this.personaElegida = null;
            // this.areaElegida = null;
            // this.getDocuments();
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
        },
        async Guardar() {
            this.PDF['id_persona'] = this.perE;
            let res = await axios.post(
                "/admin/documentos/guardar",
                this.PDF
            );
            console.log(res.data);
            if (this.is_nuevo) {
                this.$refs.form_user.reset();
            }

        },


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
    .inputs{
        display: block;
    }

}
</style>
