<template>
  <div class="small">
     <canvas ref="myChart" width="100%" height="50%"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';

export default {
  props : ['office_id','user_id'],
  data(){
    return {
      data : [],
      labels : [],
      expected_repayments : [],
      actual_repayments : [],
      chart_data : {
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
                labels: [],
                datasets: [
                  {
                    label: 'Expected Repayment',
                    fill:false,
                    borderColor: "#0000FF",

                    data: []
                  },
                  {
                    label: 'Actual Repayment',
                    fill:false,
                    borderColor: "#faa26d",

                    data: []
                  },
                ]
              }
      }

 
    }
  },
  mounted() {
      this.getData();    
      window.Echo.private('dashboard.charts.repayment.'+this.office_id)
        .listen('.loan-payment',data =>{
          this.paymentMade(data.data);
      })
        
  },
  methods : {
    chartInit(){
    
      new Chart(this.$refs.myChart, this.chart_data);
    },
    getData(){
       axios.get(this.url)
        .then(res=>{
            
            this.chart_data.data.labels = res.data.labels
            this.chart_data.data.datasets[0].data = res.data.expected_repayments
            this.chart_data.data.datasets[1].data = res.data.actual_repayments
            this.chartInit()
        })

    },
    paymentMade(data){ 
      
      var index = this.chart_data.data.labels.findIndex(x=>x == data.date);
      var curr_value = this.chart_data.data.datasets[1].data[index];
      this.chart_data.data.datasets[1].data[index] = curr_value + data.amount
      this.chartInit();
    },
    disbursmentMade(){
      
    },
    updateChart(){
          this.chart_data = {
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
                labels: ["2021-03-01", "2021-03-02", "2021-03-03", "2021-03-04", "2021-03-05", "2021-03-08"],
                datasets: [
                  {
                    label: 'Expected Repayment',
                    fill:false,
                    borderColor: "#0000FF",

                    data:[6000,5000,4000,3000,2000,1000]
                  },
                  {
                    label: 'Actual Repayment',
                    fill:false,
                    borderColor: "#faa26d",

                    // data: res.data.actual_repayments
                    data: [1000,2000,3000,4000,5000,6000]
                  },
                ]
              }
          }

          this.chartInit()
    }
    
  },
  computed : {
    url(){
      return '/dashboard/v1/repayment_trend/'+this.office_id
    },
 
  }
}
</script>

 