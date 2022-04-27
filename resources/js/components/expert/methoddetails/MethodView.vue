<template>
  <div class="col-md-12">
    <h2>{{ plant_det.name }}</h2>
    <hr />
    <div class="row">
      <div class="col-md-10">Variety: {{ plant_det.variety }}</div>
    </div>

    <div class="row">
      <label class="col-md-4" for="description"
        ><srtong>Description:</srtong></label
      >
      <div class="col-md-12">
        <p>{{ plant_det.description }}</p>
      </div>
    </div>
    <h2>Methods</h2>
    <hr />
    <template v-for="(pm, counter) in meths">
      <div class="row">
        <div class="col-md-10">
          {{ ++counter }} <strong>Graft: {{ pm.title }}</strong>
        </div>
      </div>
      <br />
      <div class="row">
        <label class="col-md-4" for="description"
          ><strong>Description:</strong></label
        >
        <div class="col-md-12">
          <p>{{ pm.description }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="comment"><strong>Advantage:</strong></label>
          <p>{{ pm.advantage }}</p>
        </div>
        <div class="col">
          <label for="comment"><strong>Disadvantage:</strong></label>
          <p>{{ pm.disadvantage }}</p>
        </div>
      </div>
      <br />
      <h4>Illustrations</h4>
      <hr />
      <div class="row" v-if="pm.files.length > 0">
        <div
          align="center"
          class="col-md-3"
          v-for="(file, key) in pm.files"
          style="margin-top: 15px"
        >
          <a target="_blank" :href="'/storage' + file.src">
            <img class="prev-img" :src="'/storage' + file.src" />
          </a>
          <div style="overflow-wrap: break-word">
            <small>{{ file.name }}</small>
          </div>

          <div class="badge-success" v-if="file.id > 0">UPLOADED</div>
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
      <div class="row" v-if="pm.vid_src != null">
        <div class="col-md-8">
          <div class="embed-responsive embed-responsive-16by9">
            <!-- <iframe
              class="embed-responsive-item"
              :src="graft_det.vid_src"
            ></iframe> -->

            <iframe
              width="560"
              height="315"
              :src="pm.vid_src"
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
          pm.season == null || pm.season == "" ? "No Record Found!" : pm.season
        }}
      </p>
      <!--  -->
      <div class="row">
        <div class="col-md-6">
          <h4>Pre Treatment</h4>
          <p>
            {{
              pm.pre_treatment == null || pm.pre_treatment == ""
                ? "No Record Found!"
                : pm.pre_treatment
            }}
          </p>
        </div>
        <div class="col-md-6">
          <h4>Post Treatment</h4>
          <p>
            {{
              pm.post_treatment == null || pm.post_treatment == ""
                ? "No Record Found!"
                : pm.post_treatment
            }}
          </p>
        </div>
      </div>
      <!--  -->
    </template>
    <div class="row">
      <div class="col-md-8">
        <label for="name"
          >Search Phrase: (Separate every search phrase with comma',')
        </label>
        <textarea
          class="form-control"
          rows="5"
          id="upcomment"
          v-model="plant_det.search_key"
        ></textarea>
      </div>
    </div>
    <br />
    <button class="btn btn-primary" type="submit" @click="updatePhrase">
      Update search phrase
    </button>
    <!--  -->
    <br /><br />

    <div class="d-flex justify-content-center row" v-if="comments.length > 0">
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
              <template v-for="(c, index) in comments">
                <div class="commented-section mt-2">
                  <div
                    class="d-flex flex-row align-items-center commented-user"
                  >
                    <h5 class="mr-2">{{ c.name }}</h5>
                    <span class="dot mb-1"></span
                    ><span class="mb-1 ml-2">
                      <time-ago :datetime="c.updated_at" refresh :long="true"
                    /></span>
                  </div>
                  <div class="comment-text-sm">
                    <span>{{ c.comment }}</span>
                  </div>
                  <div class="reply-section">
                    <div
                      class="d-flex flex-row align-items-center voting-icons"
                    >
                      <i class="fa fa-sort-up fa-2x mt-3 hit-voting"></i
                      ><i class="fa fa-sort-down fa-2x mb-3 hit-voting"></i
                      ><span class="ml-2">10</span
                      ><span class="dot ml-2"></span>
                      <h6 class="ml-2 mt-1">
                        <button
                          type="button"
                          class="btn btn-danger btn-sm"
                          :disabled="c.user_id != plant_det.user_id"
                          @click="discardComment(c.id)"
                        >
                          Discard
                        </button>
                      </h6>
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
    <!--  -->
  </div>
