<template>
    <div class="metric-panel__content">
        <article class="media" v-for="dj in tweetsPerDj">
            <figure class="media-left">
                <p class="image is-64x64 is-round">
                    <img :src="`images/${dj.name}.jpg`">
                </p>
            </figure>
            <div class="media-content">
                <div class="content">
                    <p class="title is-3">
                        <animated-number :number="dj.count"></animated-number>
                    </p>
                    <h2 class="subtitle is-5 is-strong">tweets tijdens {{dj.name}}</h2>
                </div>
            </div>
        </article>
    </div>
</template>

<script>
    import AnimatedNumber from './AnimatedNumber.vue';

    export default {
        components: { AnimatedNumber },

        props: ['tweetsPerDj'],
    }
</script>
