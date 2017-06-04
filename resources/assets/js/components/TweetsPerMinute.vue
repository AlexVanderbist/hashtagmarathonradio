<template>
    <div class="metric-panel__content">
        <h2>tweets per minuut</h2>

        <h3 class="subtitle is-6">
            Da's
            <animated-number :number="tweetsPerSecond" format="0.0[0]" style="display:inline"></animated-number>
            tweets per seconde!
        </h3>
    </div>
</template>

<script>
    import AnimatedNumber from './AnimatedNumber';

    export default {
        props: ['tweetsPerMinute'],

        components: { AnimatedNumber },

        computed: {
            tweetsPerSecond() {
                return this.tweetsPerMinute / 60;
            }
        }
    }
</script>