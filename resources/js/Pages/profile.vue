<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import SideNavLayout from "../Layout/SideNavLayout.vue";

const page = usePage();

const form = useForm({
    name: "",
    email: "",
});

form.name = page.props.user.name;
form.email = page.props.user.email;

const submit = () => {
    form.post("/update-profile");
};
</script>
<template>
    <SideNavLayout>
        <div>
            <!-- Header -->
            <div class="mb-7">
                <h1
                    class="text-[28px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                >
                    Profile Information
                </h1>

                <p class="text-[13px] text-subtle mt-1.5">
                    Manage your personal account details.
                </p>
            </div>

            <!-- Profile Card -->
            <div
                class="bg-surface border border-border rounded-[18px] p-6 shadow-[0_0_0_1px_rgba(255,255,255,0.02)]"
            >
                <form
                    @submit.prevent="submit"
                    class="grid grid-cols-1 md:grid-cols-2 gap-5"
                >
                    <!-- Name -->
                    <div>
                        <label
                            class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                        >
                            Full Name
                        </label>

                        <input
                            type="text"
                            v-model="form.name"
                            class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                        />
                    </div>

                    <!-- Email -->
                    <div>
                        <label
                            class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                        >
                            Email Address
                        </label>

                        <input
                            type="email"
                            disabled
                            v-model="form.email"
                            class="w-full bg-[#0d0d10] border border-border rounded-[12px] px-4 py-3 text-[14px] text-[#6d6d80] outline-none disabled:cursor-not-allowed"
                        />
                    </div>

                    <!-- Button -->
                    <div class="md:col-span-2 flex justify-end pt-2">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[14px] font-bold px-6 py-3 rounded-[12px] tracking-[-0.02em] transition-all disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? "Updating..."
                                    : "Update Profile"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </SideNavLayout>
</template>
<style lang="css" scoped></style>
