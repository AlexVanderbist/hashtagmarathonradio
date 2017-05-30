<template>
    <div class="metric-panel__content">
        <h2>tweets met #marathonradio</h2>

        <p class="title is-1">
            <i class="fa fa-hashtag" aria-hidden="true"></i>
            <animated-number :number="totalTweets"></animated-number>
        </p>
    </div>
</template>

<script>
    import AnimatedNumber from './AnimatedNumber';

    export default {
        props: ['totalTweets'],

        components: { AnimatedNumber },
    }
</script>