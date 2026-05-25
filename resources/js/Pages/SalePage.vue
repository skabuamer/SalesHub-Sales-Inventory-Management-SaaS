<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { toast } from "vue-sonner";
import SideNavLayout from "../Layout/SideNavLayout.vue";

const page = usePage();

const CustomerHeaders = [
    { text: "ID", value: "id" },
    { text: "Name", value: "name" },
    { text: "Email", value: "email" },
    { text: "Phone", value: "phone" },
    { text: "Actions", value: "actions" },
];
const customerItems = ref(page.props.customers);
const searchValue = ref("");

const selectedCustomer = ref(null);
const addCustomerToSale = (customer) => (selectedCustomer.value = customer);

// products
const ProductHeaders = [
    { text: "ID", value: "id" },
    { text: "Image", value: "img" },
    { text: "Name", value: "name" },
    { text: "Price", value: "price" },
    { text: "Quantity", value: "unit" },
    // { text: "Category", value: "category.name" },
    { text: "Actions", value: "actions" },
];
const productItems = ref(page.props.products);
const searchProdctValue = ref("");

const selectedProducts = ref([]);
const addProductsToSale = (id, name, price, img, productUnit) => {
    const existingProdcut = selectedProducts.value.find(
        (product) => product.id === id,
    );

    const remainingStock = getRemainingStock(id);

    if (remainingStock <= 0) {
        toast.warning(`Product with ID ${id} is out of stock.`);
        return;
    }

    if (existingProdcut) {
        existingProdcut.unit++;
    } else {
        selectedProducts.value.push({
            id,
            name,
            price,
            img,
            unit: 1,
        });
    }

    recalculateTotals();
};

const getRemainingStock = (productId) => {
    const originalProduct = productItems.value.find((p) => p.id === productId);

    const selectedProduct = selectedProducts.value.find(
        (p) => p.id === productId,
    );

    const selectedQty = selectedProduct ? selectedProduct.unit : 0;

    return originalProduct.unit - selectedQty;
};

const incQty = (id) => {
    const product = selectedProducts.value.find((product) => product.id === id);
    if (getRemainingStock(id) <= 0) {
        toast.warning("Product is out of stock.");
        return;
    }

    product.unit++;

    recalculateTotals();
};

const decQty = (id) => {
    const product = selectedProducts.value.find((product) => product.id === id);

    if (product.unit > 1) {
        product.unit--;
        recalculateTotals();
    }
};

const removeProductFromSale = (index) => {
    selectedProducts.value.splice(index, 1);
    recalculateTotals();
    removeDiscount();
};

const vatAmount = ref(0);
const vatRate = ref(5);

const calculateTotal = () => {
    return selectedProducts.value.reduce(
        (total, product) => total + product.price * product.unit,
        0,
    );
};

const applyVat = () => {
    vatAmount.value = (calculateTotal() * vatRate.value) / 100;
    calculatePayable();
};

const removeVat = () => {
    vatAmount.value = 0;
    calculatePayable();
};

const discountAmount = ref(0);
const usePercentDiscount = ref(true);
const flatDiscount = ref(0);
const percentageDiscount = ref(0);

const applyDiscount = () => {
    if (selectedProducts.value.length > 0) {
        if (usePercentDiscount.value) {
            if (percentageDiscount.value > 100) {
                toast.warning("Percentage cannot exceed 100%.");
                return;
            }
            discountAmount.value =
                (calculateTotal() * percentageDiscount.value) / 100;
        } else {
            if (flatDiscount.value > calculateTotal()) {
                toast.warning("Discount cannot exceed subtotal.");
                return;
            }
            discountAmount.value = flatDiscount.value;
        }
        calculatePayable();
    } else {
        toast.warning("Please add at least one product.");
    }
};

const removeDiscount = () => {
    flatDiscount.value = 0;
    percentageDiscount.value = 0;
    discountAmount.value = 0;
    calculatePayable();
};
const payable = ref(0);
const calculatePayable = () => {
    const totalAmount = calculateTotal();
    payable.value = Math.max(
        totalAmount + vatAmount.value - discountAmount.value,
        0,
    );
};

