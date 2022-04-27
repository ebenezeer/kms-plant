<template>
  <div class="col-md-12">
    <h2>Graft Techique</h2>
    <hr />
    <form @submit.prevent="saveGraftDet">
      <div class="row form-group">
        <label class="col-md-4" for="title">Title:</label>
        <div class="col-md-10">
          <input
            v-model="graft_det.title"
            type="text"
            class="form-control"
            id="title"
            required
          />
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-4" for="description">Description:</label>
        <div class="col-md-10">
          <textarea
            class="form-control"
            rows="5"
            id="comment"
            v-model="graft_det.description"
          ></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="comment">Advantage:</label>
          <textarea
            class="form-control"
            rows="5"
            id="adva"
            v-model="graft_det.advantage"
          ></textarea>
        </div>
        <div class="col">
          <label for="comment">Disadvantage:</label>
          <textarea
            class="form-control"
            rows="5"
            id="disadva"
            v-model="graft_det.disadvantage"
          ></textarea>
        </div>
      </div>
      <br />
      <div class="row form-group">
        <label class="col-md-4" for="title">Season:</label>
        <div class="col-md-10">
          <input
            v-model="graft_det.season"
            type="text"
            class="form-control"
            id="season"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="comment">Pre Treatment:</label>
          <textarea
            class="form-control"
            rows="5"
            id="pre"
            v-model="graft_det.pre_treatment"
          ></textarea>
        </div>
        <div class="col">
          <label for="comment">Post Treatment:</label>
          <textarea
            class="form-control"
            rows="5"
            id="post"
            v-model="graft_det.post_treatment"
          ></textarea>
        </div>
      </div>
      <br />
      <div class="col-md-10">
        <h4>Graft Pictures</h4>
        <hr />
        <div class="large-12 medium-12 small-12 filezone">
          <input
            type="file"
            id="files"
            ref="docs"
            multiple
            @change="handleFiles()"
          />
          <p>Drop your files here <br />or click to search</p>
        </div>

        <div class="row">
          <div
            align="center"
            class="col-md-3"
            v-for="(file, key) in docs"
            style="margin-top: 15px"
            v-if="file.id == null"
          >
            <img class="prev-img" v-bind:ref="'preview' + parseInt(key)" />
            <div style="overflow-wrap: break-word">
              <small>{{ file.name }}</small>
            </div>
            <div style="position: absolute; right: 35px; top: 10px">
              <a class="remove" @click="removeFile(key)">X</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div
            align="center"
            class="col-md-3"
            v-for="(file, key) in bid.docs"
            v-if="file.type === 1"
            style="margin-top: 15px"
          >
            <div style="position: absolute; right: 35px; top: 10px">
              <a class="remove" @click="deleteFile(file.id)">X</a>
            </div>
            <a target="_blank" :href="'/storage' + file.src">
              <img class="prev-img" src="/img/generic.png" />
            </a>

            <div class="badge-success" v-if="file.id > 0">UPLOADED</div>
          </div>
        </div>
        <div class="row">
          <div
            align="center"
            class="col-md-3"
            v-for="(file, key) in graft_det.docs"
            style="margin-top: 15px"
          >
            <div style="position: absolute; right: 35px; top: 10px">
              <a class="remove" @click="deleteFile(file.id)">X</a>
            </div>
            <a target="_blank" :href="'/storage' + file.src">
              <img class="prev-img" :src="'/storage' + file.src" />
            </a>
            <div style="overflow-wrap: break-word">
              <small>{{ file.name }}</small>
            </div>

            <div class="badge-success" v-if="file.id > 0">UPLOADED</div>
          </div>
        </div>
        <br />
        <div class="row">
          <h4>Graft Video</h4>
          <hr />
          <input
            v-model="graft_det.vid_src"
            type="text"
            class="form-control"
            id="vid_src "
          />
        </div>
        <div class="row">
          <div class="embed-responsive embed-responsive-16by9">
            <!-- <iframe
              class="embed-responsive-item"
              :src="graft_det.vid_src"
            ></iframe> -->

            <iframe
              width="560"
              height="315"
              :src="graft_det.vid_src"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
        </div>
      </div>
      <hr />
      <div class="form-group" style="margin-top: 20px"></div>
      <div class="form-group" style="margin-top: 15px">
        <div class="col-md-10" align="center">
          <button class="btn btn-primary" type="submit">Save</button>
          <router-link class="btn btn-secondary" to="/bids">Back</router-link>
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
      bid: {
        title: null,
        keywords: null,
        description: null,
        invitation: null,
        published: 0,
      },

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
    removeFile(key) {
      this.docs.splice(key, 1);
      this.getImagePreviews();
    },
    graftTechnique() {
      window.axios
        .get("/admin/graft-techniques/" + this.$route.params.id)
        .then(({ data }) => {
          this.graft_det = data;
        });
    },
    saveGraftDet() {
      window.axios
        .post("/admin/update-graft/" + this.graft_det.id, this.graft_det)
        .then(({ data }) => {
          if (data) {
            this.submitFiles();
          }
        });
    },
    deleteFile(val) {
      Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          window.axios.post("/admin/delete-doc/" + val).then(({ data }) => {
            if (data) {
              this.graftTechnique();
            }
          });
        }
      });
    },
    updateFile(val, typ) {
      window.axios
        .post("/update-doc/" + val, { type: typ })
        .then(({ data }) => {
          this.graftTechnique();
        });
    },
    submitFiles() {
      for (let i = 0; i < this.docs.length; i++) {
        if (this.docs[i].id) {
          continue;
        }
        let formData = new FormData();
        formData.append("docs", this.docs[i]);

        window.axios
          .post("/admin/save-docs/" + this.graft_det.id, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(({ data }) => {
            this.docs[i].id = data.id;
            this.docs.splice(i, 1, this.docs[i]);
            this.graftTechnique();
          })
          .catch(function (data) {
            console.log("error");
          });
      }
      //swal("Success" ,  "Bid successfully saved!" ,  "success" )

      Swal.fire({
        title: "Success!",
        text: "Detail successfully saved!",
        icon: "success",
        text: "I will close in 2 seconds.",
        timer: 2000,
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
