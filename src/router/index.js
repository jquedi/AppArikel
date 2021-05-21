import Vue from 'vue'
import VueRouter from 'vue-router'
import seguimientos from '../views/seguimientos'
import documentos from '../views/documentos'
import eventos from '../views/eventos'
import alertas from '../views/alertas'
import animales from '../views/animales'
import instalaciones from '../views/instalaciones'
import graficas from '../views/graficas'
import facturas from '../views/facturas'
import horario from '../views/horario'
import admin from '../views/admin'
// import App from '../../src/App'

Vue.use(VueRouter)

  const routes = [
    // {
    //   path: '/',
    //   name: 'App',
    //   component: App
    // },
    {
      path: '/seguimientos',
      name: 'seguimientos',
      component: seguimientos
      // component: () => import(/* webpackChunkName: "about" */ '../views/seguimientos.vue')
    },
    {
      path: '/documentos',
      name: 'documentos',
      // component: () => import(/* webpackChunkName: "about" */ '../views/documentos.vue')
      component: documentos
    },
    {
      path: '/eventos',
      name: 'eventos',
      component: eventos
      // component: () => import(/* webpackChunkName: "about" */ '../views/eventos.vue')
    },
    {
      path: '/alertas',
      name: 'alertas',
      component: alertas
      // component: () => import(/* webpackChunkName: "about" */ '../views/alertas.vue')
    },
    {
      path: '/animales',
      name: 'animales',
      component: animales
      // component: () => import(/* webpackChunkName: "about" */ '../views/alertas.vue')
    },
    {
      path: '/instalaciones',
      name: 'instalaciones',
      component: instalaciones
      // component: () => import(/* webpackChunkName: "about" */ '../views/alertas.vue')
    },
    {
      path: '/graficas',
      name: 'graficas',
      component: graficas
      // component: () => import(/* webpackChunkName: "about" */ '../views/alertas.vue')
    },
    {
      path: '/facturas',
      name: 'facturas',
      component: facturas
      // component: () => import(/* webpackChunkName: "about" */ '../views/alertas.vue')
    },
    {
      path: '/horario',
      name: 'horario',
      component: horario
      // component: () => import(/* webpackChunkName: "about" */ '../views/alertas.vue')
    },
    {
      path: '/admin',
      name: 'admin',
      component: admin
      // component: () => import(/* webpackChunkName: "about" */ '../views/admin.vue')
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router