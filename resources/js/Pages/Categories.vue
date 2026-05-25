<script setup>
import AlertDialog from "@/Components/ui/alert-dialog/AlertDialog.vue";
import AlertDialogAction from "@/Components/ui/alert-dialog/AlertDialogAction.vue";
import AlertDialogCancel from "@/Components/ui/alert-dialog/AlertDialogCancel.vue";
import AlertDialogContent from "@/Components/ui/alert-dialog/AlertDialogContent.vue";
import AlertDialogDescription from "@/Components/ui/alert-dialog/AlertDialogDescription.vue";
import AlertDialogHeader from "@/Components/ui/alert-dialog/AlertDialogHeader.vue";
import AlertDialogTitle from "@/Components/ui/alert-dialog/AlertDialogTitle.vue";
import AlertDialogTrigger from "@/Components/ui/alert-dialog/AlertDialogTrigger.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import SideNavLayout from "../Layout/SideNavLayout.vue";

const page = usePage();

const headers = [
    { text: "ID", value: "id" },
    { text: "Name", value: "name" },
    { text: "Actions", value: "actions" },
];

const items = computed(() => ref(page.props.categories));

const searchValue = ref("");

const deleteItem = (id) => {
    router.delete(`/delete-category/${id}`);
};
</script>

<template>
    <SideNavLayout>
        <div class="px-4 sm:px-6 md:px-8 py-6 md:py-9">
            <div
                class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-7"
            >
                <div>
                    <p
                        class="text-[11.5px] font-semibold tracking-[0.06em] uppercase text-subtle mb-1.5"
                    >
                        Manage · Catalog
                    </p>
                    <h1
                        class="text-[22px] sm:text-[24px] md:text-[26px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                    >
                        Categories
                    </h1>
                    <p class="text-[13px] text-subtle mt-1.5">
                        Organize your products into groups.
                    </p>
                </div>
                <Link
                    :href="'/category-save-page?id=0'"
                    class="flex items-center justify-center gap-1.5 bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[13px] font-bold px-4 py-2.5 sm:py-2 rounded-[10px] tracking-[-0.02em] transition-colors self-start sm:self-auto w-full sm:w-auto"
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
                    Add Category
                </Link>
            </div>

            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3.5"
            >
                <div
                    class="flex items-center gap-2 bg-[#111113] border border-[#1a1a1e] rounded-[10px] px-3 py-[8px] w-full sm:w-64"
                >
                    <svg
                        width="13"
                        height="13"
                        fill="none"
                        stroke="#3a3a48"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                    <input
                        v-model="searchValue"
                        type="text"
                        placeholder="Filter categories…"
                        class="bg-transparent text-[13px] text-ink placeholder-[#3a3a48] outline-none w-full"
                    />
                </div>
                <div class="flex items-center gap-2 self-end sm:self-auto">
                    <span class="text-[11.5px] text-subtle">
                        <span class="text-[#5a5a6e]">{{
                            items.value.length
                        }}</span>
                        total categories
                    </span>
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <easy-data-table
                    class="customize-table"
                    table-class-name="customize-table"
                    :headers="headers"
                    :items="items"
                    :search-value="searchValue"
                    :rows-per-page="10"
                    alternating
                    hide-rows-per-page
                    :theme-color="'#c8a96e'"
                    show-index
                >
                    <template #item-index="{ index }">
                        <span class="text-[12px] text-subtle">{{ index }}</span>
                    </template>

                    <template #item-id="{ id }">
                        <span class="text-[12px] text-subtle">{{ id }}</span>
                    </template>

                    <template #item-name="{ name }">
                        <span class="text-[13px] font-medium text-ink">{{
                            name
                        }}</span>
                    </template>

                    <template #item-actions="item">
                        <div class="flex items-center gap-2">
                            <Link
                                :href="'/category-save-page?id=' + item.id"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] text-[12px] font-semibold text-gold bg-[#c8a96e10] border border-[#c8a96e22] hover:bg-[#c8a96e20] hover:border-[#c8a96e44] transition-all duration-150"
                            >
                                <svg
                                    width="11"
                                    height="11"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>
                                Edit
                            </Link>
                            <AlertDialog>
                                <AlertDialogTrigger as-child>
                                    <button
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] text-[12px] font-semibold text-terra bg-[#f4725210] border border-[#f4725222] hover:bg-[#f4725225] hover:border-[#f4725244] transition-all duration-150"
                                    >
                                        <svg
                                            width="11"
                                            height="11"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            stroke-width="2.2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                        Delete
                                    </button>
                                </AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle
                                            >Delete Category?</AlertDialogTitle
                                        >
                                        <AlertDialogDescription>
                                            This action cannot be undone. This
                                            will permanently delete this
                                            category.
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>

                                    <AlertDialogFooter class="dialog-footer">
                                        <AlertDialogCancel
                                            >Cancel</AlertDialogCancel
                                        >

                                        <AlertDialogAction
                                            @click="deleteItem(item.id)"
                                        >
                                            Delete
                                        </AlertDialogAction>
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                        </div>
                    </template>
                </easy-data-table>
            </div>
        </div>
    </SideNavLayout>
</template>

<style lang="css" scoped></style>
