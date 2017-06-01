<template>
    <div class="metric-panel__content">
        <article class="media" v-for="dj in tweetsPerDj">
            <figure class="media-left">
                <p class="image is-64x64">
                    <img src="http://bulma.io/images/placeholders/128x128.png">
                </p>
            </figure>
            <div class="media-content">
                <div class="content">
                    <p class="title is-2">
                        {{ dj.count }}
                    </p>
                    <h2 class="subtitle is-4">tweets tijdens {{dj.name}}</h2>
                </div>
            </div>
        </article>
    </div>
</template>

<script>
    export default {
        props: ['tweetsPerDj'],
    }
</script>
