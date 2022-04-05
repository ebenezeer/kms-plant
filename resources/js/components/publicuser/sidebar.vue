<template>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/publicuser/home"
                >Dashboard</router-link
              >
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link side-link"
                to="/expert/method-details"
                >Plant Grafting</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/expert/plant-detail"
                >Plant Details</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/expert/graft-details"
                >Graft Techniques</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/expert/plant-name"
                >Plant Name</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link side-link" to="/expert/variety"
                >Variety</router-link
              >
            </li>
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
    };
  },
  methods: {},
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
