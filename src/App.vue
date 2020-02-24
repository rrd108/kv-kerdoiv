<template>
  <div id="app">
    <AppHeader />
    <main class="row">
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

#app {
  font-family: "Quicksand", sans-serif;
  background-color: #efdfd2;
  color: #574634;
  background-image: url("./assets/background.png");
  min-height: 100vh;
  font-size: 2rem;
}

#app h3 {
  font-family: "Quicksand", sans-serif;
  font-weight: bold;
}

#app label,
#app input {
  font-size: 2rem;
}

.faded {
  font-size: 1rem;
  color: #777;
}
main {
  height: 90vh;
}
</style>
