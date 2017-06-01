<template>
    <div>
        <ul>
            <li>{{ djCount(1) }}</li>
            <li>{{ djCount(2) }}</li>
            <li>{{ djCount(3) }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['tweetsPerDj'],

        methods: {
            djCount(id) {
                if (! this.tweetsPerDj) {
                    return 0;
                }

                return this.tweetsPerDj.filter(dj => dj.id == id)[0].count;
            }
        }
    }
</script>
