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
          <table class="table table-bordered table-striped">
            <tr>
              <th>Temporadas</th>
              <th>Capitulos</th>
              <th>Nombre</th>
            </tr>
            <tr v-for="(seguimiento, index) in seguimientos" v-bind:key="index">
              <td>{{ seguimiento }}</td>
              <td>{{ seguimiento }}</td>
              <td>{{ seguimiento }}</td>
            </tr>
            <tr v-if="nodata">
              <td colspan="3" align="center">No Data Found</td>
            </tr>
          </table>
        </div>
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
            alert(response.data);
            this.seguimientos = response.data;
            this.nodata = false;
          } else {
            alert(response.data);
            this.seguimientos = "";
            this.nodata = true;
          }
        });
    },
  },
  created: function () {
    this.fetchData();
  },
};
</script>