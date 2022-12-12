<template>
    <v-container>
        <v-card class="mt-3">
        <v-row class="inputs pl-3 pr-3"  style="margin-bottom: -30px;;">
            <v-col sx="12" sm="12" md="4" lg="4" style="mb-0 pt-0" class="p-0" >
                <v-text-field
                    v-model="ofi"
                    label="Dependencia"
                    hide-details
                    outlined
                    clearable
                    dense
                ></v-text-field>
            </v-col>
            <v-col sx="12" sm="12"  md="4" lg="4" style="" class="p-0" >
                <v-text-field
                    v-model="dep"
                    label="Oficina"
                    hide-details
                    outlined
                    clearable
                    dense
                ></v-text-field>
            </v-col>
            <v-col sx="12" sm="12"  md="4" lg="4" style="" class="p-0" >
                <v-autocomplete              
                    v-model="user"
                    clearable
                    dense
                    label="Usuarios"
                    outlined
                    :items="usuarios"
                    :filter="customFilter"
                    item-value="id"
                    item-text="nombres"
                    :search-input.sync="usuarios_search"
                    required
                >
                    <template v-slot:no-data>
                        <v-list-item>
                            <v-list-item-title>
                                <template>
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

        </v-row>

    <v-card>
        <v-card-title class="pa-0 py-3 pb-5">
      
            <v-spacer></v-spacer>   

            <div style="display: flex; justify-content:flex-end; align-items:center;">

            <div style=" margin-right:20px; height: 38px;">

                <v-menu
                    ref="menu"
                    v-model="menu"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date"
                        label="Fecha"
                        append-icon="mdi-calendar"
                        readonly
                        outlined
                        clearable
                        dense
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="date"
                    no-title
                    scrollable
                    >
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click="menu = false"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        text
                        color="primary"
                        @click="$refs.menu.save(date)"
                    >
                        OK
                    </v-btn>
                    </v-date-picker>
                </v-menu>
            </div>
            <div style=" height: 38px; margin-right: 0px;">
                <v-text-field
                class="mr-3"
                v-model="searchbienes"
                append-icon="mdi-magnify"
                outlined
                label="Buscar"
                dense
                hide-details
                >
                </v-text-field>
            </div>
        </div>
        </v-card-title>
        <v-data-table
            :headers="headBienes"
            :items="bienes"
            :search="searchbienes"
            :itemsPerPage="8"
            :mobile-breakpoint="10"
            >
            <template v-slot:item.corr_num="{ item }">
                <div>
                    <span>{{item.corr_area }} - {{ item.corr_num }} </span>
                </div>
            </template>
            <template v-slot:item.fecha="{ item }">
                <div>
                    <div>
                        <span>{{item.created_at.substring(0, 10)}}</span>
                    </div>   
                    <span>{{item.created_at.substring(11, 19)}}</span>
                </div>
            </template>  
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
                            </v-subheader>
                            <v-list-item-group
                                color="primary">

                            <v-list-item @click="detalle(item)">
                                <v-list-item-icon  style="margin-right: -10px;" >
                                    <v-icon color="primary" size="1.1rem">mdi-eye</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <span style="margin-left: 10px;" >Ver</span>
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
    </v-card>

                <v-dialog 
                    max-width="450"
                    v-model="dialogDetalle">
                    <v-card>
                    <v-card-title class="text-h5 primary">
                        <span style="color: white;">Detalles </span>
                    </v-card-title>

                    <v-card-text>
                        <!-- <verDetalleBien :item="item"/> -->
                        <div class="d-flex mt-3" v-if="datosDetalle !== null"  style="width:100%; background-color: #fff; align-items: center; justify-content:center;">
                            <div>
                                <div class="" style="font-weight: bold;">Codigo: </div>
                                <div><span>{{datosDetalle.codigo}}</span></div> 
                                <div class="">Oficina:</div>
                                <div> <span style="font-weight: bold;">{{datosDetalle.oficina}}</span></div>
                                <div class="">Dependencia: </div>
                                <div style="width: 200px;"><span>{{datosDetalle.dependencia}}</span></div>
                                <div class="" style="font-weight: bold;">Nombre: </div>
                                <div><span>{{datosDetalle.descripcion}}</span></div>
                            </div>
                            <div>
                                <div class="" style="font-weight: bold;">Responsable: </div>
                                <div><span>DNI: {{datosDetalle.pdni}}</span></div>
                                <div><span>{{datosDetalle.pnombre}} {{datosDetalle.paterno}} {{datosDetalle.materno}}</span></div>
                                <div class="" style="font-weight: bold;">Inventariador:</div>
                                <div> <span>{{datosDetalle.unombre}} {{ datosDetalle.uapellidos}}</span></div>
                                <div class="">-</div>
                                <div> <span></span></div>
                            </div>


                        </div>  
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        @click="cerrarDetalle()"
                    >
                        Ok
                    </v-btn>
                    </v-card-actions>
                </v-card>


                </v-dialog>

        </v-card>
    </v-container>
