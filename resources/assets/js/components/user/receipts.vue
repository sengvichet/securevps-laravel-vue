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
    name: 'receipts',

    components: {
        spinner,
        downloadPdf,
    },

    data () {
        return {
            loading: true,
            columns: [
                'DocNum',
                'Ref1',
                'DocDate',
                'total',
                'btnDownloadPdf',
            ],

            tableData: [],

            options: {
                headings: {
                    DocNum: 'מספר קבלה',
                    Ref1: 'מספר חשבונית',
                    DocDate: 'תאריך',
                    total: 'סה"כ',
                    btnDownloadPdf: 'הורדה',
                },

                templates: {
                    btnDownloadPdf: (createElement, row) => {
                        let pdfArgs = {DocEntry: row.DocNum, DocDate: row.DocDate, doctype: 'receipt'}

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
                    'DocNum',
                    'Ref1',
                    'DocDate',
                    'total',
                ]
            }
        }
    },

    created () {
        userStore.getAllClientReceipts().then(data => {
            this.loading = false
            this.tableData = data.data
        }).catch(error => {
            this.loading = false
        })
    },

    methods: {
    }
}
</script>
