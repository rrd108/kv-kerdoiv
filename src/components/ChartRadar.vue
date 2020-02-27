<script>
import { Radar } from 'vue-chartjs'

export default {
  name: 'ChartRadar',
  extends: Radar,
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
    this.renderChart(this.chartdata, this.options)
  }
}
</script>