<template>
  <div id="app" class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-success text-white p-3 vh-100">
      <!-- Admin Info -->
      <div class="d-flex align-items-center mb-4">
        <img src="https://via.placeholder.com/150" alt="Admin Avatar" class="rounded-circle" width="50" height="50" />
        <div class="ms-3">
          <h5>Admin Name</h5>
          <p class="mb-0">Administrator</p>
        </div>
      </div>

      <hr class="text-white" />

      <!-- Menu Items -->
      <ul class="nav flex-column">
        <li v-for="(item, index) in filteredMenuItems" :key="index" class="nav-item">
          <a class="nav-link text-white" href="#" @click="toggleSubMenu(index)">
            <i :class="'mdi ' + item.icon + ' me-2'"></i>
            {{ item.title }}
          </a>
          <!-- Submenu -->
          <ul v-if="item.expanded" class="nav flex-column ms-3">
            <li v-for="subItem in item.children" :key="subItem.title" class="nav-item">
              <a class="nav-link text-white" @click.prevent="navigateTo(subItem.route)">
                <i :class="'mdi ' + subItem.icon + ' me-2'"></i>
                {{ subItem.title }}
              </a>
            </li>
          </ul>
        </li>
      </ul>

      <hr class="text-white" />

      <!-- Logout -->
      <button class="btn btn-link text-white" @click="logout">
        <i class="mdi mdi-logout me-2"></i>Logout
      </button>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
  data() {
    return {
      menuItems: [
        {
          title: "User Lists",
          icon: "mdi-account-group",
          roles: [1],
          expanded: false,
          children: [
            { title: "View User Lists", icon: "mdi-account-multiple", route: "/userlist", roles: [1] },
            { title: "Create User", icon: "mdi-account-plus", route: "/createuser", roles: [1] },
          ],
        },
        {
          title: "Students",
          icon: "mdi-school",
          roles: [1, 2, 3],
          expanded: false,
          children: [
            { title: "View Students", icon: "mdi-account-multiple", route: "/students", roles: [1, 2, 3] },
            { title: "Add Student", icon: "mdi-account-plus", route: "/addstudent", roles: [1] },
          ],
        },
        {
          title: "Instructors",
          icon: "mdi-shield-account",
          roles: [1, 2, 3],
          expanded: false,
          children: [
            { title: "View Instructors", icon: "mdi-account-multiple", route: "/instructors", roles: [1, 2, 3] },
            { title: "Add Instructor", icon: "mdi-account-plus", route: "/addinstructor", roles: [1] },
          ],
        },
        {
          title: "Semesters",
          icon: "mdi-calendar-month",
          roles: [1, 2, 3],
          expanded: false,
          children: [
            { title: "View Semesters", icon: "mdi-calendar", route: "/semesters", roles: [1, 2, 3] },
            { title: "Add Semester", icon: "mdi-calendar-plus", route: "/addsemester", roles: [1] },
          ],
        },
        {
          title: "Courses",
          icon: "mdi-book",
          roles: [1, 2],
          expanded: false,
          children: [
            { title: "View Courses", icon: "mdi-book-open", route: "/courses", roles: [1, 2, 3] },
            { title: "Add Course", icon: "mdi-book-plus", route: "/addcourse", roles: [1] },
          ],
        },
      ],
    };
  },

  computed: {
    ...mapState(["roleId", "users"]),

    filteredMenuItems() {
      const roleId = this.roleId || 0;
      // Use a separate property to avoid modifying `menuItems`
      return this.menuItems
        .map((item) => {
          if (item.roles && !item.roles.includes(roleId)) return null;
          if (item.children) {
            item.children = item.children.filter((subItem) => {
              return !subItem.roles || subItem.roles.includes(roleId);
            });
          }
          return item;
        })
        .filter((item) => item !== null); // Remove null items (those not available for the role)
    },
  },

  methods: {
    ...mapActions(["fetchUsers"]),

    toggleSubMenu(index) {
      this.menuItems.forEach((item, i) => {
        item.expanded = i === index ? !item.expanded : false;
      });
    },

    navigateTo(route) {
      if (!route) {
        console.error("Route not defined for this item.");
        return;
      }

      console.log("Navigating to:", route);
      this.$router.push(route).catch((err) => {
        if (err.name !== "NavigationDuplicated") {
          console.error(err);
        }
      });
    },

    logout() {
      console.log("Logout clicked");
      localStorage.removeItem("role_id");
      this.$store.commit("setRoleId", null);
      this.$router.push("/login");
    },
  },

  mounted() {
    this.fetchUsers();

    const roleId = parseInt(localStorage.getItem("role_id"));
    if (roleId) {
      this.$store.commit("setRoleId", roleId);
    } else {
      console.error("No role_id found in localStorage.");
    }
  },
};
</script>

<style scoped>
#sidebar {
  width: 250px;
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
}

.mdi {
  font-size: 1.2rem;
}

.nav-link {
  cursor: pointer;
}
</style>
