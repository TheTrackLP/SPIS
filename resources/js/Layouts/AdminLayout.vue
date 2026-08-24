<script setup lang="ts">
import Navbar from "@/Components/Navbar.vue";
import Sidebar from "@/Components/Sidebar.vue";
</script>

<template>
    <!--Sidebar-->
    <Sidebar />
    <div class="sp-main">
        <!--Topbar-->
        <Navbar />
        <div class="sp-content">
            <!--Main-->
            <slot />
        </div>
    </div>
</template>
