<template>
  <div class="container" id="eventosC">
    <h1>Eventos</h1>
    <div class="panel panel-default" style="margin-top: 5%" v-if="length3 > 0">
      <div class="panel-body">
        <div class="table-responsive">
          <span for="fechaid">Mis eventos</span>
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed; margin-top: 15px"
          >
            <tr style="background: cadetblue">
              <th id="fechaid" class="text fecha">FECHA</th>
              <th class="text campo1">DESCRIPCIÓN</th>
            </tr>
            <tr
              v-for="(evento, index) in orderBy(eventos3, INICIO)"
              v-bind:key="index"
            >
              <td class="text fecha">{{ evento.INICIO }}</td>
              <td class="text campo1">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2">
                <button
                  class="btn btn-success"
                  @click="desApuntarse2(evento, index)"
                >
                  ABANDONAR
                </button>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="panel panel-default" style="margin-top: 5%">
      <div class="panel-body">
        <div class="table-responsive">
          <span for="fechaid2">DISPONIBLES</span>
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed; margin-top: 15px"
          >
            <tr style="background: cadetblue">
              <th id="fechaid2" class="text fecha">FECHA</th>
              <th class="text campo1">DESCRIPCIÓN</th>
            </tr>
            <tr
              v-for="(evento, index) in orderBy(eventos, INICIO)"
              v-bind:key="index"
            >
              <td class="text fecha">{{ evento.INICIO }}</td>
              <td class="text campo1">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2">
                <button
                  class="btn btn-success"
                  @click="apuntarse(evento, index)"
                >
                  APUNTARSE
                </button>
              </td>
            </tr>
            <tr v-if="length1 == 0">
              <td class="text" colspan="3" align="center">Sin eventos</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="panel panel-default" style="margin-top: 5%" v-if="length2 > 0">
      <div class="panel-body">
        <div class="table-responsive">
          <span for="fechaid3">SOLICITUDES</span>
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed; margin-top: 15px"
          >
            <tr style="background: cadetblue">
              <th id="fechaid3" class="text fecha">FECHA</th>
              <th class="text campo1">DESCRIPCIÓN</th>
            </tr>
            <tr
              v-for="(evento, index) in orderBy(eventos2, INICIO)"
              v-bind:key="index"
            >
              <td class="text fecha">{{ evento.INICIO }}</td>
              <td class="text campo1">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2">
                <button
                  class="btn btn-success"
                  @click="desApuntarse(evento, index)"
                >
                  CANCELAR
                </button>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <notifications group="foo" position="bottom right" />
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters, mapMutations } from "vuex";
import Vue2Filters from "vue2-filters";

export default {
  name: "eventosC",
  mixins: [Vue2Filters.mixin],
  computed: {
    ...mapState(["persona"]),
  },
  methods: {
    ...mapMutations(["modificarEvento"]),
    ...mapGetters(["sacarid"], ["eventosD"]),

    eventosDisponibles: function () {
      axios
        .post("php/eventosDisponibles.php", {
          usuario: this.idUsuario,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.eventos = "";
            this.eventos = response.data;
            this.length1 = response.data.length;
            this.$store.commit("modificarEvento", this.length1);
          } else {
            this.length1 = response.data.length;
            this.eventos = "";
          }
        });
    },
    eventosSolicitados: function () {
      axios
        .post("php/eventosSolicitados.php", {
          usuario: this.idUsuario,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.eventos2 = "";
            this.eventos2 = response.data;
            this.length2 = response.data.length;
          } else {
            this.length2 = response.data.length;
            this.eventos2 = "";
          }
        });
    },
    eventosAceptados: function () {
      axios
        .post("php/eventosAceptados.php", {
          usuario: this.idUsuario,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.eventos3 = "";
            this.eventos3 = response.data;
            this.length3 = response.data.length;
          } else {
            this.length3 = response.data.length;
            this.eventos3 = "";
          }
        });
    },
    apuntarse(evento, index) {
      axios
        .post("php/apuntarseEvento.php", {
          usuario: this.idUsuario,
          idEvento: evento.ID,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Solicitud enviada",
            text: response.data,
            type: "success",
          });
          if (this.length2 == 0) {
            this.eventos2 = this.eventoDefault;
            this.length2++;

            this.eventos2 = this.eventos2.concat(evento);
            this.eventos.splice(index, 1);
            this.length1--;
            this.eventos2.shift();
          } else {
            this.eventos2 = this.eventos2.concat(evento);
            this.eventos.splice(index, 1);
            this.length2++;
            this.length1--;
          }
        });
    },
    desApuntarse(evento, index) {
      axios
        .post("php/desApuntarseEvento.php", {
          usuario: this.idUsuario,
          idEvento: evento.ID,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Solicitud enviada",
            text: response.data,
            type: "success",
          });
          if (this.length1 == 0) {
            this.eventos = this.eventoDefault;
            this.length1++;
            this.eventos = this.eventos.concat(evento);
            this.eventos2.splice(index, 1);
            this.length2--;
            this.eventos.shift();
          } else {
            this.eventos = this.eventos.concat(evento);
            this.eventos2.splice(index, 1);
            this.length2--;
            this.length1++;
          }
        });
    },
    desApuntarse2(evento, index) {
      this.guardarAlerta(evento);
      axios
        .post("php/desApuntarseEvento.php", {
          usuario: this.idUsuario,
          idEvento: evento.ID,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Solicitud enviada",
            text: response.data,
            type: "success",
          });
          this.eventos = this.eventos.concat(evento);
          this.eventos3.splice(index, 1);
        });
    },
    guardarAlerta(evento) {
      axios
        .post("php/persona.php", {
          query: this.idUsuario,
        })
        .then((response) => {
          this.persona = response.data;
          var aux = new Date().toJSON().slice(0, 10).replace(/-/g, "-");
          var aux2 =
            this.persona +
            " se ha desapuntado del evento del " +
            evento.INICIO;
          var aux3 = ["9"];
          axios.post("php/crearAlerta.php", {
            actual: aux,
            fecha: aux,
            argumento: aux2,
            checkedNames: aux3,
          });
        });
    },
  },
  data() {
    return {
      subtitulo: "Ejemplo de texto",
      idUsuario: this.$store.getters.sacarid,
      persona: "",
      eventosCant: this.$store.getters.eventosD,
      eventoDefault: [
        {
          0: "",
          ID: "",
          1: "",
          CODIGO: "",
          2: "",
          DESCRIPCION: "",
          3: "",
          LOCALIZACION: "",
          4: "",
          INICIO: "",
          5: "",
          FINAL: "",
          6: "",
          TIPO: "",
          7: "",
          ESTADO: "",
          8: "",
          NOTAS: "",
          9: "",
          CAMPO1: "",
          10: "",
          CAMPO2: "",
          11: "",
          CAMPO3: "",
          12: "",
          ACTIVO: "",
        },
      ],
      eventos: "",
      length1: 0,
      eventos2: "",
      length2: 0,
      eventos3: "",
      length3: 0,
    };
  },
  created: function () {
    this.eventosDisponibles();
    this.eventosSolicitados();
    this.eventosAceptados();
  },
};
</script>
<style scoped>
span {
  font-size: 3vmin;
  border-bottom: solid;
  font-weight: 900;
  color: dimgray;
}
button {
  float: left;
  height: 7vmin;
  width: 14vmin;
  font-size: 2vmin;
  padding: 0;
}
.text {
  font-size: 2vmin;
}
.fecha {
  width: 12%;
}
.campo1 {
  width: 70%;
}
.campo2 {
  width: 15%;
  padding-left: 1%;
  border: none;
}
</style>