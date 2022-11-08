<template>
    <div style="width: 100%; max-width: 620px; height: 270px !important; padding: 10px;">
      <canvas id="Chart1" height="120" />
    </div>
  </template>

<script>
import Chart from 'chart.js/auto';

export default {
      data () {
        return {
          interval: {},
          value: 65,
          fechas:[],
          registros:[],
        }
      },

methods:{
    async getData(){
        let res = await axios.get("/admin/reportes/regDiario");
        this.registros = res.data.registros;
        this.fechas = res.data.fechas;
        this.grafico()
    },
    grafico(){
    new Chart(document.getElementById('Chart1'), {
    type: 'line',
    data: {
        labels: this.fechas,
        datasets: [
        {
            label: 'Ultimos dias',
            data: this.registros,
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
            ],
        },
        // {
        //     label: 'Hoy',
        //     data: [1090, 950,950, 1090, 1000],
        //     borderColor: [
        //         'rgba(54, 162, 235, 1)',
        //     ],
        // }

        ]
    }
    });
    },

    },
    mounted(){
        this.getData()


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
