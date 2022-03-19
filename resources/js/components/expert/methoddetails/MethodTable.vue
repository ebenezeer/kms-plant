<template>
  <div>
    <router-link class="btn btn-primary" to="/expert/method-details/create"
      >Create</router-link
    >
    <br />
    <br />
    <table
      id="meth-table"
      class="table table-bordered table-striped table-sm dataTable"
    >
      <thead class="table-dark">
        <tr>
          <th>Id</th>
          <th>Plant</th>
          <th>Variety</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(pm, index) in plant_meth">
          <tr>
            <td>{{ pm.id }}</td>
            <td>
              {{ pm.name }}<br />
              <small>{{ pm.description }}</small>
            </td>
            <td>{{ pm.variety }}</td>

            <td>
              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-success btn-sm"
                  @click="viewMet(pm.id)"
                >
                  <i class="fa fa-vcard"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-danger btn-sm"
                  @click="deleteMet(pm.id)"
                >
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
    <!-- MODAL UPDATE -->
    <div class="modal fade" tabindex="-1" role="dialog" id="update_unit_model">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Update</h4>
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
              <v-select
                ref="select"
                label="name"
                placeholder="Select Plant Name"
                v-model="update_meth.name_id"
                :options="plant_names"
                :reduce="(plant_names) => plant_names.id"
              >
              </v-select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Update</button>
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
export default {
  data() {
    return {
      plant_meth: [],
      plant_names: [],
      update_meth: {},
      errors: [],
    };
  },
  mounted() {
    this.getPlantNames();
  },
  created() {
    window.axios.get("/expert/plant-methods").then(({ data }) => {
      this.plant_meth = data;
      //this.dataTab();
    });
  },
  methods: {
    initUpdate(index) {
      this.errors = [];
      $("#update_unit_model").modal("show");
      this.update_meth = this.plant_meth[index];
      setTimeout(() => {
        console.log(this.update_meth);
      }, 600);
    },
    getPlantNames() {
      window.axios.get("/expert/get-plant-names").then(({ data }) => {
        this.plant_names = data;
      });
    },
    viewMet(val) {
      this.$router.push({ path: `/expert/method-details/${val}/view` });
    },
    readmeths() {
      window.axios.get("/expert/plant-methods").then(({ data }) => {
        this.plant_meth = data;
        //this.dataTab();
      });
    },
    deleteMet(a) {
      Swal.fire({
        title: "Are you sure?",
        text: "You can't revert your action",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes Delete it!",
        cancelButtonText: "No, I" + "'" + "ve change my mind!",
        showCloseButton: true,
        showLoaderOnConfirm: true,
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/expert/plant-methods/" + a)
            .then((response) => {
              this.readmeths();
              Swal.fire({
                icon: "success",
                title: "Deleted",
                text: "I will close in 2 seconds.",
                timer: 2000,
              });
            })
            .catch((error) => {});
        }
        // else {
        //   this.$swal('Cancelled', 'Your data is still intact', 'info')
        // }
      });
    },

    methhhh(val) {
      this.$router.push({ path: `/met/${val}/create` });
    },
  },
};
</script>

<style scoped>
</style>
