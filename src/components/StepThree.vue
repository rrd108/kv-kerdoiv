<template>
  <div id="step3">
      <h1>Mennyire tetszett?</h1>
        <div class="row" v-for="place in places" :key="place">
            <legend class="column small-12">{{place}}</legend>
            <div class="column small-12">
                <div class="input-group">
                <input type="radio" :name="place" value="1" :id="place + -1"><label :for="place + -1">Nem tetszett</label>
                </div>
                <div class="input-group">
                <input type="radio" :name="place" value="2" :id="place + -2"><label :for="place + -2">Nem rossz</label>
                </div>
                <div class="input-group">
                <input type="radio" :name="place" value="3" :id="place + -3"><label :for="place + -3">Egész jó</label>
                </div>
                <div class="input-group">
                <input type="radio" :name="place" value="4" :id="place + -4"><label :for="place + -4">Nagyon tetszett</label>
                </div>
                <div class="input-group">
                <input type="radio" :name="place" value="0" :id="place + -0"><label :for="place + -0">Nem láttam</label>
                </div>
            </div>
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
            places: ['Templom', 'Étterem', 'Tehénvédelmi központ', 'Kertészet', 'Botanikus kert', 'Szabadtér']
        }
    }
}
</script>

<style scoped>
legend {
    font-size: 2rem;
    background: #574634;
    color: #fff;
}
.button {
  background: #574634;
}
input[type=radio] {
  transform: scale(1.75);
  margin-top: 1rem;
}
#step3 label {
    font-size: 1.5rem;
}

</style>
