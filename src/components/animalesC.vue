<template>
  <div class="container" id="animalesC">
    <h1>ANIMALES</h1>

    <label for="animal" v-if="!fichaAbierta">BUSCAR</label>
    <input
      v-if="!fichaAbierta"
      class="form-control input"
      id="animal"
      type="text"
      v-model="query"
      @keyup="cargaranimales()"
    />

    <!-- FICHA DE ANIMAL -->
    <div v-if="!fichaAbierta">
      <div
        class="fichaAnimalReducida"
        v-for="animal in animales"
        v-bind:key="animal.ID"
      >
        <div v-if="animal.ALERTAS > 0">
          <span class="badge">{{ animal.ALERTAS }}</span>
        </div>
        <div class="row" @click="abrirFicha(animal.ID)">
          <div class="col-sm-4">
            <div class="row">
              <div class="col">
                <img class="imgPerro" :src="animal.FOTO" alt="" />
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="nombre">
                  {{ animal.NOMBRE }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-8">
            <ul>
              <li class="trait">
                <strong>RAZA:</strong><font size="-2"> {{ animal.RAZA }}</font>
              </li>
              <li class="trait">
                <strong>UBICACIÓN:</strong
                ><font size="-2"> {{ animal.UBICACION }}</font>
              </li>
              <li class="trait">
                <strong>ESTADO:</strong
                ><font size="-2"> {{ animal.ESTADO }}</font>
              </li>
              <li v-if="animal.NOTAS != ''" class="trait">
                <strong>NOTAS:</strong
                ><font size="-2"> {{ animal.NOTAS }}</font>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- FICHA AMPLIADA -->

    <div v-if="fichaAbierta == true" class="fichaAbierta">
      <button
        class="btn btn-warning"
        style="position: absolute; right: 10%; z-index: 1000"
        @click="(fichaAbierta = false), cargarRepetidas()"
      >
        ATRÁS
      </button>

      <div class="row">
        <div class="col-md-6">
          <img class="imgPerro2" :src="animal[0][15]" alt="" />
        </div>
        <div class="col-md-6">
          <ul>
            <li class="trait2">
              <strong>NOMBRE:</strong
              ><font size="-1"> {{ this.animal[0][2] }}</font>
            </li>
            <li class="trait2">
              <strong>RAZA:</strong
              ><font size="-1"> {{ this.animal[0][3] }}</font>
            </li>
            <li class="trait2">
              <strong>CHIP:</strong
              ><font size="-1"> {{ this.animal[0][4] }}</font>
            </li>
            <li class="trait2">
              <strong>NACIMIENTO:</strong
              ><font size="-1"> {{ this.animal[0][5] }}</font>
            </li>
            <li class="trait2">
              <strong>UBICACIÓN:</strong
              ><font size="-1"> {{ this.animal[0][6] }}</font>
            </li>
            <li class="trait2">
              <strong>ALIMENTACIÓN:</strong
              ><font size="-1"> {{ this.animal[0][8] }}</font>
            </li>
            <li class="trait2">
              <strong>TIPO:</strong
              ><font size="-1"> {{ this.animal[0][9] }}</font>
            </li>
            <li class="trait2">
              <strong>ESTADO:</strong
              ><font size="-1"> {{ this.animal[0][13] }}</font>
            </li>
            <!-- <li v-if="notas != ''" class="trait2">
              <strong>NOTAS:</strong><font size="-1"> {{ animal.NOTAS }}</font>
            </li> -->
          </ul>
        </div>
      </div>
      <div class="row">
        <div
          v-if="this.animal[0][7] != ''"
          class="col-md-6 trait2"
          style="margin-top: 50px"
        >
          <strong>NOTAS:</strong><font size="-1"> {{ this.animal[0][7] }}</font>
        </div>
        <div
          v-if="this.animal[0][10] != ''"
          class="col-md-6 trait2"
          style="margin-top: 50px"
        >
          <strong>CAMPO1:</strong
          ><font size="-1"> {{ this.animal[0][10] }}</font>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6" style="margin-top: 50px">
          <span
            ><strong>CUIDADOS</strong
            ><button class="btn btn-success" @click="nuevaTarea('CUIDADO')">
              +
            </button></span
          >
          <div class="tareas">
            <div class="row">
              <div class="col-3">Fecha Inicio</div>
              <div class="col-3">Fecha Limite</div>
              <div class="col-6">Descripción</div>
            </div>
            <div
              v-for="tarea in tareas"
              v-bind:key="tarea.ID"
              @click="(abrirInfo = true), cargarTarea(tarea.ID)"
            >
              <div
                class="row"
                v-if="
                  tarea.TIPO == 'CUIDADO' &&
                  tarea.ESTADO == 'ACTIVO' &&
                  tarea.FECHAINICIO <= hoy
                "
                style="
                  background: #b0ccc8;
                  width: 100%;
                  margin: auto;
                  margin-bottom: 20px;
                  border-bottom: solid;
                  border-top: solid;
                "
              >
                <div class="col-3">
                  {{ tarea.FECHAINICIO }}
                </div>
                <div class="col-3">
                  {{ tarea.FECHALIMITE }}
                </div>
                <div class="col-6">
                  {{ tarea.DESCRIPCION }}
                </div>
              </div>
            </div>

            <span>FUTURAS</span>
            <div
              v-for="tarea in tareas"
              v-bind:key="tarea.ID"
              @click="(abrirInfo = true), cargarTarea(tarea.ID)"
            >
              <div
                class="row"
                v-if="
                  tarea.TIPO == 'CUIDADO' &&
                  tarea.ESTADO == 'ACTIVO' &&
                  tarea.FECHAINICIO > hoy
                "
                style="
                  background: #f2ffb9;
                  width: 100%;
                  margin: auto;
                  margin-bottom: 20px;
                  border-bottom: solid;
                  border-top: solid;
                "
              >
                <div class="col-3">
                  {{ tarea.FECHAINICIO }}
                </div>
                <div class="col-3">
                  {{ tarea.FECHALIMITE }}
                </div>
                <div class="col-6">
                  {{ tarea.DESCRIPCION }}
                </div>
              </div>
            </div>

            <span>FINALIZADAS</span>
            <div
              v-for="tarea in tareas"
              v-bind:key="tarea.ID"
              @click="(abrirInfo = true), cargarTarea(tarea.ID)"
            >
              <div
                class="row"
                v-if="tarea.TIPO == 'CUIDADO' && tarea.ESTADO == 'FINALIZADA'"
                style="
                  background: #f1f1f1;
                  width: 100%;
                  margin: auto;
                  margin-bottom: 20px;
                  border-bottom: solid;
                  border-top: solid;
                "
              >
                <div class="col-3">
                  {{ tarea.FECHAINICIO }}
                </div>
                <div class="col-3">
                  {{ tarea.FECHALIMITE }}
                </div>
                <div class="col-6">
                  {{ tarea.DESCRIPCION }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6" style="margin-top: 50px">
          <span
            ><strong>TAREAS</strong>
            <button class="btn btn-success" @click="nuevaTarea('TAREA')">
              +
            </button></span
          >
          <div class="tareas">
            <div class="row">
              <div class="col-3">Fecha Inicio</div>
              <div class="col-3">Fecha Limite</div>
              <div class="col-6">Descripción</div>
            </div>
            <div
              v-for="tarea in tareas"
              v-bind:key="tarea.ID"
              @click="(abrirInfo = true), cargarTarea(tarea.ID)"
            >
              <div
                class="row"
                v-if="
                  tarea.TIPO == 'TAREA' &&
                  tarea.ESTADO == 'ACTIVO' &&
                  tarea.FECHAINICIO <= hoy
                "
                style="
                  background: #b0ccc8;
                  width: 100%;
                  margin: auto;
                  margin-bottom: 20px;
                  border-bottom: solid;
                  border-top: solid;
                "
              >
                <div class="col-3">
                  {{ tarea.FECHAINICIO }}
                </div>
                <div class="col-3">
                  {{ tarea.FECHALIMITE }}
                </div>
                <div class="col-6">
                  {{ tarea.DESCRIPCION }}
                </div>
              </div>
            </div>

            <span>FUTURAS</span>
            <div
              v-for="tarea in tareas"
              v-bind:key="tarea.ID"
              @click="(abrirInfo = true), cargarTarea(tarea.ID)"
            >
              <div
                class="row"
                v-if="
                  tarea.TIPO == 'TAREA' &&
                  tarea.ESTADO == 'ACTIVO' &&
                  tarea.FECHAINICIO > hoy
                "
                style="
                  background: #f2ffb9;
                  width: 100%;
                  margin: auto;
                  margin-bottom: 20px;
                  border-bottom: solid;
                  border-top: solid;
                "
              >
                <div class="col-3">
                  {{ tarea.FECHAINICIO }}
                </div>
                <div class="col-3">
                  {{ tarea.FECHALIMITE }}
                </div>
                <div class="col-6">
                  {{ tarea.DESCRIPCION }}
                </div>
              </div>
            </div>

            <span>FINALIZADAS</span>
            <div
              v-for="tarea in tareas"
              v-bind:key="tarea.ID"
              @click="(abrirInfo = true), cargarTarea(tarea.ID)"
            >
              <div
                class="row"
                v-if="tarea.TIPO == 'TAREA' && tarea.ESTADO == 'FINALIZADA'"
                style="
                  background: #f1f1f1;
                  width: 100%;
                  margin: auto;
                  margin-bottom: 20px;
                  border-bottom: solid;
                  border-top: solid;
                "
              >
                <div class="col-3">
                  {{ tarea.FECHAINICIO }}
                </div>
                <div class="col-3">
                  {{ tarea.FECHALIMITE }}
                </div>
                <div class="col-6">
                  {{ tarea.DESCRIPCION }}
                </div>
              </div>
            </div>
          </div>
        </div>
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
            <strong>Tipo:</strong> {{ this.tarea[0][3] }}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 colClase">
            <strong>Animal:</strong> {{ this.animal[0][2] }}
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
          <div style="border: none;" class="col-sm-6 colClase" v-if="this.tarea[0][10] == 'ACTIVO'">
            <button @click="finalizarTarea()" class="btn btn-success">
              Finalizar
            </button>
          </div>
          <div style="border: none;" class="col-sm-6 colClase" v-if="this.tarea[0][6] > 0">
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
            <label for="animal">Animal</label>

            <select
              class="form-control input"
              id="animal"
              v-model="animalCrear"
              :readonly="!editar"
            >
              <option v-bind:value="this.animal[0][0]">
                {{ this.animal[0][2] }}
              </option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="tipo">Tipo</label>

            <select class="form-control input" id="tipo" v-model="tipo">
              <option value="TAREA">Tarea</option>
              <option value="CUIDADO">Cuidado</option>
            </select>
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
  name: "animalesC",
  components: {
    Datepicker,
  },
  computed: {
    ...mapState(["persona"]),
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

    cargarRepetidas() {
      var fechaActual = new Date();

      fechaActual = fechaActual.toJSON().slice(0, 10).replace(/-/g, "-");

      axios
        .post("php/recargarTareasRecursivas.php", {
          fecha: fechaActual,
        })
        .then((response) => {
          this.aux = response.data;

          this.cargaranimales();
        });
    },

    nuevaTarea(tipo) {
      this.crearTarea = true;

      this.animalCrear = this.animal[0][0];

      this.tipo = tipo;

      this.formatPicker();
      this.formatPicker2();
    },
    crearTareaF() {
      axios
        .post("php/crearTarea.php", {
          animal: this.animalCrear,
          descripcion: this.descripcion,
          tipo: this.tipo,
          fecha1: this.fecha1,
          fecha2: this.fecha2,
          recursividad: this.recursividad,
          recursividadTipo: this.recursividadTipo,
        })
        .then((response) => {
          this.aux = response.data;

          this.animalCrear = 0;
          this.fecha1 = new Date().toISOString().substr(0, 10);
          this.fecha2 = new Date().toISOString().substr(0, 10);
          this.trackedDate = new Date().toISOString().substr(0, 10);
          this.trackedDate2 = new Date().toISOString().substr(0, 10);
          this.descripcion = "";
          this.tipo = "";
          this.recursividad = 0;
          this.recursividadTipo = "DIAS";
          this.estado = "";
          this.recursividadPregunta = 0;

          this.abrirFicha(this.animal[0][0]);

          this.crearTarea = false;
        });
    },

    finalizarTarea() {
      axios
        .post("php/finalizarTarea.php", {
          query: this.tarea[0][0],
          usuario: this.idUsuario,
        })
        .then((response) => {
          this.aux = response.data;

          this.abrirInfo = false;

          this.cargarRepetidas();
          this.abrirFicha(this.animal[0][0]);
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

          this.abrirFicha(this.animal[0][0]);
        });
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

    abrirFicha(id) {
      this.fichaAbierta = true;

      axios
        .post("php/animalFull.php", {
          query: id,
        })
        .then((response) => {
          this.animal = response.data;
        });
      axios
        .post("php/tareasAnimales.php", {
          query: id,
        })
        .then((response) => {
          this.tareas = response.data;
        });
    },

    cargaranimales: function () {
      axios.post("php/tareasAnimalesCont.php", {}).then((response) => {
        this.animales = response.data;
        axios
          .post("php/listaAnimales.php", {
            query: this.query,
          })
          .then((response) => {
            this.animales = response.data;
          });
      });
    },
  },
  data() {
    return {
      trackedDate: new Date().toISOString().substr(0, 10),
      trackedDate2: new Date().toISOString().substr(0, 10),

      hoy: new Date().toISOString().substr(0, 10),

      animales: "",
      query: "",

      fichaAbierta: false,

      animal: "",

      tareas: "",

      abrirInfo: false,

      tarea: "",

      animalCrear: 0,
      fecha1: "",
      fecha2: "",
      descripcion: "",
      tipo: "",
      usuario: "",
      recursividad: 0,
      recursividadTipo: "DIAS",
      estado: "",

      aux: "",

      crearTarea: "",

      editar: false,

      recursividadPregunta: 0,
    };
  },
  created: function () {
    this.cargarRepetidas();
  },
};
</script>
<style scoped>
.tareas {
  width: 100%;
  min-height: 200px;
  border: solid;
  border-radius: 10px;
  max-height: 500px;
  overflow-x: hidden;
  overflow-y: auto;
}
.fichaAbierta {
  width: 100%;
}
.badge {
  position: absolute;
  top: -20px;
  padding: 8px 12px;
  border-radius: 50%;
  background-color: red;
  color: white;
  left: -20px;
}
.fichaAnimalReducida {
  width: 80%;
  background: #d6dfea;
  padding: 10px;
  border: solid;
  border-width: 2px;
  margin: auto;
  border-color: #a95252;
  position: relative;
  margin-top: 50px;
}
.imgPerro {
  width: 150px;
  height: 150px;
}
.imgPerro2 {
  width: 300px;
  height: 300px;
  border-radius: 10px;
}
.nombre {
  font-size: 25px;
  font-weight: 800;
}
.trait {
  color: black;
}
.trait2 {
  color: black;
}
.col {
  flex-basis: 0;
  flex-grow: 1;
  max-width: 100%;
  padding: 0;
}
ul {
  height: 100%;
  margin: 0;
  width: 100%;
  padding: 0;
  text-align: left;
}
li {
  list-style-type: none;
  position: inherit;
  margin-left: 10px;
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