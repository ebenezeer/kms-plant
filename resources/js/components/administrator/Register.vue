<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Register</div>

          <div class="card-body">
            <form @submit="saveForm">
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right"
                  >Name</label
                >

                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control"
                    name="name"
                    v-model="form.name"
                  />
                  <div class="text-danger" v-if="errors.name">
                    {{ errors.name[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right"
                  >E-Mail Address</label
                >

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    v-model="form.email"
                  />
                  <div class="text-danger" v-if="errors.email">
                    {{ errors.email[0] }}
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="role" class="col-md-4 col-form-label text-md-right"
                  >Role</label
                >

                <div class="col-md-6">
                  <select class="form-control" id="role" v-model="form.role">
                    <option value="1">Admin</option>
                    <option value="2">Expert</option>
                    <option value="3">User</option>
                  </select>
                  <div class="text-danger" v-if="errors.role">
                    {{ errors.role[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Password</label
                >

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    name="password"
                    v-model="form.password"
                  />
                  <div class="text-danger" v-if="errors.password">
                    {{ errors.password[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="password-confirm"
                  class="col-md-4 col-form-label text-md-right"
                  >Confirm Password</label
                >

                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    v-model="form.password_confirmation"
                  />
                  <div class="text-danger" v-if="errors.password">
                    {{ errors.password[1] }}
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Register
                  </button>
                </div>
              </div>
            </form>
            <!--  -->
            <br />
            <div class="row">
              <div class="table-responsive">
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <template v-for="(u, index) in users">
                      <tr>
                        <td>{{ u.id }}</td>
                        <td>{{ u.name }}</td>
                        <td>{{ u.email }}</td>
                        <td>
                          {{
                            u.role == 1
                              ? "ADMINISTRATOR"
                              : u.role == 2
                              ? "EXPERT"
                              : "PUBLIC USER"
                          }}
                        </td>
                        <td>
                          <div class="btn-group">
                            <button
                              @click="initUpdate(index)"
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
              </div>
            </div>
            <!--  -->
            <!-- MODAL UPDATE -->
            <div
              class="modal fade"
              tabindex="-1"
              role="dialog"
              id="update_unit_model"
            >
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
                      <strong>
                        Whoops, looks like something went wrong...</strong
                      >
                      <ul>
                        <template v-for="(error, index) in errors">
                          <li :key="index">{{ error }}</li>
                        </template>
                      </ul>
                    </div>

                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input
                        type="text"
                        ref="updateunit"
                        name="description"
                        id="description"
                        placeholder="Plant name"
                        class="form-control"
                        v-on:keyup.enter="updateunit"
                        v-model="update_unit.name"
                      />
                    </div>
                    <!-- <div class="form-group">
                      <label for="name">Description:</label>
                      <input
                        type="text"
                        name="description"
                        id="description"
                        placeholder="Plant name"
                        class="form-control"
                        v-model="update_unit.email"
                      />
                    </div> -->
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      @click="updateunit"
                      class="btn btn-primary"
                    >
                      Update
                    </button>
                    <button
                      type="button"
                      class="btn btn-default"
                      data-dismiss="modal"
                    >
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!--END UPDATE MODAL-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2/dist/sweetalert2.js";
export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        role: "2",
        password: "",
        password_confirmation: "",
      },

      users: [],
      update_unit: {},
      foods: [],
      errors: [],
    };
  },
  mounted() {
    this.getusers();
  },
  // created() {
  //     window.axios.get("/dod").then(({ data }) => {
  //         this.units = data;
  //         this.dataTab();
  //     });
  // },

  components: {},

  methods: {
    getusers() {
      axios.get("/admin/get-users").then(({ data }) => {
        this.users = data;
      });
    },
    initUpdate(index) {
      this.errors = [];
      $("#update_unit_model").modal("show");
      this.update_unit = this.users[index];
      setTimeout(() => {
        this.$refs.updateunit.focus();
        this.$refs.updateunit.select();
      }, 600);
    },
    updateunit() {
      axios
        .post("/admin/user-update", {
          //name: this.equipment.name,
          id: this.update_unit.id,
          name: this.update_unit.name,
          //  email: this.update_unit.email,
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
          // if (error.response.data.errors.email) {
          //   this.errors.push(error.response.data.errors.email[0]);
          // }
        });
    },
    saveForm(event) {
      event.preventDefault();

      axios
        .post("/admin/adminreg", {
          //name: this.equipment.name,
          name: this.form.name,
          email: this.form.email,
          role: this.form.role,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation,
        })
        .then((response) => {
          console.log("saved");
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

          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>