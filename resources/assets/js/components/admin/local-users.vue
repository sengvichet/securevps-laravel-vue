<template>
    <div class="row">
        <div>
            <a class="button alert" @click.prevent="trancate()">
                <i class="fa fa-trash" aria-hidden="true" v-if="!destroying"></i>
                <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="destroying"></i>
                clean users table</a>
        </div>
        <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>
        <div class="text-center">
            <spinner v-if="loading"></spinner>
        </div>
    </div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { adminStore } from '../../stores'
import btnDelete from '../shared/btn-delete.vue'
import { datetime } from '../../utils'

export default {
    components: {
        spinner,
        btnDelete
    },

    data() {
        return {
            loading: true,
            destroying: false,
            columns: [
                'first_name',
                'last_name',
                'email',
                'verified',
                'token',
                'created_at',
                'updated_at',
                'delete'
            ],

            tableData: [],

            options: {
                headings: {
                    first_name: 'שם פרטי',
                    last_name: 'שם משפחה',
                    email: 'אימייל',
                    verified: 'אושר',
                    token: 'אסימון',
                    created_at: 'נוצר',
                    updated_at: 'עודכן',
                    delete: 'מחיקה',
                },

                templates: {
                    delete: btnDelete,

                    created_at: (createElement, row) => {
                        return datetime(row.created_at);
                    },

                    updated_at: (createElement, row) => {
                        return datetime(row.updated_at);
                    },
                },

                sortable: [
                    'first_name',
                    'last_name',
                    'email',
                    'verified',
                    'token',
                    'created_at',
                    'updated_at',
                ]
            }
        }
    },

    created() {
        this.getLocalUsers()
    },

    methods: {
        getLocalUsers () {
            adminStore.getLocalUsers().then((data) => {
                this.loading = false
                this.tableData = data
            }).catch(error => {
                this.loading = false
            })
        },

        trancate () {
            this.destroying = true
            adminStore.trancateLocalUsers().then((data) => {
                this.destroying = false
                this.getLocalUsers()
            }).catch(error => {
                this.destroying = false
            })
        },

        removeUserRow (id) {
            let theindexis = _.findIndex(this.tableData, function(o) {
                return o.id === id
            })
            console.log(theindexis);
            this.tableData.splice(theindexis, 1)
        }
    }
}
</script>
