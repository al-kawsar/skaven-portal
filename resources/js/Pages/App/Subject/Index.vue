<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";

import DataTable from "primevue/datatable";
import Button from "primevue/button";
import FileUpload from "primevue/fileupload";
import Toolbar from "primevue/toolbar";
import Column from "primevue/column";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Select from "primevue/select";

// defineProps({ subjects: Array });
defineOptions({ layout: AppLayout });
const page = usePage();
const role = computed(() => page.props.role);

const toast = useToast();
const selectedSubject = ref([]);
const subjects = ref([]);
const subject = ref({
  id: "",
  kode: "",
  nama: "",
  guru_id: {},
  deskripsi: "",
  jenis_pelajaran: "",
});
const subjectsDialog = ref({
  show: false,
  type: "create",
});
const submitted = ref(false);
const filters = ref({
  search: "",
  searchTeacher: "",
});
const isLoading = ref(false);
const showDeleteModal = ref(false);
const showDeleteSelectedModal = ref(false);

const filterTeachers = ref([]);
const filterLoading = ref(false);

const timeoutId = ref(null);

const onFilter = async (event) => {
  filters.value.searchTeacher = event.value.trim();
  if (!filters.value.searchTeacher) {
    filterTeachers.value = [];
    return;
  }
  filterLoading.value = true;
  if (timeoutId.value) {
    clearTimeout(timeoutId.value);
  }
  timeoutId.value = setTimeout(() => {
    getTeachers();
  }, 500);
};

const getTeachers = () => {
  axios
    .get(route("api.teachers"), {
      params: {
        limit: 5,
        search: filters.value.searchTeacher,
        type: "filter",
      },
    })
    .then((res) => {
      filterTeachers.value = res.data.data;
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      filterTeachers.value = [];
    })
    .finally(() => {
      filterLoading.value = false;
      isLoading.value = false;
    });
};

const getData = () => {
  axios.get(route("api.subjects")).then((response) => {
    subjects.value = response.data.data;
  });
};

const openNew = () => {
  subject.value = {
    kode: "",
    nama: "",
    deskripsi: "",
    jenis_pelajaran: "",
  };
  subjectsDialog.value = {
    show: true,
    type: "create",
  };
};
const hideDialog = () => {
  subjectsDialog.value.show = false;
  submitted.value = false;
};
const handleCreateSubject = async () => {
  submitted.value = true;
  if (!subject.value.nama || !subject.value.jenis_pelajaran) return;

  isLoading.value = true;
  try {
    await axios.post(route("app.subjects.store"), subject.value);
    getData();
    toast.add({
      severity: "success",
      summary: "Berhasil",
      detail: "Mata pelajaran berhasil ditambahkan",
      life: 3000,
    });
    hideDialog();
  } catch (error) {
    console.error(error);
    toast.add({
      severity: "error",
      summary: "Gagal",
      detail: res.response.data.message,
      life: 5000,
    });
  } finally {
    isLoading.value = false;
  }
};
const editSubject = (sub) => {
  subject.value = { ...sub };
  subjectsDialog.value = {
    show: true,
    type: "edit",
  };
};
const handleUpdateSubject = async () => {
  submitted.value = true;
  if (!subject.value.kode || !subject.value.nama || !subject.value.jenis_pelajaran)
    return;

  isLoading.value = true;
  try {
    await axios.put(route("app.subjects.update", subject.value.id), subject.value);
    getData();
    toast.add({
      severity: "success",
      summary: "Berhasil",
      detail: "Mata pelajaran berhasil diperbarui",
      life: 3000,
    });
    hideDialog();
  } catch (error) {
    console.error(error);
    toast.add({
      severity: "error",
      summary: "Error",
      detail: error.response.data.message,
      life: 3000,
    });
  } finally {
    isLoading.value = false;
  }
};
const confirmDeleteSubject = (sub) => {
  subject.value = { ...sub };
  showDeleteModal.value = true;
};

