<template>
  <div>
    <div v-for="usuario in usuarios" :key="usuario.id">
      <div style="cursor:pointer; margin-bottom: 15px;" @click="dialog=true">
        <span style="margin-left:42px" > <span class="mdi mdi-account-outline pr-2"></span> {{usuario.nombres}} {{usuario.apellidos}} </span>
      </div>

        <v-dialog
          v-model="dialog"
          width="500"
        >
          <v-card>
            <v-card-title class="text-h5 primary" dark>
              <span style="color:white"> Datos de usuario </span> 
            </v-card-title>
            <!-- mdi-account-multiple-plus -->
            <v-card-text>
              <div class="mt-3">
                <div>
                  <h4 style="font-weight:400; color: black;" >Nombre: {{usuario.nombres }} {{ usuario.apellidos }}</h4>
                </div>
                <div>
                  <h4 style="font-weight:400; color: black;" >Correo: {{ usuario.email }}</h4>
                </div>
                <div>
                  <h4 style="font-weight:400; color: black;" >Celular: {{ usuario.celular }}</h4>
                </div>
              </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="primary"
                dark
                @click="dialog = false"
              >
                  Aceptar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
    </div>


  </div>

</template>
    
<script>
export default {
  props:['area'],

  data(){
    return{
      usuarios:[],
      dialog:false,
    }
  },
  methods:{
    async getUsuariosxArea() {
      let res = await axios.get("/admin/grupo/usuarios-areas-grupo/"+this.area.id);
      this.usuarios = res.data.datos;
      return res.data.datos.data;
    },


  },
  created () {
    this.getUsuariosxArea();
  },

}
</script>