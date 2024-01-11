<template>
    <label for="city">Városok:</label>
      <div v-if="cities.length">
        <ul class="list-group">
          <li v-for="city in cities" :key="city.id" class="list-group-item d-flex align-items-center" @click="handleCityClick(city)">
            <div v-if="selectedCity && city.id !== selectedCity.id">
              {{ city.name }}
            </div>
            <div v-else>
              <input :value="editedCityName" @input="updateCityName($event.target.value)" class="form-control" v-if="selectedCity && city.id === selectedCity.id" />
              <span v-else>
                {{ city.name }}
              </span>
            </div>
            <span v-if="selectedCity && city.id === selectedCity.id" class="ms-auto">
              <button @click="deleteCity()" class="customBtnClass btn btn-danger">Töröl</button>
              <button @click="saveEditedCity(city.id)" class="customBtnClass btn btn-success">Módosít</button>
              <button @click="cancelEditCity(city)" class="customBtnClass btn btn-secondary">Mégse</button>
            </span>
          </li>
        </ul>
      </div>
      <div v-else class="loading">Városok betöltése...</div>
      <div v-if="!cities.length" class="loading">Nem található város</div>
</template>

<script>
export default {
  props: {
    cities: Array,
    selectedCity: Object,
    editedCityName: String,
    handleCityClick: Function,
    deleteCity: Function,
    saveEditedCity: Function,
    cancelEditCity: Function
  },
  methods: {
    updateCityName(value) {
      this.$emit('update:editedCityName', value);
    },
  },
};
</script>
