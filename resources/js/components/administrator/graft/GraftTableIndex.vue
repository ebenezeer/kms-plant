<template>
  <div class="col-md-12">
    <h2>
      {{ $route.name }}
      <button @click="initAddunit" class="btn btn-primary btn-sm float-right">
        + Graft Technique Details
      </button>
    </h2>
    <hr />
    <div class="table-responsive" id="table">
      <table
        id="unit-table"
        class="table table-bordered table-hover table-sm"
        v-if="graftings.length > 0"
        style="table-layout: fixed; width: 100%; size: 21cm 29.7cm"
      >
        <thead>
          <tr>
            <th style="width: 5%">Ref #</th>
            <th style="width: 20%">Title</th>
            <th>Description</th>
            <th style="width: 5%">Action</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(gd, index) in graftings">
            <tr :key="index">
              <td>{{ gd.id }}</td>
              <td>
                {{ gd.title }}
              </td>
              <td>
                {{ gd.description }}
              </td>
              <td>
                <div class="btn-group">
                  <button
                    @click="editTech(gd.id)"
                    class="btn btn-success btn-sm"
                    title="update"
                  >
                    <i class="fa fa-edit"></i>
                  </button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>

      <div class="alert alert-info" v-else>
        <strong>Info!</strong> No data Available.
      </div>
    </div>

    <!-- ADD MODAL -->
    <div class="modal fade" id="add_unit_model">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Graft Details</h4>
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
              <label for="name">Graft:</label>
              <input
                type="text"
                name="name"
                id="name"
                placeholder="Graft Name"
                ref="addunit"
                class="form-control"
                v-on:keyup.enter="createGraft"
                v-model="graft.title"
              />
            </div>
            <div class="form-group">
              <label for="comment">Description:</label>
              <textarea
                class="form-control"
                rows="5"
                id="comment"
                v-model="graft.description"
              ></textarea>
            </div>

            <div class="row">
              <div class="col">
                <label for="comment">Advantage:</label>
                <textarea
                  class="form-control"
                  rows="5"
                  id="adva"
                  v-model="graft.advantage"
                ></textarea>
              </div>
              <div class="col">
                <label for="comment">Disadvantage:</label>
                <textarea
                  class="form-control"
                  rows="5"
                  id="disadva"
                  v-model="graft.disadvantage"
                ></textarea>
              </div>
            </div>
            <br />
            <div class="form-group">
              <label for="season">Season:</label>
              <input
                type="text"
                name="season"
                id="season"
                placeholder="season"
                class="form-control"
                v-model="graft.season"
              />
            </div>
            <div class="row">
              <div class="col">
                <label for="comment">Pre Treatment:</label>
                <textarea
                  class="form-control"
                  rows="5"
                  id="pre"
                  v-model="graft.advantage"
                ></textarea>
              </div>
              <div class="col">
                <label for="comment">Post Treatment:</label>
                <textarea
                  class="form-control"
                  rows="5"
                  id="post"
                  v-model="graft.disadvantage"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click="createGraft" class="btn btn-primary">
              Submit
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- END ADD MODAL -->
  </div>
</template>
 
<script>
import Swal from "sweetalert2/dist/sweetalert2.js";
//import VueFeather from "vue-feather";

export default {
  data() {
    return {
      unit: {
        description: "",
      },
      graft: {
        title: "",
        description: "",
        advantage: "",
        disadvantage: "",
        season: "",
        pre_treatment: "",
        post_treatment: "",
      },
      errors: [],
      graftings: [],
      units: [],
      update_unit: {},
    };
  },
  mounted() {},

  created() {
    window.axios.get("/admin/graft-techniques").then(({ data }) => {
      this.graftings = data;
      //this.dataTab();
    });
  },
  methods: {
    initAddunit() {
      this.errors = [];
      // this.reset();
      //$("#add_unit_model").modal("show");

      $("#add_unit_model").modal({
        backdrop: "static",
        keyboard: false,
      });

      setTimeout(() => {
        this.$refs.addunit.focus();
      }, 600);
    },
    editTech(val) {
      this.$router.push({ path: `/admin/graft-details/${val}/edit` });
    },

    createGraft() {
      axios
        .post("/admin/graft-techniques", {
          title: this.graft.title,
          description: this.graft.description,
          advantage: this.graft.advantage,
          disadvantage: this.graft.disadvantage,
          season: this.graft.season,
          pre_treatment: this.graft.pre_treatment,
          post_treatment: this.graft.post_treatment,
        })
        .then((response) => {
          this.reset();

          Swal.fire({
            title: "Success!",
            text: response.data.message,
            icon: "success",
            text: "I will close in 2 seconds.",
            timer: 2000,
          });

          $("#add_unit_model").modal("hide");
          this.readunits();
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.title) {
            this.errors.push(error.response.data.errors.title[0]);
          }

          if (error.response.data.errors.description) {
            this.errors.push(error.response.data.errors.description[0]);
          }
        });
    },
    updateunit() {
      axios
        .patch("/admin/plants/" + this.update_unit.id, {
          name: this.update_unit.name,
        })
        .then((response) => {
          $("#update_unit_model").modal("hide");

          Swal.fire({
            title: "Success!",
            text: response.data.message,
            icon: "success",
            text: "I will close in 2 seconds.",
            timer: 2000,
          });
        })
        .catch((error) => {
          this.errors = [];
          if (error.response.data.errors.name) {
            this.errors.push(error.response.data.errors.name[0]);
          }
        });
    },

    reset() {
      this.graft.title = "";
      this.graft.description = "";
      this.graft.advantage = "";
      this.graft.disadvantage = "";
      this.graft.season = "";
      this.graft.pre_treatment = "";
      this.graft.post_treatment = "";
    },
    readunits() {
      axios.get("/admin/graft-techniques").then(({ data }) => {
        this.graftings = data;
      });
    },
    dataTab() {
      $(function () {
        $("#unit-table").DataTable({
          dom:
            "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'rt>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          responsive: true,
          autoWidth: false,
          dataSrc: "Data",
          iDisplayLength: 10,
          buttons: [
            {
              extend: "excelHtml5",
              messageTop: "Mariano Marcos State University",
              exportOptions: {
                columns: ":visible",
              },
              className: "btn btn-outline-success btn-sm",
            },
            {
              extend: "pdfHtml5",
              messageTop: "Mariano Marcos State University",
              exportOptions: {
                columns: ":visible",
              },
              className: "btn btn-outline-danger btn-sm",
            },
            {
              extend: "colvis",
              className: "btn btn-outline-primary btn-sm",
            },
          ],

          processing: true,

          columnDefs: [{ responsivePriority: 0, targets: 2 }],
        });
      });
    },
  },
};
</script>