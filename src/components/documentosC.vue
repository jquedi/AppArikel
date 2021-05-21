<template>
  <div class="container" id="documentosC">
    <h1>Documentos</h1>
    <button
      v-if="permisos == 'EDITAR'"
      class="btn btn-success"
      style="position: relative; margin-left: 80%"
      @click="(nuevoAbierto = true), cargarListas()"
    >
      Nuevo Documento
    </button>
    <h2 v-if="carpetaAbierta == true">{{ opcion }}</h2>
    <!-- boton atrás -->
    <div class="row" v-if="carpetaAbierta == true">
      <div class="col-sm">
        <label for="select">Ordenar por:</label>
        <select id="select" v-model="categoria" @change="cargarCategorias()">
          <option value="ninguno">Ninguno</option>
          <option value="expedientes">Expedientes</option>
          <option value="animales">Animales</option>
          <option value="eventos">Eventos</option>
        </select>
      </div>
      <div class="col-sm">
        <button @click="(carpetaAbierta = false), (categoria = 'ninguno')">
          Atrás
        </button>
      </div>
    </div>

    <!-- documentos -->
  <div v-if="carpetaAbierta == true">
    <label for="buscador">Buscador por Titulo</label>
    <input class="form-control input" type="text" name="" id="buscador" v-model="query2" @keyup="cargarCategorias()">
  </div>

    <!-- expedientes -->
    <div
      class="panel panel-default"
      v-if="carpetaAbierta == true && categoria == 'expedientes'"
    >
    
    <label for="buscador">Buscador por Expediente</label>
    <input class="form-control input" type="text" name="" id="buscador" v-model="query3" @keyup="cargarCategorias()">

      <div class="panel-body">
        <div
          class="table-responsive"
          v-for="(categoria, index) in categorias"
          v-bind:key="index"
          style="overflow: hidden"
        >
          <span class="categoriaTitulo" for="categoria">{{
            categoria[2]
          }}</span>
          <div class="categoria">
            <div class="row">
              <div
                class=""
                v-for="(documento, index) in documentos"
                v-bind:key="index"
                v-bind:value="documento.ID"
              >
                <div
                  class="col-sm-1 docuCont"
                  v-if="documento.EXPEDIENTE === categoria[0]"
                >
                  <div class="documento" @click="abrirDocu(documento.ID)">
                    <div class="trianguloDocu1"></div>
                    <div class="trianguloDocu2"></div>
                    <div class="rayaDocu"></div>
                    <div class="rayaDocu rayaDocu2"></div>
                    <div class="rayaDocu rayaDocu3"></div>
                  </div>
                  <label class="tituloDocu" for="documento">{{
                    documento.DOCUMENTO
                  }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive" style="overflow: hidden">
          <span class="categoriaTitulo" for="categoria">Sin Expediente</span>
          <div class="categoria">
            <div class="row">
              <div
                class=""
                v-for="(documento, index) in documentos"
                v-bind:key="index"
                v-bind:value="documento.ID"
              >
                <div class="col-sm-1 docuCont" v-if="documento.EXPEDIENTE == 0">
                  <div class="documento" @click="abrirDocu(documento.ID)">
                    <div class="trianguloDocu1"></div>
                    <div class="trianguloDocu2"></div>
                    <div class="rayaDocu"></div>
                    <div class="rayaDocu rayaDocu2"></div>
                    <div class="rayaDocu rayaDocu3"></div>
                  </div>
                  <label class="tituloDocu" for="documento">{{
                    documento.DOCUMENTO
                  }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- animales -->

    <div
      class="panel panel-default"
      v-if="carpetaAbierta == true && categoria == 'animales'"
    >
      <div class="panel-body">
        <div
          class="table-responsive"
          v-for="(categoria, index) in categorias"
          v-bind:key="index"
          style="overflow: hidden"
        >
          <span class="categoriaTitulo" for="categoria">{{
            categoria[2]
          }}</span>
          <div class="categoria">
            <div class="row">
              <div
                class=""
                v-for="(documento, index) in documentos"
                v-bind:key="index"
                v-bind:value="documento.ID"
              >
                <div
                  class="col-sm-1 docuCont"
                  v-if="documento.IDANIMAL === categoria[0]"
                >
                  <div class="documento" @click="abrirDocu(documento.ID)">
                    <div class="trianguloDocu1"></div>
                    <div class="trianguloDocu2"></div>
                    <div class="rayaDocu"></div>
                    <div class="rayaDocu rayaDocu2"></div>
                    <div class="rayaDocu rayaDocu3"></div>
                  </div>
                  <label class="tituloDocu" for="documento">{{
                    documento.DOCUMENTO
                  }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- eventos -->
    <div
      class="panel panel-default"
      v-if="carpetaAbierta == true && categoria == 'eventos'"
    >
      <div class="panel-body">
        <div
          class="table-responsive"
          v-for="(categoria, index) in categorias"
          v-bind:key="index"
          style="overflow: hidden"
        >
          <span class="categoriaTitulo" for="categoria">{{
            categoria[2]
          }}</span>
          <div class="categoria">
            <div class="row">
              <div
                class=""
                v-for="(documento, index) in documentos"
                v-bind:key="index"
                v-bind:value="documento.ID"
              >
                <div
                  class="col-sm-1 docuCont"
                  v-if="documento.IDEVENTO === categoria[0]"
                >
                  <div class="documento" @click="abrirDocu(documento.ID)">
                    <div class="trianguloDocu1"></div>
                    <div class="trianguloDocu2"></div>
                    <div class="rayaDocu"></div>
                    <div class="rayaDocu rayaDocu2"></div>
                    <div class="rayaDocu rayaDocu3"></div>
                  </div>
                  <label class="tituloDocu" for="documento">{{
                    documento.DOCUMENTO
                  }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive" style="overflow: hidden">
          <span class="categoriaTitulo" for="categoria">Sin Evento</span>
          <div class="categoria">
            <div class="row">
              <div
                class=""
                v-for="(documento, index) in documentos"
                v-bind:key="index"
                v-bind:value="documento.ID"
              >
                <div class="col-sm-1 docuCont" v-if="documento.IDEVENTO == 0">
                  <div class="documento" @click="abrirDocu(documento.ID)">
                    <div class="trianguloDocu1"></div>
                    <div class="trianguloDocu2"></div>
                    <div class="rayaDocu"></div>
                    <div class="rayaDocu rayaDocu2"></div>
                    <div class="rayaDocu rayaDocu3"></div>
                  </div>
                  <label class="tituloDocu" for="documento">{{
                    documento.DOCUMENTO
                  }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ninguno -->
    <div
      class="panel panel-default"
      v-if="carpetaAbierta == true && categoria == 'ninguno'"
    >
      <div class="panel-body">
        <div class="table-responsive" style="overflow: hidden">
          <div class="row">
            <div
              class=""
              v-for="(documento, index) in documentos"
              v-bind:key="index"
              v-bind:value="documento.ID"
            >
              <div class="col-sm-1 docuCont">
                <div class="documento" @click="abrirDocu(documento.ID)">
                  <div class="trianguloDocu1"></div>
                  <div class="trianguloDocu2"></div>
                  <div class="rayaDocu"></div>
                  <div class="rayaDocu rayaDocu2"></div>
                  <div class="rayaDocu rayaDocu3"></div>
                </div>
                <label class="tituloDocu" for="documento">{{
                  documento.DOCUMENTO
                }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- carpetas -->
    <div class="row">
      <div
        class="col-sm colN"
        v-if="carpetaAbierta == false"
        @click="abrirCarpeta('publicos')"
      >
        <div class="carpeta">
          <div class="solapa">
            <div class="triangulo"></div>
          </div>
        </div>
        <label class="tituloCarpeta" for="carpeta">Publicos</label>
      </div>
      <div
        class="col-sm colN"
        v-if="carpetaAbierta == false"
        @click="abrirCarpeta('propios')"
      >
        <div class="carpeta">
          <div class="solapa">
            <div class="triangulo"></div>
          </div>
        </div>
        <label class="tituloCarpeta" for="carpeta">Propios</label>
      </div>
      <div
        class="col-sm colN"
        v-if="privadosPermiso == 'SI' && carpetaAbierta == false"
        @click="abrirCarpeta('privados')"
      >
        <div class="carpeta">
          <div class="solapa">
            <div class="triangulo"></div>
          </div>
        </div>
        <label class="tituloCarpeta" for="carpeta">Privados</label>
      </div>
      <div
        class="col-sm colN"
        v-if="formacionPermiso == 'SI' && carpetaAbierta == false"
        @click="abrirCarpeta('formacion')"
      >
        <div class="carpeta">
          <div class="solapa">
            <div class="triangulo"></div>
          </div>
        </div>
        <label class="tituloCarpeta" for="carpeta">Formación</label>
      </div>
      <div
        class="col-sm colN"
        v-if="operativosPermiso == 'SI' && carpetaAbierta == false"
        @click="abrirCarpeta('operativos')"
      >
        <div class="carpeta">
          <div class="solapa">
            <div class="triangulo"></div>
          </div>
        </div>
        <label class="tituloCarpeta" for="carpeta">Operativos</label>
      </div>
    </div>

    <!-- INFO DOCU -->

    <div id="ocultoNuevo" v-if="docuAbierto == true">
      <div id="oculto2Nuevo" @click="cerrarDocu()"></div>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6" v-if="valor1 != ''">
            <label for="Documento">Documento</label>
            <input
              class="form-control input"
              id="Documento"
              v-model="valor1"
              type="text"
              placeholder="Documento"
              readonly="true"
            />
          </div>
          <div class="col-sm-6" v-if="valor2 != ''">
            <label for="Tipo">Tipo</label>
            <input
              class="form-control input"
              id="Tipo"
              v-model="valor2"
              type="text"
              placeholder="Tipo"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col" v-if="valor3 != '' && permisos == 'EDITAR'">
            <label for="Notas">Notas</label>
            <input
              class="form-control input"
              id="Notas"
              v-model="valor3"
              type="text"
              placeholder="Notas"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col" v-if="valor4 != ''">
            <label for="Expediente">Expediente</label>
            <input
              class="form-control input"
              id="Expediente"
              v-model="valor4"
              type="text"
              placeholder="Expediente"
              readonly="true"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6" v-if="valor5 != ''">
            <label for="Animal">Animal</label>
            <input
              class="form-control input"
              id="Animal"
              v-model="valor5"
              type="text"
              placeholder="Animal"
              readonly="true"
            />
          </div>
          <div class="col-sm-6" v-if="valor6 != ''">
            <label for="Persona">Persona</label>
            <input
              class="form-control input"
              id="Persona"
              v-model="valor6"
              type="text"
              placeholder="Persona"
              readonly="true"
            />
          </div>
        </div>

        <div class="row">
          <div class="col" v-if="valor7 != ''">
            <label for="Evento">Evento</label>
            <input
              class="form-control input"
              id="Evento"
              v-model="valor7"
              type="text"
              placeholder="Evento"
              readonly="true"
            />
          </div>
        </div>

        <div class="row">
          <div class="col" v-if="valor8 != '' && permisos == 'EDITAR'">
            <label for="Campo1">Campo1</label>
            <textarea
              class="form-control input"
              id="Campo1"
              v-model="valor8"
              placeholder="Campo1"
              readonly="true"
            >
            </textarea>
          </div>
        </div>
        <div class="row" style="margin-top: 20px">
          <div class="col-sm-6">
            <button class="btn btn-success">DESCARGAR</button>
          </div>
          <div class="col-sm-6" v-if="permisos == 'EDITAR'">
            <button class="btn btn-warning" @click="borrarDocu = true">
              BORRAR
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Nuevo DOCU -->

    <div id="ocultoNuevo" v-if="nuevoAbierto == true">
      <div id="oculto2Nuevo" @click="cerrarNuevo()"></div>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col-sm-6">
            <label for="Documento">Documento</label>
            <input
              class="form-control input"
              id="Documento"
              v-model="valor1g"
              type="text"
              placeholder="Documento"
            />
          </div>
          <div class="col-sm-6">
            <label for="Tipo">Tipo</label>

            <select class="form-control input" id="Tipo" v-model="valor2g">
              <option
                v-for="expediente in tiposFULL"
                v-bind:key="expediente.ID"
                v-bind:value="expediente.DOCUMENTOSTIPO"
              >
                {{ expediente.DOCUMENTOSTIPO }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="Notas">Notas</label>
            <input
              class="form-control input"
              id="Notas"
              v-model="valor3g"
              type="text"
              placeholder="Notas"
            />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="Expediente">Expediente</label>

            <select
              class="form-control input"
              id="Expediente"
              v-model="valor4g"
            >
              <option value="0"></option>
              <option
                v-for="expediente in expedientesFULL"
                v-bind:key="expediente.ID"
                v-bind:value="expediente.ID"
              >
                {{ expediente.DESCRIPCION }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="Animal">Animal</label>
            <select class="form-control input" id="Animal" v-model="valor5g">
              <option value="0"></option>
              <option
                v-for="animal in animalesFULL"
                v-bind:key="animal.ID"
                v-bind:value="animal.ID"
              >
                {{ animal.NOMBRE }}
              </option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="Persona">Persona</label>
            <select class="form-control input" id="Persona" v-model="valor6g">
              <option value="0"></option>
              <option
                v-for="persona in personasFULL"
                v-bind:key="persona.ID"
                v-bind:value="persona.ID"
              >
                {{ persona.NOMBRE }} {{ persona.APELLIDO1 }}
                {{ persona.APELLIDO2 }}
              </option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label for="Evento">Evento</label>

            <select class="form-control input" id="Evento" v-model="valor7g">
              <option value="0"></option>
              <option
                v-for="persona in eventosFULL"
                v-bind:key="persona.ID"
                v-bind:value="persona.ID"
              >
                {{ persona.DESCRIPCION }}
              </option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <label for="Categoria">Categoria</label>
            <select class="form-control input" id="Categoria" v-model="valor9g">
              <option value="1">Privado</option>
              <option value="2">Operativo</option>
              <option value="3">Formacion</option>
              <option value="4">Publico</option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="Campo1">Campo1</label>
            <textarea
              class="form-control input"
              id="Campo1"
              v-model="valor8g"
              placeholder="Campo1"
            >
            </textarea>
          </div>
        </div>
        <div class="row" style="margin-top: 20px">
          <div class="col">
            <input
              type="file"
              id="file"
              ref="file"
              v-on:change="handleFileUpload()"
            />
          </div>
        </div>
        <div class="row" style="margin-top: 20px">
          <div class="col">
            <button
              class="btn btn-success"
              @click="(nuevoAbierto = false), guardarDocu()"
            >
              GUARDAR
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmacion BOrrar -->

    <div id="ocultoNuevo" v-if="borrarDocu == true">
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col">
            ¿Está seguro de que desea borrar este documento?
          </div>
        </div>
        <div class="row">
          <div class="col">
            <button
              class="btn"
              @click="
                (borrarDocu = false),
                  borrarDocu2(),
                  (carpetaAbierta = false),
                  cerrarDocu()
              "
            >
              SI
            </button>
          </div>
          <div class="col">
            <button class="btn" @click="borrarDocu = false">NO</button>
          </div>
        </div>
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
    ...mapGetters({
      permisos: "permisoDocumentos",
      privadosPermiso: "docuPermisoPrivado",
      formacionPermiso: "docuPermisoFormacion",
      operativosPermiso: "docuPermisoOperativo",
    }),
  },
  data() {
    return {
      idUsuario: this.$store.getters.sacarid,
      // privadosPermiso: "SI", // this.$store.getters.docuPermisoPrivado
      // formacionPermiso: "SI", // this.$store.getters.docuPermisoFormacion
      // operativosPermiso: "SI", // this.$store.getters.docuPermisoOperativo
      carpetaAbierta: false,
      documentos: "",
      opcion: "",
      categorias: "",
      categoria: "ninguno",
      docuAbierto: false,
      valor1: "",
      valor2: "",
      valor3: "",
      valor4: "",
      valor5: "",
      valor6: "",
      valor7: "",
      valor8: "",
      ruta: "",

      valor1g: "",
      valor2g: "INFORME",
      valor3g: "",
      valor4g: 0,
      valor5g: 0,
      valor6g: 0,
      valor7g: 0,
      valor8g: "",
      valor9g: 1,
      rutag: "",

      info1: "",
      info2: "",
      info3: "",
      info4: "",
      info6: "",
      info7: "",
      info8: "",
      info9: "",
      info10: "",

      docuID: "",
      borrarDocu: false,

      nuevoAbierto: false,

      expedientesFULL: "",
      animalesFULL: "",
      personasFULL: "",
      eventosFULL: "",
      tiposFULL: "",

      file: "",

      query2: "",
      query3: "",
    };
  },
  methods: {
    ...mapGetters(["sacarid"]),

    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },

    submitFile() {},

    guardarDocu() {
      axios
        .post("php/guardarDocumento.php", {
          documento: this.valor1g,
          documentostipo: this.valor2g,
          notas: this.valor3g,
          expediente: this.valor4g,
          animal: this.valor5g,
          persona: this.valor6g,
          evento: this.valor7g,
          campo1: this.valor8g,
          ruta: this.rutag,
          tipo: this.valor9g,
        })
        .then(() => {

          this.cerrarNuevo();
        });
        
          let formData = new FormData();

          formData.append('file', this.file);

          axios
            .post('documentos/', formData, {
              headers: {
                'Content-Type': 'multipart/form-data',
              },
            });
    },

    cargarListas() {
      axios
        .post("php/expedientesFULL.php", {
          query: "",
        })
        .then((response) => {
          this.expedientesFULL = response.data;
        });
      axios.post("php/animalesListaFull.php", {}).then((response) => {
        this.animalesFULL = response.data;
      });
      axios
        .post("php/listaPersonas.php", {
          query: "",
          expediente: "",
        })
        .then((response) => {
          this.personasFULL = response.data;
        });
      axios.post("php/eventosActivos.php", {}).then((response) => {
        this.eventosFULL = response.data;
      });
      axios.post("php/documentosTipos.php", {}).then((response) => {
        this.tiposFULL = response.data;
      });
    },

    cerrarNuevo() {
      this.nuevoAbierto = false;

      this.valor1g = "";
      this.valor2g = "INFORME";
      this.valor3g = "";
      this.valor4g = 0;
      this.valor5g = 0;
      this.valor6g = 0;
      this.valor7g = 0;
      this.valor8g = "";
      this.rutag = "";
      this.valor9g = 1;
    },

    borrarDocu2() {
      axios.post("php/borrarDocumento.php", {
        query: this.docuID,
      });
    },

    cerrarDocu() {
      this.docuAbierto = false;

      this.info1 = "";
      this.info2 = "";
      this.info3 = "";
      this.info4 = "";
      this.info6 = "";
      this.info7 = "";
      this.info8 = "";
      this.info9 = "";
      this.info10 = "";

      this.valor1 = "";
      this.valor2 = "";
      this.valor3 = "";
      this.valor4 = "";
      this.valor5 = "";
      this.valor6 = "";
      this.valor7 = "";
      this.valor8 = "";
      this.ruta = "";
      this.docuID = "";
    },

    abrirDocu(idDocu) {
      this.docuAbierto = true;
      this.docuID = idDocu;

      axios
        .post("php/documento.php", {
          query: idDocu,
        })
        .then((response) => {
          var aux = response.data;

          this.info1 = aux[0][1];
          this.info2 = aux[0][2];
          this.info3 = aux[0][3];
          this.info4 = aux[0][4];
          this.info6 = aux[0][6];
          this.info7 = aux[0][7];
          this.info8 = aux[0][10];
          this.info9 = aux[0][11];
          this.info10 = aux[0][12];

          if (this.info6 != "0") {
            axios
              .post("php/expediente.php", {
                query: this.info6,
              })
              .then((response) => {
                this.valor4 = response.data;
              });
          }

          if (this.info8 != "0") {
            axios
              .post("php/animales.php", {
                query: this.info8,
              })
              .then((response) => {
                this.valor5 = response.data;
              });
          }

          if (this.info9 != "0") {
            axios
              .post("php/persona.php", {
                query: this.info9,
              })
              .then((response) => {
                this.valor6 = response.data;
              });
          }

          if (this.info10 != "0") {
            axios
              .post("php/evento.php", {
                query: this.info10,
              })
              .then((response) => {
                this.valor7 = response.data;
              });
          }

          this.valor1 = this.info1;
          this.valor2 = this.info2;
          this.valor3 = this.info3;
          this.ruta = this.info4;
          this.valor8 = this.info7;
        });
    },

    abrirCarpeta(opcion) {
      this.carpetaAbierta = true;
      this.opcion = opcion;

      this.cargarCategorias();
    },
    cargarCategorias() {
      axios
        .post("php/documentos.php", {
          query: this.query2,
          permiso: this.permisos,
          opcion: this.opcion,
          id: this.idUsuario,
        })
        .then((response) => {
          this.documentos = response.data;
        });

      if (this.categoria == "expedientes") {
        axios
          .post("php/expedientes.php", {
            query: this.idUsuario,
            query2: this.query3,
          })
          .then((response) => {
            this.categorias = response.data;
          });
      }
      if (this.categoria == "animales") {
        axios
          .post("php/animalesLista.php", {
            usuario: this.idUsuario,
          })
          .then((response) => {
            this.categorias = response.data;
          });
      }
      if (this.categoria == "eventos") {
        axios
          .post("php/eventosAceptados.php", {
            usuario: this.idUsuario,
          })
          .then((response) => {
            this.categorias = response.data;
          });
      }
    },
  },
  created: function () {},
};
</script>
<style scoped>
.solapa {
  background: rgb(102 160 187);
  position: relative;
  top: -20px;
  left: 0px;
  width: 100px;
  height: 20px;
  border-radius: 18px 18px 0px 0px;
}
.carpeta {
  width: 200px;
  height: 140px;
  background: rgb(102 160 187 / 69%);
  position: relative;
  margin: auto;
  border-radius: 18px;
  border-top-left-radius: 0px;
}
.colN {
  margin: 5%;
}
.tituloCarpeta {
  font-size: 25px;
  font-weight: 800;
}

.triangulo {
  position: absolute;
  width: 0;
  height: 0;
  border-top: 20px solid #ffffff;
  border-left: 25px solid transparent;
  top: 0;
  right: 0;
}

.documento {
  background-color: #c4ced2;
  height: 130px;
  position: relative;
  width: 100px;
  margin: auto;
  margin-right: 25px;
}

.trianguloDocu1 {
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0 30px 30px 0;
  border-color: transparent #ffffff transparent transparent;
  position: absolute;
  right: -3px;
  top: -3px;
  z-index: 20;
}

.trianguloDocu2 {
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 24px 0 0 24px;
  border-color: transparent transparent transparent #8f9a9e;
  position: absolute;
  right: 0;
  z-index: 2;

  -moz-box-shadow: -1px 1px 4px 0px rgba(0, 0, 0, 0.2);
  -webkit-box-shadow: -1px 1px 4px 0px rgba(0, 0, 0, 0.2);
  box-shadow: -1px 1px 4px 0px rgba(0, 0, 0, 0.2);
}

.rayaDocu {
  width: 70%;
  height: 3px;
  background: dimgrey;
  margin-left: 15%;
  top: 20%;
  position: absolute;
}
.rayaDocu2 {
  top: 40%;
}
.rayaDocu3 {
  top: 60%;
}

.docuCont {
  margin: 20%;
}
.tituloDocu {
  font-size: 15px;
  font-weight: 700;
  text-decoration: underline;
  width: 100px;
}
.categoriaTitulo {
  border: solid;
  position: relative;
  top: 15px;
  border-radius: 10px;
  background: white;
  border-color: #ffca00;
  padding: 10px;
}
.categoria {
  border: solid;
  border-color: #ffca00;
  border-radius: 10px;
  min-height: 100px;
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