<template>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <!--<li class="nav-item">-->
            <!--<a class="nav-link" href="/register" target="_blank">-->
            <!--<span data-feather="home"></span>-->
            <!--Register User-->
            <!--</a>-->
            <!--</li>-->
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/admin/home"
                >Dashboard</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/admin/graft-details"
                >Graft Techniques</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/admin/plant-detail"
                >Plant Details</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/admin/plant"
                >Plant Name</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/admin/variety"
                >Variety</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/admin/register"
                >Users</router-link
              >
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="/admin/logout">Logout</a>
            </li> -->
          </ul>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "sidebar",
  data() {
    return {
      contact_details: "",
      config: {
        events: {
          initialized: function () {
            console.log("initialized");
          },
        },
        heightMin: 400,
        attribution: false,
        quickInsertEnabled: false,
      },
    };
  },
  methods: {
    contactDetailsModal(id) {
      this.user_id = id;
      this.contact_details = "";
      $("#contact_details_modal").modal({
        backdrop: "static",
        keyboard: false,
      });
      axios.post("/admin/get-contact-details", { id: id }).then(({ data }) => {
        this.contact_details = data[0]["description"];
      });
    },
    saveContactDetails() {
      axios
        .post("/admin/save-contact-details", {
          id: this.user_id,
          contact_details: this.contact_details,
        })
        .then(({ data }) => {
          if (data == 1) {
            this.$swal({
              type: "success",
              showCancelButton: false,
              showConfirmButton: false,
              allowOutsideClick: false,
              title: "Success",
              timer: 2000,
            }).then(() => {});
          } else {
            this.$swal({
              type: "error",
              title: "Ooops",
            });
          }
        });
    },
  },
};
</script>

<style scoped>
.modal-full {
  min-width: 97%;
}

.modal-full .modal-content {
  height: 90vh;
}
a.side-link:hover {
  background-color: yellow;
  color: #555;
}
.router-link-exact-active {
  background: #555;
  border-radius: 4px;
  color: red;
  font-variant: italic;
}
</style>
