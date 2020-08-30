<template>
  <div id="menu1">
    <ul>
      <li>
        <button id="seguimientos" @click="show = !show">{{opcion1}}</button>
      </li>
      <li>
        <button id="documentos">{{opcion2}}</button>
      </li>
      <li>
        <button id="eventos">{{opcion3}}</button>
      </li>
      <li>
        <button id="desconectar">{{opcion4}}</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "menu1",
  props: {
    show: Boolean,
  },
  data() {
    return {
      opcion1: "Seguimientos",
      opcion2: "Documentos",
      opcion3: "Eventos",
      opcion4: "Desconectar",
    };
  },
};
</script>
<style>
ul {
  height: 100%;
  margin: 0;
  width: 40%;
  padding: 0;
  background: aquamarine;
}
li {
  list-style-type: none;
  position: inherit;
  height: 25%;
  margin-left: 0px;
}
button {
  background: none;
  border: none;
  font-size: inherit;
  font-weight: 900;
  cursor: pointer;
  width: 100%;
}
#menu1 {
  position: fixed;
  top: 0px;
  left: 0px;
  z-index: 3000;
  width: 100%;
  height: 100%;
}
#seguimientos {
  top: 80%;
  position: relative;
  left: 0%;
}
#documentos {
  top: 40%;
  position: relative;
  left: 0%;
}
#eventos {
  top: 0%;
  position: relative;
  left: 0%;
}
#desconectar {
  position: relative;
  top: 70%;
  left: 0%;
}
</style>