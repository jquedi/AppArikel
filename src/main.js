import Vue from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import store from './store'
import Notifications from 'vue-notification'

Vue.use(Notifications)

window.$ = window.jQuery = require('jquery')

Vue.personaLogin= Vue.prototype.personaLogin = 15;

Vue.config.productionTip = false

Vue.use(VueAxios, axios)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
