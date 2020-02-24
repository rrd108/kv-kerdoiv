<template>
  <div class="column small-12">
    <form @submit.prevent="login" v-show="!isLoggedIn">
      <fieldset>
        <div class="input email required">
          <label for="email">Email</label>
          <input type="email" v-model="email" required="required" id="email">
        </div>
        <div class="input password required">
          <label for="password">Jelszó</label>
          <input type="password" v-model="password" required="required" id="password">
        </div>
      </fieldset>
      <div class="row align-center">
        <button class="button" type="submit">Belép</button>
      </div>
    </form>
    <chart-filled v-if="isLoggedIn && chartFilledLoaded" :chartdata="chartFilledData" :options="chartFilledOptions" />
  </div>
</template>

<script>
import ChartFilled from '@/components/ChartFilled.vue'
import axios from 'axios'

export default {
  name: 'Stats',
  components: {
    ChartFilled
  },
  data() {
    return {
      email: '',
      isLoggedIn: false,
      password: '',

      chartFilledLoaded: false,
      chartFilledData: null,
      chartFilledOptions: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    }
  },
  async mounted () {
    this.chartFilledLoaded = false
    axios.get(process.env.VUE_APP_API_URL + '?data=filled')
      .then(resp => {
        this.chartFilledData = resp.data
        this.chartFilledLoaded = true
      })
      .catch(err => console.error(err))
  },
  methods: {
    login: function() {
      axios.post(process.env.VUE_APP_API_URL,
        {
          email: this.email,
          password: this.password
        })
      .then(resp => this.isLoggedIn = (resp.data == this.email))
      .catch(err => console.error(err))
    }
  }
}
</script>

<style>

</style>