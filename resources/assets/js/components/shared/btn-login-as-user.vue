<template>
    <span>
        <a class="button btn-in-td lau" @click.prevent='loginAsUser'>
            <i class="fa fa-sign-in" aria-hidden="true" v-if="!loading"></i>
            <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="loading"></i>
             LoginAU</a>
    </span>
</template>

<script>
import { adminStore } from '../../stores'

export default {
    props: ['asUser'],

    data () {
        return {
            loading: false,
        }
    },

    methods: {
        loginAsUser () {
            this.loading = true

            adminStore.loginAsUser(this.asUser).then((data) => {
                this.loading = false
                location.href = '/user/domainSpaces'
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>

<style>
    .lau {
        width: 90px;
    }
</style>
