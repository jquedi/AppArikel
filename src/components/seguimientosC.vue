<template>
  <div class="container" id="seguimientosC">
    <h1>Seguimientos</h1>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-9">
            <button
              id="botonNuevo"
              class="btn btn-success"
              @click="abrirSucesoNuevo(), trackedDate = new Date().toISOString().substr(0, 10)"
            >NUEVO</button>
          </div>
          <div class="col-md-3" align="right">
            <input
              type="text"
              class="form-control input-sm"
              placeholder="Buscar"
              v-model="query"
              @keyup="fetchData()"
            />
            <select class="form-control input" id="ordenar" v-model="ordenarPor">
              <option disabled selected>Ordenar por</option>
              <option value="ESTADO">Estado</option>
              <option value="FECHA, -1">Fecha(Primero mayor)</option>
              <option value="FECHA">Fecha(Primero menor)</option>
              <option value="TIPO">Tipo</option>
              <option value="IDEXPEDIENTE">Expediente</option>
            </select>
            <button
              id="botonFiltro"
              class="btn btn-info"
              @click="abrirFiltro(), trackedDate = ''"
            >Filtrar</button>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" style="table-layout: fixed;">
            <tr>
              <th class="text fecha">FECHA</th>
              <th class="text campo1">REQUERIMIENTO</th>
              <th class="text campo2">SUCESO</th>
            </tr>
            <tr
              v-for="(seguimiento) in orderBy(seguimientos, this.ordenarPor)"
              v-bind:key="seguimiento.ID"
              @click="abrirSuceso(seguimiento), editar=false"
              :style="btnStyles(seguimiento.ESTADO)"
            >
              <td class="text fecha">{{ seguimiento.FECHA }}</td>
              <td class="text campo1">{{ seguimiento.REQUERIMIENTO }}</td>
              <td class="text campo2">{{ seguimiento.SUCESO }}</td>
            </tr>
            <tr v-if="nodata">
              <td class="text" colspan="3" align="center">No Data Found</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div id="oculto" v-if="showSuceso">
      <div id="oculto2" @click="showSuceso = false, editar=false"></div>
      <button
        class="btn btn-primary editar"
        v-if="estado=='REQUERIDO' && editar==false"
        @click="editar=true"
      >Editar</button>
      <button
        class="btn btn-primary editar"
        v-if="estado=='REQUERIDO' && editar==true"
        @click="guardar(false)"
      >Guardar</button>
      <div id="cajaSeguimiento" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha">Fecha</label>
            <input
              class="form-control input"
              id="fecha"
              type="text"
              v-bind:value="fecha"
              placeholder="Fecha"
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
            <label for="persona">Persona</label>
            <input
              class="form-control input"
              id="persona"
              v-bind:value="persona"
              type="text"
              placeholder="Persona"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="animal">Animal</label>
            <input
              class="form-control input"
              type="text"
              id="animal"
              v-bind:value="animal"
              placeholder="Animal"
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
            <label for="tipo">Tipo</label>
            <input
              id="tipo"
              class="form-control input"
              type="text"
              v-bind:value="tipo"
              placeholder="Tipo"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="expediente">Expediente</label>
            <input
              class="form-control input"
              id="expediente"
              type="text"
              v-bind:value="expediente"
              placeholder="Expediente"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <textarea
              class="form-control input"
              name
              id
              cols="30"
              rows="10"
              placeholder="Requerimiento"
              v-bind:value="requerimiento"
              readonly="true"
            ></textarea>
          </div>
          <div class="col-md-6">
            <textarea
              class="form-control input"
              name
              id
              cols="30"
              rows="10"
              placeholder="Suceso"
              v-model="suceso"
              :readonly="!editar"
            ></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <textarea
              class="form-control input"
              name
              id
              cols="30"
              rows="10"
              placeholder="Actuación"
              v-model="actuacion"
              :readonly="!editar"
            ></textarea>
          </div>
          <div class="col-md-6">
            <textarea
              class="form-control input"
              name
              id
              cols="30"
              rows="10"
              placeholder="Campo1"
              v-bind:value="campo1"
              readonly="true"
            ></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <span class="estado" v-if="estado == 'VALIDADO'">VALIDADO</span>
            <span class="estado" style="color: rgb(250 242 215);" v-if="estado == 'RECORDATORIO'">RECORDATORIO</span>
            <span class="estado" style="color: rgb(215 219 250);" v-if="estado == 'PENDIENTE'">PENDIENTE</span>
            <span class="estado" style="color: #fad7d7;" v-if="estado == 'REQUERIDO'">REQUERIDO</span>
          </div>
        </div>
      </div>
    </div>
    <div id="ocultoNuevo" v-if="showSucesoNuevo">
      <div id="oculto2Nuevo" @click="showSucesoNuevo = false"></div>
      <button class="btn btn-primary editar" @click="guardar(true)">Guardar</button>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha2">Fecha</label>
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
            <label for="persona2">Persona</label>
            <input
              class="form-control input"
              id="persona2"
              v-bind:value="persona2"
              type="text"
              placeholder="Persona"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="animal2">Animal</label>
            <select class="form-control input" id="animal2" v-model="animal2">
              <option
                v-for="(animales) in animalLista"
                v-bind:key="animales.ID"
              >{{ animales.NOMBRE }}</option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="tipo2">Tipo</label>
            <select class="form-control input" id="tipo2" v-model="tipo2">
              <option v-for="(tipo) in tipos" v-bind:key="tipo.ID">{{ tipo.SEGUIMIENTOTIPO }}</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="expediente2">Expediente</label>
            <select
              class="form-control input"
              id="expediente2"
              v-model="expediente2"
              @change="acAnimales"
            >
              <option
                v-for="(expediente) in expedientes"
                v-bind:key="expediente.ID"
              >{{ expediente.DESCRIPCION }}</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6" v-if="requerimiento2 != ''">
            <textarea
              class="form-control input"
              name
              id
              cols="30"
              rows="10"
              placeholder="Requerimiento"
              v-bind:value="requerimiento2"
              readonly="true"
            ></textarea>
          </div>
          <div class="col-md-6">
            <textarea
              class="form-control input"
              name
              id
              cols="30"
              rows="10"
              placeholder="Suceso"
              v-model="suceso2"
            ></textarea>
          </div>
        </div>
      </div>
    </div>
    <div id="ocultoNuevo" v-if="filtrar">
      <div id="oculto2Nuevo" @click="filtrar = false"></div>
      <button class="btn btn-primary editar" @click="cargarFiltro()">Filtrar</button>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha2">Fecha</label>
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
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="animal2">Animal</label>
            <select class="form-control input" id="animal2" v-model="animal2">
              <option
                v-for="(animales) in animalLista"
                v-bind:key="animales.ID"
              >{{ animales.NOMBRE }}</option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="tipo2">Tipo</label>
            <select class="form-control input" id="tipo2" v-model="tipo2">
              <option v-for="(tipo) in tipos" v-bind:key="tipo.ID">{{ tipo.SEGUIMIENTOTIPO }}</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="expediente2">Expediente</label>
            <select
              class="form-control input"
              id="expediente2"
              v-model="expediente2"
              @change="acAnimales"
            >
              <option
                v-for="(expediente) in expedientes"
                v-bind:key="expediente.ID"
              >{{ expediente.DESCRIPCION }}</option>
            </select>
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
import Vue2Filters from "vue2-filters";

