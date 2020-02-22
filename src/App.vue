<template>
  <div id="app">
    <AppHeader :step="step" />
    <main class="row align-middle">
      <Questionare @stepChange="stepChange($event)" />
    </main>
  </div>
</template>

<script>
import AppHeader from "./components/AppHeader.vue";
import Questionare from "./components/Questionare.vue";

export default {
  name: "app",
  components: {
    AppHeader,
    Questionare
  },
  data() {
    return {
      step: 0,
    }
  },
  methods: {
    stepChange: function(step){
      this.step = step
    }
  }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css?family=Quicksand:500');
@import url('./assets/foundation.min.css');
@import url('./assets/foundation-icons.css');

#app {
  font-family: 'Quicksand', sans-serif;
  background-color: #efdfd2;
  color: #574634;
  background-image: url('./assets/background.png');
  min-height: 100vh;
  font-size: 2rem;
}

#app h3 {
  font-family: 'Quicksand', sans-serif;
  font-weight: bold;
}

#app label, #app input {
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
