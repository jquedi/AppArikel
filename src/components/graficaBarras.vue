<script>
import { Line } from "vue-chartjs";
import axios from "axios";

export default {
  extends: Line,
  mounted() {
    this.cargarDatos();
  },
  props: {
    parentData: String,
  },
  data() {
    return {
      titulos: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      colores: "",
      data: [],
      data2: [],
      data3: [],
      total: "",
      total1: 0,
      total2: 0,
      total3: 0,
      i: 0,
      gradient: null,
      gradient2: null,
    };
  },
  watch: {
    // whenever question changes, this function will run

    parentData: function () {
      this.cargarDatos();
    },
  },
  methods: {
    cargarDatos() {
      this.total = "";
      this.total1 = 0;
      this.total2 = 0;
      this.total3 = 0;
      axios
        .post("php/ingresosAño.php", {
          tipo: 2,
          año: this.parentData,
        })
        .then((response) => {
          this.data = response.data;

          axios
            .post("php/ingresosAño.php", {
              tipo: 1,
              año: this.parentData,
            })
            .then((response) => {
              this.data2 = response.data;

              for (this.i = 0; this.i < 12; this.i++) {
                this.data3[this.i] = this.data2[this.i] - this.data[this.i];

                if (this.data[this.i] == null) {
                  this.total1 = this.total1 + 0;
                } else {
                  this.total1 = this.total1 + parseInt(this.data[this.i], 10);
                }
                if (this.data2[this.i] == null) {
                  this.total2 = this.total2 + 0;
                } else {
                  this.total2 = this.total2 + parseInt(this.data2[this.i], 10);
                }
                if (this.data3[this.i] == null) {
                  this.total3 = this.total3 + 0;
                } else {
                  this.total3 = this.total3 + parseInt(this.data3[this.i], 10);
                }
              }

              this.total = this.total1 + "/" + this.total2 + "/" + this.total3

              this.$emit("inputData", this.total);

              console.log(this.data);
              console.log(this.data2);
              console.log(this.data3);

              this.gradient = this.$refs.canvas
                .getContext("2d")
                .createLinearGradient(0, 0, 0, 450);
              this.gradient2 = this.$refs.canvas
                .getContext("2d")
                .createLinearGradient(0, 0, 0, 450);

              this.gradient.addColorStop(0, "rgba(255, 0,0, 0.5)");
              this.gradient.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
              this.gradient.addColorStop(1, "rgba(255, 0, 0, 0)");

              this.gradient2.addColorStop(0, "rgba(0, 231, 255, 0.9)");
              this.gradient2.addColorStop(0.5, "rgba(0, 231, 255, 0.25)");
              this.gradient2.addColorStop(1, "rgba(0, 231, 255, 0)");

              this.gradient3 = this.$refs.canvas
                .getContext("2d")
                .createLinearGradient(0, 0, 0, 450);

              this.gradient3.addColorStop(0, "rgba(0, 255,0, 0.5)");
              this.gradient3.addColorStop(0.5, "rgba(0, 255, 0, 0.25)");
              this.gradient3.addColorStop(1, "rgba(0, 255, 0, 0)");

              this.renderChart(
                {
                  labels: this.titulos,
                  datasets: [
                    {
                      label: "Gastos",
                      borderColor: "#FC2525",
                      pointBackgroundColor: "white",
                      borderWidth: 1,
                      pointBorderColor: "white",
                      backgroundColor: this.gradient,
                      data: this.data,
                    },
                    {
                      label: "Ingresos",
                      borderColor: "#05CBE1",
                      pointBackgroundColor: "white",
                      pointBorderColor: "white",
                      borderWidth: 1,
                      backgroundColor: this.gradient2,
                      data: this.data2,
                    },
                    {
                      label: "Ganancias",
                      borderColor: "#80f7b0",
                      pointBackgroundColor: "white",
                      pointBorderColor: "white",
                      borderWidth: 1,
                      backgroundColor: this.gradient3,
                      data: this.data3,
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
