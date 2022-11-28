<template>
<v-expansion-panels >
    <v-expansion-panel
    v-for="(item,i) in areas"
    :key="i"
    >
    <v-expansion-panel-header dense>
        <span> <span class="mdi mdi-label-outline pr-2 pl-4"></span> {{item.nombre}}</span>
    </v-expansion-panel-header>

    <v-expansion-panel-content>
        <UsuariosXareasVue :area="item"/> 
    </v-expansion-panel-content>

    <!-- <v-expansion-panel-content v-for="(usuario,j) in usuarios" :key="j"
    >
        <span v-if="item.id = usuario.id_area" style="margin-left:42px" > <span class="mdi mdi-account-outline pr-2"></span> {{usuario.nombres}}</span>
    </v-expansion-panel-content> -->
    </v-expansion-panel>
</v-expansion-panels>
</template>

<script>
import axios from 'axios';
import UsuariosXareasVue from './UsuariosXareas.vue';

export default {
  props:['oficina'],
  components:{UsuariosXareasVue},

  data(){
    return{
      areas:[],
      usuarios:[],
    }
  },
  methods:{
    async getAreasGroup() {
      let res = await axios.get("/admin/grupo/areas-grupo/"+this.oficina.id);
      this.areas = res.data.datos;
      return res.data.datos.data;
    },

    async getUsuariosAreasGroup() {
      let res = await axios.get("/admin/grupo/usuarios-areas-grupo/"+this.oficina.id);
      this.usuarios = res.data.datos;
      return res.data.datos.data;
    },


    
  },
  created () {
    this.getAreasGroup();
    this.getUsuariosAreasGroup()
  },
}
</script>