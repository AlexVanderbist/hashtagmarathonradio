<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64 is-round">
                <img :src="tweet.user.profile_image_url">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>{{ tweet.user.name }}</strong> <small>@{{ tweet.user.screen_name }}</small>
                    <br>
                    <span v-html="tweet.text"></span>
                    <br>
                    <small v-if="showTimestamp">{{ timeAgo }}</small>
                </p>
            </div>
        </div>
    </article>
</template>

<script>
    import * as moment from 'moment';
    import 'moment/locale/nl-be';

    export default {
        props: ['tweet', 'showTimestamp'],

        computed: {
            timeAgo() {
                moment.locale('nl-be');

                return moment(this.tweet.tweeted_at).fromNow();
            }
        }
    }
</script>
