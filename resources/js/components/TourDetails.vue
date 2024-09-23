<template>
    <div>
      <h1>{{ tourTranslations.name }}</h1>
  
      <p><strong>Description:</strong> {{ tourTranslations.description }}</p>
      <p><strong>Services:</strong> {{ tourTranslations.services }}</p>
      <p><strong>Must Know:</strong> {{ tourTranslations.must_know }}</p>
  
      <router-link :to="{ name: 'tours.index' }">Back to Tours</router-link>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      tour: {
        type: Object,
        required: true,
      },
      locale: {
        type: String,
        required: true,
      },
    },
    computed: {
      tourTranslations() {
        // Assuming each translation is nested inside the locale in tour data
        return this.tour.translations[this.locale] || {};
      },
    },
  };
  </script>
  