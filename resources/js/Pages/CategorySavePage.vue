<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import SideNavLayout from "../Layout/SideNavLayout.vue";

const form = useForm({
    name: "",
});

const page = usePage();

const urlParams = new URLSearchParams(window.location.search);
const id = ref(parseInt(urlParams.get("id")));

let URL = "/create-category";
let category = page.props.category;

if (id.value !== 0 && category !== null) {
    URL = `/update-category/${id.value}`;
    form.name = category.name;
}

const submit = () => {
    form.post(URL, {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <SideNavLayout>
        <div
            class="max-w-md mx-auto bg-surface border border-border rounded-[24px] p-7 shadow-[0_0_0_1px_rgba(255,255,255,0.02)]"
        >
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1
                        class="text-[26px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                    >
                        Add Category
                    </h1>

                    <p class="text-[13px] text-subtle mt-1.5">
                        Create and organize your product categories.
                    </p>
                </div>

                <Link
                    href="/categories"
                    class="flex items-center gap-2 bg-[#111114] border border-border hover:border-[#c8a96e33] text-ink text-[13px] font-medium px-4 py-2 rounded-[12px] transition-all"
                >
                    <span>←</span>
                    Back
                </Link>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-5">
                <!-- Name -->
                <div>
                    <label
                        class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                    >
                        Category Name
                    </label>

                    <input
                        type="text"
                        placeholder="Enter category name"
                        v-model="form.name"
                        class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                    />

                    <!-- validation check -->
                    <div
                        v-if="form.errors.name"
                        class="text-[#ff8f8f] text-[12px] mt-2"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[14px] font-bold py-3 rounded-[12px] tracking-[-0.02em] transition-all"
                >
                    Save Category
                </button>
            </form>
        </div>
    </SideNavLayout>
</template>

<style lang="css" scoped></style>