const recalculateTotals = () => {
    // VAT
    vatAmount.value = (calculateTotal() * vatRate.value) / 100;

    // Discount
    if (usePercentDiscount.value) {
        discountAmount.value =
            (calculateTotal() * percentageDiscount.value) / 100;
    }

    // Payable
    payable.value = calculateTotal() + vatAmount.value - discountAmount.value;
};

const form = useForm({
    customer_id: "",
    total: "",
    discount: "",
    vat: "",
    payable: "",
    products: "",
});

const createInvoice = () => {
    // Customer validation
    if (!selectedCustomer.value) {
        toast.warning("Please select a customer.");
        return;
    }

    // Product validation
    if (selectedProducts.value.length === 0) {
        toast.warning("Please add at least one product.");
        return;
    }

    form.customer_id = selectedCustomer.value.id;
    form.total = calculateTotal();
    form.discount = discountAmount.value;
    form.vat = vatAmount.value;
    form.payable = payable.value;
    form.products = selectedProducts.value;

    form.post("/create-invoice", {
        onSuccess: () => {
            selectedCustomer.value = null;
            selectedProducts.value = [];

            vatAmount.value = 0;
            discountAmount.value = 0;
            payable.value = 0;

            flatDiscount.value = 0;
            percentageDiscount.value = 0;

            usePercentDiscount.value = true;
        },
        onError: () => {
            toast.warning("Failed to create invoice.");
        },
    });
};
</script>

