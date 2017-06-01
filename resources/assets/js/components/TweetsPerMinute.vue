<template>
    <div class="metric-panel__content">
        <h2>tweets per minuut</h2>

        <small>
            Da's
            <animated-number :number="tweetsPerSecond" format="0.0[0]" style="display:inline"></animated-number>
            tweets per seconde!
        </small>
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