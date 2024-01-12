<template>
  <span class="labelClass" for="city">Városok:</span>
  <div class="mt-2" v-if="cities.length">
    <ul class="list-group">
      <li
        v-for="(city, index) in cities"
        :key="city.id"
        class="list-group-item d-flex align-items-center"
        @click="handleCityClick(city); setupEditing(city, index);"
      >
        <div v-if="!city.selected" @click="startEditing(index)">
          <a class="city-link" href="#">
            {{ city.name }}
          </a>
        </div>
    
        <div v-else>
          <input
            v-if="city.selected && (selectedCity && city.id === selectedCity.id)"
            :value="editedCityName"
            @input="updateCityName($event.target.value);"
            :id="city.id"
            class="form-control"
          />
        
          <span v-else>
            <a class="city-link" href="#">
              {{ city.name }}
            </a>
          </span>
        </div>
        <span v-show="city.selected" v-if="city.selected && (selectedCity && city.id === selectedCity.id)" class="ms-auto">
          <button @click="deleteCity()" class="customBtnClass btn btn-danger">Töröl</button>
          <button @click="saveEditedCity(city.id)" class="customBtnClass btn btn-success">Módosít</button>
          <button @click="stopEditing(index)" class="customBtnClass btn btn-secondary">Mégse</button>
        </span>
      </li>
    </ul>
  </div>
  <div v-else class="loading">Városok betöltése...</div>
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
  },
  methods: {
    setupEditing(city, index) {
      if (city.selected) {
        this.startEditing(index);
      } else {
        this.stopEditing(index);
      }
    },
    startEditing(index) {
      this.cities[index].selected = true;
    },
    stopEditing(index) {
      this.cities[index].selected = false;
    },
    updateCityName(value) {
      this.$emit('update:editedCityName', value);
    },
  },
};
</script>
