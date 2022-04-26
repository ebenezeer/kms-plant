<template>
  <div>
    <table
      id="meth-table"
      class="table table-bordered table-striped table-sm dataTable"
    >
      <thead class="table-dark">
        <tr>
          <th>Id</th>
          <th>Plant</th>
          <th>Variety</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(pm, index) in plant_meth">
          <tr>
            <td>{{ pm.id }}</td>
            <td>
              {{ pm.name }}<br />
              <small>{{ pm.description }}</small>
            </td>
            <td>{{ pm.variety }}</td>

            <td>
              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-success btn-sm"
                  @click="viewMet(pm.id)"
                >
                  <i class="fa fa-vcard"></i>
                </button>
              </div>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
import Swal from "sweetalert2/dist/sweetalert2.js";
export default {
  data() {
    return {
      plant_meth: [],
      plant_names: [],
      update_meth: {},
      errors: [],
    };
  },
  mounted() {},
  created() {
    window.axios.get("/public/plant-methods").then(({ data }) => {
      this.plant_meth = data;
      //this.dataTab();
    });
  },
  methods: {
    viewMet(val) {
      this.$router.push({ path: `/public/method-details/${val}/view` });
    },
  },
};
</script>

<style scoped>
</style>
