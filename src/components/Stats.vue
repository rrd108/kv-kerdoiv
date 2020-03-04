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

    <div v-if="chartLoaded">
      <!-- TODO date select -->
      <h1>Kitöltött kérdőívek és hírlevél feliratkozások</h1>
      <chart-filled :chartdata="chartFilledData" :options="chartFilledOptions" />

      <h1>Honnan jöttél?</h1>
      <chart-city :chartdata="chartCityData" :options="chartCityOptions" />

      <h1>Hány éves vagy?</h1>
      <chart-radar :chartdata="chartAgeData" :options="chartAgeOptions" />

      <h1>Honnan halottál rólunk?</h1>
      <chart-heard :chartdata="chartHeardData" :options="chartHeardOptions" />
      <!-- TODO heardOther-->

      <h1>Hányadik alkalomal jársz nálunk?</h1>
      <chart-bar :chartdata="chartVisitData" :options="chartVisitOptions" />

      <h1>Mennyire tetszett?</h1>

      <h1>Mennyire vagy elégedett</h1>
      <h2>Vendégvezetés</h2>
      <h2>Étterem</h2>
      <h2>Ajándékbolt</h2>
    </div>
  </div>
</template>

<script>
import ChartFilled from '@/components/ChartFilled.vue'
import ChartCity from '@/components/ChartCity.vue'
import ChartRadar from '@/components/ChartRadar.vue'
import ChartHeard from '@/components/ChartHeard.vue'
import ChartBar from '@/components/ChartBar.vue'
import axios from 'axios'

export default {
  name: 'Stats',
  components: {
    ChartFilled,
    ChartCity,
    ChartRadar,
    ChartHeard,
    ChartBar,
  },
  data() {
    return {
      email: '',
      isLoggedIn: false,
      password: '',

      chartLoaded: false,

      chartBackgrounds:  [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],

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
      },

      chartCityData: null,
      chartCityOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },

      chartAgeData: null,
      chartAgeOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },

      chartHeardData: null,
      chartHeardOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },

      chartVisitData: null,
      chartVisitOptions: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      },

    }
  },
  methods: {
    login: function() {
      axios.post(process.env.VUE_APP_API_URL,
        {
          email: this.email,
          password: this.password
        })
      .then(resp => {
        if (resp.data == this.email) {
          this.isLoggedIn = true
          axios.get(process.env.VUE_APP_API_URL + '?data=all')
            .then(resp => {
              this.chartFilledData = resp.data.filled
              this.chartFilledData.datasets[0].backgroundColor = this.chartBackgrounds[0]
              this.chartFilledData.datasets[1].backgroundColor = this.chartBackgrounds[1]
              this.chartCityData = resp.data.city
              this.chartCityData.datasets[0].backgroundColor = this.chartBackgrounds
              this.chartAgeData = resp.data.age
              this.chartAgeData.datasets[0].backgroundColor = this.chartBackgrounds
              this.chartHeardData = resp.data.heard
              this.chartHeardData.datasets[0].backgroundColor = this.chartBackgrounds
              this.chartVisitData = resp.data.visits
              this.chartVisitData.datasets[0].backgroundColor = this.chartBackgrounds
              this.chartLoaded = true
            })
            .catch(err => console.error(err))
        }
      })
      .catch(err => console.error(err))

    }
  }
}
</script>