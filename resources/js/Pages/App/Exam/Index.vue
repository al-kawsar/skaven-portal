<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
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
import Calendar from "primevue/calendar";
import Select from "primevue/select";
import DatePicker from "primevue/datepicker";
import { usePage } from "@inertiajs/vue3";

defineOptions({ layout: AppLayout });

const page = usePage();
const role = computed(() => page.props.role);
const user = computed(() => page.props.user);
const toast = useToast();
const selectedExams = ref([]);
const exams = ref([]);
const exam = ref({
  id: "",
  student_id: {},
  subject_id: {},
  nilai: null,
  tanggal_nilai: "",
});
const examsDialog = ref({
  show: false,
  type: "create",
});
const submitted = ref(false);
const filters = ref({
  search: "",
  searchStudent: "",
  searchSubject: "",
});
const isLoading = ref(false);
const filterLoading = ref({
  student: false,
  subject: false,
});
const showDeleteModal = ref(false);
const showDeleteSelectedModal = ref(false);

const timeoutId = ref(null);
const filterStudents = ref([]);
const filterSubjects = ref([]);

const getData = () => {
  if (role.value != "student") {
    axios.get(route("api.exams")).then((response) => {
      exams.value = response.data.data;
    });
  } else {
    axios.get(route("api.exams.id", user.value.id)).then((response) => {
      exams.value = response.data.data;
    });
  }
};

const getStudents = () => {
  axios
    .get(route("api.students"), {
      params: {
        search: filters.value.searchStudent,
        type: "filter",
        limit: 10,
      },
    })
    .then((response) => {
      filterStudents.value = response.data.data;
    })
    .finally(() => {
      filterLoading.value.student = false;
    });
};

const getSubjects = () => {
  axios
    .get(route("api.subjects"), {
      params: {
        search: filters.value.searchSubject,
        type: "filter",
        limit: 10,
      },
    })
    .then((response) => {
      filterSubjects.value = response.data.data;
    })
    .finally(() => {
      filterLoading.value.subject = false;
    });
};

