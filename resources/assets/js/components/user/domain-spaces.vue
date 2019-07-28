<template>
    <div class="row">
        <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>
        <v-client-table :data="tableDiff" :columns="columnsDiff" :options="optionsDiff"></v-client-table>
        <!--<v-server-table url="/api/getDomainSpaces" :columns="columns" :options="options"></v-server-table>-->

        <div class="text-center">
            <spinner v-if="loading"></spinner>
        </div>
    </div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { userStore } from '../../stores'
import { adminStore  } from '../../stores'
import salesOrder from '../shared/sales-order.vue'
import statusLabel from '../shared/status-label.vue'
import invoiceReceiptsDomain from '../modals/invoice-receipts-domain.vue'
import { currency, quantity } from '../../utils'

export default {
    components: {
        spinner,
        salesOrder,
        statusLabel,
        invoiceReceiptsDomain,
    },

    data () {
        return {
            loading: true,
            columns: [
                'domainName',
                'docStatus',
                'docDate',
                'order_id',
                'numOrders',
                'total',
                'invoiceReceiptsDomain',
            ],
            columnsDiff: [
                'domainName'
            ],

            tableData: [],
            tableDiff: [],

            options: {
                headings: {
                    domainName: 'שם הדומיין',
                    docStatus: 'סטטוס הזמנות',
                    docDate: 'עודכן בתאריך',
                    order_id: 'מס הזמנה',
                    numOrders: 'כמות הזמנות',
                    total: 'סה"כ',
                    invoiceReceiptsDomain: 'חשבונית קבלה',
                },

                templates: {
                    salesOrder,
                    docStatus: statusLabel,
                    invoiceReceiptsDomain,
                    total: (createElement, row) => {
                        return currency(row.totalAmount);
                    },

                    numOrders: (createElement, row) => {
                        return quantity(row.numOrders);
                    }
                },

                customSorting: {
                    total: ascending => {
                        return (a, b) => {

                            let lastA = parseFloat(a.totalAmount);
                            let lastB = parseFloat(b.totalAmount);

                            if (ascending) {
                                return lastA <= lastB ? 1 : -1;
                            }

                            return lastA >= lastB ? 1 : -1;
                        }
                    },
                    docDate: ascending => {
                        return (a, b) => {

                            let aa = a.docDate.split('/').reverse().join(),
                                bb = b.docDate.split('/').reverse().join();
                            if (ascending) {
                                return  aa < bb ? -1: 1;
                            }
                            return aa > bb ? -1 : 1;
                        }
                    }
                },

                uniqueKey: 'domainName',
                childRow: salesOrder,

                sortable: [
                    'domainName',
                    'docStatus',
                    'docDate',
                    'order_id',
                    'numOrders',
                    'total',
                ],

                pagination: {
                    chunk: 10,
                    dropdown: false
                },
                perPageValues: [10, 25, 50],
                perPage: 10
            },
            optionsDiff: {
                headings: {
                    domainName: 'שם הדומיין'
                },


                uniqueKey: 'domainName',
                sortable: [
                    'domainName',
                ],

                pagination: {
                    chunk: 10,
                    dropdown: false
                },
                perPageValues: [10, 25, 50],
                perPage: 10
            }
        }
    },

   created () {
       this.getDomainSpaces();
    },

    methods: {
        getDomainSpaces () {
            adminStore.getDomainSpaces().then((data) => {
                this.loading = false;

                this.tableData = data.data;
                this.tableDiff = data.diff;
            }).catch(error => {
                this.loading = false
            })
        },
    }
}
</script>
