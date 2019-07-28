<template>
    <div>
        <span class="label green-label" v-show="status === 'O'">הזמנות פתוחות</span>
        <span class="label red-label" v-show="status === 'C'">הזמנות סגורות</span>
        <span class="label orange-label" v-show="status === 'M'">הזמנות מעורבות</span>
    </div>
</template>

<script>
export default {
    name: 'statusLabel',
    props: ['data'],

    computed: {
        status () {
            return this.data.docStatus
        }
    }
}
</script>
