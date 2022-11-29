<template>
    <v-container>
        <h1>Bienes</h1>
        <div style="width:300px; display:flex;" >
            <v-text-field
            v-model="searchbienes"
            append-icon="mdi-magnify"
            outlined
            dense
            hide-details
            >
            </v-text-field>
            <!-- <v-icon  outlined style=" margin-left:10px; font-size: 1.2rem" @click="drawer = !drawer">mdi-filter-outline</v-icon> -->
        </div>
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
        searchbienes:"",
        headBienes: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', width:"220px", class:'grey lighten-1' },
          { text: 'corr-area', align: 'start', filterable: true, value: 'corr_area',width:"60px", class:'grey lighten-1' },
          { text: 'corr-num', align: 'start', filterable: true, value: 'corr_num', width:"60px", class:'grey lighten-1' },
          { text: 'Responsable', align: 'center', filterable: false, width:"130px", value: 'dni', class:'grey lighten-1',},
          { text: 'Oficina', align: 'start', filterable: true, value: 'onombre', width:"230px", minWidth:'220px', class:'grey lighten-1' },
          { text: 'Dependencia', align: 'start', filterable: true, value: 'dependencia', width:"300px", minWidth:'250px', class:'grey lighten-1' },
          { text: 'Usuario', align: 'start', filterable: true, value: 'unombre', width:"230px", minWidth:'220px', class:'grey lighten-1' },
          { text: '', align: 'right', value:'acciones', maxWidth:'50px', class:'grey lighten-1'  },
        ],

    }),
    methods: {
        async getBienes(){ 
            let res = await axios.get("/admin/inventario/getBiens");
            this.bienes = res.data.datos;
            return res.data.datos.data;
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

    created() {
        this.getBienes()
    },


};
</script>
