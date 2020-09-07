<template>
  <div id="documentosC">
    <h1>documentos</h1>
    <h2>{{subtitulo}}</h2>
    <ul id="bucleFor">
      <li v-for="(serie, index) in series" v-bind:key="index">
        nombre: {{ serie.nombre }}
        Temporadas: {{ serie.temporadas }}
        Capitulos: {{ serie.capitulos }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "documentosC",
  data() {
    return {
      subtitulo: "Ejemplo de texto",
      series: [
        { nombre: "One punch man", temporadas: 2, capitulos: 36 },
        { nombre: "No game no life", temporadas: 1, capitulos: 24 },
        { nombre: "Konosuba", temporadas: 2, capitulos: 24 },
        { nombre: "Re:Zero", temporadas: 2, capitulos: 30 },
        { nombre: "Boku no Hero", temporadas: 5, capitulos: 120 },
      ],
    };
  },
};
</script>