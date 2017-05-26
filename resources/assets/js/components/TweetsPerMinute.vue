<template>
    <div>
        <h2>
            <i class="fa fa-bomb" aria-hidden="true"></i>
            <span>{{ tweetsPerMinute || '0' }}</span>
        </h2>
        <h3>tweets per minuut</h3>
        <small>Da's {{ tweetsPerSecond }} tweets per seconde!</small>
    </div>
</template>

<script>
    export default {
        props: ['tweetsPerMinute'],

        computed: {
            tweetsPerSecond() {
                if (isNaN(this.tweetsPerMinute)) {
                    return 0;
                }

                return (this.tweetsPerMinute / 60).toFixed(2);
            }
        }
    }
</script>