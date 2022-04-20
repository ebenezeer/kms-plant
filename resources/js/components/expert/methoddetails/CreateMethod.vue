<template>
  <div class="col-md-12">
    <h2>Create Plant Methods</h2>
    <hr />
    <form @submit.prevent="saveMeth">
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
            :reduce="(plant_names) => plant_names.id"
          >
            <template slot="option" slot-scope="option">
              <div class="d-center">
                {{ option.name }}, {{ option.variety }}<br />
                <small> {{ option.description }}</small>
              </div>
            </template>
            <template slot="selected-option" slot-scope="option">
              <div class="selected d-center">
                {{ option.name }}, {{ option.variety }}
              </div>
            </template>
          </v-select>
        </div>
      </div>
      <br />

      <div class="row">
        <div class="col-md-8">
          <label for="description">Graft Method:</label>
          <v-select
            ref="select"
            label="title"
            multiple="multiple"
            placeholder="Select Method"
            v-model="plantDet.graft_id"
            :options="graft_method"
            :reduce="(graft_method) => graft_method.id"
          >
          </v-select>
        </div>
      </div>
      <br />
      <div class="row">
        <div class="col-md-8">
          <label for="name"
            >Search Phrase: (Separate every search phrase with comma',')
          </label>
          <textarea
            class="form-control"
            rows="5"
            id="upcomment"
            v-model="plantDet.search_keys"
          ></textarea>
        </div>
      </div>
      <div class="form-group" style="margin-top: 15px">
        <div class="col-md-8" align="center">
          <button class="btn btn-primary" type="submit">Submit</button>
          <router-link class="btn btn-secondary" to="/expert/method-details"
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
        search_keys: "",
        description: null,
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
    this.graftings();
  },
  methods: {
    getPlantNames() {
      window.axios.get("/expert/get-plant-names-met").then(({ data }) => {
        this.plant_names = data;
      });
    },
    getVarieties() {
      window.axios.get("/expert/plant-variety").then(({ data }) => {
        this.varieties = data;
      });
    },
    graftings() {
      window.axios.get("/expert/graft-techniques").then(({ data }) => {
        this.graft_method = data;
      });
    },
    saveMeth() {
      window.axios
        .post("/expert/plant-methods", {
          name_id: this.plantDet.name_id,
          graft_id: this.plantDet.graft_id,
          search_keys: this.plantDet.search_keys,
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
          location.reload();
        })
        .catch((error) => {
          this.errors = [];

          if (error.response.data.errors.name_id) {
            this.errors.push(error.response.data.errors.name_id[0]);
          }

          if (error.response.data.errors.graft_id) {
            this.errors.push(error.response.data.errors.graft_id[0]);
          }

          // if (error.response.data.errors.description) {
          //   this.errors.push(error.response.data.errors.description[0]);
          // }
        });

      //  axios
      // .post("/expert/plant-methods", {
      //   name: this.unit.description,
      // })
      // .then((response) => {
      //   this.reset();

      //   Swal.fire({
      //     title: "Success!",
      //     text: response.data.message,
      //     icon: "success",
      //     text: "I will close in 2 seconds.",
      //     timer: 2000,
      //   });

      //   $("#add_unit_model").modal("hide");
      //   this.readunits();
      // })
      // .catch((error) => {
      //   this.errors = [];
      //   if (error.response.data.errors.name) {
      //     this.errors.push(error.response.data.errors.name[0]);
      //   }
      // });
    },
  },
};
</script>

<style scoped>
</style>
