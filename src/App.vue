<template>
  <div id="app">
    <div id="cabecera">
      <button
        class="botonCabecera"
        @click="opcionesG = true"
        v-if="opcion == 'vs'"
      >
        Arikel VS
      </button>
      <button
        class="botonCabecera"
        @click="opcionesG = true"
        v-if="opcion == 'mant'"
        style="font-size: 15px"
      >
        Arikel Mantenimiento
      </button>
      <button
        class="botonCabecera"
        @click="opcionesG = true"
        v-if="opcion == 'fac'"
        style="font-size: 25px"
      >
        Arikel Facturas
      </button>

      <div v-if="opcionesG && (mantenimiento == 'SI' || facturas != 'NINGUNO')">
        <div class="fondoNegro" @click="opcionesG = false"></div>
        <div class="divbotonCabecera2">
          <div class="row">
            <div class="col">
              <button class="botonCabecera2" @click="cambiar('vs')">
                Arikel VS
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <button
                class="botonCabecera2"
                @click="cambiar('mant')"
                v-if="mantenimiento == 'SI'"
              >
                Arikel Mantenimiento
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <button
                class="botonCabecera2"
                @click="cambiar('fac')"
                v-if="facturas == 'EDITAR' || facturas == 'VER'"
              >
                Arikel Facturas
              </button>
            </div>
          </div>
        </div>
      </div>

      <button
        id="desplegarMenu"
        :style="btnStyles"
        @click="toggleMenu"
        :class="setButtonVisibility"
      >
        <div class="hamburguesa" :style="burguer1"></div>
        <div class="hamburguesa" style="top: 50%" :style="burguer2"></div>
        <div class="hamburguesa" style="top: 75%" :style="burguer3"></div>
      </button>
    </div>
    <transition name="fade">
      <div id="menu1" v-if="showMenu && opcion == 'mant'">
        <ul id="UlMenu" style="max-width: 200px">
          <li style="margin-top: 75px">
            <router-link to="/animales">
              <button class="buttonMenu" id="documentos">{{ opcion1m }}</button>
            </router-link>
          </li>
          <li>
            <router-link to="/instalaciones">
              <button class="buttonMenu" id="documentos" @click="alertasI = ''">
                <span>{{ opcion2m }}</span>
                <span v-if="nodata" class="badge">{{ alertasI }}</span>
              </button>
            </router-link>
          </li>
          <li  v-if="opcion == 'horario'">
            <!-- Desabilitado -->
            <router-link to="/horario">
              <button class="buttonMenu" id="documentos">{{ opcion3m }}</button>
            </router-link>
          </li>
        </ul>

        <button
          id="desconectar"
          onclick="location.href='http://app.arikelk9.es/'"
        >
          {{ opcion4 }}
        </button>
      </div>


      
      <div id="menu1" v-if="showMenu && opcion == 'fac'">
        <ul id="UlMenu" style="max-width: 200px">
          <li style="margin-top: 75px">
            <router-link to="/facturas">
              <button class="buttonMenu" id="documentos">{{ opcion1f }}</button>
            </router-link>
          </li>
          <li>
            <router-link to="/graficas">
              <button class="buttonMenu" id="documentos">
                <span>{{ opcion2f }}</span>
              </button>
            </router-link>
          </li>
        </ul>

        <button
          id="desconectar"
          onclick="location.href='http://app.arikelk9.es/'"
        >
          {{ opcion4 }}
        </button>
      </div>

      <div id="menu1" v-if="showMenu && opcion == 'vs'">
        <ul id="UlMenu" style="max-width: 200px">
          <li style="margin-top: 75px">
            <router-link to="/seguimientos">
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
          <li v-if="documentos == 'EDITAR' || documentos == 'VER'">
            <router-link to="/documentos">
              <button class="buttonMenu" id="documentos">{{ opcion2 }}</button>
            </router-link>
          </li>
          <li v-if="eventosP == 'EDITAR' || eventosP == 'VER'">
            <router-link to="/eventos">
              <button class="buttonMenu" id="eventos" @click="alertasE = ''">
                <span>{{ opcion3 }}</span>
                <span class="badge">{{ alertasE }}</span>
              </button>
            </router-link>
          </li>
          <li v-if="alertasP == 'EDITAR' || alertasP == 'VER'">
            <router-link to="/alertas">
              <button class="buttonMenu" id="alertas">
                <span>{{ opcion5 }}</span>
                <span v-if="nodata" class="badge">{{ alertasA }}</span>
              </button>
            </router-link>
          </li>
          <li v-if="admin === 'SI'">
            <router-link to="/admin">
              <button class="buttonMenu" id="admin">{{ opcion6 }}</button>
            </router-link>
          </li>
        </ul>

        <button
          id="desconectar"
          onclick="location.href='http://app.arikelk9.es/'"
        >
          {{ opcion4 }}
        </button>
      </div>
    </transition>

    <transition name="fade">
      <div id="ennegrecido" v-if="showMenu" @click="toggleMenu"></div>
    </transition>
    <transition name="fade">
      <div id="log" v-if="!loggedIn">
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
    <router-view style="margin-top: 80px" />

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
    // console.log("valor de login", this.login);
    // // this.prueba();
    // if (!this.login) {
    //   this.$router.push("/");
    // }
  },
  data() {
    return {
      opcion1: "Seguimientos",
      opcion2: "Documentos",
      opcion3: "Eventos",
      opcion4: "Desconectar",
      opcion5: "Alertas",
      opcion6: "Administrar",
      showMenu: false,
      moverB: false,
      // login: false,
      datosPhp: [{}, {}],
      desplazar: 0,
      usuario: "",
      contraseña: "",
      id: 0,
      alertasS: "",
      alertasE: "",
      alertasI: "",
      alertasA: this.$store.getters.AlertasCont,
      nodata: false,
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

      mantenimiento: "NO",
      opcion: "vs",
      opcionesG: false,

      opcion1m: "Animales",
      opcion2m: "Instalaciones",
      opcion3m: "Horario",

      opcion1f: "Facturas",
      opcion2f: "Graficas",
    };
  },
  methods: {
    ...mapMutations(["modificar", "modificarAlertas", "modificarPermisos"]),

    cambiar(aux) {
      this.opcion = aux;
      this.opcionesG = false;

      if (aux == "vs") {
        this.$router.push("/seguimientos");
      }
      if (aux == "mant") {
        this.$router.push("/animales");
      }
      if (aux == "fac") {
        this.$router.push("/facturas");
      }
    },

    toggleMenu() {
      (this.showMenu = !this.showMenu), (this.moverB = !this.moverB);

      this.alertasCont(1);
    },
    // prueba(){
    //   this.$store.commit(
    //               "modificarPermisos",
    //               {admin: this.admin,
    //               alertasP: this.alertasP,
    //               alertasVer: this.alertasVer,
    //               eventosP: this.eventosP,
    //               documentos: this.documentos,
    //               seguimientos: this.seguimientos,
    //               facturas: this.facturas}
    //             );
    // },
    iniciarsesion() {
      // this.login = !this.login;

      // console.log("valor de login despues de pulsar", this.login);

      // this.$router.push("/seguimientos");

      axios
        .post("php/login.php", {
          query: this.usuario,
          query2: this.contraseña,
        })
        .then((response) => {
          this.id = response.data;
          if (this.id > 0) {
            // this.login = !this.login;

            this.$router.push("/seguimientos");

            this.$store.commit("modificar", this.id);
            axios
              .post("php/permisosPropios.php", {
                query: this.id,
              })
              .then((response) => {
                var aux = response.data;

                this.admin = aux[0][1];
                this.alertasP = aux[0][2];
                this.alertasVer = aux[0][3];
                this.eventosP = aux[0][4];
                this.documentos = aux[0][5];
                this.seguimientos = aux[0][6];
                this.facturas = aux[0][7];
                this.mantenimiento = aux[0][11];

                this.privadosPermiso = aux[0][8];
                this.formacionPermiso = aux[0][9];
                this.operativosPermiso = aux[0][10];
                this.seguimientosT = aux[0][12];

                this.$store.commit("modificarPermisos", {
                  admin: this.admin,
                  alertasP: this.alertasP,
                  alertasVer: this.alertasVer,
                  eventosP: this.eventosP,
                  documentos: this.documentos,
                  seguimientos: this.seguimientos,
                  facturas: this.facturas,
                  privadosPermiso: this.privadosPermiso,
                  formacionPermiso: this.formacionPermiso,
                  operativosPermiso: this.operativosPermiso,
                  seguimientosT: this.seguimientosT,
                });

                axios
                  .post("php/contar.php", {
                    query: this.id,
                  })
                  .then((response) => {
                    var aux = response.data;
                    this.cargarEventosCont();
                    this.alertasCont(0);
                    this.cargarInstalaciones();
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
              });
          } else {
            alert("Usuario y/o contraseña no validos");
          }
        });
    },
    cargarEventosCont() {
      if (this.eventosP == "VER" || this.eventosP == "EDITAR") {
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
      }
    },
    cargarInstalaciones() {
      if (this.mantenimiento == "SI") {
        axios
          .post("php/tareasAnimalesActivas.php", {
            query: -1,
          })
          .then((response) => {
            var aux = response.data.length;
            if (aux > 0) {
              this.alertasI = aux;
              this.$notify({
                group: "foo",
                title: "TAREAS",
                text: "Hay " + aux + " tareas sin hacer en las instalaciones.",
                duration: 4000,
              });
            } else {
              this.alertasI = "";
            }
          });
      }
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
    desconectarF() {
      this.$router.go();
    },

    widthDiv() {
      var elmnt = document.getElementById("cabecera");
      var elmnt2 = document.getElementById("desplegarMenu");
      if (elmnt.offsetWidth * 0.4 > 200) {
        var width = 200;
      } else {
        width = elmnt.offsetWidth * 0.4;
      }
      var aux = width - (20 + elmnt2.offsetWidth);
      return aux;
    },
  },
  computed: {
    ...mapState(["persona"]),

    loggedIn() {
      return this.$store.state.id > 0;
    },

    btnStyles() {
      if (this.moverB)
        return {
          transform: `translateX(${this.widthDiv()}px)`,
        };
      else return "";
    },
    burguer1() {
      if (this.moverB)
        return {
          transform: `rotateZ(-25deg) translateY(0px) translateX(-3px)`,
        };
      else return "";
    },
    burguer2() {
      if (this.moverB)
        return {
          transform: `rotateZ(90deg) translateY(-9px) translateX(-1px)`,
        };
      else return "";
    },
    burguer3() {
      if (this.moverB)
        return {
          transform: `rotateZ(30deg) translateY(-1px) translateX(-4px)`,
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
.botonCabecera2 {
  background: none;
  width: 220px;
  margin-top: 20px;
  border: solid;
  border-color: darkgrey;
  border-radius: 5px;
  font-size: 20px;
  font-weight: 800;
  background-color: gainsboro;
}
.divbotonCabecera2 {
  width: 80%;
  background: white;
  z-index: 11000;
  position: fixed;
  right: 10%;
  top: 10%;
  padding-bottom: 20px;
  border-radius: 10px;
}
.botonCabecera {
  background: none;
  border: none;
  color: white;
  font-weight: 800;
  font-size: 38px;
}
.hamburguesa {
  width: 80%;
  height: 10%;
  background: #8989b1;
  top: 25%;
  border-radius: 20px;
  position: absolute;
  left: 10%;
  transition: 1s;
}
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
.fondoNegro {
  position: fixed;
  height: 100%;
  width: 100%;
  background: #00000052;
  float: right;
  top: 0;
  right: 0;
  z-index: 10000;
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
  height: 16%;
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
  position: absolute;
  right: 0px;
  left: 20px;
  height: 35px;
  width: 35px;
  transition: 1s;
  top: 20px;
  padding: 0;
  border-radius: 7px;
  background: aliceblue;
  border-color: aliceblue;
}
#divlog {
  position: fixed;
  width: 100%;
  height: 20%;
  top: 40%;
}
</style>
