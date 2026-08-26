<script setup lang="ts">
import Navbar from "@/Components/Navbar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Swal from "sweetalert2";

const sidebarOpen = ref(false);

function toggleSidebar() {
    sidebarOpen.value = !sidebarOpen.value;
}

const page = usePage();

watch(
    () => page.props.flash?.success,
    (value) => {
        if (value) {
            Swal.fire({
                title: "Success!",
                text: value,
                icon: "success",
                timer: 2000,
                showConfirmButton: false,
            });
        }
    },
    { deep: true },
);

watch(
    () => page.props.flash?.error,
    (value) => {
        if (value) {
            Swal.fire({
                title: "Error!",
                text: value,
                icon: "error",
                timer: 2000,
                showConfirmButton: false,
            });
        }
    },
    { deep: true },
);
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
