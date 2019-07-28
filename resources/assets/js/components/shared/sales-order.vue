<template>
    <div>
        <table class="table-childrow">
            <tr>
                <th>
                </th>
                <th>
                    מס הזמנה
                </th>
                <th>
                    תאריך
                </th>
                <th>
                    סטטוס
                </th>
                <th>
                    סה"כ
                </th>
            </tr>
            <tr v-for="so in salesOrder" class="row-action" @click.prevent="viewOrder(so)" :class="{ active: currentView === so.docEntry }">
                <td class="eye-wrapper">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </td>
                <td>
                    {{ so.docEntry }}
                </td>
                <td>
                    {{ so.docDate }}
                </td>
                <td>
                    <span class="label green-label" v-show="so.docStatus === 'O'">הזמנה פתוחה</span>
                    <span class="label red-label" v-show="so.docStatus === 'C'">הזמנה סגורה</span>
                </td>
                <td>
                    {{ so.totalAmount | currency }}
                </td>
            </tr>
        </table>
        <view-order ref="viewOrder" />
    </div>
</template>

<script>
import viewOrder from '../modals/view-order.vue'
import { event } from '../../utils'
import { currency } from '../../utils'

export default {
    props:['data'],

    components: {
        viewOrder
    },

    filters: {
        currency
    },

    data () {
        return {
            salesOrder: '',
            currentView: 0,
        }
    },

    mounted  () {
        this.salesOrder = this.data.salesOrder
    },

    methods: {
        viewOrder(so) {
            this.$refs.viewOrder.open(so.docEntry)
            event.emit('currentView:so-reset')
            event.on({
                'currentView:so-reset': () => {
                    this.currentView = 0
                }
            })
            this.currentView = so.docEntry
        }
    }
}
</script>
