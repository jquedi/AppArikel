<template>
  <div class="container" id="instalacionesC">
    <h1>instalaciones</h1>

    <div class="row">
      <div class="col" style="text-align: end;">
        <button
          class="btn btn-warning"
          style="z-index: 1000;margin-bottom: 30px;"
          @click="nuevaTarea()"
        >
          NUEVA TAREA
        </button>
      </div>
    </div>

    <!-- tarea -->

    <div class="alerta text" v-if="vacio">No hay tareas disponibles</div>
    <div v-for="(alerta, index) in alertas" v-bind:key="index">
      <div
        class="alerta"
        v-if="alerta.ESTADO == 'ACTIVO'"
        :style="btnStyles(alerta.FECHALIMITE)"
      >
        <table>
          <tr>
            <td class="fecha">{{ alerta.FECHALIMITE }}</td>
            <td 
              @click="(abrirInfo = true), cargarTarea(alerta.ID)">{{ alerta.DESCRIPCION }}</td>
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



    

    <h3 style="margin-top:50px; margin-bottom: 30px;">TAREAS FINALIZADAS</h3>
    <div v-for="(alerta, index) in alertas" v-bind:key="index">
      <div
        style="background: #e8e8e8;"
        class="alerta"
        v-if="alerta.ESTADO == 'FINALIZADA'"
      >
        <table>
          <tr>
            <td class="fecha">{{ alerta.FECHALIMITE }}</td>
            <td 
              @click="(abrirInfo = true), cargarTarea(alerta.ID)">{{ alerta.DESCRIPCION }}</td>
          </tr>
        </table>
      </div>
    </div>


    <!-- INFO TAREA-->

    <div id="ocultoNuevo" v-if="abrirInfo">
      <div id="oculto2Nuevo" @click="abrirInfo = false"></div>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6 colClase">
            <strong> Fecha Inicio: </strong>{{ this.tarea[0][4] }}
          </div>
          <div class="col-sm-6 colClase">
            <strong>Fecha Limite:</strong> {{ this.tarea[0][5] }}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 colClase">
            <strong>Descripción:</strong> {{ this.tarea[0][2] }}
          </div>
          <div class="col-sm-6 colClase">
            <strong>Estado:</strong> {{ this.tarea[0][10] }}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 colClase" v-if="this.tarea[0][9] > 0">
            <strong>Finalizada por:</strong> {{ usuario }}
          </div>
          <div class="col-sm-6 colClase" v-if="this.tarea[0][6] > 0">
            <strong>Repetir cada </strong>{{ this.tarea[0][6] }}
            {{ this.tarea[0][7] }}
          </div>
        </div>
        <div class="row" style="border: none;">
          <div style="border: none;" class="col colClase" v-if="this.tarea[0][6] > 0">
            <button @click="finalizarRepeticion()" class="btn btn-warning">
              Finalizar repeticiones
            </button>
          </div>
        </div>
      </div>
    </div>



    <!-- Crear Tarea-->

    <div id="ocultoNuevo" v-if="crearTarea">
      <div id="oculto2Nuevo" @click="crearTarea = false"></div>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha">Fecha Inicio</label>

            <datepicker
              id="fecha"
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
            <label for="fecha">Fecha Limite</label>

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
              @input="formatPicker2()"
              v-model="trackedDate2"
            ></datepicker>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="descripcion">Descripción</label>
            <textarea
              class="form-control input"
              name
              id="descripcion"
              cols="30"
              rows="10"
              placeholder="Descripción"
              v-model="descripcion"
            ></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <label for="repetir">Repetir</label>

            <select
              class="form-control input"
              id="repetir"
              v-model="recursividadPregunta"
            >
              <option value="0">NO</option>
              <option value="1">SI</option>
            </select>
          </div>
          <div class="col-sm-6" v-if="recursividadPregunta == 1">
            <span
              >Repetir cada <input type="number" v-model="recursividad" />

              <select
                class="form-control input"
                id="repetir"
                v-model="recursividadTipo"
              >
                <option value="DIAS">dias</option>
                <option value="MESES">meses</option>
                <option value="AÑOS">años</option>
              </select>
            </span>
          </div>
        </div>

        <button @click="crearTareaF()" class="btn btn-success">Crear</button>
      </div>
    </div>

    <notifications group="foo" position="bottom right" />
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters } from "vuex";
import Datepicker from "vuejs-datepicker";

