<template>
  <div class="row">
    <div>
      <a class="button" @click.prevent="importItems()">
        <i class="fa fa-download" aria-hidden="true" v-if="!importing"></i>
        <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="importing"></i>
        import items
      </a>
      <a class="button alert" @click.prevent="destroyItems()">
        <i class="fa fa-trash" aria-hidden="true" v-if="!destroying"></i>
        <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="destroying"></i>
        destroy items
      </a>
      <a class="button alert" @click.prevent="destroyAll()">
        <i class="fa fa-trash" aria-hidden="true" v-if="!destroying"></i>
        <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="destroying"></i>
        Total Clean
      </a>
    </div>
    <v-client-table
      class="v-client-table-font-size"
      :data="tableData"
      :columns="columns"
      :options="options"
    ></v-client-table>
    <div class="text-center">
      <spinner v-if="loading"></spinner>
    </div>
  </div>
</template>

<script>
import spinner from "../shared/spinner.vue";
import { adminStore } from "../../stores";
import activeButton from "../shared/active-button.vue";
import { currency } from "../../utils";

export default {
  components: {
    spinner,
    activeButton
  },

  data() {
    return {
      importing: false,
      destroying: false,
      loading: true,
      columns: [
        "id",
        "description",
        "msrp",
        "price",
        "vat",
        "item_type",
        "item_os",
        "user_level",
        "free_trial",
        "billing",
        "pro_rata_logic",
        "active",
        "min_slider",
        "max_slider",
        "interval_slider",
        "default_slider"
      ],
      tableData: [],
      options: {
        headings: {
          id: "קוד פריט",
          description: "תיאור",
          msrp: "מחירון",
          price: "מחיר",
          vat: 'מע"מ',
          item_type: "סוג",
          item_os: "OS",
          user_level: "רמה",
          free_trial: "נסיון",
          billing: "חיובים",
          pro_rata_logic: "הגיון",
          active: "סטטוס",
          min_slider: "מִינִימוּם",
          max_slider: "מַקסִימוּם",
          interval_slider: "הַפסָקָה",
          default_slider: "בְּרִירַת מֶחדָל"
        },
        templates: {
          active: activeButton,

          msrp: (createElement, row) => {
            return currency(row.msrp);
          },

          price: (createElement, row) => {
            return currency(row.price);
          },

          vat: (createElement, row) => {
            return currency(row.vat);
          }
        },
        uniqueKey: "id",
        sortable: [
          "id",
          "description",
          "msrp",
          "price",
          "vat",
          "item_type",
          "item_os",
          "user_level",
          "free_trial",
          "billing",
          "pro_rata_logic",
          "active",
          "min_slider",
          "max_slider",
          "interval_slider",
          "default_slider"
        ]
      }
    };
  },

  created() {
    this.getItems();
  },

  methods: {
    getItems() {
      adminStore
        .getItems()
        .then(data => {
          this.loading = false;
          this.tableData = data;
        })
        .catch(error => {
          this.loading = false;
        });
    },

    importItems() {
      this.importing = true;
      adminStore.importItems().then(data => {
        this.importing = false;
        this.getItems();
      });
    },

    destroyItems() {
      this.destroying = true;
      adminStore.destroyItems().then(data => {
        this.destroying = false;
        this.getItems();
      });
    },

    destroyAll() {
      this.destroying = true;
      adminStore.destroyAll().then(data => {
        this.destroying = false;
        this.getItems();
      });
    }
  }
};
</script>