</template>
<script>
import Layout from "@/Layouts/FacilitadorLayout";
export default {
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    data: () => ({
        bienes:[],
        usuarios:[],
        ofi:null,
        dep:null,
        user:null,
        menu:false,
        date: null,
        usuarios_search:"",
        searchbienes:"",
        buscarBien: "",
        date:"",
        datosDetalle:null,
        headBienes: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', width:"120px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Nombre', align: 'start', filterable: true, value: 'descripcion',width:"60px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Marca', align: 'start', filterable: true, value: 'marca',width:"100px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Serie', align: 'start', filterable: true, value: 'nro_serie',width:"120px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Modelo', align: 'start', filterable: true, value: 'modelo',width:"120px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Oficina', align: 'center', filterable: true, value: 'id_area', width:"70px", class:'pl-0 pr-0 grey lighten-1' },
          { text: 'Etiqueta', align: 'center', filterable: false, sortable: true, width:"130px", value: 'corr_num', class:'pl-0 pr-0 grey lighten-1',},
          { text: 'Fecha', align: 'center', filterable: false, sortable: true, width:"130px", value: 'fecha', class:'pl-0 pr-0 grey lighten-1',},
          { align: 'right', value:'acciones', sortable: false, maxWidth:'30px', class:' pl-0 pr-0 grey lighten-1'},
        ],
        dialogDetalle: false,

    }),
    methods: {
        async getUsuarios(){
            let res = await axios.get("/facilitador/inventario/getUsuarios");
            this.usuarios = res.data.datos;
            return res.data.datos.data;
        },

        async getBienes(term = "", page = 1) {
            let res = await axios.post(
                "/facilitador/inventario/get-bienes-all-blank?page=" + page,
                { term: term, oficina:this.ofi, dependencia: this.dep, usuario: this.user, fecha: this.date }
            );
            this.bienes = res.data.datos.data;
        },

        customFilter(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            const apellidos = item.apellidos.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombres.indexOf(searchText) > -1 ||
                apellidos.indexOf(searchText) > -1
             );
        },
        detalle(item){
            this.datosDetalle = item;
            this.dialogDetalle = true;
        },
        cerrarDetalle(){
            this.datosDetalle = null;
            this.dialogDetalle = false;
        }

        
    },

    watch:{

        async ofi(){
            this.getBienes()
        },

        async dep(){
            this.getBienes()
        },

        async user(){
            this.getBienes()
        },
        async date(){
            this.getBienes()
        },
        async searchbienes(val) {
            if(val === null){
                this.buscarBien = "zzz";
            }
            
            // if (!val) return;
            

            if(this.ofi !== null){
                let res = await this.getBienes(val);
            }
            else{
                if(this.ofi !== null && this.dep !== null ){
                    let res = await this.getBienes(val);
                }
                else{
                    let res = await this.getBienes(
                        val,
                    );
                }

            }
            // this.bienes = res;
        },
    },

    created() {
        this.getBienes();
        this.getUsuarios();
    },


};
</script>
<style scoped>
@media (max-width: 600px) {
    .inputs{
        display: block;
        height: none;
    }
    

}
</style>