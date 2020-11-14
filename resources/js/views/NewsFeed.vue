<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />
        <Post v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
    </div>
</template>

<script>

import {NewPost, Post} from "../components"
export default {
    components: {
        NewPost,
        Post
    },
    data() {
        return {
            posts: null
        }
    },
    mounted() {
        axios.get('/api/posts').then((response) => {

            this.posts = response.data

        }).catch((error) => {

            console.log(error)

        });
    }
}
</script>
