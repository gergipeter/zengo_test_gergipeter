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
                id="county"
              >
                <option value="" disabled selected>{{ selectedCountyPlaceholder }}</option>
                <option v-for="county in counties" :key="county.id" :value="county.id">{{ county.name }}</option>
              </select>
              <div v-else class="loading">Megyék betöltése...</div>
            </transition>

          <div v-if="selectedCounty" class="mt-3">
            <label for="newCity">Új Város</label>
            <div class="input-group">
              <input v-model="newCity" type="text" id="newCity" class="form-control">
              <div class="input-group-append">
                <button @click="addNewCity" class="customBtnClass btn btn-primary">Felvesz</button>
              </div>
            </div>
          </div>
          
        </div>

        <div v-if="selectedCounty" class="form-group col-md-6 mb-3">
        <label for="city">Városok:</label>
          <transition name="fade" mode="out-in">
            <div v-if="cities.length">
              <ul class="list-group">
                <li v-for="city in cities" :key="city.id" class="list-group-item d-flex align-items-center" @click="handleCityClick(city)">
                  <div v-if="selectedCity && city.id !== selectedCity.id">
                    {{ city.name }}
                  </div>
                  <div v-else>
                    <input v-model="editedCityName" class="form-control" v-if="editMode && selectedCity && city.id === selectedCity.id" />
                    <span v-else>
                      {{ city.name }}
                    </span>
                  </div>
                <span v-if="selectedCity && city.id === selectedCity.id" class="ms-auto">
                  <button @click="deleteCity()" class="customBtnClass btn btn-danger">Töröl</button>
                  <button @click="saveEditedCity(city.id)" class="customBtnClass btn btn-success">Módosít</button>
                  <button @click="cancelEditCity" class="customBtnClass btn btn-secondary">Mégse</button>
                </span>
              </li>
              </ul>
            </div>
            <div v-else class="loading">Városok betöltése...</div>
          </transition>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import { toast } from 'vue3-toastify';

export default {
  data() {
    return {
      selectedCounty: '',
      selectedCity: null,
      counties: [],
      cities: [],
      selectedCountyPlaceholder: 'Válasszon',
      selectedCityPlaceholder: 'Válasszon',
      newCity: '',
      editedCityName: '',
      editMode: false,

    };
  },
  mounted() {
    this.getCounties();
  },
  methods: {

    resetCities() {
      this.selectedCity = null;
    },

    getCounties() {
      axios.get('/api/counties')
        .then(response => {
          this.counties = response.data;
        })
        .catch(error => {
          console.error('Error fetching counties:', error);
        });
    },

    getCities() {
      axios.get(`/api/counties/${this.selectedCounty}/cities`)
        .then(response => {
          this.cities = response.data;
        })
        .catch(error => {
          console.error('Error fetching cities:', error);
        });
        this.resetCities();
    },

    handleCityClick(city) {
      this.selectedCity = { id: city.id, name: city.name };
      this.editMode = true;
      this.editedCityName = city.name;
    },

    showToast(message, type) {
      toast(message, type, {
        "type": type,
      })
    },

    addNewCity() {
      const newCityData = {
        name: this.newCity,
        countyId: this.selectedCounty,
        cityTypeId: 7, //7: város 
      };
      axios.post('/api/cities', newCityData)
        .then(response => {          
          console.log(response.data );
          if (response.data && response.data.id && response.data.name) {
            const newCityOption = { id: response.data.id, name: response.data.name };
            this.cities.push(newCityOption);
            this.newCity = '';
            this.showToast('Város: ' + newCityData.name + ' sikeresen hozzáadva!', 'success');
          } else {
            this.showToast('Nem megfelelő a válaszformátum. Kérlek próbáld újra!', 'error');
          }
        })
        .catch(error => {
          console.error;
          this.showToast('Általános hiba adódott hozzáadás közben!', 'error');
        });
    },

    saveEditedCity(cityId) {

      const newCityData = {
        name: this.editedCityName,
      };

      axios.put(`/api/cities/${cityId}`, newCityData)
        .then(response => {

          if (response.data && response.data.id && response.data.name) {
            // Find the index of the edited city in the cities array
            const editedCityIndex = this.cities.findIndex(city => city.id === cityId);

            // Update the city's name in the cities array
            if (editedCityIndex !== -1) {
              this.cities[editedCityIndex] = { id: response.data.id, name: response.data.name };
            }

            this.showToast('Város: ' + newCityData.name + ' sikeresen módosítva!', 'success');
          } else {
            this.showToast('Nem megfelelő a válaszformátum. Kérlek próbáld újra!', 'error');
          }
        })
        .catch(error => {
          console.error('Error updating city:', error);
          this.showToast('Hiba történt a város módosítása közben. Kérlek próbáld újra!', 'error');
        });
},

    deleteCity() {
      if (!this.selectedCity.id) {
        this.showToast('Nem megfelelő a válaszformátum. Kérlek próbáld újra!', 'error');
        return;
      }
      axios.delete(`/api/cities/${this.selectedCity.id}`)
        .then(response => {
          if (response.data.success) {
            this.cities = this.cities.filter(city => city.id !== this.selectedCity.id);
            this.showToast('Város: ' + this.selectedCity.name + ' sikeresen törölve!', 'success');
          } else {
            this.showToast('Nem megfelelő formátum. Kérlek próbáld újra!', 'error');
          }
        })
        .catch(error => {
          //console.log(error);
          this.showToast('Általános hiba adódott törlés közben!', 'error');
        });
    },
  },
};
</script>