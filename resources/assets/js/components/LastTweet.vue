<template>
    <div class="metric-panel__content" v-if="tweet">
        <h2 class="title is-4" v-if="! showQuestion">
            {{ count }} Tweet
        </h2>
        <h2 class="title is-4 is-spaced" v-if="showQuestion">
            Wie wordt de 10.000ste Tweet?
        </h2>
        <h3 class="subtitle is-6" v-if="showQuestion">{{ count }} Tweet:</h3>
        <tweet :tweet="tweet" :show-timestamp="false"></tweet>
    </div>
</template>

<script>
    import Tweet from './Tweet';
    import numeral from 'numeral';

    export default {
        components: {Tweet},

        props: ['tweet', 'totalTweets', 'winningTweet'],

        computed: {
            count() {
                return numeral(this.totalTweets).format('0,0o');
            },
            showQuestion() {
                return this.winningTweet == null;
            }
        }
    }
</script>
