<template>
  <div class="container" id="eventosC">
    <h1>Eventos</h1>
    <button
      v-if="eventosPermisos == 'EDITAR'"
      class="button btn btn-success"
      @click="(crear = true), cargarTipos()"
    >
      CREAR
    </button>
    <select
      name=""
      id=""
      v-model="opcionTotal"
      v-if="eventosPermisos == 'EDITAR'"
    >
      <option value="propios">Mis eventos</option>
      <option value="todos">Ver todos</option>
    </select>

    <!-- todos los eventos -->

    <div
      class="panel panel-default"
      style="margin-top: 5%"
      v-if="lengthActivos > 0 && opcionTotal == 'todos'"
    >
      <div class="panel-body">
        <div class="table-responsive">
          <span for="fechaid">ACTIVOS</span>
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed; margin-top: 15px"
          >
            <tr style="background: cadetblue">
              <th id="fechaid" class="text fecha">FECHA</th>
              <th class="text campo1">DESCRIPCIÓN</th>
            </tr>
            <tr
              v-for="(evento, index) in orderBy(eventosActivos, INICIO)"
              v-bind:key="index"
            >
              <td class="text fecha">{{ evento.INICIO }}</td>
              <td class="text campo1" @click="abrirInfo(evento)">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2"></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div
      class="panel panel-default"
      style="margin-top: 5%"
      v-if="lengthNoActivos > 0 && opcionTotal == 'todos'"
    >
      <div class="panel-body">
        <div class="table-responsive">
          <span for="fechaid">INACTIVOS</span>
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed; margin-top: 15px"
          >
            <tr style="background: cadetblue">
              <th id="fechaid" class="text fecha">FECHA</th>
              <th class="text campo1">DESCRIPCIÓN</th>
            </tr>
            <tr
              v-for="(evento, index) in orderBy(eventosNoActivos, INICIO)"
              v-bind:key="index"
            >
              <td class="text fecha">{{ evento.INICIO }}</td>
              <td class="text campo1" @click="abrirInfo(evento)">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2"></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <!-- CREAR EVENTO -->

    <div id="ocultoNuevo" v-if="crear && eventosPermisos == 'EDITAR'">
      <div id="oculto2Nuevo" @click="crear = false"></div>
      <button class="btn btn-primary boton2" @click="guardar(false)">
        CREAR
      </button>
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
            <label for="fecha2">Fecha Fin</label>
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
            <textarea
              class="form-control input"
              name
              id
              cols="30"
              rows="10"
              placeholder="Descripción"
              v-model="descripcionC"
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
              placeholder="Localización"
              v-model="localizacionC"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label for="expediente2">TIPO</label>
            <select class="form-control input" id="expediente2" v-model="tipoC">
              <option v-for="tipo in tipos" v-bind:key="tipo.ID">
                {{ tipo.EVENTOTIPO }}
              </option>
            </select>
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
              placeholder="Horario"
              v-model="notasC"
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
              v-model="campo1C"
            ></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <select class="form-control input" v-model="estadoC">
              <option value="ABIERTA INSCRIPCIÓN">ABIERTA INSCRIPCIÓN</option>
              <option value="ANULADO">ANULADO</option>
              <option value="CELEBRANDOSE">CELEBRANDOSE</option>
              <option value="CERRADA INSCRIPCIÓN">CERRADA INSCRIPCIÓN</option>
              <option value="FINALIZADO">FINALIZADO</option>
              <option value="PLANIFICADO">PLANIFICADO</option>
            </select>
          </div>
          <div class="col">
            <label for="Activo">Activo</label>
            <select if="Activo" class="form-control input" v-model="activoC">
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Mis eventos -->

    <div
      class="panel panel-default"
      style="margin-top: 5%"
      v-if="length3 > 0 && opcionTotal == 'propios'"
    >
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
              <td class="text campo1" @click="abrirInfo(evento)">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2">
                <button
                  class="button btn btn-success"
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
    <div
      class="panel panel-default"
      style="margin-top: 5%"
      v-if="opcionTotal == 'propios'"
    >
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
              <td class="text campo1" @click="abrirInfo(evento)">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2">
                <button
                  class="button btn btn-success"
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
    <div
      class="panel panel-default"
      style="margin-top: 5%"
      v-if="length2 > 0 && opcionTotal == 'propios'"
    >
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
              <td class="text campo1" @click="abrirInfo(evento)">
                {{ evento.DESCRIPCION + "(" + evento.NOTAS + ")" }}
              </td>
              <td class="text campo2">
                <button
                  class="button btn btn-success"
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

    <!-- info DIV -->

    <div class="formularioNueva panel panel-default" v-if="info">
      <select
        @change="solicitudes()"
        v-if="eventosPermisos == 'EDITAR'"
        name=""
        id=""
        v-model="opcion"
      >
        <option value="info">Información</option>
        <option value="SOLICITADO">Solicitudes</option>
        <option value="ADMITIDO">Admitidos</option>
        <option value="EDITAR">Editar</option>
      </select>

      <button
        id="cerrarF"
        class="btn btn-warning"
        @click="(info = false), (opcion = 'info')"
      >
        X
      </button>

      <h1 v-if="opcion == 'info'">INFORMACIÓN</h1>
      <h1 v-if="opcion == 'SOLICITADO'">SOLICITUDES</h1>
      <h1 v-if="opcion == 'ADMITIDO'">ADMITIDOS</h1>
      <h1 v-if="opcion == 'EDITAR'">EDITAR</h1>

      <!-- INFO -->

      <div v-if="opcion == 'info'">
        <div
          id="cajaSeguimientoNuevo"
          class="panel panel-default"
          style="position: initial"
        >
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
                @input="formatPicker11()"
                v-model="trackedDate"
                disabled="true"
              ></datepicker>
            </div>
            <div class="col-sm-6">
              <label for="fecha2">Fecha Fin</label>
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
                @input="formatPicker22()"
                v-model="trackedDate2"
                disabled="true"
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
                readonly="true"
              ></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="localizacion">Localización</label>
              <textarea
                class="form-control input"
                name
                id="localizacion"
                cols="30"
                rows="10"
                placeholder="Localización"
                v-model="localizacion"
                readonly="true"
              ></textarea>
            </div>
            <div class="col-md-6">
              <label for="expediente2">TIPO</label>
              <select
                class="form-control input"
                id="expediente2"
                v-model="tipo"
                disabled="true"
              >
                <option v-for="tipo in tipos" v-bind:key="tipo.ID">
                  {{ tipo.EVENTOTIPO }}
                </option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="notas">Horario</label>
              <textarea
                class="form-control input"
                name
                id="notas"
                cols="30"
                rows="10"
                placeholder="Horario"
                v-model="notas"
                readonly="true"
              ></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <select
                class="form-control input"
                v-model="estado"
                disabled="true"
              >
                <option value="ABIERTA INSCRIPCIÓN">ABIERTA INSCRIPCIÓN</option>
                <option value="ANULADO">ANULADO</option>
                <option value="CELEBRANDOSE">CELEBRANDOSE</option>
                <option value="CERRADA INSCRIPCIÓN">CERRADA INSCRIPCIÓN</option>
                <option value="FINALIZADO">FINALIZADO</option>
                <option value="PLANIFICADO">PLANIFICADO</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- SOLICITUDES -->

      <div v-if="opcion == 'SOLICITADO'">
        <div
          class="row"
          v-for="(persona, index) in personas"
          v-bind:key="index"
        >
          <div class="col" style="text-align: initial">
            <label class="labelNombre text"
              >{{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
              {{ persona.APELLIDO2 }}</label
            >
            <button
              class="btn btn-success"
              @click="admitirPersona(persona, 'ADMITIDO')"
            >
              Admitir
            </button>
          </div>
        </div>
      </div>

      <!-- ADMITIDOS -->

      <div v-if="opcion == 'ADMITIDO'">
        <div
          class="row"
          v-for="(persona, index) in personas"
          v-bind:key="index"
        >
          <div class="col" style="text-align: initial">
            <label class="labelNombre text"
              >{{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
              {{ persona.APELLIDO2 }}</label
            >
            <button
              class="btn btn-success"
              @click="admitirPersona(persona, 'EXCLUIDO')"
            >
              Excluir
            </button>
          </div>
        </div>
      </div>

      <!-- EDITAR -->

      <div v-if="opcion == 'EDITAR'">
        <button
          class="btn btn-primary boton22"
          @click="guardar(true), (info = 'false'), (opcion = 'info')"
        >
          CREAR
        </button>
        <div
          id="cajaSeguimientoNuevo"
          class="panel panel-default"
          style="position: initial"
        >
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
                @input="formatPicker11()"
                v-model="trackedDate"
              ></datepicker>
            </div>
            <div class="col-sm-6">
              <label for="fecha2">Fecha Fin</label>
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
                @input="formatPicker22()"
                v-model="trackedDate2"
              ></datepicker>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="Descripción">Descripción</label>
              <textarea
                class="form-control input"
                name
                id="Descripción"
                cols="30"
                rows="10"
                placeholder="Descripción"
                v-model="descripcion"
              ></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Localización">Localización</label>
              <textarea
                class="form-control input"
                name
                id="Localización"
                cols="30"
                rows="10"
                placeholder="Localización"
                v-model="localizacion"
              ></textarea>
            </div>
            <div class="col-md-6">
              <label for="expediente2">TIPO</label>
              <select
                class="form-control input"
                id="expediente2"
                v-model="tipo"
              >
                <option v-for="tipo in tipos" v-bind:key="tipo.ID">
                  {{ tipo.EVENTOTIPO }}
                </option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Horario">Horario</label>
              <textarea
                class="form-control input"
                name
                id="Horario"
                cols="30"
                rows="10"
                placeholder="Horario"
                v-model="notas"
              ></textarea>
            </div>
            <div class="col-md-6">
              <label for="Campo1">Campo1</label>
              <textarea
                class="form-control input"
                name
                id="Campo1"
                cols="30"
                rows="10"
                placeholder="Campo1"
                v-model="campo1"
              ></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <select class="form-control input" v-model="estado">
                <option value="ABIERTA INSCRIPCIÓN">ABIERTA INSCRIPCIÓN</option>
                <option value="ANULADO">ANULADO</option>
                <option value="CELEBRANDOSE">CELEBRANDOSE</option>
                <option value="CERRADA INSCRIPCIÓN">CERRADA INSCRIPCIÓN</option>
                <option value="FINALIZADO">FINALIZADO</option>
                <option value="PLANIFICADO">PLANIFICADO</option>
              </select>
            </div>
            <div class="col">
              <label for="Activo">Activo</label>
              <select id="Activo" class="form-control input" v-model="activo">
                <option value="SI">SI</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <button
        v-if="eventosPermisos == 'EDITAR'"
        id="crearF"
        class="btn btn-success"
        @click="borrarEvento(), (opcion = 'info')"
      >
        DESACTIVAR
      </button>
    </div>

    <notifications group="foo" position="bottom right" />
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters, mapMutations } from "vuex";
import Vue2Filters from "vue2-filters";
import Datepicker from "vuejs-datepicker";

export default {
  name: "eventosC",
  mixins: [Vue2Filters.mixin],
  components: {
    Datepicker,
  },
  computed: {
    ...mapState(["persona"]),
    ...mapGetters({
      idUsuario: 'sacarid',
      eventosCant: 'eventosD',
      eventosPermisos: 'permisoEventosP',
    }),
  },
  methods: {
    ...mapMutations(["modificarEvento"]),

    

    abrirInfo(evento) {
      this.info = true;
      this.idEvento = evento.ID;
      this.descripcion = evento.DESCRIPCION;
      this.localizacion = evento.LOCALIZACION;
      this.fecha1 = evento.INICIO;
      this.fecha2 = evento.FINAL;
      this.tipo = evento.TIPO;
      this.estado = evento.ESTADO;
      this.notas = evento.NOTAS;
      this.campo1 = evento.CAMPO1;
      this.activo = evento.ACTIVO;

      this.trackedDate = evento.INICIO;
      this.trackedDate2 = evento.FINAL;
      this.solicitudes();
      this.cargarTipos();
    },
    admitirPersona(persona, estado) {
      axios
        .post("php/personasEventosAñadir.php", {
          idPersona: persona.ID,
          idEvento: this.idEvento,
          estado: estado,
        })
        .then((response) => {
          if (response.data == "OK") {
            this.solicitudes();
            this.eventosDisponibles();
            this.eventosSolicitados();
            this.eventosAceptados();
          }
        });
    },
    solicitudes() {
      axios
        .post("php/personasEventos.php", {
          estado: this.opcion,
          idEvento: this.idEvento,
        })
        .then((response) => {
          this.personas = response.data;
          this.cargarTipos();
        });
    },
    borrarEvento() {
      axios
        .post("php/borrarEvento.php", {
          idEvento: this.idEvento,
        })
        .then((response) => {
          if (response.data == "OK") {
            this.eventosDisponibles();
            this.eventosSolicitados();
            this.eventosAceptados();
            this.eventosNoActivosF();
            this.eventosActivosF();
            this.info = false;
          }
        });
    },
    formatPicker: function () {
      var self = this;
      var d = new Date(self.trackedDate);
      self.fecha1C =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },
    formatPicker2: function () {
      var self = this;
      var d = new Date(self.trackedDate2);
      self.fecha2C =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },
    formatPicker11: function () {
      var self = this;
      var d = new Date(self.trackedDate);
      self.fecha1 =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },
    formatPicker22: function () {
      var self = this;
      var d = new Date(self.trackedDate2);
      self.fecha2 =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },
    guardar(aux) {
      if (aux) {
        var idEvento2 = this.idEvento;
        var activo = this.activo;
        var estado = this.estado;
        var campo1 = this.campo1;
        var notas = this.notas;
        var tipo = this.tipo;
        var localizacion = this.localizacion;
        var descripcion = this.descripcion;
        var fecha1 = this.fecha1;
        var fecha2 = this.fecha2;
      } else {
        idEvento2 = "";
        activo = this.activoC;
        estado = this.estadoC;
        campo1 = this.campo1C;
        notas = this.notasC;
        tipo = this.tipoC;
        localizacion = this.localizacionC;
        descripcion = this.descripcionC;
        fecha1 = this.fecha1C;
        fecha2 = this.fecha2C;
      }
      axios
        .post("php/eventoGuardar.php", {
          idEvento: idEvento2,
          activo: activo,
          estado: estado,
          campo1: campo1,
          notas: notas,
          tipo: tipo,
          localizacion: localizacion,
          descripcion: descripcion,
          fecha1: fecha1,
          fecha2: fecha2,
        })
        .then((response) => {
          if (response.data == "OK") {
            this.crear = false;
            this.eventosDisponibles();
            this.eventosSolicitados();
            this.eventosAceptados();
            this.eventosNoActivosF();
            this.eventosActivosF();
          }
        });
    },
    cargarTipos() {
      axios.post("php/tiposEventos.php", {}).then((response) => {
        this.tipos = response.data;
      });
    },

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
    eventosActivosF: function () {
      axios.post("php/eventosActivos.php", {}).then((response) => {
        if (response.data.length > 0) {
          this.eventosActivos = "";
          this.eventosActivos = response.data;
          this.lengthActivos = response.data.length;
        } else {
          this.lengthActivos = response.data.length;
          this.eventosActivos = "";
        }
      });
    },
    eventosNoActivosF: function () {
      axios.post("php/eventosNoActivos.php", {}).then((response) => {
        if (response.data.length > 0) {
          this.eventosNoActivos = "";
          this.eventosNoActivos = response.data;
          this.lengthNoActivos = response.data.length;
        } else {
          this.lengthNoActivos = response.data.length;
          this.eventosNoActivos = "";
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
            this.persona + " se ha desapuntado del evento del " + evento.INICIO;
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
      // idUsuario: this.$store.getters.sacarid,
      persona: "",
      // eventosCant: this.$store.getters.eventosD,
      // eventosPermisos: "VER" /*this.$store.getters.permisoEventosP,*/,
      opcion: "info",
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
      info: false,
      descripcion: "",
      localizacion: "",
      fecha1: "",
      fecha2: "",
      tipo: "",
      estado: "",
      notas: "",
      campo1: "",
      personas: "",
      checkedNames: "",
      idEvento: "",
      crear: false,
      activoC: "SI",
      activo: "",
      estadoC: "ABIERTA INSCRIPCIÓN",
      campo1C: "",
      notasC: "",
      tipoC: "",
      localizacionC: "",
      descripcionC: "",
      fecha1C: "",
      fecha2C: "",
      tipos: "",
      trackedDate: new Date().toISOString().substr(0, 10),
      trackedDate2: new Date().toISOString().substr(0, 10),
      opcionTotal: "propios",
      eventosActivos: "",
      lengthActivos: 0,
      eventosNoActivos: "",
      lengthNoActivos: 0,
    };
  },
  created: function () {
    this.eventosDisponibles();
    this.eventosSolicitados();
    this.eventosAceptados();
    this.eventosActivosF();
    this.eventosNoActivosF();
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
.button {
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

.marginBottom {
  margin-bottom: 3%;
}
.labelNombre {
  font-size: 3vmin;
  display: inline;
  margin-left: 5%;
}
#crearF {
  position: absolute;
  right: 5%;
  z-index: 5000;
  margin-top: 30px;
  font-size: 4vmin;
}
#cerrarF {
  position: absolute;
  top: 1%;
  right: 5%;
  z-index: 5000;
}
.formularioNueva {
  height: 100%;
  width: 100%;
  background: white;
  z-index: 5000;
  position: fixed;
  top: 0;
  left: 0;
  overflow: scroll;
  padding-left: 5%;
  padding-right: 5%;
  padding-top: 5%;
}

.campo {
  border: solid;
  border-width: 1px;
  border-color: #005198;
  width: fit-content;
  margin: auto;
  margin-bottom: 2%;
}
.titulo {
  font-weight: 600;
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
.boton2 {
  position: fixed;
  z-index: 5000;
  top: 2%;
  right: 5%;
}
.boton22 {
  z-index: 5000;
  float: right;
}
</style>