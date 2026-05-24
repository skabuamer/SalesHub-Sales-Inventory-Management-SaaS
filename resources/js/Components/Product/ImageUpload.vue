<script setup>
import { ref } from "vue";

const props = defineProps({
    productImage: {
        type: String,
    },
});

const currentImage = props.productImage
    ? props.productImage
    : "/placeholder.png";

const preview = ref(currentImage);

const emit = defineEmits(["imageSelected"]);

const imageSelected = (e) => {
    const file = e.target.files[0];
    if (file) {
        preview.value = URL.createObjectURL(file);
        emit("imageSelected", file);
    }
};
</script>

<template>
    <div>
        <label
            for="image"
            class="group flex flex-col items-center justify-center w-full min-h-[220px] border border-dashed border-border rounded-[18px] bg-[#111114] hover:border-[#c8a96e55] hover:bg-[#15151a] transition-all cursor-pointer overflow-hidden"
        >
            <!-- Preview -->
            <div
                class="w-full h-full flex flex-col items-center justify-center p-5"
            >
                <img
                    :src="(preview || currentImage) ?? '/placeholder.png'"
                    alt="Image"
                    class="w-full h-32 object-cover rounded-[14px] border border-border shadow-sm"
                />

                <div class="mt-5 text-center">
                    <p
                        class="text-[14px] font-medium text-ink group-hover:text-gold transition-colors"
                    >
                        Upload Product Image
                    </p>

                    <p class="text-[12px] text-subtle mt-1">Click to browse</p>
                </div>
            </div>

            <!-- Input -->
            <input
                @input="imageSelected"
                type="file"
                name="image"
                id="image"
                class="hidden"
            />
        </label>
    </div>
</template>

<style lang="css" scoped></style>
