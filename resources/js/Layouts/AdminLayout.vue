<script setup lang="ts">
import Navbar from "@/Components/Navbar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import { ref } from "vue";

const sidebarOpen = ref(false);

function toggleSidebar() {
    sidebarOpen.value = !sidebarOpen.value;
}
</script>

<template>
    <!--Sidebar-->
    <aside class="sp-sidebar" :class="{ show: sidebarOpen }">
        <Sidebar />
    </aside>
    <div class="sp-main">
        <!--Topbar-->
        <Navbar @toggleSidebar="toggleSidebar" />
        <div class="sp-content">
            <!--Main-->
            <slot />
        </div>
    </div>
</template>
