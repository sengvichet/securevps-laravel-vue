<template lang="html">
        <div>
            <div class="row">
                בחר
                <div class="button-group">
                    <a class="button submenu active" href="/user/invoices">חשבוניות</a>
                    <a class="button submenu" href="/user/receipts">קבלות</a>
                    <a class="button submenu" href="/user/credit-card">כרטיסי אשראי</a>
                </div>

                <div  v-if="yearsData.length > 0">כרטסת</div>

                <div class="button-group" v-if="yearsData.length > 0">
                        <div v-for="year in yearsData">
                            <a class="button submenu" @click="createInvoiceExcelByYear(year.Docyear)" download>{{ year.Docyear }}</a>
                        </div>
                </div>
            </div>
        </div>
</template>

<script>
    import { userStore } from '../../stores';

    export default {
         components: {},

        data (){
            return {
                loading: true,
                yearsData: '',
                createInvoiceExcel: '',
                downloadLink: null
            }
        },

        mounted () {
            this.getInvoiceYear();
        },

        methods: {
            getInvoiceYear () {
              userStore.getInvoiceYears()
              .then((data) => {
                  this.yearsData = data;
              }).catch(error => {
                    this.yearsData = 0;
              })
            },

             createInvoiceExcelByYear: function (params, event) {
              userStore.createInvoiceExcelByYear(params).then((data) => {

                     var parsedUrl = new URL(window.location.href);

                     if(data.path != undefined){
                         this.downloadLink = parsedUrl.origin + "\\downloadXls\\" + data.path;

                         location  = this.downloadLink;
                     }

              }).catch(error => {
                    this.createInvoiceExcel = 0;
              })
            }
        }
    }
</script>

