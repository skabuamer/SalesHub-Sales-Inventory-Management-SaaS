<script setup>
import { Toaster } from "@/Components/ui/sonner";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside
            class="sticky top-0 left-0 z-30 w-[clamp(200px,11.56vw,220px)] min-h-screen flex flex-col bg-[#111113] border-r border-[#1a1a1e]"
        >
            <!-- Logo -->
            <div
                class="flex items-center gap-2.5 px-[18px] py-5 border-b border-[#1a1a1e]"
            >
                <div
                    class="w-[30px] h-[30px] rounded-[8px] bg-[#c8a96e] flex items-center justify-center shrink-0"
                >
                    <svg
                        width="14"
                        height="14"
                        fill="none"
                        stroke="#0e0e10"
                        viewBox="0 0 24 24"
                        stroke-width="2.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 10V3L4 14h7v7l9-11h-7z"
                        />
                    </svg>
                </div>
                <span
                    class="text-[15px] font-bold text-[#e8e3db] tracking-[-0.03em]"
                    >SalesHub</span
                >
            </div>

            <!-- Nav -->
            <nav class="flex-1 flex flex-col gap-0.5 px-2.5 py-3.5">
                <p
                    class="text-[10px] font-semibold tracking-[0.08em] uppercase text-[#3a3a48] px-2 mb-2"
                >
                    Menu
                </p>
                <Link
                    href="/dashboard"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-subtle hover:text-ink hover:bg-border cursor-pointer transition-all duration-150"
                >
                    <svg
                        width="15"
                        height="15"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    Dashboard</Link
                >
                <Link
                    href="/categories"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-subtle hover:text-ink hover:bg-border cursor-pointer transition-all duration-150"
                >
                    <svg
                        width="15"
                        height="15"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                        />
                    </svg>
                    Categories</Link
                >
                <Link
                    href="/products"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-subtle hover:text-ink hover:bg-border cursor-pointer transition-all duration-150"
                    ><svg
                        width="15"
                        height="15"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                        />
                    </svg>
                    Products</Link
                >
                <Link
                    href="/customers"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-subtle hover:text-ink hover:bg-border cursor-pointer transition-all duration-150"
                >
                    <svg
                        width="15"
                        height="15"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                    Customers</Link
                >
                <Link
                    href="/invoices"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-subtle hover:text-ink hover:bg-border cursor-pointer transition-all duration-150"
                    ><svg
                        width="15"
                        height="15"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    Invoices</Link
                >

                <Link
                    href="/create-sale"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-subtle hover:text-ink hover:bg-border cursor-pointer transition-all duration-150"
                    ><svg
                        width="15"
                        height="15"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    Create Sale</Link
                >

                <div
                    class="mt-auto pt-3 border-t border-[#1a1a1e] flex flex-col gap-0.5"
                >
                    <Link
                        href="/profile"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-subtle hover:text-ink hover:bg-border cursor-pointer transition-all duration-150"
                    >
                        <svg
                            width="15"
                            height="15"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            />
                        </svg>
                        Profile
                    </Link>
                    <Link
                        href="/logout"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-[10px] text-[13.5px] font-medium text-[#f47252] hover:bg-[#f4725210] cursor-pointer transition-all duration-150"
                    >
                        <svg
                            width="15"
                            height="15"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>
                        Logout
                    </Link>
                </div>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col transition-all duration-300">
            <!-- Top Bar -->

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-5">
                <slot></slot>
                <Toaster
                    theme="dark"
                    richColors
                    position="top-center"
                    closeButton
                />
            </main>
        </div>

        <!-- Mobile Overlay -->
        <div
            v-if="sidebarOpen"
            class="top-0 inset-0 bg-black bg-opacity-50 z-30 md:hidden"
            @click="sidebarOpen = false"
        ></div>
    </div>
</template>
