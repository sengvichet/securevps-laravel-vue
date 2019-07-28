<template>
<div>
    <a v-if="hasInvoices" @click="showInvoicesAndReceipts()"><i class="fa fa-eye" aria-hidden="true"></i> חשבוניות/קבלות</a>
    <div class="reveal-overlay reveal-overlay-vue" v-if="show">
        <div class="reveal reveal-view-order">
            <div class="header-lined-order">
                <h1>
                    חשבוניות/קבלות לדומיין {{ domain }}
                    <button class="close-button" type="button" @click.prevent="cancel()">
                        <span aria-hidden="true">×</span>
                    </button>
                </h1>
            </div>

            <div class="reveal-content">
                <div class="text-center">
                    <spinner v-if="loading"></spinner>
                </div>

                <h3>חשבוניות</h3>
                <table class="table-childrow">
                    <tr>
                        <th>
                            מספר חשבונית
                        </th>
                        <th>
                            תאריך הפקת חשבונית
                        </th>
                        <th>
                            סה"כ
                        </th>
                        <th>
                            מספר הזמנה
                        </th>
                        <th>
                            הורדה
                        </th>
                    </tr>
                    <tr v-for="invc in invoices" class="row-action">
                        <td>
                            {{ invc.DocEntry }}
                        </td>
                        <td>
                            {{ invc.DocDate | date }}
                        </td>
                        <td>
                            {{ invc.DocTotal | currency }}
                        </td>
                        <td>
                            {{ invc.SaleOrder }}
                        </td>
                        <td>
                            <downloadPdf :pdfArgs="{DocEntry: invc.DocEntry, DocDate: invc.DocDate, doctype: 'invoice'}"></downloadPdf>
                        </td>
                    </tr>
                </table>

                <hr>

                <h3>קבלות</h3>
                <table class="table-childrow">
                    <tr>
                        <th>
                            מספר קבלה
                        </th>
                        <th>
                            מספר חשבונית
                        </th>
                        <th>
                            תאריך הפקת קבלה
                        </th>
                        <th>
                            סה"כ
                        </th>
                        <th>
                            הורדה
                        </th>
                    </tr>
                    <tr class="row-action">
                        <td>
                            {{ receipts.ReceiptNum }}
                        </td>
                        <td>
                            {{ receipts.invoiceDocEntry }}
                        </td>
                        <td>
                            {{ receipts.DocDate | date }}
                        </td>
                        <td>
                            {{ receipts.DocTotal | currency }}
                        </td>
                        <td>
                            <downloadPdf :pdfArgs="{DocEntry: receipts.ReceiptNum, DocDate: receipts.DocDate, doctype: 'receipt'}"></downloadPdf>
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { event } from '../../utils'
import { userStore } from '../../stores'
import { date, currency } from '../../utils'
import moment from 'moment'
import downloadPdf from '../modals/download-pdf.vue'

export default {
    name: 'invoice-receipts-domain',

    props:['data'],

    components: {
        spinner,
        downloadPdf,
    },

    data () {
        return {
            loading: false,
            show: false,
            domain: this.data.domainName,
            invoices: [],
            receipts: [],
            // createInvoiceSh: {
            //     Wrapper: false,
            //     spinner: false,
            //     link: false
            // },
            // downloadInvoicePdf: null,
            // countDown: 0,
        }
    },

    computed: {
        hasInvoices() {
            return this.data.docStatus !== 'O'
        }
    },

    filters: {
        date,
        currency,
    },

    methods: {
        showInvoicesAndReceipts () {
            this.getDomainInvoicesAndReceipts ()
            this.show = true
        },

        getDomainInvoicesAndReceipts () {
            this.loading = true
            userStore.getDomainInvoicesAndReceipts(this.domain).then(data => {
                this.loading = false
                this.invoices = data.data.invoices
                this.receipts = data.data.receipts
            }).catch(error => {
                this.loading = false
            })
        },

        cancel () {
            this.show = false
            this.invoices = []
        }
    }
}
</script>

<style lang="scss">
@import "../../../sass/partials/_vars.scss";

.reveal {
    &.reveal-view-order {
        padding: 0;
        margin: 0;
    }
}

.reveal-content {
    padding: 10px;
}
</style>
