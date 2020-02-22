<template>
  <header class="row">
    <div class="column small-4">
      <img src="../assets/logo.png">
    </div>
    <nav class="column small-8">
      <h1>Kérdőív {{step+1}} / 8</h1>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'AppHeader',
  props: ['step'],
}
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
  font-family: 'Quicksand', sans-serif;
}
nav {
  font-size: 1.2rem;
}
</style>