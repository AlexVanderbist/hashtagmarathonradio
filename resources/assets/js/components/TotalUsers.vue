<template>
    <div class="metric-panel__content">
        <p class="title is-1">
            <span class="icon is-large">
                <i class="fa fa-twitter"></i>
            </span>
            <animated-number :number="totalUsers"></animated-number>
        </p>

        <h2>twitteraars met #marathonradio</h2>
    </div>
</template>

<script>
    import AnimatedNumber from './AnimatedNumber';

    export default {
        props: ['totalUsers'],

        components: { AnimatedNumber },
    }
</script>