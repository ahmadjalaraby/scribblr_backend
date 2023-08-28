<template>
    <Head :title="pageTitle"/>
    <form @submit.prevent="handleSubmit">
        <div v-if="userImage" class="grid xl:grid-cols-1 gap-3 mb-4">
            <div class="card-auto-height space-y-5">
                <Card :title="contentTitle">
                    <Image
                        :src="userImage"
                        alt="Small image with fluid-grow:"
                        imageClass="rounded-md w-full "
                    />
                </Card>
            </div>
        </div>

        <div class="grid xl:grid-cols-2 gap-5">
            <Card :title="detailsTitle">
                <UserFormContent :countries="props.user.countries" :form="form"/>
            </Card>
            <div class="space-y-5 order-first sm:order-last">
                <Card :title="contentTitle">
                    <TagFormContent :form="form"/>
                </Card>
            </div>
        </div>
        <div class="mt-8 px-32">
            <Button :text="editBtnText" btnClass="btn-primary block-btn" type="submit"/>
        </div>
        <p>
            {{ props.user.user }}
        </p>
    </form>
</template>
<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {useToast} from 'vue-toastification';
import * as yup from 'yup';
import Card from '@/Components/Card/index.vue';
import Button from '@/Components/Button/index.vue';
import TagFormContent from '@/Pages/Tag/Components/Create/TagFormContent.vue';
import {computed} from "vue";
import UserFormContent from "@/Pages/User/Components/Create/UserFormContent.vue";
import useImageUrl from "@/Composables/useImageUrl";
import Image from "@/Components/Image/index.vue";

const {t} = useI18n();


const props = defineProps({
    user: {
        required: true,
        type: Object,
    },
    errors: Object,
});

const pageTitle = computed(() => t('dashboard.users_edit'));
const detailsTitle = computed(() => t('dashboard.details'));
const contentTitle = computed(() => t('dashboard.content'));
const editBtnText = computed(() => t('dashboard.edit'));

const userImage = computed(
    () => props.user.user.image != null ? useImageUrl(props.user.user.image.path).imageUrl : null,
);

const requiredField = (value) => t('validation.required',
    {attribute: t('dashboard.' + value)});

const form = useForm({
    id: props.user.user.id,
    firstname: props.user.user.firstname,
    lastname: props.user.user.lastname,
    username: props.user.user.username,
    email: props.user.user.email,
    date_of_birth: props.user.user.date_of_birth,
    gender: props.user.user.gender.value,
    country_id: props.user.user.country_id,
    image: null,
    _method: 'put',
});

const formSchema = yup.object({
    firstname: yup
        .string()
        .required(requiredField('firstname')),
    lastname: yup
        .string()
        .required(requiredField('lastname')),
    username: yup
        .string()
        .required(requiredField('username')),
    email: yup
        .string()
        .email()
        .required(requiredField('email')),
    gender: yup
        .string()
        .min(1)
        .max(1)
        .oneOf(['m', 'f', 'o'])
        .required(requiredField('gender')),
    date_of_birth: yup
        .date()
        .required(requiredField('date_of_birth')),
    country_id: yup
        .number()
        .required(requiredField('country')),
});


const handleSubmit = async () => {
    form.clearErrors();
    try {
        await formSchema.validate(form.data(), {abortEarly: false});
        if (form.processing) {
            return false
        }
        form.post(route('users.update', props.user.user.id), {
            preserveScroll: true,
            onError: (error) => {
                toast.error(t('error.something_happened'), {
                    timeout: 2000,
                });
                console.log(error);
            },
            onSuccess: () => {
                toast.success(t('dashboard.successfully_added'), {
                    timeout: 2000,
                });
            },
        })
        ;
    } catch (error) {
        console.log(error)
        if (error.inner) {
            const errors = {};
            error.inner.forEach((e) => {
                errors[e.path] = e.message;
            });
            form.setError(errors);
        }
    }
};

const toast = useToast();
</script>
