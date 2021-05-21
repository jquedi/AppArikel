<template>
  <div class="container" id="alertasC">
    <h1>ALERTAS</h1>
    <button
      v-if="permisoAlertasP === 'EDITAR'"
      id="botonNuevo"
      class="btn btn-success"
      @click="cerrarFormularion(true)"
    >
      Nueva
    </button>

    <div class="row" v-if="permisoAlertasVer == 'TODOS'">
      <div class="col-md-9">
        <div class="row">
          <div class="col-sm-6 text marginBottom">
            <label for="persona">Personas</label>
            <input
              class="form-control input text"
              id="persona"
              type="text"
              v-model="queryP"
              @keyup="cargarPersonas2()"
            />
          </div>
          <div class="col-sm-6 text marginBottom">
            <button v-if="verTodas == false"
              class="btn btn-primary"
              @click="verTodasF(), (verTodas = true)"
            >
              Ver Todas
            </button>
            <button v-if="verTodas == true" class="btn btn-primary" @click="verTodas = false">
              No Ver Todas
            </button>
          </div>
        </div>
        <div class="col marginBottom">
          <select
            class="form-control input text"
            v-model="idNuevo"
            @change="alertasPendientes(), date_function(), alertasPasadas()"
          >
            <option
              v-for="(persona, index) in personas2"
              v-bind:key="index"
              v-bind:value="persona.ID"
            >
              {{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
              {{ persona.APELLIDO2 }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="formularioNueva panel panel-default" v-if="nuevoF">
      <button
        id="cerrarF"
        class="btn btn-warning"
        @click="cerrarFormularion(false)"
      >
        X
      </button>

      <div class="row">
        <div class="col-sm-6">
          <label for="fecha2">Fecha Limite</label>
          <datepicker
            id="fecha2"
            class="input"
            wrapper-class="calendario"
            color="green lighten-1"
            header-color="primary"
            placeholder="Fecha"
            full-width="true"
            monday-first="true"
            bootstrap-styling="true"
            @input="formatPicker()"
            v-model="trackedDate"
          ></datepicker>
        </div>
        <div class="col-sm-6">
          <label for="argumento">Argumento</label>
          <input
            class="form-control input"
            id="argumento"
            type="text"
            v-model="argumento"
            maxlength="80"
          />
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="persona">Personas</label>
          <input
            class="form-control input"
            id="persona"
            type="text"
            v-model="query"
            @keyup="cargarPersonas()"
          />
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label for="expediente2">Expediente</label>
          <select
            class="form-control input"
            id="expediente2"
            v-model="expediente"
            @change="cargarPersonas()"
          >
            <option value=""></option>
            <option
              v-for="expediente in expedientes"
              v-bind:key="expediente.ID"
              v-bind:value="expediente.ID"
            >
              {{ expediente.DESCRIPCION }}
            </option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label for="todos">TODOS</label>
          <input
            type="checkbox"
            id="todos"
            v-model="todos"
            @click="personasID(todos)"
          />
        </div>
      </div>
      <div class="row" v-for="(persona, index) in personas" v-bind:key="index">
        <div class="col" style="text-align: initial">
          <input
            type="checkbox"
            id="box"
            v-bind:value="persona.ID"
            v-model="checkedNames"
          />
          <label class="labelNombre text"
            >{{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
            {{ persona.APELLIDO2 }}</label
          >
        </div>
      </div>
      <span>Total seleccionado: {{ checkedNames.length }}</span>

      <button
        id="crearF"
        class="btn btn-success"
        @click="
          guardarAlerta(), alertasPendientes(), alertasPasadas(), verTodasF()
        "
      >
        CREAR
      </button>
    </div>

    <div v-if="verTodas == false">
      <div class="alerta text" v-if="vacio">NO TIENE ALERTAS PENDIENTES</div>
      <div v-for="(alerta, index) in alertas" v-bind:key="index">
        <div class="alerta" :style="btnStyles(alerta.HASTA)">
          <table>
            <tr>
              <td class="fecha">{{ alerta.HASTA }}</td>
              <td>{{ alerta.ALERTA }}</td>
              <td class="cerrar">
                <button
                  @click="cerrarAlerta(alerta, index)"
                  style="background: none; border: none; color: white"
                >
                  X
                </button>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <h3 class="text">Alertas Pasadas</h3>

      <div v-for="(alerta, index) in alertas2" v-bind:key="index">
        <div class="alertaPasada">
          <table>
            <tr>
              <td class="fecha">{{ alerta.HASTA }}</td>
              <td class="descripcionPasadas">{{ alerta.ALERTA }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div v-if="verTodas == true">
      <div v-for="(persona, index) in personas2" v-bind:key="index">
        <div
          class="row"
          style="border-bottom: solid; border-width: 2px; padding: 10px"
        >
          <div
            class="col-sm-3"
            style="border-right: solid; text-align: end; font-weight: 600"
          >
            {{ persona.NOMBRE }} <br />
            {{ persona.APELLIDO1 }} {{ persona.APELLIDO2 }}
          </div>
          <div class="col-sm-9">
            <div v-for="(alerta, index) in alertas3" v-bind:key="index">
              <div
                v-if="alerta.IDPERSONA == persona.ID"
                class="alerta"
                :style="btnStyles(alerta.HASTA)"
              >
                <table>
                  <tr>
                    <td class="fecha">{{ alerta.HASTA }}</td>
                    <td>{{ alerta.IDPERSONA }}</td>
                    <td>{{ alerta.ALERTA }}</td>
                    <td class="cerrar">
                      <button
                        @click="cerrarAlerta2(alerta, index)"
                        style="background: none; border: none; color: white"
                      >
                        X
                      </button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <notifications group="foo" position="bottom right" />
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters, mapMutations } from "vuex";
import Datepicker from "vuejs-datepicker";

export default {
  name: "alertasC",
  components: {
    Datepicker,
  },
  computed: {
    ...mapState(["persona"]),
    // ...mapGetters(["sacarid"], ["permisoAlertasP"], ["permisoAlertasVer"]),
    ...mapGetters({
      idUsuario: "sacarid",
      permisoAlertasP: "permisoAlertasP",
      permisoAlertasVer: "permisoAlertasVer",
    }),
  },
  methods: {
    ...mapMutations(["reducirAlertas"]),

    alertasPendientes: function () {
      if (this.idNuevo == 0) {
        this.idNuevo = this.idUsuario;
      }
      axios
        .post("php/alertas.php", {
          usuario: this.idNuevo,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.alertas = response.data;
            this.vacio = false;
          } else {
            this.alertas = "";
            this.vacio = true;
          }
        });
    },
    alertasPasadas: function () {
      if (this.idNuevo == 0) {
        this.idNuevo = this.idUsuario;
      }
      axios
        .post("php/alertasPasadas.php", {
          usuario: this.idNuevo,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.alertas2 = response.data;
          } else {
            this.alertas2 = "";
          }
        });
    },
    verTodasF: function () {
      axios.post("php/alertasTodas.php", {}).then((response) => {
        if (response.data.length > 0) {
          this.alertas3 = response.data;
        } else {
          this.alertas3 = "";
        }
      });
    },
    cerrarAlerta(alerta, index) {
      axios
        .post("php/borrarAlerta.php", {
          idAlerta: alerta.ID,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.alertas.splice(index, 1);
          this.$store.commit("reducirAlertas");
          this.alertasPasadas();
        });
    },
    cerrarAlerta2(alerta, index) {
      axios
        .post("php/borrarAlerta.php", {
          idAlerta: alerta.ID,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.alertas3.splice(index, 1);
          this.alertasPendientes();
          this.alertasPasadas();
        });
    },
    personasID(todos) {
      if (!todos) {
        for (this.i = 0; this.i < this.personas.length; this.i++) {
          this.personasIDLista[this.i] = this.personas[this.i][0];
        }
        this.checkedNames = this.personasIDLista;
      } else {
        this.personasIDLista = [];
        this.checkedNames = this.personasIDLista;
      }
    },
    cargarPersonas: function () {
      axios
        .post("php/listaPersonas.php", {
          query: this.query,
          expediente: this.expediente,
        })
        .then((response) => {
          this.personas = response.data;
        });
    },
    cargarPersonas2: function () {
      axios
        .post("php/listaPersonas.php", {
          query: this.queryP,
        })
        .then((response) => {
          this.personas2 = response.data;
        });
    },
    cerrarFormularion(opcion) {
      this.nuevoF = opcion;
      if (opcion == true) {
        this.cargarPersonas();
      } else {
        this.checkedNames = [];
        this.argumento = "";
        this.fecha2 = "";
        this.personas = "";
        this.query = "";
      }
    },
    formatPicker: function () {
      var self = this;
      var d = new Date(self.trackedDate);
      self.fecha2 =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },
    guardarAlerta() {
      this.formatPicker();
      axios
        .post("php/crearAlerta.php", {
          actual: this.fecha,
          fecha: this.fecha2,
          argumento: this.argumento,
          checkedNames: this.checkedNames,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });

          this.nuevoF = false;
        });
    },

    cargarExpedientes: function () {
      axios.post("php/expedientesFULL.php", {}).then((response) => {
        this.expedientes = response.data;
      });
    },

    date_function: function () {
      this.fecha = new Date().toJSON().slice(0, 10).replace(/-/g, "-");

      this.tomorrow = new Date();
      this.tomorrow.setDate(this.tomorrow.getDate() + 3);
      this.tomorrow = this.tomorrow.toJSON().slice(0, 10).replace(/-/g, "-");

      this.tomorrow2 = new Date();
      this.tomorrow2.setDate(this.tomorrow2.getDate() + 7);
      this.tomorrow2 = this.tomorrow2.toJSON().slice(0, 10).replace(/-/g, "-");

      console.log(this.tomorrow2);
    },
    btnStyles: function (hasta) {
      if (this.tomorrow > hasta) {
        return {
          background: "#fad7d7",
        };
      } else {
        if (this.tomorrow2 > hasta) {
          return {
            background: "#ffc10770",
          };
        } else {
          return {
            background: "",
          };
        }
      }
    },
  },
  data() {
    return {
      trackedDate: new Date().toISOString().substr(0, 10),
      subtitulo: "Ejemplo de texto",
      // idUsuario: this.sacarid,
      alertas: "",
      vacio: true,
      nuevoF: false,
      personas: "",
      fecha: "",
      argumento: "",
      query: "",
      checkedNames: [],
      personasIDLista: [],
      i: 0,
      todos: false,
      fecha2: "",
      diaA: "",
      mesA: "",
      añoA: "",
      tomorrow: "",
      tomorrow2: "",
      // permisos: this.permisoAlertasP,
      // permisos2: this.permisoAlertasVer,
      queryP: "",
      personas2: "",
      expediente: "",
      expedientes: "",
      idNuevo: 0,
      alertas2: "",
      alertas3: "",
      verTodas: false,
    };
  },
  created: function () {
    this.alertasPendientes();
    this.verTodasF();
    this.alertasPasadas();
    this.date_function();
    this.cargarPersonas2();
    this.cargarExpedientes();
  },
};
</script>
<style scoped>
.text {
  font-size: 3vmin;
}
.marginBottom {
  margin-bottom: 3%;
}
.labelNombre {
  font-size: 3vmin;
  display: inline;
  margin-left: 5%;
}
#crearF {
  position: absolute;
  right: 5%;
  z-index: 5000;
  margin-top: 30px;
  font-size: 4vmin;
}
#cerrarF {
  position: absolute;
  top: 1%;
  right: 5%;
  z-index: 5000;
}
.formularioNueva {
  height: 100%;
  width: 100%;
  background: white;
  z-index: 5000;
  position: fixed;
  top: 0;
  left: 0;
  overflow: scroll;
  padding-left: 5%;
  padding-right: 5%;
  padding-top: 5%;
}
table {
  width: 100%;
  min-height: 30px;
}
.alerta {
  width: 90%;
  margin: auto;
  background: #e7f0ff;
  border-radius: 20px;
  display: flex;
  font-size: 3vmin;
  margin-bottom: 2%;
}
.fecha {
  border-right: solid;
  border-width: 1px;
  border-color: black;
  width: 20%;
}
.cerrar {
  border-left: solid;
  border-width: 1px;
  border-color: #000;
  width: 15%;
  max-width: 10px;
  background: #b30000ad;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
}
#botonNuevo {
  float: right;
  margin-bottom: 3%;
  font-size: 4vmin;
}
.descripcionPasadas {
  border-left: solid;
  border-width: 1px;
  border-color: #000;
  width: 80%;
  max-width: 10px;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
}
.alertaPasada {
  width: 90%;
  margin: auto;
  background: #bebebe;
  border-radius: 20px;
  display: flex;
  font-size: 3vmin;
  margin-bottom: 2%;
}
</style>