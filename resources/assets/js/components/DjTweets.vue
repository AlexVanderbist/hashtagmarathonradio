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
        props: ['djs'],

        computed: {
            djCount(id) {
                return this.djs.filter(dj => dj.id == id)[0];
            }
        }
    }
</script>
