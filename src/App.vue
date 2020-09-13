<template>
  <div id="app">
    <div id="cabecera">
      <button
        id="desplegarMenu"
        :style="btnStyles"
        @click="toggleMenu"
        :class="setButtonVisibility"
      ></button>

      <h1>Arikel VS</h1>
    </div>
    <transition name="fade">
      <div id="menu1" v-if="showMenu">
        <ul id="UlMenu" style=" max-width: 200px;">
          <li>
            <router-link to="/">
              <button class="buttonMenu" id="seguimientos">{{opcion1}}</button>
            </router-link>
          </li>
          <li>
            <router-link to="/documentos">
              <button class="buttonMenu" id="documentos">{{opcion2}}</button>
            </router-link>
          </li>
          <li>
            <router-link to="/eventos">
              <button class="buttonMenu" id="eventos">{{opcion3}}</button>
            </router-link>
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
    <transition name="fade">
      <div id="log" v-if="!login">
        <div id="divlog">
          <table style="margin: auto;">
            <tr>
              <td>
                <input class="input" type="text" v-model="usuario" placeholder="Usuario" />
              </td>
            </tr>
            <tr>
              <td>
                <input class="input" type="password" v-model="contraseña" placeholder="Contraseña" />
              </td>
            </tr>
            <tr>
              <td>
                <button @click="iniciarsesion">Iniciar Sesión</button>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </transition>
    <router-view style="margin-top: 80px" />
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  components: {},
  created() {
    //axios
  },
  data() {
    return {
      opcion1: "Seguimientos",
      opcion2: "Documentos",
      opcion3: "Eventos",
      opcion4: "Desconectar",
      showMenu: false,
      moverB: false,
      login: false,
      datosPhp: [{}, {}],
      desplazar: 150,
      usuario: "",
      contraseña: "",
    };
  },
  methods: {
    toggleMenu() {
      (this.showMenu = !this.showMenu), (this.moverB = !this.moverB);
    },
    iniciarsesion() {
      axios
        .post("http://app.arikelk9.es/login.php", {
          query: this.usuario,
          query2: this.contraseña,
        })
        .then((response) => {
          this.personaLogin = response.data;
          if(this.personaLogin > 0){
            this.login = !this.login
          }else{
            alert("Usuario y/o contraseña no validos");
          }
        });
    },
  },
  computed: {
    btnStyles() {
      if (this.moverB)
        return {
          transform: `translateX(${this.desplazar}px)`,
        };
      else return "";
    },
    setButtonVisibility() {
      if (this.moverB) return "slide";
      else return "";
    },
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.slide {
  transform: translateX(150px);
}

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
#log {
  position: fixed;
  width: 100%;
  height: 100%;
  background: blue;
  top: 0;
  left: 0;
  z-index: 10000;
}
#divlog {
  position: fixed;
  width: 100%;
  height: 20%;
  top: 40%;
}
</style>
