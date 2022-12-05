<template>
    <v-container>
        <v-row class="inputs mb-2" style="background: white">
        <v-col sx="12" sm="12" md="4" lg="4" style="" class=" " >
            <v-text-field
                v-model="ofi"
                label="Oficina"
                hide-details
                outlined
                clearable
                dense
            ></v-text-field>
        </v-col>
        <v-col sx="12" sm="12" md="4" lg="4" style="" class="p-0" >
            <v-text-field
                v-model="dep"
                label="Dependencia"
                hide-details
                outlined
                clearable
                dense
            ></v-text-field>
        </v-col>
        <v-col sx="12" sm="12" md="4" lg="4" style="" class="p-0" >
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
                            <template v-if="usuarios_search?.length > 0">
                                <!-- Datos no encontrados para -->
                                <!-- <strong>
                                    {{ usuarios_search }}
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
        <v-col sx="12" sm="12" md="4" lg="4" style="" class="p-0" >
            <v-text-field
            v-model="searchbienes"
            append-icon="mdi-magnify"
            outlined
            label="Buscar"
            dense
            hide-details
            >
            </v-text-field>
        </v-col>
    </v-row>
        <v-data-table
            :headers="headBienes"
            :items="bienes"
            :search="searchbienes"
            :itemsPerPage="10"
            :mobile-breakpoint="10"
            >
            <template v-slot:item.corr_num="{ item }">
                <div>
                    <span>{{item.corr_area }} - {{ item.corr_num }} </span>
                </div>
            </template>
            <template v-slot:item.fecha="{ item }">
                <div>
                   <span>{{item.fecha }} </span>
                </div>
                <div>
                    <span>{{item.hora }} </span>
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

                            <v-list-item @click="dialogDetalle = true">
                                <v-list-item-icon  style="margin-right: -10px;" >
                                    <v-icon color="primary" size="1.1rem">mdi-eye</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <span style="margin-left: 10px;" >Ver</span>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item @click="eliminar(item)">
                                <v-list-item-icon  style="margin-right: -10px;" >
                                    <v-icon color="primary" size="1.1rem">mdi-delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <span style="margin-left: 10px;" >Eliminar</span>
                                </v-list-item-content>
                            </v-list-item>
                            </v-list-item-group>

                        </v-list>
                    </v-menu>
                </div>
    
                <v-dialog 
                max-width="450"
                v-model="dialogDetalle">
                    <v-card>
                    <v-card-title class="text-h5 primary">
                        <span style="color: white;">Detalles </span>
                    </v-card-title>

                    <v-card-text>
                        <verDetalleBien :item="item"/>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        @click="dialogDetalle = false"
                    >
                        Ok
                    </v-btn>
                    </v-card-actions>
                </v-card>


                </v-dialog>
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


    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import verDetalleBien from "./Components/verDetalleBien.vue";
export default {
    components:{verDetalleBien},
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    data: () => ({
        bienes:[],
        usuarios:[],
        ofi:null,
        dep:null,
        user:null,
        usuarios_search:"",
        searchbienes:"",
        buscarBien: "",
        headBienes: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', width:"120px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Nombre', align: 'start', filterable: true, value: 'descripcion',width:"60px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Oficina', align: 'center', filterable: true, value: 'id_area', width:"70px", class:'pl-0 pr-0 grey lighten-1' },
          { text: 'Etiqueta', align: 'center', filterable: false, sortable: true, width:"130px", value: 'corr_num', class:'pl-0 pr-0 grey lighten-1',},
          { text: 'Fecha', align: 'center', filterable: false, sortable: true, width:"130px", value: 'fecha', class:'pl-0 pr-0 grey lighten-1',},
          { align: 'right', value:'acciones', sortable: false, maxWidth:'30px', class:' pl-0 pr-0 grey lighten-1'},
        ],
        dialogDetalle: false,

    }),
    methods: {
        async getUsuarios(){
            let res = await axios.get("/admin/inventario/getUsuarios");
            this.usuarios = res.data.datos;
            return res.data.datos.data;
        },

        async getBienes(term = "", page = 1) {
                let res = await axios.post(
                    "/admin/inventario/get-bienes-all?page=" + page,
                    { term: term, oficina:this.ofi, dependencia: this.dep, usuario: this.user }
                );
                this.bienes = res.data.datos.data;
            },

        async eliminar(item){
            await axios.delete(`/admin/inventario/eliminarbienadmin/${item.id}`)
            .then(response => {
                this.text = "Documento eliminado"
                this.snackbar = true
                this.getBienes()
            }, error => {
                if (error.response.status === 401) {
                    this.dialogError = true;
                    return error;
                }
            });
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
    }

}
</style>