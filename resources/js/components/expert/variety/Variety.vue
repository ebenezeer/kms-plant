<template>
  <div class="col-md-12">
    <h2>
      {{ $route.name }}
      <button @click="initAddunit" class="btn btn-primary btn-sm float-right">
        + Add Plant Variety
      </button>
    </h2>
    <hr />
    <div class="table-responsive" id="table">
      <table
        id="unit-table"
        class="table table-bordered table-hover table-sm"
        width="98%"
        v-if="units.length > 0"
      >
        <thead>
          <tr>
            <th>Ref #</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(unit, index) in units">
            <tr :key="index">
              <td>{{ unit.id }}</td>
              <td>
                {{ unit.description }}
              </td>
              <td>
                <div class="btn-group">
                  <button
                    @click="initUpdate(index)"
                    class="btn btn-success btn-sm"
                    title="update"
                  >
                    <i class="fa fa-edit"></i>
                  </button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>

      <div class="alert alert-info" v-else>
        <strong>Info!</strong> No registered Variety.
      </div>
    </div>

    <!-- ADD MODAL -->
    <div class="modal fade" id="add_unit_model">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Plant Variety</h4>
            <button type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <strong> Whoops, looks like something went wrong...</strong>
              <ul>
                <template v-for="(error, index) in errors">
                  <li :key="index">{{ error }}</li>
                </template>
              </ul>
            </div>
            <div class="form-group">
              <label for="name">Plant Variety:</label>
              <input
                type="text"
                name="description"
                id="description"
                placeholder="Plant Variety"
                ref="addunit"
                class="form-control"
                v-on:keyup.enter="createunit"
                v-model="unit.description"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click="createunit" class="btn btn-primary">
              Submit
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- END ADD MODAL -->

    <!-- MODAL UPDATE -->
    <div class="modal fade" tabindex="-1" role="dialog" id="update_unit_model">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Update Variety</h4>
            <button type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <strong> Whoops, looks like something went wrong...</strong>
              <ul>
                <template v-for="(error, index) in errors">
                  <li :key="index">{{ error }}</li>
                </template>
              </ul>
            </div>

            <div class="form-group">
              <label for="name">Description:</label>
              <input
                type="text"
                ref="updateunit"
                name="description"
                id="description"
                placeholder="Plant name"
                class="form-control"
                v-on:keyup.enter="updateunit"
                v-model="update_unit.description"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click="updateunit" class="btn btn-primary">
              Update
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
    <!--END UPDATE MODAL-->
  </div>
</template>
 
<script>
import Swal from "sweetalert2/dist/sweetalert2.js";
//import VueFeather from "vue-feather";

export default {
  data() {
    return {
      unit: {
        description: "",
      },
      errors: [],
      units: [],
      update_unit: {},
    };
  },
  mounted() {},

  created() {
    window.axios.get("/expert/plant-variety").then(({ data }) => {
      this.units = data;
      //this.dataTab();
    });
  },
  methods: {
    initAddunit() {
      this.errors = [];
      this.reset();
      $("#add_unit_model").modal("show");
      setTimeout(() => {
        this.$refs.addunit.focus();
      }, 600);
    },
    initUpdate(index) {
      this.errors = [];
      $("#update_unit_model").modal("show");
      this.update_unit = this.units[index];
      setTimeout(() => {
        this.$refs.updateunit.focus();
        this.$refs.updateunit.select();
      }, 600);
    },
    createunit() {
      axios
        .post("/expert/plant-variety", {
          description: this.unit.description,
        })
        .then((response) => {
          this.reset();

          Swal.fire({
            title: "Success!",
            text: response.data.message,
            icon: "success",
            text: "I will close in 2 seconds.",
            timer: 2000,
          });

          $("#add_unit_model").modal("hide");
          this.readunits();
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.description) {
            this.errors.push(error.response.data.errors.description[0]);
          }
        });
    },
    updateunit() {
      axios
        .patch("/expert/plant-variety/" + this.update_unit.id, {
          description: this.update_unit.description,
        })
        .then((response) => {
          $("#update_unit_model").modal("hide");

          Swal.fire({
            title: "Success!",
            text: response.data.message,
            icon: "success",
            text: "I will close in 2 seconds.",
            timer: 2000,
          });
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.description) {
            this.errors.push(error.response.data.errors.description[0]);
          }
        });
    },

    reset() {
      this.unit.description = "";
    },
    readunits() {
      axios.get("/expert/plant-variety").then(({ data }) => {
        this.units = data;
      });
    },
    dataTab() {
      $(function () {
        $("#unit-table").DataTable({
          dom:
            "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'rt>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          responsive: true,
          autoWidth: false,
          dataSrc: "Data",
          iDisplayLength: 10,
          buttons: [
            {
              extend: "excelHtml5",
              messageTop: "Mariano Marcos State University",
              exportOptions: {
                columns: ":visible",
              },
              className: "btn btn-outline-success btn-sm",
            },
            {
              extend: "pdfHtml5",
              messageTop: "Mariano Marcos State University",
              exportOptions: {
                columns: ":visible",
              },
              className: "btn btn-outline-danger btn-sm",
            },
            {
              extend: "colvis",
              className: "btn btn-outline-primary btn-sm",
            },
          ],

          processing: true,

          columnDefs: [{ responsivePriority: 0, targets: 2 }],
        });
      });
    },
  },
};
</script>