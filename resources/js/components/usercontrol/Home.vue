<template>
  <div class="container">
    <div class="row">
      <h1>Welcome</h1>
      <hr />
      <div class="col-md-12">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <button
              type="button"
              class="btn btn-success"
              :disabled="filterbox == ''"
              @click="searchRelated"
            >
              Search
            </button>
          </div>
          <input
            type="text"
            class="form-control"
            id="filterbox"
            placeholder="Whats on yur mind?"
            v-model="filterbox"
            v-on:keyup.enter="searchRelated"
          />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-borderless" v-if="graft_results.length > 0">
          <tbody>
            <template v-for="g in graft_results">
              <tr>
                <td>
                  <!-- <button
                    type="button"
                    class="btn btn-link"
                    @click="plantDetail(g.graft_id)"
                  >
                    <strong>{{ g.graft.title }}</strong>
                  </button> -->

                  <a :href="'/user-view/method-details/' + g.graft_id"
                    ><strong>
                      <strong>{{ g.graft.title }}</strong></strong
                    ></a
                  >

                  <br />
                  <small> {{ g.graft.description }}</small>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
        <table class="table table-borderless" v-if="plant_results.length > 0">
          <tbody>
            <template v-for="p in plant_results">
              <tr>
                <td>
                  <a :href="'/user-view/plant-details/' + p.plant_det_id"
                    ><strong>{{ p.plant_name }}</strong></a
                  >

                  <br />
                  <div>
                    <small> {{ p.plant_des }}</small>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2/dist/sweetalert2.js";
export default {
  data() {
    return {
      plants: [],

      filterbox: "",
      search_result: [],

      plant_results: [],
      graft_results: [],
      errors: [],
    };
  },
  mounted() {
    this.getPlants();
  },

  components: {},

  methods: {
    searchRelated() {
      window.axios
        .post("/user-view/search-related", {
          phrase: this.filterbox,
        })
        .then((response) => {
          this.plant_results = response.data.plants;
          this.graft_results = response.data.grafts;
          // Swal.fire({
          //   title: "Success!",
          //   text: response.data.message,
          //   icon: "success",
          //   text: "I will close in 2 seconds.",
          //   timer: 2000,
          // });
          //this.$router.push({ path: "/expert/plant-methods" + data + "/edit" });
        })
        .catch((error) => {
          // this.errors = [];
        });
    },
    getPlants() {},
    plantDetail(val) {
      this.$router.push({ path: `/user-view/method-details/${val}` });
    },
  },
};
</script>