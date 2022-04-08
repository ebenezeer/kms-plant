<template>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <img
            width="304"
            height="236"
            class="rounded"
            :src="'/storage' + plant.puto.src"
            alt="Card image cap"
          />
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 blog-main">
          <h3 class="pb-3 mb-4 font-italic border-bottom">
            {{ plant.name }}
          </h3>

          <div class="blog-post">
            <p class="blog-post-meta">
              {{ plant.variety }}
            </p>

            <p>
              {{ plant.description }}
            </p>
            <hr />
          </div>
          <!-- /.blog-post -->
          <div class="blog-post">
            <h4 class="blog-post-title">Technologies</h4>
            <p class="blog-post-meta">
              {{ plant.updated_at }}
            </p>
            <!-- temp -->
            <template v-for="(p, index) in plant.tech">
              <h2>{{ ++index }}) {{ p.title }}</h2>
              <p>
                {{ p.description }}
              </p>
              <h3>Advantage</h3>
              <p>
                {{ p.advantage == "" ? "No Record Found!" : p.advantage }}
              </p>

              <h3>Disadvantage</h3>
              <p>
                {{ p.disadvantage == "" ? "No Record Found!" : p.disadvantage }}
              </p>
              <hr />

              <h4>Illustrations</h4>

              <div class="row" v-if="p.files.length > 0">
                <div class="col-md-4" v-for="(file, key) in p.files">
                  <div class="card mb-4 box-shadow">
                    <img
                      class="card-img-top"
                      :src="'/storage' + file.src"
                      alt="Card image cap"
                      width="100"
                      height="225"
                    />
                  </div>
                </div>
              </div>
              <div class="row" v-else>
                <div class="col">
                  <div class="alert alert-secondary">
                    <strong>Oops!</strong> No image found!.
                  </div>
                </div>
              </div>
              <br />
              <br />
              <div class="row" v-if="p.vid_src != null">
                <div class="col-md-8">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe
                      width="560"
                      height="315"
                      :src="p.vid_src"
                      title="YouTube video player"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen
                    ></iframe>
                  </div>
                </div>
              </div>
              <hr />
            </template>
            <!-- temp -->
          </div>
          <!-- /.blog-post -->

          <!-- /.blog-post -->

          <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
          </nav>
        </div>
        <!-- /.blog-main -->

        <aside class="col-md-4 blog-sidebar">
          <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">Archives</h4>
            <ol class="list-unstyled mb-0">
              <template v-for="p in plants">
                <li>
                  <button
                    type="button"
                    class="btn btn-link"
                    @click="plantDetail(p.id)"
                  >
                    {{ p.name }}({{ p.variety }})
                  </button>
                </li>
              </template>
            </ol>
          </div>
        </aside>
        <!-- /.blog-sidebar -->
      </div>
      <!-- /.row -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      plants: [],
      plant: {},
      errors: [],
    };
  },
  mounted() {
    //alert(this.$route.params.id);
    this.getPlants();
    this.showPlant();
  },

  components: {},

  methods: {
    getPlants() {
      window.axios.get("/public/plants").then(({ data }) => {
        this.plants = data;
        //this.dataTab();
      });
    },
    showPlant() {
      window.axios
        .get("/public/plant/" + this.$route.params.id)
        .then(({ data }) => {
          this.plant = data;
          //this.dataTab();
        });
    },
    plantDetail(val) {
      this.plant = [];
      window.axios.get("/public/plant/arc/" + val).then(({ data }) => {
        this.plant = data;
        //this.dataTab();
      });
    },
  },
};
</script>