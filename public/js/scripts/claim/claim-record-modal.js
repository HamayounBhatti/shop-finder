document.getElementById('submit-record').addEventListener('click', function () {
  var table = $('#claim-table').DataTable();
  var claimId = this.getAttribute('data-claimId');
  var claimName = this.getAttribute('data-claimName');
  document.getElementById('claimId').value = claimId;
  document.getElementById('claimName').value = claimName;
  var myModal = new bootstrap.Modal(document.getElementById('claimModal'));
  myModal.show();
 });
 $('#claimModal').on('hidden.bs.modal', function () {
  window.location.reload()
  // You can reset or perform other tasks when modal closes
});
  