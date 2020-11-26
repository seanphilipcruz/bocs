<template>
  <v-app>
    <v-navigation-drawer app
       v-model="drawer"
       absolute
       temporary>

      <v-list>
        <v-list-item>
          <v-list-item-avatar>
            <v-img src="../src/assets/images/default-profile.png"></v-img>
          </v-list-item-avatar>
        </v-list-item>

        <v-list-item link>
          <v-list-item-content>
            <v-list-item-title class="title">
              Sean Philip Cruz
            </v-list-item-title>
            <v-list-item-subtitle>sean@rx931.com</v-list-item-subtitle>
          </v-list-item-content>

          <v-list-item-action>
            <v-icon>mdi-menu-down</v-icon>
          </v-list-item-action>
        </v-list-item>

      </v-list>
      <v-divider></v-divider>
      <v-list
         nav
         dense>

        <v-list-item-group
           v-model="group"
           active-class="cyan--text text--accent-4"
        >

          <v-list-item v-for="(navigation, index) in nav" :key="index" :to="{ name: navigation.route }">
            <v-list-item-icon>
              <v-icon>{{ navigation.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{ navigation.title }}</v-list-item-title>
          </v-list-item>

        </v-list-item-group>

      </v-list>
      <v-divider></v-divider>
      <v-list>
        <v-list-item-group>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>

        </v-list-item-group>
      </v-list>

    </v-navigation-drawer>

    <v-app-bar app
       absolute
       color="cyan lighten-1"
       elevate-on-scroll
    >
      <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
      <v-toolbar-title>Broadcast Order & Contracts System</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "App",
  data: () => ({
    drawer: false,
    group: null,
    nav: [
      { icon: 'mdi-home', title: 'Home', route: 'Home' },
      { icon: 'mdi-account-cog', title: 'Manage Accounts', route: 'Users' },
      { icon: 'mdi-office-building', title: 'Departments', route: 'Departments' },
      { icon: 'mdi-briefcase', title: 'Contracts', route: 'Contracts' },
      { icon: 'mdi-currency-php', title: 'Sales', route: 'Sales' },
      { icon: 'mdi-clipboard-list', title: 'Logs', route: 'Logs' }
    ]
  })
}
</script>

<style scoped>

</style>