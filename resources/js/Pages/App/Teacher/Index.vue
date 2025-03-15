<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
import { ref, onMounted, watch } from "vue";
import { useToast } from "primevue/usetoast";
import axios from "axios";

import DataTable from "primevue/datatable";
import Button from "primevue/button";
import FileUpload from "primevue/fileupload";
import Toolbar from "primevue/toolbar";
import Column from "primevue/column";
import Dialog from "primevue/dialog";

import InputText from "primevue/inputtext";
import InputIcon from "primevue/inputicon";
import IconField from "primevue/iconfield";

// defineProps({ teachers: Array });
defineOptions({ layout: AppLayout });

const toast = useToast();
const selectedTeacher = ref([]);
const teachers = ref([]);
const isLoading = ref(false);
const showDeleteModal = ref(false);
const showDeleteSelectedModal = ref(false);
const teacher = ref({
  id: "",
  name: "",
  nip: "",
  tanggal_lahir: "",
  agama: "",
  jenis_kelamin: "",
  jurusan: "",
  alamat: "",
});

const filters = ref({
  search: "",
});

const getData = (search = "") => {
  isLoading.value = true;
  axios
    .get(route("api.teachers"), {
      params: {
        search,
      },
    })
    .then((res) => {
      teachers.value = res.data.data;
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
    });
};

const confirmDeleteTeacher = (stud) => {
  teacher.value = stud;
  showDeleteModal.value = true;
};

const confirmDeleteSelected = () => {
  showDeleteSelectedModal.value = true;
};

const deleteTeacher = () => {
  isLoading.value = true;
  axios
    .delete(route("app.teachers.destroy", teacher.value.id))
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

const timeoutId = ref(null);

const handleSearch = (query) => {
  isLoading.value = true;
  if (timeoutId.value) {
    clearTimeout(timeoutId.value);
  }
  timeoutId.value = setTimeout(() => {
    getData(query);
  }, 500);
};

const selectedTeachers = () => {
  // Implement delete selected logic
};

const exportCSV = () => {
  console.log("export");
  //   dt.value.exportCSV();
};

watch(
  () => filters.value.search,
  (newSearch) => {
    handleSearch(newSearch);
  }
);
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
        />
        <Button
          label="Export"
          icon="pi pi-upload"
          severity="help"
          class="mx-2 !text-sm !px-2"
          @click="exportCSV($event)"
        />
        <Button
          label="Hapus"
          icon="pi pi-trash"
          severity="danger"
          class="!text-sm !px-2"
          @click="confirmDeleteSelected"
          :disabled="!selectedTeacher || !selectedTeacher.length"
        />
      </template>
      <template #start>
        <h1 class="text-2xl md:text-4xl font-bold">Teacher Page</h1>
      </template>
    </Toolbar>
    <div class="bg-white shadow-md rounded-sm">
      <DataTable
        v-model:selection="selectedTeacher"
        :value="teachers"
        :rows="10"
        :rowsPerPageOptions="[10, 20, 50, 100]"
        dataKey="id"
        removableSort
        paginator
        tableStyle="min-width: 50rem"
        paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
        currentPageReportTemplate="{first} sampai {last} dari {totalRecords}"
      >
        <template #header>
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-lg font-bold">Semua Guru {{ teachers.length }}</h2>
            </div>
            <div class="flex gap-3 items-center">
              <IconField>
                <InputIcon>
                  <i :class="['pi', isLoading ? 'pi-spin pi-spinner' : 'pi-search']" />
                </InputIcon>
                <InputText
                  v-model="filters.search"
                  @input="handleSearch(filters.search)"
                  placeholder="Cari Guru ..."
                />
              </IconField>
              <Link :href="route('app.teachers.create')">
                <Button
                  label="Tambah Data Guru"
                  severity="info"
                  class="mr-2 !text-sm !px-2"
                />
              </Link>
            </div>
          </div>
        </template>
        <Column v-if="isLoading" header="Mengambil data guru. Mohon Menunggu."></Column>
        <Column
          v-else-if="!isLoading && teachers.length === 0"
          header="Data Guru Not Found"
        ></Column>
        <div v-else>
          <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
          <Column field="id" header="#" sortable style="width: 25%"></Column>
          <Column field="name" header="Nama" sortable style="width: 25%"></Column>
          <Column field="nip" header="Nip" sortable style="width: 25%"></Column>
          <Column
            field="tanggal_lahir"
            header="Tempat, Tanggal Lahir"
            sortable
            style="width: 25%"
          ></Column>
          <Column field="agama" header="Agama" sortable style="width: 25%"></Column>
          <Column field="jenis_kelamin" header="JK" sortable style="width: 25%"></Column>
          <Column field="alamat" header="alamat" sortable style="width: 25%"></Column>
          <Column :exportable="false" style="min-width: 12rem">
            <template #body="slotProps">
              <Link :href="route('app.teachers.edit', slotProps.data.id)">
                <Button icon="pi pi-pencil" outlined rounded class="mr-2" />
              </Link>
              <Button
                icon="pi pi-trash"
                outlined
                rounded
                severity="danger"
                @click="confirmDeleteTeacher(slotProps.data)"
              />
            </template>
          </Column>
        </div>
      </DataTable>
    </div>
  </div>

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
        ingin menghapus Guru ({{ teacher.name }})?</span
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
        @click="deleteTeacher()"
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
      <span>Apakah anda yakin ingin menghapus {{ selectedTeacher.length }} Guru?</span>
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
        @click="selectedTeachers"
      />
    </template>
  </Dialog>
</template>
