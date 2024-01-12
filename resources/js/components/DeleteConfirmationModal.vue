<template>
  <!-- Bootstrap Modal -->
  <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ modalTitle }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Biztos, hogy törölni szeretné?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
          <button type="button" class="btn btn-danger" @click="confirmDelete">Törlés</button>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
  export default {
    props: {
    confirmDelete: Function,
    cityName: String,
  },
  computed: {
    modalTitle() {
      // Use the cityName prop to dynamically set the modal title
      return `${this.cityName} - Törlés`;
    },
  }
}
  </script>
  