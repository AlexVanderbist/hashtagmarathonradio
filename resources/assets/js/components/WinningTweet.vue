<template>
    <div class="metric-panel__content" v-if="winningTweet">
        <h2 class="title is-4">
            {{ milestone }}ste Tweet
        </h2>
        <tweet :tweet="winningTweet"></tweet>
    </div>
</template>

<script>
    import Tweet from './Tweet.vue';

    export default {
        components: {Tweet},

        props: ['winningTweet', 'milestone'],
    }
</script>
