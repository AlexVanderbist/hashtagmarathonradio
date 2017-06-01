<template>
    <div class="scrollable-flex">
        <div class="metric-panel__content">
            <h2>
                <span class="icon">
                    <i class="fa fa-heart"></i>
                </span>
                Populairste woorden
            </h2>
            <p>(laatste 30 minuten)</p>
        </div>
        <ul class="scrollable-flex--list fancy-list">
            <li v-for="(occurrence, index) in occurrences">
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
        props: ['occurrences'],
    }
</script>