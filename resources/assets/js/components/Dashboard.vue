<template>
    <div>
        <div class="tile is-ancestor">
            <div class="tile is-vertical">
                <div class="tile is-parent">
                    <article class="tile is-child metric-panel">
                        <total-tweets :total-tweets="statistics.totalTweets"></total-tweets>
                    </article>
                </div>

                <div class="tile is-parent">
                    <article class="tile is-child metric-panel">
                        <total-users :total-users="statistics.totalUsers"></total-users>
                    </article>
                </div>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child metric-panel">
                    <hype-meter :value="statistics.tweetsPerMinute"></hype-meter>
                    <tweets-per-minute :tweets-per-minute="statistics.tweetsPerMinute"></tweets-per-minute>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child metric-panel">
                    <highscores :users="statistics.usersWithMostTweets"></highscores>
                </article>
            </div>
        </div>
        <div class="tile is-ancestor">
            <div class="tile is-parent">
                <article class="tile is-child metric-panel">
                    <dj-tweets :tweets-per-dj="statistics.tweetsPerDj"></dj-tweets>
                </article>
            </div>
            <div class="tile is-parent is-vertical">
                <article class="tile is-child metric-panel">
                    <last-tweet :tweet="statistics.lastTweet" :total-tweets="statistics.totalTweets" :winning-tweet="statistics.winningTweet"></last-tweet>
                </article>
                <article class="tile is-child metric-panel" v-if="statistics.winningTweet">
                    <winning-tweet :winning-tweet="statistics.winningTweet"></winning-tweet>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child metric-panel">
                    <word-occurrences :occurrences="statistics.lastWordOccurrences"></word-occurrences>
                </article>
            </div>
        </div>
    </div>
</template>

<script>
    import TweetsPerMinute from './TweetsPerMinute.vue';
    import TotalTweets from './TotalTweets.vue';
    import TotalUsers from './TotalUsers.vue';
    import Highscores from './Highscores.vue';
    import WordOccurrences from './WordOccurrences.vue';
    import HypeMeter from './HypeMeter.vue';
    import DjTweets from './DjTweets.vue';
    import WinningTweet from './WinningTweet.vue';
    import LastTweet from './LastTweet.vue';

    export default {
        components: { TweetsPerMinute, TotalTweets, TotalUsers, Highscores, HypeMeter, WordOccurrences, DjTweets, WinningTweet, LastTweet },

        props: ['initialStatistics'],

        data() {
            return {
                statistics: {}
            }
        },

        mounted() {
            this.statistics = this.initialStatistics;

            this.listen();
        },

        methods: {
            listen() {
                Echo.channel('dashboard')
                    .listen('DashboardUpdate', (e) => {
                        if (window.debug) console.log(e);

                        window.bus.$emit('DashboardUpdate');


                        this.statistics = e;
                    });
            }
        }
    }
</script>
