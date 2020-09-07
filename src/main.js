import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

window.$ = window.jQuery = require('jquery')

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
