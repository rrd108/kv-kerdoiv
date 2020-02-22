<template>
  <form @submit.prevent="send2API" class="column small-12">

      <div v-show="$store.state.step === 0">
        <div class="row">
            <label for="email" class="column small-12">Email címed</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Az email címed a kitöltés ellenőrzéséhez kell</p>
        </div>
        <div class="row">
            <input v-model="email" class="column small-12" id="email" type="email" placeholder="Email címed" autocomplete="off">
        </div>
    </div>

    <div v-show="$store.state.step === 1">
        <div class="row">
          <label for="city">Honnan érkeztél hozzánk?</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Külföld / Budapest / Megye neve</p>
        </div>
        <div class="row">
          <input v-model="city" type="text" list="cities" autocomplete="off" id="city" placeholder="Megye">
          <datalist id="cities">
            <option v-for="city in cities" :key="city.id">{{city}}</option>
          </datalist>
      </div>
    </div>

    <div v-show="$store.state.step === 2">
        <div class="row">
          <label for="age">Hány éves vagy?</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Életkorod</p>
        </div>
        <div class="row">
          <input type="range" class="slider column small-10" id="age" min="0" max="100" step="5" v-model="age">
          <span class="column small-2">{{age}}</span>
      </div>
    </div>

    <div v-show="$store.state.step === 3">
        <div class="row">
          <label>Honnan hallottál rólunk?</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Több választ is megjelölhetsz</p>
        </div>
        <div class="row">
          <div class="column small-12">
            <div class="row">
                <input v-model="heard" id="from_facebook" type="checkbox" value="fb">
                <label for="from_facebook">Facebook</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_krisnavolgyhu" type="checkbox" value="kv">
                <label for="from_krisnavolgyhu">krisnavolgy.hu</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_instagram" type="checkbox" value="inst">
                <label for="from_instagram">Instagram</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_plakat" type="checkbox" value="plak">
                <label for="from_plakat">Plakát</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_ujsag" type="checkbox" value="ujs">
                <label for="from_ujsag">Újság</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_other" type="checkbox" value="other">
                <label for="from_other">
                  <input v-model="heardOther" type="text" id="from_other" placeholder="Írd meg honnan">
                </label>
            </div>
          </div>
        </div>
    </div>

    <div v-show="$store.state.step === 4">
        <div class="row">
          <label for="age">Hányadik alkalomal jársz nálunk?</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Használd a csúszkát</p>
        </div>
        <div class="row">
          <input type="range" class="slider column small-10" id="visits" min="0" max="20" step="1" v-model="visits">
          <span class="column small-2">{{visits}}</span>
      </div>
    </div>

    <div v-show="$store.state.step === 5">
      <div class="row">
        <label for="age">Mennyire tetszett?</label>
      </div>
      <div class="row">
          <p class="faded column small-12">Ha nem láttad, akkor hagyd üresen</p>
      </div>
      <div class="row" v-for="(place, index) in places" :key="place[0]">
        <div class="column small-6">
          <label>{{place[1]}}</label>
        </div>
        <div class="column small-6">
          <star-rating
            v-model="places[index][2]"
            inactive-color="#bbb"
            active-color="#574634"
            :max-rating="4"
            :show-rating="false"></star-rating>
        </div>
      </div>
    </div>

    <div v-show="$store.state.step === 6">
      <div class="row">
        <h3>{{serviceGroup}}</h3>
      </div>
      <div class="row">
        <label for="age">Mennyire vagy elégedett?</label>
      </div>
      <div class="row">
          <p class="faded column small-12">Ha nem tudod, akkor hagyd üresen</p>
      </div>
      <div class="row" v-for="(service, index) in services[serviceGroup]" :key="service[0]">
        <div class="column small-6">
          <label>{{service[1]}}</label>
        </div>
        <div class="column small-6">
          <star-rating
            v-model="services[serviceGroup][index][2]"
            inactive-color="#bbb"
            active-color="#574634"
            :max-rating="4"
            :show-rating="false"></star-rating>
        </div>
      </div>
      <div class="row">
        <input v-model="egyeb" type="text" placeholder="egyéb észrevétel">
      </div>
    </div>

    <div class="row align-center" v-show="$store.state.step < 7">
        <button v-show="!$store.state.step" class="button" @click.prevent="$store.commit('increaseStep')">Start!</button>
        <button v-show="$store.state.step" class="button" @click.prevent="$store.commit('decreaseStep')"><i class="fi-arrow-left"></i></button>
        <button v-show="$store.state.step" class="button" @click.prevent="$store.commit('increaseStep')"><i class="fi-arrow-right"></i></button>
    </div>

    <div v-show="$store.state.step === 7">
      <div class="row">
            <label for="newsletter" class="column small-12">Hírlevél feliratkozás</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Maradjunk kapcsolatban! Íratkozz fel a hírlevelünkre. 1-2 emailt küldünk havonta sok érdekeséggel!</p>
        </div>
        <div class="row">
            <input v-model="newsletter" id="newsletter" type="checkbox" style="width:1em" checked>
            <label for="newsletter">Feliratkozom</label>
            <p class="faded column small-12">Elfogadom a krisnavolgy.hu oldalon található adatkezelési tájékoztatót, az adatkezeléshez hozzájárulok.</p>
        </div>
        <div class="row align-center">
          <button type="submit" name="subscribe" class="button">Beküldés</button>
        </div>
    </div>
  </form>

