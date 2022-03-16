<template>
  <div>
    <router-link class="btn btn-primary" to="/expert/method-details/create"
      >Create</router-link
    >

    <table
      id="meth-table"
      class="table table-bordered table-striped table-sm dataTable"
      style="margin-top: 15px"
    >
      <thead class="table-dark">
        <tr>
          <th>Id</th>
          <th>Plant</th>
          <th>Variety</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="pm in plant_meth">
          <tr>
            <td>{{ pm.id }}</td>
            <td>{{ pm.name }}</td>
            <td>{{ pm.variety }}</td>
            <td>{{ pm.description }}</td>
            <td>action</td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      plant_meth: [],
      errors: [],
    };
  },
  created() {
    window.axios.get("/expert/plant-methods").then(({ data }) => {
      this.plant_meth = data;
      //this.dataTab();
    });
  },
  methods: {
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
</style>
