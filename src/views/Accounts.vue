<template>
  <div>
    <v-row>
      <v-col align="right">
        <v-btn
          elevation="4"
          @click.stop="dialog = true">
          New Account
        </v-btn>
      </v-col>
    </v-row>

    <v-row no-gutters class="justify-center">
      <v-data-table
        :headers="userHeaders"
        :items="userAccounts"
        item-key="id"
        :items-per-page="10"
        class="elevation-1"
        :search="search"
        :footer-props="{
          showFirstLastPage: true,
          firstIcon: 'mdi-arrow-collapse-left',
          lastIcon: 'mdi-arrow-collapse-right',
          prevIcon: 'mdi-minus',
          nextIcon: 'mdi-plus'
        }">
        <template v-slot:top>
          <v-text-field v-model="search" label="Search" class="mx-4"></v-text-field>
        </template>

        <template v-slot:item.actions="{ actions }">
          <v-btn
            class="mr-2"
            @click="editItem(actions)">
            mdi-pencil
          </v-btn>

          <v-btn
            class="mr-2"
            @click="editItem(actions)">
            mdi-delete
          </v-btn>
        </template>
      </v-data-table>
    </v-row>

    <v-dialog v-model="dialog">
      <v-card>
        <v-card-title>
          <span class="headline">New Employee</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-text-field label="Username" required aria-required="true" v-model="employee.username"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-text-field label="Password" required aria-required="true" v-model="employee.password"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col
                cols="12"
                md="4"
                sm="4">
                <v-text-field label="First Name" required aria-required="true" v-model="employee.firstName"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="4"
                sm="4">
                <v-text-field label="Middle Name" required aria-required="true" v-model="employee.middleName"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="4"
                sm="4">
                <v-text-field label="Last Name" required aria-required="true" v-model="employee.lastName"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-text-field label="Nickname" required aria-required="true" v-model="employee.nickname"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  :return-value.sync="date"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="date"
                      label="Picker in menu"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="date"
                    no-title
                    scrollable
                  >
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="menu = false"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.menu.save(date)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
              <v-col
                cols="12">
                <v-autocomplete solo label="Department" required aria-required="true" v-model="employee.jobs_id"></v-autocomplete>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            elevation="4"
            @click="dialog = false">
            Save
          </v-btn>

          <v-btn
            elevation="4"
            @click="dialog = false">
            Cancel
          </v-btn>

        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>
  import Form from 'vform';

  export default {
    name: "Accounts",
    created() {

    },
    data: () => ({
      dialog: false,
      search: '',
      userHeaders: [
        { text: 'Id', align: 'start', sortable: false, value: 'id' },
        { text: 'Last Name', value: 'lastName' },
        { text: 'First Name', value: 'firstName' },
        { text: 'Middle Name', value: 'middleName' },
        { text: 'Username', value: 'username' },
        { text: 'Nickname', value: 'nickname' },
        { text: 'Birthday', value: 'birthDate' },
        { text: 'Department', value: 'jobs_id' },
        { text: 'Active', value: 'isActive' },
        { text: 'Joined In', value: 'created_at' },
      ],
      userAccounts: [],
      employee: {
        firstName: '',
        middleName: '',
        lastName: '',
        nickname: '',
        birthDate: '',
        jobs_id: '',
        username: '',
        password: '',
        isActive: false,
      },
      form: new Form({
        firstName: '',
        middleName: '',
        lastName: '',
        nickname: '',
        birthDate: '',
        isActive: false,
        jobs_id: '',
        username: '',
        password: ''
      }),
      date: new Date().toISOString().substr(0, 10),
    }),
    methods: {

    },
  }
</script>

<style scoped>

</style>