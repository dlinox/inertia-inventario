<template>
<v-container  style="background:white;">
    <div class="" style="background:white;">  
        <v-row style="background: white; margin-bottom:-25px;" >
            <v-col md="9" lg="9">
                <h3>Bienes </h3>
            </v-col>
        </v-row>
        <v-row class="inputs" style="background: white">
            <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class=" " >
                <v-autocomplete
                    v-model="ofiE"
                    clearable
                    dense
                    label="Oficina"
                    outlined
                    :items="oficinas"
                    :filter="customFilter"
                    item-value="id"
                    item-text="nombre"
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
                            <v-list-item-title v-html="data.item.codigo">
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ data.item.nombre }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-autocomplete>
    
            </v-col>
            <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class="p-0 " >
                <v-autocomplete
                    v-model="areE"
                    clearable
                    class="mt-0 pt-0"
                    dense
                    label="Area"
                    outlined
                    :items="areas"
                    :filter="customFilterAreas"
                    item-value="id"
                    item-text="nombre"
                    :search-input.sync="areas_search"
                    required
                >
                    <template v-slot:no-data>
                        <v-list-item>
                            <v-list-item-title>
                                <template >
                                    No hay registros
                                </template>
                            </v-list-item-title>
                        </v-list-item>
                    </template>
    
                    <template v-slot:item="data">
                        <v-list-item-content>
                            <v-list-item-title v-html="data.item.codigo">
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ data.item.nombre }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-autocomplete>
            </v-col>
    
            <!-- <pre>{{personas}}</pre> -->
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
                    item-text="nombres"
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
        </v-row>
        <div class="mt-6" >
            <!-- <pre>{{ bienes }}</pre>  -->
            <div class="d-flex mb-3" style="justify-content: flex-end; ">
                <v-text-field
                    v-model="buscarBien"
                    append-icon="mdi-magnify"
                    label="Buscar"
                    hide-details
                    outlined
                    clearable
                    dense
                    style="max-width: 300px;"
                ></v-text-field>
            </div>
            <div>
            <v-simple-table>
                <template v-slot:default>
                    <thead class="grey lighten-1">
                        <tr>
                            <th class="text-left">Código</th>
                            <th class="text-left">Descripcion</th>
                            <th class="text-left">Estado</th>
                            <th class="text-left">Observacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in bienes"
                            :key="index"
                        >
                            <td>{{ item.codigo }}</td>
                            <td>{{ item.descripcion }}</td>
                            <td>
                                {{ item.estado }}
                            </td>

                            <td>
                                {{ item.nombre }}
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
            </div>
            <div>
                <v-pagination
                    v-model="page"
                    class=""
                    :length="pages"
                    :total-visible="5"
                    ></v-pagination>
            </div>

            <!-- <pre>{{bienes}}</pre> -->
        </div>
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

            searchdocuments:"",
            areas: [],
            oficinas: [],
            personas:[],
    
            areEO:null,
            areE:null,
            perE:null,
            ofiE:null,
 
            oficinas_search: "",
            areas_search: "",
            personas_search: "",
            data: [],
            registrado:0,
            opcion:1,
            pages:null,
            page:null,
            total_result:null,

            buscarBien: "",
            bienes:[],


           }
        },
        created() {
            this.getAreas()
            this.getPersonas()
            this.getOficinas()
            this.getBienes()
        },
    
        watch:{
            areE: function(){
                this.getPersonas();
                this.perE = null;
                if(this.areE !== null){
                    this.getBienesArea();
                }
                if(this.areE === null){
                    this.getBienesArea()
                    this.perE=null
                }

            },

            perE: function(){
                this.getPersonas();
                if(this.perE != null){
                    this.getBienesArea();
                }
                if(this.perE === null){
                    this.getBienesArea()
                }

            },

            ofiE: function(){
                this.getAreas();
                this.areE = null;
                this.perE = null;
            },

            async buscarBien(val) {
                if(val === null){
                    this.buscarBien = "zzz";
                }
                
                // if (!val) return;
                

                if(this.areE !== null){
                    let res = await this.getBienesArea(val);
                }
                else{
                    if(this.areE !== null && this.areE !== null ){
                        let res = await this.getBienesArea(val);
                    }
                    else{
                        let res = await this.getBienes(
                            val,
                        );
                    }

                }
                // this.bienes = res;
            },
            async page(val, old_val) {
                if (!val) return;
                if (val == old_val) return;
                //this.loading_table = true;
                let res = await this.getBienes(
                    this.buscarBien,
                    val
                );
            },
    
        },
    
        methods: {
            customFilter(item, queryText, itemText) {
                const nombre = item.nombre.toLowerCase();
                const codigo = item.codigo.toLowerCase();
                const searchText = queryText.toLowerCase();
                return (
                    nombre.indexOf(searchText) > -1 ||
                    codigo.indexOf(searchText) > -1
                 );
            },
    
            customFilterAreas(item, queryText, itemText) {
                const nombre = item.nombre.toLowerCase();
                const codigo = item.codigo.toLowerCase();
                const searchText = queryText.toLowerCase();
                return (
                    nombre.indexOf(searchText) > -1 ||
                    codigo.indexOf(searchText) > -1
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
    
            async getOficinas() {
                if (this.areE === null ){
                    let res = await axios.get("/facilitador/oficina/get-oficinas");
                    console.log(res.data);
                    this.oficinas = res.data.datos;
                    return res.data.datos.data;
                } else {
                    if(this.areE !== null ){
    
                    }
                }
            },
    
            async getAreas() {
                if (this.ofiE === null){
                    let res = await axios.get("/facilitador/area/get-areas");
                    this.areas = res.data.datos;
                    this.areas2 = res.data.datos;
                    return res.data.datos.data;
                }
                else
                {
                    if (this.ofiE !== null ){
                        let res = await axios.get("/facilitador/area/get-areas-oficina/"+this.ofiE);
                        this.areas = res.data.datos;
                        return res.data.datos.data;
                    }
    
                }
    
            },

            async getPersonas(){

                if( this.areE !== null ){
                    let res = await axios.get("/facilitador/persona/getPersonasByAreaInv/"+this.areE);
                    console.log(res.data);
                    this.personas = res.data.datos;
                    return res.data.datos.data;
                }
            },

            async getBienes(term = "", page = 1) {
                let res = await axios.post(
                    "/facilitador/inventario/get-bienes-area?page=" + page,
                    { term: term }
                );

                this.pages = res.data.datos.current_page;
                this.total_result = res.data.datos.total;
                this.pages = res.data.datos.last_page;
                this.bienes = res.data.datos.data;
            },

            async getBienesArea(term = "", page = 1) {
                let res = await axios.post(
                    "/facilitador/inventario/get-bienes-area?page=" + page,
                    { term: term, id_area: this.areE, id_persona: this.perE }
                );

                this.pages = res.data.datos.current_page;
                this.total_result = res.data.datos.total;
                this.pages = res.data.datos.last_page;
                this.bienes = res.data.datos.data;
            },
        },

            // async getPersonas() {
            //     if (this.areE === null ){
            //         let res = await axios.get("/facilitador/persona/getPersonasInv");
            //         console.log(res.data);
            //         this.personas = res.data.datos;
            //         return res.data.datos.data;
            //     }
            //     else {
            //         if( this.areE !== null ){
            //             if (this.opcion === 0){
            //                 let res = await axios.get("/facilitador/persona/getPersonasByAreaInv/"+this.areE);
            //                 console.log(res.data);
            //                 this.personas = res.data.datos;
            //                 return res.data.datos.data;
            //             }
            //         }
            //     }
            // },
       
        
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
    