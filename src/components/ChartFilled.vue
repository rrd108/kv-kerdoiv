<script>
import { Line } from 'vue-chartjs'

export default {
  name: 'ChartFilled',
  extends: Line,
  props: {
    chartdata: {
      type: Object,
      default: null
    },
    options: {
      type: Object,
      default: null
    }
  },
  mounted () {
    this.chartdata.datasets[0].label = this.chartdata.datasets[0].data.reduce((a, b) => parseInt(a) + parseInt(b), 0) + ' Kitöltött kérdőív'
    this.chartdata.datasets[1].label = this.chartdata.datasets[1].data.reduce((a, b) => parseInt(a) + parseInt(b), 0) + ' Hírlevél feliratkozó'

    this.renderChart(this.chartdata, this.options)
  }
}
</script>
