<template>
    <div>
        <Fileinput
            :label="useI18n().t('dashboard.browse')"
            :placeholder="useI18n().t('dashboard.choose_file_or_drop_it')"
            name="image"
            @input="onInputChange"
            v-model="props.form.image"
            preview/>
        <div class="text-red-600 text-lg" v-if="props.form.errors.image">{{ props.form.errors.image }}</div>
    </div>
</template>

<script setup>

import Fileinput from "@/Components/Fileinput/index.vue";
import {useI18n} from "vue-i18n";

const props = defineProps({
    form: Object,
})

const onInputChange = (value) => {
    props.form.image = value;
    console.log(props.form);
}

</script>
