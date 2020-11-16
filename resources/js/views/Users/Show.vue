<template>
    <div class="flex flex-col items-center">
        <div class="relative">
            <span v-if="user_loading">Loading User page</span>
            <div class="w-100 h-64 overflow-hidden z-1" v-else>
                <img src="/img/background-profile.jpg" class="object-cover w-full" alt="background-profile">
            </div>
            <div class="ml-6 absolute flex items-center bottom-0 left-0 -mb-8 z-2">
                <div class="w-32">
                    <img src="/img/profile.jpg" class="object-cover border-4 border-gray-200 w-32 rounded-full shadow-lg" alt="user profile image">
                </div>
                <span class="ml-4 tracking-wider text-3xl text-gray-100">{{ user.data.attributes.name | capitalize }}</span>
            </div>
        </div>
        <span v-if="post_loading" class="mt-2">The posts is loading</span>
        <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
        <span class="text-2xl mt-8" v-if="!post_loading && posts.data.length < 1">User Has no Posts</span>
    </div>
</template>

<script>
import {Post} from '../../components'
export default {
    data() {
        return {
            user: null,
            posts: null,
            user_loading: true,
            post_loading: true
        }
    },
    components: {
        Post
    },
    mounted() {
        axios.get('/api/users/' + this.$route.params.userId).then(({data}) => {
            this.user = data
        }).catch((error) => {
            console.log('Unable to find such a user!')
        }).finally(() => {
            this.user_loading = false
        }),
        axios.get('/api/users/' + this.$route.params.userId + '/posts').then(({data}) => {
            this.posts = data
        }).catch((error) => {
            console.log('Sorry theres no post to see!')
        }).finally(() => {
            this.post_loading = false
        })
    }
}
</script>
