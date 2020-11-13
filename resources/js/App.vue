<template>
    <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
        <AppNav />
        <div class="flex overflow-y-hidden flex1">
            <div class="w-1/3">
                Sidebar
            </div>
            <div class="overflow-x-hidden w-2/3">
                <router-view></router-view>

                <p v-for="i in 100">hello world {{ i }}</p>
            </div>
        </div>
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
