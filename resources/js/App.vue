<template>
  <div class="container mt-4">
    <div class="form-group">
      <div class="row">
        
        <CountySelector
          :counties="counties"
          :selectedCounty="selectedCounty"
          :selectedCountyPlaceholder="selectedCountyPlaceholder"
          :getCities="getCities"
          :newCity="newCity"
          :addNewCity="addNewCity"
          @update:selectedCounty="updateSelectedCounty"
          @update:newCity="updateNewCity"
        />

        <div v-if="selectedCounty" class="col-md-6 mt-3 mb-3">
          <CityList
            :cities="cities"
            :selectedCity="selectedCity"
            :editedCityName.sync="editedCityName"
            :handleCityClick="handleCityClick"
            :deleteCity="deleteCity"
            :saveEditedCity="saveEditedCity"
            @update:editedCityName="updateCityName"
            />

          <Pagination
            :pagination="pagination"
            :showAllMode="showAllMode"
            :changePage="changePage"
            :displayPageNumbersWithEllipsis="displayPageNumbersWithEllipsis"
            :showAll="showAll"
            :goBackToPagination="goBackToPagination"
          />

        </div>
      </div>
    </div>
  </div>

</template>

<script>

import { toast } from 'vue3-toastify';

import CountySelector from './components/CountySelector.vue';
import CityList from './components/CityList.vue';
import Pagination from './components/Pagination.vue';

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
      pagination: null,
      maxDisplayedPages: 5,
      showAllMode: false,
    };
  },
  mounted() {
    this.getCounties();
  },
  components: {
    Pagination,
    CityList,
    CountySelector,
  },
  computed: {
    displayPageNumbersWithEllipsis: function() {
      const result = [];
      const totalPageCount = this.pagination ? this.pagination.last_page : 0;
      const currentPage = this.pagination ? this.pagination.current_page : 0;
      const visiblePageCount = 5;

      if (totalPageCount <= visiblePageCount) {
        for (let i = 1; i <= totalPageCount; i++) {
          result.push(i);
        }
      } else {
        const halfVisibleCount = Math.floor(visiblePageCount / 2);
        const startPage = currentPage - halfVisibleCount;
        const endPage = currentPage + halfVisibleCount;

        if (startPage <= 0) {
          for (let i = 1; i <= visiblePageCount; i++) {
            result.push(i);
          }
          result.push('...');
        } else if (endPage > totalPageCount) {
          result.push('...');
          for (let i = totalPageCount - visiblePageCount + 1; i <= totalPageCount; i++) {
            result.push(i);
          }
        } else {
          result.push('...');
          for (let i = startPage; i <= endPage; i++) {
            result.push(i);
          }
          result.push('...');
        }
      }

      return result;
    }
},
  methods: {
    showAll() {
      this.getCities(`/api/counties/${encodeURIComponent(this.selectedCounty)}/cities?show_all=true`);
      this.showAllMode = true;
    },
    goBackToPagination() {
      this.showAllMode = false;
      // Fetch paginated data when going back to pagination
      this.getCities();
    },
    loadPreviousPage() {
      if (this.pagination.prev_page_url) {
        this.getCities(this.pagination.prev_page_url);
      }
    },
    loadNextPage() {
      if (this.pagination.next_page_url) {
        this.getCities(this.pagination.next_page_url);
      }
    },
    changePage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.getCities(`/api/counties/${encodeURIComponent(this.selectedCounty)}/cities?page=${page}`);
      }
    },
    getCounties() {
      axios.get('/api/counties')
        .then(response => {
          this.counties = response.data;
        })
        .catch(error => {
          //console.error('Error fetching counties:', error);
          this.showToast('Általános hiba adódott hozzáadás közben!', 'error');
        });
    },
    getCities(url) {
      let apiUrl = '';
      if (typeof url === 'string') {
        apiUrl = url;
      } else {
        apiUrl = `/api/counties/${this.selectedCounty}/cities`;
      }
      axios.get(apiUrl)
        .then(response => {
          let cities = null;

          if (this.showAllMode) {
            // Handle "Show All" mode
            cities = response.data;
            this.pagination = null;
          } else {
            // Handle paginated mode
            cities = response.data.data;
            this.pagination = response.data;
          }

          this.cities = cities.sort((a, b) => a.name.localeCompare(b.name));
        })
        .catch(error => {
          //console.log(error);
          this.showToast('Általános hiba adódott!', 'error');
        });
    },
    handleCityClick(city) {
      this.selectedCity = { id: city.id, name: city.name };
      this.editedCityName = city.name;
    },
    showToast(message, type) {
      toast(message, {
        "type": type,
      })
    },
    updateSelectedCounty(value) {
      this.selectedCounty = value;
    },
    updateNewCity(value) {
      this.newCity = value;
    },
    updateCityName(value) {
      this.editedCityName = value;
    },
    addNewCity() {
      const newCityData = {
        name: this.newCity,
        countyId: this.selectedCounty,
        cityTypeId: 7, // 7: város 
      };
      axios.post('/api/cities', newCityData)
        .then(response => {          
          if (response.data && response.data.id && response.data.name) {
            const newCityOption = { id: response.data.id, name: response.data.name };
  
            // Find the index to insert the new city alphabetically
            const insertIndex = this.cities.findIndex(city => city.name.localeCompare(newCityOption.name) > 0);

            // Insert the new city at the correct position
            if (insertIndex !== -1) {
              this.cities.splice(insertIndex, 0, newCityOption);
            } else {
              // If insertIndex is -1, it means the new city should be added at the end
              this.cities.push(newCityOption);
              // update pagination total count
              this.getCities();
            }

            this.newCity = '';
            this.showToast('Város: ' + newCityData.name + ' sikeresen hozzáadva!', 'success');
          } else {
            this.showToast('Nem megfelelő a válaszformátum. Kérlek próbáld újra!', 'error');
          }
        })
        .catch(error => {
          //console.error;
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

            if (this.editedCityName !== response.data.name) {
              const editedCityIndex = this.cities.findIndex(city => city.id === cityId);
            
              if (editedCityIndex !== -1) {
                this.cities[editedCityIndex] = { id: response.data.id, name: response.data.name };
              }

              this.selectedCity = null;

              this.showToast('Város: ' + this.editedCityName + ' ➡ ' + response.data.name + ' sikeresen módosítva!', 'success');
            } else {
              this.showToast('Városnév nem lett módosítva!', 'info');
            }
          } else {
            this.showToast('Nem megfelelő a válaszformátum. Kérlek próbáld újra!', 'error');
          }
        })
        .catch(error => {
          //console.error('Error updating city:', error);
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
            // update pagination total count
            this.getCities();
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