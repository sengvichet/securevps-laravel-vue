<template>
    <form @submit.prevent="submit" v-show="show">
        <h3>כניסה לחשבון באמצעות SMS</h3>

        <hr>

        <p>
            שלחנו לך קוד SMS לטלפון,
            המתן עד לקבלת הקוד והזן אותו בשדה הבא
        </p>

        <hr>

        <p>
            <label for="smscode">הזן קוד SMS שקיבלת</label>

            <input class="input-field" id="smscode" type="text" v-model="smscode" placeholder="Code" required>

            <div class="error-label" v-if="errorSmscode">
                {{ errorSmscode }}
            </div>
        </p>

        <hr>

        <p>
            <button type="submit" class="button large expanded">
                <i class="fa fa-spinner fa-spin fa-fw" v-if="loading"></i>
                <span v-if="!loading">כניסה</span>
            </button>
        </p>
    </form>
</template>

<script>
import { userStore } from '../../stores'
import { event } from '../../utils'

export default {
    created () {
        event.on({
            'user:smsCodeForLoginSent': () => {
                this.show = true
            }
        })
    },

    data () {
        return {
            show: false,
            loading: false,
            smscode: '',
            errorSmscode: ''
        }
    },

    methods: {
        submit () {
            this.loading = true
            this.failed = false

            userStore.validateMySmsCodeForLogin(this.smscode).then(() => {
                this.loading = false
                this.failed = false
                this.smscode = ''
                location.href = '/accountlist'
            }).catch(error => {
                this.loading = false
                this.failed = true
                this.errorSmscode = error.response.data['smscode'][0]
            })
        }
    }
}
</script>
