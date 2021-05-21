<template>
  <div class="container" id="seguimientosC" style="max-width: none">
    <h1>Facturas</h1>
    <div class="panel panel-default">
      <!-- Parte superior -->

      <div class="panel-heading">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-9">
                <button
                  id="botonNuevo"
                  class="btn btn-danger"
                  @click="
                    abrirSucesoNuevo('gasto'),
                      (trackedDate3 = new Date().toISOString().substr(0, 10))
                  "
                >
                  NUEVO GASTO
                </button>
                <button
                  id="botonNuevo"
                  class="btn btn-primary"
                  @click="
                    abrirSucesoNuevo('ingreso'),
                      (trackedDate3 = new Date().toISOString().substr(0, 10))
                  "
                >
                  NUEVO INGRESO
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-3" align="right">
            <select
              class="form-control input"
              id="ordenar"
              v-model="ordenarPor"
            >
              <option disabled selected>Ordenar por</option>
              <option value="PAGADO">NO Pagados Primero</option>
              <option value="">Fecha(Primero mayor)</option>
              <option value="FECHA">Fecha(Primero menor)</option>
              <option value="TIPO">Ingresos Primero</option>
              <option value="TIPO_GASTO">Tipo de Gasto</option>
              <option value="CLIENTE">Cliente</option>
              <option value="REVISADO">Revisado</option>
            </select>
            <button
              id="botonFiltro"
              class="btn btn-info"
              @click="abrirFiltro(), (trackedDate = ''), (trackedDate2 = '')"
            >
              Filtrar
            </button>
          </div>
        </div>
      </div>

      <!-- TABLA -->

      <div class="panel-body">
        <div class="table-responsive">
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed"
          >
            <tr class="row">
              <th class="text col-md-1">FECHA</th>
              <th class="text col-md-3">TIPO GASTO</th>
              <th class="text col-md-4">CLIENTE</th>
              <th class="text col-md-1">TIPO</th>
              <th class="text col-md-1">TOTAL</th>
              <th class="text col-md-1">PAGADO</th>
              <th class="text col-md-1">REVISADO</th>
            </tr>
            <tr
              class="row campo1"
              v-for="seguimiento in orderBy(seguimientos, this.ordenarPor)"
              v-bind:key="seguimiento.ID"
              @click="abrirSuceso(seguimiento), (editar = false)"
              :style="btnStyles(seguimiento.PAGADO)"
            >
              <td class="text col-md-1">{{ seguimiento.FECHA }}</td>
              <td class="text col-md-3">{{ seguimiento.TIPO_GASTO }}</td>
              <td class="text col-md-4">{{ seguimiento.CLIENTE }}</td>
              <td class="text col-md-1" v-if="seguimiento.TIPO == 1">
                INGRESO
              </td>
              <td class="text col-md-1" v-if="seguimiento.TIPO == 2">GASTO</td>
              <td class="text col-md-1">{{ seguimiento.LIQUIDO }}</td>
              <td class="text col-md-1">{{ seguimiento.PAGADO }}</td>
              <td class="text col-md-1">{{ seguimiento.REVISADO }}</td>
            </tr>
            <tr v-if="nodata" class="row">
              <td class="text col" colspan="3" align="center">
                No hay datos que cumplan los criterios
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <!-- info factura -->

    <div id="oculto" v-if="showSuceso">
      <div id="oculto2" @click="(showSuceso = false), (editar = false)"></div>
      <div class="row">
        <div class="col-sm-4" v-if="editar == false">
          <button class="btn btn-primary editar" @click="editar = true">
            Editar
          </button>
        </div>
        <div class="col-sm-4" v-if="editar == false">
          <button class="btn btn-primary editar" @click="duplicar()">
            Duplicar
          </button>
        </div>
        <div class="col-sm-4" v-if="editar == true">
          <button class="btn btn-primary editar" @click="guardar()">
            Guardar
          </button>
        </div>
        <div class="col-sm-4" v-if="revisado == 'NO'">
          <button class="btn btn-primary editar" @click="revisadoF()">
            Revisado
          </button>
        </div>
      </div>

      <div id="cajaSeguimiento" class="panel panel-default">
        <div class="row" v-if="editar">
          <div class="col-sm-6">
            <label for="plantillaBuc">Buscar Plantilla</label>
            <input
              class="form-control input"
              type="text"
              name=""
              id="plantillaBuc"
              v-model="query2"
              @keyup="cargarPlantillas()"
            />
          </div>
        </div>
        <div class="row" v-if="editar">
          <div class="col">
            <label for="Plantilla">Plantilla</label>
            <select
              id="Plantilla"
              class="form-control input"
              v-model="plantilla"
              @change="aplicarPlantilla()"
            >
              <option value=""></option>
              <option
                v-for="(plantilla, index) in plantillas"
                v-bind:key="index"
                v-bind:value="index"
              >
                {{ plantilla.NIF }} / {{ plantilla.CLIENTE }} /
                {{ plantilla.POBLACION }} / {{ plantilla.CAMPO1 }} /
                {{ plantilla.CAMPO2 }} / {{ plantilla.CAMPO3 }}
              </option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <label for="fecha">Fecha</label>

            <input
              v-if="!editar"
              class="form-control input"
              id="fecha"
              type="text"
              v-bind:value="fecha"
              placeholder=""
              readonly="true"
            />

            <datepicker
              v-if="editar"
              id="fecha2"
              class="input"
              wrapper-class="calendario"
              color="green lighten-1"
              header-color="primary"
              placeholder=""
              full-width="true"
              monday-first="true"
              bootstrap-styling="true"
              @input="formatPicker3()"
              v-model="trackedDate3"
            ></datepicker>
          </div>

          <div class="col-sm-6">
            <label for="tipoG2">Tipo de gasto</label>

            <select
              v-if="editar"
              name=""
              id="tipoG2"
              v-model="tipoG2"
              class="form-control input"
            >
              <option value="ARRENDAMIENTOS">ARRENDAMIENTOS</option>
              <option value="COMPRAS">COMPRAS</option>
              <option value="COMPRAS OTROS APROVISIONAMIENTOS">
                COMPRAS OTROS APROVISIONAMIENTOS
              </option>
              <option value="OTROS GASTOS">OTROS GASTOS</option>
              <option value="OTROS SERVICIOS">OTROS SERVICIOS</option>
              <option value="PRESTACION SERVICIOS">PRESTACION SERVICIOS</option>
              <option value="PROF. INDEPENDIENTES">PROF. INDEPENDIENTES</option>
              <option value="PROFESIONALES INDEPENDIENTES">
                PROFESIONALES INDEPENDIENTES
              </option>
              <option value="REPARACIONES">REPARACIONES</option>
              <option value="SALARIOS">SALARIOS</option>
              <option value="SEGURIDAD SOCIAL">SEGURIDAD SOCIAL</option>
              <option value="SUMINISTROS">SUMINISTROS</option>
              <option value="TRANSPORTES">TRANSPORTES</option>
              <option value="TRIBUTOS">TRIBUTOS</option>
            </select>

            <input
              v-if="!editar"
              class="form-control input"
              id="tipoG2"
              v-bind:value="tipoG2"
              type="text"
              placeholder=""
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col-sm-4">
            <label for="nif">NIF</label>
            <input
              class="form-control input"
              type="text"
              id="nif"
              v-bind:value="nif"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="nombre">Nombre</label>
            <input
              id="nombre"
              class="form-control input"
              type="text"
              v-bind:value="nombre"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="direccion">Dirección</label>
            <input
              id="direccion"
              class="form-control input"
              type="text"
              v-bind:value="direccion"
              placeholder=""
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col-sm-4">
            <label for="nif">NIF</label>
            <input
              class="form-control input"
              type="text"
              id="nif"
              v-model="nif"
              placeholder=""
            />
          </div>
          <div class="col-sm-4">
            <label for="nombre">Nombre</label>
            <input
              id="nombre"
              class="form-control input"
              type="text"
              v-model="nombre"
              placeholder=""
            />
          </div>
          <div class="col-sm-4">
            <label for="direccion">Dirección</label>
            <input
              id="direccion"
              class="form-control input"
              type="text"
              v-model="direccion"
              placeholder=""
            />
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col-sm-4">
            <label for="poblacion">Población</label>
            <input
              class="form-control input"
              type="text"
              id="poblacion"
              v-bind:value="poblacion"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="postal">Codigo postal</label>
            <input
              id="postal"
              class="form-control input"
              type="text"
              v-bind:value="postal"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="mail">Email</label>
            <input
              id="mail"
              class="form-control input"
              type="text"
              v-bind:value="mail"
              placeholder=""
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col-sm-4">
            <label for="poblacion">Población</label>
            <input
              class="form-control input"
              type="text"
              id="poblacion"
              v-model="poblacion"
              placeholder=""
            />
          </div>
          <div class="col-sm-4">
            <label for="postal">Codigo postal</label>
            <input
              id="postal"
              class="form-control input"
              type="text"
              v-model="postal"
              placeholder=""
            />
          </div>
          <div class="col-sm-4">
            <label for="mail">Email</label>
            <input
              id="mail"
              class="form-control input"
              type="text"
              v-model="mail"
              placeholder=""
            />
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col-sm-4">
            <label for="factura">Factura</label>
            <input
              class="form-control input"
              type="text"
              id="factura"
              v-bind:value="factura"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="base">Base</label>
            <input
              id="base"
              class="form-control input"
              type="number"
              step="0.01"
              v-bind:value="base"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="ivaPor">% IVA</label>
            <input
              id="ivaPor"
              class="form-control input"
              type="number"
              v-bind:value="ivaPor"
              placeholder=""
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col-sm-4">
            <label for="factura">Factura</label>
            <input
              class="form-control input"
              type="text"
              id="factura"
              v-model="factura"
              placeholder=""
            />
          </div>
          <div class="col-sm-4">
            <label for="base">Base</label>
            <input
              id="base"
              class="form-control input"
              type="number"
              step="0.01"
              v-model="base"
              placeholder=""
              @keyup="cambiarValores('base')"
            />
          </div>
          <div class="col-sm-4">
            <label for="ivaPor">% IVA</label>
            <input
              id="ivaPor"
              class="form-control input"
              type="number"
              v-model="ivaPor"
              placeholder=""
              @keyup="cambiarValores('ivaPor')"
            />
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col-sm-4">
            <label for="iva">IVA</label>
            <input
              class="form-control input"
              type="number"
              step="0.01"
              id="iva"
              v-bind:value="iva"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="retencionT">Tipo Retención</label>

            <input
              id="retencionT"
              class="form-control input"
              type="text"
              v-bind:value="retencionT"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="retencionPor">% Retención</label>
            <input
              id="retencionPor"
              class="form-control input"
              type="number"
              v-bind:value="retencionPor"
              placeholder=""
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col-sm-4">
            <label for="iva">IVA</label>
            <input
              class="form-control input"
              type="number"
              step="0.01"
              id="iva"
              v-model="iva"
              placeholder=""
              @keyup="cambiarValores('iva')"
            />
          </div>
          <div class="col-sm-4">
            <label for="retencionT">Tipo Retención</label>

            <select
              name=""
              id="retencionT"
              v-model="retencionT"
              class="form-control input"
              @change="cambiarValores('tipoRet')"
            >
              <option value=""></option>
              <option value="SALARIOS">SALARIOS</option>
              <option value="PROFESIONALES">PROFESIONALES</option>
              <option value="ARRENDAMIENTOS">ARRENDAMIENTOS</option>
              <option value="MODULOS">MODULOS</option>
            </select>
          </div>
          <div class="col-sm-4">
            <label for="retencionPor">% Retención</label>
            <input
              id="retencionPor"
              class="form-control input"
              type="number"
              v-model="retencionPor"
              placeholder=""
              @keyup="cambiarValores('retPor')"
            />
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col-sm-4">
            <label for="retencion">Retencion</label>
            <input
              class="form-control input"
              type="number"
              step="0.01"
              id="retencion"
              v-bind:value="retencion"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="liquido">IMPORTE</label>

            <input
              id="liquido"
              class="form-control input"
              type="number"
              step="0.01"
              v-bind:value="liquido"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-4">
            <label for="tipo">TIPO:</label>
            <span v-if="tipo == 1" style="color: blue">INGRESO</span>
            <span v-if="tipo == 2" style="color: red">GASTO</span>
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col-sm-4">
            <label for="retencion">Retencion</label>
            <input
              class="form-control input"
              type="number"
              step="0.01"
              id="retencion"
              v-model="retencion"
              placeholder=""
              @keyup="cambiarValores('ret')"
            />
          </div>
          <div class="col-sm-4">
            <label for="liquido">IMPORTE</label>
            <input
              class="form-control input"
              type="number"
              step="0.01"
              id="liquido"
              v-model="liquido"
              placeholder=""
              @keyup="cambiarValores('importe')"
            />
          </div>
          <div class="col-sm-4">
            <label for="tipo">TIPO:</label>
            <select name="" id="tipo" class="form-control input" v-model="tipo">
              <option value="1">INGRESO</option>
              <option value="2">GASTO</option>
            </select>
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col-sm-6">
            <label for="tributa">Tributa</label>
            <input
              class="form-control input"
              type="text"
              id="tributa"
              v-bind:value="tributa"
              placeholder=""
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
            <label for="pagado">Pagado</label>

            <input
              id="pagado"
              class="form-control input"
              type="text"
              v-bind:value="pagado"
              placeholder=""
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col-sm-6">
            <label for="tributa">Tributa</label>

            <select
              name=""
              id="tributa"
              class="form-control input"
              v-model="tributa"
            >
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="pagado">Pagado</label>

            <select
              name=""
              id="pagado"
              class="form-control input"
              v-model="pagado"
            >
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col">
            <label for="descripcion">Descripción</label>
            <textarea
              class="form-control input"
              name=""
              id="descripcion"
              cols="30"
              rows="10"
              v-bind:value="descripcion"
              readonly="true"
            ></textarea>
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col">
            <label for="descripcion">Descripción</label>
            <textarea
              class="form-control input"
              name=""
              id="descripcion"
              cols="30"
              rows="10"
              v-bind:value="descripcion"
            ></textarea>
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col">
            <button
              class="btn btn-primary"
              v-if="editar == true"
              @click="guardarPlantilla()"
            >
              Guardar Como plantilla
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- FILTRO -->

    <div id="ocultoNuevo" v-if="filtrar">
      <div id="oculto2Nuevo" @click="filtrar = false"></div>
      <button class="btn btn-primary editar" @click="cargarFiltro()">
        Filtrar
      </button>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha2">Fecha Inicio</label>
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
            <label for="fecha22">Fecha Fin</label>
            <datepicker
              id="fecha22"
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
          <div class="col-sm-6">
            <label for="tipo">TIPO</label>
            <select class="form-control input" id="tipo" v-model="tipo">
              <option value="1">INGRESOS</option>
              <option value="2">GASTOS</option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="tipo2">Tipo de gasto</label>
            <input
              type="text"
              class="form-control input"
              id="tipo2"
              v-model="tipo2"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="cliente">CLIENTE</label>
            <input
              type="text"
              class="form-control input"
              id="cliente"
              v-model="cliente"
            />
          </div>
          <div class="col-sm-3">
            <label for="pagado">PAGADO</label>
            <select class="form-control input" id="pagado" v-model="pagado">
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
          </div>
          <div class="col-sm-3">
            <label for="pagado">REVISADO</label>
            <select
              class="form-control input"
              id="pagado"
              v-model="revisadoFiltro"
            >
              <option value="SI">SI</option>
              <option value="NO">NO</option>
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
import { mapState, mapGetters } from "vuex";
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
    ...mapGetters({
      idUsuario: "sacarid",
      admin: "permisoAdmin",
    }),
  },
  data() {
    return {
      hoy: new Date().toISOString().substr(0, 10),
      trackedDate: new Date().toISOString().substr(0, 10),
      trackedDate3: new Date().toISOString().substr(0, 10),
      trackedDate2: new Date().toISOString().substr(0, 10),
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
      expediente: "Expediente",
      requerimiento: "Requerimiento",
      suceso: "Suceso",
      actuacion: "Actuación",
      campo1: "Campo1",
      estado: "PENDIENTE",
      estado2: "PENDIENTE",
      persona2: "",
      fecha2: "",
      fecha22: "",
      animal2: "",
      tipo2: "",
      expediente2: "",
      requerimiento2: "",
      suceso2: "Sin novedad",
      actuacion2: "",
      campo12: "",
      // idUsuario: this.sacarid,
      guia: "NO",
      tipos: "",
      expedientes: "",
      animalLista: "",
      animalLista3: "",
      animal3: "",
      editar: false,
      personaID: "",
      ordenarPor: "Ordenar por",
      filtrar: false,
      idNuevo: 0,

      cliente: "",

      tipoG2: "OTROS GASTOS",
      nif: "",
      nombre: "",
      direccion: "",
      poblacion: "",
      postal: "",
      mail: "",
      factura: "",
      base: "",
      ivaPor: 21,
      iva: "",
      retencionT: "",
      retencionPor: "",
      retencion: "",
      liquido: "",
      tipo: "",
      tributa: "",
      pagado: "NO",
      descripcion: "",
      idFactura: 0,
      revisado: "",
      revisadoFiltro: "",

      plantilla: "",
      plantillas: "",
      query2: "",
    };
  },
  methods: {
    btnStyles: function (estado) {
      if (estado == "SI")
        return {
          background: "rgb(186 226 255)",
        };
      if (estado == "NO")
        return {
          background: "rgb(255 186 199)",
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
    formatPicker3: function () {
      var self = this;
      var d = new Date(self.trackedDate3);
      self.fecha =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },
    formatPicker2: function () {
      var self = this;
      var d = new Date(self.trackedDate2);
      self.fecha22 =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },

    fetchData: function () {
      this.cargarPlantillas();
      axios.post("php/facturas.php", {}).then((response) => {
        if (response.data.length > 0) {
          this.seguimientos = response.data;
          this.nodata = false;
        } else {
          this.seguimientos = "";
          this.nodata = true;
        }
      });
    },

    cambiarValores(aux) {
      if (aux == "base") {
        this.iva = parseFloat(this.base) * (parseFloat(this.ivaPor) / 100);
        this.iva = this.iva.toFixed(2);
        this.liquido =
          parseFloat(this.iva) +
          parseFloat(this.base) -
          parseFloat(this.retencion);
        this.liquido = this.liquido.toFixed(2);
      }
      if (aux == "ivaPor") {
        this.iva = parseFloat(this.base) * (parseFloat(this.ivaPor) / 100);
        this.iva = this.iva.toFixed(2);
        this.liquido =
          parseFloat(this.iva) +
          parseFloat(this.base) -
          parseFloat(this.retencion);
        this.liquido = this.liquido.toFixed(2);
      }
      if (aux == "iva") {
        this.ivaPor = parseFloat(this.iva) / parseFloat(this.base) / 100;
        this.ivaPor = this.ivaPor.toFixed(2);
        this.liquido =
          parseFloat(this.iva) +
          parseFloat(this.base) -
          parseFloat(this.retencion);
        this.liquido = this.liquido.toFixed(2);
      }
      if (aux == "tipoRet") {
        if (this.retencionT == "") {
          this.retencionPor = 0;
        }
        if (this.retencionT == "SALARIOS") {
          this.retencionPor = 0;
        }
        if (this.retencionT == "ARRENDAMIENTOS") {
          this.retencionPor = 19;
        }
        if (this.retencionT == "PROFESIONALES") {
          this.retencionPor = 15;
        }
        if (this.retencionT == "MODULOS") {
          this.retencionPor = 1;
        }

        this.retencion =
          parseFloat(this.base) * (parseFloat(this.retencionPor) / 100);
        this.retencion = this.retencion.toFixed(2);
        this.liquido =
          parseFloat(this.iva) +
          parseFloat(this.base) -
          parseFloat(this.retencion);
        this.liquido = this.liquido.toFixed(2);
      }
      if (aux == "retPor") {
        this.retencion =
          parseFloat(this.base) * (parseFloat(this.retencionPor) / 100);
        this.retencion = this.retencion.toFixed(2);
        this.liquido =
          parseFloat(this.iva) +
          parseFloat(this.base) -
          parseFloat(this.retencion);
        this.liquido = this.liquido.toFixed(2);
      }
      if (aux == "ret") {
        this.retencionPor =
          parseFloat(this.retencion) / parseFloat(this.base) / 100;
        this.retencionPor = this.retencionPor.toFixed(2);
        this.liquido =
          parseFloat(this.iva) +
          parseFloat(this.base) -
          parseFloat(this.retencion);
        this.liquido = this.liquido.toFixed(2);
      }
      if (aux == "importe") {
        this.base =
          (100 * parseFloat(this.liquido)) /
          (100 - parseFloat(this.retencionPor) + parseFloat(this.ivaPor));
        this.base = this.base.toFixed(2);
        this.iva = parseFloat(this.base) * (parseFloat(this.ivaPor) / 100);
        this.iva = this.iva.toFixed(2);
        this.retencion =
          parseFloat(this.base) * (parseFloat(this.retencionPor) / 100);
        this.retencion = this.retencion.toFixed(2);
      }
    },

    abrirSucesoNuevo(aux) {
      this.cargarPlantillas();
      this.editar = true;
      this.showSuceso = true;

      if (aux == "gasto") {
        this.tipoG2 = "OTROS GASTOS";
        this.idFactura = 0;
        this.nif = "";
        this.nombre = "";
        this.direccion = "";
        this.poblacion = "";
        this.postal = "";
        this.mail = "";
        this.factura = "";
        this.base = 0;
        this.ivaPor = 21;
        this.iva = 0;
        this.retencionT = "";
        this.retencionPor = 0;
        this.retencion = 0;
        this.liquido = 0;
        this.tipo = 2;
        this.tributa = "";
        this.pagado = "SI";
        this.descripcion = "";
      }

      if (aux == "ingreso") {
        this.tipoG2 = "PRESTACION SERVICIOS";
        this.idFactura = 0;
        this.nif = "";
        this.nombre = "";
        this.direccion = "";
        this.poblacion = "";
        this.postal = "";
        this.mail = "";
        this.factura = "";
        this.base = 0;
        this.ivaPor = 21;
        this.iva = 0;
        this.retencionT = "";
        this.retencionPor = 0;
        this.retencion = 0;
        this.liquido = 0;
        this.tipo = 1;
        this.tributa = "";
        this.pagado = "NO";
        this.descripcion = "";

        axios
          .post("php/contarFacturasAño.php", {
            año: new Date().toISOString().substr(0, 4),
          })
          .then((response) => {
            this.factura = response.data;
          });
      }
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
      this.fecha22 = "";
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
        .post("php/facturas.php", {
          tipoG: this.tipo2,
          tipo: this.tipo,
          fecha: this.fecha2,
          fecha2: this.fecha22,
          cliente: this.cliente,
          pagado: this.pagado,
          revisado: this.revisadoFiltro,
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
          this.tipo = "";
          this.cliente = "";
          this.pagado = "";
          this.revisadoFiltro = "";
          this.tipos = "";
          this.fecha2 = "";
          this.fecha22 = "";
        });
    },
    abrirSuceso(value) {
      this.cargarPlantillas();
      this.tipoG2 = value.TIPO_GASTO;
      this.idFactura = value.ID;
      this.trackedDate3 = value.FECHA;
      this.fecha = value.FECHA;
      this.nif = value.NIF;
      this.nombre = value.CLIENTE;
      this.direccion = value.DIRECCION;
      this.poblacion = value.POBLACION;
      this.postal = value.POSTAL;
      this.mail = value.EMAIL;
      this.factura = value.FACTURA;
      this.base = value.BASE;
      this.ivaPor = value.IVA_POR;
      this.iva = value.IVA;
      this.retencionT = value.TIPO_RETENCION;
      this.retencionPor = value.RETENCION_POR;
      this.retencion = value.RETENCION;
      this.liquido = value.LIQUIDO;
      this.tipo = value.TIPO;
      this.tributa = value.TRIBUTA;
      this.pagado = value.PAGADO;
      this.descripcion = value.DESCRIPCION;
      this.revisado = value.REVISADO;

      this.showSuceso = true;
      this.formatPicker3();
    },

    revisadoF() {
      axios
        .post("php/revisarFactura.php", {
          id: this.idFactura,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Exito",
            text: response.data,
            type: "success",
          });
          this.showSuceso = false;
          this.fetchData();
        });
    },

    cargarPlantillas() {
      this.plantilla = "";

      axios
        .post("php/proveedores.php", {
          query2: this.query2,
        })
        .then((response) => {
          this.plantillas = response.data;
        });
    },

    aplicarPlantilla() {
      this.tipoG2 = this.plantillas[this.plantilla][8];
      this.nif = this.plantillas[this.plantilla][1];
      this.nombre = this.plantillas[this.plantilla][2];
      this.direccion = this.plantillas[this.plantilla][3];
      this.poblacion = this.plantillas[this.plantilla][4];
      this.postal = this.plantillas[this.plantilla][5];
      this.mail = this.plantillas[this.plantilla][6];
    },

    guardarPlantilla() {
      axios
        .post("php/guardarProveedor.php", {
          id: 0,
          tipoG2: this.tipoG2,
          nif: this.nif,
          nombre: this.nombre,
          direccion: this.direccion,
          poblacion: this.poblacion,
          postal: this.postal,
          mail: this.mail,
          tipo: this.tipo,
          campo1: "",
          campo2: "",
          campo3: "",
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Exito",
            text: response.data,
            type: "success",
          });
        });
    },
    duplicar() {
      this.editar = true;
      this.idFactura = 0;

      axios
        .post("php/contarFacturasAño.php", {
          año: new Date().toISOString().substr(0, 4),
        })
        .then((response) => {
          this.factura = response.data;
        });

      this.trackedDate3 = new Date().toISOString().substr(0, 10);
      this.formatPicker3();
    },

    guardar() {
      this.formatPicker3();

      axios
        .post("php/guardarFactura.php", {
          inserccion: this.hoy,
          tipoG2: this.tipoG2,
          id: this.idFactura,
          fecha: this.fecha,
          nif: this.nif,
          nombre: this.nombre,
          direccion: this.direccion,
          poblacion: this.poblacion,
          postal: this.postal,
          mail: this.mail,
          factura: this.factura,
          base: this.base,
          ivaPor: this.ivaPor,
          iva: this.iva,
          retencionT: this.retencionT,
          retencionPor: this.retencionPor,
          retencion: this.retencion,
          liquido: this.liquido,
          tipo: this.tipo,
          tributa: this.tributa,
          pagado: this.pagado,
          descripcion: this.descripcion,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Exito",
            text: response.data,
            type: "success",
          });
          this.showSuceso = false;
          this.editar = false;
          this.showSucesoNuevo = false;
          this.fetchData();
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
  z-index: 20;
  position: relative;
  top: 2%;
  right: -33%;
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
  font-size: 20px;
}
.fecha {
  width: 7%;
}
.campo1 {
  border-color: black;
  border: solid;
  border-width: 1px;
}
.campo2 {
  width: 36%;
}
.campo3 {
  width: 7%;
}
.campo4 {
  width: 7%;
}
.campo5 {
  width: 7%;
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