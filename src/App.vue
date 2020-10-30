<template>
  <div id="app">
    <div id="cabecera">
      <button
        id="desplegarMenu"
        :style="btnStyles"
        @click="toggleMenu"
        :class="setButtonVisibility"
      ></button>

      <h1 style="font-weight: 800">Arikel VS</h1>
    </div>
    <transition name="fade">
      <div id="menu1" v-if="showMenu">
        <ul id="UlMenu" style="max-width: 200px">
          <li style="margin-top: 75px">
            <router-link to="/">
              <button
                class="buttonMenu"
                id="seguimientos"
                @click="alertasS = ''"
              >
                <span>{{ opcion1 }}</span>
                <span class="badge">{{ alertasS }}</span>
              </button>
            </router-link>
          </li>
          <li>
            <router-link to="/documentos">
              <button class="buttonMenu" id="documentos">{{ opcion2 }}</button>
            </router-link>
          </li>
          <li>
            <router-link to="/eventos">
              <button class="buttonMenu" id="eventos" @click="alertasE = ''">
                <span>{{ opcion3 }}</span>
                <span class="badge">{{ alertasE }}</span>
              </button>
            </router-link>
          </li>
          <li>
            <router-link to="/alertas">
              <button class="buttonMenu" id="alertas">
                <span>{{ opcion5 }}</span>
                <span v-if="nodata" class="badge">{{ alertasA }}</span>
              </button>
            </router-link>
          </li>
        </ul>
        <button id="desconectar">{{ opcion4 }}</button>
      </div>
    </transition>
    <transition name="fade">
      <div id="ennegrecido" v-if="showMenu" @click="toggleMenu"></div>
    </transition>
    <transition name="fade">
      <div id="log" v-if="!login">
        <img id="logo" src="imagenes/Logo.PNG" alt />
        <div class="form">
          <h2>Iniciar sesión</h2>
          <div class="input">
            <div class="inputBox">
              <label for>Usuario</label>
              <input type="text" v-model="usuario" name placeholder="ejemplo" />
            </div>
            <div class="inputBox">
              <label for>Contraseña</label>
              <input
                type="password"
                v-model="contraseña"
                name
                placeholder="******"
              />
            </div>
            <div class="inputBox">
              <input
                type="submit"
                @click="iniciarsesion"
                name
                value="Iniciar"
              />
            </div>
          </div>
        </div>
      </div>
    </transition>
    <router-view v-if="id > 0" style="margin-top: 80px" />

    <notifications group="foo" position="bottom right" />
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
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
      opcion5: "Alertas",
      showMenu: false,
      moverB: false,
      login: false,
      datosPhp: [{}, {}],
      desplazar: 150,
      usuario: "",
      contraseña: "",
      id: 0,
      alertasS: "",
      alertasE: "",
      alertasA: this.$store.getters.AlertasCont,
      nodata: false,
    };
  },
  methods: {
    ...mapMutations(["modificar", "modificarAlertas"]),

    toggleMenu() {
      (this.showMenu = !this.showMenu), (this.moverB = !this.moverB);

      this.alertasCont(1);
    },
    iniciarsesion() {
      axios
        .post("php/login.php", {
          query: this.usuario,
          query2: this.contraseña,
        })
        .then((response) => {
          this.id = response.data;
          if (this.id > 0) {
            this.login = !this.login;
            this.$store.commit("modificar", this.id);
            axios
              .post("php/contar.php", {
                query: this.id,
              })
              .then((response) => {
                var aux = response.data;
                this.cargarEventosCont();
                this.alertasCont(0);
                if (aux > 0) {
                  this.alertasS = aux;
                  this.$notify({
                    group: "foo",
                    title: "REQUERIDOS PENDIENTES",
                    text: "Tiene " + aux + " REQUERIDOS sin atender.",
                    type: "warn",
                    duration: 4000,
                  });
                } else {
                  this.alertasS = "";
                }
              });
          } else {
            alert("Usuario y/o contraseña no validos");
          }
        });
    },
    cargarEventosCont() {
      axios
        .post("php/eventosDisponibles.php", {
          usuario: this.id,
        })
        .then((response) => {
          var aux = response.data.length;
          if (aux > 0) {
            this.alertasE = aux;
            this.$notify({
              group: "foo",
              title: "EVENTOS",
              text: "Hay " + aux + " eventos a los que se puede apuntar.",
              duration: 4000,
            });
          } else {
            this.alertasE = "";
          }
        });
    },
    alertasCont(vez) {
      axios
        .post("php/alertasCont.php", {
          usuario: this.id,
        })
        .then((response) => {
          var aux = response.data;
          if (aux > 0) {
            this.nodata = true;
            this.alertasA = aux;
            this.$store.commit("modificarAlertas", this.alertasA);
            if (vez == 0) {
              this.$notify({
                group: "foo",
                title: "ALERTAS",
                text: "Hay " + aux + " alertas pendientes.",
                type: "warn",
                duration: 4000,
              });
            }
          } else {
            this.nodata = false;
            this.alertasA = 0;
            this.$store.commit("modificarAlertas", this.alertasA);
          }
        });
    },
  },
  computed: {
    ...mapState(["persona"]),

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
#logo {
  position: fixed;
  bottom: 0;
  right: 0;
  width: 20%;
}
#log {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #303244;
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 10000;
}
.form {
  position: relative;
  max-width: 500px;
  height: auto;
  width: 80%;
  padding: 4% 4% 6%;
  background: #303244;
  border-radius: 10px;
  text-align: center;
  box-shadow: -5px -5px 10px rgb(255 255 255 / 15%),
    5px 5px 15px rgb(0 0 0 / 38%);
}
.form h2 {
  color: #c7c7c7;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 4px;
  font-size: 6vh;
}
.form .input {
  text-align: left;
}
.form .input .inputBox {
  margin-top: 3%;
}
.form .input .inputBox label {
  display: block;
  color: #868686;
  margin-bottom: 5px;
  font-size: 4vh;
  font-weight: 600;
}
.form .input .inputBox input {
  width: 100%;
  height: 10vh;
  background: #303244;
  border: none;
  outline: none;
  border-radius: 40px;
  padding: 5px 15px;
  color: #fff;
  font-size: 5vmin;
  color: #03a9f4;
  box-shadow: inset -2px -2px 6px rgba(255, 255, 255, 0.1),
    inset 2px 2px 6px rgba(0, 0, 0, 0.8);
}
.form .input .inputBox input[type="submit"] {
  margin-top: 20px;
  box-shadow: -2px -2px 6px rgba(255, 255, 255, 0.1),
    2px 2px 6px rgba(0, 0, 0, 0.8);
}
.form .input .inputBox input[type="submit"]:hover {
  color: #006c9c;
  margin-top: 20px;
  box-shadow: inset -2px -2px 6px rgba(255, 255, 255, 0.1),
    inset 2px 2px 6px rgba(0, 0, 0, 0.8);
}
.form .input .inputBox input::placeholder {
  color: #555;
  font-size: 4vmin;
}

