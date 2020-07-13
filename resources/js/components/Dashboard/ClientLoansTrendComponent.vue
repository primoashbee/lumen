<template>
  <div class="">
     <canvas ref="myChart" width="100%" height="25%"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';

export default {
  mounted() {
    new Chart(this.$refs.myChart, {
      type: 'horizontalBar',
      options: {
          scales: {
              xAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          },
          title: {
            display: true,
            text: 'Client Trend',
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
        labels: ['February', 'March', 'April', 'May', 'June'],
        datasets: [
          { 
            label:'Resigned',
            borderColor: "#c45750",
            backgroundColor: "#c45750",
            data: [50, 15, 10, 45, 20], 
          },
          {
            label:'New Loans',
            borderColor: '#3e95cd',
            backgroundColor: "#3e95cd",

            data: [90, 50, 25, 90, 50]
          },
        ]
      }
    });
  }
}
</script>

 