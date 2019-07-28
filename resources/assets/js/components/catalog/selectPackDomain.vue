<template lang="html">
    <div>
        <div class="clearfix">
            <div class="cart-domain-wrapper">
                <label>
                    <input type="text" id="domain" v-model="domain"
                    placeholder="Type your Domain..."
                    @blur="checkDomainAvaliable()"
                    @focus="errorCheckDomainAvaliable = false;successCheckDomainAvaliable = false"
                    class="selectdomain">
                    <div class="domain-indicator">
                        <i class="fa fa-spinner fa-pulse fa-fw" v-if="loadingCheckDomainAvaliable"></i>
                        <i class="fa fa-check green" aria-hidden="true" v-if="successCheckDomainAvaliable"></i>
                        <i class="fa fa-times red" aria-hidden="true" v-if="errorCheckDomainAvaliable"></i>
                    </div>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import { cartStore } from '../../stores'

export default {

    props: ['cartpk', 'i'],

    data() {
        return {
            domain: this.cartpk.domain,
            loadingCheckDomainAvaliable: false,
            successCheckDomainAvaliable: false,
            errorCheckDomainAvaliable: false,
        }
    },

    created() {
        if (this.domain.length > 4)
            this.successCheckDomainAvaliable = true
    },

    methods: {
        checkIsValidDomain(domain) {
            var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/);
            return domain.match(re);
        },

        checkDomainAvaliable () {

            this.loadingCheckDomainAvaliable = true
            this.errorCheckDomainAvaliable = false
            this.successCheckDomainAvaliable = false

            if (! this.checkIsValidDomain(this.domain) && this.domain) {
                this.loadingCheckDomainAvaliable = false
                this.errorCheckDomainAvaliable = true
                this.successCheckDomainAvaliable = false
                swal('שם הדומיין לא חוקי', 'נא הזן שם דומיין לפי התחביר הבא mydomain.com', 'warning')
                return
            } else {

                let domainPack = {
                    domain: this.domain,
                    cartId: this.cartpk.id,
                    action: 'selectDomain',
                };

                cartStore.checkDomainAvaliable(domainPack).then(data => {
                    this.loadingCheckDomainAvaliable = false
                    if (data.error === 'domain not avaliable') {
                        this.errorCheckDomainAvaliable = true
                        this.successCheckDomainAvaliable = false
                        this.$parent.cartPackages[this.i].errorCheckDomainAvaliable = true
                        swal({
                            title: 'שם הדומיין שבחרת תפוס',
                            text: data.msg,
                            type: 'warning',
                        })
                    } else {
                        this.errorCheckDomainAvaliable = false
                        if (this.domain) {
                            this.successCheckDomainAvaliable = true
                        }
                        this.$parent.cartPackages[this.i].domain = this.domain
                        this.$parent.cartPackages[this.i].errorCheckDomainAvaliable = false
                    }
                }).catch(err => {
                    console.log(err)
                })
            }
        }
    }
}
</script>

<style lang="scss">
@import "../../../sass/partials/_vars.scss";

.domain-indicator {
    position: absolute;
    top: 1px;
    right: 10px;
    font-size: 22px;
}

input.selectdomain, input.selectdomain:focus {
    width: 300px;
    border: 2px solid $colorGreen6;
    direction: ltr;
    font-weight: bold;
    border-radius: 2px;
}

.cart-domain-wrapper {
    margin-bottom: 5px;
    position: relative;
}

.domain-wrapper label {
    // font-size: 30px;
    // margin: 30px;
    // color: #666;
}
</style>
