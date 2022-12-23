<template>
<v-container  style="background:white;">
  <div class="" style="background:white;">
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
    <v-row style="background: white; margin-bottom:-25px;" >
        <v-col md="9" lg="9">
            <h3>Cargo de bienes </h3>
        </v-col>
        <v-col md="3" lg="3" class="right" style="text-align: right; margin-bottom:-20px;">
            <v-autocomplete   
                v-model="opcion"
                :items="opciones"
                label="Tipo"
                outlined
                item-value="value"
                item-text="name"
                dense
            ></v-autocomplete>

        </v-col>
    </v-row>
    <v-row class="inputs" style="background: white">
        <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class=" " >
            <v-autocomplete
                v-model="areE"
                clearable
                dense
                label="Oficina"
                outlined
                :items="oficinas"
                :filter="customFilter"
                item-value="iduoper"
                item-text="nombres"
                :search-input.sync="oficinas_search"
                required
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>
                            <template v-if="oficinas_search?.length > 0">
                                <!-- Datos no encontrados para -->
                                <!-- <strong>
                                    {{ oficinas_search }}
                                </strong> -->
                            </template>
                            <template v-else>
                                No hay registros en el inventario
                            </template>
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.iduoper">
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ data.item.nombres }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>

        </v-col>

        <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class="p-0" >
            <v-autocomplete
                v-model="perE"
                clearable
                class="mt-0 pt-0"
                dense
                label="Persona"
                outlined
                :items="personas"
                :filter="customFilterPersona"
                item-value="id"
                item-text="nombre"
                :search-input.sync="personas_search"
                required
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>
                            <template v-if="oficinas_search?.length > 0">
                                Datos no encontrados para
                                <strong>
                                    {{ oficinas_search }}
                                </strong>
                            </template>
                            <template v-else>
                                No hay registros en el inventario
                            </template>
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.dni">
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ data.item.nombres }} {{ data.item.paterno }} {{ data.item.materno }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>
        </v-col>

        <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class="p-0" >
            <v-autocomplete
                v-model="perE2"
                clearable
                class="mt-0 pt-0"
                dense
                label="2DO Responsable"
                outlined
                :items="personas2"
                :filter="customFilterPersona2"
                item-value="id"
                item-text="nombres"
                :search-input.sync="personas_search2"
                required
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>
                            <template v-if="oficinas_search?.length > 0">
                                Datos no encontrados para
                                <strong>
                                    {{ oficinas_search }}
                                </strong>
                            </template>
                            <template v-else>
                                No hay registros en el inventario
                            </template>
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.dni">
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ data.item.nombres }} {{ data.item.paterno }} {{ data.item.materno }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>
        </v-col>

    </v-row>
     <!-- {{ registrado }}  -->
    <div style=" overflow-y:hidden; width:100%; margin-top:30px; height:425px;" class="contenedorIframe" >
        <div  v-if="areE !== null && perE !== null"  class="by-preview" style="transform:scale(1);">
            <iframe :src="preview" scrolling="yes" frameborder="0" style=" padding-top:-30px;  border:solid 0.5px #cdcdf4;"> </iframe>
        </div>
    </div>
    <v-col style="display: flex; justify-content:flex-end;" sx="12" sm="12" md="12" lg="12" >
        <div class="ml-2">
            <v-btn height="38" small class="btn" outlined dark color="primary" @click="generarPDFCubiculos">Imp Cubiculo</v-btn>
        </div>
        <div class="ml-2">
            <v-btn height="38" small class="btn" outlined dark color="primary" @click="generarPDFBorrador">Borrador</v-btn>
        </div>

        <div class="ml-2" v-if="registrado === 0">
            <v-btn height="38" small class="btn" dark color="primary" @click="dialogGuardar">Imprimir</v-btn>
        </div>
        <div class="ml-2" v-if="registrado === 1">
            <v-btn v-if="opcion !== 2" height="38" small class="btn" color="grey-100" @click="dialogBloq">Impreso</v-btn>
            <v-btn v-if="opcion === 2" height="38" small class="btn" dark color="primary" @click="dialogGuardar">Imprimir</v-btn>
        </div>


        <!-- <div class=" ml-2" small>
            <v-btn height="38" class="btn" dark color="primary" @click="Guardar" >Guardar PDF</v-btn>
        </div> -->
    </v-col>

    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            persistent
            max-width="300"
            >
            <v-card>
            <v-card-title class="text-h6 white--text primary lighten-1">
                    Advertencia!
            </v-card-title>
            <v-card-text>
                <h4 class="mt-4 m-2" style="text-align:center;" >
                    {{ mensaje }} <span v-if="docSeleccionado !== null"> <span color="black"> {{docSeleccionado.dni}} </span> de {{ docSeleccionado.nombre }} </span>
                </h4>
            </v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn  
                color="danger darken-1"
                outlined
                text
                @click="dialog = false"
            >
                Cancelar
            </v-btn>
            <v-btn
                color="primary lighten-1"
                @click="generarPDF"
            >
                Continuar
            </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
    </v-row>

    <v-row justify="center">
        <v-dialog
            v-model="dialogBloqueado"
            persistent
            max-width="300"
            >
            <v-card>
            <v-card-title class="text-h6 white--text primary lighten-1">
                    Advertencia!
            </v-card-title>
            <v-card-text>
                <h4 class="mt-4 m-2" style="text-align:center;" >
                    Ya se  generó un documento para <span v-if="docSeleccionado !== null"> <span color="black"> {{docSeleccionado.dni}} </span> de {{ docSeleccionado.nombre }}, si desea continuar debe desbloquear el documento {{docSeleccionado.codigo }} </span>
                </h4>
            </v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="danger darken-1"
                outlined
                text
                @click="dialogBloqueado = false"
            >
                Cancelar
            </v-btn>
            <v-btn
                color="primary lighten-1"
                disabled
            >
                Continuar
            </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
    </v-row>



</div>


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
        url:'',
        dialog: false,
        preview:'',
        searchdocuments:"",
        areas: [],
        oficinas: [],
        personas:[],
        personas2:[],
        documentos:[],
        docSeleccionado: null,
        areEO:null,
        areE:null,
        perE:null,
        perE2:null,
        ofiE:null,
        snackbar: false,
        text: '',
        PDF:null,
        timeout: 2000,
        oficinas_search: "",
        areas_search: "",
        personas_search: "",
        personas_search2: "",
        data: [],
        mensaje:'',
        registrado:0,
        opcion:null,
        dialogBloqueado:false,
        borrador:null,
        doc:null,
        opciones:[
            {value:0,name:"Todos"},
            {value:1,name:"Registrados"},
            {value:2,name:"Adicionales"}
        ]

      }
    },
    created() {
        this.getPersonas()
        this.getOficinas()
        this.getDocumentos()
        this.opcion = 1
        this.getPersonas2()
    },

    watch:{
        areE: function(){
            this.getPersonas();
            this.Registrado(this.areE, this.perE)
            this.preview = null;
        },
        perE: function(){
            this.preview = '/admin/reportes/preview/'+this.areE+'/'+this.perE+'#toolbar=0';
            this.Registrado(this.areE, this.perE)
        },
        opcion: function(){
            if (this.opcion === 0 || this.opcion === 2){
                if(this. areE !== null && this.perE === null ) {
                    this.perE = null;
                    this.getPersonas();
                }
                else {
                    if(this.areE !== null && this.perE !== null) {
                        this.perE = null;
                        this.getPersonas();
                    }
                }
            }
            if (this.opcion === 1){
                if(this. areE !== null && this.perE === null ) {
                    this.perE = null;
                    this.getPersonas();
                }
                else {
                    if(this.areE !== null && this.perE !== null) {
                        this.perE = null;
                        this.getPersonas();
                    }
                }
            }

        }


    },

    methods: {
        customFilter(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            const iduoper = item.iduoper.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombres.indexOf(searchText) > -1 ||
                iduoper.indexOf(searchText) > -1
             );
        },

        customFilterPersona(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            const dni = item.dni.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombres.indexOf(searchText) > -1 ||
                dni.indexOf(searchText) > -1
             );
        },
        customFilterPersona2(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            const dni = item.dni.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombres.indexOf(searchText) > -1 ||
                dni.indexOf(searchText) > -1
             );
        },


        async getOficinas() {
            let res = await axios.get("/admin/oficinas/getallOficinas");
            console.log(res.data);
            this.oficinas = res.data.datos;
            return res.data.datos.data;
        },

        async getDocumentos() {
            let res = await axios.get("/admin/reportes/getDocuments");
            this.documentos = res.data.datos;
            return res.data.datos.data;
        },
        async getPersonas2() {
            let res = await axios.get("/admin/reportes/getPersonas2");
            this.personas2 = res.data.datos;
            return res.data.datos.data;
        },

        async getPersonas() {
            if (this.areE === null ){
                let res = await axios.get("/admin/personas/getPersonasInv");
                console.log(res.data);
                this.personas = res.data.datos;
                return res.data.datos.data;
            }
            else {
                if( this.areE !== null ){
                    if (this.opcion === 0 ){
                        let res = await axios.get("/admin/personas/getPersonasByAreaInv/"+this.areE);
                        console.log(res.data);
                        this.personas = res.data.datos;
                        return res.data.datos.data;
                    } else {
                        if (this.opcion === 1) {
                            let res = await axios.get("/admin/personas/getPersonasByAreaInvNoR/"+this.areE);
                            console.log(res.data);
                            this.personas = res.data.datos;
                            return res.data.datos.data;
                        }
                        else{
                            if (this.opcion === 2 ){
                                let res = await axios.get("/admin/personas/getPersonasForAdicionales/"+this.areE);
                                console.log(res.data);
                                this.personas = res.data.datos;
                                return res.data.datos.data;
                            }
                        }
                    }
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
        Registrado(idA, idP){
            this.registrado = 0;
            for(let i in this.documentos){
                if (this.documentos[i].id_area === idA && this.documentos[i].id_persona === idP ){
                    if(this.documentos[i].estado ===  0 ){
                        this.registrado = 1;
                    }
                    this.docSeleccionado = this.documentos[i];
                }
            }
        },
        dialogBloq(){
            this.dialogBloqueado = true;
        },
        dialogGuardar(){
            this.mensaje = "Se bloquearan todos los bienes de este documento y los inventariadores no podrán registrar más bienes para";
            this.dialog = true;
        },
        dialogImprimir(){
            this.mensaje = "Se bloquearan todos los bienes de este documento";
            this.dialog = true;
        },
        dialogBorrador(){
            this.mensaje = "Se ha impreso un cargo de bienes Borrador";
            this.dialog = true;
        },

         generarPDF(){
            this.doc = {
                area:this.areE,
                persona:this.perE,
                opcion:this.opcion
            }
            this.dialog = false;
            let res = axios.post("/admin/pdfBienes",this.doc)
            .then(response => {
                 console.log(response);
                 this.PDF=response.data.datos;
//                 this.url = this.PDF.url+"#toolbar=0";
                //    this.PrintPdf(this.PDF.url);
                //    this.url = this.PDF.url;
                //    console.log(response);
                 this.PDF=response.data.datos;
                 this.url = response.data.datos.url;
                 this.PrintPdf(this.url);
             });
            this.text = "Documento Guardado"
            this.snackbar = true
            this.getDocumentos()
            this.areE = null;
            this.perE = null;
        },

        generarPDFBorrador() {
            let res = axios.get("/admin/pdfBienesB/"+this.perE+"/"+this.areE)
            .then(response => {
                 console.log(response);
                 this.PDF=response.data.datos;
                 this.url = response.data.datos.url;
                 this.PrintPdf(this.url);
             });
            // console.log("URDL: ",this.url); 
            // this.PrintPdf(this.url);    
            this.text = "Documento Borrador Generado"
            this.snackbar = true
            this.areE = null;
            this.perE = null;
        },

        generarPDFCubiculos() {
            this.doc = {
                area:this.areE,
                persona:this.perE,
                persona2:this.perE2,
            }
            let res = axios.post("/admin/pdfCubiculos",this.doc)
            .then(response => {
                 console.log(response);
                 this.PDF=response.data.datos;
                 this.url = response.data.datos.url;
                 this.PrintPdf(this.url);
                 this.text = "Documentos Generados"
                 this.snackbar = true
             });

            // this.areE = null;
            // this.perE = null;
            // this.perE2 = null; 
        },

        async Guardar() {
            this.PDF['id_persona'] = this.perE;
            let res = await axios.post(
                "/admin/documentos/guardar",
                this.PDF
            );


        },

        PrintPdf (URL) {
            var iframe = document.createElement('iframe');
            iframe.style.display = "none";
            iframe.src = URL;
            document.body.appendChild(iframe);
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }

    },
  }
</script>
<style scoped>
.selec{
    color: #0808a7;
    font-weight: bold;
}
.by-preview{
    width:100%;
    height:100%;
    min-width:1070px;
}
iframe{
border:none;
width: 100% !important;
  height: 100% !important;
  scale:(0.7);
}
.padre{
   overflow-x: visible;
   white-space: nowrap;
  }
.contenedorIframe{
    background: none;
}
.hijo{
    transform: scale(0.6)
}
@media (max-width: 600px) {
    .contenedorIframe{
        overflow-x:scroll;
    }
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
