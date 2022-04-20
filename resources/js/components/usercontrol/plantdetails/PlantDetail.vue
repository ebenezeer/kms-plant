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
          <p class="blog-post-meta">
            {{ plant.updated_at }}<br />
            <time-ago :datetime="plant.updated_at" refresh :long="true" />
          </p>
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

            <!-- temp -->
            <template v-for="(p, index) in plant.tech">
              <h2>{{ ++index }}) {{ p.title }}</h2>
              <p>
                {{ p.description }}
              </p>
              <!--  -->
              <div class="row">
                <div class="col-md-6">
                  <h4>Advantage</h4>
                  <p>
                    {{ p.advantage == "" ? "No Record Found!" : p.advantage }}
                  </p>
                </div>
                <div class="col-md-6">
                  <h4>Disadvantage</h4>
                  <p>
                    {{
                      p.disadvantage == "" ? "No Record Found!" : p.disadvantage
                    }}
                  </p>
                </div>
              </div>
              <!--  -->
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
              <h3>Season</h3>
              <p>
                {{
                  p.season == null || p.season == ""
                    ? "No Record Found!"
                    : p.season
                }}
              </p>
              <!--  -->
              <div class="row">
                <div class="col-md-6">
                  <h4>Pre Treatment</h4>
                  <p>
                    {{
                      p.pre_treatment == null || p.pre_treatment == ""
                        ? "No Record Found!"
                        : p.pre_treatment
                    }}
                  </p>
                </div>
                <div class="col-md-6">
                  <h4>Post Treatment</h4>
                  <p>
                    {{
                      p.post_treatment == null || p.post_treatment == ""
                        ? "No Record Found!"
                        : p.post_treatment
                    }}
                  </p>
                </div>
              </div>
              <!--  -->
              <hr />
            </template>
            <!-- temp -->
          </div>
          <!-- /.blog-post -->
          <div class="blog-post" v-if="plant.tech.length > 0">
            <div class="d-flex justify-content-center row">
              <div class="d-flex flex-column col-md-12">
                <div class="coment-bottom bg-white p-2">
                  <div class="alert alert-danger" v-if="errors.length > 0">
                    <strong> Whoops, looks like something went wrong...</strong>
                    <ul>
                      <template v-for="(error, index) in errors">
                        <li :key="index">{{ error }}</li>
                      </template>
                    </ul>
                  </div>
                  <div class="d-flex flex-row add-comment-section mt-4 mb-4">
                    <input
                      type="text"
                      class="form-control mr-3"
                      placeholder="Add comment"
                      v-model="comment"
                    /><button
                      class="btn btn-primary"
                      type="button"
                      @click="postComment"
                    >
                      Comment
                    </button>
                  </div>
                  <div class="collapsable-comment">
                    <div
                      class="
                        d-flex
                        flex-row
                        justify-content-between
                        align-items-center
                        action-collapse
                        p-2
                      "
                      data-toggle="collapse"
                      aria-expanded="false"
                      aria-controls="collapse-1"
                      href="#collapse-1"
                    >
                      <span>Comments</span
                      ><i class="fa fa-chevron-down servicedrop"></i>
                    </div>
                    <div id="collapse-1" class="collapse">
                      <!--  -->
                      <template v-for="(c, index) in plant.comments">
                        <div class="commented-section mt-2">
                          <div
                            class="
                              d-flex
                              flex-row
                              align-items-center
                              commented-user
                            "
                          >
                            <h5 class="mr-2">{{ c.name }}</h5>
                            <span class="dot mb-1"></span
                            ><span class="mb-1 ml-2">
                              <time-ago
                                :datetime="c.updated_at"
                                refresh
                                :long="true"
                            /></span>
                          </div>
                          <div class="comment-text-sm">
                            <span>{{ c.comment }}</span>
                          </div>
                          <div class="reply-section">
                            <div
                              class="
                                d-flex
                                flex-row
                                align-items-center
                                voting-icons
                              "
                            >
                              <i class="fa fa-sort-up fa-2x mt-3 hit-voting"></i
                              ><i
                                class="fa fa-sort-down fa-2x mb-3 hit-voting"
                              ></i
                              ><span class="ml-2">10</span
                              ><span class="dot ml-2"></span>
                              <h6 class="ml-2 mt-1">Reply</h6>
                            </div>
                          </div>
                        </div>
                      </template>
                      <!--  -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.blog-post -->
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
import { TimeAgo } from "vue2-timeago";
import "vue2-timeago/dist/vue2-timeago.css";
export default {
  data() {
    return {
      comment: "",
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

  components: { TimeAgo },

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
    postComment() {
      axios
        .post("/user-view/save-comment", {
          article_id: this.plant.article_id,
          comment: this.comment,
        })
        .then((response) => {
          this.$toasted.show(response.data.message, {
            theme: "bubble",
            type: "success",
            position: "bottom-right",
            duration: 1500,
            action: {
              text: "X",
              onClick: (e, toast) => {
                toast.goAway(0);
              },
            },
          });
          this.comment = [];
          this.plantDetail(this.plant.id);
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.comment) {
            this.errors.push(error.response.data.errors.comment[0]);
          }
        });
    },
  },
};
</script>
<style scoped>
.bdge {
  height: 21px;
  background-color: orange;
  color: #fff;
  font-size: 11px;
  padding: 8px;
  border-radius: 4px;
  line-height: 3px;
}

.comments {
  text-decoration: underline;
  text-underline-position: under;
  cursor: pointer;
}

.dot {
  height: 7px;
  width: 7px;
  margin-top: 3px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
}

.hit-voting:hover {
  color: blue;
}

.hit-voting {
  cursor: pointer;
}

.servicedrop {
  transition-delay: 1s;
}

.action-collapse {
  cursor: pointer;
}
</style>