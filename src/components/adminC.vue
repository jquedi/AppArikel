<template>
  <div class="container" id="adminC">
    <h1>PANEL DE ADMINISTRADOR</h1>
    <select class="form-control input" id="accion" v-model="accion">
      <option value="personaN" selected="selected">Editar Persona</option>
      <option value="animalN">Editar Animal</option>
      <option value="expedientesA">Asignar Expedientes</option>
      <option value="expedientesN">Crear Expediente</option>
      <option value="usuario">Nuevo Usuario</option>
      <option value="proveedorN">Nuevo Proveedor</option>
      <option value="varios">Varios</option>
      <option></option>
    </select>

    <!-- CREAR EXPEDIENTE -->

    <div class="nuevo panel panel-default" v-if="accion == 'expedientesN'">
      <button
        class="botonarriba btn btn-success"
        @click="cambioF('expedientesE')"
      >
        Editar Expedientes
      </button>
      <h2 class="titulo">Crear expediente nuevo</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <input
            class="form-control input"
            id="codigo"
            type="text"
            v-model="codigoE"
            placeholder="Codigo"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="nombre"
            type="text"
            v-model="descripcionE"
            placeholder="Descripción"
          />
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm-6">
          <label for="fecha2">INICIO</label>
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

        <div class="col-sm">
          <input
            class="form-control input"
            id="chip"
            type="text"
            v-model="localizacionE"
            placeholder="Localización"
          />
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="tipo">Tipo</label>
          <select class="form-control input" id="tipo" v-model="tipoE">
            <option v-for="tipo in tiposE" v-bind:key="tipo.ID">
              {{ tipo.EXPEDIENTETIPO }}
            </option>
          </select>
        </div>

        <div class="col-sm">
          <label for="estado">Estado</label>
          <select class="form-control input" id="estado" v-model="estadoE">
            <option selected="selected">ACTIVO</option>
            <option>ANULADO</option>
            <option>ESPERANDO</option>
            <option>FINALIZADO</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="NOTAS">Notas</label>
          <textarea
            class="form-control input"
            name=""
            id="NOTAS"
            cols="30"
            rows="10"
            v-model="notasE"
            placeholder="NOTAS"
          >
          </textarea>
        </div>

        <div class="col-sm">
          <label for="campo1">Campo1</label>
          <textarea
            class="form-control input"
            name=""
            id="campo1"
            cols="30"
            rows="10"
            v-model="campo1E"
            placeholder="Campo1"
          >
          </textarea>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="activo">Activo</label>
          <select class="form-control input" id="activo" v-model="activoE">
            <option selected="selected">SI</option>
            <option>NO</option>
          </select>
        </div>
      </div>

      <div class="row">
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="guardarExpediente()"
        >
          Guardar
        </button>
      </div>
    </div>

    <!-- EDITAR EXPEDIENTE -->

    <div class="nuevo panel panel-default" v-if="accion == 'expedientesE'">
      <button
        class="botonarriba btn btn-success"
        @click="cambioF('expedientesN')"
      >
        Crear Expedientes
      </button>
      <h2 class="titulo">Editar expedientes</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <input
            class="form-control input"
            id="buscar"
            type="text"
            v-model="queryE"
            @keyup="cargarExpedientes()"
            placeholder="Buscar"
          />
        </div>
      </div>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="animal">Expediente</label>

          <select
            class="form-control input"
            id="tipo"
            v-model="idE"
            @change="buscarE()"
          >
            <option
              v-for="expediente in expedientes"
              v-bind:key="expediente.ID"
              v-bind:value="expediente.ID"
            >
              {{ expediente.DESCRIPCION }}
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
            id="codigo"
            type="text"
            v-model="codigoE"
            placeholder="Codigo"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="nombre"
            type="text"
            v-model="descripcionE"
            placeholder="Descripción"
          />
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm-6">
          <label for="fecha2">INICIO</label>
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

        <div class="col-sm">
          <input
            class="form-control input"
            id="chip"
            type="text"
            v-model="localizacionE"
            placeholder="Localización"
          />
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="tipo">Tipo</label>
          <select class="form-control input" id="tipo" v-model="tipoE">
            <option v-for="tipo in tiposE" v-bind:key="tipo.ID">
              {{ tipo.EXPEDIENTETIPO }}
            </option>
          </select>
        </div>

        <div class="col-sm">
          <label for="estado">Estado</label>
          <select class="form-control input" id="estado" v-model="estadoE">
            <option selected="selected">ACTIVO</option>
            <option>ANULADO</option>
            <option>ESPERANDO</option>
            <option>FINALIZADO</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="NOTAS">Notas</label>
          <textarea
            class="form-control input"
            name=""
            id="NOTAS"
            cols="30"
            rows="10"
            v-model="notasE"
            placeholder="Notas"
          >
          </textarea>
        </div>

        <div class="col-sm">
          <label for="campo1">Campo1</label>
          <textarea
            class="form-control input"
            name=""
            id="campo1"
            cols="30"
            rows="10"
            v-model="campo1E"
            placeholder="Campo1"
          >
          </textarea>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="activo">Activo</label>
          <select class="form-control input" id="activo" v-model="activoE">
            <option selected="selected">SI</option>
            <option>NO</option>
          </select>
        </div>
      </div>

      <div class="row">
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="guardarExpediente()"
        >
          Guardar
        </button>
      </div>
    </div>

    <!-- CREAR ANIMAL -->

    <div class="nuevo panel panel-default" v-if="accion == 'animalN'">
      <button class="botonarriba btn btn-success" @click="cambioF('animalE')">
        Editar Animal
      </button>
      <h2 class="titulo">Añadir nuevo animal</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <input
            class="form-control input"
            id="codigo"
            type="text"
            v-model="codigoA"
            placeholder="Codigo"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="nombre"
            type="text"
            v-model="nombreA"
            placeholder="Nombre"
          />
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm-6">
          <label for="fecha2">Nacimiento</label>
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

        <div class="col-sm">
          <input
            class="form-control input"
            id="chip"
            type="text"
            v-model="chipA"
            placeholder="Chip"
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
            id="alimentacion"
            type="text"
            v-model="alimentacionA"
            placeholder="Alimentacion"
          />
        </div>

        <div class="col-sm">
          <label for="NOTAS">Notas</label>
          <textarea
            class="form-control input"
            name=""
            id="NOTAS"
            cols="30"
            rows="10"
            v-model="notasA"
            placeholder="Notas"
          >
          </textarea>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="razaA">Raza</label>
          <select class="form-control input" id="razaA" v-model="razaA">
            <option v-for="raza in razasA" v-bind:key="raza.ANIMALRAZA">
              {{ raza.ANIMALRAZA }}
            </option>
          </select>
        </div>

        <div class="col-sm">
          <label for="ubiacionA">Ubicación</label>
          <select
            class="form-control input"
            id="ubiacionA"
            v-model="ubicacionA"
          >
            <option
              v-for="ubicacion in ubicacionesA"
              v-bind:key="ubicacion.ANIMALUBICACION"
            >
              {{ ubicacion.ANIMALUBICACION }}
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
          <select class="form-control input" id="tipo" v-model="tipoA">
            <option v-for="tipo in tiposA" v-bind:key="tipo.ANIMALTIPO">
              {{ tipo.ANIMALTIPO }}
            </option>
          </select>
        </div>
        <div class="col-sm">
          <label for="activo">Activo</label>
          <select class="form-control input" id="activo" v-model="activoA">
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
          <label for="tipo">Estado</label>
          <select class="form-control input" id="tipo" v-model="estadoA">
            <option v-for="estado in estadosA" v-bind:key="estado.ANIMALESTADO">
              {{ estado.ANIMALESTADO }}
            </option>
          </select>
        </div>
        <div class="col-sm">
          <label for="campo1">Campo1</label>
          <textarea
            class="form-control input"
            name=""
            id="campo1"
            cols="30"
            rows="10"
            v-model="campo1A"
            placeholder="Campo1"
          >
          </textarea>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col">
          <form
            action="/subirImagenPerro.php"
            method="post"
            enctype="multipart/form-data"
          >
            Imagen:
            <input
              class="form-control-file"
              type="file"
              name="fileToUpload"
              id="fileToUpload"
            />
            <input type="submit" value="Subir Imagen" name="submit" />
          </form>
        </div>
      </div>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col">



          
        </div>
      </div>

      <div class="row">
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="guardarAnimal()"
        >
          Guardar
        </button>
      </div>
    </div>

    <!-- ASIGNAR EXPEDIENTE -->
    <!-- Crear Relacion-->

    <div id="ocultoNuevo" v-if="abrirExpPersona">
      <div id="oculto2Nuevo" @click="abrirExpPersona = false"></div>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col">
            <label for="descripcion">Nota</label>
            <textarea
              class="form-control input"
              name
              id="descripcion"
              cols="30"
              rows="10"
              placeholder="Descripción"
              v-model="notaPersonaExp"
            ></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="animal">Tipo</label>

            <select
              class="form-control input"
              id="tipo"
              v-model="tipoPersonaExp"
            >
              <option
                v-for="tipo in tipoExpPersonaLista"
                v-bind:key="tipo.ID"
                v-bind:value="tipo.EXPEDIENTEPERSONATIPO"
              >
                {{ tipo.EXPEDIENTEPERSONATIPO }}
              </option>
            </select>
          </div>
        </div>

        <button @click="añadirPersonaExp()" class="btn btn-success">
          Crear
        </button>
      </div>
    </div>
    <!-- Crear Relacion animal-->

    <div id="ocultoNuevo" v-if="abrirExpAnimal">
      <div id="oculto2Nuevo" @click="abrirExpAnimal = false"></div>
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col">
            <label for="descripcion">Nota</label>
            <textarea
              class="form-control input"
              name
              id="descripcion"
              cols="30"
              rows="10"
              placeholder="Descripción"
              v-model="notaAnimalExp"
            ></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label for="animal">Tipo</label>

            <select
              class="form-control input"
              id="tipo"
              v-model="tipoAnimalExp"
            >
              <option value="TITULAR">TITULAR</option>
              <option value="RESERVA">RESERVA</option>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="animal">Estado</label>

            <select
              class="form-control input"
              id="tipo"
              v-model="estadoAnimalExp"
            >
              <option value="TRABAJANDO">TRABAJANDO</option>
              <option value="ENFERMO">ENFERMO</option>
            </select>
          </div>
        </div>

        <button @click="añadirAnimalExp()" class="btn btn-success">
          Crear
        </button>
      </div>
    </div>

    <div class="nuevo panel panel-default" v-if="accion == 'expedientesA'">
      <div class="row">
        <div class="col-sm-6">
          <h2 class="titulo">Asignar Expediente</h2>
        </div>
        <div class="col-sm-6">
          <button
            class="btn btn-success"
            v-if="expTipo == 'Animales'"
            @click="(expTipo = 'Personas'), cargarPersonasExpediente()"
          >
            Personas
          </button>
          <button
            class="btn btn-success"
            v-if="expTipo == 'Personas'"
            @click="(expTipo = 'Animales'), cargarAnimalesExpediente()"
          >
            Animales
          </button>
        </div>
      </div>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col">
          <label for="tipo">Expediente</label>
          <select
            class="form-control input"
            id="tipo"
            v-model="expediente"
            @change="cargarPersonasExpediente(), cargarAnimalesExpediente()"
          >
            <option
              v-for="expediente in expedientes"
              v-bind:key="expediente.ID"
              v-bind:value="expediente.ID"
            >
              {{ expediente.DESCRIPCION }}
            </option>
          </select>
        </div>
      </div>
      <!-- Asignar Personas -->
      <div v-if="expTipo == 'Personas'">
        <div class="row">
          <div class="col">
            <label for="persona">Personas</label>
            <input
              class="form-control input"
              id="persona"
              type="text"
              v-model="query3"
              @keyup="cargarPersonasExpediente()"
            />
          </div>
        </div>

        <div class="row">
          <div class="col">
            <span>Personas asignadas</span>
          </div>
        </div>

        <div
          class="row"
          v-for="(persona2, index) in personas2"
          v-bind:key="index"
          style="width: max-content; margin: auto"
        >
          <div
            class="col"
            style="margin-bottom: 15px; border-bottom: solid; border-width: 2px"
          >
            <label class="labelNombre" style="margin-right: 15px"
              >{{ persona2.NOMBRE }} {{ persona2.APELLIDO1 }}
              {{ persona2.APELLIDO2 }}</label
            >

            <button
              class="btn btn-warning"
              @click="borrarPersonaExpediente(persona2.ID)"
            >
              -
            </button>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <span>Personas Sin Asignar</span>
          </div>
        </div>

        <div
          class="row"
          v-for="(persona22, index) in personas22"
          v-bind:key="index"
          style="width: max-content; margin: auto"
        >
          <div
            class="col"
            style="margin-bottom: 15px; border-bottom: solid; border-width: 2px"
          >
            <label class="labelNombre" style="margin-right: 15px"
              >{{ persona22.NOMBRE }} {{ persona22.APELLIDO1 }}
              {{ persona22.APELLIDO2 }}</label
            >

            <button
              class="btn btn-success"
              @click="(abrirExpPersona = true), (personaExp = persona22.ID)"
            >
              +
            </button>
          </div>
        </div>
      </div>
      <!-- Asignar Animales -->
      <div v-if="expTipo == 'Animales'">
        <div class="row">
          <div class="col">
            <label for="persona">Animales</label>
            <input
              class="form-control input"
              id="persona"
              type="text"
              v-model="query30"
              @keyup="cargarAnimalesExpediente()"
            />
          </div>
        </div>

        <div class="row">
          <div class="col">
            <span>Animales asignados</span>

            <div
              class="row"
              v-for="(animalExp22, index2) in animalesExp"
              v-bind:key="index2"
              style="width: max-content; margin: auto"
            >
              <div
                class="col"
                style="
                  margin-bottom: 15px;
                  border-bottom: solid;
                  border-width: 2px;
                "
              >
                <label class="labelNombre" style="margin-right: 15px">{{
                  animalExp22.NOMBRE
                }}</label>

                <button
                  class="btn btn-warning"
                  @click="borrarAnimalExpediente(animalExp22.ID)"
                >
                  -
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <span>Animales Sin Asignar</span>

            <div
              class="row"
              v-for="(animal, index3) in animalesExp2"
              v-bind:key="index3"
              style="width: max-content; margin: auto"
            >
              <div
                class="col"
                style="
                  margin-bottom: 15px;
                  border-bottom: solid;
                  border-width: 2px;
                "
              >
                <label class="labelNombre" style="margin-right: 15px">{{
                  animal.NOMBRE
                }}</label>

                <button
                  class="btn btn-success"
                  @click="(abrirExpAnimal = true), (animalExp = animal.ID)"
                >
                  +
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- EDITAR ANIMAL -->

    <div class="nuevo panel panel-default" v-if="accion == 'animalE'">
      <button class="botonarriba btn btn-success" @click="cambioF('animalN')">
        Crear Animal
      </button>
      <h2 class="titulo">Editar animal</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="animal">Animal</label>

          <select
            class="form-control input"
            id="tipo"
            v-model="idA"
            @change="buscarA()"
          >
            <option
              v-for="animal in animales"
              v-bind:key="animal.ID"
              v-bind:value="animal.ID"
            >
              {{ animal.NOMBRE }}
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
            id="codigo"
            type="text"
            v-model="codigoA"
            placeholder="Codigo"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="nombre"
            type="text"
            v-model="nombreA"
            placeholder="Nombre"
          />
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm-6">
          <label for="fecha2">Nacimiento</label>
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

        <div class="col-sm">
          <input
            class="form-control input"
            id="chip"
            type="text"
            v-model="chipA"
            placeholder="Chip"
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
            id="alimentacion"
            type="text"
            v-model="alimentacionA"
            placeholder="Alimentacion"
          />
        </div>

        <div class="col-sm">
          <label for="NOTAS">Notas</label>
          <textarea
            class="form-control input"
            name=""
            id="NOTAS"
            cols="30"
            rows="10"
            v-model="notasA"
            placeholder="Notas"
          >
          </textarea>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="razaA">Raza</label>
          <select class="form-control input" id="razaA" v-model="razaA">
            <option v-for="raza in razasA" v-bind:key="raza.ANIMALRAZA">
              {{ raza.ANIMALRAZA }}
            </option>
          </select>
        </div>

        <div class="col-sm">
          <label for="ubiacionA">Ubicación</label>
          <select
            class="form-control input"
            id="ubiacionA"
            v-model="ubicacionA"
          >
            <option
              v-for="ubicacion in ubicacionesA"
              v-bind:key="ubicacion.ANIMALUBICACION"
            >
              {{ ubicacion.ANIMALUBICACION }}
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
          <select class="form-control input" id="tipo" v-model="tipoA">
            <option v-for="tipo in tiposA" v-bind:key="tipo.ANIMALTIPO">
              {{ tipo.ANIMALTIPO }}
            </option>
          </select>
        </div>
        <div class="col-sm">
          <label for="activo">Activo</label>
          <select class="form-control input" id="activo" v-model="activoA">
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
          <label for="tipo">Estado</label>
          <select class="form-control input" id="tipo" v-model="estadoA">
            <option v-for="estado in estadosA" v-bind:key="estado.ANIMALESTADO">
              {{ estado.ANIMALESTADO }}
            </option>
          </select>
        </div>
        <div class="col-sm">
          <label for="campo1">Campo1</label>
          <textarea
            class="form-control input"
            name=""
            id="campo1"
            cols="30"
            rows="10"
            v-model="campo1A"
            placeholder="Campo1"
          >
          </textarea>
        </div>
      </div>

      <div class="row">
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="guardarAnimal()"
        >
          Guardar
        </button>
      </div>
    </div>

    <!-- CREAR PERSONA -->

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
          <label for="NOTAS">Notas</label>
          <textarea
            class="form-control input"
            name=""
            id="NOTAS"
            cols="30"
            rows="10"
            v-model="notas"
            placeholder="Notas"
          >
          </textarea>
        </div>
        <div class="col-sm">
          <label for="campo1">Campo1</label>
          <textarea
            class="form-control input"
            name=""
            id="campo1"
            cols="30"
            rows="10"
            v-model="campo1"
            placeholder="Campo1"
          >
          </textarea>
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
          <label for="documentos">Documentos Operativos</label>
          <select
            class="form-control input"
            id="documentos"
            v-model="documentos4"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="documentos">Documentos Formacion</label>
          <select
            class="form-control input"
            id="documentos"
            v-model="documentos3"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="documentos">Documentos Privados</label>
          <select
            class="form-control input"
            id="documentos"
            v-model="documentos2"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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

        <div class="col-sm">
          <label for="seguimientost">Seguimientos Tipo</label>
          <select
            class="form-control input"
            id="seguimientost"
            v-model="seguimientosT"
          >
            <option selected="selected">GUIA</option>
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
        <div class="col-sm">
          <label for="mantenimiento">Mantenimiento</label>
          <select
            class="form-control input"
            id="mantenimiento"
            v-model="mantenimiento"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
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

    <!-- VARIOS -->

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
          <select
            class="form-control input"
            id="tabla"
            v-model="tabla"
            @change="cargarVarios()"
          >
            <option value="PERSONATIPO">Personas tipo</option>
            <option value="PERSONAORGANIZACION">Organizaciones personas</option>
            <option value="EXPEDIENTETIPO">Nuevo tipo expediente</option>
            <option value="EXPEDIENTEPERSONATIPO">
              Nuevo tipo persona en expedientes
            </option>
            <option value="DOCUMENTOSTIPO">Nuevo tipo de documento</option>
            <option value="EVENTOTIPO">Nuevo tipo de evento</option>
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
      <div class="row" v-for="(vario, index) in varios" v-bind:key="index">
        <div
          class="col"
          style="text-align: initial; margin-left: 20px; margin-bottom: 20px"
        >
          {{ vario[1] }}
          <button class="btn btn-warning" @click="borrarVarios(vario[0])">
            -
          </button>
        </div>
      </div>
    </div>

    <!-- EDITAR PERSONA -->

    <div class="nuevo panel panel-default" v-if="accion == 'personaE'">
      <button class="botonarriba btn btn-success" @click="cambioF('personaN')">
        Crear Persona
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
          <label for="NOTAS">Notas</label>
          <textarea
            class="form-control input"
            name=""
            id="NOTAS"
            cols="30"
            rows="10"
            v-model="notas"
            placeholder="Notas"
          >
          </textarea>
        </div>
        <div class="col-sm">
          <label for="campo1">Campo1</label>
          <textarea
            class="form-control input"
            name=""
            id="campo1"
            cols="30"
            rows="10"
            v-model="campo1"
            placeholder="Campo1"
          >
          </textarea>
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
          <label for="documentos">Documentos Operativos</label>
          <select
            class="form-control input"
            id="documentos"
            v-model="documentos4"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="documentos">Documentos Formacion</label>
          <select
            class="form-control input"
            id="documentos"
            v-model="documentos3"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="documentos">Documentos Privados</label>
          <select
            class="form-control input"
            id="documentos"
            v-model="documentos2"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
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

        <div class="col-sm">
          <label for="seguimientost">Seguimientos Tipo</label>
          <select
            class="form-control input"
            id="seguimientost"
            v-model="seguimientosT"
          >
            <option selected="selected">GUIA</option>
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

        <div class="col-sm">
          <label for="mantenimiento">Mantenimiento</label>
          <select
            class="form-control input"
            id="mantenimiento"
            v-model="mantenimiento"
          >
            <option selected="selected">NO</option>
            <option>SI</option>
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

    <!-- CREAR proveedor -->

    <div class="nuevo panel panel-default" v-if="accion == 'proveedorN'">
      <button
        class="botonarriba btn btn-success"
        @click="cambioF('proveedorE'), cargarProveedores()"
      >
        Editar Proveedor
      </button>
      <h2 class="titulo">Añadir nuevo Proveedor</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <input
            class="form-control input"
            id="nifP"
            type="text"
            v-model="nifP"
            placeholder="NIF"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="nombreP"
            type="text"
            v-model="nombreP"
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
            id="direccionP"
            type="text"
            v-model="direccionP"
            placeholder="Dirección"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="poblacionP"
            type="text"
            v-model="poblacionP"
            placeholder="Población"
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
            id="codigoP"
            type="text"
            v-model="codigoP"
            placeholder="Codigo Postal"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="emailP"
            type="text"
            v-model="emailP"
            placeholder="Email"
          />
        </div>
      </div>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="tipo">Tipo de Gasto Habitual</label>
          <select
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
        </div>
        <div class="col-sm">
          <label for="tipo">TIPO</label>
          <select name="" id="tipo" class="form-control input" v-model="tipoP">
            <option value="1">CLIENTE</option>
            <option value="2">PROVEEDOR</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col">
          <textarea
            name=""
            id="campo1P"
            cols="30"
            rows="10"
            v-model="campo1P"
          ></textarea>
        </div>
      </div>

      <div class="row">
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="guardarProveedor()"
        >
          Guardar
        </button>
      </div>
    </div>

    <!-- EDITAR PROVEEDOR -->

    <div class="nuevo panel panel-default" v-if="accion == 'proveedorE'">
      <button
        class="botonarriba btn btn-success"
        @click="cambioF('proveedorN')"
      >
        Crear Proveedor
      </button>
      <h2 class="titulo">Editar Proveedor</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm-6">
          <label for="plantillaBuc">Buscar Proveedor</label>
          <input
            class="form-control input"
            type="text"
            name=""
            id="plantillaBuc"
            v-model="queryp"
            @keyup="cargarProveedores()"
          />
        </div>
        <div class="col-sm-6">
          <label for="animal">Proveedor</label>

          <select
            class="form-control input"
            id="tipo"
            v-model="idP"
            @change="cargarProveedor()"
          >
            <option
              v-for="proveedor in proveedores"
              v-bind:key="proveedor.ID"
              v-bind:value="proveedor.ID"
            >
              {{ proveedor.CLIENTE }}
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
            id="nifP"
            type="text"
            v-model="nifP"
            placeholder="NIF"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="nombreP"
            type="text"
            v-model="nombreP"
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
            id="direccionP"
            type="text"
            v-model="direccionP"
            placeholder="Dirección"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="poblacionP"
            type="text"
            v-model="poblacionP"
            placeholder="Población"
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
            id="codigoP"
            type="text"
            v-model="codigoP"
            placeholder="Codigo Postal"
          />
        </div>
        <div class="col-sm">
          <input
            class="form-control input"
            id="emailP"
            type="text"
            v-model="emailP"
            placeholder="Email"
          />
        </div>
      </div>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <label for="tipo">Tipo de Gasto Habitual</label>
          <select
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
        </div>
        <div class="col-sm">
          <label for="tipo">TIPO</label>
          <select name="" id="tipo" class="form-control input" v-model="tipoP">
            <option value="1">CLIENTE</option>
            <option value="2">PROVEEDOR</option>
          </select>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col">
          <textarea
            name=""
            id="campo1P"
            cols="30"
            rows="10"
            v-model="campo1P"
          ></textarea>
        </div>
      </div>

      <div class="row">
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="guardarProveedor()"
        >
          Guardar
        </button>
        <button
          id="botonNuevo"
          class="btn btn-success"
          @click="(selectBorrado = 'proveedor'), (borrarConf = true)"
        >
          Eliminar
        </button>
      </div>
    </div>

    <!-- Crear usuario -->
    <div class="nuevo panel panel-default" v-if="accion == 'usuario'">
      <h2 class="titulo">Editar Usuarios</h2>

      <div
        class="row"
        style="margin-bottom: 20px; margin-left: 10px; margin-right: 10px"
      >
        <div class="col-sm">
          <input
            class="form-control input"
            id="buscar"
            type="text"
            v-model="query5"
            @keyup="personasF2()"
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
            v-model="persona3"
            @change="cargarUsuario()"
          >
            <option
              v-for="persona in personas3"
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
        <div class="col-sm-6">
          <label for="usuario">Usuario</label>
          <input id="usuario" type="text" v-model="usuario" />
        </div>
        <div class="col-sm-6">
          <label for="password">Contraseña</label>
          <input id="password" type="text" v-model="password" />
        </div>
      </div>
      <div class="row">
        <div class="col">
          <button class="btn btn-success" @click="guardarUsuario()">
            Actualizar
          </button>
        </div>
      </div>
    </div>

    <!-- Confirmar borrado -->

    <div id="ocultoNuevo" v-if="borrarConf == true">
      <div id="cajaSeguimientoNuevo" class="panel panel-default">
        <div class="row">
          <div class="col">
            ¿Está seguro de que desea borrar este elemento definitivamente?
          </div>
        </div>
        <div class="row">
          <div class="col">
            <button class="btn" @click="(borrarConf = false), borrar()">
              SI
            </button>
          </div>
          <div class="col">
            <button class="btn" @click="borrarConf = false">NO</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapState, mapGetters } from "vuex";
