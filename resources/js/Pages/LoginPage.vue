<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import NavLayout from "../Layout/NavLayout.vue";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const page = usePage();

const submit = () => {
    form.post("/user-login");
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
                                d="M12 11c0-3.314 2.686-6 6-6m0 0v6m0-6h-6M6 13v6m0 0h6m-6 0V13m6 0c0 3.314-2.686 6-6 6"
                            />
                        </svg>
                    </div>

                    <h2
                        class="text-[30px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                    >
                        Welcome Back
                    </h2>

                    <p class="text-[13px] text-subtle mt-2">
                        Sign in to manage your sales and inventory.
                    </p>
                </div>

                <!-- Login Form -->
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                        >
                            Email Address
                        </label>

                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="Enter your email"
                            class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                        />

                        <!-- validation check -->
                        <div
                            v-if="form.errors.email"
                            class="text-[#ff8f8f] text-[12px] mt-2"
                        >
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="password"
                            class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="Enter your password"
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

                    <!-- Flash Success -->
                    <div
                        v-if="page.props.flash.success"
                        class="bg-[#16361f] border border-[#21542f] text-[#7ef0a0] px-4 py-3 rounded-[12px] text-[13px]"
                    >
                        {{ page.props.flash.success }}
                    </div>

                    <!-- Flash Error -->
                    <div
                        v-if="page.props.flash.error"
                        class="bg-[#341818] border border-[#552222] text-[#ff8f8f] px-4 py-3 rounded-[12px] text-[13px]"
                    >
                        {{ page.props.flash.error }}
                    </div>

                    <!-- Forgot Password -->
                    <div class="flex justify-end">
                        <Link
                            href="/forgot-password"
                            class="text-[13px] text-gold hover:text-[#d4b87a] transition-colors"
                        >
                            Forgot your password?
                        </Link>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[14px] font-bold py-3 rounded-[12px] tracking-[-0.02em] transition-all disabled:opacity-50"
                    >
                        {{ form.processing ? "Signing in..." : "Sign in" }}
                    </button>

                    <!-- Divider -->
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-border"></div>
                        </div>

                        <div class="relative flex justify-center">
                            <span
                                class="bg-surface px-4 text-[11px] uppercase tracking-wider text-[#5f5f70]"
                            >
                                Account Access
                            </span>
                        </div>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center">
                        <p class="text-[13px] text-subtle">
                            Don’t have an account?

                            <Link
                                href="/register"
                                class="text-gold hover:text-[#d4b87a] font-semibold transition-colors"
                            >
                                Sign up here
                            </Link>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </NavLayout>
</template>
