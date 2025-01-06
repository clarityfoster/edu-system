<template>
  <div id="app" class="d-flex position-relative">
    <!-- Sidebar -->
    <aside
      id="sidebar"
      class="sidebar bg-primary text-light vh-100 shadow-sm d-none d-lg-block"
      :class="{ 'collapsed': isCollapsed }"
    >
      <!-- Header -->
      <div class="nav flex-column pt-3">
        <div class="d-flex align-items-center mb-4">
          <img
            src="https://via.placeholder.com/150"
            alt="Admin Avatar"
            class="rounded-circle"
            width="50"
            height="50"
          />
          <div v-if="!isCollapsed" class="ms-3">
            <h5>{{ authUsers.name }}</h5>
            <!-- <p class="mb-0">{{ authUsers.role.name }}</p> -->
          </div>
        </div>

        <hr class="text-white" />

        <!-- Menu Items -->
        <ul class="nav flex-column">
          <li v-for="(item, index) in filteredMenuItems" :key="index" class="nav-item">
            <a
              class="nav-link text-white d-flex align-items-center"
              href="#"
              @click="toggleSubMenu(index)"
              :class="{ active: isActive(item) }"
            >
              <i :class="'mdi ' + item.icon + ' me-2'"></i>
              <span v-if="!isCollapsed">{{ item.title }}</span>
            </a>
            <!-- Submenu -->
            <ul v-if="item.expanded" class="nav flex-column ms-3">
              <li v-for="subItem in item.children" :key="subItem.title" class="nav-item">
                <a
                  class="nav-link text-white"
                  @click.prevent="navigateTo(subItem.route)"
                  :class="{ active: isActive(subItem) }"
                >
                  <i :class="'mdi ' + subItem.icon + ' me-2'"></i>
                  {{ subItem.title }}
                </a>
              </li>
            </ul>
          </li>
        </ul>

        <hr class="text-white" />

        <!-- Logout -->
        <button
          class="btn btn-link text-white d-flex align-items-center"
          @click="logout"
        >
          <i class="mdi mdi-logout me-2"></i>
          <span v-if="!isCollapsed">Logout</span>
        </button>
      </div>

      <!-- Toggle Button -->
      <button
        class="btn btn-light toggle-btn"
        @click="toggleSidebar"
        aria-label="Toggle Sidebar"
      >
        <i class="mdi" :class="isCollapsed ? 'mdi-menu' : 'mdi-chevron-left'"></i>
      </button>

    </aside>

  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
  name: "SideBar",
  data() {
    return {
      menuItems: [
        {
          title: "User Lists",
          icon: "mdi-account-group",
          roles: [1],
          expanded: false,
          children: [
            {
              title: "View User Lists",
              icon: "mdi-account-multiple",
              route: "/viewuserlist",
              roles: [1],
            },
            {
              title: "Create User",
              icon: "mdi-account-plus",
              route: "/createuser",
              roles: [1],
            },
          ],
        },
         {
          title: "Students",
          icon: "mdi-school",
          roles: [1, 2, 3],
          expanded: false,
          children: [
            { title: "View Students", icon: "mdi-account-multiple", route: "/studentlist", roles: [1, 2, 3] },
            { title: "Add Student", icon: "mdi-account-plus", route: "/addstudent", roles: [1] },
          ],
        },
        {
          title: "Instructors",
          icon: "mdi-shield-account",
          roles: [1, 2, 3],
          expanded: false,
          children: [
            { title: "View Instructors", icon: "mdi-account-multiple", route: "/instructorlist", roles: [1, 2, 3] },
            { title: "Add Instructor", icon: "mdi-account-plus", route: "/addinstructor", roles: [1] },
          ],
        },
        {
          title: "Semesters",
          icon: "mdi-calendar-month",
          roles: [1, 2, 3],
          expanded: false,
          children: [
            { title: "View Semesters", icon: "mdi-calendar", route: "/semesterlist", roles: [1, 2, 3] },
            { title: "Add Semester", icon: "mdi-calendar-plus", route: "/addsemester", roles: [1] },
          ],
        },
        {
          title: "Courses",
          icon: "mdi-book",
          roles: [1, 2, 3],
          expanded: false,
          children: [
            { title: "View Courses", icon: "mdi-book-open", route: "/courselist", roles: [1, 2, 3] },
            { title: "Add Course", icon: "mdi-book-plus", route: "/addcourse", roles: [1] },
          ],
        },

      ],
      isCollapsed: false,
    };
  },

  computed: {
    ...mapState(["roleId","users","authUsers"]),

    filteredMenuItems() {
      const roleId = this.roleId || 0;
      return this.menuItems
        .map((item) => {
          if (!item.roles.includes(roleId)) return null;
          if (item.children) {
            item.children = item.children.filter(
              (subItem) => !subItem.roles || subItem.roles.includes(roleId)
            );
          }
          return item;
        })
        .filter((item) => item);
      },
    filteredMenuItems() {
  const roleId = this.roleId || 0;
  return this.menuItems
    .map((item) => {
      // Filter out items not allowed for this role
      if (!item.roles.includes(roleId)) return null;

      // Filter children for this role
      if (item.children) {
        item.children = item.children.filter(
          (subItem) => !subItem.roles || subItem.roles.includes(roleId)
        );
      }
      return item;
    })
    .filter((item) => item && item.children && item.children.length > 0); // Ensure non-empty items
},


  },

  methods: {
    ...mapActions(["fetchUsers","fetchAuthUsers"]),

    toggleSubMenu(index) {
      this.menuItems.forEach((item, i) => {
        item.expanded = i === index ? !item.expanded : false;
      });
      },



    navigateTo(route) {
      if (!route) return;
      this.$router.push(route).catch((err) => {
        if (err.name !== "NavigationDuplicated") {
          console.error(err);
        }
      });
    },

    isActive(item) {
      return this.$route.path === item.route;
      },



    toggleSidebar() {
      this.isCollapsed = !this.isCollapsed;
    },

    logout() {
      console.log("Logout clicked");
      localStorage.removeItem("role_id");
      this.$store.commit("setRoleId", null);
      this.$router.push("/");
    },
  },

  mounted() {
    this.fetchUsers();
    this.fetchAuthUsers();
    const roleId = parseInt(localStorage.getItem("role_id"));
    if (roleId) {
      this.$store.commit("setRoleId", roleId);
    }
  },
};
</script>

<style scoped>
/* Styles for sidebar */
#sidebar {
  width: 250px;
  transition: width 0.3s;
}
#sidebar.collapsed {
  width: 70px;
}
.sidebar {
  position: sticky;
  top: 0;
  overflow-y: auto;
}
.toggle-btn {
  position: absolute;
  top: 10px;
  right: -20px;
  z-index: 1000;
}
.nav-link {
  cursor: pointer;
}
.nav-link.active {
  background-color: rgba(255, 255, 255, 0.2);
}
</style>
