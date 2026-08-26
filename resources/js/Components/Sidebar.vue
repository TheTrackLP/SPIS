<script setup>
import { Link } from "@inertiajs/vue3";
const isActive = (routeName) => {
    return route().current(routeName);
};
</script>

<template>
    <div>
        <div class="brand d-flex align-items-center gap-2">
            <div class="seal">SP</div>
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
            <a href="#" class="nav-link"
                ><i class="fa-solid fa-chart-simple"></i> Reports</a
            >
            <a href="#" class="nav-link"
                ><i class="fa-solid fa-box-archive"></i> Archive</a
            >
            <div class="nav-section-label">Settings</div>
            <a
                class="nav-link collapsed"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#collapseSettings"
            >
                <i class="fa-solid fa-gear"></i> Settings
                <div class="sb-sidenav-collapse-arrow">
                    <i class="fas fa-angle-down"></i>
                </div>
            </a>
            <div
                class="collapse"
                id="collapseSettings"
                data-bs-parent="#sidenavAccordion"
            >
                <nav class="sp-nav flex-column">
                    <Link class="nav-link" :href="route('gear.author')"
                        ><i class="fa-solid fa-user-tie"></i> Authors</Link
                    >
                    <a class="nav-link" href="#"
                        ><i class="fa-solid fa-flag"></i> Status</a
                    >
                    <Link class="nav-link" :href="route('sector.dash')"
                        ><i class="fa-solid fa-layer-group"></i> Sector</Link
                    >
                    <Link class="nav-link" :href="route('class.dash')"
                        ><i class="fa-solid fa-list"></i> Classification</Link
                    >
                </nav>
            </div>
        </nav>

        <div class="sidebar-foot">
            Province of Capiz &middot; v0.1 (UI Preview)
        </div>
    </div>
</template>