import Datepicker from "vuejs-datepicker";

export default {
  name: "adminC",
  components: {
    Datepicker,
  },
  computed: {
    ...mapState(["persona"]),
  },
  data() {
    return {
      idUsuario: this.$store.getters.sacarid,
      accion: "personaN",
      admin: "NO",
      alertas: "VER",
      alertasV: "PROPIOS",
      eventos: "VER",
      documentos: "VER",
      documentos2: "NO",
      documentos3: "NO",
      documentos4: "NO",
      seguimientos: "PROPIOS",
      seguimientosT: "GUIA",
      facturas: "NINGUNO",
      mantenimiento: "NO",
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
      codigoA: "",
      nombreA: "",
      razaA: "",
      chipA: "",
      nacimientoA: "",
      ubicacionA: "",
      notasA: "",
      alimentacionA: "",
      tipoA: "",
      campo1A: "",
      estadoA: "",
      activoA: "",
      razasA: "",
      tiposA: "",
      estadosA: "",
      ubicacionesA: "",
      idA: "",
      animales: "",
      fecha2: "",
      trackedDate: new Date().toISOString().substr(0, 10),

      query3: "",
      persona2: "",
      personas2: "",
      persona22: "",
      personas22: "",
      checkedNames: [],
      personasIDLista: [],
      i: 0,
      todos: false,

      query4: "",
      animal2: "",
      animales2: "",
      checkedNames2: [],
      animalesIDLista: [],
      i2: 0,
      todos2: false,

      expedientes: "",
      expediente: "0",

      tipoExpPersonaLista: "",
      tipoExpPersona: "",

      idE: "",
      codigoE: "",
      descripcionE: "",
      localizacionE: "",
      tipoE: "",
      tiposE: "",
      estadoE: "",
      notasE: "",
      campo1E: "",
      activoE: "",

      queryE: "",

      abrirExpPersona: false,
      notaPersonaExp: "",
      tipoPersonaExp: "",
      personaExp: "",

      abrirExpAnimal: false,
      notaAnimalExp: "",
      tipoAnimalExp: "",
      estadoAnimalExp: "",
      animalExp: "",
      query30: "",
      animalesExp: "",
      animalesExp2: "",

      expTipo: "Personas",

      nifP: "",
      nombreP: "",
      direccionP: "",
      poblacionP: "",
      codigoP: "",
      emailP: "",
      tipoG2: "",
      tipoP: "",
      campo1P: "",
      proveedores: "",

      query5: "",

      persona3: "",
      personas3: "",
      usuario: "",
      password: "",
      idloggin: 0,
      queryp: "",
      selectBorrado: "",
      borrarConf: false,
      varios: "",
    };
  },
  methods: {
    ...mapGetters(["sacarid"]),

    añadirAnimalExp() {
      this.abrirExpAnimal = false;

      axios
        .post("php/añadirAnimalExp.php", {
          exp: this.expediente,
          persona: this.animalExp,
          tipo: this.tipoAnimalExp,
          notas: this.notaAnimalExp,
          estado: this.estadoAnimalExp,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.notaAnimalExp = "";
          this.tipoAnimalExp = "";
          this.estadoAnimalExp = "";
          this.animalExp = "";
          this.cargarAnimalesExpediente();
        });
    },

    guardarProveedor() {
      axios
        .post("php/guardarProveedor.php", {
          id: this.idP,
          nif: this.nifP,
          nombre: this.nombreP,
          direccion: this.direccionP,
          poblacion: this.poblacionP,
          postal: this.codigoP,
          mail: this.emailP,
          tipoG2: this.tipoG2,
          tipo: this.tipoP,
          campo1: this.campo1P,
          campo2: "",
          campo3: "",
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.nifP = "";
          this.nombreP = "";
          this.direccionP = "";
          this.poblacionP = "";
          this.codigoP = "";
          this.emailP = "";
          this.tipoG2 = "";
          this.tipoP = "";
          this.campo1P = "";
          this.idP = 0;
        });
    },
    cargarProveedor() {
      axios
        .post("php/cargarProveedor.php", {
          id: this.idP,
        })
        .then((response) => {
          this.nifP = response.data[0][1];
          this.nombreP = response.data[0][2];
          this.direccionP = response.data[0][3];
          this.poblacionP = response.data[0][4];
          this.codigoP = response.data[0][5];
          this.emailP = response.data[0][6];
          this.tipoG2 = response.data[0][8];
          this.tipoP = response.data[0][7];
          this.campo1P = response.data[0][10];
        });
    },
    cargarProveedores() {
      axios
        .post("php/proveedores.php", {
          query2: this.queryp,
        })
        .then((response) => {
          this.proveedores = response.data;
        });
    },

    añadirPersonaExp() {
      this.abrirExpPersona = false;

      axios
        .post("php/añadirPersonaExp.php", {
          exp: this.expediente,
          persona: this.personaExp,
          tipo: this.tipoPersonaExp,
          notas: this.notaPersonaExp,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.notaPersonaExp = "";
          this.tipoPersonaExp = "";
          this.personaExp = "";
          this.cargarPersonasExpediente();
        });
    },

    cargarExpedientes: function () {
      axios
        .post("php/expedientesFULL.php", {
          query: this.queryE,
        })
        .then((response) => {
          this.expedientes = response.data;
        });
    },

    cargarTipoExpPersonaLista: function () {
      axios.post("php/tipoExpPersonaLista.php", {}).then((response) => {
        this.tipoExpPersonaLista = response.data;
      });
    },
    cargarTipoExp: function () {
      axios.post("php/tipoExp.php", {}).then((response) => {
        this.tiposE = response.data;
      });
    },

    personasID(todos) {
      if (!todos) {
        for (this.i = 0; this.i < this.personas2.length; this.i++) {
          this.personasIDLista[this.i] = this.personas2[this.i][0];
        }
        this.checkedNames = this.personasIDLista;
      } else {
        this.personasIDLista = [];
        this.checkedNames = this.personasIDLista;
      }
    },
    cargarPersonasExpediente: function () {
      axios
        .post("php/listaPersonasExpediente.php", {
          query: this.query3,
          exp: this.expediente,
        })
        .then((response) => {
          this.personas2 = response.data;

          axios
            .post("php/listaPersonasNOExpediente.php", {
              query: this.query3,
              exp: this.expediente,
            })
            .then((response) => {
              this.personas22 = response.data;
            });
        });
    },
    borrarPersonaExpediente(aux) {
      axios
        .post("php/borrarPersonaExp.php", {
          persona: aux,
          exp: this.expediente,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.cargarPersonasExpediente();
        });
    },
    cargarAnimalesExpediente: function () {
      axios
        .post("php/listaAnimalesExpediente.php", {
          query: this.query30,
          exp: this.expediente,
        })
        .then((response) => {
          this.animalesExp = response.data;

          axios
            .post("php/listaAnimalesNOExpediente.php", {
              query: this.query30,
              exp: this.expediente,
            })
            .then((response) => {
              this.animalesExp2 = response.data;
              console.log(this.animalesExp2);
            });
        });
    },
    borrarAnimalExpediente(aux) {
      axios
        .post("php/borrarAnimalExp.php", {
          animal: aux,
          exp: this.expediente,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.cargarAnimalesExpediente();
        });
    },

    animalesID(todos2) {
      if (!todos2) {
        for (this.i2 = 0; this.i2 < this.animales2.length; this.i2++) {
          this.animalesIDLista[this.i2] = this.animales2[this.i2][0];
        }
        this.checkedNames2 = this.animalesIDLista;
      } else {
        this.animalesIDLista = [];
        this.checkedNames2 = this.animalesIDLista;
      }
    },
    cargaranimales: function () {
      axios
        .post("php/listaAnimales.php", {
          query: this.query3,
        })
        .then((response) => {
          this.animales2 = response.data;
        });
    },

    formatPicker: function () {
      var self = this;
      var d = new Date(self.trackedDate);
      self.nacimientoA =
        d.getUTCFullYear() + "-" + (d.getUTCMonth() + 1) + "-" + d.getUTCDate();
    },

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
          this.cargarVarios();
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
          this.cargarVarios();
        });
    },
    buscarA() {
      axios
        .post("php/animalFull.php", {
          query: this.idA,
        })
        .then((response) => {
          this.codigoA = response.data[0][1];
          this.nombreA = response.data[0][2];
          this.razaA = response.data[0][3];
          this.chipA = response.data[0][4];
          this.trackedDate = response.data[0][5];
          this.ubicacionA = response.data[0][6];
          this.notasA = response.data[0][7];
          this.alimentacionA = response.data[0][8];
          this.tipoA = response.data[0][9];
          this.campo1A = response.data[0][10];
          this.estadoA = response.data[0][13];
          this.activoA = response.data[0][14];
        });
    },
    buscarE() {
      axios
        .post("php/expedienteFull.php", {
          query: this.idE,
        })
        .then((response) => {
          this.codigoE = response.data[0][1];
          this.descripcionE = response.data[0][2];
          this.localizacionE = response.data[0][3];
          this.trackedDate = response.data[0][4];
          this.tipoE = response.data[0][6];
          this.estadoE = response.data[0][7];
          this.notasE = response.data[0][8];
          this.campo1E = response.data[0][9];
          this.activoE = response.data[0][12];
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
            this.seguimientosT = response.data[0][12];
            this.facturas = response.data[0][7];
            this.documentos2 = response.data[0][8];
            this.documentos3 = response.data[0][9];
            this.documentos4 = response.data[0][10];
            this.mantenimiento = response.data[0][11];

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
            this.seguimientosT = "GUIA";
            this.facturas = "NINGUNO";
            this.mantenimiento = "NO";
            this.documentos2 = "NO";
            this.documentos3 = "NO";
            this.documentos4 = "NO";
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
    personasF2() {
      axios
        .post("php/listaPersonas.php", {
          query: this.query5,
        })
        .then((response) => {
          this.personas3 = response.data;
        });
    },
    cargarUsuario() {
      axios
        .post("php/cargarUsuario.php", {
          query: this.persona3,
        })
        .then((response) => {
          this.usuario = response.data[0][0];
          this.password = response.data[0][1];
          this.idloggin = response.data[0][2];
        });
    },

    guardarUsuario() {
      axios
        .post("php/actualizaCredenciales.php", {
          persona: this.persona3,
          usuario: this.usuario,
          contraseña: this.password,
          id: this.idloggin,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.usuario = "";
          this.password = "";
          this.idloggin = "";
        });
    },
    animalesF() {
      axios.post("php/animalesListaFull.php", {}).then((response) => {
        this.animales = response.data;
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
          documentos2: this.documentos2,
          documentos3: this.documentos3,
          documentos4: this.documentos4,
          seguimientos: this.seguimientos,
          seguimientosT: this.seguimientosT,
          facturas: this.facturas,
          mantenimiento: this.mantenimiento,
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
    AnimalTipos() {
      axios.post("php/tiposAnimales.php", {}).then((response) => {
        this.tiposA = response.data;
      });
    },
    AnimalRazas() {
      axios.post("php/razas.php", {}).then((response) => {
        this.razasA = response.data;
      });
    },
    AnimalEstados() {
      axios.post("php/EstadosAnimales.php", {}).then((response) => {
        this.estadosA = response.data;
      });
    },
    AnimalUbicaciones() {
      axios.post("php/ubicacionesAnimales.php", {}).then((response) => {
        this.ubicacionesA = response.data;
      });
    },
    guardarAnimal() {
      axios
        .post("php/guardarAnimal.php", {
          id: this.idA,
          codigoA: this.codigoA,
          nombreA: this.nombreA,
          nacimientoA: this.nacimientoA,
          chipA: this.chipA,
          alimentacionA: this.alimentacionA,
          notasA: this.notasA,
          razaA: this.razaA,
          ubicacionA: this.ubicacionA,
          tipoA: this.tipoA,
          activoA: this.activoA,
          estadoA: this.estadoA,
          campo1A: this.campo1A,
        })
        .then((response) => {
          this.idA = "";
          this.codigoA = "";
          this.nombreA = "";
          this.trackedDate = "";
          this.chipA = "";
          this.alimentacionA = "";
          this.notasA = "";
          this.razaA = "";
          this.ubicacionA = "";
          this.tipoA = "";
          this.activoA = "";
          this.estadoA = "";
          this.campo1A = "";
          this.cargaranimales();

          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
        });
    },
    guardarExpediente() {
      axios
        .post("php/guardarExpediente.php", {
          id: this.idE,
          codigoE: this.codigoE,
          descripcionE: this.descripcionE,
          localizacionE: this.localizacionE,
          tipoE: this.tipoE,
          estadoE: this.estadoE,
          notasE: this.notasE,
          campo1E: this.campo1E,
          activoE: this.activoE,
          fecha: this.nacimientoA,
        })
        .then((response) => {
          this.idE = "";
          this.codigoE = "";
          this.descripcionE = "";
          this.localizacionE = "";
          this.tipoE = "";
          this.estadoE = "";
          this.notasE = "";
          this.campo1E = "";
          this.activoE = "";
          this.trackedDate = "";
          this.cargarExpedientes();

          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
        });
    },

    borrar() {
      if (this.selectBorrado == "proveedor") {
        axios
          .post("php/borrarElemento.php", {
            id: this.idP,
            tabla: "PROVEEDORES",
          })
          .then((response) => {
            this.$notify({
              group: "foo",
              title: response.data,
              type: "success",
            });
            this.cargarProveedores();
          });
      }
    },
    cargarVarios() {
      axios
        .post("php/cargarVarios.php", {
          tabla: this.tabla,
        })
        .then((response) => {
          this.varios = response.data;
        });
    },
    borrarVarios(aux) {
      axios
        .post("php/borrarElemento.php", {
          id: aux,
          tabla: this.tabla,
        })
        .then((response) => {
          this.$notify({
            group: "foo",
            title: response.data,
            type: "success",
          });
          this.cargarVarios();
        });
    },
  },
  created: function () {
    this.cargarVarios();
    this.organizacionesF();
    this.tiposF();
    this.personasF();
    this.personasF2();
    this.animalesF();
    this.AnimalRazas();
    this.AnimalEstados();
    this.AnimalUbicaciones();
    this.AnimalTipos();
    this.cargarPersonasExpediente();
    this.cargarAnimalesExpediente();
    this.cargaranimales();
    this.cargarExpedientes();
    this.cargarTipoExpPersonaLista();
    this.cargarTipoExp();
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