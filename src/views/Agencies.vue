<template>
  <div>
    <v-row>
      <v-col align="right">
        <v-btn
          elevation="4"
          @click.stop="dialog = true">
          New Agency
        </v-btn>
      </v-col>
    </v-row>

    <v-row no-gutters class="justify-center">
      <v-data-table
        :headers="agencyHeaders"
        :items="agencies"
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
          <span class="headline">New Agency</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-text-field label="Advertiser Name" required aria-required="true" v-model="agency.agencyName"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="6"
                sm="6">
                <v-autocomplete label="Account Executive (AE)" required aria-required="true" v-model="agency.accountExecutive"></v-autocomplete>
              </v-col>
            </v-row>
            <v-row>
              <v-col
                cols="12"
                md="4"
                sm="4">
                <v-text-field label="Agency Address" required aria-required="true" v-model="agency.address"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="4"
                sm="4">
                <v-text-field label="Agency Contact" required aria-required="true" v-model="agency.contact"></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="4"
                sm="4">
                <v-select :items="accreditation" label="Accredited by KBP"></v-select>
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
  name: "Agencies",
  created() {

  },
  data: () => ({
    dialog: false,
    search: '',
    agencyHeaders: [
      { text: 'Id', align: 'start', sortable: false, value: 'id' },
      { text: 'Agency Name', value: 'agencyName' },
      { text: 'Account Executive (AE)', value: 'accountExecutive' },
      { text: 'Contact Number', value: 'contact' },
      { text: 'Address', value: 'address' },
      { text: 'Accredited', value: 'accredited' },
      { text: 'Active', value: 'isActive' },
      { text: 'Modified', value: 'updated_at' },
      { text: 'Created', value: 'created_at' },
    ],
    agencies: [],
    accreditation: [
      'Yes', 'No'
    ],
    agency: {
      agencyName: '',
      accountExecutive: '',
      contact: '',
      address: '',
      accredited: '',
      isActive: false,
    },
    form: new Form({
      agencyName: '',
      accountExecutive: '',
      contact: '',
      address: '',
      accredited: '',
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