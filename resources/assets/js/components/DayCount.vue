<template>
    <span>
        Dag {{ day }} van Marathonradio!
    </span>
</template>

<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                day: 0,
            }
        },

        mounted() {
            this.updateDay();

            setInterval(() => this.updateDay(), 5000);
        },

        methods: {
            updateDay() {
                this.day = moment().diff(moment("2017-06-05"), 'days') + 1;
            }
        }
    }
</script>