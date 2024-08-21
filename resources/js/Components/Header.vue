<script setup>
import { Head } from "@inertiajs/vue3";
import Section from "@components/Section.vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    pathBack: {
        type: Function
    }
});
</script>

<template>
    <Head :title="title" />

    <Section
        class="q-mb-md q-mt-md"
        class-content="full-width row justify-between items-center content-center"
    >
        <div class="row">
            <div
                v-if="props.pathBack"
                class="q-mr-md"
            >
                <q-btn
                    icon="chevron_left"
                    :unelevated="true"
                    no-caps
                    padding="xs"
                    @click="props.pathBack"
                />
            </div>

            <h1 class="text-h5 text-weight-bold q-my-none">{{ title }}</h1>
        </div>

        <div v-if="$slots.default">
            <slot />
        </div>
    </Section>
</template>
