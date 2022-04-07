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
            {{ plant.name }} asd
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
              <li><a href="#">March 2014</a></li>
              <li><a href="#">February 2014</a></li>
              <li><a href="#">January 2014</a></li>
              <li><a href="#">December 2013</a></li>
              <li><a href="#">November 2013</a></li>
              <li><a href="#">October 2013</a></li>
              <li><a href="#">September 2013</a></li>
              <li><a href="#">August 2013</a></li>
              <li><a href="#">July 2013</a></li>
              <li><a href="#">June 2013</a></li>
              <li><a href="#">May 2013</a></li>
              <li><a href="#">April 2013</a></li>
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
  },
};
</script>