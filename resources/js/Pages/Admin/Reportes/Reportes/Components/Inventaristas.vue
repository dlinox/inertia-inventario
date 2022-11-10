<template>
    <div style="width: 100%; height: 100%; padding: 10px;">
        <div style="width:100%; height: 20px; padding-left: 5px; display: flex; justify-content: space-between;">
            <div> <span style="font-weight: bold ; font-size:1rem;"> Ranking</span> </div>
            <div style="padding-right:0px;"> <span style="font-weight: bold ; font-size:1.3rem;"> <span class="mdi mdi-arrow-right"></span> </span> </div>
        </div>
        <!-- <div style="width:100%; height: 20px; padding-left: 5px; display: flex; justify-content: space-between;">
            <div> <span style="font-weight: bold ; font-size:1rem;">{{ grafico.titulo }}</span> </div>
            <div style="padding-right:0px;"> <span style="font-weight: bold ; font-size:1.3rem;"> <span class="mdi mdi-arrow-right"></span> </span> </div>
        </div> -->
        <v-list dense>
            <v-list-item-group

            >
                <v-list-item
                v-for="(item, i) in items"
                :key="i"
                style="background:#bcbcbc13; margin:5px;"
                >
                    <v-list-item-content v-if="i < maximo"  >
                        <!-- {{total}} -->
                        <div style=" display:flex; justify-content: space-between;">
                            <div>
                                <v-list-item-title v-text="item.NOMBRES"></v-list-item-title>
                             </div>
                            <div style="text-align:center;">
                                <span style="font-size:0.8rem;">{{item.NREGISTROS }} </span>
                                <span style="font-size:0.8rem;" >Reg</span>
                            </div>
                        </div>
                        <v-progress-linear height="8" :value="(item.NREGISTROS/total)*100"></v-progress-linear>
                     </v-list-item-content>

                </v-list-item>
            </v-list-item-group>
        </v-list>

    </div>
  </template>

<script>

export default {
    props:['total','maximo'],
    data () {
        return {
            items: [],
            model: 1,
            skill:null,
        }
    },

    created(){
        this.getGlobal()
    },

    methods:{
        async getGlobal() {
        let res = await axios.get("/admin/reportes/ranking");
        console.log(res.data.avance_diario);
        this.items = res.data.avance_diario;

        // this.grafico1.registrados = res.data.g_actual.registros;
        // this.grafico1.anterior = res.data.g_antes.registros;
        // this.grafico1.valor = (res.data.g_actual.registros/res.data.g_antes.registros).toFixed(2);
        // this.grafico3.nroactual = res.data.g_hoy.registros;
        // this.grafico4.nroactual = res.data.g_ayer.registros;
    },
    }

}

</script>
<style scoped>
.v-progress-circular {
margin: 1rem;
}
</style>












<!-- <template>
    <v-sparkline
      :value="value"
      color="primary"
      height="160"
      padding="5"
      :line-width="2"
      stroke-linecap="round"
      smoot
    >
      <template v-slot:label="item">
          <p style="background:Red !important;" > ${{ item.value }} </p>
      </template>
    </v-sparkline>
</template>

<script>
  export default {
    data: () => ({
      value: [
        423,
        486,
        675,
        510,
        590,
        486,
      ],
    }),
  }
</script> -->
