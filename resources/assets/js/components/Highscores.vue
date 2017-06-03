<template>
    <div class="scrollable-flex">
        <div class="metric-panel__content">
            <h2 class="title is-4">
                <!--<i class="fa fa-star"></i>-->
                Grootste Twitteraars
            </h2>
            <p class="control has-icons-left">
                <input class="input is-small" type="text" v-model="searchQuery" placeholder="Zoek jouw @Twitter...">
                <span class="icon is-small is-left">
                    <i class="fa fa-search"></i>
                </span>
            </p>
        </div>
        <ul class="scrollable-flex--list fancy-list">
            <li v-for="(user, index) in displayedUsers">
                <p style="flex-grow: 1">
                    {{ index + 1 }}.
                    <a :href="`https://www.twitter.com/${user.screen_name}`" target="_blank">
                        {{ user.screen_name }}
                    </a>
                </p>
                <span class="tag">{{ user.tweets_count }} tweets</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['users'],

        data() {
            return {
                searchQuery: '',
            }
        },

        computed: {
            displayedUsers() {
                if (! this.users) {
                    return [];
                }

                const searchQuery = this.searchQuery.toLowerCase().replace('@', '');

                return this.users.filter(user => {
                    return user.screen_name.toLowerCase().includes(searchQuery);
                });
            }
        }
    }
</script>