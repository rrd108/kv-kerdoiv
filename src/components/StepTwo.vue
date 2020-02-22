<template>
  <div id="step2">
      <div class="row">
          <label for="city">Honnan érkeztél hozzánk?</label>
          <input type="text" list="cities" autocomplete="off" id="city" placeholder="megye">
          <datalist id="cities">
            <option v-for="city in cities" :key="city.id">{{city}}</option>
          </datalist>
      </div>
      <div class="row">
          <label for="age">Hány éves vagy?</label>
          <input type="range" class="slider column small-10" id="age" min="0" max="100" step="5" v-model="age">
          <span class="column small-2">{{age}}</span>
      </div>
      <div class="row">
          <label>Honnan hallottál rólunk?</label>
          <div class="column small-12">
            <div class="row">
                <input id="from_facebook" type="checkbox">
                <label for="from_facebook">Facebook</label>
            </div>
            <div class="row">
                <input id="from_krisnavolgyhu" type="checkbox">
                <label for="from_krisnavolgyhu">krisnavolgy.hu</label>
            </div>
            <div class="row">
                <input id="from_instagram" type="checkbox">
                <label for="from_instagram">Instagram</label>
            </div>
            <div class="row">
                <input id="from_plakat" type="checkbox">
                <label for="from_plakat">Plakát</label>
            </div>
            <div class="row">
                <input id="from_ujsag" type="checkbox">
                <label for="from_ujsag">Újság</label>
            </div>
            <div class="row">
                <input id="from_other" type="checkbox">
                <label for="from_other">
                  <input type="text" id="from_other" placeholder="Írd meg honnan">
                </label>
            </div>
          </div>
      </div>
      <div class="row">
          <label for="visits">Hányadik alkalomal jársz nálunk?</label>
          <input type="number" id="visits">
      </div>
        <div class="row align-center">
          <button class="button" @click="$store.commit('increaseStep')">Tovább</button>
        </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            age: 25,
            cities: [
              'Külföld', 'Budapest', 'Bács-Kiskun', 'Baranya', 'Békés', 'Borsod-Abaúj-Zemplén', 'Csongrád', 'Fejér', 'Győr-Moson-Sopron', 'Hajdú-Bihar', 'Heves', 'Jász-Nagykun-Szolnok', 'Komárom-Esztergom', 'Nógrád', 'Pest', 'Somogy', 'Szabolcs-Szatmár-Bereg', 'Tolna', 'Vas', 'Veszprém', 'Zala'
            ]
        }
    }
}
</script>

<style scoped>
#step2 label, #step2 input {
    font-size: 1.5rem;
    color: #574634;
}
#step2 .button {
  background: #574634;
}
.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 5px;
  border-radius: 5px;
  background: #574634;
  outline: none;
  /*opacity: 0.7;*/
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #574634;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #574634;
  cursor: pointer;
}
span {
    font-size: 2rem;
}
input[type=checkbox] {
  transform: scale(1.75);
  margin: 1rem;
}
</style>
