<script setup>
import { router } from "@inertiajs/vue3";
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

import InputIcon from "primevue/inputicon";
import IconField from "primevue/iconfield";
import InputText from "primevue/inputtext";
import DatePicker from "primevue/datepicker";
import RadioButton from "primevue/radiobutton";
import Textarea from "primevue/textarea";

defineOptions({ layout: AppLayout });

const toast = useToast();
const selectedStudent = ref([]);
const students = ref([]);
const student = ref({
  name: "",
  nis: "",
  nisn: "",
  agama: "",
  jenis_kelamin: "",
  tempat_lahir: "",
  tanggal_lahir: "",
  alamat: "",
});
const studentDialog = ref({
  show: false,
  type: "create",
});
const submitted = ref(false);
const isLoading = ref(false);
const showDeleteModal = ref(false);
const showDeleteSelectedModal = ref(false);

const filters = ref({
  search: "",
});
const getData = (search = "") => {
  isLoading.value = true;
  axios
    .get(route("api.students"), {
      params: {
        search,
      },
    })
    .then((res) => {
      students.value = res.data.data;
    })
    .catch((error) => {
      toast.add({
        severity: "error",
        summary: "Gagal",
        detail: error.response.data.message,
        life: 5000,
      });
    })
    .finally(() => {
      isLoading.value = false;
    });
};

const openNew = () => {
  student.value = {};
  studentDialog.value.type = "create";
  studentDialog.value.show = true;
};

const hideDialog = () => {
  studentDialog.value.show = false;
  submitted.value = false;
};

const handleCreateStudent = () => {
  isLoading.value = true;
  submitted.value = true;
  axios
    .post(route("app.students.store"), student.value)
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
    .catch((error) => {
      toast.add({
        severity: "error",
        summary: "Gagal",
        detail: error.response.data.message,
      });
    })
    .finally(() => {
      isLoading.value = false;
    });
};

const handleUpdateStudent = () => {
  isLoading.value = true;
  axios
    .put(route("app.students.update", student.value.id), student.value)
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
    .catch((error) => {
      toast.add({
        severity: "error",
        summary: "Gagal",
        detail: error.response.data.message,
        life: 5000,
      });
    })
    .finally(() => {
      isLoading.value = false;
    });
};

const editStudent = (stud) => {
  student.value = { ...stud };
  studentDialog.value.show = true;
  studentDialog.value.type = "edit";
};

const confirmDeleteStudent = (stud) => {
  student.value = stud;
  showDeleteModal.value = true;
};

const confirmDeleteSelected = () => {
  showDeleteSelectedModal.value = true;
};

