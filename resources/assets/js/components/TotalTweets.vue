<template>
    <div>
        <h2>
            <i class="fa fa-hashtag" aria-hidden="true"></i>
            <span>{{ totalTweets || 'Laden...'}}</span>
        </h2>
        <h3>tweets met #marathonradio</h3>
    </div>
</template>

<script>
    export default {
        props: ['totalTweets'],
    }
</script>