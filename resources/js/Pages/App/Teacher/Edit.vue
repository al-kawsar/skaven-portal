<script>
export default {
  layout: AppLayout,
};
</script>
<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
import { ref, watch, computed, onMounted } from "vue";

import InputText from "primevue/inputtext";
import InputGroupAddon from "primevue/inputgroupaddon";
import InputGroup from "primevue/inputgroup";
import DatePicker from "primevue/datepicker";
import RadioButton from "primevue/radiobutton";
import { useToast } from "primevue/usetoast";
import axios from "axios";

import Button from "primevue/button";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const teacher = computed(() => page.props.teacher);

const toast = useToast();
const isLoading = ref(false);

const handleUpdateTeacher = () => {
  isLoading.value = true;
  axios
    .put(route("app.teachers.update", teacher.value.id), teacher.value)
    .then((res) => {
      toast.add({
        severity: "success",
        summary: "Berhasil",
        detail: res.data.message,
        life: 5000,
      });
      router.reload(route("app.teachers.edit", teacher.value.id));
    })
    .catch((error) => {
      console.log(error);
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
</script>
<template>
  <div class="card bg-white p-4 rounded">
    <h1 class="text-3xl font-bold mb-12">Edit Guru</h1>

    <form method="post" @submit.prevent="handleUpdateTeacher">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="nama" class="block font-bold mb-3"
            >Nama <span class="text-red-600">*</span></label
          >
          <InputText
            id="nama"
            v-model.trim="teacher.name"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
        </div>
        <div>
          <label for="nip" class="block font-bold mb-3"
            >Nip <span class="text-red-600">*</span></label
          >
          <InputText
            id="nip"
            v-model.trim="teacher.nip"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="jenis_kelamin" class="block font-bold mb-3">Jenis Kelamin</label>
          <div class="flex flex-wrap gap-4">
            <div class="flex items-center">
              <RadioButton
                v-model="teacher.jenis_kelamin"
                inputId="jenis_kelamin1"
                name="jenis_kelamin"
                value="L"
              />
              <label for="jenis_kelamin1" class="ml-2">Laki-Laki</label>
            </div>
            <div class="flex items-center">
              <RadioButton
                v-model="teacher.jenis_kelamin"
                inputId="jenis_kelamin2"
                name="jenis_kelamin"
                value="P"
              />
              <label for="jenis_kelamin2" class="ml-2">Perempuan</label>
            </div>
          </div>
        </div>
        <div>
          <label for="tempat_lahir" class="block font-bold mb-3"
            >Tempat Lahir <span class="text-red-600">*</span></label
          >
          <InputText
            id="tempat_lahir"
            v-model.trim="teacher.tempat_lahir"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="tanggal_lahir" class="block font-bold mb-3">Tanggal Lahir</label>
          <DatePicker
            v-model="teacher.tanggal_lahir"
            showIcon
            fluid
            class="focus:border-blue-600"
          />
        </div>
        <div>
          <label for="alamat" class="block font-bold mb-3"
            >Alamat <span class="text-red-600">*</span></label
          >
          <InputText
            id="alamat"
            v-model.trim="teacher.alamat"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="agama" class="block font-bold mb-3"
            >Agama <span class="text-red-600">*</span></label
          >
          <InputText
            id="agama"
            v-model.trim="teacher.agama"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
        </div>
        <div>
          <label for="pendidikan_terakhir" class="block font-bold mb-3"
            >Pendidikan Terakhir
          </label>
          <InputText
            id="pendidikan_terakhir"
            v-model.trim="teacher.pendidikan_terakhir"
            class="focus:border-blue-600"
            fluid
          />
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="jurusan" class="block font-bold mb-3"
            >Jurusan <span class="text-red-600">*</span></label
          >
          <InputText
            id="jurusan"
            v-model.trim="teacher.jurusan"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
        </div>
        <div>
          <label for="no_telepon" class="block font-bold mb-3"
            >No Telepon <span class="text-red-600">*</span></label
          >
          <InputGroup>
            <InputGroupAddon>+62</InputGroupAddon>
            <InputText
              v-model.trim="teacher.no_telepon"
              required="true"
              type="number"
              fluid
              id="no_telepon"
              class="focus:border-blue-600"
            />
          </InputGroup>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="tanggal_masuk" class="block font-bold mb-3">Tanggal Masuk</label>
          <DatePicker
            v-model="teacher.tanggal_masuk"
            showIcon
            fluid
            class="focus:border-blue-600"
          />
        </div>
        <div>
          <label for="gaji" class="block font-bold mb-3">Gaji</label>
          <InputText
            id="gaji"
            v-model.trim="teacher.gaji"
            class="focus:border-blue-600"
            fluid
          />
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="status" class="block font-bold mb-3"
            >Status <span class="text-red-600">*</span></label
          >
          <InputText
            id="status"
            v-model.trim="teacher.status"
            required="true"
            class="focus:border-blue-600"
            fluid
          />
        </div>
        <div>
          <label for="tanggal_pensiun" class="block font-bold mb-3"
            >Tanggal Pensiun</label
          >
          <DatePicker
            v-model="teacher.tanggal_pensiun"
            showIcon
            fluid
            class="focus:border-blue-600"
          />
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="no_telepon_darurat" class="block font-bold mb-3"
            >No Telepon Darurat</label
          >
          <InputGroup>
            <InputGroupAddon>+62</InputGroupAddon>
            <InputText
              v-model.trim="teacher.no_telepon_darurat"
              type="number"
              fluid
              id="no_telepon_darurat"
              class="focus:border-blue-600"
            />
          </InputGroup>
        </div>

        <div>
          <label for="alamat_email_darurat" class="block font-bold mb-3"
            >Alamat Email Darurat</label
          >
          <InputText
            id="alamat_email_darurat"
            type="email"
            v-model.trim="teacher.alamat_email_darurat"
            class="focus:border-blue-600"
            fluid
          />
        </div>
      </div>
      <div></div>
      <Button
        class="my-2"
        label="Simpan"
        type="submit"
        severity="info"
        :loading="isLoading"
      />
    </form>
  </div>
</template>
