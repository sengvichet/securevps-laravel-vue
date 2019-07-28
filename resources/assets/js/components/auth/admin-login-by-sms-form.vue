<template>
    <div>
        <form @submit.prevent="submit" v-show="show">
            <h3>בקשת קוד SMS</h3>

            <hr>

            <p>
                <label for="phone">הזן מספר סלולרי</label>
                <input class="input-field" id="phone" type="tel" v-model="phone" placeholder="Phone" required>

                <div class="error-label" v-if="errorPhone">
                    {{ errorPhone }}
                </div>
            </p>

            <hr>

            <p>
                <button type="submit" class="button large expanded">
                    <i class="fa fa-spinner fa-spin fa-fw" v-if="loading"></i>
                    <span v-if="!loading">שלח אלי קוד כניסה ב SMS</span>
                </button>
            </p>
        </form>

        <p v-show="!show">
            קוד נשלח בהצלחה<br />
            נא הזן אותו בטופס הבא
        </p>
    </div>
</template>

<script>
import { adminStore } from '../../stores'
import { event } from '../../utils'

export default {
    data () {
        return {
            show: true,
            loading: false,
            phone: '',
            errorPhone: ''
        }
    },
    methods: {
        submit () {
            this.loading = true
            this.failed = false

            adminStore.sendMeSmsCodeForAdminLogin(this.phone).then((data) => {
                this.loading = false
                this.faild = false
                this.show = false
                this.phone = ''
            }).catch(error => {
                this.loading = false
                this.failed = true
                this.errorPhone = error.response.data['phone'][0]
            })
        }
    }
}
</script>
