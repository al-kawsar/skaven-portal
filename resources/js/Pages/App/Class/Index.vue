<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
import { router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
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

// defineProps({ classes: Array });
defineOptions({ layout: AppLayout });

const toast = useToast();
const selectedClass = ref([]);
const classes = ref([]);
const clas = ref({
  id: "",
  kode: "",
  nama: "",
  wali_kelas_id: {},
  tahun_ajaran: "",
  tingkat_kelas: "",
  jumlah_siswa: 0,
});
const classDialog = ref({
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

const selectClass = ref([
  { name: "X", id: 1 },
  { name: "XI", id: 2 },
  { name: "XII", id: 3 },
]);

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
  axios
    .get(route("api.classes"))
    .then((res) => {
      classes.value = res.data.data;
    })
    .catch((res) => {
      toast.add({
        severity: "error",
        summary: "Gagal",
        detail: res.response.data.message,
        life: 5000,
      });
    });
};

const openNew = () => {
  clas.value = {};
  classDialog.value.type = "create";
  classDialog.value.show = true;
};

const hideDialog = () => {
  classDialog.value.show = false;
  submitted.value = false;
};

const handleCreateClass = () => {
  isLoading.value = true;
  submitted.value = true;
  axios
    .post(route("app.classes.store"), clas.value)
    .then((res) => {
      toast.add({
        severity: "success",
        summary: "Berhasil",
        detail: res.data.message,
        life: 5000,
      });
      getData();
      hideDialog();
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

const handleUpdateClass = () => {
  isLoading.value = true;
  axios
    .put(route("app.classes.update", clas.value.id), clas.value)
    .then((res) => {
      toast.add({
        severity: "success",
        summary: "Berhasil",
        detail: res.data.message,
        life: 5000,
      });
      getData();
      hideDialog();
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

const editClass = (stud) => {
  clas.value = { ...stud };
  classDialog.value.show = true;
  classDialog.value.type = "edit";
};

const confirmDeleteClass = (stud) => {
  clas.value = stud;
  showDeleteModal.value = true;
};

const confirmDeleteSelected = () => {
  showDeleteSelectedModal.value = true;
};

const deleteClass = () => {
  isLoading.value = true;
  axios
    .delete(route("app.classes.destroy", clas.value.id))
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
          @click="console.log($event)"
        />
        <Button
          label="Hapus"
          icon="pi pi-trash"
          severity="danger"
          class="!text-sm !px-2"
          @click="confirmDeleteSelected"
          :disabled="!selectedClass || !selectedClass.length"
        />
      </template>
      <template #start>
        <h1 class="text-2xl md:text-4xl font-bold">Class Page</h1>
      </template>
    </Toolbar>
    <div class="bg-white shadow-md rounded-sm">
      <div class="px-3 pt-8 pb-4 flex justify-between">
        <div>
          <h2 class="text-lg font-bold">Semua Kelas {{ classes.length }}</h2>
        </div>
        <div>
          <Button
            label="Tambah Data Kelas"
            severity="info"
            @click="openNew"
            class="mr-2 !text-sm !px-2"
          />
        </div>
      </div>
      <DataTable
        v-model:selection="selectedClass"
        :value="classes"
        :rows="10"
        :rowsPerPageOptions="[5, 10, 20, 50, 100]"
        dataKey="id"
        removableSort
        paginator
        tableStyle="min-width: 50rem"
        paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
        currentPageReportTemplate="{first} sampai {last} dari {totalRecords}"
      >
        <template #empty> No clas found. </template>
        <template #loading> Load data kelas. Mohon Menunggu. </template>

        <Column field="kode" header="Kode" sortable style="width: 25%"></Column>
        <Column field="nama" header="Nama" sortable style="width: 25%"></Column>
        <Column
          field="wali_kelas_id.name"
          header="Wali Kelas"
          sortable
          style="width: 25%"
        ></Column>
        <Column
          field="tingkat_kelas"
          header="Tingkat Kelas"
          sortable
          style="width: 25%"
        ></Column>
        <Column
          field="jumlah_siswa"
          header="Jumlah Siswa"
          sortable
          style="width: 25%"
        ></Column>
        <Column
          field="tahun_ajaran"
          header="Tahun Ajaran"
          sortable
          style="width: 25%"
        ></Column>
        <Column :exportable="false" style="min-width: 12rem">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              outlined
              rounded
              class="mr-2"
              @click="editClass(slotProps.data)"
            />
            <Button
              icon="pi pi-trash"
              outlined
              rounded
              severity="danger"
              @click="confirmDeleteClass(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>
  </div>

  <Dialog
    v-model:visible="classDialog.show"
    :style="{ width: '50vw' }"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
    :header="`Class ${classDialog.type}`"
    :modal="true"
  >
    <!-- {{ filterTeachers }}
    {{ filters.searchTeacher }} -->
    <div class="flex flex-col gap-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label for="nama" class="block font-bold mb-3">Nama</label>

          <InputText
            id="nama"
            v-model.trim="clas.nama"
            required="true"
            class="focus:border-blue-600"
            autofocus
            fluid
          />
          <small v-if="submitted && !clas.nama" class="text-red-500"
            >Nama is required.</small
          >
        </div>
        <div>
          <label for="wali_kelas_id" class="block font-bold mb-3">Wali Kelas</label>
          <Select
            v-model="clas.wali_kelas_id"
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
          <small v-if="submitted && !clas.wali_kelas_id" class="text-red-500"
            >wali kelas is required.</small
          >
        </div>
      </div>
      <div class="grid grid-cols-1 gap-3">
        <div>
          <label for="tahun_ajaran" class="block font-bold mb-3">Tahun Ajaran</label>
          <InputText
            id="tahun_ajaran"
            v-model.trim="clas.tahun_ajaran"
            class="focus:border-blue-600"
            autofocus
            required="true"
            fluid
          />
          <small v-if="submitted && !clas.tahun_ajaran" class="text-red-500"
            >tahun_ajaran is required.</small
          >
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label for="tingkat_kelas" class="block font-bold mb-3">Tingkat Kelas</label>
          <Select
            v-model="clas.tingkat_kelas"
            :options="selectClass"
            required="true"
            fluid
            optionLabel="name"
            optionValue="id"
            placeholder="Pilih Kelas"
          />
          <small v-if="submitted && !clas.tingkat_kelas" class="text-red-500"
            >Tingkat Kelas is required.</small
          >
        </div>
        <div>
          <label for="jumlah_siswa" class="block font-bold mb-3">Jumlah Siswa</label>
          <InputText
            id="jumlah_siswa"
            v-model.trim="clas.jumlah_siswa"
            required="true"
            class="focus:border-blue-600"
            autofocus
            fluid
          />
          <small v-if="submitted && !clas.jumlah_siswa" class="text-red-500"
            >Tingkat Kelas is required.</small
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
        v-if="classDialog.type == 'create'"
        label="Tambah"
        severity="info"
        :loading="isLoading"
        @click="handleCreateClass"
        icon="pi pi-check"
      />
      <Button
        v-else-if="classDialog.type == 'edit'"
        label="Simpan"
        severity="info"
        :loading="isLoading"
        @click="handleUpdateClass"
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
        ingin menghapus kelas ({{ clas.nama }})?</span
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
        @click="deleteClass()"
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
      <span>Apakah anda yakin ingin menghapus {{ selectedClass.length }} kelas?</span>
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
        @click="deleteSelectedClasses"
      />
    </template>
  </Dialog>
</template>
