document.addEventListener('DOMContentLoaded', function() {
document.getElementById('status-update-modal').addEventListener('click', function () {
  console.log('ok');
  var shopId = this.getAttribute('data-shopId');
  document.getElementById('shopId').value = shopId;
  var myModal = new bootstrap.Modal(document.getElementById('addShopStatusModal'));
  var openModals = document.querySelectorAll('.modal.show');
  openModals.forEach(function(modal) {
    bootstrap.Modal.getInstance(modal).hide(); // Hide any open modals
  });
  myModal.show();
 });

 $('#addShopStatusModal').on('hidden.bs.modal', function () {
  window.location.reload()
  // You can reset or perform other tasks when modal closes
});
});
  