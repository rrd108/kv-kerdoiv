<template>
  <header class="row">
    <div class="column">
      <img src="../assets/logo.png" />
    </div>
    <nav class="column">
      <h1>Kérdőív {{ this.$store.state.step + 1 }} / 8</h1>
    </nav>
  </header>
</template>

<script>
export default {
  name: "AppHeader"
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