const deleteSubject = () => {
  isLoading.value = true;
  axios
    .delete(route("app.subjects.destroy", subject.value.id))
    .then((res) => {
      toast.add({
        severity: "success",
        summary: "Berhasil",
        detail: res.data.message,
        life: 5000,
      });
      getData();
    })
    .catch((res) => {
      toast.add({
        severity: "error",
        summary: "Gagal",
        detail: res.response.data.message,
        life: 5000,
      });
    })
    .finally(() => {
      isLoading.value = false;
      showDeleteModal.value = false;
    });
};

const confirmDeleteSelected = () => {
  showDeleteSelectedModal.value = true;
};
onMounted(() => {
  getData();
});
</script>

<template>
  <div class="card">
    <Toolbar class="px-0 mb-4 !border-none bg-transparent">
      <template #end>
        <FileUpload
          mode="basic"
          accept="image/*"
          :maxFileSize="1000000"
          label="Import"
          chooseLabel="Import"
          class="!text-sm !px-2"
          auto
          v-if="role == 'admin'"
        />
        <Button
          label="Export"
          icon="pi pi-upload"
          severity="help"
          class="mx-2 !text-sm !px-2"
          v-if="role == 'admin'"
          @click="console.log($event)"
        />
        <Button
          label="Hapus"
          icon="pi pi-trash"
          severity="danger"
          class="!text-sm !px-2"
          @click="confirmDeleteSelected"
          v-if="role == 'admin'"
          :disabled="!selectedSubject || !selectedSubject.length"
        />
      </template>
      <template #start>
        <h1 class="text-2xl md:text-4xl font-bold">Subject Page</h1>
      </template>
    </Toolbar>
    <div class="bg-white shadow-md rounded-sm">
      <div class="px-3 pt-8 pb-4 flex justify-between">
        <div>
          <h2 class="text-lg font-bold">Semua Mata Pelajaran {{ subjects.length }}</h2>
        </div>
        <div>
          <Button
            label="Tambah Data Mata Pelajaran"
            severity="info"
            @click="openNew"
            v-if="role == 'admin'"
            class="mr-2 !text-sm !px-2"
          />
        </div>
      </div>
      <DataTable
        v-model:selection="selectedSubject"
        :value="subjects"
        :rows="10"
        :rowsPerPageOptions="[5, 10, 20, 50, 100]"
        dataKey="id"
        removableSort
        paginator
        tableStyle="min-width: 50rem"
        paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
        currentPageReportTemplate="{first} sampai {last} dari {totalRecords}"
      >
        <template #empty> Tidak ada mata pelajaran yang ditemukan. </template>
        <template #loading> Memuat data mata pelajaran. Mohon menunggu. </template>

        <Column field="kode" header="Kode" sortable style="width: 25%"></Column>
        <Column field="nama" header="Nama" sortable style="width: 25%"></Column>
        <Column field="guru_id.name" header="Guru" sortable style="width: 25%"></Column>
        <Column field="deskripsi" header="Deskripsi" sortable style="width: 25%"></Column>
        <Column
          field="jenis_pelajaran"
          header="Jenis Pelajaran"
          sortable
          style="width: 25%"
        ></Column>
        <Column :exportable="false" style="min-width: 12rem" v-if="role == 'admin'">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              outlined
              rounded
              class="mr-2"
              @click="editSubject(slotProps.data)"
            />
            <Button
              icon="pi pi-trash"
              outlined
              rounded
              severity="danger"
              @click="confirmDeleteSubject(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>
  </div>

  <Dialog
    v-model:visible="subjectsDialog.show"
    :style="{ width: '50vw' }"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
    :header="`Subject ${subjectsDialog.type}`"
    :modal="true"
  >
    <div class="flex flex-col gap-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label for="nama" class="block font-bold mb-3">Nama</label>
          <InputText
            id="nama"
            v-model.trim="subject.nama"
            required="true"
            class="focus:border-blue-600"
            autofocus
            fluid
          />
          <small v-if="submitted && !subject.nama" class="text-red-500"
            >Nama is required.</small
          >
        </div>
        <div>
          <label for="guru_id" class="block font-bold mb-3">Guru</label>
          <Select
            v-model="subject.guru_id"
            :options="filterTeachers"
            :placeholder="filterLoading ? 'Loading...' : 'Pilih'"
            :loading="filterLoading"
            filter
            @filter="onFilter"
            optionLabel="name"
            fluid
            required="true"
            class="focus:border-blue-600"
          >
            <template #value="slotProps">
              <div v-if="slotProps.value" class="flex items-center">
                <div>{{ slotProps.value.name }}</div>
              </div>
              <span v-else>
                {{ slotProps.placeholder }}
              </span>
            </template>
            <template #option="slotProps">
              <div class="flex items-center">
                <div>{{ slotProps.option.name }}</div>
              </div>
            </template>
          </Select>
          <small v-if="submitted && !subject.guru_id" class="text-red-500"
            >guru is required.</small
          >
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label for="deskripsi" class="block font-bold mb-3">Deskripsi</label>
          <InputText
            id="deskripsi"
            v-model.trim="subject.deskripsi"
            class="focus:border-blue-600"
            fluid
          />
        </div>
        <div>
          <label for="jenis_pelajaran" class="block font-bold mb-3"
            >Jenis Pelajaran</label
          >
          <InputText
            id="jenis_pelajaran"
            v-model.trim="subject.jenis_pelajaran"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
          <small v-if="submitted && !subject.jenis_pelajaran" class="text-red-500"
            >Jenis Pelajaran is required.</small
          >
        </div>
      </div>
    </div>

    <template #footer>
      <Button
        label="Batal"
        severity="secondary"
        icon="pi pi-times"
        text
        @click="hideDialog"
      />
      <Button
        v-if="subjectsDialog.type == 'create'"
        label="Tambah"
        severity="info"
        :loading="isLoading"
        @click="handleCreateSubject"
        icon="pi pi-check"
      />
      <Button
        v-else-if="subjectsDialog.type == 'edit'"
        label="Simpan"
        severity="info"
        :loading="isLoading"
        @click="handleUpdateSubject"
        icon="pi pi-check"
      />
    </template>
  </Dialog>

  <Dialog
    v-model:visible="showDeleteModal"
    :style="{ width: '450px' }"
    header="Konfirmasi"
    :modal="true"
  >
    <div class="flex items-center gap-4">
      <i class="pi pi-exclamation-triangle text-danger !text-3xl" />
      <span
        >Apakah anda yakin <br />
        ingin menghapus mata pelajaran ({{ subject.nama }})?</span
      >
    </div>
    <template #footer>
      <Button
        label="Tidak"
        severity="info"
        icon="pi pi-times"
        text
        @click="showDeleteModal = false"
      />
      <Button
        label="Ya, Hapus"
        severity="danger"
        :loading="isLoading"
        :disabled="isLoading"
        icon="pi pi-check"
        text
        @click="deleteSubject()"
      />
    </template>
  </Dialog>

  <Dialog
    v-model:visible="showDeleteSelectedModal"
    :style="{ width: '450px' }"
    header="Konfirmasi"
    :modal="true"
  >
    <div class="flex items-center gap-4">
      <i class="pi pi-exclamation-triangle text-danger !text-3xl" />
      <span
        >Apakah anda yakin ingin menghapus {{ selectedSubject.length }} mata
        pelajaran?</span
      >
    </div>
    <template #footer>
      <Button
        label="Tidak"
        severity="info"
        icon="pi pi-times"
        text
        @click="showDeleteSelectedModal = false"
      />
      <Button
        label="Ya, Hapus"
        severity="danger"
        :loading="isLoading"
        :disabled="isLoading"
        icon="pi pi-check"
        text
        @click="deleteSelectedSubjects"
      />
    </template>
  </Dialog>
</template>
