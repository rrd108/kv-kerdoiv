<template>
  <div id="app">
    <AppHeader :url="url"/>
    <main class="row align-middle">
      <Stats v-if="url == '/admin'" />
      <Questionare v-if="url != '/admin'" class="align-middle" />
    </main>
  </div>
</template>

<script>
import AppHeader from "./components/AppHeader.vue";
import Questionare from "./components/Questionare.vue";
import Stats from "./components/Stats.vue";

export default {
  name: "app",
  components: {
    AppHeader,
    Questionare,
    Stats
  },

  data() {
    return {
      url : window.location.pathname
    }
  }
};
</script>

<style>
@import url("https://fonts.googleapis.com/css?family=Quicksand:500");
@import url("./assets/foundation.min.css");
@import url("./assets/foundation-icons.css");

body {
  background: url("./assets/background.png") #efdfd2 !important;
}

#app {
  font-family: "Quicksand", sans-serif;
  color: #574634;
  min-height: 100vh;
  font-size: 1.7rem;
}

#app h1, #app h2, #app h3 {
  font-family: "Quicksand", sans-serif;
  font-weight: bold;
}

#app label,
#app input {
  font-size: 1.7rem;
}

.faded {
  font-size: 1rem;
  color: #777;
}
main {
  height: 90vh;
  padding: 1rem;
}

@media (min-width:961px) {
  #app label, #app input, button.button {
    font-size: 2.8rem;
  }
  button.button {
    padding: 1rem 1.25rem;
  }
  .faded {
    font-size: 2rem;
  }
}
</style>
