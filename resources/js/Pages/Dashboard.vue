<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import SideNavLayout from "../Layout/SideNavLayout.vue";

const page = usePage();

const summary = page.props.data;
</script>

<template>
    <SideNavLayout>
        <main class="flex-1 px-8 py-9">
            <!-- Welcome -->
            <div class="flex items-start justify-between mb-8">
                <div>
                    <p
                        class="text-[11.5px] font-semibold tracking-[0.06em] uppercase text-[#f5f5f5] mb-1.5"
                    >
                        Dashboard
                    </p>
                    <h1
                        class="text-[26px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                    >
                        Welcome to SalesHub,
                        <span class="text-[#c8a96e]">{{
                            page.props.user.name
                        }}</span>
                    </h1>
                </div>
                <Link
                    href="/create-sale"
                    class="flex items-center gap-1.5 bg-[#c8a96e] hover:bg-[#d4b87a] text-[#0e0e10] text-[13px] font-bold px-4 py-2 rounded-[10px] tracking-[-0.02em] transition-colors"
                >
                    <svg
                        width="13"
                        height="13"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    New Sale
                </Link>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-4 gap-3.5 mb-6">
                <!-- Revenue -->
                <div
                    class="bg-[#13110e] border border-[#2a2418] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-0.5 transition-transform cursor-pointer"
                >
                    <div class="flex items-center justify-between">
                        <div
                            class="w-[34px] h-[34px] rounded-[9px] bg-[#c8a96e18] flex items-center justify-center text-[#c8a96e]"
                        >
                            <svg
                                width="16"
                                height="16"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p
                            class="text-[10.5px] font-medium uppercase tracking-[0.06em] text-[#aaaabe] mb-1"
                        >
                            Total Revenue
                        </p>
                        <p
                            class="mono text-[28px] font-medium text-[#c8a96e] tracking-[-0.03em]"
                        >
                            {{ summary.payable }}
                        </p>
                    </div>
                </div>

                <!-- Customers -->
                <div
                    class="bg-[#0d1210] border border-[#182420] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-0.5 transition-transform cursor-pointer"
                >
                    <div class="flex items-center justify-between">
                        <div
                            class="w-[34px] h-[34px] rounded-[9px] bg-[#4caf8818] flex items-center justify-center text-[#4caf88]"
                        >
                            <svg
                                width="16"
                                height="16"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p
                            class="text-[10.5px] font-medium uppercase tracking-[0.06em] text-[#aaaabe] mb-1"
                        >
                            Total Customers
                        </p>
                        <p
                            class="mono text-[28px] font-medium text-[#4caf88] tracking-[-0.03em]"
                        >
                            {{ summary.customers }}
                        </p>
                    </div>
                </div>

                <!-- Products -->
                <div
                    class="bg-[#110f14] border border-[#211d28] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-0.5 transition-transform cursor-pointer"
                >
                    <div class="flex items-center justify-between">
                        <div
                            class="w-[34px] h-[34px] rounded-[9px] bg-[#a78bfa18] flex items-center justify-center text-[#a78bfa]"
                        >
                            <svg
                                width="16"
                                height="16"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p
                            class="text-[10.5px] font-medium uppercase tracking-[0.06em] text-[#aaaabe] mb-1"
                        >
                            Total Products
                        </p>
                        <p
                            class="mono text-[28px] font-medium text-[#a78bfa] tracking-[-0.03em]"
                        >
                            {{ summary.products }}
                        </p>
                    </div>
                </div>

                <!-- Sales -->
                <div
                    class="bg-[#0f1114] border border-[#1c2028] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-0.5 transition-transform cursor-pointer"
                >
                    <div class="flex items-center justify-between">
                        <div
                            class="w-[34px] h-[34px] rounded-[9px] bg-[#60a5fa18] flex items-center justify-center text-[#60a5fa]"
                        >
                            <svg
                                width="16"
                                height="16"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p
                            class="text-[10.5px] font-medium uppercase tracking-[0.06em] text-[#aaaabe] mb-1"
                        >
                            Total Sales
                        </p>
                        <p
                            class="mono text-[28px] font-medium text-[#60a5fa] tracking-[-0.03em]"
                        >
                            {{ summary.sales }}
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </SideNavLayout>
</template>

<style lang="css" scoped></style>
