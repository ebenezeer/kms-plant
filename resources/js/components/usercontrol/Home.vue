<template>
  <div class="album py-5 bg-light">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button
          type="button"
          class="btn btn-success"
          :disabled="filterbox == ''"
        >
          Search
        </button>
      </div>
      <input
        type="text"
        class="form-control"
        id="filterbox"
        v-model="filterbox"
      />
    </div>
    <div class="container">
      <div class="row">
        <template v-for="p in plants">
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <img
                class="card-img-top"
                :src="'/storage' + p.puto.src"
                alt="Card image cap"
                width="100"
                height="225"
              />
              <div class="card-body">
                <h4 class="card-text">{{ p.name }}</h4>
                <p class="card-text">
                  <strong> {{ p.variety }}</strong>
                </p>
                <p class="card-text">
                  {{ p.description }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-secondary"
                      @click="plantDetail(p.id)"
                    >
                      View
                    </button>
                    <!-- <button
                      type="button"
                      class="btn btn-sm btn-outline-secondary"
                    >
                      Edit
                    </button> -->
                  </div>
                  <small class="text-muted">{{ p.updated_at }}</small>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      plants: [],
      filterbox: "",
      errors: [],
    };
  },
  mounted() {
    this.getPlants();
  },

  components: {},

  methods: {
    getPlants() {
      window.axios.get("/public/plants").then(({ data }) => {
        this.plants = data;
        //this.dataTab();
      });
    },
    plantDetail(val) {
      this.$router.push({ path: `/user-view/plant-details/${val}` });
    },
  },
};
</script>