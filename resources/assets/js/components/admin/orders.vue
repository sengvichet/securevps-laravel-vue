<template>
    <div class="row">
        <v-server-table url="/api/admin/orders" :columns="columns" :options="options"></v-server-table>
    </div>
</template>

<script>
import btnLoginAsUser from '../shared/btn-login-as-user.vue'
import { currency } from '../../utils'

export default {
    components: {
        btnLoginAsUser,
    },

    data() {
        return {
            loading: true,
            columns: [
                'DocNum',
                'DocStatus',
                'DocDate',
                'CardCode',
                'CardName',
                'DocTotal',
                'U_ICR_DOMAIN_NAME',
                'U_WEBSITE_USERNAME',
                'btnLoginAsUser',
            ],

            tableData: [],

            options: {
                headings: {
                    DocNum: 'מס הזמנה',
                    DocStatus: 'סטטוס',
                    DocDate: 'תאריך',
                    CardCode: 'קוד משתמש',
                    CardName: 'שם מלא',
                    DocTotal: 'סך הכל',
                    U_ICR_DOMAIN_NAME: 'דומיין',
                    U_WEBSITE_USERNAME: 'שם משתמש',
                    btnLoginAsUser: 'כניסה כ',
                },

                templates: {
                    btnLoginAsUser: (createElement, row) => {
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
                    },

                    DocTotal: (createElement, row) => {
                        return currency(row.DocTotal);
                    },

                    DocStatus: (createElement, row) => {
                        if (row.DocStatus === 'C') {
                            return createElement('span', {
                                                        attrs: {
                                                            class: 'label red-label'
                                                        }
                                                    }, 'הזמנה סגורה')
                        }

                        if (row.DocStatus === 'O') {
                            return createElement('span', {
                                                        attrs: {
                                                            class: 'label green-label'
                                                        }
                                                    }, 'הזמנה פתוחה')
                        }
                    }
                },

                uniqueKey: 'DocNum',

                sortable: [
                    'DocNum',
                    'DocStatus',
                    'DocDate',
                    'CardCode',
                    'CardName',
                    'DocTotal',
                    'U_ICR_DOMAIN_NAME',
                    'U_WEBSITE_USERNAME',
                ],

                filterable: [
                    'DocNum',
                    'CardCode',
                    'CardName',
                    'U_ICR_DOMAIN_NAME',
                    'U_WEBSITE_USERNAME',
                ],

                filterByColumn: true,
            }
        }
    }
}
</script>
