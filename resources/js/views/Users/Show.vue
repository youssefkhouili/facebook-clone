<template>
    <div>
        <span v-if="loading">Loading User page</span>
        <div class="w-100 h-64 overflow-hidden" v-else>
            <img src="/img/background-profile.jpg" class="object-cover w-full" alt="background-profile">
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            loading: true
        }
    },
    mounted() {
        axios.get('/api/users/' + this.$route.params.userId).then(({data}) => {
            this.user = data
        }).catch((error) => {
            console.log('Unable to find such a user!')
        }).finally(() => {
            this.loading = false
        }),
        axios.get('/api/posts/' + this.$route.params.userId).then(({data}) => {
            this.posts = data
        }).catch((error) => {
            console.log('Sorry theres no post to see!')
        }).finally(() => {
            this.loading = false
        })
    }
}
</script>
