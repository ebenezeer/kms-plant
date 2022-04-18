<template>
  <div class="col-md-12">
    <h2>Plant Details</h2>
    <hr />
    <form @submit.prevent="saveDet">
      <div class="alert alert-danger" v-if="errors.length > 0">
        <strong> Whoops, looks like something went wrong...</strong>
        <ul>
          <template v-for="(error, index) in errors">
            <li :key="index">{{ error }}</li>
          </template>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label for="title">Name:</label>
          <v-select
            ref="select"
            label="name"
            placeholder="Select Plant Name"
            v-model="plantDet.name_id"
            :options="plant_names"
            :reduce="(plant_names) => [plant_names.id, plant_names.name]"
          >
          </v-select>
        </div>
        <div class="col-md-6">
          <label for="title">Variety:</label>
          <v-select
            ref="select"
            label="description"
            placeholder="Select Variety"
            v-model="plantDet.variety_id"
            :options="varieties"
            :reduce="(varieties) => [varieties.id, varieties.description]"
          >
          </v-select>
        </div>
      </div>
      <br />

      <div class="row">
        <div class="col-md-8">
          <label for="name">Description:</label>
          <textarea
            class="form-control"
            rows="5"
            id="upcomment"
            v-model="plantDet.description"
          ></textarea>
        </div>
      </div>
      <div class="form-group" style="margin-top: 15px">
        <div class="col-md-8" align="center">
          <button class="btn btn-primary" type="submit">Submit</button>
          <router-link class="btn btn-secondary" to="/expert/plant-detail"
            >Back</router-link
          >
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Swal from "sweetalert2/dist/sweetalert2.js";
export default {
  data() {
    return {
      plantDet: {
        name_id: "",
        variety_id: "",
        graft_id: "",
        description: "",
      },
      plant_names: [],
      varieties: [],
      graft_method: [],

      errors: [],
    };
  },
  mounted() {
    this.getPlantNames();
    this.getVarieties();
    // this.graftings();
  },
  methods: {
    getPlantNames() {
      window.axios.get("/admin/get-plant-names").then(({ data }) => {
        this.plant_names = data;
      });
    },
    getVarieties() {
      window.axios.get("/admin/plant-variety").then(({ data }) => {
        this.varieties = data;
      });
    },
    graftings() {
      window.axios.get("/expert/graft-techniques").then(({ data }) => {
        this.graft_method = data;
      });
    },
    saveDet() {
      window.axios
        .post("/admin/plant-details", {
          name_id: this.plantDet.name_id[0],
          variety_id: this.plantDet.variety_id[0],
          //graft_id: this.plantDet.graft_id[0],
          description: this.plantDet.description,
        })
        .then((response) => {
          Swal.fire({
            title: "Success!",
            text: response.data.message,
            icon: "success",
            text: "I will close in 2 seconds.",
            timer: 2000,
          });
          //this.$router.push({ path: "/expert/plant-methods" + data + "/edit" });
        })
        .catch((error) => {
          this.errors = [];

          if (error.response.data.errors.name_id) {
            this.errors.push(error.response.data.errors.name_id[0]);
          }

          if (error.response.data.errors.variety_id) {
            this.errors.push(error.response.data.errors.variety_id[0]);
          }
          if (error.response.data.errors.description) {
            this.errors.push(error.response.data.errors.description[0]);
          }
        });
    },
  },
};
</script>

<style scoped>
</style>
