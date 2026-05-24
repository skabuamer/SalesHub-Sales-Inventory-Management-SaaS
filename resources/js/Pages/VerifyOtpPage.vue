<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import NavLayout from "../Layout/NavLayout.vue";

const form = useForm({
    otp: "",
});

const page = usePage();

const submit = () => {
    form.post("/verify-otp");
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
                                d="M9 12l2 2 4-4"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"
                            />
                        </svg>
                    </div>

                    <h2
                        class="text-[30px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                    >
                        Verify OTP
                    </h2>

                    <p class="text-[13px] text-subtle mt-2 leading-relaxed">
                        Enter the OTP sent to your email to continue resetting
                        your password.
                    </p>
                </div>

                <!-- Form -->
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- OTP -->
                    <div>
                        <label
                            for="otp"
                            class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                        >
                            One Time Password
                        </label>

                        <input
                            id="otp"
                            v-model="form.otp"
                            type="text"
                            placeholder="Enter your OTP"
                            class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                        />

                        <!-- validation check -->
                        <div
                            v-if="form.errors.otp"
                            class="text-[#ff8f8f] text-[12px] mt-2"
                        >
                            {{ form.errors.otp }}
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div
                        v-if="page.props.flash.success"
                        class="bg-[#16361f] border border-[#21542f] text-[#7ef0a0] px-4 py-3 rounded-[12px] text-[13px]"
                    >
                        {{ page.props.flash.message }}
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
                            form.processing ? "Verifying OTP..." : "Verify OTP"
                        }}
                    </button>
                </form>
            </div>
        </div>
    </NavLayout>
</template>

<style lang="css" scoped></style>
