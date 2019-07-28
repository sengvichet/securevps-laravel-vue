<template>
    <span>
        <a class="button alert btn-in-td" @click.prevent='disconnect()'>
            <i class="fa fa-sign-out" aria-hidden="true" v-if="!loading"></i>
            <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="loading"></i>
             Disconnect</a>
    </span>
</template>

<script>
import { adminStore } from '../../stores'

export default {
    props: ['data'],

    data () {
        return {
            loading: false,
        }
    },

    methods: {
        disconnect () {
            this.loading = true
            this.$parent.$parent.removeSessionRow(this.data.id)
            adminStore.deleteSession(this.data.id).then((data) => {
                this.loading = false
                this.$parent.$parent.removeSessionRow(this.data.id)
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>
