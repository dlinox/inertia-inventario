<template>
<v-container>

    <div>
        <v-card color="basil">  

            <v-tabs
            v-model="tab"
            background-color="transparent"
            color="basil"
            grow
            >
            <v-tab
                v-for="(item, ind) in tabs" :key="ind"
            >
                {{ item }}
            </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
                
                <v-tab-item href="Oficinas/Areas">


                    <v-data-table
                        :headers="dessertHeaders"
                        :items="oficinas"
                        :expanded.sync="expanded"
                        :search="search"
                        item-key="id"
                        show-expand
                        :mobile-breakpoint="50"
                    >
                        <template v-slot:top>
                        <v-toolbar flat style="margin-bottom: -30px; padding-top: 10px;">
                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>  
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Buscar"
                                outlined
                                dense
                                hide-details
                                max-width="300px"
                            ></v-text-field>
                        </v-toolbar>
                        </template>
                        <template v-slot:item.nombre="slotData">
                            <div style="cursor:pointer;" @click="clickColumn(slotData)"><span class="mdi mdi-domain mr-2"></span> {{ slotData.item.nombre }}</div>
                        </template>
                        <template  v-slot:expanded-item="{ headers, item }" elevation="0">
                            <td  cellpadding="0" style="background:white; transition: 2s;   "  :colspan="headers.length" class="pa-0">
                                <div>
                                    <AreasByOficinaGrupo :oficina="item"/>
                                </div>
                            </td>
                        </template>
                    </v-data-table>
                </v-tab-item>
                <v-tab-item href="Usuarios">
                    <v-card
                    color="basil"
                    flat
                    >
                    <v-card-text>USuar</v-card-text>
                    </v-card>
                </v-tab-item>
            
            </v-tabs-items>
        </v-card>

    </div>



 

</v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import axios from 'axios';
import AreasByOficinaGrupo from './Components/AreasByOfcinaGrupo.vue';


export default {
    components:{AreasByOficinaGrupo},

    layout: Layout,
    data: () => ({
        types: [],

        open: [1, 2],
        search: null,
        caseSensitive: false,
        usuarios:[],
        oficinas:[],
        usuariosSelecionadas:null,
        usuarios_search:"",
        search:"",
        dialog: false,

        tab: null,
        tabs: [ 'Oficinas/Areas', 'Usuarios'],
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    
        expanded: [],   
        dessertHeaders: [
          {
            text: '',
            align: 'start',
            sortable: false,
            value: 'nombre',
          },
          { text: 'name', value: 'data-table-expand' },
        ],
    }),

    computed: {
      filter () {
        return this.caseSensitive
          ? (item, search, textKey) => item[textKey].indexOf(search) > -1
          : undefined
      },
    },
    methods:{

        async getOficinas() {
            let res = await axios.get("/admin/grupo/oficinas-grupo");
            this.oficinas = res.data.datos;
            return res.data.datos.data;
        },


        customFilterUsuario(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            //const dni = item.dni.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombres.indexOf(searchText) > -1 //||
                //dni.indexOf(searchText) > -1
             );
        },
        clickColumn(slotData) {
            const indexRow = slotData.index;
            const indexExpanded = this.expanded.findIndex(i => i === slotData.item);
            if (indexExpanded > -1) {
            this.expanded.splice(indexExpanded, 1)
            } else {
            this.expanded.push(slotData.item);
            }
        },
    },
    created() {
        this.getOficinas()
    },

};
</script>

<style scoped>
.treee{
    background: none;
}
.treee::-webkit-scrollbar {
    -webkit-appearance: none;
}

.treee::-webkit-scrollbar:vertical {
    width:10px;
}

.treee::-webkit-scrollbar-button:increment,.treee::-webkit-scrollbar-button {
    display: none;
} 

.treee::-webkit-scrollbar:horizontal {
    height: 10px;
}

.treee::-webkit-scrollbar-thumb {
    background-color: #797979;
    border-radius: 20px;
    border: 2px solid #f1f2f3;
}

.treee::-webkit-scrollbar-track {
    border-radius: 10px;  
}
.v-data-table__expanded.v-data-table__expanded__content {
  box-shadow: none !important;
}
</style>
