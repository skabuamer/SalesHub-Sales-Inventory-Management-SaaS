<script setup>
const props = defineProps({
    invoice: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["close"]);

const closeModal = () => {
    emit("close");
};

const printInvoice = () => {
    const ogHtml = document.body.innerHTML;
    const elemHtml = document.getElementById("invoice-modal").innerHTML;
    document.body.innerHTML = elemHtml;
    window.print();
    document.body.innerHTML = ogHtml;
    location.reload();
    closeModal();
};
</script>

<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-3xl bg-surface border border-border rounded-[20px] shadow-[0_10px_40px_rgba(0,0,0,0.4)] max-h-[90%] overflow-auto"
        >
            <div id="invoice-modal">
                <!-- Body -->
                <div class="p-6 space-y-6">
                    <!-- Customer Info -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-[#111114]">
                            <h3
                                class="text-[12px] uppercase tracking-wide text-subtle mb-3"
                            >
                                Customer Information
                            </h3>

                            <div class="space-y-2 text-[13px] text-ink">
                                <p>
                                    <span class="text-subtle">Name:</span>
                                    <span class="font-medium">
                                        {{ invoice.customer.name }}
                                    </span>
                                </p>

                                <p>
                                    <span class="text-subtle">Email:</span>
                                    {{ invoice.customer.email }}
                                </p>

                                <p>
                                    <span class="text-subtle">Phone:</span>
                                    {{ invoice.customer.phone }}
                                </p>
                            </div>
                        </div>

                        <p class="text-[12.5px] text-subtle mt-1 text-end">
                            Date:
                            <span class="text-ink">
                                {{ props.invoice.created_at.split("T")[0] }}
                            </span>
                        </p>
                    </div>

                    <!-- Products Table -->
                    <div class="overflow-x-auto">
                        <table
                            class="w-full border border-border rounded-[14px] overflow-hidden"
                        >
                            <thead class="bg-[#111114]">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-[12px] uppercase text-subtle bg-zinc-800"
                                    >
                                        Product
                                    </th>

                                    <th
                                        class="px-4 py-3 text-center text-[12px] uppercase text-subtle bg-zinc-800"
                                    >
                                        Qty
                                    </th>

                                    <th
                                        class="px-4 py-3 text-right text-[12px] uppercase text-subtle bg-zinc-800"
                                    >
                                        Price
                                    </th>

                                    <th
                                        class="px-4 py-3 text-right text-[12px] uppercase text-subtle bg-zinc-800"
                                    >
                                        Total
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr
                                    v-for="(
                                        product, index
                                    ) in invoice.invoice_products"
                                    :key="index"
                                    class="border-t border-border hover:bg-[#111114]/60 transition"
                                >
                                    <td class="px-4 py-3 text-[13px] text-ink">
                                        {{ product.product.name }}
                                    </td>

                                    <td
                                        class="px-4 py-3 text-center text-[13px] text-subtle"
                                    >
                                        {{ product.qty }}
                                    </td>

                                    <td
                                        class="px-4 py-3 text-right text-[13px] text-subtle"
                                    >
                                        ৳ {{ product.product.price }}
                                    </td>

                                    <td
                                        class="px-4 py-3 text-right text-[13px] text-ink font-medium"
                                    >
                                        ৳
                                        {{
                                            product.product.price * product.qty
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="flex justify-end">
                        <div
                            class="w-full max-w-xs bg-[#111114] border border-border rounded-[14px] p-4 space-y-2"
                        >
                            <div
                                class="flex justify-between text-[13px] text-subtle"
                            >
                                <span>Subtotal</span>
                                <span class="text-ink"
                                    >৳ {{ invoice.total }}</span
                                >
                            </div>

                            <div
                                class="flex justify-between text-[13px] text-subtle"
                            >
                                <span>Vat</span>
                                <span class="text-ink"
                                    >৳ {{ invoice.vat }}</span
                                >
                            </div>

                            <div
                                class="flex justify-between text-[13px] text-subtle"
                            >
                                <span>Discount</span>
                                <span class="text-ink"
                                    >৳ {{ invoice.discount }}</span
                                >
                            </div>

                            <div
                                class="flex justify-between text-[15px] font-bold text-[#e8e3db] border-t border-border pt-2"
                            >
                                <span>Total</span>
                                <span class="text-gold">
                                    ৳ {{ invoice.payable }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="flex items-center justify-end gap-3 px-6 py-4 border-t border-border bg-[#0f0f12]"
            >
                <button
                    @click="closeModal"
                    class="px-4 py-2 rounded-[10px] border border-border text-subtle hover:text-ink hover:border-[#c8a96e33] transition"
                >
                    Close
                </button>

                <button
                    @click="printInvoice"
                    class="px-4 py-2 rounded-[10px] bg-gold hover:bg-[#d4b87a] text-[#0e0e10] font-semibold transition"
                >
                    Print Invoice
                </button>
            </div>
        </div>
    </div>
</template>

<style lang="css" scoped>
.invoice-modal {
    font-family:
        system-ui,
        -apple-system,
        sans-serif;
}

/* Header */
.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.invoice-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.invoice-date {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

.close-btn {
    color: #6b7280;
    font-size: 1.875rem;
    line-height: 1;
    border: 1px solid #6b7280;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 9999px;
    background: transparent;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition:
        color 0.2s ease,
        border-color 0.2s ease;
}

.close-btn:hover {
    color: #ef4444;
    border-color: #ef4444;
}

/* Body */
.invoice-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.section-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: #4b5563;
}

.info-list p {
    margin: 0;
}

.text-right {
    text-align: right;
}

/* Table */
.table-wrapper {
    overflow-x: auto;
}

.products-table {
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    border-collapse: separate;
    border-spacing: 0;
    overflow: hidden;
}

.products-table thead {
    background-color: #f3f4f6;
}

.products-table th,
.products-table td {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: #374151;
}

.products-table th {
    font-weight: 600;
}

.products-table tbody tr {
    border-top: 1px solid #e5e7eb;
}

.text-left {
    text-align: left;
}

.text-center {
    text-align: center;
}

/* Summary */
.summary-wrapper {
    display: flex;
    justify-content: flex-end;
}

.summary-box {
    width: 100%;
    max-width: 20rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.875rem;
    color: #4b5563;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    border-top: 1px solid #e5e7eb;
    padding-top: 0.5rem;
}
</style>