<template>
    <SideNavLayout>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="w-full overflow-hidden">
                <div class="flex items-start justify-between mb-7 gap-4">
                    <div>
                        <h1
                            class="text-[22px] sm:text-[26px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                        >
                            Products
                        </h1>
                        <p class="text-[13px] text-subtle mt-1.5">
                            Select products for sale.
                        </p>
                    </div>
                    <Link
                        :href="'/product-save-page?id=0'"
                        class="flex items-center gap-1.5 bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[13px] font-bold px-4 py-2 rounded-[10px] tracking-[-0.02em] transition-colors whitespace-nowrap"
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
                        Add Product
                    </Link>
                </div>

                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3.5"
                >
                    <div
                        class="flex items-center gap-2 bg-surface border border-border rounded-[10px] px-3 py-[8px] w-full sm:w-64"
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
                            v-model="searchProdctValue"
                            type="text"
                            placeholder="Search Products..."
                            class="bg-transparent text-[13px] text-ink placeholder-[#3a3a48] outline-none w-full"
                        />
                    </div>
                    <div class="flex items-center gap-2 sm:justify-end">
                        <span class="text-[11.5px] text-subtle">
                            <span class="text-[#5a5a6e]">{{
                                productItems.length
                            }}</span>
                            total products
                        </span>
                    </div>
                </div>

                <easy-data-table
                    class="customize-table"
                    table-class-name="customize-table"
                    :headers="ProductHeaders"
                    :items="productItems"
                    :rows-per-page="3"
                    :search-value="searchProdctValue"
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

                    <template #item-unit="{ id }">
                        <span
                            class="text-[13px] font-medium"
                            :class="
                                getRemainingStock(id) > 0
                                    ? 'text-ink'
                                    : 'text-red-400'
                            "
                        >
                            {{ getRemainingStock(id) }} Left
                        </span>
                    </template>

                    <template #item-img="{ img, name }">
                        <img :src="img" :alt="name" class="w-16 sm:w-20" />
                    </template>

                    <template #item-actions="{ id, name, price, img, unit }">
                        <div class="flex items-center gap-2">
                            <button
                                @click="
                                    addProductsToSale(
                                        id,
                                        name,
                                        price,
                                        img,
                                        unit,
                                    )
                                "
                                :disabled="getRemainingStock(id) <= 0"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] text-[12px] font-semibold text-gold bg-[#c8a96e10] border border-[#c8a96e22] hover:bg-[#c8a96e20] hover:border-[#c8a96e44] transition-all duration-150 disabled:opacity-50 whitespace-nowrap"
                            >
                                <i class="ri-add-line"></i>
                                {{
                                    getRemainingStock(id) > 0
                                        ? `Add to Sale`
                                        : "Stock Out"
                                }}
                            </button>
                        </div>
                    </template>
                </easy-data-table>
            </div>

            <div class="w-full overflow-hidden">
                <div class="flex items-start justify-between mb-7 gap-4">
                    <div>
                        <h1
                            class="text-[22px] sm:text-[26px] font-bold text-[#e8e3db] tracking-[-0.04em] leading-tight"
                        >
                            Customers
                        </h1>
                        <p class="text-[13px] text-subtle mt-1.5">
                            Select customers for sale.
                        </p>
                    </div>
                    <Link
                        :href="'/customer-save-page?id=0'"
                        class="flex items-center gap-1.5 bg-gold hover:bg-[#d4b87a] text-[#0e0e10] text-[13px] font-bold px-4 py-2 rounded-[10px] tracking-[-0.02em] transition-colors whitespace-nowrap"
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
                        Add Customer
                    </Link>
                </div>

                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3.5"
                >
                    <div
                        class="flex items-center gap-2 bg-surface border border-border rounded-[10px] px-3 py-[8px] w-full sm:w-64"
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
                            placeholder="Search Customers…"
                            class="bg-transparent text-[13px] text-ink placeholder-[#3a3a48] outline-none w-full"
                        />
                    </div>
                    <div class="flex items-center gap-2 sm:justify-end">
                        <span class="text-[11.5px] text-subtle">
                            <span class="text-[#5a5a6e]">{{
                                customerItems.length
                            }}</span>
                            total customers
                        </span>
                    </div>
                </div>

                <!-- <div class="overflow-x-auto w-full generic-scrollbar"> -->
                <easy-data-table
                    class="customize-table"
                    table-class-name="customize-table"
                    :headers="CustomerHeaders"
                    :items="customerItems"
                    :search-value="searchValue"
                    :rows-per-page="3"
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

                    <template #item-actions="{ id, name, email, phone }">
                        <div class="flex items-center gap-2">
                            <button
                                @click="
                                    addCustomerToSale({
                                        id,
                                        name,
                                        email,
                                        phone,
                                    })
                                "
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] text-[12px] font-semibold text-gold bg-[#c8a96e10] border border-[#c8a96e22] hover:bg-[#c8a96e20] hover:border-[#c8a96e44] transition-all duration-150 whitespace-nowrap"
                            >
                                <i class="ri-add-line"></i>
                                Add to Sale
                            </button>
                        </div>
                    </template>
                </easy-data-table>
                <!-- </div> -->
            </div>

            <div class="col-span-1 lg:col-span-2 w-full">
                <div class="mb-4">
                    <h2
                        class="text-[18px] font-bold text-[#e8e3db] tracking-[-0.03em]"
                    >
                        Customer Information
                    </h2>
                    <p class="text-[12px] text-subtle mt-1">
                        Review selected customer and products before confirming
                        sale.
                    </p>
                </div>

                <div
                    class="bg-surface border border-border rounded-[18px] p-4 sm:p-6 space-y-6 shadow-[0_0_0_1px_rgba(255,255,255,0.02)]"
                >
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 border border-border rounded-[14px] bg-[#111114] p-4 sm:p-5"
                    >
                        <div>
                            <div class="space-y-2 text-[13px] text-subtle">
                                <p class="flex flex-wrap">
                                    <span class="text-[#6d6d80]">Name:</span>
                                    <span
                                        class="text-ink font-medium ml-1 break-all"
                                    >
                                        {{
                                            selectedCustomer?.name ||
                                            "Not Selected"
                                        }}
                                    </span>
                                </p>

                                <p class="flex flex-wrap">
                                    <span class="text-[#6d6d80]">Email:</span>
                                    <span
                                        class="text-ink font-medium ml-1 break-all"
                                    >
                                        {{
                                            selectedCustomer?.email ||
                                            "Not Available"
                                        }}
                                    </span>
                                </p>

                                <p class="flex flex-wrap">
                                    <span class="text-[#6d6d80]">Phone:</span>
                                    <span
                                        class="text-ink font-medium ml-1 break-all"
                                    >
                                        {{
                                            selectedCustomer?.phone ||
                                            "Not Available"
                                        }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex justify-start sm:justify-end items-start"
                        >
                            <div
                                class="text-left sm:text-right space-y-2 text-[13px] text-subtle"
                            >
                                <p>
                                    <span class="text-[#6d6d80]">Date:</span>
                                    <span class="text-ink font-medium ml-1">
                                        {{ new Date().toLocaleDateString() }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-x-auto border border-border rounded-[16px] bg-[#111114] w-full generic-scrollbar"
                    >
                        <table class="w-full min-w-[600px]">
                            <thead class="border-b border-border bg-[#0f0f12]">
                                <tr>
                                    <th
                                        class="px-5 py-4 text-left text-[12px] uppercase tracking-wide text-[#7d7d92] font-semibold"
                                    >
                                        Product
                                    </th>
                                    <th
                                        class="px-5 py-4 text-center text-[12px] uppercase tracking-wide text-[#7d7d92] font-semibold"
                                    >
                                        Qty
                                    </th>
                                    <th
                                        class="px-5 py-4 text-right text-[12px] uppercase tracking-wide text-[#7d7d92] font-semibold"
                                    >
                                        Price
                                    </th>
                                    <th
                                        class="px-5 py-4 text-right text-[12px] uppercase tracking-wide text-[#7d7d92] font-semibold"
                                    >
                                        Total
                                    </th>
                                    <th
                                        class="px-5 py-4 text-right text-[12px] uppercase tracking-wide text-[#7d7d92] font-semibold"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr
                                    class="border-t border-border hover:bg-[#15151a] transition-colors"
                                    v-if="selectedProducts.length > 0"
                                    v-for="(product, index) in selectedProducts"
                                    :key="index"
                                >
                                    <td
                                        class="px-5 py-4 text-[13px] text-ink font-medium"
                                    >
                                        {{ product.name }}
                                    </td>
                                    <td
                                        class="px-5 py-4 text-[13px] text-center text-subtle"
                                    >
                                        {{ product.unit }}
                                    </td>
                                    <td
                                        class="px-5 py-4 text-[13px] text-right text-subtle whitespace-nowrap"
                                    >
                                        ৳ {{ product.price }}
                                    </td>
                                    <td
                                        class="px-5 py-4 text-[13px] text-right text-gold font-semibold whitespace-nowrap"
                                    >
                                        ৳ {{ product.price * product.unit }}
                                    </td>
                                    <td
                                        class="px-5 py-4 text-sm text-right text-gray-700 whitespace-nowrap"
                                    >
                                        <button
                                            class="border border-[#2a2a35] bg-[#17171c] hover:bg-[#202028] text-gold rounded-full w-8 aspect-square mx-0.5 inline-flex items-center justify-center transition-all"
                                            @click="incQty(product.id)"
                                        >
                                            <i class="ri-add-line"></i>
                                        </button>

                                        <button
                                            class="border border-[#2a2a35] bg-[#17171c] hover:bg-[#202028] text-gold rounded-full w-8 aspect-square mx-0.5 inline-flex items-center justify-center disabled:opacity-40 transition-all"
                                            :disabled="product.unit <= 1"
                                            @click="decQty(product.id)"
                                        >
                                            <i class="ri-subtract-line"></i>
                                        </button>

                                        <button
                                            class="border border-[#3a1f1f] bg-[#2a1515] hover:bg-[#3a1c1c] text-red-400 rounded-full w-8 aspect-square mx-0.5 inline-flex items-center justify-center transition-all"
                                            @click="
                                                removeProductFromSale(index)
                                            "
                                        >
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr v-if="selectedProducts.length === 0">
                                    <td
                                        colspan="5"
                                        class="text-center py-10 text-[13px] text-[#5f5f70]"
                                    >
                                        No products selected yet.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end w-full">
                        <div
                            class="w-full lg:max-w-xl border border-border rounded-[16px] bg-[#111114] p-4 sm:p-5 space-y-4"
                        >
                            <div
                                class="flex justify-between text-[13px] text-subtle"
                            >
                                <span>Subtotal</span>
                                <span class="text-ink"
                                    >৳ {{ calculateTotal() }}</span
                                >
                            </div>

                            <div
                                class="flex justify-between text-[13px] text-subtle"
                            >
                                <span>Vat (5%)</span>
                                <span class="text-ink">৳ {{ vatAmount }}</span>
                            </div>

                            <div class="flex flex-wrap justify-end gap-2 pt-1">
                                <button
                                    @click="applyVat"
                                    class="text-[13px] bg-[#16361f] border border-[#21542f] text-[#7ef0a0] hover:bg-[#21542f] px-4 py-2 rounded-[10px] transition-all font-medium flex-1 sm:flex-none"
                                >
                                    Apply Vat
                                </button>

                                <button
                                    @click="removeVat"
                                    class="text-[13px] bg-[#341818] border border-[#552222] text-[#ff8f8f] hover:bg-[#552222] px-4 py-2 rounded-[10px] transition-all font-medium flex-1 sm:flex-none"
                                >
                                    Remove Vat
                                </button>
                            </div>

                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[13px] text-subtle"
                            >
                                <span>Discount Mode</span>
                                <select
                                    v-model="usePercentDiscount"
                                    class="bg-[#17171c] border border-border text-ink rounded-[10px] px-3 py-2 outline-none w-full sm:w-auto"
                                >
                                    <option :value="false">
                                        Flat Discount
                                    </option>
                                    <option :value="true">
                                        Percentage Discount
                                    </option>
                                </select>
                            </div>

                            <div
                                v-if="!usePercentDiscount"
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[13px] text-subtle"
                            >
                                <span>Flat Discount</span>
                                <form
                                    @submit.prevent="applyDiscount"
                                    class="flex flex-wrap gap-2 w-full sm:w-auto"
                                >
                                    <input
                                        type="number"
                                        min="0"
                                        v-model="flatDiscount"
                                        class="bg-[#17171c] border border-border text-ink rounded-[10px] px-3 py-2 outline-none flex-1 sm:w-36 sm:flex-initial"
                                    />
                                    <button
                                        class="text-[13px] bg-[#16361f] border border-[#21542f] text-[#7ef0a0] hover:bg-[#21542f] px-4 py-2 rounded-[10px] transition-all font-medium"
                                    >
                                        Apply
                                    </button>
                                </form>
                            </div>

                            <div
                                v-if="usePercentDiscount"
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[13px] text-subtle"
                            >
                                <span>Percentage Discount</span>
                                <form
                                    @submit.prevent="applyDiscount"
                                    class="flex flex-wrap gap-2 w-full sm:w-auto"
                                >
                                    <input
                                        type="number"
                                        min="0"
                                        v-model="percentageDiscount"
                                        class="bg-[#17171c] border border-border text-ink rounded-[10px] px-3 py-2 outline-none flex-1 sm:w-36 sm:flex-initial"
                                    />
                                    <button
                                        class="text-[13px] bg-[#16361f] border border-[#21542f] text-[#7ef0a0] hover:bg-[#21542f] px-4 py-2 rounded-[10px] transition-all font-medium"
                                    >
                                        Apply
                                    </button>
                                </form>
                            </div>

                            <div
                                class="flex justify-between text-[13px] text-subtle"
                            >
                                <span>Discount</span>
                                <div class="text-ink">
                                    <span>৳</span> {{ discountAmount }}
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    @click="removeDiscount"
                                    class="text-[13px] bg-[#341818] border border-[#552222] text-[#ff8f8f] hover:bg-[#552222] px-4 py-2 rounded-[10px] transition-all font-medium w-full sm:w-auto"
                                >
                                    Remove Discount
                                </button>
                            </div>

                            <div
                                class="flex justify-between items-center border-t border-border pt-4"
                            >
                                <span
                                    class="text-[18px] sm:text-[20px] font-bold text-[#e8e3db] tracking-[-0.03em]"
                                >
                                    Total
                                </span>
                                <span
                                    class="text-[20px] sm:text-[22px] font-bold text-gold tracking-[-0.03em]"
                                >
                                    ৳ {{ payable }}
                                </span>
                            </div>

                            <button
                                @click="createInvoice"
                                :disabled="form.processing"
                                class="w-full bg-gold hover:bg-[#d4b87a] text-[#0e0e10] font-bold py-3 rounded-[12px] transition-all tracking-[-0.02em] disabled:opacity-50"
                            >
                                {{
                                    form.processing
                                        ? "Processing..."
                                        : "Confirm Sale"
                                }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SideNavLayout>
</template>

<style lang="css" scoped></style>
