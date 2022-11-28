<template>
<div>
    <div v-for="(usuario,j) in usuarios" :key="j" >
      <div dense>
        <span style="margin-left:42px" > <span class="mdi mdi-account-outline pr-2"></span> {{usuario.nombres}}</span>
      </div>
    
    </div>
</div>
</template>

<script>
import axios from 'axios';
// import UsuariosXareasVue from './UsuariosXareas.vue';

export default {
  props:['oficina'],
  // components:{UsuariosXareasVue},

  data(){
    return{
      areas:[],
      usuarios:[],
    }
  },
  methods:{
    // async getAreasGroup() {
    //   let res = await axios.get("/admin/grupo/areas-grupo/"+this.oficina.id);
    //   this.areas = res.data.datos;
    //   return res.data.datos.data;
    // },

    async getUsuariosAreasGroup() {
      let res = await axios.get("/admin/grupo/usuarios-areas-grupo/"+this.oficina.iduoper);
      this.usuarios = res.data.datos;
      return res.data.datos.data;
    },


    
  },
  created () {
    // this.getAreasGroup();
    this.getUsuariosAreasGroup()
  },
}
</script>