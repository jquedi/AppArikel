<template>
  <div class="container" id="alertasC">
    <h1>ALERTAS</h1>
    <div v-for="(alerta, index) in alertas" v-bind:key="index">
      <div class="alerta">
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

export default {
  name: "alertasC",
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
            this.vacio = "no";
          } else {
            this.alertas = "";
            this.vacio = "si";
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
  },
  data() {
    return {
      subtitulo: "Ejemplo de texto",
      idUsuario: this.$store.getters.sacarid,
      alertas: "",
      vacio: "si",
    };
  },
  created: function () {
    this.alertasPendientes();
  },
};
</script>
<style scoped>
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
</style>