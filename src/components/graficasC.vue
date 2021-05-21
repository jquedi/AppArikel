<template>
  <div id="app">
    <div class="row">
      <div class="col-sm-6">
        <label for="año">Año</label>
        <input id="año" type="number" v-model="myData.año" placeholder="2020" />
      </div>
      <div class="col-sm-6">
        <label for="mes">Mes</label>
        <select name="" id="mes" v-model="myData.mes">
          <option value="01">Enero</option>
          <option value="02">Febrero</option>
          <option value="03">Marzo</option>
          <option value="04">Abril</option>
          <option value="05">Mayo</option>
          <option value="06">Junio</option>
          <option value="07">Julio</option>
          <option value="08">Agosto</option>
          <option value="09">Septiembre</option>
          <option value="10">Octubre</option>
          <option value="11">Noviembre</option>
          <option value="12">Diciembre</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col">
          <h1>AÑO {{myData.año}}</h1>
        <BarChart :parentData="myData.año" @inputData="updateMessage3" />
        <div class="row" style="margin-bottom: 50px;">
          <div class="col"><strong>Total gastos: </strong> {{ total3 }}</div>
          <div class="col"><strong>Total ingresos: </strong> {{ total4 }}</div>
          <div class="col"><strong>Total ganancias: </strong> {{ total5 }}</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <h1>INGRESOS MES {{myData.mes}} DE {{myData.año}}</h1>
        <BarChart2
          :parentData="myData.mes"
          :parentData2="myData.año"
          @inputData="updateMessage1"
        />
        <div class="row" v-if="total1 != 0">
          <div class="col"><strong>Total: </strong> {{ total1 }}</div>
        </div>
      </div>
      <div class="col-md-6">
          <h1>GASTOS MES {{myData.mes}} DE {{myData.año}}</h1>
        <BarChart3
          :parentData="myData.mes"
          :parentData2="myData.año"
          @inputData="updateMessage2"
        />
        <div class="row" v-if="total2 != 0">
          <div class="col"><strong>Total: </strong> {{ total2 }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BarChart from "@/components/graficaBarras.vue";
import BarChart2 from "@/components/graficaBarras2.vue";
import BarChart3 from "@/components/graficaBarras3.vue";

export default {
  name: "App",
  components: {
    BarChart,
    BarChart2,
    BarChart3,
  },
  data() {
    return {
      myData: {
        mes: new Date().toISOString().substr(5, 2),
        año: new Date().toISOString().substr(0, 4),
      },
      total1: 0,
      total2: 0,
      total3: 0,
      total4: 0,
      total5: 0,
      total6: "",
    };
  },
  methods: {
    updateMessage1(variable) {
      this.total1 = variable;
    },
    updateMessage2(variable) {
      this.total2 = variable;
    },
    updateMessage3(variable) {
      this.total6 = variable;
      this.total6 = this.total6.split('/');
      this.total3 = this.total6[0];
      this.total4 = this.total6[1];
      this.total5 = this.total6[2];
    },
  },
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  overflow: hidden;
}
</style>