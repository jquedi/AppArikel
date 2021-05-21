<template>
  <div class="alertas">
    <alertasC></alertasC>
  </div>
</template>

<script>
import alertasC from "@/components/alertasC.vue";

export default {
  name: "alertas",
  components: {
    alertasC,
  },
  created() {
    console.log("la store esta asi", this.$store.state);
  },
};
</script>