export default {
  name: "instalacionesC",
  components: {
    Datepicker,
  },
  computed: {
    ...mapState(["persona"]),
    // ...mapGetters(["sacarid"], ["permisoAlertasP"], ["permisoAlertasVer"]),
    ...mapGetters({
      idUsuario: "sacarid",
    }),
  },
  methods: {
    formatPicker: function () {
      var self = this;
      var d = new Date(self.trackedDate);
      self.fecha1 =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },
    formatPicker2: function () {
      var self = this;
      var d = new Date(self.trackedDate2);
      self.fecha2 =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },

    cargarTareas() {
      axios
        .post("php/tareasAnimales.php", {
          query: -1,
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

    cerrarAlerta(alerta) {
      axios
        .post("php/finalizarTarea.php", {
          query: alerta.ID,
          usuario: this.idUsuario,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.cargarTareas();
        });
    },
    nuevaTarea() {
      this.crearTarea = true;

      this.formatPicker();
      this.formatPicker2();
    },
    crearTareaF() {
      axios
        .post("php/crearTarea.php", {
          animal: -1,
          descripcion: this.descripcion,
          tipo: "TAREA",
          fecha1: this.fecha1,
          fecha2: this.fecha2,
          recursividad: this.recursividad,
          recursividadTipo: this.recursividadTipo,
        })
        .then((response) => {
          this.aux = response.data;

          this.fecha1 = new Date().toISOString().substr(0, 10);
          this.fecha2 = new Date().toISOString().substr(0, 10);
          this.trackedDate = new Date().toISOString().substr(0, 10);
          this.trackedDate2 = new Date().toISOString().substr(0, 10);
          this.descripcion = "";
          this.recursividad = 0;
          this.recursividadTipo = "DIAS";
          this.recursividadPregunta = 0;

          this.cargarTareas();

          this.crearTarea = false;
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

    
    cargarTarea(id) {
      axios
        .post("php/tareaFull.php", {
          query: id,
        })
        .then((response) => {
          this.tarea = response.data;

          axios
            .post("php/persona.php", {
              query: this.tarea[0][9],
            })
            .then((response) => {
              this.usuario = response.data;
            });
        });
    },
    finalizarRepeticion() {
      axios
        .post("php/finalizarRepeticionTarea.php", {
          query: this.tarea[0][0],
        })
        .then((response) => {
          this.aux = response.data;

          this.abrirInfo = false;
          this.cargarTareas();
        });
    },
  },
  data() {
    return {
      alertas: "",
      vacio: false,

      tomorrow: "",
      tomorrow2: "",

      usuario: "",
      crearTarea: false,

      aux: "",

      fecha1: new Date().toISOString().substr(0, 10),
      fecha2: new Date().toISOString().substr(0, 10),
      trackedDate: new Date().toISOString().substr(0, 10),
      trackedDate2: new Date().toISOString().substr(0, 10),
      descripcion: "",
      recursividad: 0,
      recursividadTipo: "DIAS",
      recursividadPregunta: 0,

      abrirInfo: false,
      tarea: "",
    };
  },
  created: function () {
    this.cargarTareas();
    this.date_function();
  },
};
</script>
<style scoped>
table {
  width: 100%;
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
#ocultoNuevo {
  background: #00000052;
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 5000;
}
#cajaSeguimientoNuevo {
  width: 80%;
  margin: auto;
  background-color: #fff;
  top: 10%;
  position: fixed;
  left: 10%;
  z-index: 10;
  overflow: auto;
  padding: 2%;
}
#oculto2Nuevo {
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
}
.colClase {
  margin-bottom: 25px;
  border-bottom: solid;
  border-width: 2px;
}
</style>