import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

  const routes = [
    {
      path: '/',
      name: 'seguimientos',
      component: () => import(/* webpackChunkName: "about" */ '../views/seguimientos.vue')
    },
    {
      path: '/documentos',
      name: 'documentos',
      component: () => import(/* webpackChunkName: "about" */ '../views/documentos.vue')
    },
    {
      path: '/eventos',
      name: 'eventos',
      component: () => import(/* webpackChunkName: "about" */ '../views/eventos.vue')
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
