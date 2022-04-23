<template>
  <div class="album py-5 bg-light">
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

    <!-- vids -->
    <div class="container">
      <div class="row">
        <template v-for="v in videos">
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <div class="embed-responsive embed-responsive-16by9">
                <iframe
                  width="560"
                  height="315"
                  :src="v.vid_src"
                  title="YouTube video player"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                ></iframe>
              </div>
              <div class="card-body">
                <h4 class="card-text">{{ v.title }}</h4>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
    <!-- vids -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      plants: [],
      videos: [],
      errors: [],
    };
  },
  mounted() {
    this.getPlants();
    this.getVideo();
  },

  components: {},

  methods: {
    getPlants() {
      window.axios.get("/public/plants").then(({ data }) => {
        this.plants = data;
        //this.dataTab();
      });
    },
    getVideo() {
      window.axios.get("/public/get-vids").then(({ data }) => {
        this.videos = data;
        //this.dataTab();
      });
    },
    plantDetail(val) {
      this.$router.push({ path: `/plant-details/${val}` });
    },
  },
};
</script>