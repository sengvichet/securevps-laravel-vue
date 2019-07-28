<template>
    <div class="row">
        <v-server-table url="/api/admin/domain-spaces" :columns="columns" :options="options"></v-server-table>
    </div>
</template>

<script>
import btnLoginAsUser from '../shared/btn-login-as-user.vue'

export default {
    components: {
        btnLoginAsUser,
    },

    data() {
        return {
            loading: true,
            columns: [
                'LastOrderdate',
                'U_DOMAIN_NAME',
                'U_ICR_BP_NAME',
                'U_CP_USER_Name',
                'CardCode',
                'U_Active',
                'loginAsUser',
            ],

            tableData: [],

            options: {
                headings: {
                    LastOrderdate: 'ת. הזמנה אחרונה',
                    U_DOMAIN_NAME: 'שם הדומיין',
                    U_ICR_BP_NAME: 'שם מלא',
                    U_CP_USER_Name: 'שם משתמש',
                    CardCode: 'קוד משתמש',
                    U_Active: 'פעיל',
                    loginAsUser: 'כניסה כ',
                },

                templates: {
                    loginAsUser: (createElement, row) => {
                        let asUser = {
                            username: row.U_CP_USER_Name,
                            firstName: row.U_CLIENT_FNAME,
                            lastName: row.U_CLIENT_LNAME,
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

                uniqueKey: 'U_DOMAIN_NAME',

                sortable: [
                    'LastOrderdate',
                    'U_DOMAIN_NAME',
                    'U_ICR_BP_NAME',
                    'U_CP_USER_Name',
                    'CardCode',
                    'U_Active',
                ],

                filterable: [
                    'U_DOMAIN_NAME',
                    'U_ICR_BP_NAME',
                    'U_CP_USER_Name',
                    'CardCode',
                ],

                filterByColumn:true,
            }
        }
    }
}
</script>