</template>

<script>
import StarRating from 'vue-star-rating'
import axios from 'axios'

export default {
  components: {
    StarRating
  },
  data() {
    return {
      age: 25,
      city: '',
      cities: [
          'Külföld', 'Budapest', 'Bács-Kiskun', 'Baranya', 'Békés', 'Borsod-Abaúj-Zemplén', 'Csongrád', 'Fejér', 'Győr-Moson-Sopron', 'Hajdú-Bihar', 'Heves', 'Jász-Nagykun-Szolnok', 'Komárom-Esztergom', 'Nógrád', 'Pest', 'Somogy', 'Szabolcs-Szatmár-Bereg', 'Tolna', 'Vas', 'Veszprém', 'Zala'
      ],
      email: '',
      egyeb: '',
      heard: [],
      heardOther: '',
      newsletter: true,
      places: [
        ['tpl', 'Templom', 0],
        ['ett', 'Étterem', 0],
        ['gos', 'Tehénvédelmi központ', 0],
        ['kert', 'Kertészet', 0],
        ['szab', 'Szabadtér', 0]
        ],
      services: {
        'Vendégvezetés' :
          [
            ['vv_felk', 'Vendégvezető felkészültsége', 0],
            ['vv_inf', 'Információ hasznossága', 0],
            ['vv_eloa', 'Vendégvezető előadásmódja', 0],
            ['vv_seg', 'Vendégvezető segítőkészsége', 0]
          ],
        'Étterem' :
          [
            ['ett_val', 'Választék', 0],
            ['ett_gyo', 'Kiszolgálás gyorsasága', 0],
            ['ett_men', 'Menü mennyisége', 0],
            ['ett_min', 'Menü minősége', 0],
            ['ett_ar', 'Menü ára', 0]
          ],
        'Ajándékbolt' :
          [
            ['sh_val', 'Választék', 0],
            ['sh_kisz', 'Kiszolgálás minősége', 0]
          ]
        },
      serviceGroup: '',
      sg: '',
      visits: 1,
    }
  },

  created: function() {
    this.setServiceGroup()
  },
  methods : {
    setServiceGroup: function() {
      let serviceGroups = Object.keys(this.services)
      this.serviceGroup = serviceGroups[serviceGroups.length * Math.random() << 0]
      if (this.serviceGroup == 'Vendégvezetés') this.sg = 'vv'
      if (this.serviceGroup == 'Étterem') this.sg = 'ett'
      if (this.serviceGroup == 'Ajándékbolt') this.sg = 'sh'
    },
    send2API: function(){
      axios.post(
        process.env.VUE_APP_API_URL,
        {
          email: this.email,
          city: this.city,
          age: this.age,
          heard: this.heard,
          heardOther: this.heardOther,
          visits: this.visits,
          places: this.places,
          services: this.services,
          newsletter: this.newsletter,
          vv_egyeb: this.sg == 'vv' ? this.egyeb : '',
          ett_egyeb: this.sg == 'ett' ? this.egyeb : '',
          sh_egyeb:  this.sg == 'sh' ? this.egyeb : '',
        }
      )
      .then(resp => {
        console.log(resp)

        this.$store.commit('setStep', 0)
        this.email = this.city = this.heardOther = this.egyeb = this.sg = ''
        this.age = 25
        this.heard = []
        this.visits = 1
        this.places.forEach(place => place[2] = 0)
        this.services[this.serviceGroup].forEach(service => service[2] = 0)
        this.newsletter = true
        this.setServiceGroup()
      })
      .catch(error => console.error(error))

      if (this.newsletter) {
        axios.post(
          process.env.VUE_APP_API_URL,
          {
            status: 'subscribed',
            email_address: this.email,
            marketing_permissions: [{marketing_permission_id: process.env.VUE_APP_MAILCHIMP_MARKETING_PERMISSION_ID, text: "Elfogadom", enabled: true}]
          })
          .then(resp => console.log(resp))
          .catch(error => console.error(error))
      }
    }
  }
}
</script>

<style>
#app label, #app input {
    color: #574634;
}
#app input {
    height: 3.5rem;
}
#app .button {
  background: #574634;
  margin: 0 1rem;
}
#app .slider {
  -webkit-appearance: none;
  width: 100%;
  height: 3px;
  border-radius: 3px;
  background: #574634;
  outline: none;
  /*opacity: 0.7;*/
  -webkit-transition: .2s;
  transition: opacity .2s;
}
#app .slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #574634;
  cursor: pointer;
}
#app .slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #574634;
  cursor: pointer;
}
</style>