<template>
    <div class="row">
        <div>
            <a class="button alert" @click.prevent="destroySessions()">
                <i class="fa fa-trash" aria-hidden="true" v-if="!destroying"></i>
                <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="destroying"></i>
                destroy all sessions</a>
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
import btnDisconnect from '../shared/btn-disconnect.vue'
import { datetime } from '../../utils'

export default {
    components: {
        spinner,
        btnDisconnect,
    },

    data () {
        return {
            loading: true,
            destroying: false,
            columns: [
                'full_name',
                'user_name',
                'user_code',
                'ip_address',
                'created_at',
                'updated_at',
                'disconnect',
            ],

            tableData: [],

            options: {
                headings: {
                    full_name: 'שם מלא',
                    user_name: 'שם המשתמש',
                    user_code: 'קוד',
                    ip_address: 'IP',
                    created_at: 'נוצר',
                    updated_at: 'עודכן',
                    disconnect: 'נתק חיבור',
                },

                templates: {
                    disconnect: btnDisconnect,

                    created_at: (createElement, row) => {
                        return datetime(row.created_at);
                    },

                    updated_at: (createElement, row) => {
                        return datetime(row.updated_at);
                    },
                },

                sortable: [
                    'full_name',
                    'user_name',
                    'user_code',
                    'ip_address',
                    'created_at',
                    'updated_at',
                ]
            }
        }
    },

    created () {
        this.getSessions()
    },

    methods: {
        getSessions () {
            adminStore.getSessions().then((data) => {
                this.loading = false
                this.tableData = data
            }).catch(error => {
                this.loading = false
            })
        },

        destroySessions () {
            this.destroying = true
            adminStore.destroySessions().then((data) => {
                this.destroying = false
                this.getSessions()
            })
        },

        removeSessionRow (id) {
            let theindexis = _.findIndex(this.tableData, (o) => {
                return o.id === id
            })

            this.tableData.splice(theindexis, 1)
        }
    }
}
</script>
