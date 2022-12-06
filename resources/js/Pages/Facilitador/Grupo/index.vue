<template>
<v-container>
    <card>
        <v-card-title class="pa-0 py-3 pb-5">
            <v-spacer></v-spacer>   
            <div style=" height: 38px; margin-right: 0px;">
                <v-text-field
                v-model="searchbienes"
                append-icon="mdi-magnify"
                outlined
                label="Buscar"
                dense
                hide-details
                >
                </v-text-field>
            </div>
        </v-card-title>
        <v-data-table
            :headers="headGrupo"
            :items="grupos"
            :search="searchbienes"
            :itemsPerPage="8"
            :mobile-breakpoint="10"
            >
        </v-data-table>
        </card>
</v-container>
</template>
<script>
import Layout from "@/Layouts/FacilitadorLayout";
import axios from 'axios';
import AreasByOficinaGrupo from './Components/AreasByOfcinaGrupo.vue';


export default {
    components:{AreasByOficinaGrupo},

    layout: Layout,
    data: () => ({
        searchbienes:"",
        grupos:[],
        headGrupo: [
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombres', width:"120px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Apellidos', align: 'start', filterable: true, value: 'apellidos',width:"60px", class:'pl-4 pr-0 grey lighten-1' },
          { text: 'Dependencias', align: 'center', filterable: true, value: 'dependencia', width:"70px", class:'pl-0 pr-0 grey lighten-1' },
        ],


    }),
    methods:{
        async getGrupos() {
            let res = await axios.get("/facilitador/inventario/get-grupo");
            this.grupos = res.data.datos;
            return res.data.datos.data;
        },

    },    
    created() {
        this.getGrupos()
    },

};
</script>
