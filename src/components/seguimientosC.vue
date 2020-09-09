<template>
  <div class="container" id="seguimientosC">
    <h1>Seguimeitnos</h1>
    <h2>{{subtitulo}}</h2>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-9">
            <h3 class="panel-title">Sample Data</h3>
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
              v-for="(seguimiento, index) in seguimientos"
              v-bind:key="index"
              @click="abrirSuceso"
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
      <div id="oculto2" @click="abrirSuceso">

      </div>
      <div id="cajaSeguimiento">

      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "seguimientosC",
  data() {
    return {
      subtitulo: "Ejemplo de texto",
      seguimientos: "",
      query: "",
      nodata: false,
      showSuceso: false,
    };
  },
  methods: {
    fetchData: function () {
      axios
        .post("http://app.arikelk9.es/seguimientos.php", {
          query: this.query,
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
    abrirSuceso() {
      this.showSuceso = !this.showSuceso;
    },
  },
  created: function () {
    this.fetchData();
  },
};
</script>

<style scoped>
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
#cajaSeguimiento{
  height: 80%;
  width: 80%;
  margin: auto;
  background-color: white;
  top: 10%;
  position: fixed;
  left: 10%;
  z-index: 10;
}
#oculto2{
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
}
</style>