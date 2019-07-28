<template>
    <div class="row">
        <v-server-table url="/api/admin/users" :columns="columns" :options="options"></v-server-table>
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
                    var FName;
                    var LName;
                    var name = row.CardName.split(' ');
                        if(name[0] && name[1]){
                            FName = name[0];
                            LName = name[1];
                        } else {
                            FName = name[0];
                            LName = '';
                        }

                        let asUser = {
                            username: row.U_WEBSITE_USERNAME,
                            firstName: FName,
                            lastName: LName,
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

                // uniqueKey: 'U_WEBSITE_USERNAME',
                // uniqueKey: 'U_DOMAIN_NAME',

                sortable: [
                    'U_WEBSITE_USERNAME',
                    'CardName',
                    'U_CLIENT_EMAIL1',
                    'CreateDate',
                    'CardCode'
                ],

                filterable: [
                    'U_WEBSITE_USERNAME',
                    'CardName',
                    'CardCode'
                ],

                filterByColumn:true,
                pagination: {
                    chunk: 10,
                    dropdown: false
                },
                perPageValues: [25, 50],
                perPage: 25
            }
        }
    }
}
</script>
