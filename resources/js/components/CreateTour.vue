<template>
  <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Create a New Tour</h1>

    <!-- Display success or error messages -->
    <div v-if="successMessage" class="bg-green-100 text-green-700 p-2 rounded mb-4">
      {{ successMessage }}
    </div>

    <div v-if="errors.length > 0" class="bg-red-100 text-red-700 p-2 rounded mb-4">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>

    <form @submit.prevent="submitForm" class="space-y-4">
      <!-- Common Fields -->
      <div>
        <label for="tour_duration" class="block text-gray-600">Tour Duration:</label>
        <input
          type="text"
          id="tour_duration"
          v-model="form.tour_duration"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="images" class="block text-gray-600">Images (URL):</label>
        <input
          type="text"
          id="images"
          v-model="form.images"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="location" class="block text-gray-600">Location:</label>
        <input
          type="text"
          id="location"
          v-model="form.location"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="type" class="block text-gray-600">Type:</label>
        <input
          type="text"
          id="type"
          v-model="form.type"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="governorate" class="block text-gray-600">Governorate:</label>
        <input
          type="text"
          id="governorate"
          v-model="form.governorate"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="start_date" class="block text-gray-600">Start Date:</label>
        <input
          type="date"
          id="start_date"
          v-model="form.start_date"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="price" class="block text-gray-600">Price:</label>
        <input
          type="number"
          id="price"
          v-model="form.price"
          step="0.01"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <hr class="my-4" />

      <!-- Arabic Translations -->
      <h2 class="text-xl font-semibold text-gray-700">Arabic Translations</h2>

      <div>
        <label for="name_ar" class="block text-gray-600">Name (Arabic):</label>
        <input
          type="text"
          id="name_ar"
          v-model="form.translations.ar.name"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="description_ar" class="block text-gray-600">Description (Arabic):</label>
        <textarea
          id="description_ar"
          v-model="form.translations.ar.description"
          required
          class="w-full p-2 border rounded"
        ></textarea>
      </div>

      <div>
        <label for="services_ar" class="block text-gray-600">Services (Arabic):</label>
        <input
          type="text"
          id="services_ar"
          v-model="form.translations.ar.services"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="must_know_ar" class="block text-gray-600">Must Know (Arabic):</label>
        <input
          type="text"
          id="must_know_ar"
          v-model="form.translations.ar.must_know"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <hr class="my-4" />

      <!-- English Translations -->
      <h2 class="text-xl font-semibold text-gray-700">English Translations</h2>

      <div>
        <label for="name_en" class="block text-gray-600">Name (English):</label>
        <input
          type="text"
          id="name_en"
          v-model="form.translations.en.name"
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="description_en" class="block text-gray-600">Description (English):</label>
        <textarea
          id="description_en"
          v-model="form.translations.en.description"
          class="w-full p-2 border rounded"
        ></textarea>
      </div>

      <div>
        <label for="services_en" class="block text-gray-600">Services (English):</label>
        <input
          type="text"
          id="services_en"
          v-model="form.translations.en.services"
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label for="must_know_en" class="block text-gray-600">Must Know (English):</label>
        <input
          type="text"
          id="must_know_en"
          v-model="form.translations.en.must_know"
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Create Tour
        </button>
      </div>
    </form>

    <a href="/tours" class="block mt-4 text-blue-500 hover:underline">Back to Tours List</a>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        tour_duration: '',
        images: '',
        location: '',
        type: '',
        governorate: '',
        start_date: '',
        price: '',
        translations: {
          ar: {
            name: '',
            description: '',
            services: '',
            must_know: '',
          },
          en: {
            name: '',
            description: '',
            services: '',
            must_know: '',
          },
        },
      },
      errors: [],
      successMessage: '',
    };
  },
  methods: {
    async submitForm() {
      this.errors = [];
      try {
        const response = await axios.post('/tours/store', this.form);
        this.successMessage = response.data.message;
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = Object.values(error.response.data.errors).flat();
        }
      }
    },
  },
};
</script>

<style scoped>
/* Custom Styles */
</style>