export default {
  name: "seguimientosC",
  mixins: [Vue2Filters.mixin],
  components: {
    Datepicker,
  },
  computed: {
    ...mapState(["persona"]),
  },
  data() {
    return {
      trackedDate: new Date().toISOString().substr(0, 10),
      subtitulo: "culo",
      seguimientos: "",
      query: "",
      nodata: false,
      showSuceso: false,
      showSucesoNuevo: false,
      idSeguimiento: "",
      persona: "Persona",
      fecha: "Fecha",
      animal: "Animal",
      tipo: "Tipo",
      expediente: "Expediente",
      requerimiento: "Requerimiento",
      suceso: "Suceso",
      actuacion: "Actuación",
      campo1: "Campo1",
      estado: "VALIDADO",
      persona2: "",
      fecha2: "",
      animal2: "",
      tipo2: "",
      expediente2: "",
      requerimiento2: "",
      suceso2: "Sin novedad",
      actuacion2: "",
      campo12: "",
      idUsuario: this.$store.getters.sacarid,
      guia: "NO",
      tipos: "",
      expedientes: "",
      animalLista: "",
      editar: false,
      personaID: "",
      ordenarPor: "Ordenar por",
      filtrar: false,
    };
  },
  methods: {
    ...mapMutations(["modificar"]),
    ...mapGetters(["sacarid"]),

    btnStyles: function (estado) {
      if (estado == "REQUERIDO")
        return {
          background: "#fad7d7",
        };
      if (estado == "PENDIENTE")
        return {
          background: "rgb(215 219 250)",
        };
      if (estado == "RECORDATORIO")
        return {
          background: "rgb(250 242 215)",
        };
      else
        return {
          background: "",
        };
    },

    formatPicker: function () {
      var self = this;
      var d = new Date(self.trackedDate);
      self.fecha2 =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },

    fetchData: function () {
      axios
        .post("php/seguimientos.php", {
          query: this.query,
          usuario: this.idUsuario,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.seguimientos = response.data;
            this.nodata = false;
          } else {
            this.seguimientos = "";
            this.nodata = true;
          }
        });
    },
    abrirSucesoNuevo() {
      this.showSucesoNuevo = !this.showSucesoNuevo;
      this.tipo2 = "";
      this.expediente2 = 0;
      this.animalLista = "";
      this.animal2 = 0;
      axios
        .post("php/persona.php", {
          query: this.idUsuario,
        })
        .then((response) => {
          this.persona2 = response.data;
        });
      axios
        .post("php/expedientes.php", {
          query: this.idUsuario,
        })
        .then((response) => {
          this.expedientes = response.data;
        });
      axios
        .post("php/seguimientotipo.php", {
          query: this.guia,
        })
        .then((response) => {
          this.tipos = response.data;
        });
    },
    abrirFiltro() {
      this.filtrar = true;
      this.tipo2 = "";
      this.expediente2 = "";
      this.animalLista = "";
      this.animal2 = "";
      this.expedientes = "";
      this.tipos = "";
      this.fecha2 = "";
      axios
        .post("php/expedientes.php", {
          query: this.idUsuario,
        })
        .then((response) => {
          this.expedientes = response.data;
        });
      axios
        .post("php/seguimientotipo.php", {
          query: this.guia,
        })
        .then((response) => {
          this.tipos = response.data;
        });
    },
    cargarFiltro() {
      this.filtrar = false;

      axios
        .post("php/seguimientos.php", {
          tipo: this.tipo2,
          fecha: this.fecha2,
          expediente: this.expediente2,
          animal: this.animal2,
          usuario: this.idUsuario,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.seguimientos = response.data;
            this.nodata = false;
          } else {
            this.seguimientos = "";
            this.nodata = true;
          }
          this.tipo2 = "";
          this.expediente2 = 0;
          this.animalLista = "";
          this.animal2 = 0;
          this.expedientes = "";
          this.tipos = "";
          this.fecha2 = "";
        });
    },
    abrirSuceso(value) {
      this.showSuceso = !this.showSuceso;
      this.tipo = value.TIPO;
      this.requerimiento = value.REQUERIMIENTO;
      this.suceso = value.SUCESO;
      this.actuacion = value.ACTUACION;
      this.campo1 = value.CAMPO1;
      this.fecha = value.FECHA;
      this.estado = value.ESTADO;

      this.idSeguimiento = value.ID;

      var aux = value.IDANIMAL;
      this.personaID = value.IDPERSONA;
      var aux3 = value.IDEXPEDIENTE;

      axios
        .post("php/animales.php", {
          query: aux,
        })
        .then((response) => {
          this.animal = response.data;
        });
      axios
        .post("php/persona.php", {
          query: this.personaID,
        })
        .then((response) => {
          this.persona = response.data;
        });
      axios
        .post("php/expediente.php", {
          query: aux3,
        })
        .then((response) => {
          this.expediente = response.data;
        });
    },
    acAnimales() {
      this.animal2 = 0;
      this.animalLista = "";
      axios
        .post("php/animalesExpediente.php", {
          query: this.expediente2,
        })
        .then((response) => {
          this.animalLista = response.data;
        });
    },
    guardar(aux) {
      var aux1 = "";
      var aux2 = "";
      var aux3 = "";
      var aux4 = "";
      var aux5 = "";
      var aux6 = "";
      var aux7 = "";
      var aux8 = "";
      var aux9 = "";
      var aux10 = 0;

      if (aux) {
        this.formatPicker();
        aux1 = this.fecha2;
        aux2 = this.idUsuario;
        aux3 = this.animal2;
        aux4 = this.tipo2;
        aux5 = this.expediente2;
        aux6 = this.suceso2;
        if (aux5 == "") {
          this.$notify({
            group: "foo",
            title: "AVISO",
            text: "Debe seleccionar un expediente para poder guardar.",
            type: "error",
          });
          return 0;
        }
      } else {
        aux1 = this.fecha;
        aux2 = this.personaID;
        aux3 = this.animal;
        aux4 = this.tipo;
        aux5 = this.expediente;
        aux6 = this.suceso;
        aux7 = this.actuacion;
        aux8 = this.requerimiento;
        aux9 = this.campo1;
        aux10 = this.idSeguimiento;
      }
      axios
        .post("php/guardarRegistro.php", {
          fecha: aux1,
          persona: aux2,
          animal: aux3,
          tipo: aux4,
          expediente: aux5,
          suceso: aux6,
          actuacion: aux7,
          requerimiento: aux8,
          campo1: aux9,
          id: aux10,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Exito",
            text: response.data,
            type: "success",
          });
          this.showSuceso = false;
          this.showSucesoNuevo = false;
        });
    },
  },
  created: function () {
    this.fetchData();
  },
};
</script>

<style scoped>
.estado {
  font-size: 3vmin;
  font-weight: 600;
}
.recordatorio {
  background-color: violet;
}
.pendiente {
  background-color: red;
}
.requerido {
  background-color: blue;
}
.editar {
  height: 7vmin;
  width: 14vmin;
  margin-bottom: 3%;
  font-size: 2vmin;
  z-index: 10;
  position: fixed;
  top: 2%;
  right: 10%;
}
label {
  margin-bottom: 0%;
  float: left;
  margin-top: 2%;
}
.input {
  margin-top: 1%;
}
.calendario {
  width: 200px;
}
#botonNuevo {
  float: left;
  height: 7vmin;
  width: 14vmin;
  margin-bottom: 3%;
  font-size: 2vmin;
}
#botonFiltro {
  float: right;
  height: 7vmin;
  width: 14vmin;
  font-size: 2vmin;
}
.text {
  font-size: 2vmin;
}
.fecha {
  width: 7%;
}
.campo1 {
  width: 15%;
}
.campo2 {
  width: 15%;
}
#oculto {
  background: #00000052;
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 5000;
}
#cajaSeguimiento {
  height: 80%;
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
#oculto2 {
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
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
  height: 80%;
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
</style>