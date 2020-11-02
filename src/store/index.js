import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    persona: [
      {id: 0},
      {eventos: 0},
      {alertas: 0},
      {admin: ""},
      {alertasP: ""},
      {alertasVer: ""},
      {eventosP: ""},
      {documentos: ""},
      {seguimientos: ""},
      {facturas: ""},
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
    permisoAdmin: state => {
      return state.persona[0].admin;
    },
    permisoAlertasP: state => {
      return state.persona[0].alertasP;
    },
    permisoAlertasVer: state => {
      return state.persona[0].alertasVer;
    },
    permisoEventosP: state => {
      return state.persona[0].eventosP;
    },
    permisoDocumentos: state => {
      return state.persona[0].documentos;
    },
    permisoSeguimientos: state => {
      return state.persona[0].seguimientos;
    },
    permisoFacturas: state => {
      return state.persona[0].facturas;
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
    },
    modificarPermisos(state, admin, alertasP, alertasVer, eventosP, documentos, seguimientos, facturas){
      state.persona[0].admin = admin
      state.persona[0].alertasP = alertasP
      state.persona[0].alertasVer = alertasVer
      state.persona[0].eventosP = eventosP
      state.persona[0].documentos = documentos
      state.persona[0].seguimientos = seguimientos
      state.persona[0].facturas = facturas
    },
  },
  actions: {
  },
  modules: {
  }
})
