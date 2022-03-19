<template>
  <div>
    <router-link class="btn btn-primary" to="/expert/plant-detail/create"
      >Create</router-link
    >

    <table
      id="meth-table"
      class="table table-bordered table-striped table-sm dataTable"
      style="margin-top: 15px"
    >
      <thead class="table-dark">
        <tr>
          <th>Id</th>
          <th>Plant</th>
          <th>Variety</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(pm, index) in plant_meth">
          <tr>
            <td>{{ pm.id }}</td>
            <td>{{ pm.name }}</td>
            <td>{{ pm.variety }}</td>
            <td>{{ pm.description }}</td>
            <td>
              <button
                type="button"
                class="btn btn-success btn-sm"
                @click="initUpdate(index)"
              >
                <i class="fa fa-edit"></i>
              </button>
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
              <label for="name">Variety:</label>
              <v-select
                ref="select"
                label="description"
                placeholder="Select Plant Name"
                v-model="update_det.variety_id"
                :options="varieties"
                :reduce="(varieties) => varieties.id"
              >
              </v-select>
            </div>
            <div class="form-group">
              <label for="name">Description:</label>
              <textarea
                class="form-control"
                rows="5"
                id="upcomment"
                v-model="update_det.description"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="updateDet">
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
export default {
  data() {
    return {
      plant_meth: [],
      plant_names: [],
      varieties: [],
      update_det: {},
      errors: [],
    };
  },
  mounted() {
    this.getVarieties();
  },
  created() {
    window.axios.get("/expert/plant-details").then(({ data }) => {
      this.plant_meth = data;
      //this.dataTab();
    });
  },
  methods: {
    initUpdate(index) {
      this.errors = [];
      $("#update_unit_model").modal("show");
      this.update_det = this.plant_meth[index];
      setTimeout(() => {
        console.log(this.update_meth);
      }, 600);
    },
    getPlantNames() {
      window.axios.get("/expert/get-plant-names").then(({ data }) => {
        this.plant_names = data;
      });
    },
    getVarieties() {
      window.axios.get("/expert/plant-variety").then(({ data }) => {
        this.varieties = data;
      });
    },
    updateDet() {
      axios
        .patch("/expert/plant-details/" + this.update_det.id, {
          variety_id: this.update_det.variety_id,
          description: this.update_det.description,
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

          this.readDet();
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.name) {
            this.errors.push(error.response.data.errors.name[0]);
          }
          if (error.response.data.errors.description) {
            this.errors.push(error.response.data.errors.description[0]);
          }
        });
    },
    readDet() {
      window.axios.get("/expert/plant-details").then(({ data }) => {
        this.plant_meth = data;
        //this.dataTab();
      });
    },
    editMet(val) {
      this.$router.push({ path: `/meth/${val}/edit` });
    },
    deleteMeth(val) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          window.axios.post("/delete-meth/" + val).then(({ data }) => {
            if (data) {
              $("#meth-table").DataTable().draw();
            }
          });
        }
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
