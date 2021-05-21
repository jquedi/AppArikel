import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
      id: 0,
      eventos: 0,
      alertas: 0,
      admin: "NO",
      alertasP: "",
      alertasVer: "",
      eventosP: "",
      documentos: "",
      seguimientos: "",
      seguimientosT: "",
      facturas: "",
      privadosPermiso: "",
      formacionPermiso: "",
      operativosPermiso: "",
  },
  getters: {
    docuPermisoPrivado: state => {
      return state.privadosPermiso;
    },
    docuPermisoFormacion: state => {
      return state.formacionPermiso;
    },
    docuPermisoOperativo: state => {
      return state.operativosPermiso;
    },
    sacarid: state => {
      return state.id;
    },
    eventosD: state => {
      return state.eventos;
    },
    AlertasCont: state => {
      return state.alertas;
    },
    permisoAdmin: state => {
      return state.admin;
    },
    permisoAlertasP: state => {
      return state.alertasP;
    },
    permisoAlertasVer: state => {
      return state.alertasVer;
    },
    permisoEventosP: state => {
      return state.eventosP;
    },
    permisoDocumentos: state => {
      return state.documentos;
    },
    permisoSeguimientos: state => {
      return state.seguimientos;
    },
    permisoSeguimientosT: state => {
      return state.seguimientosT;
    },
    permisoFacturas: state => {
      return state.facturas;
    },
  },
  mutations: {
    modificar(state, id){
      state.id = id
    },
    modificarEvento(state, eventos){
      state.eventos = eventos
    },
    modificarAlertas(state, alertas){
      state.alertas = alertas
    },
    reducirAlertas(state){
      state.alertas = (state.alertas - 1)
    },
    modificarPermisos(state, {admin, alertasP, alertasVer, eventosP, documentos, seguimientos, facturas, privadosPermiso, formacionPermiso, operativosPermiso, seguimientosT}){
      state.admin = admin,
      state.alertasP = alertasP,
      state.alertasVer = alertasVer,
      state.eventosP = eventosP,
      state.documentos = documentos,
      state.seguimientos = seguimientos,
      state.facturas = facturas,
      state.privadosPermiso = privadosPermiso,
      state.formacionPermiso = formacionPermiso,
      state.operativosPermiso = operativosPermiso,
      state.seguimientosT = seguimientosT
    },
  },
  actions: {
  },
  modules: {
  }
})
