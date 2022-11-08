<template>
  <div style="width: 100%; height: 100%; padding: 15px;">
    <div style="width:100%; height: 40px; padding-left: 5px; display: flex; justify-content: space-between;">
        <div> <span style="font-weight: bold ; font-size:1rem;">{{ grafico.titulo }}</span> </div>
        <div style="padding-right:0px;"> <span style="font-weight: bold ; font-size:1.3rem;"> <span class="mdi mdi-arrow-right"></span> </span> </div>
    </div>
  <div class="text-center" style=" display: flex; width: 100%;  justify-content: space-between;" >

    <v-progress-circular
      :rotate="270"
      :size="150"
      :width="20"
      :value="g.valor"
      dark
      :color="g.color"
    >
      <div style="font-size:1.6rem;">
         <div style="margin-bottom:-5px;">{{ g.valor }}%</div>
         <div style="width:100px;"><p style="color:#00000099; font-size:0.95rem; line-height: 1; "> {{ g.titulo }}</p></div>
      </div>
    </v-progress-circular>
    <div style="height:100%; padding-top:20px;  ">
        <div>
            <div style="text-align:right;"><span style="font-size: 0.95rem" >{{g.label}}</span></div>
            <div style="text-align:right;"><span style="font-weight:bold; font-size:1.1rem;" >{{ g.registrados }} </span> </div>
        </div>
        <div>
            <div style="text-align:right;"><span style="font-size: 0.95rem">{{g.labelAnterior}}</span></div>
            <div style="text-align:right;"><span style="font-weight:bold; font-size:1.1rem;" >{{ g.anterior }}</span></div>
        </div>

        <div>
            <div style="text-align:right;"><span >Diferencia</span></div>
            <div style="text-align:right;"><span style="font-weight:bold; font-size:1.1rem;" >{{ g.anterior - g.registrados }}</span></div>
        </div>


    </div>
    <!-- <canvas id="Chart1" width="250" height="200"/> -->
  </div>
</div>
</template>

<script>
//import Chart from 'chart.js/auto';
//let Chart1 = null;
  export default {
    props:['grafico'] ,
    data () {
      return {
        g: {
            color: '',
            titulo: '',
            valor: '',
            label: '',
            registrados: 0,
            anterior: 0,
            labelAnterior: ''
        },
      }
    },

    created(){
        this.g = this.grafico;
    },

    mounted(){

    },

    methods:{
        // grafico(){
        //     const ctx = document.getElementById('Chart1').getContext('2d');
        // if (Chart1 != null){
        //     Chart1.destroy()
        // }

        // Chart1 = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: ['No Registrados','Registrados'],
        //         datasets: [{
        //             label: '# of Votes',
        //             data: [12, 3],
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 0.2)',
        //                 'rgba(54,162, 235, 0.2)',
        //             ],
        //             hoverOffset: 4,
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //             ],
        //             borderWidth: 1
        //         }]
        //     },
            //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });
        // //  Chart1;

        // }

    },


  }



</script>
<style scoped>
.v-progress-circular {
  margin: 1rem;
}
</style>
