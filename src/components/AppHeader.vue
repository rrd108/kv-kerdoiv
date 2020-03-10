<template>
  <header class="row">
    <div class="column">
      <a href="https://kerdoiv.krisnavolgy.hu"><img src="../assets/logo.png" /></a>
    </div>
    <nav class="column">
      <h1>Kérdőív<span v-show="url != '/admin'"> {{ this.$store.state.step + 1 }} / 8</span></h1>
    </nav>
  </header>
</template>

<script>
export default {
  name: "AppHeader",
  props: ['url']
};
</script>

<style scoped>
header {
  height: 10vh;
  padding-top: 2vh;
}
header img {
  height: 10vh;
}
h1 {
  font-family: "Quicksand", sans-serif;
}
nav {
  font-size: 1.2rem;
}
</style>
