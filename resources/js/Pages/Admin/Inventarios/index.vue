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

                        <v-list-item @click="eliminar(item)">
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
    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
export default {
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    data: () => ({
        bienes:[],
        ofi:null,
        dep:null,
        searchbienes:"",
            buscarBien: "",
        headBienes: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', width:"120px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Nombre', align: 'start', filterable: true, value: 'descripcion',width:"60px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Oficina', align: 'center', filterable: true, value: 'id_area', width:"70px", class:'pl-0 pr-0 grey lighten-1' },
          { text: 'Etiqueta', align: 'center', filterable: false, sortable: true, width:"70px", value: 'corr_num', class:'pl-0 pr-0 grey lighten-1',},
          { align: 'right', value:'acciones', sortable: false, maxWidth:'30px', class:' pl-0 pr-0 grey lighten-1'},
        ],

    }),
    methods: {
        // async getBienes(){ 
        //     let res = await axios.get("/admin/inventario/getBiens");
        //     this.bienes = res.data.datos;
        //     return res.data.datos.data;
        // },

        async getBienes(term = "", page = 1) {
                let res = await axios.post(
                    "/admin/inventario/get-bienes-all?page=" + page,
                    { term: term, oficina:this.ofi, dependencia: this.dep }
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
        
    },

    watch:{

        async ofi(){
            this.getBienes()
        },

        async dep(){
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
        this.getBienes()
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