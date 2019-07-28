<template>
    <div class="row">
        <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>
        <div class="text-center">
            <spinner v-if="loading"></spinner>
        </div>
    </div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { adminStore } from '../../stores'
import btnLoginAsUser from '../shared/btn-login-as-user.vue'

export default {
    components: {
        spinner,
        btnLoginAsUser,
    },

    data() {
        return {
            loading: true,
            columns: [
                'U_WEBSITE_USERNAME',
                'CardName',
                'U_CLIENT_EMAIL1',
                'CreateDate',
                'CardCode',
                'loginAsUser',
            ],

            tableData: [],

            options: {
                headings: {
                    U_WEBSITE_USERNAME: 'שם המשתמש',
                    CardName: 'שם מלא',
                    U_CLIENT_EMAIL1: 'אימייל',
                    CreateDate: 'הרשמה',
                    CardCode: 'קוד משתמש',
                    loginAsUser: 'כניסה כ',
                },

                templates: {
                    loginAsUser: (createElement, row) => {
                        let asUser = {
                            username: row.U_WEBSITE_USERNAME,
                            firstName: row.CardName.split(" ")[0],
                            lastName: row.CardName.split(" ")[1],
                            password: '',
                            BPCode: row.CardCode,
                        }

                        return createElement(btnLoginAsUser, {
                                                    props: {
                                                        asUser: asUser
                                                    }
                                                }, '')
                    }
                },

                sortable: [
                    'U_WEBSITE_USERNAME',
                    'CardName',
                    'U_CLIENT_EMAIL1',
                    'CreateDate',
                    'CardCode'
                ]
            }
        }
    },

    created() {
        adminStore.getAllUsers().then((data) => {
            this.loading = false
            this.tableData = data
        }).catch(error => {
            this.loading = false
        })
    }
}
</script>
