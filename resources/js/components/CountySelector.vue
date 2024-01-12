<template>
  <div class="col-md-6 mt-3 mb-3">
    <label for="county">Megye:</label>
      <select
        v-if="counties.length"
        class="form-select"
        :value="selectedCounty"
        @input="updateSelectedCounty"
        @change="getCities"
        :placeholder="selectedCountyPlaceholder"
        id="county"
      >
        <option value="" disabled selected>{{ selectedCountyPlaceholder }}</option>
        <option v-for="county in counties" :key="county.id" :value="county.id">{{ county.name }}</option>
      </select>
      <div v-else class="loading">Megyék betöltése...</div>

    <div v-if="selectedCounty" class="mt-3">
      <label for="newCity">Új Város</label>
      <div class="input-group">
        <input :value="newCity" @input="updateNewCity($event.target.value)" type="text" id="newCity" class="form-control">
        <div class="input-group-append">
          <button @click="addNewCity" class="customBtnClass btn btn-primary">Felvesz</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    counties: Array,
    selectedCounty: String,
    selectedCountyPlaceholder: String,
    getCities: Function,
    newCity: String,
    addNewCity: Function,
  },
  methods: {
    updateSelectedCounty(event) {
      this.$emit('update:selectedCounty', event.target.value);
    },
    updateNewCity(value) {
      this.$emit('update:newCity', value);
    },
  },
};
</script>