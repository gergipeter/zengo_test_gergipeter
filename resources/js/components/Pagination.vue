<template>
    <div class="mt-3 mb-5">
      <nav v-if="pagination && !showAllMode">
        <ul class="pagination justify-content-center">
          <!-- ... Previous Page ... -->
          <li :class="{ 'page-item': true, 'disabled': pagination.current_page === 1 }">
            <a @click.prevent="changePage(1)" class="page-link" href="#">
              <i class="fa-solid fa-backward-step"></i>
            </a>
          </li>
          <li :class="{ 'page-item': true, 'disabled': pagination.current_page === 1 }">
            <a @click.prevent="changePage(pagination.current_page - 1)" class="page-link" href="#">
              <i class="fa-solid fa-caret-left"></i>
            </a>
          </li>
  
          <!-- Display dynamic page numbers with ellipsis -->
          <li v-for="pageNumber in displayPageNumbersWithEllipsis" :key="pageNumber" :class="{ 'page-item': true, 'active': pageNumber === pagination.current_page || pageNumber === '...' }">
            <a v-if="pageNumber !== '...'" @click.prevent="changePage(pageNumber)" class="page-link" href="#">
              {{ pageNumber }}
            </a>
            <span v-else class="ellipsis-link">...</span>
          </li>
  
          <!-- ... Next Page ... -->
          <li :class="{ 'page-item': true, 'disabled': pagination.current_page === pagination.last_page }">
            <a @click.prevent="changePage(pagination.current_page + 1)" class="page-link" href="#">
              <i class="fa-solid fa-caret-right"></i>
            </a>
          </li>
          <li :class="{ 'page-item': true, 'disabled': pagination.current_page === pagination.last_page }">
            <a @click.prevent="changePage(pagination.last_page)" class="page-link" href="#">
              <i class="fa-solid fa-forward-step"></i>
            </a>
          </li>
  
          <!-- Show All Button -->
          <li class="page-item">
            <a class="page-link mr-3" href="#" @click="showAll">Összes</a>
          </li>
        </ul>
        <p class="text-center">Összesen {{ pagination.total }} elem található</p>
      </nav>
  
      <!-- Show Back Button -->
      <a href="#" v-if="showAllMode" class="btn btn-light" @click="goBackToPagination">Vissza</a>

    </div>
  </template>
  
  <script>
  export default {
    props: {
      pagination: Object,
      showAllMode: Boolean,
      changePage: Function,
      displayPageNumbersWithEllipsis: Array,
      showAll: Function,
      goBackToPagination: Function
    }
  };
  </script>
  