const openNew = () => {
  exam.value = {
    nilai: 0,
    tanggal_nilai: "",
  };
  examsDialog.value = {
    show: true,
    type: "create",
  };
};
const hideDialog = () => {
  examsDialog.value.show = false;
  submitted.value = false;
};
const handleCreateExam = async () => {
  submitted.value = true;
  if (!exam.value.student_id || !exam.value.subject_id || !exam.value.nilai) return;

  isLoading.value = true;
  try {
    await axios.post(route("app.exams.store"), exam.value);
    toast.add({
      severity: "success",
      summary: "Berhasil",
      detail: "Nilai berhasil ditambahkan",
      life: 3000,
    });
    getData();
    hideDialog();
  } catch (error) {
    console.error(error);
    toast.add({
      severity: "error",
      summary: "Gagal",
      detail: error.response.data.message,
      life: 5000,
    });
  } finally {
    isLoading.value = false;
  }
};
const editExam = (ex) => {
  exam.value = { ...ex };
  examsDialog.value = {
    show: true,
    type: "edit",
  };
  console.info(exam.value);
};
const handleUpdateExam = async () => {
  submitted.value = true;

  if (!exam.value.student_id || !exam.value.subject_id || !exam.value.nilai) return;

  isLoading.value = true;
  try {
    await axios.put(route("app.exams.update", exam.value.id), exam.value);
    getData();
    toast.add({
      severity: "success",
      summary: "Berhasil",
      detail: "Nilai berhasil diperbarui",
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
const confirmDeleteExam = (ex) => {
  exam.value = { ...ex };
  showDeleteModal.value = true;
};

const deleteExam = () => {
  isLoading.value = true;
  axios
    .delete(route("app.exams.destroy", exam.value.id))
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

const handleFilterStudent = (event) => {
  filters.value.searchStudent = event.value.trim();
  if (!filters.value.searchStudent) {
    filterStudents.value = [];
    return;
  }
  filterLoading.value.student = true;
  if (timeoutId.value) {
    clearTimeout(timeoutId.value);
  }
  timeoutId.value = setTimeout(() => {
    getStudents();
  }, 500);
};

const handleFilterSubject = (event) => {
  filters.value.searchSubject = event.value.trim();
  if (!filters.value.searchSubject) {
    filterSubjects.value = [];
    return;
  }
  filterLoading.value.subject = true;
  if (timeoutId.value) {
    clearTimeout(timeoutId.value);
  }
  timeoutId.value = setTimeout(() => {
    getSubjects();
  }, 500);
};

onMounted(() => {
  getData();
  getStudents();
  getSubjects();
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
          @click="console.log($event)"
          v-if="role == 'admin'"
        />
        <Button
          label="Hapus"
          icon="pi pi-trash"
          severity="danger"
          class="!text-sm !px-2"
          @click="confirmDeleteSelected"
          :disabled="!selectedExams || !selectedExams.length"
          v-if="role == 'admin'"
        />
      </template>
      <template #start>
        <h1 class="text-2xl md:text-4xl font-bold">Halaman Nilai</h1>
      </template>
    </Toolbar>
    <div class="bg-white shadow-md rounded-sm">
      <div class="px-3 pt-8 pb-4 flex justify-between">
        <div>
          <h2 class="text-lg font-bold">Semua Nilai {{ exams.length }}</h2>
        </div>
        <div>
          <Button
            :label="role == 'admin' ? 'Tambah Data Nilai' : 'Beri Nilai'"
            severity="info"
            @click="openNew"
            class="mr-2 !text-sm !px-2"
            v-if="role != 'student'"
          />
        </div>
      </div>
      <DataTable
        v-model:selection="selectedExams"
        :value="exams"
        :rows="10"
        :rowsPerPageOptions="[5, 10, 20, 50, 100]"
        dataKey="id"
        removableSort
        paginator
        tableStyle="min-width: 50rem"
        paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
        currentPageReportTemplate="{first} sampai {last} dari {totalRecords}"
      >
        <template #empty> Tidak ada nilai yang ditemukan. </template>
        <template #loading> Memuat data nilai. Mohon menunggu. </template>

        <Column
          field="student_id.name"
          header="Siswa"
          sortable
          style="width: 25%"
        ></Column>
        <Column
          field="subject_id.nama"
          header="Mata Pelajaran"
          sortable
          style="width: 25%"
        ></Column>
        <Column field="nilai" header="Nilai" sortable style="width: 25%"></Column>
        <Column
          field="tanggal_nilai"
          header="Tanggal Nilai"
          sortable
          style="width: 25%"
        ></Column>
        <Column :exportable="false" style="min-width: 12rem" v-if="role != 'admin'">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              outlined
              rounded
              class="mr-2"
              @click="editExam(slotProps.data)"
            />
            <Button
              icon="pi pi-trash"
              outlined
              rounded
              severity="danger"
              v-if="role == 'admin'"
              @click="confirmDeleteExam(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>
  </div>

  <Dialog
    v-model:visible="examsDialog.show"
    :style="{ width: '50vw' }"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
    :header="`Nilai ${examsDialog.type}`"
    :modal="true"
  >
    <div class="flex flex-col gap-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label for="student_id" class="block font-bold mb-3">Siswa</label>
          <Select
            v-model="exam.student_id"
            :options="filterStudents"
            :loading="filterLoading.student"
            :placeholder="filterLoading.student ? 'Loading...' : 'Pilih Siswa'"
            filter
            @filter="handleFilterStudent"
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
          <small v-if="submitted && !exam.student_id" class="text-red-500"
            >Siswa is required.</small
          >
        </div>
        <div>
          <label for="subject_id" class="block font-bold mb-3">Mata Pelajaran</label>
          <Select
            v-model="exam.subject_id"
            :options="filterSubjects"
            :loading="filterLoading.subject"
            :placeholder="filterLoading.subject ? 'Loading...' : 'Pilih Mata Pelajaran'"
            filter
            @filter="handleFilterSubject"
            optionLabel="nama"
            fluid
            required="true"
            class="focus:border-blue-600"
          >
            <template #value="slotProps">
              <div v-if="slotProps.value" class="flex items-center">
                <div>{{ slotProps.value.nama }}</div>
              </div>
              <span v-else>
                {{ slotProps.placeholder }}
              </span>
            </template>
            <template #option="slotProps">
              <div class="flex items-center">
                <div>{{ slotProps.option.nama }}</div>
              </div>
            </template>
          </Select>
          <small v-if="submitted && !exam.subject_id" class="text-red-500"
            >Mata Pelajaran is required.</small
          >
        </div>
        <div>
          <label for="nilai" class="block font-bold mb-3">Nilai</label>
          <InputText
            v-model="exam.nilai"
            type="number"
            fluid
            class="focus:border-blue-600"
            required="true"
          />
          <small v-if="submitted && !exam.nilai" class="text-red-500"
            >Nilai is required.</small
          >
        </div>
        <div>
          <label for="tanggal_nilai" class="block font-bold mb-3">Tanggal Nilai</label>
          <Calendar
            v-model="exam.tanggal_nilai"
            fluid
            dateFormat="dd/mm/yy"
            placeholder="Pilih Tanggal Nilai"
            class="focus:border-blue-600"
          />
        </div>
      </div>
    </div>
    <template #footer>
      <Button
        label="Batal"
        severity="secondary"
        icon="pi pi-times"
        outlined
        class="!text-sm !px-2"
        @click="hideDialog"
      />
      <Button
        label="Simpan"
        :loading="isLoading"
        :disabled="isLoading"
        severity="info"
        icon="pi pi-check"
        @click="examsDialog.type === 'create' ? handleCreateExam() : handleUpdateExam()"
        class="!text-sm !px-2"
      />
    </template>
  </Dialog>

  <Dialog
    v-model:visible="showDeleteModal"
    style="width: 30vw"
    :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
    header="Konfirmasi"
    modal
    footerClass="flex justify-end"
  >
    <span>Apakah Anda yakin ingin menghapus data nilai ini?</span>
    <template #footer>
      <Button
        label="Batal"
        icon="pi pi-times"
        severity="secondary"
        outlined
        class="!text-sm !px-2"
        @click="showDeleteModal.value = false"
      />
      <Button
        label="Ya, Hapus"
        icon="pi pi-check"
        class="!text-sm !px-2"
        :loading="isLoading"
        :disabled="isLoading"
        severity="danger"
        @click="deleteExam"
      />
    </template>
  </Dialog>

  <Dialog
    v-model:visible="showDeleteSelectedModal"
    style="width: 30vw"
    :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
    header="Konfirmasi"
    modal
    footerClass="flex justify-end"
  >
    <span>Apakah Anda yakin ingin menghapus data nilai yang terpilih?</span>
    <template #footer>
      <Button
        label="Batal"
        icon="pi pi-times"
        outlined
        class="!text-sm !px-2"
        @click="showDeleteSelectedModal.value = false"
      />
      <Button label="Ya" icon="pi pi-check" class="!text-sm !px-2" severity="danger" />
    </template>
  </Dialog>
</template>
