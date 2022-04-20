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
  </div>
</template>

<script>
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

      graft: [],
      docs: [],
    };
  },
  mounted() {
    this.graftTechnique();
  },
  methods: {
    handleFiles() {
      let uploadedFiles = this.$refs.docs.files;

      for (var i = 0; i < uploadedFiles.length; i++) {
        this.docs.push(uploadedFiles[i]);
      }
      this.getImagePreviews();
    },
    getImagePreviews() {
      for (let i = 0; i < this.docs.length; i++) {
        if (/\.(jpe?g|png|gif)$/i.test(this.docs[i].name)) {
          let reader = new FileReader();
          reader.addEventListener(
            "load",
            function () {
              this.$refs["preview" + parseInt(i)][0].src = reader.result;
            }.bind(this),
            false
          );
          reader.readAsDataURL(this.docs[i]);
        } else {
          this.$nextTick(function () {
            this.$refs["preview" + parseInt(i)][0].src = "/img/generic.png";
          });
        }
      }
    },

    graftTechnique() {
      window.axios
        .get("/expert/view-plant-methods/" + this.$route.params.id)
        .then(({ data }) => {
          this.plant_det = data.plant_det;
          this.meths = data.meths;
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
    saveGraftDet() {
      window.axios
        .post("/expert/update-graft/" + this.graft_det.id, this.graft_det)
        .then(({ data }) => {
          if (data) {
            this.submitFiles();
          }
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
