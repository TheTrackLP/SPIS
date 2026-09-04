<script setup>
import { Link } from "@inertiajs/vue3";

const isActive = (routeName) => {
    return route().current(routeName);
};
</script>

<template>
    <div>
        <div class="brand d-flex align-items-center gap-2">
            <div class="seal">
                <img
                    src="/img/capiz-logo.png"
                    alt="PBO Logo"
                    style="width: 50px; height: 50px"
                />
            </div>
            <div class="name">
                <strong>Sangguniang Panlalawigan</strong>
                Information System
            </div>
        </div>

        <nav class="sp-nav">
            <div class="nav-section-label">Overview</div>
            <Link
                :href="route('admin.dash')"
                class="nav-link"
                :class="{ active: isActive('admin.dash') }"
            >
                <i class="fa-solid fa-gauge"></i> Dashboard</Link
            >

            <div class="nav-section-label">Legislative</div>
            <Link
                :href="route('rec.dash')"
                class="nav-link"
                :class="{ active: isActive('rec.dash') }"
                ><i class="fa-solid fa-book"></i> Legislative Records</Link
            >

            <div class="nav-section-label">Manage</div>
            <Link
                :href="route('reports.dash')"
                class="nav-link"
                :class="{ active: isActive('reports.dash') }"
                ><i class="fa-solid fa-chart-simple"></i> Reports</Link
            >
            <a href="#" class="nav-link"
                ><i class="fa-solid fa-box-archive"></i> Archive</a
            >
            <div class="nav-section-label">Settings</div>
            <Link
                :href="route('gear.author')"
                class="nav-link"
                :class="{ active: isActive('gear.author') }"
                ><i class="fa-solid fa-user-tie"></i> Authors</Link
            >
            <Link
                :href="route('sector.dash')"
                class="nav-link"
                :class="{ active: isActive('sector.dash') }"
                ><i class="fa-solid fa-layer-group"></i> Sector</Link
            >
            <Link
                :href="route('class.dash')"
                class="nav-link"
                :class="{ active: isActive('class.dash') }"
                ><i class="fa-solid fa-list"></i> Classification</Link
            >
        </nav>

        <div class="sidebar-foot">
            Province of Capiz &middot; v0.1 (UI Preview)
        </div>
    </div>
</template>
