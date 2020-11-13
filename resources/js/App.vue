<template>
    <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
        <AppNav />
        <router-view></router-view>
    </div>
</template>

<script>
import {Nav} from "./components"
export default {
    components: {
        AppNav:Nav
    }
}
</script>
