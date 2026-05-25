<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import ImageUpload from "../Components/Product/ImageUpload.vue";
import SideNavLayout from "../Layout/SideNavLayout.vue";

const form = useForm({
    name: "",
    price: "",
    unit: "",
    category_id: "",
    img: null,
});

const page = usePage();

const urlParams = new URLSearchParams(window.location.search);
const id = ref(parseInt(urlParams.get("id")));

let URL = "/create-product";
let product = page.props.product;

if (id.value !== 0 && product !== null) {
    URL = `/update-product/${id.value}`;
    form.name = product.name;
    form.price = product.price;
    form.unit = product.unit;
    form.category_id = product.category_id;
    form.img = product.img;
}
const imageKey = ref(0);
const submit = () => {
    form.post(URL, {
        onSuccess: () => {
            form.reset();
            imageKey.value++;
        },
    });
};
</script>
<template>
    <SideNavLayout>
        <div
            class="w-full max-w-2xl mx-auto bg-surface border border-border rounded-[20px] sm:rounded-[24px] p-5 sm:p-7 shadow-[0_0_0_1px_rgba(255,255,255,0.02)]"
        >
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8"
            >
                <div>
                    <h1
                        class="text-[22px] sm:text-[26px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                    >
                        Add/Edit Product
                    </h1>

                    <p class="text-[13px] text-subtle mt-1.5">
                        Manage product information and inventory.
                    </p>
                </div>

                <Link
                    href="/products"
                    class="w-fit flex items-center gap-2 bg-[#111114] border border-border hover:border-[#c8a96e33] text-ink text-[13px] font-medium px-4 py-2 rounded-[12px] transition-all"
                >
                    <span>←</span>
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label
                        class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                    >
                        Product Name
                    </label>

                    <input
                        type="text"
                        placeholder="Enter product name"
                        v-model="form.name"
                        class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                    />

                    <div
                        v-if="form.errors.name"
                        class="text-[#ff8f8f] text-[12px] mt-2"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>

                <div>
                    <label
                        class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                    >
                        Price
                    </label>

                    <input
                        type="number"
                        placeholder="Enter product price"
                        v-model="form.price"
                        class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                    />

                    <div
                        v-if="form.errors.price"
                        class="text-[#ff8f8f] text-[12px] mt-2"
                    >
                        {{ form.errors.price }}
                    </div>
                </div>

                <div>
                    <label
                        class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                    >
                        Quantity
                    </label>

                    <input
                        type="number"
                        placeholder="Enter quantity"
                        v-model="form.unit"
                        class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink placeholder-[#4c4c5d] outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                    />

                    <div
                        v-if="form.errors.unit"
                        class="text-[#ff8f8f] text-[12px] mt-2"
                    >
                        {{ form.errors.unit }}
                    </div>
                </div>

                <div>
                    <label
                        class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                    >
                        Category
                    </label>

                    <select
                        name="category_id"
                        v-model="form.category_id"
                        class="w-full bg-[#111114] border border-border rounded-[12px] px-4 py-3 text-[14px] text-ink outline-none transition-all focus:border-[#c8a96e55] focus:ring-1 focus:ring-[#c8a96e33]"
                    >
                        <option disabled value="none">Select Category</option>

                        <option
                            v-for="category in page.props.categories"
                            :key="category_id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>

                    <div
                        v-if="form.errors.category_id"
                        class="text-[#ff8f8f] text-[12px] mt-2"
                    >
                        {{ form.errors.category_id }}
                    </div>
                </div>

                <div>
                    <label
                        class="block text-[12px] font-medium text-[#7d7d92] uppercase tracking-wide mb-2"
                    >
                        Product Image
                    </label>

                    <div
                        class="bg-[#111114] border border-border rounded-[14px] p-4"
                    >
                        <ImageUpload
                            :key="imageKey"
                            :productImage="form.img"
                            @imageSelected="(e) => (form.img = e)"
                            class="w-full"
                        />
                    </div>

                    <div
                        v-if="form.errors.img"
                        class="text-[#ff8f8f] text-[12px] mt-2"
                    >
                        {{ form.errors.img }}
                    </div>
                </div>

                <div
                    v-if="showFlash && page.props.flash.message"
                    class="bg-[#16361f] border border-[#21542f] text-[#7ef0a0] px-4 py-3 rounded-[12px] text-[13px]"
                >
                    {{ page.props.flash.message }}
                </div>

                <div
                    v-if="showFlash && page.props.flash.error"
                    class="bg-[#341818] border border-[#552222] text-[#ff8f8f] px-4 py-3 rounded-[12px] text-[13px]"
                >
                    {{ page.props.flash.error }}
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[14px] font-bold py-3.5 rounded-[12px] tracking-[-0.02em] transition-all disabled:opacity-50"
                >
                    {{ form.processing ? "Saving..." : "Save Product" }}
                </button>
            </form>
        </div>
    </SideNavLayout>
</template>

<style lang="css" scoped></style>
