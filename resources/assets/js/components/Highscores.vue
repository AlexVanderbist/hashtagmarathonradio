<template>
    <div>
        <h2 style="margin-bottom:15px;font-weight:bold;">Meeste tweets</h2>

        <ul>
            <li v-for="user in users">
                {{ user.screen_name }}
                <span class="tag">{{ user.tweets_count }}</span>
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        props: ['users'],
    }
</script>