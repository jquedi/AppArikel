<template>
  <div class="container" id="documentosC">
    <h1>documentos</h1>
    <h2>{{ subtitulo }}</h2>
    <div id="cajaSeguimientoNuevo" class="panel panel-default">
      <div class="row">
        <div class="col">
          <label for="expediente2">Expediente</label>
          <select
            class="form-control input"
            id="expediente2"
            v-model="expediente2"
            @change="buscarDocu"
          >
            <option value="">--</option>
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
          <label for="evento2">Evento</label>
          <select
            class="form-control input"
            id="evento2"
            v-model="evento2"
            @change="buscarDocu"
          >
            <option value="">--</option>
            <option
              v-for="evento in eventos"
              v-bind:key="evento.ID"
              v-bind:value="evento.ID"
            >
              {{ evento.DESCRIPCION }}
            </option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="animal2">Animal</label>
          <select
            class="form-control input"
            id="animal2"
            v-model="animal2"
            @change="buscarDocu"
          >
            <option value="">--</option>
            <option
              v-for="animal in animales"
              v-bind:key="animal.ID"
              v-bind:value="animal.ID"
            >
              {{ animal.NOMBRE }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div id="containerDocu">
      <div
        id="docu"
        v-for="(documento, index) in documentos"
        v-bind:key="index"
      >
        <label for="fecha" style="float: left; margin-left: 10px">Fecha</label>
        <label for="descrip">Descripción</label>
        <table style="width: 100%">
          <tr>
            <td id="fecha">{{ documento.FECHA }}</td>
            <td id="descrip">{{ documento.DESCRIPCION }}</td>
          </tr>
        </table>
      </div>
      <div v-if="nodata" id="docu">
        <table style="width: 100%">
          <tr>
            <td id="fecha">No hay documentos disponibles.</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters } from "vuex";

export default {
  name: "documentosC",
  computed: {
    ...mapState(["persona"]),
  },
  data() {
    return {
      subtitulo: "Ejemplo de texto",
      idUsuario: this.$store.getters.sacarid,
      documentos: "",
      nodata: true,
      animales: "",
      animal2: "",
      eventos: "",
      evento2: "",
      expedientes: "",
      expediente2: "",
    };
  },
  methods: {
    ...mapGetters(["sacarid"]),

    buscarDocu () {
      alert("Cambia");
      axios
        .post("php/documentos.php", {
          usuario: this.idUsuario,
          animal: this.animal2,
          evento: this.evento2,
          expediente: this.expediente2,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.documentos = response.data;
            this.nodata = false;
          } else {
            this.seguimientos = "";
            this.nodata = true;
          }
        });
    },
    cargarDatos() {
      this.evento2 = "";
      this.eventos = "";
      this.expediente2 = 0;
      this.expedientes = "";
      this.animales = "";
      this.animal2 = 0;
      axios
        .post("php/expedientes.php", {
          query: this.idUsuario,
        })
        .then((response) => {
          this.expedientes = response.data;
        });
      axios
        .post("php/eventosAceptados.php", {
          usuario: this.idUsuario,
        })
        .then((response) => {
          this.eventos = response.data;
        });
      axios
        .post("php/animalesLista.php", {
          usuario: this.idUsuario,
        })
        .then((response) => {
          this.animales = response.data;
        });
    },
  },
  created: function () {
    this.buscarDocu();
    this.cargarDatos();
  },
};
</script>
<style scoped>
label {
  font-weight: 800;
  font-size: 16px;
  border-bottom: solid;
}
#docu {
  background: aliceblue;
  width: 80%;
  margin: auto;
  margin-top: 2%;
  border: solid;
  border-width: 1px;
  min-height: 90px;
}
#descrip {
  width: 80%;
  border-left: solid;
  border-width: 1px;
  font-size: 2.5vmin;
}
#fecha {
  font-size: 2.5vmin;
}
#cajaSeguimientoNuevo {
  height: 80%;
  width: 80%;
  margin: auto;
}
.input {
  margin-top: 1%;
}
</style>