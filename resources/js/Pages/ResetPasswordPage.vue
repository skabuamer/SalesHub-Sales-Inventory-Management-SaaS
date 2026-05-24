<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import NavLayout from "../Layout/NavLayout.vue";

const form = useForm({
    password: "",
    confirm_password: "",
});

const page = usePage();

const submit = () => {
    form.post("/reset-password");
};
</script>

<template>
    <NavLayout>
        <div
            class="min-h-screen flex items-center justify-center bg-[#09090b] px-4"
        >
            <!-- Card -->
            <div
                class="w-full max-w-md bg-surface border border-border rounded-[24px] p-8 shadow-[0_0_0_1px_rgba(255,255,255,0.02)]"
            >
                <!-- Header -->
                <div class="text-center mb-8">
                    <div
                        class="w-14 h-14 mx-auto mb-5 rounded-[16px] bg-gold flex items-center justify-center shadow-lg"
                    >
                        <svg
                            width="24"
                            height="24"
                            fill="none"
                            stroke="#0e0e10"
                            viewBox="0 0 24 24"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2V9a2 2 0 00-2-2h-1V5a5 5 0 00-10 0v2H6a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>
                    </div>

                    <h2
                        class="text-[30px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                    >
                        Reset Password
                    </h2>

                    <p class="text-[13px] text-subtle mt-2 leading-relaxed">
                        Enter your new password to complete the password reset
                        process.
                    </p>
                </div>

                <!-- Form -->
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- New Password -->
                    <div>
                        <label
                            for="password"
                            class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                        >
                            New Password
                        </label>

                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="Enter your new password"
                            class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                        />

                        <!-- validation check -->
                        <div
                            v-if="form.errors.password"
                            class="text-[#ff8f8f] text-[12px] mt-2"
                        >
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label
                            for="confirm_password"
                            class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                        >
                            Confirm New Password
                        </label>

                        <input
                            id="confirm_password"
                            v-model="form.confirm_password"
                            type="password"
                            placeholder="Re-enter your new password"
                            class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                        />

                        <!-- validation check -->
                        <div
                            v-if="form.errors.confirm_password"
                            class="text-[#ff8f8f] text-[12px] mt-2"
                        >
                            {{ form.errors.confirm_password }}
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div
                        v-if="page.props.flash.success"
                        class="bg-[#16361f] border border-[#21542f] text-[#7ef0a0] px-4 py-3 rounded-[12px] text-[13px]"
                    >
                        {{ page.props.flash.success }}
                    </div>

                    <!-- Error Message -->
                    <div
                        v-if="page.props.flash.error"
                        class="bg-[#341818] border border-[#552222] text-[#ff8f8f] px-4 py-3 rounded-[12px] text-[13px]"
                    >
                        {{ page.props.flash.error }}
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[14px] font-bold py-3 rounded-[12px] tracking-[-0.02em] transition-all disabled:opacity-50"
                    >
                        {{
                            form.processing
                                ? "Resetting Password..."
                                : "Reset Password"
                        }}
                    </button>
                </form>
            </div>
        </div>
    </NavLayout>
</template>
<style lang="css" scoped></style>
