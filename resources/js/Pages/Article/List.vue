<template>
    <Head :title="pageTitle"/>
    <div>
        <vue-good-table
            :columns="columns"
            :pagination-options="{
        enabled: true,
        perPage: perpage,
      }"
            :rows="props.model.articles.data"
            :select-options="{
        enabled: true,
        selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
        selectioninfoClass: 'custom-class',
        selectionText: t('dashboard.rows_selected'),
        clearSelectionText: t('dashboard.clear'),
        disableSelectinfo: false, // disable the select info-500 panel on top
        selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
      }"
            :sort-options="{
        enabled: true,
      }"
            styleClass=" vgt-table  lesspadding2 centered "
        >
            <template v-slot:table-row="props">
        <span v-if="props.column.field == 'image'" class="flex items-center">
          <span v-if="props.row.image"
                class="w-48 h-48 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
            <img
                :alt="props.row.title"
                :src="useImageUrl(props.row.image.path).imageUrl"
                class="object-cover w-full h-full rounded-full"
            />
          </span>
        </span>


                <span
                    v-if="props.column.field == 'status'"
                    class="text-slate-800 dark:text-slate-400"
                >
          {{ useI18n().t(`dashboard.${props.row.status.name}`) }}
        </span>

                <span
                    v-if="props.column.field == 'tag'"
                    class="text-slate-600 dark:text-slate-400"
                >
          {{ props.row.tag.title ?? useI18n().t('dashboard.not_found') }}
        </span>

                <span v-if="props.column.field == 'allow_comments'" class="block w-full">
          <span
              :class="`${
              props.row.allow_comments === 1
                ? 'text-success-500 bg-success-500'
                : ''
            }
            ${
              props.row.allow_comments === 0
                ? 'text-warning-500 bg-warning-500'
                : ''
            }
             `"
              class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
          >
            {{ props.row.allow_comments === 1 ? t('dashboard.active') : t('dashboard.disabled') }}
          </span>
        </span>

                <span
                    v-if="props.column.field == 'publish_time'"
                    class="text-slate-500 dark:text-slate-400"
                >
          {{ calculateTime(props.row.publish_time) }}
        </span>

                <span
                    v-if="props.column.field == 'created_at'"
                    class="text-slate-500 dark:text-slate-400"
                >
          {{ calculateTime(props.row.created_at) }}
        </span>



                <span v-if="props.column.field == 'action'">
          <div class="flex space-x-3 justify-center rtl:space-x-reverse">
            <Tooltip arrow placement="top" theme="dark">
              <template #button>
                <div class="action-btn" @click="viewModel(props.row.id)">
                  <Icon icon="heroicons:eye"/>
                </div>
              </template>
              <span> {{ t('dashboard.view') }}</span>
            </Tooltip>
            <Tooltip arrow placement="top" theme="dark">
              <template #button>
                <div class="action-btn" @click="editModel(props.row.id)">
                  <Icon icon="heroicons:pencil-square"/>
                </div>
              </template>
              <span> {{ t('dashboard.edit') }}</span>
            </Tooltip>
            <Tooltip arrow placement="top" theme="danger-500">
              <template #button>
                <div class="action-btn" @click="showModal = true;">
                  <Icon icon="heroicons:trash"/>
                </div>
              </template>
              <span> {{ t('dashboard.delete') }}</span>
            </Tooltip>
              <Modal
                  ref="modal6"
                  :active-modal="showModal"
                  :size-class="lang == 'ar' ? 'max-w-xl text-right' : 'max-w-xl text-left'"
                  :title="t('dashboard.delete')"
                  label="danger"
                  labelClass="btn-outline-danger"
                  themeClass="bg-danger-500"
                  @close="showModal = false;"
              >
<!--            <h4 class="font-medium text-lg mb-3 text-slate-900">-->
                  <!--                {{ t('dashboard.delete') }}-->
                  <!--            </h4>-->
            <div class="text-base text-slate-600 dark:text-slate-300">
                {{ t('dashboard.are_you_sure_delete') }}
            </div>
            <template v-slot:footer>
                <Button
                    :text="t('dashboard.agree')"
                    btnClass="btn-danger "
                    @click="deleteModel(props.row.id)"
                />
                <Button
                    :text="t('dashboard.cancel')"
                    btnClass="btn-outline mx-4 "
                    @click="showModal = false;"
                />
            </template>
        </Modal>
          </div>
        </span>
            </template>
            <template #pagination-bottom="props">
                <div class="py-4 px-3 flex justify-center">
                    <Pagination
                        :current="current"
                        :pageChanged="props.pageChanged"
                        :pageRange="pageRange"
                        :per-page="perpage"
                        :perPageChanged="props.perPageChanged"
                        :total="total"
                        @page-changed="changePage($event)"
                    >
                        >
                    </Pagination>
                </div>
            </template>
        </vue-good-table>
    </div>
</template>
<script setup>
import {Head} from "@inertiajs/vue3";
import Icon from "@/Components/Icon/index.vue";
import Tooltip from "@/Components/Tooltip/index.vue";
import Pagination from "@/Components/Pagination/index.vue";
import Modal from "@/Components/Modal/index.vue";
import Button from "@/Components/Button/index.vue";
import {useI18n} from "vue-i18n";
import {computed, ref} from "vue";
import {router} from '@inertiajs/vue3';
import {formatDistance} from 'date-fns';
import {ar, enUS} from 'date-fns/locale';
import useImageUrl from "@/Composables/useImageUrl";

const pageTitle = computed(() => t('dashboard.articles_index'));

const {t, locale} = useI18n();

const showModal = ref(false);

const lang = computed(
    () => (localStorage.getItem('language') ?? 'en'),
);

function calculateTime(time) {
    return formatDistance(new Date(time), new Date(), {addSuffix: true, locale: lang.value === 'ar' ? ar : enUS});
}


const props = defineProps({
    model: {
        type: Object,
        required: true,
    },
})

const total = computed(
    () => props.model.total,
);

const current = computed(
    () => props.model.articles.current_page,
);

function changePage(page) {
    if (page > pageRange.value) return;
    router.get(props.model.articles.path + `?page=${page}`)
}

const perpage = computed(
    () => props.model.articles.per_page,
);

const pageRange = computed(
    () => props.model.articles.last_page,
);

const viewModel = (id) => {
    console.log(id);
}

const editModel = (id) => {
    console.log(id);
    router.get(route('articles.edit', id));
}

const deleteModel = (id) => {
    console.log(id);
    showModal.value = false;
    router.delete(route('articles.destroy', id));
}

const searchTerm = "";

const options = [
    {
        value: "1",
        label: "1",
    },
    {
        value: "3",
        label: "3",
    },
    {
        value: "5",
        label: "5",
    },
];

const columns = [
    {
        label: t('dashboard.id'),
        field: "id",
    },
    {
        label: t('dashboard.cover'),
        field: "image",
    },
    {
        label: t('dashboard.title'),
        field: "title",
    },
    {
        label: t('dashboard.tag'),
        field: "tag",
    },
    {
        label: t('dashboard.status'),
        field: "status",
    },
    {
        label: t('dashboard.allow_comments'),
        field: "allow_comments",
    },
    {
        label: t('dashboard.publish_time'),
        field: "publish_time",
    },
    {
        label: t('dashboard.created_at'),
        field: "created_at",
    },
    {
        label: t('dashboard.action'),
        field: "action",
    },
];

</script>
<style lang="scss" scoped>
.action-btn {
    @apply h-6 w-6 flex flex-col items-center justify-center border border-slate-200 dark:border-slate-700 rounded;
}
</style>
