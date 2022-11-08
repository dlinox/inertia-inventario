<template>
    <div>
      <canvas id="Chart2" width="250" height="200"/>
    </div>
  </template>

  <script>
  import Chart from 'chart.js/auto';
  let Chart2 = null;

  export default {
    //   props:['grafico'] ,
      data () {
        return {
        }
      },


      mounted(){
        this.grafico()
      },

      methods:{
          grafico(){
          const ctx = document.getElementById('Chart2').getContext('2d');
          if (Chart2 != null){
              Chart2.destroy()
          }

          Chart2 = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: ['No Registrados','Registrados'],
                  datasets: [{
                      label: 'Total Areas',
                      data: [12, 9],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54,162, 235, 0.2)',
                      ],
                      hoverOffset: 4,
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                      ],
                      borderWidth: 1
                  },

                  {
                      label: 'Areas Finalizadas',
                      data: [10, 5],
                      backgroundColor: [
                          'rgba(55, 129, 23, 0.2)',
                          'rgba(154,12, 35, 0.2)',
                      ],
                      hoverOffset: 4,
                      borderColor: [
                          'rgba(55, 129, 32, 1)',
                          'rgba(54, 162, 235, 1)',
                      ],
                      borderWidth: 1
                  }


                ]
              },
                  options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });
     Chart2;

          }

      },


    }



  </script>
  <style scoped>
  .v-progress-circular {
    margin: 1rem;
  }
  </style>
