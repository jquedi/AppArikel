<template>
  <div class="container" id="seguimientosC">
    <h1>Seguimientos</h1>
    <h2>{{subtitulo}}</h2>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-9">
            <button id="botonNuevo" class="btn btn-success" @click="abrirSucesoNuevo">NUEVO</button>
          </div>
          <div class="col-md-3" align="right">
            <input
              type="text"
              class="form-control input-sm"
              placeholder="Search Data"
              v-model="query"
              @keyup="fetchData()"
            />
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
              v-for="(seguimiento) in seguimientos"
              v-bind:key="seguimiento.ID"
              @click="abrirSuceso(seguimiento)"
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
      <div id="oculto2" @click="abrirSuceso"></div>
      <div id="cajaSeguimiento" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <input
              class="form-control input"
              type="text"
              v-bind:value="fecha"
              placeholder="Fecha"
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
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
            <input
              class="form-control input"
              type="text"
              v-bind:value="animal"
              placeholder="Animal"
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
            <input class="form-control input" type="text" v-bind:value="tipo" placeholder="Tipo" readonly="true" />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <input
              class="form-control input"
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
              v-bind:value="suceso"
              readonly="true"
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
              v-bind:value="actuacion"
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
              placeholder="Campo1"
              v-bind:value="campo1"
              readonly="true"
            ></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <span v-if="estado == 'VALIDADO'">VALIDADO</span>
            <span v-if="estado == 'RECORDATORIO'">RECORDATORIO</span>
            <span v-if="estado == 'PENDIENTE'">PENDIENTE</span>
            <span v-if="estado == 'REQUERIDO'">REQUERIDO</span>
          </div>
        </div>
      </div>
    </div>
    <div id="ocultoNuevo" v-if="showSucesoNuevo">
      <div id="oculto2Nuevo" @click="abrirSucesoNuevo"></div>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <input class="form-control input" type="text" v-bind:value="fecha2" placeholder="Fecha" />
          </div>
          <div class="col-sm-6">
            <input class="form-control input" id v-bind:value="persona2" type="text" placeholder="Persona" readonly="true"/>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <input class="form-control input" type="text" v-bind:value="animal2" placeholder="Animal" />
          </div>
          <div class="col-sm-6">
            <select class="form-control input" id="sel1" v-model="tipo2">
              <option v-for="(tipo) in tipos" v-bind:key="tipo.ID">{{ tipo.SEGUIMIENTOTIPO }}</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <select class="form-control input" id="sel1" v-model="expediente2">
              <option v-for="(expediente) in expedientes" v-bind:key="expediente.ID" v-bind:value="expediente.ID">{{ expediente.DESCRIPCION }}</option>
            </select>
            expediente2: {{expediente2}}
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
              v-bind:value="suceso2"
            ></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters, mapMutations } from "vuex";

export default {
  name: "seguimientosC",
  computed: {
    ...mapState(["persona"]),
  },
  data() {
    return {
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
      suceso2: "",
      actuacion2: "",
      campo12: "",
      idUsuario: this.$store.getters.sacarid,
      guia: "NO",
      tipos: "",
      expedientes: "",
    };
  },
  methods: {
    ...mapMutations(["modificar"]),
    ...mapGetters(["sacarid"]),

    fetchData: function () {
      axios
        .post("http://app.arikelk9.es/seguimientos.php", {
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

      axios
        .post("http://app.arikelk9.es/persona.php", {
          query: this.idUsuario,
        })
        .then((response) => {
          this.persona2 = response.data;
        });
      axios
        .post("http://app.arikelk9.es/expedientes.php", {
          query: this.idUsuario,
        })
        .then((response) => {
          this.expedientes = response.data;
        });
      axios
        .post("http://app.arikelk9.es/seguimientotipo.php", {
          query: this.guia,
        })
        .then((response) => {
          this.tipos = response.data;
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

      var aux = value.IDANIMAL;
      var aux2 = value.IDPERSONA;
      var aux3 = value.IDEXPEDIENTE;

      axios
        .post("http://app.arikelk9.es/animales.php", {
          query: aux,
        })
        .then((response) => {
          this.animal = response.data;
        });
      axios
        .post("http://app.arikelk9.es/persona.php", {
          query: aux2,
        })
        .then((response) => {
          this.persona = response.data;
        });
      axios
        .post("http://app.arikelk9.es/expediente.php", {
          query: aux3,
        })
        .then((response) => {
          this.expediente = response.data;
        });
    },
  },
  created: function () {
    this.fetchData();
  },
};
</script>

<style scoped>
#botonNuevo {
  float: left;
  height: 7vmin;
  width: 14vmin;
  margin-bottom: 3%;
  font-size: 2vmin;
}
.input {
  width: 80%;
  margin-top: 2%;
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
  background-color: white;
  top: 10%;
  position: fixed;
  left: 10%;
  z-index: 10;
  overflow: auto;
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
  background-color: white;
  top: 10%;
  position: fixed;
  left: 10%;
  z-index: 10;
  overflow: auto;
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