<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';

let categories = ref([]);
let title = ref('');
let description = ref('');
let link = ref('');
let category_id = ref(null);

onMounted(() => {
  axios.get("/api/categories").then((response) => {
    categories.value = response.data;
  });
});

function crearRecurso() {
  axios
    .post("/api/resources", {
      title: title.value,
      description: description.value,
      link: link.value,
      category_id: category_id.value,
    })
    .then((response) => {
      window.location.href = "/";
    })
    .catch((error) => {
      alert(error.message);
    });
}

</script>

<template>
  <div class="container mx-auto p-2 mt-0">
    <form class="max-w-md bg-white p-6 rounded-md  mx-auto">
      <h2 class="text-2xl font-semibold mb-4">Agregar Nuevo Producto</h2>

      <!-- Nombre del Producto -->
      <div class="mb-2">
        <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto</label>
        <input type="text" id="nombre" name="nombre" class="w-full px-3 py-2 border rounded-md"
          placeholder="Ej. Producto XYZ" v-model="title">
      </div>

      <div class="mb-2">
        <label for="categoria" class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
        <select id="categoria" name="categoria" class="w-full px-3 py-2 border rounded-md" v-model="category_id">
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <!-- Descripción del Producto -->
      <div class="mb-2">
        <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="w-full px-3 py-2 border rounded-md"
          placeholder="Ingrese una descripción del producto" v-model="description"></textarea>
      </div>


      <div class="mb-2">
        <label for="precio" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
        <input type="number" id="precio" name="precio" class="w-full px-3 py-2 border rounded-md" placeholder="Ej. 29.99"
          v-model="link">
      </div>




      <!-- Botón de Enviar -->
      <div class="flex justify-end">
        <button @click="crearRecurso()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Agregar Producto</button>
      </div>
    </form>
  </div>
</template>