<template>
  <div>
    <router-link class="btn btn-primary" to="/admin/plant-detail/create"
      >Create</router-link
    >

    <table
      id="meth-table"
      class="table table-bordered table-striped table-sm dataTable"
      style="margin-top: 15px"
    >
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Plant</th>
          <th>Variety</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(pm, index) in plant_meth">
          <tr>
            <td>{{ pm.id }}</td>
            <td>{{ pm.name }}</td>
            <td>{{ pm.variety }}</td>
            <td>{{ pm.description }}</td>
            <td>
              <button
                type="button"
                class="btn btn-success btn-sm"
                @click="initUpdate(index)"
              >
                <i class="fa fa-edit"></i>
              </button>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
    <!-- MODAL UPDATE -->
    <div class="modal fade" tabindex="-1" role="dialog" id="update_unit_model">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Update</h4>
            <button type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <strong> Whoops, looks like something went wrong...</strong>
              <ul>
                <template v-for="(error, index) in errors">
                  <li :key="index">{{ error }}</li>
                </template>
              </ul>
            </div>

            <div class="form-group">
              <label for="name">Variety:</label>
              <v-select
                ref="select"
                label="description"
                placeholder="Select Plant Name"
                v-model="update_det.variety_id"
                :options="varieties"
                :reduce="(varieties) => varieties.id"
              >
              </v-select>
            </div>
            <div class="form-group">
              <label for="name">Description:</label>
              <textarea
                class="form-control"
                rows="5"
                id="upcomment"
                v-model="update_det.description"
              ></textarea>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="name">Photo:</label>
                <hr />
                <div class="large-12 medium-12 small-12 filezone">
                  <input
                    type="file"
                    id="files"
                    ref="docs"
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
                    <img
                      class="prev-img"
                      v-bind:ref="'preview' + parseInt(key)"
                    />
                    <div style="overflow-wrap: break-word">
                      <small>{{ file.name }}</small>
                    </div>
                    <div style="position: absolute; right: 35px; top: 10px">
                      <a class="remove" @click="removeFile(key)">X</a>
                    </div>
                  </div>
                </div>
                <div class="row" v-if="update_det.puto">
                  <div align="center" class="col-md-3" style="margin-top: 15px">
                    <div style="position: absolute; right: 35px; top: 10px">
                      <a class="remove" @click="deleteFile(update_det.puto.id)"
                        >X</a
                      >
                    </div>
                    <a target="_blank" :href="'/storage' + update_det.puto.src">
                      <img
                        class="prev-img"
                        :src="'/storage' + update_det.puto.src"
                      />
                    </a>
                    <div style="overflow-wrap: break-word">
                      <small>{{ update_det.puto.name }}</small>
                    </div>

                    <div class="badge-success" v-if="update_det.puto.id > 0">
                      UPLOADED
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="updateDet">
              Update
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
    <!--END UPDATE MODAL-->
  </div>
</template>

<script>
import Swal from "sweetalert2/dist/sweetalert2.js";
export default {
  data() {
    return {
      plant_meth: [],
      plant_names: [],
      varieties: [],
      update_det: {},
      errors: [],

      docs: [],
      update_index: "",
    };
  },
  mounted() {
    this.getVarieties();
  },
  created() {
    window.axios.get("/admin/plant-details").then(({ data }) => {
      this.plant_meth = data;
      //this.dataTab();
    });
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
    deleteFile(val) {
      // alert(val);
      // return;
      Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          window.axios
            .post("/admin/delete-plantphoto/" + val)
            .then(({ data }) => {
              if (data) {
                $("#update_unit_model").modal("hide");
                this.readDet();
                setTimeout(() => {
                  this.initUpdate(this.update_index);
                }, 600);
              }
            });
        }
      });
    },
    updateDet() {
      if (this.docs.length > 1) {
        Swal.fire({
          title: "Oops!",
          text: "One Photo per plant!",
          icon: "error",
        });
        return;
      }
      axios
        .patch("/admin/plant-details/" + this.update_det.id, {
          variety_id: this.update_det.variety_id,
          description: this.update_det.description,
        })
        .then((response) => {
          if (this.docs.length > 0) {
            this.submitFiles();
          }
          $("#update_unit_model").modal("hide");

          Swal.fire({
            title: "Success!",
            text: response.data.message,
            icon: "success",
            text: "I will close in 2 seconds.",
            timer: 2000,
          });

          this.readDet();
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.name) {
            this.errors.push(error.response.data.errors.name[0]);
          }
          if (error.response.data.errors.description) {
            this.errors.push(error.response.data.errors.description[0]);
          }
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
          .post("/admin/update-plantphoto/" + this.update_det.id, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(({ data }) => {
            this.docs[i].id = data.id;
            this.docs.splice(i, 1, this.docs[i]);
            // this.graftTechnique();
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
    initUpdate(index) {
      this.update_index = index;
      this.errors = [];
      this.docs = [];
      $("#update_unit_model").modal("show");
      this.update_det = this.plant_meth[index];
      setTimeout(() => {
        console.log(this.update_meth);
      }, 600);
    },
    getPlantNames() {
      window.axios.get("/admin/get-plant-names").then(({ data }) => {
        this.plant_names = data;
      });
    },
    getVarieties() {
      window.axios.get("/admin/plant-variety").then(({ data }) => {
        this.varieties = data;
      });
    },

    readDet() {
      window.axios.get("/admin/plant-details").then(({ data }) => {
        this.plant_meth = data;
        //this.dataTab();
      });
    },
    editMet(val) {
      this.$router.push({ path: `/meth/${val}/edit` });
    },
    deleteMeth(val) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          window.axios.post("/delete-meth/" + val).then(({ data }) => {
            if (data) {
              $("#meth-table").DataTable().draw();
            }
          });
        }
      });
    },
    methhhh(val) {
      this.$router.push({ path: `/met/${val}/create` });
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

