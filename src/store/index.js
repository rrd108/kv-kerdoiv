import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    step: 0
  },
  mutations: {
    increaseStep: state => state.step++,
    decreaseStep: state => state.step--,
    setStep: (state, step) => (state.step = step)
  },
  actions: {},
  modules: {}
});
