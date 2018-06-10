<template>
    <div class="scrollable-flex">
        <div class="metric-panel__content">
            <h2 class="title is-4">
                Populairste woorden
            </h2>
            <p class="subtitle is-6">
                <a @click="last = true" :class="{ 'is-underlined': last }">30 min</a> | <a @click="last = false" :class="{ 'is-underlined': ! last }">30 dagen</a>
            </p>
        </div>
        <ul v-if='last' class="scrollable-flex--list fancy-list">
            <li v-for="(occurrence, index) in lastOccurrences">
                <p style="flex-grow: 1">
                    {{ index + 1 }}.
                    {{ occurrence.word }}
                </p>
                <span class="tag">{{ occurrence.count }}</span>
            </li>
        </ul>
        <ul v-else class="scrollable-flex--list fancy-list">
            <li v-for="(occurrence, index) in allOccurrences">
                <p style="flex-grow: 1">
                    {{ index + 1 }}.
                    {{ occurrence.word }}
                </p>
                <span class="tag">{{ occurrence.count }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['lastOccurrences', 'allOccurrences'],
        data() {
            return {
                last: true,
            };
        }
    }
</script>
