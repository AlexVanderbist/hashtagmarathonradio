<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        <h1>{{ numTweets }} tweets</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'numTweets': 0
            }
        },

        mounted() {
            console.log('Component mounted.');
            this.listen();
        },

        methods: {
            listen() {
                console.log('listening');
                Echo.channel('dashboard')
                    .listen('DashboardUpdate', (e) => {
                        console.log(e);

                        this.numTweets = e.numTweets;
                    });
            }
        }
    }
</script>
