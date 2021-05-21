<script>
import { Pie } from "vue-chartjs";
import axios from "axios";

export default {
  extends: Pie,
  mounted() {
    this.cargarDatos();
  },
  props: {
    parentData: String,
    parentData2: String,
  },
  data() {
    return {
      titulos: "",
      colores: "",
      data: "",
      i: 0,
      total: 0,
    };
  },
  watch: {
    parentData: function () {
      this.cargarDatos();
    },
    parentData2: function () {
      this.cargarDatos();
    },
  },
  methods: {
    cargarDatos() {
      this.data = "";
      this.total = 0;
      axios.post("php/tiposIngresos.php", {}).then((response) => {
        this.titulos = response.data;

        axios
          .post("php/ingresosPorTipos.php", {
            tipo: this.titulos,
            tipo2: 2,
            mes: this.parentData,
            año: this.parentData2,
          })
          .then((response) => {
            this.data = response.data;

            if (this.data != "") {
              for (this.i = 0; this.i < this.data.length; this.i++) {
                if (this.data[this.i] == null) {
                  this.total = this.total + 0;
                } else {
                  this.total = this.total + parseInt(this.data[this.i], 10);
                }
              }
            } else {
              this.total = 0;
            }

            this.$emit("inputData", this.total);

            this.colores = [];
            for (this.i = 0; this.i < this.titulos.length; this.i++) {
              var g = Math.floor(Math.random() * 125);
              var b = Math.floor(Math.random() * 125);

              var dynamicColors = "rgb(255," + g + "," + b + ")";

              this.colores[this.i] = dynamicColors;
            }

            console.log("colores", this.colores);

            console.log(this.titulos);
            console.log(this.data);

            this.renderChart(
              {
                labels: this.titulos,
                datasets: [
                  {
                    backgroundColor: this.colores,
                    data: this.data,
                  },
                ],
              },
              { responsive: true, maintainAspectRatio: false }
            );
          });
      });
    },
  },
};
</script>