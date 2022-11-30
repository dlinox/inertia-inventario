<template>
    <div class="d-flex mt-3"  style="width:100%; background-color: #fff; align-items: center; justify-content:center;">
        <!-- {{data}} -->
        <div>
            <div class="">Codigo: </div>
            <div><span>{{data.codigo}}</span></div> 
            <div class="">Oficina:</div>
            <div> <span>{{data.onombre}}</span></div>
            <div class="">Dependencia: </div>
            <div style="width: 200px;"><span>{{data.dependencia}}</span></div>

        </div>
        <div>
            <div class="">Nombre: </div>
            <div><span>{{data.descripcion}}</span></div>
            <div class="">Responsable: </div>
            <div><span>{{data.dni}}</span></div>
            <div class="">Inventariador:</div>
            <div> <span>{{data.unombre}}</span></div>
        </div>


    </div>  
  </template>
  
  <script>
  export default {
    props:['item'] ,
    data () {
      return {
          data:null,
      }
    },
    created(){
        this.getBien();
    },

    methods:{
      async getBien() {
        let res = await axios.get('/admin/inventario/getBien/'+this.item.id);
        this.data = res.data.datos;
      },
    },

  }
  </script>
  