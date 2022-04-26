<template>
  <div class="col-md-12">
    <template v-for="pm in meths">
      <div class="row">
        <div class="col-md-10">
          <h1>{{ pm.title }}</h1>
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
      <div class="row form-group">
        <label class="col-md-4" for="title">Season:</label>
        <div class="col-md-10">
          {{ pm.season }}
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="comment">Pre Treatment:</label>
          {{ pm.pre_treatment }}
        </div>
        <div class="col">
          <label for="comment">Post Treatment:</label>
          {{ pm.post_treatment }}
        </div>
      </div>
      <br />
      <h4>Illustrations</h4>
      <hr />
      <!--  -->
      <div class="row" v-if="pm.files.length > 0">
        <div class="col-md-4" v-for="(file, key) in pm.files">
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
      <!--  -->
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
    graftTechnique() {
      window.axios
        .get("/user-view/graft-detail/" + this.$route.params.id)
        .then(({ data }) => {
          this.meths = data;
          //this.dataTab();
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
