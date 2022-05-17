<template>
  <div class="container-fluid">
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
      <div class="col-md-9 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
          {{ plant.name }}ytuyytuytu
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
                <!--  -->

                <div class="card mb-4 box-shadow">
                  <img
                    class="card-img-top"
                    :src="'/storage' + file.src"
                    alt="Card image cap"
                    width="100"
                    height="225"
                  />
                </div>

                <div class="btn-group">
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-secondary"
                    @click="showImg(file.src)"
                  >
                    View
                  </button>
                </div>

                <!--  -->
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
        <!-- The Modal img -->
        <div class="modal fade" id="show_img_model">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Illustration</h4>
                <button type="button" class="close" data-dismiss="modal">
                  &times;
                </button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <img
                  class="img-fluid mx-auto d-block"
                  :src="'/storage' + img_show"
                  alt="illustration"
                />
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- The Modal img -->
        <!-- /.blog-post -->

        <nav class="blog-pagination">
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

          <div class="container" v-if="plant.comments">
            <!--  -->

            <div class="be-comment-block">
              <h1 class="comments-title">
                Comments ({{
                  plant.comments == null ? "0" : plant.comments.length
                }})
              </h1>
              <!--  -->
              <template v-for="com in plant.comments">
                <div class="be-comment">
                  <div class="be-img-comment">
                    <a href="#">
                      <img
                        src="/avatar/avatar.png"
                        alt=""
                        class="be-ava-comment"
                      />
                    </a>
                  </div>
                  <div class="be-comment-content">
                    <span class="be-comment-name">
                      <a href="#">{{
                        com.name == null ? "anonymous" : com.name
                      }}</a
                      ><br />
                      <template v-if="com.role == 2">@expert</template>
                    </span>
                    <span class="be-comment-time">
                      <i class="fa fa-clock-o"></i>

                      <time-ago
                        :datetime="com.created_at"
                        refresh
                        :long="true"
                      />
                    </span>

                    <p class="be-comment-text">
                      {{ com.comment }}
                    </p>
                  </div>
                </div>
              </template>
              <!--  -->
            </div>

            <!--  -->
          </div>
        </nav>
      </div>
      <!-- /.blog-main -->
      <div class="col-md-3 blog-main">
        <aside class="col-md-12 blog-sidebar">
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
      </div>
      <!-- /.blog-sidebar -->
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
import { TimeAgo } from "vue2-timeago";
import "vue2-timeago/dist/vue2-timeago.css";
export default {
  data() {
    return {
      plants: [],
      // comments:[],
      img_show: "",
      plant: {},
      comment: "",
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
    showImg(f) {
      //  alert("gaga");
      this.img_show = f;
      $("#show_img_model").modal("show");
    },
    postComment() {
      axios
        .post("/public/save-comment", {
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
          this.showPlant();
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.comment) {
            this.errors.push(error.response.data.errors.comment[0]);
          }
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
<style scoped>
.be-comment-block {
  margin-bottom: 50px !important;
  border: 1px solid #edeff2;
  border-radius: 2px;
  padding: 50px 70px;
  border: 1px solid #ffffff;
}

.comments-title {
  font-size: 16px;
  color: #262626;
  margin-bottom: 15px;
  font-family: "Conv_helveticaneuecyr-bold";
}

.be-img-comment {
  width: 60px;
  height: 60px;
  float: left;
  margin-bottom: 15px;
}

.be-ava-comment {
  width: 60px;
  height: 60px;
  border-radius: 50%;
}

.be-comment-content {
  margin-left: 80px;
}

.be-comment-content span {
  display: inline-block;
  width: 49%;
  margin-bottom: 15px;
}

.be-comment-name {
  font-size: 13px;
  font-family: "Conv_helveticaneuecyr-bold";
}

.be-comment-content a {
  color: #383b43;
}

.be-comment-content span {
  display: inline-block;
  width: 49%;
  margin-bottom: 15px;
}

.be-comment-time {
  text-align: right;
}

.be-comment-time {
  font-size: 11px;
  color: #b4b7c1;
}

.be-comment-text {
  font-size: 13px;
  line-height: 18px;
  color: #7a8192;
  display: block;
  background: #f6f6f7;
  border: 1px solid #edeff2;
  padding: 15px 20px 20px 20px;
}

.form-group.fl_icon .icon {
  position: absolute;
  top: 1px;
  left: 16px;
  width: 48px;
  height: 48px;
  background: #f6f6f7;
  color: #b5b8c2;
  text-align: center;
  line-height: 50px;
  -webkit-border-top-left-radius: 2px;
  -webkit-border-bottom-left-radius: 2px;
  -moz-border-radius-topleft: 2px;
  -moz-border-radius-bottomleft: 2px;
  border-top-left-radius: 2px;
  border-bottom-left-radius: 2px;
}

.form-group .form-input {
  font-size: 13px;
  line-height: 50px;
  font-weight: 400;
  color: #b4b7c1;
  width: 100%;
  height: 50px;
  padding-left: 20px;
  padding-right: 20px;
  border: 1px solid #edeff2;
  border-radius: 3px;
}

.form-group.fl_icon .form-input {
  padding-left: 70px;
}

.form-group textarea.form-input {
  height: 150px;
}
</style>