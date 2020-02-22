<template>
<div id="step1">
  <div class="row">
      <label for="email" class="column small-12">Email címed</label>
  </div>
  <div class="row">
      <p class="faded column small-12">Az email címed a kitöltés ellenőrzéséhez kell</p>
  </div>
  <div class="row">
      <input class="column small-12" id="email" type="email" placeholder="Email címed">
  </div>
  <div class="row align-center">
      <button class="button" @click="$store.commit('increaseStep')">Start!</button>
  </div>
</div>
</template>

<script>
export default {
    // TODO validate email
}
</script>

<style scoped>
#step1 label, #step1 input {
    font-size: 2rem;
    color: #574634;
}
#step1 input {
    height: 3.5rem;
}
#step1 .button {
  background: #574634;
}
</style>