<template>
  <div class="small">
     <canvas ref="myChart" width="100%" height="50%"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';

export default {
  
  mounted() {
    new Chart(this.$refs.myChart, {
      type: 'line',
      options: {
        title: {
          display: true,
          text: 'PAR Movement',
          fontSize: 20,
          fontColor: 'white',
        },
        legend:{
          labels:{
               fontColor: "white",
               fontSize:15
          }
        }
      },
      data: {
        labels: ['20-June', '21-June', '22-June', '23-June', '24-June'],
        datasets: [
          {
            label: 'Over 180',
            fill:false,
            borderColor: "#0000FF",

            data: [10, 25, 30, 45, 50]
          },
          {
            label: '91-180',
            fill:false,
            borderColor: "#006400",

            data: [8, 22, 28, 40, 45]
          },
          {
            label: '61-90',
            fill:false,
            borderColor: "#FFDF00",

            data: [6, 18, 25, 35, 40]
          },
          {
            label: '30-60',
            fill:false,
            borderColor: "#008080",

            data: [4, 15, 20, 30, 20   ]
          },
          {
            label: '1-30',
            fill:false,
            borderColor: "#90EE90",

            data: [10, 40, 25, 45 ,0 ]
          },
        ]
      }
    });
  }
}
</script>

 