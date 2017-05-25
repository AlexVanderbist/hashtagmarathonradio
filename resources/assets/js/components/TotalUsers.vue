<template>
    <div>
        <h2>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <span>{{ totalUsers || 'Laden...' }}</span>
        </h2>
        <h3>twitteraars met #marathonradio</h3>
    </div>
</template>

<script>
    export default {
        props: ['totalUsers'],
    }
</script>