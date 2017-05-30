<template>
    <div class="metric-panel__content">
        <h2>twitteraars met #marathonradio</h2>

        <p class="title is-1">
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <animated-number :number="totalUsers"></animated-number>
        </p>
    </div>
</template>

<script>
    import AnimatedNumber from './AnimatedNumber';

    export default {
        props: ['totalUsers'],

        components: { AnimatedNumber },
    }
</script>