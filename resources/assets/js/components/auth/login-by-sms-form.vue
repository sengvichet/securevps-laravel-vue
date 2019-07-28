<template>
    <div v-show="show">
        <form @submit.prevent="submit">
            <h3>כניסה לחשבון באמצעות SMS</h3>

            <hr>

            <div>
                <label for="phone">הזן מספר סלולרי</label>
                <input  class="input-field" id="phone" type="tel" v-model="phone" placeholder="Phone" required>

                <div class="error-label" v-if="errorPhone">
                    {{ errorPhone }}
                </div>
            </div>
            <br><br>
            <div>
                <div id="captcha">
                </div>
                <div class="error-label" v-if="errorVerify">
                    {{ errorVerify }}
                </div>
            </div>
            <hr>
            <p>
                <button type="submit" class="button large expanded btn-captcha" disabled="disabled">
                    <i class="fa fa-spinner fa-spin fa-fw" v-if="loading"></i>
                    <span v-if="!loading">שלח אלי קוד כניסה ב SMS</span>
                </button>
            </p>
        </form>
    </div>
</template>

<script>
import { userStore } from '../../stores'
import { event } from '../../utils'

export default {
    data() {
        return {
            show: true,
            loading: false,
            phone: '',
            failed: false,
            errorPhone: '',
            errorVerify: '',
            captcha: ''
        }
    },

    methods: {
        submit() {
            this.loading = true
            this.failed = false
            this.captcha = $('meta[name=captcha-token]').attr("content")
            userStore.sendMeSmsCodeForLogin({
                phone: this.phone,
                captcha: this.captcha
            }).then((data) => {
                this.loading = false
                this.failed = false
                this.show = false
                this.phone = ''
                event.emit('user:smsCodeForLoginSent')
            }).catch(error => {
                this.loading = false
                this.failed = true
                error.response.data['phone']?this.errorPhone = error.response.data['phone'][0]:this.errorPhone =''
                error.response.data['captcha']?this.errorVerify = error.response.data['captcha'][0]:this.errorVerify =''
            })
        }
    }
}
</script>
