<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { ref } from "vue";

const user = computed(() => usePage().props.auth.user);

const emit = defineEmits(["toggleSidebar"]);
const dropdownProfile = ref(false);
</script>

<template>
    <header class="sp-topbar">
        <div class="crumb">
            Legislative Information System /
            <strong id="crumbCurrent">Dashboard</strong>
        </div>

        <div class="ms-auto d-flex align-items-center gap-2">
            <button class="nav-link" @click.prevent="emit('toggleSidebar')">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="dropdown">
                <button
                    class="btn d-flex align-items-center gap-2 border-0"
                    @click="dropdownProfile = !dropdownProfile"
                >
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            background: var(--navy);
                            color: #fff;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 0.75rem;
                            font-weight: 600;
                        "
                    >
                        EC
                    </div>
                    <div
                        class="text-start d-none d-md-block"
                        style="line-height: 1.1"
                    >
                        <div style="font-size: 0.8rem; font-weight: 600">
                            {{ user.username }}
                        </div>
                    </div>
                </button>
                <ul
                    class="dropdown-menu dropdown-menu-end"
                    :class="{ show: dropdownProfile }"
                >
                    <li>
                        <a class="dropdown-item" :href="route('admin.logout')"
                            ><i class="bi bi-box-arrow-right me-2"></i>Sign
                            out</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </header>
</template>
