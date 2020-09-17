import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    persona: [
      {id: 0},
    ]
  },
  getters: {
    sacarid: state => {
      return state.persona[0].id;
    }
  },
  mutations: {
    modificar(state, id){
      state.persona[0].id = id
    }
  },
  actions: {
  },
  modules: {
  }
})
