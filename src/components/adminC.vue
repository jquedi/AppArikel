<template>
  <div class="container" id="adminC">
    <h1>PANEL DE ADMINISTRADOR {{ this.admin }}</h1>

    <div class="nuevo panel panel-default" v-if="accion == 'nuevo'">
      <h2 class="titulo">Añadir nueva persona</h2>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <input
            class="form-control input"
            id="nif"
            type="text"
            v-model="nif"
            placeholder="NIF"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="nombre"
            type="text"
            v-model="nombre"
            placeholder="Nombre"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="apellido1"
            type="text"
            v-model="apellido1"
            placeholder="Primer apellido"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="apellido2"
            type="text"
            v-model="apellido2"
            placeholder="Segundo apellido"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="domicilio"
            type="text"
            v-model="domicilio"
            placeholder="Domicilio"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="email"
            type="text"
            v-model="email"
            placeholder="Email"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="telefono"
            type="phone"
            v-model="telefono"
            placeholder="Telefono"
          />
        </div>
        <div class="col-sm">
          <label for="organizacion">Organización</label>
          <select
            class="form-control input"
            id="organizacion"
            v-model="organizacion"
          >
            <option
              v-for="organizacion in organizaciones"
              v-bind:key="organizacion.PERSONAORGANIZACION"
            >
              {{ organizacion.PERSONAORGANIZACION }}
            </option>
          </select>
        </div>
        <div class="col-sm">
          <label for="tipo">Tipo</label>
          <select class="form-control input" id="tipo" v-model="tipo">
            <option v-for="tipo in tipos" v-bind:key="tipo.PERSONATIPO">
              {{ tipo.PERSONATIPO }}
            </option>
          </select>
        </div>
        <div class="col-sm">
          <label for="activo">Activo</label>
          <select class="form-control input" id="activo" v-model="activo">
            <option selected="selected">SI</option>
            <option>NO</option>
          </select>
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="notas"
            type="text"
            v-model="notas"
            placeholder="Notas"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="campo1"
            type="text"
            v-model="campo1"
            placeholder="Campo1"
          />
        </div>
        <h4 class="titulo">Permisos</h4>
        <div class="col-sm">
          <label for="admin">Admin</label>
          <select class="form-control input" id="admin" v-model="admin">
            <option selected="selected">SI</option>
            <option>NO</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="alertas">Alertas</label>
          <select class="form-control input" id="alertas" v-model="alertas">
            <option selected="selected">NINGUNO</option>
            <option>VER</option>
            <option>EDITAR</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="alertasV">Ver alertas</label>
          <select class="form-control input" id="alertasV" v-model="alertasV">
            <option selected="selected">PROPIO</option>
            <option>TODOS</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="eventos">Eventos</label>
          <select class="form-control input" id="eventos" v-model="eventos">
            <option selected="selected">NINGUNO</option>
            <option>VER</option>
            <option>EDITAR</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="documentos">Documentos</label>
          <select
            class="form-control input"
            id="documentos"
            v-model="documentos"
          >
            <option selected="selected">NINGUNO</option>
            <option>VER</option>
            <option>EDITAR</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="seguimientos">Seguimientos</label>
          <select
            class="form-control input"
            id="seguimientos"
            v-model="seguimientos"
          >
            <option selected="selected">PROPIO</option>
            <option>TODOS</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="facturas">Facturas</label>
          <select class="form-control input" id="facturas" v-model="facturas">
            <option selected="selected">NINGUNO</option>
            <option>VER</option>
            <option>EDITAR</option>
          </select>
        </div>
      </div>
      <div class="row">
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="guardarPersona()"
        >
          Guardar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters } from "vuex";

export default {
  name: "adminC",
  computed: {
    ...mapState(["persona"]),
  },
  data() {
    return {
      idUsuario: this.$store.getters.sacarid,
      permisos: this.$store.getters.permisoAdmin,
      accion: "nuevo",
      admin: "",
      alertas: "",
      alertasV: "",
      eventos: "",
      documentos: "",
      seguimientos: "",
      facturas: "",
      nif: "",
      nombre: "",
      apellido1: "",
      apellido2: "",
      domicilio: "",
      email: "",
      telefono: "",
      organizacion: "",
      organizaciones: "",
      tipo: "",
      tipos: "",
      activo: "",
      notas: "",
      campo1: "",
      persona: "",
    };
  },
  methods: {
    ...mapGetters(["sacarid"], ["permisoAdmin"]),

    organizacionesF() {
      axios.post("php/organizaciones.php", {}).then((response) => {
        this.organizaciones = response.data;
      });
    },
    tiposF() {
      axios.post("php/tiposPersonas.php", {}).then((response) => {
        this.tipos = response.data;
      });
    },
    guardarPersona() {
      axios
        .post("php/guardarPersona.php", {
          nif: this.nif,
          nombre: this.nombre,
          apellido1: this.apellido1,
          apellido2: this.apellido2,
          domicilio: this.domicilio,
          email: this.email,
          telefono: this.telefono,
          organizacion: this.organizacion,
          tipo: this.tipo,
          activo: this.activo,
          notas: this.notas,
          campo1: this.campo1,
        })
        .then((response) => {
          this.persona = response.data;
          this.guardarPermisos();
        });
    },
    guardarPermisos() {
      axios
        .post("php/guardarPermisos.php", {
          persona: this.persona,
          admin: this.admin,
          alertas: this.alertas,
          alertasV: this.alertasV,
          eventos: this.eventos,
          documentos: this.documentos,
          seguimientos: this.seguimientos,
          facturas: this.facturas,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
        });
    },
  },
  created: function () {
      this.organizacionesF();
      this.tiposF();
  },
};
</script>
<style scoped>
.nuevo {
  background: gainsboro;
  border: solid;
}
.titulo {
  margin-top: 10px;
  margin-bottom: 20px;
  text-decoration: underline;
}
#botonNuevo {
  margin: auto;
  margin-bottom: 3%;
  font-size: 4vmin;
}
</style>