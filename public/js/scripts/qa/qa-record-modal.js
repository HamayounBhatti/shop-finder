document.getElementById('submit-record').addEventListener('click', function () {
  var claimId = this.getAttribute('data-claimId');
  var claimName = this.getAttribute('data-claimName');
  document.getElementById('claimId').value = claimId;
  document.getElementById('claimName').value = claimName;
  var myModal = new bootstrap.Modal(document.getElementById('submitClaimModal'));
  myModal.show();
  $('#submitClaimModal').on('hidden.bs.modal', function () {
    window.location.reload()
    // You can reset or perform other tasks when modal closes
  });
 });
  