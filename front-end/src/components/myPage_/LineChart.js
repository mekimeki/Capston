import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  data: () => ({
   
      chartdata:{
        datacollection: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label: 'Data One',
            backgroundColor: '#FC2525',
            data: [3, 10, 10, 40, 39, 80, 40],
            tension : 0
          }
        ]
        }
    },

  options:{
    responsive: true, 
    maintainAspectRatio: false
  }
  }),
    
  mounted () {
    this.renderChart(this.datacollection, this.options)

  },

}