<template>
    <span>
        Laatste update {{ lastUpdateDisplay }}.
    </span>
</template>

<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                lastUpdate: moment(),
                secondsSinceLastUpdate: 0,
            }
        },

        mounted() {
            window.bus.$on('DashboardUpdate', () => this.dashboardUpdated());

            setInterval(() => this.countSeconds(), 1001);
        },

        computed: {
            lastUpdateDisplay() {
                if (this.secondsSinceLastUpdate < 6) {
                    return 'minder dan 5 seconden geleden';
                }

                return `${this.secondsSinceLastUpdate} seconden geleden`;
            }
        },

        methods: {
            dashboardUpdated() {
                this.lastUpdate = moment();
            },
            countSeconds() {
                this.secondsSinceLastUpdate = moment().diff(this.lastUpdate, 'seconds');
            },
        }
    }
</script>