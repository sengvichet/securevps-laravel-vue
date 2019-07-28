<template>
    <div>
        <a class="success button wd wda" v-show="active" @click.prevent="toggleEnable()">
            <i class="fa fa-check-square" aria-hidden="true" v-if="!toggling"></i>
            <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="toggling"></i>
            <span class="ac">Active</span><span class="ds to">To Disable</span>
        </a>
        <a class="alert button wd wdd" v-show="!active" @click.prevent="toggleEnable()">
            <i class="fa fa-square" aria-hidden="true" v-if="!toggling"></i>
            <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="toggling"></i>
            <span class="ac to">To Activate</span><span class="ds">Disable</span>
        </a>
    </div>
</template>

<script>
import { adminStore } from '../../stores'

export default {
    props: ['data'],

    data () {
        return {
            active: this.data.active,
            toggling: false
        }
    },

    created () {
        this.active = this.data.active
    },

    methods: {
        toggleEnable() {
            this.toggling = true
            adminStore.toggleEnable(this.data.id).then((data) => {
                this.toggling = false
                this.active = data.active
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.wd {
    width: 90px;
    padding: 0.3em;
    margin-top: -12px;
    margin-bottom: -10px;
}

.wda .ds {
    display: none;
}

.wda:hover .ds {
    display: inline;
}

.wda:hover .ac {
    display: none;
}

.wdd .ac {
    display: none;
}

.wdd:hover .ds {
    display: none;
}

.wdd:hover .ac {
    display: inline;
}

.to {
    font-size: 0.7em;
}

</style>