.badge {
  position: absolute;
  top: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background-color: red;
  color: white;
}
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
  width: 100%;
  padding: 0;
  background: #303244;
}
li {
  list-style-type: none;
  position: inherit;
  height: 20%;
  margin-left: 0px;
}
#menu1 {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 3000;
  width: 40%;
  max-width: 200px;
  height: 100%;
}
.buttonMenu {
  position: relative;
  top: 50%;
  left: 0;
  background: none;
  border: none;
  font-size: inherit;
  font-weight: 900;
  cursor: pointer;
  width: 100%;
  text-align: left;
  color: #fff;
}
#desconectar {
  font-size: inherit;
  font-weight: 900;
  cursor: pointer;
  text-align: left;
  color: #fff;
  background: #a50000;
  border-radius: 13px;
  position: fixed;
  right: 0;
  bottom: 10px;
}
#cabecera {
  z-index: 4000;
  position: fixed;
  top: 0;
  left: 0;
  height: 75px;
  width: 100%;
  background: #303244;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #f3f3f3;
}
#desplegarMenu {
  position: fixed;
  left: 10px;
  height: 35px;
  width: 35px;
  transition: 1s;
  top: 20px;
}
#divlog {
  position: fixed;
  width: 100%;
  height: 20%;
  top: 40%;
}
</style>
