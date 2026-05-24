<script setup>
import { Link } from "@inertiajs/vue3";
import NavLayout from "../Layout/NavLayout.vue";
</script>

<template>
    <NavLayout>
        <div class="flex justify-center flex-col items-center w-full h-screen">
            <h2>Sales Inventory</h2>
            <Link
                href="/login"
                class="bg-slate-700 py-1 px-5 rounded-md text-white no-underline hover:bg-slate-900"
                >Start</Link
            >
        </div>
    </NavLayout>
</template>

<style lang="css" scoped></style>
