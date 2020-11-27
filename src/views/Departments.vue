<template>
  <div>
    <v-row>
      <v-col align="right">
        <v-btn
          elevation="4"
          @click.stop="dialog = true">
          New Department
        </v-btn>
      </v-col>
    </v-row>

    <v-row no-gutters class="justify-center">
      <v-data-table
        :headers="headers"
        :items="departments"
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
          <span class="headline">New Department</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-text-field label="Department" required aria-required="true" v-model="department.description"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-select :items="level" label="Level"></v-select>
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
import Form from "vform";

export default {
  name: "Departments",
  created() {

  },
  data: () => ({
    dialog: false,
    search: '',
    headers: [
      { text: 'Id', align: 'start', sortable: false, value: 'id' },
      { text: 'Description', value: 'description' },
      { text: 'Level', value: 'level' },
      { text: 'Active', value: 'isActive' },
      { text: 'Modified', value: 'updated_at' },
      { text: 'Created', value: 'created_at' },
    ],
    departments: [],
    level: ['0', '1', '2', '3'],
    department: {
      description: '',
      level: '',
      isActive: false,
    },
    form: new Form({
      description: '',
      level: '',
      isActive: false,
    }),
    date: new Date().toISOString().substr(0, 10),
  }),
  methods: {

  },
}
</script>

<style scoped>

</style>