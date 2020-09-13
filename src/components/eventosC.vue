<template>
  <div id="eventosC">
    <h1>eventos</h1>
    <h2>{{subtitulo}}</h2>
    <ul id="bucleFor">
      <li v-for="item of persona" v-bind:key="item.id">
        Temporadas: {{ persona[0].id }}
      </li>
    </ul>
  </div>
</template>

<script>
import {mapState, mapMutations} from "vuex";
export default {
  name: "eventosC",
  computed: {
    ...mapState(["persona"]),
  },
  methods: {
    ...mapMutations(['modificar'])
  },
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