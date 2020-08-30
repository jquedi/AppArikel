<template>
  <div id="app">
    <div id="cabecera">
      <!-- <transition name="slide">
      <button id="desplegarMenu" @click="showMenu = !showMenu, moverB = !moverB"></button>
      </transition>-->

        <button id="desplegarMenu" @click="toggleMenu" :class="setButtonVisibility"></button>

      <h1>Arikel VS</h1>
    </div>
    <transition name="fade">
      <div id="menu1" v-if="showMenu">
        <ul style=" max-width: 200px;">
          <li>
            <button class="buttonMenu" id="seguimientos">{{opcion1}}</button>
          </li>
          <li>
            <button class="buttonMenu" id="documentos">{{opcion2}}</button>
          </li>
          <li>
            <button class="buttonMenu" id="eventos">{{opcion3}}</button>
          </li>
          <li>
            <button class="buttonMenu" id="desconectar">{{opcion4}}</button>
          </li>
        </ul>
      </div>
    </transition>
    <transition name="fade">
      <div id="ennegrecido" v-if="showMenu"></div>
    </transition>
    <micomponente></micomponente>
  </div>
</template>

<script>
import micomponente from "./components/componente.vue";

export default {
  name: "App",
  components: {
    micomponente
  },
  data() {
    return {
      opcion1: "Seguimientos",
      opcion2: "Documentos",
      opcion3: "Eventos",
      opcion4: "Desconectar",
      showMenu: false,
      moverB: false,
    };
  },
  methods: {
    toggleMenu() {
      this.showMenu = !this.showMenu, 
      this.moverB = !this.moverB
    }
  },
  computed:{
    setButtonVisibility() {
      if (this.moverB) return 'slide'
      else return ''
    }
  }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.slide{
  transform: translateX(150px);
}
/* .slide-enter-active,
.slide-leave-active {
  transition: 1s;
}
.slide-enter, .slide-leave-to  {
  transform: translateX(150px);
} */

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
#ennegrecido {
  position: fixed;
  height: 100%;
  width: 100%;
  background: #00000052;
  float: right;
  top: 0;
  right: 0;
  z-index: 2000;
}

ul {
  height: 100%;
  margin: 0;
  width: 40%;
  padding: 0;
  background: aquamarine;
}
li {
  list-style-type: none;
  position: inherit;
  height: 25%;
  margin-left: 0px;
}
#menu1 {
  position: fixed;
  top: 0px;
  left: 0px;
  z-index: 3000;
  width: 100%;
  height: 100%;
}
.buttonMenu {
  background: none;
  border: none;
  font-size: inherit;
  font-weight: 900;
  cursor: pointer;
  width: 100%;
}
#seguimientos {
  top: 80%;
  position: relative;
  left: 0%;
}
#documentos {
  top: 40%;
  position: relative;
  left: 0%;
}
#eventos {
  top: 0%;
  position: relative;
  left: 0%;
}
#desconectar {
  position: relative;
  top: 70%;
  left: 0%;
}
#cabecera {
  z-index: 4000;
  position: fixed;
  top: 0;
  left: 0;
  height: 75px;
  width: 100%;
  background: aquamarine;
}
#desplegarMenu {
  position: fixed;
  left: 10px;
  height: 35px;
  width: 35px;
  transition: 1s;
  top: 20px;
}
</style>
