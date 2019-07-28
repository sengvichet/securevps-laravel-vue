<template>
    <span>
        <a class="button alert btn-in-td" @click.prevent="deleteUser()">
            <i class="fa fa-trash" aria-hidden="true" v-if="!loading"></i>
            <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="loading"></i>
             Delete</a>
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
        deleteUser () {
            this.loading = true
            adminStore.deleteLocalUser(this.data.id).then((data) => {
                this.loading = false
                console.log(this)
                this.$parent.$parent.removeUserRow(this.data.id)
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>
