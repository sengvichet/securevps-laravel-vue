<template>
<div>
    <div class="reveal-overlay reveal-overlay-vue" v-if="show">
        <div id="order-boxes" class="reveal reveal-view-order"  v-bind:class="{'reveal-view-order2': showUpgradeWizard === true}">
            <div class="header-lined-order">
                <h1>
                    הזמנה מס {{ order.Table.DocEntry }}
                    <button type="button" name="button" class="button editorderbtn btnleftcorner" v-show="showEditButton" @click="showEditMenu = !showEditMenu">עריכה <i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                    <a @click.prevent="payNow()">
                        <button type="button" name="button" class="button btn-left-corner-second btn-success">שלם עכשיו</button>
                    </a>
                    <button class="close-button" type="button" @click.prevent="cancel()">
                        <span aria-hidden="true">×</span>
                    </button>
                </h1>
                <div class="edit-order-wrapper" v-show="showEditMenu">
                    <div class="eo-q">
                        <b>מה תרצה לעשות?</b>
                    </div>
                    <div>
                        <a class="pop-action" @click="showUpgradeWizard = true; showEditMenu = false">
                            1. לשנות את ההזמנה
                            <span class="note">(שינוי משאבים)</span>
                        </a><br />
                        <a class="pop-action" @click="openPopUp()">
                            2. לסגור את ההזמנה
                        </a>
                        <div class="back-wrapper">
                            <a class="pop-back" @click="showEditMenu = false">
                                &#10005 סגור
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <upgrade-order :order="order" v-if="showUpgradeWizard"></upgrade-order>

            <div class="row">
                <div class="text-center">
                    <spinner v-if="loading"></spinner>
                </div>
                <div class="small-12 columns">
                    <ul class="small-4 columns ul-clean">
                        <li>
                            <h4>פרטי הזמנה</h4></li>
                        <li>מזהה/קוד הזמנה: {{ order.Table.DocEntry }}</li>
                        <li>תאריך הזמנה: {{ order.Table.DocDate | date }}</li>
                        <li>סטטוס:
                            <span class="label green-label" v-show="order.Table.DocStatus === 'O'">הזמנה פתוחה</span>
                            <span class="label red-label" v-show="order.Table.DocStatus === 'C'">הזמנה סגורה</span>
                        </li>
                    </ul>
                    <ul class="small-4 columns ul-clean">
                        <li>
                            <h4>פרטי חיבור</h4></li>
                        <li>שם דומיין: {{ order.Table.U_ICR_DOMAIN_NAME }}</li>
                        <li>שם משתמש: {{ order.Table.U_ICR_CP_USER_NAME }}</li>
                        <li>סיסמה: {{ order.Table.U_ICR_CP_PASSWORD }}</li>
                    </ul>
                    <ul class="small-3 columns ul-clean">
                        <li>
                            <h4>פרטי לקוח</h4></li>
                        <li>כתובת: {{ order.Table.Address }}</li>
                        <li>טלפון: {{ order.Table.U_ICR_PHONE1 }}</li>
                        <li>אימייל: {{ order.Table.U_ICR_EMAIL1 }}</li>
                    </ul>
                </div>
            </div>

            <div class="expanded">
                <table class="table-childrow table-body-scroll-wrapper">
                    <thead class="thead-sale">
                        <tr>
                            <th>
                                מס
                            </th>
                            <th>
                                תיאור
                            </th>
                            <th>
                                ת. התחלה
                            </th>
                            <th>
                                ת. סיום
                            </th>
                            <th>
                                תזכורת
                            </th>
                            <th>
                                פעולה
                            </th>
                            <th>
                                מחירון
                            </th>
                            <th>
                                מחיר בפועל
                            </th>
                            <th>
                                כמות
                            </th>
                            <th>
                                מע"מ
                            </th>
                            <th>
                                סה"כ
                            </th>
                            <th>
                                IP
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="order.Table1.length != undefined" class="markpink" :class="{ refund: item.Quantity < 0 }" v-for="(item, key, index) in order.Table1">
                            <td>
                                {{ ++key }}
                            </td>
                            <td :title="item.ItemCode">
                                {{ item.Dscription }}<br />
                            </td>
                            <td>
                                {{ item.U_ICR_START_DATE | date }}
                            </td>
                            <td>
                                {{ item.U_ICR_END_DATE | date }}
                            </td>
                            <td>
                                {{ item.U_ICR_MEMO }}
                            </td>
                            <td>
                                {{ item.Quantity | isRefund }}
                            </td>
                            <td class="ltr">
                                {{ (item.Quantity < 0) ? item.U_ICR_MSRP * -1 : item.U_ICR_MSRP | currency }}
                            </td>
                            <td>
                                {{ item.Price | currency }}
                            </td>
                            <td>
                                {{ item.Quantity | quantity }}
                            </td>
                            <td class="ltr">
                                {{ (item.Quantity < 0) ? item.U_ICR_VAT * -1 : item.U_ICR_VAT | currency }}
                            </td>
                            <td class="ltr">
                                {{ (item.Quantity < 0) ? item.U_ICR_PRICE_WITHVAT * -1 : item.U_ICR_PRICE_WITHVAT | currency }}
                            </td>
                            <td>
                                {{ item.U_ICR_IP }}
                            </td>
                        </tr>
                        <tr v-if="order && order.Table1 && order.Table1.length == undefined" class="markpink" :class="{ refund: order.Table1.Quantity < 0 }">
                            <td>
                                1
                            </td>
                            <td :title="order.Table1.ItemCode">
                                {{ order.Table1.Dscription }}<br />
                            </td>
                            <td>
                                {{ order.Table1.U_ICR_START_DATE | date }}
                            </td>
                            <td>
                                {{ order.Table1.U_ICR_END_DATE | date }}
                            </td>
                            <td>
                                {{ order.Table1.U_ICR_MEMO }}
                            </td>
                            <td>
                                {{ order.Table1.Quantity | isRefund }}
                            </td>
                            <td class="ltr">
                                {{ (order.Table1.Quantity < 0) ? order.Table1.U_ICR_MSRP * -1 : order.Table1.U_ICR_MSRP | currency }}
                            </td>
                            <td>
                                {{ order.Table1.Price | currency }}
                            </td>
                            <td>
                                {{ order.Table1.Quantity | quantity }}
                            </td>
                            <td class="ltr">
                                {{ (order.Table1.Quantity < 0) ? order.Table1.U_ICR_VAT * -1 : order.Table1.U_ICR_VAT | currency }}
                            </td>
                            <td class="ltr">
                                {{ (order.Table1.Quantity < 0) ? order.Table1.U_ICR_PRICE_WITHVAT * -1 : order.Table1.U_ICR_PRICE_WITHVAT | currency }}
                            </td>
                            <td>
                                {{ order.Table1.U_ICR_IP }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="view-order-summarize">
                <h4>סיכום הזמנה</h4>
                <ul class="ul-clean">
                    <li>לפני מע"מ: {{ order.Table2.TotalBeforeVAT | currency }}</li>
                    <li>מע"מ: {{ order.Table2.VAT | currency }}</li>
                    <li>סה"כ: {{ order.Table2.TotalincludingVAT | currency }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { date, currency, quantity, intg, isRefund } from '../../utils'
import upgradeOrder from '../wizard/upgrade-order.vue'
import moment from 'moment'

import {
    userStore
} from '../../stores'

export default {
    name: 'modals--view-order',

    components: {
        spinner,
        upgradeOrder,
    },

    data() {
        return {
            show: false,
            loading: false,
            loadingUpgrade: false,
            order: {},
            showEditMenu: false,
            showUpgradeWizard: false,
            showEditButton: false,
            closeOrder: false,
        }
    },

    filters: {
        date,
        currency,
        quantity,
        intg,
        isRefund,
    },

    methods: {
        open(so) {
            this.show = true
            this.loading = true
            this.order.Table = so
            this.order.Table2 = so
            userStore.getOrderData(so).then((data) => {
                this.loading = false
                this.order.Table = data.data.Table;
//                this.order.Table1 = data.data.Table1;
                this.order.Table2 = data.data.Table2;

            if(data.data.Table1.length == undefined) {
                this.order.Table1 = data.data.Table1;
            }else{
                this.order.Table1 = _.orderBy(data.data.Table1, ['ItemCode', 'LineNum'], ['asc', 'asc'])
            }
                if(this.order.Table.DocStatus === 'O') {
                    this.showEditButton = true
                } else if(this.order.Table.DocStatus === 'C') {
                    if(moment().diff(this.order.Table1[this.order.Table1.length - 1].U_ICR_END_DATE, 'days') < 0) {
                        this.showEditButton = true
                    }
                }
            }).catch(error => {
                this.loading = false
            })
        },

        cancel() {
            this.show = false
            this.order = {}
        },
        openPopUp() {
            swal({
                title: 'סגירת הזמנה',
                text: 'על מנת לבצע סגירת הזמנה, אנא צור קשר עם מרכז התמיכה באימייל:\n' +
                'hosting@shev.com\n' +
                'או בטלפון:\n' +
                '03-6421228',
                type: 'success',
                confirmButtonText: 'סגור'
            })
        },
        payNow() {
            let params = {
                payfor_type: 'payNow',
                orderId: this.order.Table.DocEntry,
                total: this.order.Table2.TotalincludingVAT,
                domain: this.order.Table.U_ICR_DOMAIN_NAME,
                ipHost: this.order.Table1[0].U_ICR_IP,
                ItemCode: this.order.Table1[0].ItemCode,
            };
            userStore.setPayNowSummerize(params).then((data) => {
                location.href = '/payment';
            }).catch(error => {
                this.loading = false
            })
        },
    },

    created () {
        document.addEventListener("keydown", (e) => {
            if (this.show && !this.showUpgradeWizard && !this.showEditMenu && e.keyCode == 27) {
                this.cancel()
            } else if(this.show && this.showUpgradeWizard && e.keyCode == 27){
                this.showUpgradeWizard = false
            } else if(this.show && this.showEditMenu && e.keyCode == 27){
                this.showEditMenu = false
            }
        })
    }
}
</script>

<style lang="scss">
@import "../../../sass/partials/_vars.scss";

.edit-order-wrapper {
    position: absolute;
    top: 47px;
    left: 7px;
    width: 300px;
    background: $colorBlue3;
    padding: 20px;
    font-size: 0.9em;
    border-radius: 4px;
}

.edit-order-wrapper {
    a {
        color: $colorWhite;
    }
}

.edit-order-wrapper {
    a:hover {
       text-decoration: underline;
   }
}

.eo-q {
    margin-bottom: 10px;
    color: $colorWhite;
    font-size: 1.2em;
    text-decoration: underline;
}

.eo-q-w {
    margin-bottom: 10px;
    font-size: 1.75em;
    text-decoration: underline;
}

.note {
    color: rgba(255, 255, 255, 0.7);
}

.pop-back {
    color: #777;
    font-size: 0.9em;
}
.back-wrapper {
    margin-top: 30px;
    border-top: 1px solid #eee;
}

.upgrade-wizard-container {
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: flex-start;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1005;
    background-color: rgba(232, 232, 232, 0.75);
    cursor: default;
}

.upgrade-wizard-wrapper {
    border-radius: 4px;
    box-sizing: border-box;
    margin:4% auto;
    overflow-x: hidden;
    overflow-y: auto;
    display: none;
    position: relative;
    width: 700px;
    padding: 40px 0;
    background: $colorWhite;
    display: block;
    min-height: 280px;
    max-height: 500px;
    overflow: hidden;
    a:hover {
        text-decoration: underline;
    }
}

.upgrade-wizard-title {
    margin: -40px;
    padding: 8px;
    background-color: $colorBlue3;
    color: $colorWhite;
    text-align: center;
    border-radius: 3px 3px 0 0;
    margin-bottom: 12px;
}

.steps-indicator {
    display: inline-block;
    float: left;
    font-size: 0.5em;
    color: $colorGrey2;
}

.bold {
    font-weight: bold;
}

.adn-slider-upg {
    width: 200px;
    height: 60px;
}

.refund,.refund:hover {
    color: $colorRed2 !important;
}

.table-body-scroll-wrapper {
    tr {
        border-bottom: 1px solid $colorGrey3;
    }
}

.table-body-scroll-wrapper {
    td {
        padding: 1px;
    }
}

.ltr {
    direction: ltr;
}

.editorderbtn {
    background-color: $colorBlue3;

    &:hover {
        background-color: $colorBlue3;
    }

    &:focus {
        background-color: $colorBlue3;
    }
}
.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;

    &:hover, &:focus {
        background-color: #5cb85c;
        border-color: #4cae4c;
    }
}
.wait-loader{
   color: #c7c7c7;
}
.package-date-info{
    font-size: 19px;
    color: red;
}
.reveal-view-order2 {
    border-radius: 0;
}
</style>