const deleteStudent = () => {
  isLoading.value = true;
  axios
    .delete(route("app.students.destroy", student.value.id))
    .then((res) => {
      toast.add({
        severity: "success",
        summary: "Berhasil",
        detail: res.data.message,
        life: 5000,
      });
      getData();
    })
    .catch((error) => {
      toast.add({
        severity: "error",
        summary: "Gagal",
        detail: error.response.data.message,
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

const deleteSelectedStudents = () => {
  // Implement delete selected logic
};

const clearFilter = () => {
  // Implement clear filter logic
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
  <div class="card bg-white shadow-lg rounded-s-3xl border">
    <Toolbar class="px-6 pt-8 mb-4 !border-none bg-transparent">
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
          :disabled="!selectedStudent || !selectedStudent.length"
        />
      </template>
      <template #start>
        <h1 class="text-2xl md:text-4xl font-bold">Student Page</h1>
      </template>
    </Toolbar>
    <DataTable
      v-model:selection="selectedStudent"
      :value="students"
      :rows="5"
      :rowsPerPageOptions="[5, 10, 20, 50, 100]"
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
            <h2 class="text-lg font-bold">Semua Siswa {{ students.length }}</h2>
          </div>
          <div class="flex gap-3 items-center">
            <IconField>
              <InputIcon>
                <i :class="isLoading ? 'pi pi-spin pi-spinner' : 'pi pi-search'" />
              </InputIcon>
              <InputText
                v-model="filters.search"
                @input="handleSearch(filters.search)"
                placeholder="Cari Siswa ..."
              />
            </IconField>
            <Button
              label="Tambah Data Siswa"
              severity="info"
              @click="openNew"
              class="mr-2 !text-sm !px-2"
            />
          </div>
        </div>
      </template>

      <Column v-if="isLoading" header="Mengambil data siswa. Mohon Menunggu."></Column>
      <Column
        v-else-if="!isLoading && students.length === 0"
        header="Data siswa Not Found"
      ></Column>
      <div v-else>
        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
        <Column field="id" header="#" sortable style="width: 25%"></Column>
        <Column field="name" header="Nama" sortable style="width: 25%"></Column>
        <Column field="nis" header="Nis" sortable style="width: 25%"></Column>
        <Column field="nisn" header="Nisn" sortable style="width: 25%"></Column>
        <Column field="agama" header="Agama" sortable style="width: 25%"></Column>
        <Column field="jenis_kelamin" header="JK" sortable style="width: 25%"></Column>
        <Column
          field="tanggal_lahir"
          header="Tempat_Tanggal_Lahir"
          sortable
          style="width: 25%"
        ></Column>
        <Column field="alamat" header="Alamat" sortable style="width: 25%"></Column>
        <Column :exportable="false" style="min-width: 12rem">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              outlined
              rounded
              class="mr-2"
              @click="editStudent(slotProps.data)"
            />
            <Button
              icon="pi pi-trash"
              outlined
              rounded
              severity="danger"
              @click="confirmDeleteStudent(slotProps.data)"
            />
          </template>
        </Column>
      </div>
    </DataTable>
  </div>

  <Dialog
    v-model:visible="studentDialog.show"
    :style="{ width: '50vw' }"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
    :header="`Student ${studentDialog.type}`"
    :modal="true"
  >
    <div class="flex flex-col gap-6">
      <!-- <img
          v-if="product.image"
          :src="`https://primefaces.org/cdn/primevue/images/product/${product.image}`"
          :alt="product.image"
          class="block m-auto pb-4"
        /> -->
      <div>
        <label for="name" class="block font-bold mb-3">Nama</label>

        <InputText
          id="name"
          v-model.trim="student.name"
          required="true"
          class="focus:border-blue-600"
          autofocus
          fluid
        />
        <small v-if="submitted && !student.name" class="text-red-500"
          >Name is required.</small
        >
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label for="nis" class="block font-bold mb-3">Nis</label>
          <InputText
            id="nis"
            v-model.trim="student.nis"
            required="true"
            class="focus:border-blue-600"
            autofocus
            fluid
          />
          <small v-if="submitted && !student.nis" class="text-red-500"
            >nis is required.</small
          >
        </div>
        <div>
          <label for="nisn" class="block font-bold mb-3">Nisn</label>
          <InputText
            id="nisn"
            v-model.trim="student.nisn"
            required="true"
            class="focus:border-blue-600"
            autofocus
            fluid
          />
          <small v-if="submitted && !student.nisn" class="text-red-500"
            >nisn is required.</small
          >
        </div>
      </div>

      <div>
        <label for="agama" class="block font-bold mb-3">Agama</label>
        <InputText
          id="agama"
          v-model.trim="student.agama"
          required="true"
          class="focus:border-blue-600"
          autofocus
          fluid
        />
        <small v-if="submitted && !student.agama" class="text-red-500"
          >agama is required.</small
        >
      </div>
      <div>
        <label for="jenis_kelamin" class="block font-bold mb-3">Jenis Kelamin</label>
        <div class="flex flex-wrap gap-4">
          <div class="flex items-center">
            <RadioButton
              v-model="student.jenis_kelamin"
              inputId="jenis_kelamin1"
              name="jenis_kelamin"
              value="L"
            />
            <label for="jenis_kelamin1" class="ml-2">Laki-Laki</label>
          </div>
          <div class="flex items-center">
            <RadioButton
              v-model="student.jenis_kelamin"
              inputId="jenis_kelamin2"
              name="jenis_kelamin"
              value="P"
            />
            <label for="jenis_kelamin2" class="ml-2">Perempuan</label>
          </div>
        </div>

        <small v-if="submitted && !student.jenis_kelamin" class="text-red-500"
          >Jenis Kelamin is required.</small
        >
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label for="tempat_lahir" class="block font-bold mb-3">Tempat Lahir</label>
          <InputText
            id="tempat_lahir"
            v-model.trim="student.tempat_lahir"
            required="true"
            class="focus:border-blue-600"
            autofocus
            fluid
          />
          <small v-if="submitted && !student.tempat_lahir" class="text-red-500"
            >Name is required.</small
          >
        </div>
        <div>
          <label for="tanggal_lahir" class="block font-bold mb-3">Tanggal Lahir</label>
          <DatePicker v-model="student.tanggal_lahir" showIcon fluid />
          <small v-if="submitted && !student.tanggal_lahir" class="text-red-500"
            >Name is required.</small
          >
        </div>
      </div>
      <div>
        <label for="alamat" class="block font-bold mb-3">Alamat</label>
        <Textarea v-model="student.alamat" autoResize fluid rows="5" cols="25" />
        <small v-if="submitted && !student.alamat" class="text-red-500"
          >Alamat is required.</small
        >
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
        v-if="studentDialog.type == 'create'"
        label="Tambah"
        severity="info"
        :loading="isLoading"
        @click="handleCreateStudent"
        icon="pi pi-check"
      />
      <Button
        v-else-if="studentDialog.type == 'edit'"
        label="Simpan"
        severity="info"
        :loading="isLoading"
        @click="handleUpdateStudent"
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
        ingin menghapus siswa ({{ student.name }})?</span
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
        @click="deleteStudent()"
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
      <span>Apakah anda yakin ingin menghapus {{ selectedStudent.length }} siswa?</span>
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
        @click="deleteSelectedStudents"
      />
    </template>
  </Dialog>
</template>
