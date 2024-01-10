<template>
  <div class="container mt-4">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="county">Megye:</label>
            <transition name="fade" mode="out-in">
              <select
                v-if="counties.length"
                class="form-control"
                v-model="selectedCounty"
                @change="getCities"
                :placeholder="selectedCountyPlaceholder"
              >
                <option value="" disabled selected>{{ selectedCountyPlaceholder }}</option>
                <option v-for="county in counties" :key="county.id" :value="county.id">{{ county.name }}</option>
              </select>
              <div v-else class="loading">Megyék betöltése...</div>
            </transition>
          </div>
        </div>
          <div v-if="selectedCounty" class="col-md-6">
            <label for="newCity">Új Város</label>
            <div class="input-group">
              <input v-model="newCity" type="text" id="newCity" class="form-control">
              <div class="input-group-append">
                <button @click="addNewCity" class="btn btn-primary">Felvesz</button>
              </div>
            </div>
          </div>
       
      <div v-if="selectedCounty" class="form-group col-md-6 mb-3">
        <label for="city">Városok:</label>
        <transition name="fade" mode="out-in">
          <div v-if="cities.length">
            <ul class="list-group">
              <li v-for="city in cities" :key="city.id" class="list-group-item" @click="handleCityClick(city.id)">
                {{ city.name }}
                <div v-if="city.id === selectedCity">
                  <router-link :to="{ name: 'deleteCity', params: { cityId: selectedCity } }" class="btn btn-danger">Töröl</router-link>
                  <button @click="editCity" class="btn btn-success">Módosít</button>
                  <button @click="cancelAction" class="btn btn-secondary">Mégse</button>

                </div>
              </li>
            </ul>
          </div>
          <div v-else class="loading">Városok betöltése...</div>
        </transition>
      </div>


     

      </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedCounty: '',
      selectedCity: null, // Track the selected city ID
      counties: [],
      cities: [],
      selectedCountyPlaceholder: 'Válasszon',
      selectedCityPlaceholder: 'Válasszon'
    };
  },
  mounted() {
    // Fetch counties on component mount
    this.getCounties();
  },
  methods: {
    getCounties() {
      // Make an API request to get the counties from Laravel backend
      axios.get('/api/counties')
        .then(response => {
          this.counties = response.data;
        })
        .catch(error => {
          console.error('Error fetching counties:', error);
        });
    },
    getCities() {
      // Make an API request to get the cities based on the selected county
      axios.get(`/api/counties/${this.selectedCounty}/cities`)
        .then(response => {
          this.cities = response.data;
        })
        .catch(error => {
          console.error('Error fetching cities:', error);
        });
    },
    addNewCity() {
      // Mock data for testing
      const response = { data: { id: 4, label: this.newCity } };

      // Assuming the response contains the newly added city
      const newCityOption = { id: response.data.id, label: response.data.label };
      this.options.push(newCityOption);
      this.selectedOption = newCityOption.id;
      this.newCity = ''; // Clear the input field
    },
    handleCityClick(cityId) {
      this.selectedCity = cityId;
    },
    cancelAction() {
      // Placeholder action for viewing details
      alert(`Viewing details for ${this.getSelectedCityLabel()}`);
    },
    editCity() {
      this.isEditingCity = true;
      this.editedCityName = ''; // Initialize with the current city name
    },

    cancelEditCity() {
      this.isEditingCity = false;
    },

    saveEditedCity() {
      // Perform the save operation (update the city name in the database, etc.)
      // For now, let's just log the edited name
      console.log('Edited city name:', this.editedCityName);

      this.isEditingCity = false;
    },
    deleteCity() {
      // Placeholder action for deleting city
      alert(`Deleting ${this.getSelectedCityLabel()}`);
    },
    getSelectedCityLabel() {
      const selectedCity = this.options.find(option => option.id === this.selectedOption);
      return selectedCity ? selectedCity.label : '';
    },
  },
};
</script>

<style scoped>
label {
  font-weight: bold;
  margin-bottom: 10px;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.6s;
}
.fade-enter, .fade-leave-to .fade-leave-active {
  opacity: 0;
}

.loading {
  font-style: italic;
  color: #888;
}

.button-container {
  display: flex;
  justify-content: space-around;
  margin-top: 5px;
}
</style>
