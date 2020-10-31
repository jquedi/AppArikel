<template>
  <div class="container" id="alertasC">
    <h1>ALERTAS</h1>
    <button
      id="botonNuevo"
      class="btn btn-success"
      @click="cerrarFormularion(true)"
    >
      Nueva
    </button>
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
          <label class="labelNombre"
            >{{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
            {{ persona.APELLIDO2 }}</label
          >
        </div>
      </div>
      <span>Total seleccionado: {{ checkedNames.length }}</span>

      <button id="crearF" class="btn btn-success" @click="guardarAlerta()">
        CREAR
      </button>
    </div>
    <div class="alerta" v-if="vacio">
      NO TIENE ALERTAS PENDIENTES
    </div>
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
  },
  methods: {
    ...mapGetters(["sacarid"]),
    ...mapMutations(["reducirAlertas"]),

    alertasPendientes: function () {
      axios
        .post("php/alertas.php", {
          usuario: this.idUsuario,
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
        })
        .then((response) => {
          this.personas = response.data;
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
      idUsuario: this.$store.getters.sacarid,
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
    };
  },
  created: function () {
    this.alertasPendientes();
    this.date_function();
  },
};
</script>
<style scoped>
.labelNombre {
  font-size: 3vmin;
  display: inline;
  margin-left: 5%;
}
#crearF {
  position: absolute;
  right: 0;
  z-index: 5000;
  margin-top: 30px;
}
#cerrarF {
  position: fixed;
  top: 0;
  right: 0;
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
</style>