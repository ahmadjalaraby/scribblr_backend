<template>
    <Head :title="pageTitle"/>
    <form @submit.prevent="handleSubmit">
        <div v-if="tagImage" class="grid xl:grid-cols-1 gap-3 mb-4">
            <div class="card-auto-height space-y-5">
                <Card :title="contentTitle">
                    <Image
                        :src="tagImage"
                        alt="Small image with fluid-grow:"
                        imageClass="rounded-md w-full "
                    />
                </Card>
            </div>
        </div>
        <div class="grid xl:grid-cols-2 gap-5">
            <Card :title="detailsTitle">
                <TagFormDetails :form="form"/>
            </Card>
            <div class="card-auto-height space-y-5 order-first sm:order-last">
                <Card :title="contentTitle">
                    <TagFormContent :form="form"/>
                </Card>
            </div>
        </div>
        <div class="mt-8 px-32">
            <Button :text="editBtnText" btnClass="btn-primary block-btn mt-4" type="submit"/>
        </div>
    </form>
</template>
<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {useToast} from 'vue-toastification';
import * as yup from 'yup';
import Card from '@/Components/Card/index.vue';
import Image from '@/Components/Image/index.vue';
import Button from '@/Components/Button/index.vue';
import TagFormDetails from '@/Pages/Tag/Components/Create/TagFormDetails.vue';
import TagFormContent from '@/Pages/Tag/Components/Create/TagFormContent.vue';
import {computed} from "vue";
import {router} from '@inertiajs/vue3'
import useImageUrl from "@/Composables/useImageUrl";

const {t} = useI18n();
const toast = useToast();

const props = defineProps({
    tag: {
        type: Object,
        required: true,
    },
    errors: Object,
});


const tagImage = computed(
    () => props.tag.tag.image != null ? useImageUrl(props.tag.tag.image.path).imageUrl : null,
);

const pageTitle = computed(() => t('dashboard.tags_edit'));
const detailsTitle = computed(() => t('dashboard.details'));
const contentTitle = computed(() => t('dashboard.content'));
const editBtnText = computed(() => t('dashboard.edit'));

const dashboardTitle = computed(() => t('validation.required',
    {attribute: t('dashboard.title')}));

const formSchema = yup.object({
    title: yup
        .string()
        .required(dashboardTitle.value),
});

const form = useForm({
    id: props.tag.tag.id,
    title: props.tag.tag.title,
    active: props.tag.tag.active !== 1,
    image: null,
    _method: 'put',
});

const handleSubmit = async () => {
    await formSchema.validate(form, {abortEarly: false});

    if (form.processing) {
        return false;
    }

    console.log(form.data());

    form.post(route('tags.update', props.tag.tag.id), {
        preserveScroll: true,
        // forceFormData: !!form.image,
        onError: (error) => {
            toast.error(t('error.something_happened'), {
                timeout: 2000,
            });
            console.log(error);
            console.log(form.data());
        },
        onSuccess: () => {
            toast.success(t('dashboard.successfully_updated'), {
                timeout: 2000,
            });
        },
    })
}

</script>
