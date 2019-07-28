<template lang="html">
  <div>
      <div class="text-center">
          <spinner v-if="loading"></spinner>
      </div>

      <div class="row">
          <div class="small-12 large-8 medium-8 columns mb50">

              <div>
                  <div class="py-title">
                      פרטי חיוב
                  </div>

                  <div class="py-action mb50">
                      <ul class="ul-clean">
                          <li>
                              {{ user.firstName }} {{ user.lastName }}
                          </li>
                          <li>
                              {{ user.company }} ח.פ. {{ user.idn }}
                          </li>
                          <li>
                              רח`
                              {{ user.street_address }}
                              עיר
                              {{ user.city }}
                              מיקוד
                              {{ user.zip }}
                          </li>
                          <li>
                              {{ user.email }}
                          </li>
                          <li>
                              {{ user.mobile }}
                          </li>
                      </ul>

                      <p>
                          פרטים אלו יופיעו על החשבונית, לשינוי הפרטים
                          <a href="/user/profile">לחץ כאן</a>
                      </p>
                  </div>
              </div>

              <div>
                  <div class="py-title">
                      בחר אמצעי תשלום
                  </div>
                  <div>
                      <div class="py-option" :class="{active: pymethod === 'pelecard'}" @click="pymethod = 'pelecard';goToPelecard()">
                          <i class="fa fa-circle-o" aria-hidden="true" v-show="pymethod !== 'pelecard'"></i>
                          <i class="fa fa-dot-circle-o gr" aria-hidden="true" v-show="pymethod === 'pelecard'"></i>
                          תשלום בכרטיס אשראי באמצעות פלאכארד
                      </div>
                      <div class="py-action" v-show="pymethod === 'pelecard'">
                          סליקת כרטיס האשראי שלך נעשית ישירות ע"י חברת פלאכארד
                          ואנו מקבלים רק את האישור לחיוב מבלי שפרטי כרטיס האשראי שלך נחשפים.
                          <div v-if="loadingCheckDomainAvaliable">
                              <i class="fa fa-spinner fa-pulse fa-fw"></i> נא להמתין...
                              <br />
                              בודק זמינות של הדומיין שבחרת
                          </div>
                          <div v-if="loadingGoToPelecard">
                              <i class="fa fa-spinner fa-pulse fa-fw"></i> נא להמתין...
                              <br />
                              טוען טופס תשלום מאובטח
                          </div>
                          <div v-if="showPelecardFrame" class="clearfix">
                              <iframe id="pelecardframe" src="payment/pay" width="500" height="500" scrolling="no"></iframe>

                              <input id="save-token" type="checkbox" name="save-token" class="float-right" @click="changeSaveTokenStatus($event)" checked="checked">
                              <label for="save-token" class="float-right">אפשר שמירת כרטיס האשראי לחיובים מהירים בעתיד</label>
                          </div>
                      </div>
                      <div class="py-option" :class="{active: pymethod === 'bank'}" @click="pymethod = 'bank'">
                          <i class="fa fa-circle-o" aria-hidden="true" v-show="pymethod !== 'bank'"></i>
                          <i class="fa fa-dot-circle-o gr" aria-hidden="true" v-show="pymethod === 'bank'"></i>
                          תשלום בהמחאה או העברה בנקאי
                      </div>
                      <div class="py-action" v-show="pymethod === 'bank'">
                          נא לבצע העברה ל או משלוח צק ל
                      </div>
                      <div class="py-option" :class="{active: pymethod === 'paypal'}" @click="pymethod = 'paypal'">
                          <i class="fa fa-circle-o" aria-hidden="true" v-show="pymethod !== 'paypal'"></i>
                          <i class="fa fa-dot-circle-o gr" aria-hidden="true" v-show="pymethod === 'paypal'"></i>
                          תשלום בפאיפל
                      </div>
                      <div class="py-action" v-show="pymethod === 'paypal'">
                          פעולת פאי פאל
                      </div>
                  </div>
              </div>

              <div class="py-pad">
                  <a href="/cart">
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                      חזור לסל הקניות</a>
              </div>

          </div>
          <div class="small-12 large-4 medium-4 columns">
              <div class="py-title">
                  סך הכל לתשלום
              </div>

              <div class="subtotal-wrapper py-action">
                  <span class="subtotal-label">דומיין</span>
                  <span class="subtotal-value">{{ domain }}</span>
                  <br />
                  <span class="subtotal-label">מזהה חבילה</span>
                  <span class="subtotal-value">{{ itemId }}</span>
                  <br /><br />
                  <span class="subtotal-label">סה"כ</span>
                  <span class="subtotal-value">{{ subtotal | currency }}</span>
                  <br />
                  <span class="subtotal-label">מע"מ</span>
                  <span class="subtotal-value">{{ tax | currency }}</span>

                  <hr>

                  <span class="subtotal-label">סה"כ כולל</span><br />
                  <span class="total-value">{{ total | currency }}</span>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { currency } from '../../utils'
import { cartStore } from '../../stores'

export default {
    components: {
        spinner,
    },

    filters: {
        currency
    },

    data () {
        return {
            loading: false,
            loadingGoToPelecard: false,
            loadingCheckDomainAvaliable: false,
            showPelecardFrame: false,
            user: '',
            order: '',
            pymethod: '',
            pcardform: '',
            domain: '',
            itemId: '',
            cartId: '',
            tax: '',
            total: '',
            subtotal: '',
        }
    },

    created () {
        this.loading = true
        cartStore.getPaymentDetails().then(data => {

            this.domain = data.cartPackages.domain;
            this.itemId = data.cartPackages.itemId;
            this.cartId = data.cartPackages.cartId;

            if ( ! data.ok) {
                swal({
                    title: 'לא נמצאו נתונים לחיוב',
                    type: 'warning',
                    confirmButtonText: 'חזור לדף הבית',
                }).then(() => {
                    window.location.href = '/'
                })
            }

            this.loading = false;
            this.user = data.user;
            this.total = data.cartPackages.total;

            if (!this.tax) {
                this.total = this.total.replace(',', '');
            }

            this.tax = this.calcTax(this.total);
            this.subtotal = (this.total - this.tax);

            if (!this.subtotal) {
                this.total = this.total.replace(',','');
                this.tax = this.tax.replace(',','');
                this.subtotal = (parseFloat(this.total) - parseFloat(this.tax))
            }
        }).catch(err => {
            console.log(err)
        })
    },

    methods: {
        checkout () {
            swal('ok')
        },

        goToPelecard () {

            this.loadingCheckDomainAvaliable = true

            let domainPack = {
                domain: this.domain,
                cartId: this.cartId,
                action: 'payment',
            };

            cartStore.checkDomainAvaliable(domainPack).then(data => {
                this.loadingCheckDomainAvaliable = false
                if (data.error === 'domain not avaliable') {
                    swal({
                      title: 'שם הדומיין שבחרת תפוס',
                      text: data.msg,
                      type: 'warning',
                    })
                } else {
                    this.loadingGoToPelecard = true
                    this.showPelecardFrame = true
                    setTimeout(() => {
                        this.loadingGoToPelecard = false
                    }, 2000);
                }
            }).catch(err => {
                console.log(err)
            })
        },

        calcTax (total) {
            let taxvalue = 17
            return (total/100) * taxvalue
        },

        changeSaveTokenStatus (e) {
            var saveToken = 'false';

            if (e.target.checked) {
                saveToken = 'true';
            }

            cartStore.changeSaveTokenStatus(saveToken).then(data => {
                //
            }).catch(err => {
                console.log(err)
            });
        },
    }
}
</script>

<style lang="scss">
@import "../../../sass/partials/_vars.scss";

.gr {
    color: #7db700;
}
.py-title {
    box-shadow: inset 0 -1px rgba(0,0,0,0.05), inset 0 1px rgba(0,0,0,0.05);
    color: $colorWhite !important;
    background: #2F333E;
    border: 0!important;
    padding: 0.7em 1.25em 0.7em 1em;
}

.py-option {
    border: 1px solid $colorGrey1;
    padding: 0.7em 1.25em 0.7em 1em;
    font-size: 1.25em;
    cursor: pointer;
    -webkit-transition: 0.3s; /* Safari */
    transition: 0.3s;

    &:hover {
        background-color: $colorGrey1;
    }

    &.active {
        background-color: $colorGrey1;
    }
}

.py-action {
    border: 1px solid $colorGrey1;
    padding: 0.7em 1.25em 0.7em 1em;
}

.py-pad {
    padding: 1.7em 0em;
}

.ul-clean {
    list-style-type: none;
}

.thedomn {
    text-align: center;
    font-weight: bold;
    font-size: 18px;
    margin: 20px 0;
}
</style>
