<template>
  <form @submit.prevent="send2API" class="column small-12">
      <div v-show="step === 0">
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

    <div v-show="step === 1">
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

    <div v-show="step === 2">
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

    <div v-show="step === 3">
        <div class="row">
          <label>Honnan hallottál rólunk?</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Több választ is megjelölhetsz</p>
        </div>
        <div class="row">
          <div class="column small-12">
            <div class="row">
                <input v-model="heard" id="from_facebook" type="checkbox" value="facebook">
                <label for="from_facebook">Facebook</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_krisnavolgyhu" type="checkbox" value="krisnavolgy.hu">
                <label for="from_krisnavolgyhu">krisnavolgy.hu</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_instagram" type="checkbox" value="instagram">
                <label for="from_instagram">Instagram</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_plakat" type="checkbox" value="plakat">
                <label for="from_plakat">Plakát</label>
            </div>
            <div class="row">
                <input v-model="heard" id="from_ujsag" type="checkbox" value="ujsag">
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

    <div v-show="step === 4">
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

    <div v-show="step === 5">
      <div class="row">
        <label for="age">Mennyire tetszett?</label>
      </div>
      <div class="row">
          <p class="faded column small-12">Ha nem láttad, akkor hagyd üresen</p>
      </div>
      <div class="row" v-for="(place, index) in places" :key="index">
        <div class="column small-6">
          <label :for="'place-' + index">{{place}}</label>
        </div>
        <div class="column small-6">
          <star-rating
            v-model="placesStars[index]"
            inactive-color="#bbb"
            active-color="#574634"
            :max-rating="4"
            :show-rating="false"></star-rating>
        </div>
      </div>
    </div>

    <div v-show="step === 6">
      <div class="row">
        <h3>{{serviceGroup}}</h3>
      </div>
      <div class="row">
        <label for="age">Mennyire vagy elégedett?</label>
      </div>
      <div class="row">
          <p class="faded column small-12">Ha nem tudod, akkor hagyd üresen</p>
      </div>
      <div class="row" v-for="(service, index) in services[serviceGroup]" :key="index">
        <div class="column small-6">
          <label :for="'service-' + index">{{service}}</label>
        </div>
        <div class="column small-6">
          <star-rating
            v-model="servicesStars[index]"
            inactive-color="#bbb"
            active-color="#574634"
            :max-rating="4"
            :show-rating="false"></star-rating>
        </div>
      </div>
    </div>

    <div class="row align-center" v-show="step < 7">
        <button v-show="!step" class="button" @click.prevent="stepChange(1)">Start!</button>
        <button v-show="step" class="button" @click.prevent="stepChange(-1)"><i class="fi-arrow-left"></i></button>
        <button v-show="step" class="button" @click.prevent="stepChange(1)"><i class="fi-arrow-right"></i></button>
    </div>

    <div v-show="step === 7">
      <div class="row">
            <label for="gdpr_2125" class="column small-12">Hírlevél feliratkozás</label>
        </div>
        <div class="row">
            <p class="faded column small-12">Maradjunk kapcsolatban! Íratkozz fel a hírlevelünkre. 1-2 emailt küldünk havonta sok érdekeséggel!</p>
        </div>
        <div class="row">
            <input v-model="newsletter" id="gdpr_2125" name="gdpr[2125]" value="Y" type="checkbox" style="width:1em" checked>
            <label for="gdpr_2125">Feliratkozom</label>
            <p class="faded column small-12">Elfogadom a krisnavolgy.hu oldalon található adatkezelési tájékoztatót, az adatkezeléshez hozzájárulok.</p>
        </div>
        <div class="row align-center">
          <button type="submit" name="subscribe" class="button">Válaszok elküldése</button>
        </div>
    </div>
  </form>

</template>

<script>
import StarRating from 'vue-star-rating'
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
          heard: [],
          heardOther: '',
          newsletter: true,
          places: ['Templom', 'Étterem', 'Tehénvédelmi központ', 'Kertészet', 'Szabadtér'],
          placesStars: [0,0,0,0,0,0,0],
          services: {
            'Vendégvezetés' : ['Vendégvezető felkészültsége', 'Információ hasznossága', 'Vendégvezető előadásmódja', 'Vendégvezető segítőkészsége'],
            'Étterem' : ['Választék', 'Kiszolgálás gyorsasága', 'Menü mennyisége', 'Menü minősége', 'Menü ára'],
            'Ajándékbolt' : ['Választék', 'Kiszolgálás minősége']
            },
          serviceGroup: '',
          servicesStars: [0,0,0,0,0,0,0],
          step: 0,
          visits: 1,
      }
    },

    created: function(){
      let serviceGroups = Object.keys(this.services)
      this.serviceGroup = serviceGroups[serviceGroups.length * Math.random() << 0]
    },
    methods : {
      stepChange: function(step){
          this.step += step
          this.$emit('stepChange', this.step)
      },

      send2API: function(){
        console.log('email: ' + this.email)
        console.log('city: ' + this.city)
        console.log('age: ' + this.age)
        console.log('heard:' + this.heard)
        console.log('heardOther: ' + this.heardOther)
        console.log('visits: ' + this.visits)
        console.log('newsletter: ' +  this.newsletter)
        this.places.forEach((place, index) => console.log(place + ': ' + this.placesStars[index]))
        console.log('serviceGroup: ' + this.serviceGroup)
        this.services[this.serviceGroup].forEach((service, index) => console.log(service + ': ' + this.servicesStars[index]))

        this.step = 0

        /*
        email: rrd@krisna.hu
        city: Somogy
        age: 45
        heard:facebook,krisnavolgy.hu
        heardOther: barátok
        visits: 20
        newsletter: true
        Templom: 4
        Étterem: 3
        Tehénvédelmi központ: 2
        Kertészet: 1
        Szabadtér: 0
        serviceGroup: Vendégvezetés
        Vendégvezető felkészültsége: 1
        Információ hasznossága: 2
        Vendégvezető előadásmódja: 3
        Vendégvezető segítőkészsége: 4
        */

        /*Mailchimp: form action="https://krisnavolgy.us8.list-manage.com/subscribe/post?u=ad07ffcfc8e16e5c5f1595fa3&amp;id=20fdc26fb9" method="post"*/
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