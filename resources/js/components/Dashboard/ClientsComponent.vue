<template>
  <div class="small">
     <canvas ref="myChart" width="100%" height="70%"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';

export default {

  mounted() {
    new Chart(this.$refs.myChart, {
        type: 'pie',
        options: {
          title: {
            display: true,
            text: 'Client Outreach',
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
        labels: ["With Loans- W/ PAR", "With Loans- W/O PAR", "Without Loans"],
        datasets: [
            {
                label: "Clients",
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f"],
                data: [2478,5267,734],
            }
        ]
      }
    });
  }
}
</script>

 