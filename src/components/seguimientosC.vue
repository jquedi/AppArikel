<template>
  <div class="container" id="seguimientosC">
    <h1>Seguimientos</h1>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-9">
                <button
                  id="botonNuevo"
                  v-if="verTodas == false"
                  class="btn btn-success"
                  @click="
                    abrirSucesoNuevo(true),
                      (trackedDate = new Date().toISOString().substr(0, 10))
                  "
                >
                  NUEVO
                </button>
              </div>
            </div>
            <div class="row" v-if="seguimientosPermiso == 'TODOS'">
              <div class="col-md-9">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="persona">Personas</label>
                    <input
                      class="form-control input"
                      id="persona"
                      type="text"
                      v-model="queryP"
                      @keyup="cargarPersonas()"
                    />
                  </div>

                  <div class="col-sm-6 text marginBottom">
                    <button
                      v-if="verTodas == false"
                      class="btn btn-primary"
                      @click="verTodasF(), (verTodas = true)"
                    >
                      Ver Todos
                    </button>
                    <button
                      v-if="verTodas == true"
                      class="btn btn-primary"
                      @click="verTodas = false"
                    >
                      No Ver Todos
                    </button>
                  </div>
                </div>
                <div class="col">
                  <select
                    class="form-control input"
                    v-model="idNuevo"
                    @change="fetchData(), verTodasF(), cargarPermisos()"
                  >
                    <option
                      v-for="(persona, index) in personas"
                      v-bind:key="index"
                      v-bind:value="persona.ID"
                    >
                      {{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
                      {{ persona.APELLIDO2 }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3" align="right">
            <input
              type="text"
              class="form-control input-sm"
              placeholder="Buscar"
              v-model="query"
              @keyup="fetchData(), verTodasF()"
            />
            <select
              class="form-control input"
              id="ordenar"
              v-model="ordenarPor"
            >
              <option disabled selected>Ordenar por</option>
              <option value="ESTADO">Estado</option>
              <option value="FECHA, -1">Fecha(Primero mayor)</option>
              <option value="FECHA">Fecha(Primero menor)</option>
              <option value="TIPO">Tipo</option>
              <option value="IDEXPEDIENTE">Expediente</option>
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
      <div class="panel-body" v-if="verTodas == false">
        <div class="table-responsive">
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed"
          >
            <tr>
              <th class="text fecha">FECHA</th>
              <th class="text campo1">REQUERIMIENTO</th>
              <th class="text campo2">SUCESO</th>
            </tr>
            <tr
              v-for="seguimiento in orderBy(seguimientos, this.ordenarPor)"
              v-bind:key="seguimiento.ID"
              @click="abrirSuceso(seguimiento), (editar = false)"
              :style="btnStyles(seguimiento.ESTADO)"
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

      <div class="panel-body" v-if="verTodas == true">
        <div class="table-responsive">
          <table
            class="table table-bordered table-striped"
            style="table-layout: fixed"
          >
            <tr>
              <th class="text fecha">FECHA</th>
              <th class="text campo1">REQUERIMIENTO</th>
              <th class="text campo2">SUCESO</th>
            </tr>
            <tr
              v-for="seguimiento in orderBy(todosSeguimientos, this.ordenarPor)"
              v-bind:key="seguimiento.ID"
              @click="abrirSuceso(seguimiento), (editar = false)"
              :style="btnStyles(seguimiento.ESTADO)"
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

    <!-- info expediente NO admin -->

    <div id="oculto" v-if="showSuceso && admin == 'NO'">
      <div id="oculto2" @click="(showSuceso = false), (editar = false)"></div>
      <button
        class="btn btn-primary editar"
        v-if="estado == 'REQUERIDO' && editar == false"
        @click="editar = true"
      >
        Editar
      </button>
      <button
        class="btn btn-primary editar"
        v-if="estado == 'REQUERIDO' && editar == true"
        @click="guardar(false)"
      >
        Guardar
      </button>
      <div id="cajaSeguimiento" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha">Fecha</label>
            <input
              class="form-control input"
              id="fecha"
              type="text"
              v-bind:value="fecha"
              placeholder="Fecha"
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
            <label for="persona">Persona</label>
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
            <label for="animal">Animal</label>
            <input
              class="form-control input"
              type="text"
              id="animal"
              v-bind:value="animal"
              placeholder="Animal"
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
            <label for="tipo">Tipo</label>
            <input
              id="tipo"
              class="form-control input"
              type="text"
              v-bind:value="tipo"
              placeholder="Tipo"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="expediente">Expediente</label>
            <input
              class="form-control input"
              id="expediente"
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
              v-model="suceso"
              :readonly="!editar"
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
              v-model="actuacion"
              :readonly="!editar"
            ></textarea>
          </div>
          <div class="col-md-6">
            <textarea
              style="display: none"
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
            <span class="estado" v-if="estado == 'VALIDADO'">{{ estado }}</span>
            <span
              class="estado"
              style="color: rgb(255 197 0)"
              v-if="estado == 'RECORDATORIO'"
              >{{ estado }}</span
            >
            <span
              class="estado"
              style="color: rgb(0 29 255)"
              v-if="estado == 'PENDIENTE'"
              >{{ estado }}</span
            >
            <span
              class="estado"
              style="color: rgb(255 0 0)"
              v-if="estado == 'REQUERIDO'"
              >{{ estado }}</span
            >
          </div>
        </div>
      </div>
    </div>

    <!-- info expediente admin -->

    <div id="oculto" v-if="showSuceso && admin == 'SI'">
      <div id="oculto2" @click="(showSuceso = false), (editar = false)"></div>
      <button
        class="btn btn-primary editar"
        v-if="editar == false"
        @click="abrirSucesoNuevo(false), acAnimales2(), (editar = true)"
      >
        Editar
      </button>
      <button
        class="btn btn-primary editar"
        v-if="editar == true"
        @click="guardar(false)"
      >
        Guardar
      </button>
      <div id="cajaSeguimiento" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha">Fecha</label>

            <input
              v-if="!editar"
              class="form-control input"
              id="fecha"
              type="text"
              v-bind:value="fecha"
              placeholder="Fecha"
              readonly="true"
            />

            <datepicker
              v-if="editar"
              id="fecha2"
              class="input"
              wrapper-class="calendario"
              color="green lighten-1"
              header-color="primary"
              placeholder="Fecha"
              full-width="true"
              monday-first="true"
              bootstrap-styling="true"
              @input="formatPicker3()"
              v-model="trackedDate3"
            ></datepicker>
          </div>

          <div class="col-sm-6">
            <label for="persona">Persona</label>
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

        <div class="row" v-if="!editar">
          <div class="col-sm-6">
            <label for="animal">Animal</label>
            <input
              class="form-control input"
              type="text"
              id="animal"
              v-bind:value="animal"
              placeholder="Animal"
              readonly="true"
            />
          </div>
          <div class="col-sm-6">
            <label for="tipo">Tipo</label>
            <input
              id="tipo"
              class="form-control input"
              type="text"
              v-bind:value="tipo"
              placeholder="Tipo"
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col-sm-6">
            <label for="animal2">Animal</label>
            <select
              class="form-control input"
              id="animal2"
              v-model="animal"
              :readonly="!editar"
            >
              <option v-for="animales in animalLista3" v-bind:key="animales.ID">
                {{ animales.NOMBRE }}
              </option>
            </select>
          </div>

          <div class="col-sm-6">
            <label for="tipo2">Tipo</label>
            <select
              class="form-control input"
              id="tipo2"
              v-model="tipo"
              :readonly="!editar"
            >
              <option v-for="tipo in tipos" v-bind:key="tipo.ID">
                {{ tipo.SEGUIMIENTOTIPO }}
              </option>
            </select>
          </div>
        </div>

        <div class="row" v-if="!editar">
          <div class="col">
            <label for="expediente">Expediente</label>
            <input
              class="form-control input"
              id="expediente"
              type="text"
              v-bind:value="expediente"
              placeholder="Expediente"
              readonly="true"
            />
          </div>
        </div>

        <div class="row" v-if="editar">
          <div class="col">
            <label for="expediente2">Expediente</label>
            <select
              class="form-control input"
              id="expediente2"
              v-model="expediente"
              @change="acAnimales2"
              :readonly="!editar"
            >
              <option
                v-for="expediente in expedientes"
                v-bind:key="expediente.ID"
              >
                {{ expediente.DESCRIPCION }}
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
              placeholder="Requerimiento"
              v-model="requerimiento"
              :readonly="!editar"
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
              v-model="suceso"
              :readonly="!editar"
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
              v-model="actuacion"
              :readonly="!editar"
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
              v-model="campo1"
              :readonly="!editar"
            ></textarea>
          </div>
        </div>

        <div class="row" v-if="editar == true">
          <div class="col">
            <select class="form-control input" v-model="estado">
              <option value="VALIDADO">VALIDADO</option>
              <option style="color: rgb(255 197 0)" value="RECORDATORIO">
                RECORDATORIO
              </option>
              <option style="color: rgb(0 29 255)" value="PENDIENTE">
                PENDIENTE
              </option>
              <option style="color: rgb(255 0 0)" value="REQUERIDO">
                REQUERIDO
              </option>
            </select>
          </div>
        </div>

        <div class="row" v-if="editar == false">
          <div class="col">
            <span class="estado" v-if="estado == 'VALIDADO'">{{ estado }}</span>
            <span
              class="estado"
              style="color: rgb(255 197 0)"
              v-if="estado == 'RECORDATORIO'"
              >{{ estado }}</span
            >
            <span
              class="estado"
              style="color: rgb(0 29 255)"
              v-if="estado == 'PENDIENTE'"
              >{{ estado }}</span
            >
            <span
              class="estado"
              style="color: rgb(255 0 0)"
              v-if="estado == 'REQUERIDO'"
              >{{ estado }}</span
            >
          </div>
        </div>
        <div class="row">
            <div class="col">
              <button
                class="btn btn-primary"
                v-if="editar == true"
                @click="verificacionBorrar = true"
              >
                Eliminar
              </button>
            </div>
        </div>
      </div>
    </div>

    <!-- Nuevo seguimiento NO admin -->

    <div id="ocultoNuevo" v-if="showSucesoNuevo && admin == 'NO'">
      <div id="oculto2Nuevo" @click="showSucesoNuevo = false"></div>
      <button class="btn btn-primary editar" @click="guardar(true)">
        Guardar
      </button>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha2">Fecha</label>
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
            <label for="persona2">Persona</label>
            <input
              class="form-control input"
              id="persona2"
              v-bind:value="persona2"
              type="text"
              placeholder="Persona"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="animal2">Animal</label>
            <select class="form-control input" id="animal2" v-model="animal2">
              <option v-for="animales in animalLista" v-bind:key="animales.ID">
                {{ animales.NOMBRE }}
              </option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="tipo2">Tipo</label>
            <select class="form-control input" id="tipo2" v-model="tipo2">
              <option v-for="tipo in tipos" v-bind:key="tipo.ID">
                {{ tipo.SEGUIMIENTOTIPO }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="expediente2">Expediente</label>
            <select
              class="form-control input"
              id="expediente2"
              v-model="expediente2"
              @change="acAnimales"
            >
              <option
                v-for="expediente in expedientes"
                v-bind:key="expediente.ID"
              >
                {{ expediente.DESCRIPCION }}
              </option>
            </select>
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
              v-model="suceso2"
            ></textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Nuevo seguimiento admin -->

    <div id="ocultoNuevo" v-if="showSucesoNuevo && admin == 'SI'">
      <div id="oculto2Nuevo" @click="showSucesoNuevo = false"></div>
      <button class="btn btn-primary editar" @click="guardar(true)">
        Guardar
      </button>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="fecha2">Fecha</label>
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
            <label for="persona2">Persona</label>
            <input
              class="form-control input"
              id="persona2"
              v-bind:value="persona2"
              type="text"
              placeholder="Persona"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="animal2">Animal</label>
            <select class="form-control input" id="animal2" v-model="animal2">
              <option v-for="animales in animalLista" v-bind:key="animales.ID">
                {{ animales.NOMBRE }}
              </option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="tipo2">Tipo</label>
            <select class="form-control input" id="tipo2" v-model="tipo2">
              <option v-for="tipo in tipos" v-bind:key="tipo.ID">
                {{ tipo.SEGUIMIENTOTIPO }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="expedienteBusca">Buscador Expediente</label>
            <input
              class="form-control input"
              type="text"
              name=""
              id="expedienteBusca"
              v-model="query2"
              @keyup="cargarExp()"
            />
          </div>
          <div class="col-sm-6">
            <label for="expediente2">Expediente</label>
            <select
              class="form-control input"
              id="expediente2"
              v-model="expediente2"
              @change="acAnimales"
            >
              <option
                v-for="expediente in expedientes"
                v-bind:key="expediente.ID"
              >
                {{ expediente.DESCRIPCION }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="estado">Estado</label>
            <select class="form-control input" id="estado" v-model="estado2">
              <option value="VALIDADO">VALIDADO</option>
              <option style="color: rgb(255 197 0)" value="RECORDATORIO">
                RECORDATORIO
              </option>
              <option style="color: rgb(0 29 255)" value="PENDIENTE">
                PENDIENTE
              </option>
              <option style="color: rgb(255 0 0)" value="REQUERIDO">
                REQUERIDO
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
              placeholder="Requerimiento"
              v-model="requerimiento2"
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
              v-model="suceso2"
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
              v-model="actuacion2"
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
              v-model="campo12"
            ></textarea>
          </div>
        </div>
      </div>
    </div>
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
            <label for="animal2">Animal</label>
            <select class="form-control input" id="animal2" v-model="animal2">
              <option v-for="animales in animalLista" v-bind:key="animales.ID">
                {{ animales.NOMBRE }}
              </option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="tipo2">Tipo</label>
            <select class="form-control input" id="tipo2" v-model="tipo2">
              <option v-for="tipo in tipos" v-bind:key="tipo.ID">
                {{ tipo.SEGUIMIENTOTIPO }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="expedienteBusca">Buscador Expediente</label>
            <input
              class="form-control input"
              type="text"
              name=""
              id="expedienteBusca"
              v-model="query2"
              @keyup="cargarExp()"
            />
          </div>
          <div class="col-sm-6">
            <label for="expediente2">Expediente</label>
            <select
              class="form-control input"
              id="expediente2"
              v-model="expediente2"
              @change="acAnimales"
            >
              <option
                v-for="expediente in expedientes"
                v-bind:key="expediente.ID"
              >
                {{ expediente.DESCRIPCION }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>


    
    <!-- Confirmar borrado -->

    <div id="ocultoNuevo" v-if="verificacionBorrar == true">
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col">
            ¿Está seguro de que desea borrar este elemento definitivamente?
          </div>
        </div>
        <div class="row">
          <div class="col">
            <button
              class="btn"
              @click="
                (verificacionBorrar = false),
                  eliminar()
              "
            >
              SI
            </button>
          </div>
          <div class="col">
            <button class="btn" @click="verificacionBorrar = false">NO</button>
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
      seguimientosPermiso: "permisoSeguimientos",
      guia: "permisoSeguimientosT",
    }),
  },
  data() {
    return {
      trackedDate: new Date().toISOString().substr(0, 10),
      trackedDate3: new Date().toISOString().substr(0, 10),
      trackedDate2: new Date().toISOString().substr(0, 10),
      subtitulo: "culo",
      seguimientos: "",
      query: "",
      queryP: "",
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
      // seguimientosPermiso: "PROPIOS", /*this.$store.getters.permisoSeguimientos*/
      tipos: "",
      expedientes: "",
      animalLista: "",
      animalLista3: "",
      animal3: "",
      editar: false,
      personaID: "",
      ordenarPor: "Ordenar por",
      filtrar: false,
      // admin: "NO", /*this.$store.getters.permisoAdmin*/
      personas: "",
      idNuevo: 0,
      query2: "",
      verTodas: false,
      todosSeguimientos: "",
      verificacionBorrar: false,
      guia2: "",
    };
  },
  methods: {
    btnStyles: function (estado) {
      if (estado == "REQUERIDO")
        return {
          background: "#fad7d7",
        };
      if (estado == "PENDIENTE")
        return {
          background: "rgb(215 219 250)",
        };
      if (estado == "RECORDATORIO")
        return {
          background: "rgb(250 242 215)",
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
      if (this.idNuevo == 0) {
        this.idNuevo = this.idUsuario;
      }
      if (this.guia2 == "") {
        this.guia2 = this.guia;
      }

      /* alert(this.admin);*/
      axios
        .post("php/seguimientos.php", {
          query: this.query,
          usuario: this.idNuevo,
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
    abrirSucesoNuevo(entrada) {
      if (entrada) {
        this.showSucesoNuevo = !this.showSucesoNuevo;
        this.tipo2 = "";
        this.expediente2 = 0;
        this.animalLista = "";
        this.animal2 = 0;
        this.campo12 = "";
        this.suceso2 = "Sin novedad";
        this.estado2 = "PENDIENTE";
        this.requerimiento2 = "";
        this.actuacion2 = "";
      } else {
        this.animalLista3 = "";
      }

      axios
        .post("php/persona.php", {
          query: this.idNuevo,
        })
        .then((response) => {
          this.persona2 = response.data;
        });
      this.cargarExp();
      axios
        .post("php/seguimientotipo.php", {
          query: this.guia2,
        })
        .then((response) => {
          this.tipos = response.data;
        });
    },
    cargarExp() {
      axios
        .post("php/expedientes.php", {
          query: this.idNuevo,
          query2: this.query2,
        })
        .then((response) => {
          this.expedientes = response.data;
        });
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
      this.cargarExp();
      axios
        .post("php/seguimientotipo.php", {
          query: this.guia2,
        })
        .then((response) => {
          this.tipos = response.data;
        });
    },
    cargarFiltro() {
      this.filtrar = false;

      axios
        .post("php/seguimientos.php", {
          tipo: this.tipo2,
          fecha: this.fecha2,
          fecha2: this.fecha22,
          expediente: this.expediente2,
          animal: this.animal2,
          usuario: this.idNuevo,
        })
        .then((response) => {
          if (response.data.length > 0) {
            this.seguimientos = response.data;
            this.nodata = false;
          } else {
            this.seguimientos = "";
            this.nodata = true;
          }

          axios
            .post("php/seguimientosTodos.php", {
              tipo: this.tipo2,
              fecha: this.fecha2,
              fecha2: this.fecha22,
              expediente: this.expediente2,
              animal: this.animal2,
              usuario: this.idNuevo,
            })
            .then((response) => {
              if (response.data.length > 0) {
                this.todosSeguimientos = response.data;
                this.nodata = false;
              } else {
                this.todosSeguimientos = "";
                this.nodata = true;
              }
              this.tipo2 = "";
              this.expediente2 = 0;
              this.animalLista = "";
              this.animal2 = 0;
              this.expedientes = "";
              this.tipos = "";
              this.fecha2 = "";
              this.fecha22 = "";
            });
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

      this.idSeguimiento = value.ID;

      var aux = value.IDANIMAL;
      this.personaID = value.IDPERSONA;
      var aux3 = value.IDEXPEDIENTE;

      axios
        .post("php/animales.php", {
          query: aux,
        })
        .then((response) => {
          this.animal = response.data;
        });
      axios
        .post("php/persona.php", {
          query: this.personaID,
        })
        .then((response) => {
          this.persona = response.data;
        });
      axios
        .post("php/expediente.php", {
          query: aux3,
        })
        .then((response) => {
          this.expediente = response.data;
        });
    },
    acAnimales() {
      this.animal2 = 0;
      this.animalLista = "";
      axios
        .post("php/animalesExpediente.php", {
          query: this.expediente2,
        })
        .then((response) => {
          this.animalLista = response.data;
        });
    },
    acAnimales2() {
      this.animal = 0;
      this.animalLista3 = "";
      axios
        .post("php/animalesExpediente.php", {
          query: this.expediente,
        })
        .then((response) => {
          this.animalLista3 = response.data;
        });
    },
    guardar(aux) {
      var aux1 = "";
      var aux2 = "";
      var aux3 = "";
      var aux4 = "";
      var aux5 = "";
      var aux6 = "";
      var aux7 = "";
      var aux8 = "";
      var aux9 = "";
      var aux10 = 0;
      var aux11 = "PENDIENTE";

      if (aux) {
        this.formatPicker();

        aux1 = this.fecha2;
        aux2 = this.idNuevo;
        aux3 = this.animal2;
        aux4 = this.tipo2;
        aux5 = this.expediente2;
        aux6 = this.suceso2;
        aux7 = this.actuacion2;
        aux8 = this.requerimiento2;
        aux9 = this.campo12;
        aux10 = this.idSeguimiento2;
        aux11 = this.estado2;

        if (aux5 == "") {
          this.$notify({
            group: "foo",
            title: "AVISO",
            text: "Debe seleccionar un expediente para poder guardar.",
            type: "error",
          });
          return 0;
        }
      } else {
        aux1 = this.fecha;
        aux2 = this.personaID;
        aux3 = this.animal;
        aux4 = this.tipo;
        aux5 = this.expediente;
        aux6 = this.suceso;
        aux7 = this.actuacion;
        aux8 = this.requerimiento;
        aux9 = this.campo1;
        aux10 = this.idSeguimiento;
        aux11 = this.estado;
        if (this.admin == "SI") {
          aux11 = this.estado;
        } else {
          aux11 = "PENDIENTE";
        }
      }
      axios
        .post("php/guardarRegistro.php", {
          fecha: aux1,
          persona: aux2,
          animal: aux3,
          tipo: aux4,
          expediente: aux5,
          suceso: aux6,
          actuacion: aux7,
          requerimiento: aux8,
          campo1: aux9,
          id: aux10,
          estado: aux11,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: "Exito",
            text: response.data,
            type: "success",
          });
          this.showSuceso = false;
          this.showSucesoNuevo = false;
          this.fetchData();
          this.verTodasF();
        });
    },
    cargarPersonas: function () {
      this.idNuevo = this.idUsuario;

      axios
        .post("php/listaPersonas.php", {
          query: this.queryP,
        })
        .then((response) => {
          this.personas = response.data;
          if (this.verTodas == true) {
            this.verTodasF();
          }
        });
    },
    verTodasF() {
      axios.post("php/seguimientosTodos.php", {}).then((response) => {
        if (response.data.length > 0) {
          this.todosSeguimientos = response.data;
        } else {
          this.todosSeguimientos = "";
        }
      });
    },
    eliminar(){
      axios.post("php/borrarElemento.php", {
        id: this.idSeguimiento,
        tabla: "SEGUIMIENTOS",
      }).then((response) => {
          this.$notify({
            group: "foo",
            title: "Exito",
            text: response.data,
            type: "success",
          });
          this.showSuceso = false;
          this.showSucesoNuevo = false;
          this.fetchData();
          this.verTodasF();
      });
    },
    cargarPermisos(){
      
            axios
              .post("php/permisosPropios.php", {
                query: this.idNuevo,
              })
              .then((response) => {
                var aux = response.data;
                this.guia2 = aux[0][12];
              });
    },
  },
  created: function () {
    this.fetchData();
    this.cargarPersonas();
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
  z-index: 10;
  position: fixed;
  top: 2%;
  right: 10%;
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