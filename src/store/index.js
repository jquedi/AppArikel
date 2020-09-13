import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    persona: [
      {id: 0},
    ]
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
