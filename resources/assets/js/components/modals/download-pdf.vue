<template>
    <div>
        <a class="btn-download-pdf" @click="createPdf"><i class="fa fa-download" aria-hidden="true"></i>
            הורדה
        </a>
        <div class="upgrade-wizard-container" v-if="show.modal">
            <div id="order-boxes" class="reveal reveal-view-order reveal-download">

                <div class="header-lined-order-download">
                    הורדת מסמך
                    <button class="close-button" type="button" @click.prevent="cancel()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="downloading-invoice-wrapper-st" :class="{'downloading-invoice-wrapper': show.spinner}" v-show="show.wrapper">
                    <div v-show="show.spinner" class="text-center">
                        <i class="fa fa-refresh fa-spin fa-fw"></i>
                        אנא המתן
                        {{ countDown }}
                        שניות, מכין את המסמך שלך
                    </div>
                    <div v-if="show.link" class="text-center">
                        <a id="alinkid" :href="downloadLink" download>
                            <i class="fa fa-download" aria-hidden="true"></i>
                            אם ההורדה אינה מתחילה <u>לחץ כאן</u></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { userStore } from '../../stores'
import moment from 'moment'

export default {

    name: 'downloadPdf',

    components: {
        spinner,
    },

    props: ['pdfArgs'],

    data () {
        return {
            loading: true,
            downloadLink: null,
            countDown: 0,
            show: {
                modal: false,
                Wrapper: false,
                spinner: false,
                link: false
            },
            waitInSeconds: null,
            clickOnTimeout: null,
        }
    },

    created () {
        document.addEventListener("keydown", (e) => {
            if (this.show.modal && e.keyCode == 27) {
                this.cancel()
            }
        })
    },

    methods: {

        toDateArg (thedate) {
            return moment(thedate).format('YYYY-MM-DD')
        },

        createPdf () {
            this.loading = true
            this.show.modal = true
            this.show.wrapper = true
            this.show.spinner = true
            this.countDown = 30

            this.waitInSeconds = setInterval(() => {
                if (this.countDown > 0) {
                    this.countDown--
                }  else {
                    this.countDown = 9
                }
            }, 1000);


            let createFunction = {
                invoice: userStore.createInvoice,
                receipt: userStore.createReceipt,
            }

            let bakasha = userStore.createPdf(this.pdfArgs.DocEntry, this.toDateArg(this.pdfArgs.DocDate), this.pdfArgs.doctype).then(data => {
                console.log('call createPdf API');
                this.loading = false
                this.show.spinner = false
                this.show.link = true
                this.countDown = 30
                
                clearInterval(this.waitInSeconds)
                clearTimeout(this.clickOnTimeout)

                this.downloadLink = "/api/download/" + data.data
                this.clickOnTimeout = setTimeout(() => {
                    console.log('timeoutfired!');
                    if (document.getElementById('alinkid') !== null) {
                        document.getElementById('alinkid').click()
                    }
                }, 1000)
            }).catch(error => {
                console.log(error)
                this.loading = false
                this.cancel()
            })

            bakasha = '';
        },

        cancel () {
            console.log('cancled!');
            this.show = {
                modal: false,
                Wrapper: false,
                spinner: false,
                link: false
            }

            this.downloadLink = '';

            // cancel all counters and downloads
            clearInterval(this.waitInSeconds)
            clearTimeout(this.clickOnTimeout)
        }
    }
}
</script>
