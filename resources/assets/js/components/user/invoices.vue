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
import { userStore } from '../../stores'
import downloadPdf from '../modals/download-pdf.vue'
import { currency } from '../../utils'

export default {
    name: 'invoices',

    components: {
        spinner,
        downloadPdf,
    },

    data () {
        return {
            loading: true,
            columns: [
                'DocEntry',
                'DocDate',
                'DocStatus',
                'U_ICR_DOMAIN_NAME',
                'total',
                'btnDownloadPdf',
            ],

            tableData: [],

            pagination: { dropdown:false },

            options: {
                headings: {
                    DocEntry: 'מספר חשבונית',
                    DocDate: 'תאריך',
                    DocStatus: 'סטטוס',
                    U_ICR_DOMAIN_NAME: 'דומיין',
                    total: 'סה"כ',
                    btnDownloadPdf: 'הורדה',
                },

                templates: {
                    btnDownloadPdf: (createElement, row) => {
                        let pdfArgs = {DocEntry: row.DocEntry, DocDate: row.DocDate, doctype: 'invoice'}

                        return createElement(
                            downloadPdf,
                            {
                                props: {
                                    pdfArgs: pdfArgs
                                }
                            }
                        )
                    },

                    total: (createElement, row) => {
                        return currency(row.DocTotal);
                    }
                },

                customSorting: {
                    total: function (ascending) {
                        return function (a, b) {
                            let lastA = parseFloat(a.DocTotal);
                            let lastB = parseFloat(b.DocTotal);

                            if (ascending) {
                                return lastA <= lastB ? 1 : -1;
                            }

                            return lastA >= lastB ? 1 : -1;
                        }
                    }
                },

                sortable: [
                    'DocEntry',
                    'DocDate',
                    'DocStatus',
                    'U_ICR_DOMAIN_NAME',
                    'total',
                ],
            }
        }
    },

    created () {
        userStore.getAllClientInvoices().then(data => {
            this.loading = false
            this.tableData = data.data
        }).catch(error => {
            this.loading = false
        })
    },

    methods: {
        foo () {
            console.log('bar')
            //console.log(this.row)
        }
    }
}
</script>
