import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    persona: [
      {id: 0},
      {eventos: 0},
      {alertas: 0}
    ]
  },
  getters: {
    sacarid: state => {
      return state.persona[0].id;
    },
    eventosD: state => {
      return state.persona[0].eventos;
    },
    AlertasCont: state => {
      return state.persona[0].alertas;
    },
  },
  mutations: {
    modificar(state, id){
      state.persona[0].id = id
    },
    modificarEvento(state, eventos){
      state.persona[0].eventos = eventos
    },
    modificarAlertas(state, alertas){
      state.persona[0].alertas = alertas
    },
    reducirAlertas(state){
      state.persona[0].alertas = (state.persona[0].alertas - 1)
    }
  },
  actions: {
  },
  modules: {
  }
})
