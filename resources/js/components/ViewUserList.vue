<template>
  <div class="d-flex h-100" style="width: 100%;">
    <!-- Sidebar -->
    <SideBar  />

    <!-- Main Content Area -->
    <div class="flex-grow-1 p-4 bg-light ms-md-5" >
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0 text-center">User List</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table
              id="example"
              class="table table-striped table-hover table-bordered text-center align-middle w-100"
            >
              <thead>
                <tr>
                  <th style="width: 5%;">Id</th>
                  <th style="width: 20%;">Name</th>
                  <th style="width: 15%;">Phone</th>
                  <th style="width: 20%;">Email</th>
                  <th style="width: 10%;">Roles</th>
                  <th style="width: 10%;">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.phone }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <span v-if="user.role" class="badge bg-info text-dark">
                      {{ user.role.name }}
                    </span>
                    <span v-else class="text-muted">No Role</span>
                  </td>
                  <td class="d-flex justify-content-center">
                    <!-- Add actions here (e.g., edit, delete) -->
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SideBar from './SideBar.vue';
import { mapState, mapActions } from "vuex";

export default {
  name: "ViewUserList",
  components: {
    SideBar,
  },
  computed: {
    ...mapState(["users", "roles"]),
  },
  methods: {
    ...mapActions(["fetchUsers", "fetchRoles"]),
  },
  mounted() {
    this.fetchUsers();
    this.fetchRoles();
  }
}
</script>

<style scoped>
/* Optional styles for the table and layout */
.table {
  table-layout: fixed;
}
</style>
