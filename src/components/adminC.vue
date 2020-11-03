<template>
  <div class="container" id="adminC">
    <h1>PANEL DE ADMINISTRADOR</h1>
    <select class="form-control input" id="accion" v-model="accion">
      <option value="personaN" selected="selected">Editar Persona</option>
      <option value="animalN">Editar Animal</option>
      <option value="varios">Varios</option>
      <option></option>
    </select>

    <div class="nuevo panel panel-default" v-if="accion == 'personaN'">
      <button class="botonarriba btn btn-success" @click="cambioF('personaE')">
        Editar Persona
      </button>
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>

      <h4 class="titulo">Permisos</h4>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="alertasV">Ver alertas</label>
          <select class="form-control input" id="alertasV" v-model="alertasV">
            <option selected="selected">PROPIOS</option>
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
            <option selected="selected">PROPIOS</option>
            <option>TODOS</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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

    <div class="nuevo panel panel-default" v-if="accion == 'varios'">
      <h2 class="titulo">Varios</h2>

      <div
        class="row"
        style="
          margin-bottom: 20px;
          margin-left: 10px;
          margin-right: 10px;
          border: solid;
          border-width: 1px;
        "
      >
        <div class="col-sm">
          <label for="vario11">Argumento</label>
          <input
            class="form-control input"
            id="vario11"
            type="text"
            v-model="query2"
            placeholder="Nuevo"
          />

          <label for="guiaT" v-if="tabla == 'SEGUIMIENTOTIPO'"
            >Acceso a guias</label
          >
          <select
            v-if="tabla == 'SEGUIMIENTOTIPO'"
            class="form-control input"
            id="guiaT"
            v-model="guiaT"
          >
            <option value="SI">SI</option>
            <option value="NO">NO</option>
          </select>

          <label for="tabla">Tipo</label>
          <select class="form-control input" id="tabla" v-model="tabla">
            <option value="PERSONATIPO">Personas tipo</option>
            <option value="PERSONAORGANIZACION">Organizaciones personas</option>
            <option value="EXPEDIENTETIPO">Nuevo tipo expediente</option>
            <option value="EXPEDIENTEPERSONATIPO">
              Nuevo tipo persona en expedientes
            </option>
            <option value="DOCUMENTOSTIPO">Nuevo tipo de documento</option>
            <option value="SEGUIMIENTOTIPO">Tipo seguimientos</option>
            <option value="CUIDADOTIPO">Nuevo tipo cuidado animal</option>
            <option value="ANIMALUBICACION">Nueva ubicación animal</option>
            <option value="ANIMALTIPO">Nuevo tipo animal</option>
            <option value="ANIMALRAZA">Nueva raza animal</option>
            <option value="ANIMALESTADO">Nuevo estado animal</option>
          </select>
          <button
            v-if="tabla != 'SEGUIMIENTOTIPO'"
            class="btn btn-success"
            @click="guardarTipo()"
          >
            Guardar
          </button>
          <button
            v-if="tabla == 'SEGUIMIENTOTIPO'"
            class="btn btn-success"
            @click="guardarTipo2()"
          >
            Guardar
          </button>
        </div>
      </div>
    </div>

    <div class="nuevo panel panel-default" v-if="accion == 'personaE'">
      <button class="botonarriba btn btn-success" @click="cambioF('personaN')">
        Editar Persona
      </button>
      <h2 class="titulo">Crear Persona</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <input
            class="form-control input"
            id="buscar"
            type="text"
            v-model="query"
            @keyup="personasF()"
            placeholder="Buscar"
          />
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="persona">Persona</label>

          <select
            class="form-control input"
            id="tipo"
            v-model="persona"
            @change="buscarP()"
          >
            <option
              v-for="persona in personas"
              v-bind:key="persona.ID"
              v-bind:value="persona.ID"
            >
              {{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
              {{ persona.APELLIDO2 }}
            </option>
          </select>
        </div>
      </div>

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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>

      <h4 class="titulo">Permisos</h4>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="alertasV">Ver alertas</label>
          <select class="form-control input" id="alertasV" v-model="alertasV">
            <option selected="selected">PROPIOS</option>
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
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
            <option selected="selected">PROPIOS</option>
            <option>TODOS</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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
      accion: "personaN",
      admin: "NO",
      alertas: "VER",
      alertasV: "PROPIOS",
      eventos: "VER",
      documentos: "VER",
      seguimientos: "PROPIOS",
      facturas: "NINGUNO",
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
      personas: "",
      query: "",
      query2: "",
      tabla: "PERSONATIPO",
      guiaT: "NO",
    };
  },
  methods: {
    ...mapGetters(["sacarid"], ["permisoAdmin"]),

    cambioF(aux) {
      this.accion = aux;
    },

    guardarTipo() {
      axios
        .post("php/guardarTipoTabla.php", {
          query: this.query2,
          tabla: this.tabla,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
        });
    },
    guardarTipo2() {
      axios
        .post("php/guardarTipoTabla2.php", {
          query: this.query2,
          tabla: this.tabla,
          guia: this.guiaT,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
        });
    },

    buscarP() {
      axios
        .post("php/permisosPropios.php", {
          query: this.persona,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.admin = response.data[0][1];
            this.alertas = response.data[0][2];
            this.alertasV = response.data[0][3];
            this.eventos = response.data[0][4];
            this.documentos = response.data[0][5];
            this.seguimientos = response.data[0][6];
            this.facturas = response.data[0][7];

            axios
              .post("php/personaFull.php", {
                query: this.persona,
              })
              .then((response) => {
                if (response.data.length > 0) {
                  this.nif = response.data[0][1];
                  this.nombre = response.data[0][2];
                  this.apellido1 = response.data[0][3];
                  this.apellido2 = response.data[0][4];
                  this.domicilio = response.data[0][5];
                  this.email = response.data[0][6];
                  this.telefono = response.data[0][7];
                  this.organizacion = response.data[0][8];
                  this.tipo = response.data[0][9];
                  this.activo = response.data[0][15];
                  this.notas = response.data[0][11];
                  this.campo1 = response.data[0][12];
                }
              });
          } else {
            this.admin = "NO";
            this.alertas = "VER";
            this.alertasV = "PROPIOS";
            this.eventos = "VER";
            this.documentos = "VER";
            this.seguimientos = "PROPIOS";
            this.facturas = "NINGUNO";
          }
        });
    },

    personasF() {
      axios
        .post("php/listaPersonas.php", {
          query: this.query,
        })
        .then((response) => {
          this.personas = response.data;
        });
    },
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
          id: this.persona,
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
          this.persona = "";
          this.nif = "";
          this.nombre = "";
          this.apellido1 = "";
          this.apellido2 = "";
          this.domicilio = "";
          this.email = "";
          this.telefono = "";
          this.organizacion = "";
          this.tipo = "";
          this.activo = "";
          this.notas = "";
          this.campo1 = "";
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
    this.personasF();
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
.botonarriba {
  float: right;
}
</style>