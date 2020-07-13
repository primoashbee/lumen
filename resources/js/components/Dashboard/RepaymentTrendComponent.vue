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
          text: 'Repayment Trend',
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
            label: 'Expected Repayment',
            fill:false,
            borderColor: "#0000FF",

            data: [50000, 150000, 350000,320000,129000]
          },
          {
            label: 'Actual Repayment',
            fill:false,
            borderColor: "#faa26d",

            data: [45000, 120000, 325000,120000,229000]
          },
        ]
      }
    });
  }
}
</script>

 