</template>

<script>
import { TimeAgo } from "vue2-timeago";
import "vue2-timeago/dist/vue2-timeago.css";
import Swal from "sweetalert2/dist/sweetalert2.js";
export default {
  data() {
    return {
      bid: {
        title: null,
        keywords: null,
        description: null,
        invitation: null,
        published: 0,
      },

      plant_det: [],
      meths: [],
      graft_det: {},

      comment: "",
      comments: [],
      errors: [],
      graft: [],
      docs: [],
    };
  },
  mounted() {
    this.graftTechnique();
  },
  components: { TimeAgo },
  methods: {
    graftTechnique() {
      window.axios
        .get("/expert/view-plant-methods/" + this.$route.params.id)
        .then(({ data }) => {
          this.plant_det = data.plant_det;
          this.meths = data.meths;
          this.comments = data.comments;
        });
    },
    postComment() {
      axios
        .post("/expert/save-comment", {
          article_id: this.$route.params.id,
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
          this.graftTechnique();
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.comment) {
            this.errors.push(error.response.data.errors.comment[0]);
          }
        });
    },
    discardComment(id) {
      axios
        .post("/expert/discard-comment", {
          comment_id: id,
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
          //  this.comment = [];
          setTimeout(() => {
            this.graftTechnique();
          }, 600);
        })
        .catch((error) => {
          this.errors = [];
          // if (error.response.data.errors.comment) {
          //   this.errors.push(error.response.data.errors.comment[0]);
          // }
        });
    },
    updatePhrase() {
      axios
        .patch("/expert/plant-methods/" + this.plant_det.id, {
          search_key: this.plant_det.search_key,
        })
        .then((response) => {
          this.plant_det = [];
          this.meths = [];
          Swal.fire({
            title: "Success!",
            text: response.data.message,
            icon: "success",
            text: "I will close in 2 seconds.",
            timer: 2000,
          });
          setTimeout(() => {
            this.graftTechnique();
          }, 600);
        })
        .catch((error) => {
          this.errors = [];
        });
    },
  },
};
</script>

<style scoped>
input[type="file"] {
  opacity: 0;
  width: 100%;
  height: 200px;
  position: absolute;
  cursor: pointer;
}
.filezone {
  outline: 2px dashed grey;
  outline-offset: -10px;
  background: #ccc;
  color: dimgray;
  padding: 10px 10px;
  min-height: 200px;
  position: relative;
  cursor: pointer;
}
.filezone:hover {
  background: #c0c0c0;
}

.filezone p {
  font-size: 1.2em;
  text-align: center;
  padding: 50px 50px 50px 50px;
}

a.remove {
  color: red;
  cursor: pointer;
  font-weight: 700;
  background-color: #e1e1e1;
  padding: 2px 5px;
  border: none;
}

.prev-img {
  max-width: 75%;
  max-height: 75px;
}

.switch {
  position: relative;
  display: inline-block;
  width: 70px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: red;
  -webkit-transition: 0.4s;
  transition: 0.4s;
  color: #ffffff;
}
.slider p {
  position: relative;
  margin-top: 5px;
  margin-left: 7px;
  font-weight: 700;
  color: #ffffff;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #1d643b;
}

input:focus + .slider {
  box-shadow: 0 0 1px #1d643b;
}

input:checked + .slider:before {
  -webkit-transform: translateX(35px);
  -ms-transform: translateX(35px);
  transform: translateX(35px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
